<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Kas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'organization_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'saldo' => [
                'type' => 'DOUBLE',
                'default' => 0
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addForeignKey('organization_id', 'organizations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kas', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('kas');
    }
}