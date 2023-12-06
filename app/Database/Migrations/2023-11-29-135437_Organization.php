<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Organization extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => true,
                'default' => null
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => true,
                'default' => null
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => null
            ],
            'legal_doc' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => true,
                'default' => null
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['verifing','verified','blocked'],
                'default' => 'verifing'
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('organizations', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('organizations');
    }
}
