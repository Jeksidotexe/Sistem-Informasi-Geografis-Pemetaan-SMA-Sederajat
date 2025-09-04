<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        // Jika sudah login, langsung redirect ke dashboard tanpa cek role.
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        helper(['form']);
        $data = [
            'title' => 'Login',
        ];
        return view('auth/login2', $data);
    }

    /**
     * Memproses upaya login dari user.
     */
    public function login()
    {
        $rules = [
            'email'    => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid. Harap periksa kembali.'
                ]
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $session  = session();
        $model    = new UserModel();
        $email    = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $model->where('email', $email)->first();

        // Cek jika user ada dan password cocok
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau Password salah.');
        }

        // Buat data session
        $sessionData = [
            'user_id'         => $user['id_users'],
            'user_nama'       => $user['username'],
            'user_email'      => $user['email'],
            'user_foto'       => $user['foto'],
            'user_role'       => $user['role'],
            'user_id_sekolah' => $user['id_sekolah'],
            'isLoggedIn'      => true
        ];
        $session->set($sessionData);

        $session->setFlashdata('success', 'Selamat datang, ' . $user['username'] . '!');

        // Langsung arahkan ke dashboard tanpa perlu if/else
        return redirect()->to('/dashboard');
    }

    /**
     * Menghancurkan session dan logout.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }
}
