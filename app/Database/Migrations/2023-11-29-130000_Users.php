<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'unique' => true
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'default' => null
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => null
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true,
                'default' => null
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['male','female'],
                'null' => true,
                'default' => null
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => true,
                'default' => null
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['member','admin'],
                'default' => 'member'
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
