<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $table = 'users';
        if($this->db->table($table)->countAll() > 0){
            log_message('error', "$table seed failed, double seeding...");
            return false;
        }

        $uuid = Uuid::uuid4();
        $data['id'] = $uuid->toString();
        $data['email'] = 'halo.trisnasejati@gmail.com';
        $data['phone'] = '6287719734045';
        $data['password'] = password_hash('rindu', PASSWORD_DEFAULT);
        $data['full_name'] = 'Trisnawan';
        $data['gender'] = 'male';
        $data['role'] = 'admin';
        $this->db->table($table)->insert($data);
    }
}
