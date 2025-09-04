<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'   => 'admin',
            'email'      => 'admin@gmail.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'foto'       => 'default-profile.jpg',
            'role'       => 'admin',
            'id_sekolah' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Insert data ke dalam tabel users
        $this->db->table('users')->insert($data);
    }
}
