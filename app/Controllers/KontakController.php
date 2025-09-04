<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class KontakController extends BaseController
{
    public function kirim()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setBody('Method Not Allowed');
        }

        // 1. Aturan Validasi dengan Pesan Kustom
        $rules = [
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Harap masukkan nama Anda.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Harap masukkan email Anda.',
                    'valid_email' => 'Harap masukkan format email yang valid.',
                ],
            ],
            'subjek' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Harap masukkan subjek pesan.',
                ],
            ],
            'pesan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Harap masukkan isi pesan Anda.',
                ],
            ],
        ];

        // 2. Cek Validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kirim semua pesan error kustom
            return $this->response->setJSON([
                'status' => 'validation_error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // 3. Ambil data dari form (tidak ada perubahan di sini)
        $nama = $this->request->getPost('nama');
        $email_pengirim = $this->request->getPost('email');
        $subjek = $this->request->getPost('subjek');
        $pesan = $this->request->getPost('pesan');

        // 4. Konfigurasi dan Kirim Email (tidak ada perubahan di sini)
        $email = \Config\Services::email();
        $email->setTo('zakiptk1@gmail.com');
        $email->setFrom($email_pengirim, $nama);
        $email->setSubject("Pesan dari Website: " . $subjek);
        $email->setMessage($pesan);

        // 5. Kirim email dan berikan respons JSON (tidak ada perubahan di sini)
        if ($email->send()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Pesan Anda berhasil terkirim. Terima kasih!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengirim email. Silakan coba lagi.']);
        }
    }
}
