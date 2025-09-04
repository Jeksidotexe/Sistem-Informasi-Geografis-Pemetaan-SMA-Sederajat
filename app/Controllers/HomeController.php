<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenjangPendidikanModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SekolahModel; // Pastikan Anda sudah memiliki model ini

class HomeController extends BaseController
{
    /**
     * Menampilkan halaman utama dengan peta.
     */
    public function index()
    {
        $data = [
            'title' => 'Peta Sebaran Sekolah'
        ];
        return view('home/index', $data);
    }

    /**
     * Menyediakan data sekolah dalam format JSON untuk digunakan oleh Leaflet.
     *
     * @return ResponseInterface
     */
    public function sekolahJson(): ResponseInterface
    {
        $sekolahModel = new SekolahModel();

        // Ambil parameter filter (sekarang bisa berupa array)
        $jenjangIds = $this->request->getGet('jenjang'); // Nama parameter diubah menjadi 'jenjang'
        $statuses = $this->request->getGet('status');

        $builder = $sekolahModel
            ->select("
                sekolah.nama_sekolah, sekolah.alamat, sekolah.latitude, sekolah.longitude, 
                sekolah.foto, sekolah.npsn, sekolah.akreditasi, sekolah.status,
                sekolah.id_jenjang, kepala_sekolah.nama_kepsek, kecamatan.nama_kecamatan, 
                desa.nama_desa, jenjang_pendidikan.nama_jenjang,
                users.username as nama_operator
            ")
            ->join('jenjang_pendidikan', 'jenjang_pendidikan.id_jenjang = sekolah.id_jenjang', 'left')
            ->join('kecamatan', 'kecamatan.id_kecamatan = sekolah.id_kecamatan', 'left')
            ->join('desa', 'desa.id_desa = sekolah.id_desa', 'left')
            ->join('kepala_sekolah', 'kepala_sekolah.id_sekolah = sekolah.id_sekolah', 'left')
            ->join('users', 'users.id_sekolah = sekolah.id_sekolah AND users.role = \'operator\'', 'left')
            ->where('sekolah.latitude IS NOT NULL')->where("sekolah.latitude != ''")
            ->where('sekolah.longitude IS NOT NULL')->where("sekolah.longitude != ''");

        // Terapkan filter jika ada (menggunakan whereIn untuk array)
        if (!empty($jenjangIds) && is_array($jenjangIds)) {
            $builder->whereIn('sekolah.id_jenjang', $jenjangIds);
        }
        if (!empty($statuses) && is_array($statuses)) {
            $builder->whereIn('sekolah.status', $statuses);
        }

        $sekolahData = $builder->findAll();

        return $this->response->setJSON($sekolahData);
    }

    /**
     * Method baru untuk menyediakan data Jenjang Pendidikan.
     * Ini akan digunakan untuk mengisi dropdown filter di frontend.
     */
    public function jenjangJson(): ResponseInterface
    {
        $jenjangModel = new JenjangPendidikanModel();
        $data = $jenjangModel->select('id_jenjang, nama_jenjang')->findAll();
        return $this->response->setJSON($data);
    }
}
