<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Transaksi extends Migration
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
            'tagihan_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['income','expense'],
                'null' => true,
                'default' => null
            ],
            'amount' => [
                'type' => 'DOUBLE',
                'default' => 0
            ],
            'payment' => [
                'type' => 'ENUM',
                'constraint' => ['online','offline'],
                'default' => 'offline'
            ],
            'gateway_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['unpaid','paid','cancel'],
                'default' => 'unpaid'
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('member_id', 'organization_member', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('tagihan_id', 'tagihan', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('transaksi', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
