<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kitaplığım</title>

    <link rel="stylesheet" href="<?= base_url('student.css') ?>">

</head>


<body class="library-page">


    <?= view('layouts/student_sidebar') ?>


    <!-- TEMA DEKORASYONU -->
<div
    class="sakura-container"
    id="sakuraDecoration"
    aria-hidden="true"
></div>

<div
    class="dark-library-decoration"
    id="darkLibraryDecoration"
    aria-hidden="true"
></div>

<div
    class="ocean-library-decoration"
    id="oceanLibraryDecoration"
    aria-hidden="true"
></div>

    <main class="main-content">


        <!-- KÜTÜPHANE BAŞLIK -->

        <section class="library-header">


            <div>

                <p class="library-eyebrow">
                    ÖĞRENCİ KÜTÜPHANESİ
                </p>


                <h1>
                    📚 Kitaplığım
                </h1>


                <p class="library-description">
                    Okuduğun, okuyacağın ve keşfetmek istediğin kitapların.
                </p>

            </div>


            <a
                href="<?= base_url('/student/library/add') ?>"
                class="library-add-button"
            >
                ➕ Kitap Ekle
            </a>


        </section>



        <!-- ARAMA VE FİLTRE -->

        <section class="library-tools">


            <form
                method="get"
                action="<?= base_url('/student/library') ?>"
                class="library-search"
            >

                <input
                    type="text"
                    name="search"
                    placeholder="Kitap adı veya yazar ara..."
                    value="<?= esc($search ?? '') ?>"
                >


                <button type="submit">
                    🔍 Ara
                </button>

            </form>


            <div class="library-filters">


                <a
                    href="<?= base_url('/student/library') ?>"
                    class="<?= empty($filter) ? 'active' : '' ?>"
                >
                    Tümü
                </a>


                <a
                    href="<?= base_url('/student/library?filter=reading') ?>"
                    class="<?= ($filter ?? '') === 'reading' ? 'active' : '' ?>"
                >
                    📖 Okuyorum
                </a>


                <a
                    href="<?= base_url('/student/library?filter=completed') ?>"
                    class="<?= ($filter ?? '') === 'completed' ? 'active' : '' ?>"
                >
                    ✓ Tamamlandı
                </a>


                <a
                    href="<?= base_url('/student/library?filter=favorite') ?>"
                    class="<?= ($filter ?? '') === 'favorite' ? 'active' : '' ?>"
                >
                    ❤️ Favoriler
                </a>


            </div>


        </section>



        <!-- KÜTÜPHANE -->

        <section class="real-library">


            <div class="library-wall">

                <?php if (!empty($books)): ?>
                    <div
                        class="dark-tombstones"
                        id="darkTombstones"
                        aria-hidden="true"
                    ></div>
                <?php endif; ?>

                <?php if (empty($books)): ?>


                    <!-- BOŞ KÜTÜPHANE -->

                    <div class="empty-library">

                        <div class="empty-library-icon">
                            📚
                        </div>

                        <h2>
                            Rafların henüz boş
                        </h2>

                        <p>
                            İlk kitabını ekleyerek kendi kütüphaneni oluşturmaya başla.
                        </p>

                        <a
                            href="<?= base_url('/student/library/add') ?>"
                            class="library-add-button"
                        >
                            ➕ İlk Kitabını Ekle
                        </a>

                    </div>


                <?php else: ?>


                    <?php
                    $bookCount = 0;
                    ?>


                    <!-- RAF -->

                    <div class="library-shelf">


                        <div class="books-row">


                            <?php foreach ($books as $book): ?>


                                <?php
                                $bookColors = [
                                    'purple',
                                    'pink',
                                    'blue',
                                    'burgundy',
                                    'green',
                                    'brown'
                                ];

                                $bookColor =
                                    $bookColors[$bookCount % count($bookColors)];

                                $bookCount++;
                                ?>


                                <!-- KİTAP -->

                                <button
                                    type="button"
                                    class="library-book <?= $bookColor ?>"
                                    onclick="openBookDetails(this)"
                                    data-id="<?= esc($book['id'], 'attr') ?>"
                                    data-title="<?= esc($book['title'], 'attr') ?>"
                                    data-author="<?= esc($book['author'], 'attr') ?>"
                                    data-current="<?= esc($book['current_page'], 'attr') ?>"
                                    data-total="<?= esc($book['total_pages'], 'attr') ?>"
                                    data-status="<?= esc($book['status'], 'attr') ?>"
                                    data-favorite="<?= esc($book['is_favorite'] ?? 0, 'attr') ?>"
                                >


                                    <span class="book-spine-decoration">
                                        ✦
                                    </span>


                                    <span class="book-title">
                                        <?= esc($book['title']) ?>
                                    </span>


                                    <span class="book-spine-line"></span>


                                    <span class="book-author">
                                        <?= esc($book['author']) ?>
                                    </span>


                                </button>


                            <?php endforeach; ?>


                        </div>


                        <div class="shelf-board"></div>


                    </div>


                <?php endif; ?>


            </div>


        </section>


    </main>



    <!-- KİTAP DETAY PENCERESİ -->

    <!-- KİTAP DETAY VE GÜNCELLEME PENCERESİ -->

<div
    class="book-modal"
    id="bookModal"
    onclick="closeBookDetails(event)"
>

    <div
        class="book-modal-content"
        onclick="event.stopPropagation()"
    >

        <button
            type="button"
            class="book-modal-close"
            onclick="closeBookDetails()"
        >
            ×
        </button>


        <div class="book-modal-icon">
            📖
        </div>


        <p class="book-modal-label">
            KİTAP DETAYI
        </p>


        <h2 id="modalTitle">
            Kitap
        </h2>


        <p id="modalAuthor">
            Yazar
        </p>


        <form
            id="bookUpdateForm"
            class="book-update-form"
        >

            <input
                type="hidden"
                id="modalBookId"
                name="student_book_id"
            >


            <label>
                📄 Şu an kaçıncı sayfadasın?
            </label>


            <div class="page-input">

                <input
                    type="number"
                    id="modalCurrentPage"
                    name="current_page"
                    min="0"
                    required
                >

                <span>
                    /
                    <span id="modalTotalPages">
                        0
                    </span>
                    sayfa
                </span>

            </div>


            <label>
                📚 Durum
            </label>


            <select
                id="modalStatus"
                name="status"
            >

                <option value="reading">
                    📖 Okuyorum
                </option>

                <option value="completed">
                    ✓ Okudum
                </option>

            </select>


            <label class="favorite-option">

                <input
                    type="checkbox"
                    id="modalFavorite"
                    name="is_favorite"
                    value="1"
                >

                <span>
                    ❤️ Favorim
                </span>

            </label>


            <button
                type="submit"
                class="book-save-button"
            >
                💾 Değişiklikleri Kaydet
            </button>


            <p
                id="bookUpdateMessage"
                class="book-update-message"
            ></p>


        </form>

    </div>

</div>



    <script>


    function openBookDetails(book) {

    document.getElementById('modalBookId').value =
        book.dataset.id;

    document.getElementById('modalTitle').textContent =
        book.dataset.title;

    document.getElementById('modalAuthor').textContent =
        'Yazar: ' + book.dataset.author;

    document.getElementById('modalCurrentPage').value =
        book.dataset.current;

    document.getElementById('modalTotalPages').textContent =
        book.dataset.total;

    document.getElementById('modalStatus').value =
        book.dataset.status;

    document.getElementById('modalFavorite').checked =
        book.dataset.favorite === '1';

    document.getElementById('bookUpdateMessage').textContent =
        '';

    document
        .getElementById('bookModal')
        .classList.add('show');
}


function closeBookDetails(event) {

    if (
        event &&
        event.target !== event.currentTarget
    ) {
        return;
    }

    document
        .getElementById('bookModal')
        .classList.remove('show');
}


document
    .getElementById('bookUpdateForm')
    .addEventListener('submit', function (event) {

        event.preventDefault();

        const form =
            document.getElementById('bookUpdateForm');

        const formData =
            new FormData(form);

        fetch(
            '<?= base_url('/student/library/update') ?>',
            {
                method: 'POST',
                body: formData
            }
        )

        .then(response => response.json())

        .then(data => {

            const message =
                document.getElementById(
                    'bookUpdateMessage'
                );

            if (data.success) {

                message.textContent =
                    '✓ ' + data.message;

                message.classList.add('success');

                setTimeout(function () {

                    location.reload();

                }, 700);

            } else {

                message.textContent =
                    data.message || 'Bir hata oluştu.';

                message.classList.remove('success');

            }

        })

        .catch(error => {

            console.error('Hata:', error);

            document
                .getElementById('bookUpdateMessage')
                .textContent =
                'Bir bağlantı hatası oluştu.';

        });

    });


document.addEventListener(
    'keydown',
    function (event) {

        if (event.key === 'Escape') {

            closeBookDetails();

        }

    }
);


    function closeBookDetails(event) {


        if (
            event &&
            event.target !== event.currentTarget
        ) {

            return;

        }


        document
            .getElementById('bookModal')
            .classList.remove('show');

    }



    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                closeBookDetails();

            }

        }
    );


    </script>



<script>

(function () {

    const sakuraDecoration =
        document.getElementById('sakuraDecoration');

    const darkDecoration =
        document.getElementById('darkLibraryDecoration');

    const oceanDecoration =
        document.getElementById('oceanLibraryDecoration');

    const tombstones =
        document.getElementById('darkTombstones');


    function updateLibraryTheme(theme) {

        /* ========================================
           🌸 SAKURA
        ======================================== */

        if (theme === 'sakura') {

            if (sakuraDecoration) {
                sakuraDecoration.innerHTML = `
                    <span>🌸</span>
                    <span>🌸</span>
                    <span>🌸</span>
                    <span>🌸</span>
                    <span>🌸</span>
                    <span>🌸</span>
                    <span>🌸</span>
                    <span>🌸</span>
                `;

                sakuraDecoration.style.display = 'block';
            }

            if (darkDecoration) {
                darkDecoration.innerHTML = '';
                darkDecoration.style.display = 'none';
            }

            if (tombstones) {
                tombstones.innerHTML = '';
            }

            if (oceanDecoration) {
                oceanDecoration.innerHTML = '';
                oceanDecoration.style.display = 'none';
            }
        }


        /* ========================================
           🪦 DARK
        ======================================== */

        else if (theme === 'dark') {

            if (sakuraDecoration) {
                sakuraDecoration.innerHTML = '';
                sakuraDecoration.style.display = 'none';
            }

            if (darkDecoration) {
                darkDecoration.innerHTML = `
                    <span class="dark-bat bat-1">🦇</span>
                    <span class="dark-bat bat-2">🦇</span>
                    <span class="dark-bat bat-3">🦇</span>
                    <span class="dark-bat bat-4">🦇</span>
                `;

                darkDecoration.style.display = 'block';
            }

            if (tombstones) {
                tombstones.innerHTML = `
                    <div class="dark-tombstone tombstone-1">
                        <span>RIP</span>
                    </div>

                    <div class="dark-tombstone tombstone-2">
                        <span>RIP</span>
                    </div>

                    <div class="dark-tombstone tombstone-3">
                        <span>RIP</span>
                    </div>
                `;
            }

            if (oceanDecoration) {
                oceanDecoration.innerHTML = '';
                oceanDecoration.style.display = 'none';
            }
        }


        /* ========================================
           🌊 OCEAN
        ======================================== */

        else if (theme === 'ocean') {

            if (sakuraDecoration) {
                sakuraDecoration.innerHTML = '';
                sakuraDecoration.style.display = 'none';
            }

            if (darkDecoration) {
                darkDecoration.innerHTML = '';
                darkDecoration.style.display = 'none';
            }

            if (tombstones) {
                tombstones.innerHTML = '';
            }

            if (oceanDecoration) {
                oceanDecoration.innerHTML = `
                    <span class="ocean-wave ocean-wave-1"></span>
                    <span class="ocean-wave ocean-wave-2"></span>
                    <span class="ocean-wave ocean-wave-3"></span>

                    <span class="ocean-bubble bubble-1"></span>
                    <span class="ocean-bubble bubble-2"></span>
                    <span class="ocean-bubble bubble-3"></span>
                    <span class="ocean-bubble bubble-4"></span>
                    <span class="ocean-bubble bubble-5"></span>
                    <span class="ocean-bubble bubble-6"></span>
                `;

                oceanDecoration.style.display = 'block';
            }
        }

        /* updateLibraryTheme fonksiyonunu kapat */
        }


    /* Sidebar'dan tema değişince */
    window.addEventListener('themeChanged', function (event) {

        updateLibraryTheme(event.detail.theme);

    });


    /* Sayfa ilk açıldığında kayıtlı temayı al */
    const currentTheme =
        localStorage.getItem('studentTheme') ||
        document.body.getAttribute('data-theme') ||
        'sakura';


    updateLibraryTheme(currentTheme);

})();

</script>

</body>

</html>