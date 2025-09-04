<?php

namespace App\Controllers;

use App\Models\SekolahModel;
use App\Controllers\BaseController;
use App\Models\KepalaSekolahModel;
use CodeIgniter\HTTP\ResponseInterface;

class SekolahController extends BaseController
{
    protected $sekolah;
    protected $db;

    public function __construct()
    {
        $this->sekolah = new SekolahModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = ['title' => 'Data Sekolah'];
        return view('sekolah/index', $data);
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

        $builder = $this->db->table('sekolah');
        $builder->select('sekolah.*, jenjang_pendidikan.nama_jenjang, kecamatan.nama_kecamatan, desa.nama_desa');
        $builder->join('jenjang_pendidikan', 'jenjang_pendidikan.id_jenjang = sekolah.id_jenjang', 'left');
        $builder->join('kecamatan', 'kecamatan.id_kecamatan = sekolah.id_kecamatan', 'left');
        $builder->join('desa', 'desa.id_desa = sekolah.id_desa', 'left');

        if ($userRole === 'operator') {
            $builder->where('sekolah.id_sekolah', $operatorSekolahId);
        }

        $totalData = $builder->countAllResults(false);

        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('sekolah.nama_sekolah', $search);
            $builder->orLike('sekolah.npsn', $search);
            $builder->orLike('kecamatan.nama_kecamatan', $search);
            $builder->orLike('desa.nama_desa', $search);
            $builder->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false);

        $builder->limit($length, $start);
        $builder->orderBy('sekolah.id_sekolah', 'DESC');
        $list = $builder->get()->getResultArray();

        $rows = [];
        $no = $start + 1;
        foreach ($list as $row) {
            $fotoUrl = base_url('foto_sekolah/' . ($row['foto'] ?? 'default.png'));

            $actionButtons = '<button type="button" onclick="editForm(`' . $row['id_sekolah'] . '`)" class="btn btn-sm btn-outline-warning"><i class="fe fe-edit"></i></button>';
            if (session('user_role') === 'admin') {
                $actionButtons .= '<button type="button" style="margin-left:2pt" onclick="deleteData(`' . site_url('sekolah/destroy/' . $row['id_sekolah']) . '`)" class="btn btn-sm btn-outline-danger"><i class="fe fe-trash-2"></i></button>';
            }

            $rows[] = [
                'checkbox'         => '<input type="checkbox" name="id_sekolah[]" class="checkbox-cetak" value="' . $row['id_sekolah'] . '">',
                'DT_RowIndex'      => $no++,
                'nama_sekolah'     => esc($row['nama_sekolah']),
                'npsn'             => esc($row['npsn']),
                'nama_jenjang'     => esc($row['nama_jenjang']),
                'akreditasi'       => esc($row['akreditasi']),
                'alamat'           => esc($row['alamat']),
                'nama_kecamatan'   => esc($row['nama_kecamatan']),
                'nama_desa'        => esc($row['nama_desa']),
                'status'           => esc($row['status']),
                'latitude'         => esc($row['latitude']),
                'longitude'        => esc($row['longitude']),
                'foto'             => '<img src="' . $fotoUrl . '" alt="Foto Sekolah" class="foto-sekolah-tabel">',
                'aksi'             => '<div class="btn-group">' . $actionButtons . '</div>'
            ];
        }

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data'            => $rows,
        ]);
    }

    private function getValidationRules($id_sekolah = null)
    {
        $npsnRule = 'required|numeric|is_unique[sekolah.npsn]';
        if ($id_sekolah) {
            $npsnRule = "required|numeric|is_unique[sekolah.npsn,id_sekolah,{$id_sekolah}]";
        }
        $fotoRule = 'uploaded[foto]|max_size[foto,2048]|mime_in[foto,image/png,image/jpg,image/jpeg]|ext_in[foto,png,jpg,jpeg]';
        if ($id_sekolah) {
            $fotoRule = 'max_size[foto,2048]|mime_in[foto,image/png,image/jpg,image/jpeg]|ext_in[foto,png,jpg,jpeg]';
        }
        return [
            'nama_sekolah' => ['rules' => 'required', 'errors' => ['required' => 'Harap isi nama sekolah.']],
            'npsn'         => ['rules' => $npsnRule, 'errors' => ['required' => 'Harap isi NPSN.', 'is_unique' => 'NPSN sudah terdaftar.']],
            'id_jenjang'   => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih jenjang pendidikan.']],
            'akreditasi'   => ['rules' => 'required|in_list[A,B,C,Belum Terakreditasi]', 'errors' => ['required' => 'Harap pilih akreditasi.']],
            'id_kecamatan' => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih Kecamatan.']],
            'id_desa'      => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih desa.']],
            'status'       => ['rules' => 'required', 'errors' => ['required' => 'Harap pilih status.']],
            'alamat'       => ['rules' => 'required', 'errors' => ['required' => 'Harap masukkan alamat.']],
            'latitude'     => ['rules' => 'required', 'errors' => ['required' => 'Harap masukkan latitude.']],
            'longitude'    => ['rules' => 'required', 'errors' => ['required' => 'Harap masukkan longitude.']],
            'foto'         => [
                'rules'  => $fotoRule,
                'errors' => [
                    'uploaded' => 'Harap masukkan foto sekolah.',
                    'max_size' => 'Ukuran foto maksimal 2MB.',
                    'mime_in'  => 'Format foto harus PNG, JPG, atau JPEG.'
                ]
            ]
        ];
    }

    public function store(): ResponseInterface
    {
        if (session('user_role') === 'operator') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.'])->setStatusCode(403);
        }
        $rules = $this->getValidationRules();
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors'  => $this->validator->getErrors()]);
        }
        $foto = $this->request->getFile('foto');
        $namaSekolah = $this->request->getPost('nama_sekolah');
        $namaFoto = $this->_generateFotoName($namaSekolah, $foto);
        $foto->move('foto_sekolah', $namaFoto);
        $data = $this->request->getPost();
        $data['foto'] = $namaFoto;
        if ($this->sekolah->save($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil ditambahkan.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan data.']);
    }

    public function show($id_sekolah = null): ResponseInterface
    {
        if (session('user_role') === 'operator' && $id_sekolah != session('user_id_sekolah')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.'])->setStatusCode(403);
        }
        $builder = $this->sekolah->table('sekolah');
        $builder->select('sekolah.*, jenjang_pendidikan.nama_jenjang, kecamatan.nama_kecamatan, desa.nama_desa');
        $builder->join('jenjang_pendidikan', 'jenjang_pendidikan.id_jenjang = sekolah.id_jenjang', 'left');
        $builder->join('kecamatan', 'kecamatan.id_kecamatan = sekolah.id_kecamatan', 'left');
        $builder->join('desa', 'desa.id_desa = sekolah.id_desa', 'left');
        $builder->where('sekolah.id_sekolah', $id_sekolah);
        $data = $builder->get()->getRowArray();
        if ($data) {
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
    }

    public function update($id_sekolah = null): ResponseInterface
    {
        if (session('user_role') === 'operator' && $id_sekolah != session('user_id_sekolah')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.'])->setStatusCode(403);
        }
        $rules = $this->getValidationRules($id_sekolah);
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors'  => $this->validator->getErrors()]);
        }
        $data = $this->request->getPost();
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid()) {
            $sekolahLama = $this->sekolah->find($id_sekolah);
            $fotoLama = $sekolahLama['foto'];
            if ($fotoLama && file_exists('foto_sekolah/' . $fotoLama)) {
                unlink('foto_sekolah/' . $fotoLama);
            }
            $namaSekolah = $this->request->getPost('nama_sekolah');
            $namaFotoBaru = $this->_generateFotoName($namaSekolah, $foto);
            $foto->move('foto_sekolah', $namaFotoBaru);
            $data['foto'] = $namaFotoBaru;
        }
        if ($this->sekolah->update($id_sekolah, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil diperbarui.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui data.']);
    }

    public function destroy($id_sekolah = null): ResponseInterface
    {
        if (session('user_role') === 'operator') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak.'])->setStatusCode(403);
        }
        $kepsekModel = new KepalaSekolahModel();
        $kepsekIsUsed = $kepsekModel->where('id_sekolah', $id_sekolah)->first();
        if ($kepsekIsUsed) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak dapat dihapus, karena masih digunakan di data Kepala Sekolah.']);
        }
        $sekolah = $this->sekolah->find($id_sekolah);
        if ($sekolah) {
            $foto = $sekolah['foto'];
            if ($foto && file_exists('foto_sekolah/' . $foto)) {
                unlink('foto_sekolah/' . $foto);
            }
            $this->sekolah->delete($id_sekolah, true);
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil dihapus.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
    }

    private function _generateFotoName($namaSekolah, $file)
    {
        helper(['url', 'text']);
        $slug = url_title($namaSekolah, '-', true);
        $tanggal = date('Y-m-d');
        $ekstensi = $file->getExtension();
        return "{$slug}_{$tanggal}.{$ekstensi}";
    }

    public function getSelect2Data()
    {
        $request = service('request');
        $searchTerm = $request->getVar('term') ?? '';
        $sekolahModel = new SekolahModel();
        $data = $sekolahModel->like('nama_sekolah', $searchTerm)->findAll(10);
        $response = [];
        foreach ($data as $sekolah) {
            $response[] = [
                'id'   => $sekolah['id_sekolah'],
                'text' => esc($sekolah['nama_sekolah'])
            ];
        }
        return $this->response->setJSON($response);
    }

    public function cetak()
    {
        $id_sekolah = $this->request->getPost('id_sekolah');
        if (!$id_sekolah) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dicetak.');
        }
        $builder = $this->db->table('sekolah');
        $builder->select('sekolah.*, jenjang_pendidikan.nama_jenjang, kecamatan.nama_kecamatan, desa.nama_desa');
        $builder->join('jenjang_pendidikan', 'jenjang_pendidikan.id_jenjang = sekolah.id_jenjang', 'left');
        $builder->join('kecamatan', 'kecamatan.id_kecamatan = sekolah.id_kecamatan', 'left');
        $builder->join('desa', 'desa.id_desa = sekolah.id_desa', 'left');
        $builder->whereIn('sekolah.id_sekolah', $id_sekolah);
        $builder->orderBy('sekolah.nama_sekolah', 'ASC');
        $query = $builder->get();
        $data = [
            'title'   => 'Data Sekolah',
            'sekolah' => $query->getResultArray()
        ];
        return view('sekolah/cetak', $data);
    }
}
