<?php

namespace App\Controllers;

use App\Models\DesaModel;
use App\Models\SekolahModel;
use App\Models\KecamatanModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KecamatanController extends BaseController
{

    protected $kecamatan;

    public function __construct()
    {
        $this->kecamatan = new KecamatanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kecamatan'
        ];
        return view('kecamatan/index', $data);
    }

    public function data(): ResponseInterface
    {
        $request = service('request');
        $draw    = intval($request->getVar('draw'));
        $start   = intval($request->getVar('start'));
        $length  = intval($request->getVar('length'));
        $search  = $request->getVar('search')['value'] ?? '';

        $kecamatanModel = $this->kecamatan;

        $totalData = $kecamatanModel->countAll();

        if (!empty($search)) {
            $kecamatanModel = $kecamatanModel->like('nama_kecamatan', $search);
        }

        $totalFiltered = $kecamatanModel->countAllResults(false);

        $list = $kecamatanModel
            ->orderBy('id_kecamatan', 'DESC')
            ->findAll($length, $start);

        $rows = [];
        $no = $start + 1;
        foreach ($list as $row) {
            $rows[] = [
                'DT_RowIndex'    => $no++,
                'nama_kecamatan' => esc($row['nama_kecamatan']),
                'aksi' => '
                    <div class="btn-group">
                        <button onclick="editForm(`' . $row['id_kecamatan'] . '`)" class="btn btn-sm btn-outline-warning"><i class="fe fe-edit"></i></button>
                        <button style="margin-left:2pt" onclick="deleteData(`' . site_url('kecamatan/destroy/' . $row['id_kecamatan']) . '`)" class="btn btn-sm btn-outline-danger"><i class="fe fe-trash-2"></i></button>
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

    public function store(): ResponseInterface
    {
        $rules = [
            'nama_kecamatan' => [
                'rules'  => 'required|is_unique[kecamatan.nama_kecamatan]',
                'errors' => [
                    'required'  => 'Harap isi nama kecamatan!',
                    'is_unique' => 'Nama kecamatan ini sudah terdaftar.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            // Mengirimkan error validasi ke client
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $data = [
            'nama_kecamatan' => $this->request->getPost('nama_kecamatan')
        ];

        if ($this->kecamatan->save($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil ditambahkan.'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menambahkan data.'
        ]);
    }

    public function show($id_kecamatan = null): ResponseInterface
    {
        $kecamatan = $this->kecamatan->find($id_kecamatan);

        if ($kecamatan) {
            return $this->response->setJSON($kecamatan);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Data tidak ditemukan.'
        ]);
    }

    public function update($id_kecamatan = null): ResponseInterface
    {
        // Aturan validasi
        $rules = [
            'nama_kecamatan' => [
                'rules'  => "required|is_unique[kecamatan.nama_kecamatan,id_kecamatan,{$id_kecamatan}]",
                'errors' => [
                    'required'  => 'Nama kecamatan harus diisi.',
                    'is_unique' => 'Nama kecamatan ini sudah terdaftar.'
                ]
            ]
        ];

        // Validasi data dari request
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors()
            ]);
        }

        // Ambil data yang sudah divalidasi
        $data = [
            'nama_kecamatan' => $this->request->getVar('nama_kecamatan')
        ];

        // Lakukan update data di database
        if ($this->kecamatan->update($id_kecamatan, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil diperbarui.'
            ]);
        }

        // Jika gagal update karena alasan lain
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal memperbarui data kecamatan.'
        ]);
    }

    public function destroy($id_kecamatan = null): ResponseInterface
    {
        // 1. Inisialisasi model yang berelasi
        $desaModel = new DesaModel();
        $sekolahModel = new SekolahModel();

        // 2. Cek apakah kecamatan ini masih digunakan di tabel desa
        $desaIsUsed = $desaModel->where('id_kecamatan', $id_kecamatan)->first();
        if ($desaIsUsed) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak dapat dihapus, karena masih digunakan di data Desa.'
            ]);
        }

        // 3. Cek apakah kecamatan ini masih digunakan di tabel sekolah
        $sekolahIsUsed = $sekolahModel->where('id_kecamatan', $id_kecamatan)->first();
        if ($sekolahIsUsed) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak dapat dihapus, karena masih digunakan di data Sekolah.'
            ]);
        }

        // 4. Jika tidak digunakan di mana pun, baru lakukan penghapusan
        if ($this->kecamatan->delete($id_kecamatan, true)) { // 'true' untuk hapus permanen (hard delete)
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
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

        $kecamatanModel = new KecamatanModel();

        $data = $kecamatanModel
            ->like('nama_kecamatan', $searchTerm)
            ->findAll(10);

        $response = [];
        foreach ($data as $kecamatan) {
            $response[] = [
                'id'   => $kecamatan['id_kecamatan'],
                'text' => esc($kecamatan['nama_kecamatan'])
            ];
        }

        return $this->response->setJSON($response);
    }
}
