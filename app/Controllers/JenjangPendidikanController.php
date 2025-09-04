<?php

namespace App\Controllers;

use App\Models\SekolahModel;
use App\Controllers\BaseController;
use App\Models\JenjangPendidikanModel;
use CodeIgniter\HTTP\ResponseInterface;

class JenjangPendidikanController extends BaseController
{
    protected $jenjang_pendidikan;

    public function __construct()
    {
        $this->jenjang_pendidikan = new JenjangPendidikanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Jenjang Pendidikan'
        ];
        return view('jenjang_pendidikan/index', $data);
    }

    public function data(): ResponseInterface
    {
        $request = service('request');
        $draw    = intval($request->getVar('draw'));
        $start   = intval($request->getVar('start'));
        $length  = intval($request->getVar('length'));
        $search  = $request->getVar('search')['value'] ?? '';

        $jenjangModel = $this->jenjang_pendidikan;

        $totalData = $jenjangModel->countAll();

        if (!empty($search)) {
            $jenjangModel = $jenjangModel->like('nama_jenjang', 'keterangan', $search);
        }

        $totalFiltered = $jenjangModel->countAllResults(false);

        $list = $jenjangModel
            ->orderBy('id_jenjang', 'DESC')
            ->findAll($length, $start);

        $rows = [];
        $no = $start + 1;
        foreach ($list as $row) {
            $rows[] = [
                'DT_RowIndex'    => $no++,
                'nama_jenjang' => esc($row['nama_jenjang']),
                'keterangan' => esc($row['keterangan']),
                'aksi' => '
                    <div class="btn-group">
                        <button onclick="editForm(`' . $row['id_jenjang'] . '`)" class="btn btn-sm btn-outline-warning"><i class="fe fe-edit"></i></button>
                        <button style="margin-left:2pt" onclick="deleteData(`' . site_url('jenjang_pendidikan/destroy/' . $row['id_jenjang']) . '`)" class="btn btn-sm btn-outline-danger"><i class="fe fe-trash-2"></i></button>
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
            'nama_jenjang' => [
                'rules'  => 'required|is_unique[jenjang_pendidikan.nama_jenjang]',
                'errors' => [
                    'required'  => 'Harap isi nama jenjang pendidikan!',
                    'is_unique' => 'Nama jenjang pendidikan ini sudah terdaftar.'
                ]
            ],
            'keterangan' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'Harap isi keterangan!'
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
            'nama_jenjang' => $this->request->getPost('nama_jenjang'),
            'keterangan' => $this->request->getPost('keterangan')
        ];

        if ($this->jenjang_pendidikan->save($data)) {
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

    public function show($id_jenjang = null): ResponseInterface
    {
        $jenjang_pendidikan = $this->jenjang_pendidikan->find($id_jenjang);

        if ($jenjang_pendidikan) {
            return $this->response->setJSON($jenjang_pendidikan);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Data tidak ditemukan.'
        ]);
    }

    public function update($id_jenjang = null): ResponseInterface
    {
        // Aturan validasi
        $rules = [
            'nama_jenjang' => [
                'rules'  => "required|is_unique[jenjang_pendidikan.nama_jenjang,id_jenjang,{$id_jenjang}]",
                'errors' => [
                    'required'  => 'Nama jenjang pendidikan harus diisi.',
                    'is_unique' => 'Nama jenjang pendidikan ini sudah terdaftar.'
                ]
            ],
            'keterangan' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'Harap isi keterangan!'
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
            'nama_jenjang' => $this->request->getVar('nama_jenjang'),
            'keterangan' => $this->request->getVar('keterangan')
        ];

        // Lakukan update data di database
        if ($this->jenjang_pendidikan->update($id_jenjang, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil diperbarui.'
            ]);
        }

        // Jika gagal update karena alasan lain
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal memperbarui data.'
        ]);
    }

    public function destroy($id_jenjang = null): ResponseInterface
    {
        // 1. Buat instance model sekolah untuk pengecekan
        $sekolahModel = new SekolahModel();

        // 2. Cek apakah id_jenjang ini masih digunakan di tabel sekolah
        $isUsed = $sekolahModel->where('id_jenjang', $id_jenjang)->first();

        // 3. Jika $isUsed tidak kosong (artinya data masih digunakan)
        if ($isUsed) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak dapat dihapus, karena masih digunakan di data sekolah.'
            ]);
        }

        // 4. Jika tidak digunakan, baru lakukan penghapusan
        if ($this->jenjang_pendidikan->delete($id_jenjang, true)) { // 'true' untuk hard delete
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

        $jenjangModel = new JenjangPendidikanModel();

        $data = $jenjangModel
            ->like('nama_jenjang', $searchTerm)
            ->findAll(10);

        $response = [];
        foreach ($data as $jenjang_pendidikan) {
            $response[] = [
                'id'   => $jenjang_pendidikan['id_jenjang'],
                'text' => esc($jenjang_pendidikan['nama_jenjang'])
            ];
        }

        return $this->response->setJSON($response);
    }
}
