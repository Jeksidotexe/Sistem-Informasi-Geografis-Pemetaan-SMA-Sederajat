<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSekolah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sekolah'           => ['type' => 'INT', 'auto_increment' => true],
            'nama_sekolah' => ['type' => 'VARCHAR', 'constraint' => 100],
            'npsn'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'id_jenjang'   => ['type' => 'INT'],
            'akreditasi' => [
                'type'       => 'ENUM',
                'constraint' => ['A', 'B', 'C', 'Belum Akreditasi'],
                'null'       => false,
            ],
            'alamat'       => ['type' => 'TEXT'],
            'id_kecamatan' => ['type' => 'INT'],
            'id_desa'      => ['type' => 'INT'],
            'latitude'     => ['type' => 'DECIMAL', 'constraint' => '10,8'],
            'longitude'    => ['type' => 'DECIMAL', 'constraint' => '11,8'],
            'status'       => ['type' => 'ENUM', 'constraint' => ['Negeri', 'Swasta']],
            'foto'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            // 'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id_sekolah', true);
        // $this->forge->addKey(['deleted_at', 'id_sekolah']);
        // $this->forge->addKey('created_at');
        // $this->forge->addKey('updated_at');
        $this->forge->addForeignKey('id_jenjang', 'jenjang_pendidikan', 'id_jenjang');
        $this->forge->addForeignKey('id_kecamatan', 'kecamatan', 'id_kecamatan');
        $this->forge->addForeignKey('id_desa', 'desa', 'id_desa');
        $this->forge->createTable('sekolah');
    }

    public function down()
    {
        $this->forge->dropTable('sekolah');
    }
}
