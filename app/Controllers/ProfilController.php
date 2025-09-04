<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfilController extends BaseController
{
    public function index()
    {
        $data = [
            'nama'          => 'Zaki',
            'status'       => 'Mahasiswa',
            'deskripsi'     => 'Saya adalah seorang mahasiswa dari Politeknik Negeri Sambas, semester
                4, Jurusan Manajemen Informatika, Program Studi Manajemen Informatika.',
            'email'         => 'zakiptk1@gmail.com',
            'telepon'       => '+62895704919719',
            'alamat'        => 'Sambas, Kalimantan Barat, Indonesia',
            'foto_profil'   => 'profile/profil.png'
        ];
        return view('profil_saya/index', $data);
    }
}
