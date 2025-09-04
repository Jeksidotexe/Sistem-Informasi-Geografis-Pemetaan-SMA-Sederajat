<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_users'       => ['type' => 'INT', 'auto_increment' => true],
            'id_sekolah'     => ['type' => 'INT', 'null' => true],
            'username'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'password'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'foto'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'           => ['type' => 'ENUM', 'constraint' => ['admin', 'operator'], 'default' => 'operator'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            // 'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id_users', true);
        // $this->forge->addKey(['deleted_at', 'id_users']);
        // $this->forge->addKey('created_at');
        // $this->forge->addKey('updated_at');
        $this->forge->addForeignKey('id_sekolah', 'sekolah', 'id_sekolah', 'SET NULL');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
