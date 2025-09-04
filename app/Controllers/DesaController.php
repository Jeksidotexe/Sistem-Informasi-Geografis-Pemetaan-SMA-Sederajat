<?php

namespace App\Controllers;

use App\Models\DesaModel;
use App\Models\SekolahModel;
use App\Models\KecamatanModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DesaController extends BaseController
{
    protected $desa;
    protected $kecamatan;
    protected $db;

    public function __construct()
    {
        $this->desa = new DesaModel();
        $this->kecamatan = new KecamatanModel(); // Inisialisasi
        $this->db = \Config\Database::connect(); // Inisialisasi koneksi DB
    }

    public function index()
    {
        $data = [
            'title' => 'Data Desa'
        ];
        return view('desa/index', $data);
    }

    public function data(): ResponseInterface
    {
        $request = service('request');
        $draw    = intval($request->getVar('draw'));
        $start   = intval($request->getVar('start'));
        $length  = intval($request->getVar('length'));
        $search  = $request->getVar('search')['value'] ?? '';

        // Gunakan Query Builder untuk JOIN
        $builder = $this->db->table('desa');
        $builder->select('desa.id_desa, desa.nama_desa, kecamatan.nama_kecamatan');
        $builder->join('kecamatan', 'kecamatan.id_kecamatan = desa.id_kecamatan');

        // Hitung total data tanpa filter
        $totalData = $builder->countAllResults(false);

        // Tambahkan filter pencarian
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('desa.nama_desa', $search);
            $builder->orLike('kecamatan.nama_kecamatan', $search);
            $builder->groupEnd();
        }

        // Hitung total data dengan filter
        $totalFiltered = $builder->countAllResults(false);

        // Ambil data untuk halaman ini
        $builder->limit($length, $start);
        $builder->orderBy('desa.id_desa', 'DESC');
        $list = $builder->get()->getResultArray();

        $rows = [];
        $no = $start + 1;
        foreach ($list as $row) {
            $rows[] = [
                'DT_RowIndex'      => $no++,
                'nama_kecamatan'   => esc($row['nama_kecamatan']), // Data dari join
                'nama_desa'        => esc($row['nama_desa']),
                'aksi'             => '
                    <div class="btn-group">
                        <button onclick="editForm(`' . $row['id_desa'] . '`)" class="btn btn-sm btn-outline-warning"><i class="fe fe-edit"></i></button>
                        <button style="margin-left:2pt" onclick="deleteData(`' . site_url('desa/destroy/' . $row['id_desa']) . '`)" class="btn btn-sm btn-outline-danger"><i class="fe fe-trash-2"></i></button>
                    </div>'
            ];
        }

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data'            => $rows,
        ]);
    }

    public function store($id_desa = null): ResponseInterface
    {
        $rules = [
            'id_kecamatan' => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih kecamatan!']],
            'nama_desa'    => [
                'rules' => "required",
                'errors' => [
                    'required'  => 'Harap isi nama desa!'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors'  => $this->validator->getErrors()]);
        }

        $data = [
            'id_kecamatan' => $this->request->getPost('id_kecamatan'),
            'nama_desa'    => $this->request->getPost('nama_desa')
        ];

        if ($this->desa->save($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil ditambahkan.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan data.']);
    }

    public function show($id_desa = null): ResponseInterface
    {
        // Lakukan JOIN untuk mendapatkan nama kecamatan juga
        $builder = $this->db->table('desa');
        $builder->select('desa.*, kecamatan.nama_kecamatan');
        $builder->join('kecamatan', 'kecamatan.id_kecamatan = desa.id_kecamatan');
        $builder->where('desa.id_desa', $id_desa);
        $data = $builder->get()->getRowArray();


        if ($data) {
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
    }

    public function update($id_desa = null): ResponseInterface
    {
        $rules = [
            'id_kecamatan' => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih kecamatan!']],
            'nama_desa'    => [
                'rules' => "required|is_unique[desa.nama_desa,id_desa,{$id_desa},id_kecamatan,{id_kecamatan}]",
                'errors' => [
                    'required'  => 'Nama desa harus diisi.',
                    'is_unique' => 'Nama desa ini sudah terdaftar di kecamatan yang sama.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors'  => $this->validator->getErrors()]);
        }

        $data = [
            'id_kecamatan' => $this->request->getVar('id_kecamatan'),
            'nama_desa'    => $this->request->getVar('nama_desa')
        ];

        if ($this->desa->update($id_desa, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui data desa.']);
    }

    public function destroy($id_desa = null): ResponseInterface
    {
        // 1. Inisialisasi model sekolah untuk pengecekan
        $sekolahModel = new SekolahModel();

        // 2. Cek apakah desa ini masih digunakan di tabel sekolah
        $isUsed = $sekolahModel->where('id_desa', $id_desa)->first();

        // 3. Jika data masih digunakan, kirim pesan error yang jelas
        if ($isUsed) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak dapat dihapus, karena masih digunakan di data Sekolah.'
            ]);
        }

        // 4. Jika tidak digunakan, baru lakukan penghapusan permanen
        if ($this->desa->delete($id_desa, true)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil dihapus permanen.'
            ]);
        }

        // 5. Jika gagal menghapus karena alasan lain
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus data.'
        ]);
    }

    public function getSelect2Data()
    {
        $request = service('request');
        $searchTerm = $request->getVar('term') ?? '';
        $id_kecamatan = $request->getVar('id_kecamatan'); // Ambil id_kecamatan dari request

        $desaModel = new DesaModel();

        // Mulai membangun query
        $builder = $desaModel->select('id_desa, nama_desa');

        // Jika ada id_kecamatan yang dikirim, filter berdasarkan itu
        if (!empty($id_kecamatan)) {
            $builder->where('id_kecamatan', $id_kecamatan);
        } else {
            // Jika tidak ada kecamatan dipilih, kembalikan array kosong
            // agar dropdown desa tidak menampilkan apa-apa.
            return $this->response->setJSON([]);
        }


        // Jika ada kata kunci pencarian dari pengguna
        if (!empty($searchTerm)) {
            $builder->like('nama_desa', $searchTerm);
        }

        $data = $builder->findAll(10); // Batasi hasil untuk performa

        $response = [];
        foreach ($data as $desa) {
            $response[] = [
                'id'   => $desa['id_desa'],
                'text' => esc($desa['nama_desa'])
            ];
        }

        return $this->response->setJSON($response);
    }
}
