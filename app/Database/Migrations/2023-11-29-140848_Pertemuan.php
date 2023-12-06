<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Pertemuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'member_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
            ],
            'start_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null
            ],
            'end_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null
            ],
            'location' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => null
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('member_id', 'organization_member', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('pertemuan', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('pertemuan');
    }
}
