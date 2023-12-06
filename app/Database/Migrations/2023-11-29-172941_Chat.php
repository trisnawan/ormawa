<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Chat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'member_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'text' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => null
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => true,
                'default' => null
            ],
            'send_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('member_id', 'organization_member', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('chat', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('chat');
    }
}
