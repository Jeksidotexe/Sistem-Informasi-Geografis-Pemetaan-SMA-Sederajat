<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKepalaSekolah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kepsek'    => ['type' => 'INT', 'auto_increment' => true],
            'id_sekolah'   => ['type' => 'INT'],
            'nama_kepsek'  => ['type' => 'VARCHAR', 'constraint' => 100],
            // 'nip'          => ['type' => 'VARCHAR', 'constraint' => 30],
            // 'masa_jabatan' => ['type' => 'VARCHAR', 'constraint' => 50],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            // 'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id_kepsek', true);
        // $this->forge->addKey(['deleted_at', 'id_kepsek']);
        // $this->forge->addKey('created_at');
        // $this->forge->addKey('updated_at');
        $this->forge->addForeignKey('id_sekolah', 'sekolah', 'id_sekolah');
        $this->forge->createTable('kepala_sekolah');
    }

    public function down()
    {
        $this->forge->dropTable('kepala_sekolah');
    }
}
