<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKecamatan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kecamatan'   => ['type' => 'INT', 'auto_increment' => true],
            'nama_kecamatan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            // 'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id_kecamatan', true);
        // $this->forge->addKey(['deleted_at', 'id_kecamatan']);
        // $this->forge->addKey('created_at');
        // $this->forge->addKey('updated_at');
        $this->forge->createTable('kecamatan');
    }

    public function down()
    {
        $this->forge->dropTable('kecamatan');
    }
}
