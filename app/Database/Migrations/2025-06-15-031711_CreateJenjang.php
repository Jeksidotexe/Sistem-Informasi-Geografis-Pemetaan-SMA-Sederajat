<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenjangPendidikan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenjang'   => ['type' => 'INT', 'auto_increment' => true],
            'nama_jenjang' => ['type' => 'VARCHAR', 'constraint' => 50],
            'keterangan'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            // 'deleted_at'   => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id_jenjang', true);
        // $this->forge->addKey(['deleted_at', 'id_jenjang']);
        // $this->forge->addKey('created_at');
        // $this->forge->addKey('updated_at');
        $this->forge->createTable('jenjang_pendidikan');
    }

    public function down()
    {
        $this->forge->dropTable('jenjang_pendidikan');
    }
}
