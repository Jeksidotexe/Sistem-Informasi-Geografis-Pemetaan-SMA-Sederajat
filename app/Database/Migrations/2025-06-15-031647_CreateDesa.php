<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDesa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_desa'      => ['type' => 'INT', 'auto_increment' => true],
            'id_kecamatan' => ['type' => 'INT'],
            'nama_desa'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            // 'deleted_at'   => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id_desa', true);
        // $this->forge->addKey(['deleted_at', 'id_desa']);
        // $this->forge->addKey('created_at');
        // $this->forge->addKey('updated_at');
        $this->forge->addForeignKey('id_kecamatan', 'kecamatan', 'id_kecamatan');
        $this->forge->createTable('desa');
    }

    public function down()
    {
        $this->forge->dropTable('desa');
    }
}
