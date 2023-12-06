<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Presensi extends Migration
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
            'pertemuan_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['H','S','I','A'],
                'default' => 'A'
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('member_id', 'organization_member', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pertemuan_id', 'pertemuan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('presensi', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('presensi');
    }
}
