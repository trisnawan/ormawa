<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OrganizationMember extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'organization_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['member','admin'],
                'default' => 'member'
            ],
            'position' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
                'default' => null
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['verifing','verified','blocked'],
                'default' => 'verifing'
            ],
            'join_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('organization_id', 'organizations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('organization_member', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('organization_member');
    }
}
