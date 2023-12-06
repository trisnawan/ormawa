<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Tagihan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'organization_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => true,
                'default' => null
            ],
            'amount' => [
                'type' => 'DOUBLE',
                'default' => 0
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('organization_id', 'organizations', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('tagihan', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('tagihan');
    }
}
