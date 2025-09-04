<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OperatorController extends BaseController
{
    protected $db;
    protected $users;

    public function __construct()
    {
        $this->users = new UserModel();
        $this->db = \Config\Database::connect();
    }

    // Method index, data, store, show, dan update tidak ada perubahan dari sebelumnya.
    // ... (kode method lain tetap sama) ...

    public function index()
    {
        $data = ['title' => 'Data Operator'];
        return view('operator/index', $data);
    }

    public function data(): ResponseInterface
    {
        $request = service('request');
        $draw     = intval($request->getVar('draw'));
        $start    = intval($request->getVar('start'));
        $length   = intval($request->getVar('length'));
        $search   = $request->getVar('search')['value'] ?? '';

        $builder = $this->db->table('users');
        $builder->select('users.id_users, users.username, users.email, sekolah.nama_sekolah');
        $builder->join('sekolah', 'sekolah.id_sekolah = users.id_sekolah', 'left');
        $builder->where('users.role', 'operator');

        $totalData = $builder->countAllResults(false);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('users.username', $search)
                ->orLike('users.email', $search)
                ->orLike('sekolah.nama_sekolah', $search)
                ->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false);

        $builder->limit($length, $start);
        $builder->orderBy('users.id_users', 'DESC');
        $list = $builder->get()->getResultArray();

        $rows = [];
        $no = $start + 1;
        foreach ($list as $row) {
            $rows[] = [
                'DT_RowIndex'  => $no++,
                'nama_sekolah' => esc($row['nama_sekolah'] ?? 'Belum terhubung'),
                'username'     => esc($row['username']),
                'email'        => esc($row['email']),
                'aksi'         => '
                    <div class="btn-group">
                        <button onclick="editForm(`' . $row['id_users'] . '`)" class="btn btn-sm btn-outline-warning"><i class="fe fe-edit"></i></button>
                        <button style="margin-left:2pt" onclick="deleteData(`' . site_url('operator/destroy/' . $row['id_users']) . '`)" class="btn btn-sm btn-outline-danger"><i class="fe fe-trash-2"></i></button>
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
            'id_sekolah' => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih sekolah.']],
            'username'   => ['rules' => 'required', 'errors' => ['required' => 'Nama operator wajib diisi.']],
            'email'      => ['rules' => 'required|valid_email|is_unique[users.email]', 'errors' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique'   => 'Email ini sudah terdaftar.'
            ]],
            'password'   => ['rules' => 'required|min_length[6]', 'errors' => [
                'required'   => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.'
            ]],
            'password_confirm' => ['rules' => 'required|matches[password]', 'errors' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok dengan password baru.'
            ]]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
        }

        $data = [
            'id_sekolah' => $this->request->getPost('id_sekolah'),
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'role'       => 'operator',
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'foto'       => 'default-profile.jpg',
        ];

        if ($this->users->save($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil ditambahkan.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan data.']);
    }

    public function show($id_users = null): ResponseInterface
    {
        $builder = $this->db->table('users');
        $builder->select('users.*, sekolah.nama_sekolah');
        $builder->join('sekolah', 'sekolah.id_sekolah = users.id_sekolah', 'left');
        $builder->where('users.id_users', $id_users);
        $builder->where('users.role', 'operator');
        $data = $builder->get()->getRowArray();

        if ($data) {
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
    }

    public function update($id_users = null): ResponseInterface
    {
        $rules = [
            'id_sekolah' => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih sekolah.']],
            'username'   => ['rules' => 'required', 'errors' => ['required' => 'Nama operator harus diisi.']],
            'email'      => ['rules' => "required|valid_email|is_unique[users.email,id_users,{$id_users}]", 'errors' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique'   => 'Email ini sudah digunakan akun lain.'
            ]],
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = ['rules' => 'required|min_length[6]', 'errors' => ['min_length' => 'Password minimal 6 karakter.']];
            $rules['password_confirm'] = ['rules' => 'required|matches[password]', 'errors' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok.'
            ]];
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
        }

        $data = [
            'id_sekolah' => $this->request->getVar('id_sekolah'),
            'username'   => $this->request->getVar('username'),
            'email'      => $this->request->getVar('email'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->users->update($id_users, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui data.']);
    }


    // --- METHOD DESTROY YANG DIMODIFIKASI ---
    public function destroy($id_users = null): ResponseInterface
    {
        // 1. Ambil data user terlebih dahulu berdasarkan id
        $user = $this->users->where('role', 'operator')->find($id_users);

        // Jika user tidak ditemukan, kirim pesan gagal
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data operator tidak ditemukan.'
            ]);
        }

        // 2. Coba hapus data dari database
        if ($this->users->delete($id_users)) {

            // 3. Jika record database berhasil dihapus, lanjutkan hapus file
            // Cek apakah nama file foto bukan foto default dan tidak kosong
            if ($user['foto'] && $user['foto'] != 'default-profile.jpg') {
                $filePath = FCPATH . 'img/' . $user['foto'];

                // Cek apakah file benar-benar ada sebelum menghapusnya
                if (file_exists($filePath)) {
                    unlink($filePath); // Hapus file dari folder public/img
                }
            }

            // Kirim pesan sukses
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        }

        // Jika gagal menghapus dari database
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus data operator.'
        ]);
    }
}
