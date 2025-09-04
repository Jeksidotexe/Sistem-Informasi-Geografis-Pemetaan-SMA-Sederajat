<?php

namespace App\Controllers;

use App\Models\SekolahModel;
use App\Models\KepalaSekolahModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KepalaSekolahController extends BaseController
{
    protected $kepala_sekolah;
    protected $sekolah;
    protected $db;

    public function __construct()
    {
        $this->kepala_sekolah = new KepalaSekolahModel();
        $this->sekolah = new SekolahModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kepala Sekolah'
        ];
        return view('kepala_sekolah/index', $data);
    }

    public function data(): ResponseInterface
    {
        $userRole = session('user_role');
        $operatorSekolahId = session('user_id_sekolah');

        $request = service('request');
        $draw    = intval($request->getVar('draw'));
        $start   = intval($request->getVar('start'));
        $length  = intval($request->getVar('length'));
        $search  = $request->getVar('search')['value'] ?? '';

        $builder = $this->db->table('kepala_sekolah');
        $builder->select('kepala_sekolah.id_kepsek, kepala_sekolah.nama_kepsek, sekolah.nama_sekolah');
        $builder->join('sekolah', 'sekolah.id_sekolah = kepala_sekolah.id_sekolah');

        if ($userRole === 'operator') {
            $builder->where('kepala_sekolah.id_sekolah', $operatorSekolahId);
        }

        $totalData = $builder->countAllResults(false);

        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('kepala_sekolah.nama_kepsek', $search);
            $builder->orLike('sekolah.nama_sekolah', $search);
            $builder->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false);

        $builder->limit($length, $start);
        $builder->orderBy('kepala_sekolah.id_kepsek', 'DESC');
        $list = $builder->get()->getResultArray();

        $rows = [];
        $no = $start + 1;
        foreach ($list as $row) {
            $actionButtons = '<button onclick="editForm(`' . $row['id_kepsek'] . '`)" class="btn btn-sm btn-outline-warning"><i class="fe fe-edit"></i></button>';
            if ($userRole === 'admin') {
                $actionButtons .= '<button style="margin-left:2pt" onclick="deleteData(`' . site_url('kepala_sekolah/destroy/' . $row['id_kepsek']) . '`)" class="btn btn-sm btn-outline-danger"><i class="fe fe-trash-2"></i></button>';
            }

            $rows[] = [
                'DT_RowIndex'  => $no++,
                'nama_sekolah' => esc($row['nama_sekolah']),
                'nama_kepsek'  => esc($row['nama_kepsek']),
                'aksi'         => '<div class="btn-group">' . $actionButtons . '</div>'
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
        if (session('user_role') === 'operator') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.'])->setStatusCode(403);
        }

        $id_sekolah = $this->request->getPost('id_sekolah');
        $rules = [
            'id_sekolah' => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih sekolah!']],
            'nama_kepsek'    => [
                'rules' => "required|is_unique[kepala_sekolah.nama_kepsek,id_sekolah,{$id_sekolah}]",
                'errors' => [
                    'required'  => 'Harap isi nama kepala sekolah!',
                    'is_unique' => 'Nama kepala sekolah sudah terdaftar di sekolah yang sama.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors'  => $this->validator->getErrors()]);
        }

        $data = [
            'id_sekolah'  => $this->request->getPost('id_sekolah'),
            'nama_kepsek' => $this->request->getPost('nama_kepsek')
        ];

        if ($this->kepala_sekolah->save($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil ditambahkan.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan data.']);
    }

    public function show($id_kepsek = null): ResponseInterface
    {
        $builder = $this->db->table('kepala_sekolah');
        $builder->select('kepala_sekolah.*, sekolah.nama_sekolah');
        $builder->join('sekolah', 'sekolah.id_sekolah = kepala_sekolah.id_sekolah');
        $builder->where('kepala_sekolah.id_kepsek', $id_kepsek);
        $data = $builder->get()->getRowArray();

        if (session('user_role') === 'operator' && $data && $data['id_sekolah'] != session('user_id_sekolah')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.'])->setStatusCode(403);
        }

        if ($data) {
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
    }

    public function update($id_kepsek = null): ResponseInterface
    {
        $kepsek = $this->kepala_sekolah->find($id_kepsek);
        if (session('user_role') === 'operator' && (!$kepsek || $kepsek['id_sekolah'] != session('user_id_sekolah'))) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.'])->setStatusCode(403);
        }

        $id_sekolah_from_form = $this->request->getVar('id_sekolah');
        $rules = [
            'nama_kepsek'    => [
                'rules' => "required|is_unique[kepala_sekolah.nama_kepsek,id_kepsek,{$id_kepsek},id_sekolah,{$id_sekolah_from_form}]",
                'errors' => [
                    'required'  => 'Nama kepala sekolah harus diisi.',
                    'is_unique' => 'Nama kepala sekolah ini sudah terdaftar di sekolah yang sama.'
                ]
            ]
        ];

        if (session('user_role') === 'admin') {
            $rules['id_sekolah'] = ['rules' => 'required', 'errors' => ['required' => 'Harap pilih sekolah!']];
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors'  => $this->validator->getErrors()]);
        }

        $data = ['nama_kepsek' => $this->request->getVar('nama_kepsek')];
        if (session('user_role') === 'admin') {
            $data['id_sekolah'] = $id_sekolah_from_form;
        }

        if ($this->kepala_sekolah->update($id_kepsek, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui data.']);
    }

    public function destroy($id_kepsek = null): ResponseInterface
    {
        if (session('user_role') === 'operator') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.'])->setStatusCode(403);
        }

        if ($this->kepala_sekolah->delete($id_kepsek, true)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil dihapus permanen.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data.']);
    }
}
