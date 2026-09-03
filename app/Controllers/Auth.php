<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        $data = [];

        if ($this->request->getMethod() === 'POST') {

            $rules = [

                // USERNAME
                'username' => [
                    'rules' => 'required|min_length[3]|max_length[50]|regex_match[/^[A-Za-z0-9_]+$/]|is_unique[users.username]',
                    'errors' => [
                        'required' => 'Kullanıcı adı zorunludur.',
                        'min_length' => 'Kullanıcı adı en az 3 karakter olmalıdır.',
                        'max_length' => 'Kullanıcı adı en fazla 50 karakter olabilir.',
                        'regex_match' => 'Kullanıcı adı sadece İngilizce harf, rakam ve alt çizgi (_) içerebilir. Türkçe karakter kullanmayınız.',
                        'is_unique' => 'Bu kullanıcı adı zaten kullanılıyor.'
                    ]
                ],

                // EMAIL
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Email adresi zorunludur.',
                        'valid_email' => 'Geçerli bir email adresi giriniz.',
                        'is_unique' => 'Bu email adresiyle zaten bir hesap bulunmaktadır.'
                    ]
                ],

                // PASSWORD
                'password' => [
                    'rules' => 'required|min_length[8]|regex_match[/[A-Z]/]|regex_match[/[a-z]/]|regex_match[/[^a-zA-Z0-9]/]',
                    'errors' => [
                        'required' => 'Şifre zorunludur.',
                        'min_length' => 'Şifre en az 8 karakter olmalıdır.',
                        'regex_match' => 'Şifre en az 8 karakter, 1 büyük harf, 1 küçük harf ve 1 özel karakter içermelidir.'
                    ]
                ],

                // ROLE
                'role' => [
                    'rules' => 'required|in_list[student,teacher]',
                    'errors' => [
                        'required' => 'Lütfen öğrenci veya öğretmen seçiniz.',
                        'in_list' => 'Geçersiz kullanıcı rolü.'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {

                $data['validation'] = $this->validator;

                return view('auth/register', $data);
            }

            $userModel = new UserModel();

            $userData = [
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),

                'password' => password_hash(
                    $this->request->getPost('password'),
                    PASSWORD_DEFAULT
                ),

                'role' => $this->request->getPost('role')
            ];

            $userModel->insert($userData);

            return redirect()
                ->to('/register')
                ->with(
                    'success',
                    'Kaydınız başarıyla oluşturulmuştur.'
                );
        }

        return view('auth/register', $data);
    }


// LOGIN
public function login()
{
    $data = [];

    if ($this->request->getMethod() === 'POST') {

        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email adresi zorunludur.',
                    'valid_email' => 'Geçerli bir email adresi giriniz.'
                ]
            ],

            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Şifre zorunludur.'
                ]
            ],

            'role' => [
                'rules' => 'required|in_list[student,teacher]',
                'errors' => [
                    'required' => 'Lütfen öğrenci veya öğretmen seçiniz.',
                    'in_list' => 'Geçersiz kullanıcı rolü.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;

            return view('auth/login', $data);
        }

        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        $user = $userModel
            ->where('email', $email)
            ->first();

        if (!$user) {
            $data['error'] = 'Email veya şifre hatalı.';

            return view('auth/login', $data);
        }

        if (!password_verify($password, $user['password'])) {
            $data['error'] = 'Email veya şifre hatalı.';

            return view('auth/login', $data);
        }

        if ($user['role'] !== $role) {
            $data['error'] = 'Seçtiğiniz kullanıcı türü bu hesapla eşleşmiyor.';

            return view('auth/login', $data);
        }

        session()->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
            'isLoggedIn' => true
        ]);

        if ($user['role'] === 'student') {
            return redirect()->to('/student/dashboard');
        }

        if ($user['role'] === 'teacher') {
            return redirect()->to('/teacher/dashboard');
        }
    }

    return view('auth/login', $data);
}
// LOGOUT
public function logout()
{
    session()->destroy();

    return redirect()->to('/login');
}
}