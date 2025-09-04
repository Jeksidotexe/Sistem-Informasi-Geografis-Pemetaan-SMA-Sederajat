<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Method ini berjalan SEBELUM controller dieksekusi.
     * Tugasnya adalah memeriksa hak akses pengguna.
     *
     * @param array|null $arguments Berisi daftar peran yang diizinkan, dikirim dari file routes.
     * Contoh: ['admin'] atau ['admin', 'operator']
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Pastikan pengguna sudah login. Jika belum, lempar ke halaman login.
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // 2. Pastikan rute telah mendefinisikan peran apa saja yang diizinkan.
        if (empty($arguments)) {
            // Jika tidak ada peran yang didefinisikan di routes, tolak akses untuk keamanan.
            return redirect()->back()->with('error', 'Akses ditolak: Tidak ada peran yang ditentukan.');
        }

        // 3. Ambil peran pengguna dari session.
        $userRole = session()->get('user_role');

        // 4. Periksa apakah peran pengguna ada di dalam daftar peran yang diizinkan ($arguments).
        if (!in_array($userRole, $arguments)) {
            // Jika peran tidak cocok, kembalikan pengguna ke halaman sebelumnya dengan pesan error.
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Jika semua pemeriksaan lolos, biarkan request melanjutkan ke controller.
    }

    /**
     * Method ini berjalan SETELAH controller selesai dieksekusi.
     * Untuk kasus ini, kita tidak perlu melakukan apa-apa.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi.
    }
}
