<?php

namespace App\Controllers;

use Config\Database;
use App\Models\DesaModel;
use App\Models\SekolahModel;
use App\Models\KecamatanModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $db;
    protected $sekolah;
    protected $kecamatan;
    protected $desa;

    public function __construct()
    {
        $this->sekolah = new SekolahModel();
        $this->kecamatan = new KecamatanModel();
        $this->desa = new DesaModel();
        $this->db = Database::connect();
    }

    public function index()
    {
        $session = session();
        $role = $session->get('user_role');

        $data = [
            'title' => 'Dashboard'
        ];

        if ($role === 'admin') {
            // Jika role adalah admin, muat data spesifik untuk admin (jika ada)
            // $data['total_users'] = ...
            return view('dashboard/admin', $data);
        } elseif ($role === 'operator') {
            // Jika role adalah operator, muat data spesifik untuk operator
            // $data['nama_sekolah'] = ...
            return view('dashboard/operator', $data);
        } else {
            // Jika role tidak dikenali, arahkan ke halaman login
            return redirect()->to('/login');
        }
    }

    /**
     * Menyediakan data agregat untuk card statistik di dashboard.
     * Disesuaikan dengan struktur tabel relasional.
     * @return ResponseInterface
     */
    public function getData(): ResponseInterface
    {
        // Hitung total kecamatan & desa
        $totalKecamatan = $this->db->table('kecamatan')->countAllResults();
        $totalDesa = $this->db->table('desa')->countAllResults();

        // --- Perhitungan Total Sekolah per Jenjang dengan JOIN ---
        // Bergabung dengan tabel jenjang_pendidikan untuk memfilter berdasarkan nama_jenjang
        $totalSMA = $this->db->table('sekolah s')
            ->join('jenjang_pendidikan jp', 's.id_jenjang = jp.id_jenjang')
            ->where('jp.nama_jenjang', 'SMA')->countAllResults();

        $totalSMK = $this->db->table('sekolah s')
            ->join('jenjang_pendidikan jp', 's.id_jenjang = jp.id_jenjang')
            ->where('jp.nama_jenjang', 'SMK')->countAllResults();

        $totalMA = $this->db->table('sekolah s')
            ->join('jenjang_pendidikan jp', 's.id_jenjang = jp.id_jenjang')
            ->where('jp.nama_jenjang', 'MA')->countAllResults();

        $totalSLB = $this->db->table('sekolah s')
            ->join('jenjang_pendidikan jp', 's.id_jenjang = jp.id_jenjang')
            ->where('jp.nama_jenjang', 'SLB')->countAllResults();

        // --- Perhitungan Total Sekolah per Status ---
        // Kolom 'status' ada di tabel sekolah, jadi tidak perlu join
        $totalNegeri = $this->db->table('sekolah')->where('status', 'Negeri')->countAllResults();
        $totalSwasta = $this->db->table('sekolah')->where('status', 'Swasta')->countAllResults();

        $data = [
            'total_kecamatan' => $totalKecamatan,
            'total_desa' => $totalDesa,
            'total_sma' => $totalSMA,
            'total_smk' => $totalSMK,
            'total_ma' => $totalMA,
            'total_slb' => $totalSLB,
            'total_negeri' => $totalNegeri,
            'total_swasta' => $totalSwasta,
        ];

        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }

    /**
     * Menyediakan data untuk bar chart jumlah sekolah per kecamatan.
     * Disesuaikan dengan struktur tabel relasional.
     * @return ResponseInterface
     */
    public function getChartData(): ResponseInterface
    {
        // Query builder untuk mengagregasi data chart
        $builder = $this->db->table('kecamatan k');
        $builder->select('
            k.nama_kecamatan,
            COUNT(CASE WHEN jp.nama_jenjang = "SMA" THEN 1 END) as total_sma,
            COUNT(CASE WHEN jp.nama_jenjang = "SMK" THEN 1 END) as total_smk,
            COUNT(CASE WHEN jp.nama_jenjang = "MA" THEN 1 END) as total_ma,
            COUNT(CASE WHEN jp.nama_jenjang = "SLB" THEN 1 END) as total_slb
        ');
        // LEFT JOIN untuk memastikan kecamatan tanpa sekolah tetap muncul
        $builder->join('sekolah s', 's.id_kecamatan = k.id_kecamatan', 'left');
        $builder->join('jenjang_pendidikan jp', 's.id_jenjang = jp.id_jenjang', 'left');
        $builder->groupBy('k.nama_kecamatan');
        $builder->orderBy('k.nama_kecamatan', 'ASC');

        $chartData = $builder->get()->getResultArray();

        return $this->response->setJSON(['success' => true, 'data' => $chartData]);
    }

    /**
     * Menyediakan data sekolah dalam format JSON untuk digunakan oleh Leaflet.
     * @return ResponseInterface
     */
    public function sekolahJson(): ResponseInterface
    {
        $sekolahModel = new SekolahModel();

        $sekolahData = $sekolahModel
            ->select('nama_sekolah, alamat, latitude, longitude, foto, npsn, akreditasi, status')
            ->where('latitude IS NOT NULL')
            ->where("latitude != ''")
            ->where('longitude IS NOT NULL')
            ->where("longitude != ''")
            ->findAll();

        return $this->response->setJSON($sekolahData);
    }
}
