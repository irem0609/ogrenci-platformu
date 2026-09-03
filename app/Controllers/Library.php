<?php

namespace App\Controllers;

use App\Models\StudentBookModel;
use App\Models\BookModel;

class Library extends BaseController
{
    /**
     * Öğrencinin kendi kitaplığını gösterir.
     * Arama ve filtre işlemleri burada yapılır.
     */
    public function index()
    {
        $studentBookModel = new StudentBookModel();

        $studentId = session()->get('user_id');

        // Arama
        $search = trim(
            $this->request->getGet('search')
        );

        // Filtre
        $filter = $this->request->getGet('filter');

        $books = $studentBookModel
            ->select('
                student_books.*,
                books.title,
                books.author,
                books.total_pages,
                books.cover
            ')
            ->join(
                'books',
                'books.id = student_books.book_id'
            )
            ->where(
                'student_books.student_id',
                $studentId
            );

        // Kitap adı veya yazar ile arama
        if ($search !== '') {

            $books->groupStart()
                ->like('books.title', $search)
                ->orLike('books.author', $search)
                ->groupEnd();
        }

        // Filtre
        if ($filter === 'reading') {

            $books->where(
                'student_books.status',
                'reading'
            );

        } elseif ($filter === 'completed') {

            $books->where(
                'student_books.status',
                'completed'
            );

        } elseif ($filter === 'favorite') {

            $books->where(
                'student_books.is_favorite',
                1
            );
        }

        $books = $books->findAll();

        return view('student/library', [
            'books' => $books,
            'search' => $search,
            'filter' => $filter
        ]);
    }


    /**
     * Kitap ekleme sayfasını gösterir.
     *
     * GET  → formu gösterir.
     * POST → kitabı oluşturur ve öğrencinin
     *        kitaplığına ekler.
     */
    public function add()
    {
        $studentId = session()->get('user_id');

        // Oturum kontrolü
        if (!$studentId) {

            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Oturum bulunamadı.'
                );
        }


        /*
         * FORM GÖNDERİLDİYSE
         */
        if (
            strtolower(
                $this->request->getMethod()
            ) === 'post'
        ) {

            $title = trim(
                $this->request->getPost('title')
            );

            $author = trim(
                $this->request->getPost('author')
            );

            $totalPages =
                $this->request->getPost('total_pages');


            /*
             * Form kontrolü
             */
            if (
                $title === '' ||
                $author === '' ||
                !is_numeric($totalPages) ||
                (int) $totalPages < 1
            ) {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Kitap bilgilerini doğru giriniz.'
                    );
            }


            $bookModel =
                new BookModel();

            $studentBookModel =
                new StudentBookModel();


            /*
             * Kitap sistemde daha önce
             * oluşturulmuş mu?
             */
            $existingBook = $bookModel
                ->where(
                    'title',
                    $title
                )
                ->where(
                    'author',
                    $author
                )
                ->first();


            /*
             * Kitap zaten sistemde varsa
             * yeni books kaydı oluşturma.
             */
            if ($existingBook) {

                $bookId =
                    $existingBook['id'];

            } else {

                /*
                 * Kitap sistemde yoksa
                 * books tablosuna ekle.
                 */
                $bookId =
                    $bookModel->insert([
                        'title' => $title,
                        'author' => $author,
                        'total_pages' =>
                            (int) $totalPages
                    ], true);


                if (!$bookId) {

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'Kitap oluşturulamadı.'
                        );
                }
            }


            /*
             * Bu kitap öğrencinin
             * kitaplığında zaten var mı?
             */
            $existingStudentBook =
                $studentBookModel
                    ->where(
                        'student_id',
                        $studentId
                    )
                    ->where(
                        'book_id',
                        $bookId
                    )
                    ->first();


            if ($existingStudentBook) {

                return redirect()
                    ->to('/student/library')
                    ->with(
                        'error',
                        'Bu kitap zaten kitaplığında.'
                    );
            }


            /*
             * Öğrenci ile kitabı ilişkilendir.
             */
            $saved =
                $studentBookModel->insert([
                    'student_id' => $studentId,
                    'book_id' => $bookId
                ]);


            if (!$saved) {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Kitap kitaplığına eklenemedi.'
                    );
            }


            /*
             * Başarılı → Kitaplığıma dön.
             */
            return redirect()
                ->to('/student/library')
                ->with(
                    'success',
                    'Kitap başarıyla kitaplığına eklendi.'
                );
        }


        /*
         * GET isteği:
         * Direkt kitap ekleme formunu göster.
         */
        return view(
            'student/library_add'
        );
    }
}