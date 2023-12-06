<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
    protected $deletedField  = null;

    protected $allowCallbacks = true;
    protected $beforeInsert   = ['insert_fields'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = ['selection_fields'];
    protected $afterFind      = ['time_format'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function selection_fields(array $data){
        $this->select('id, email, phone, full_name, gender, role');
        $this->select("CONCAT('".base_url('content/profile/avatar/')."', IFNULL(avatar, 'default.png')) as avatar");
        $this->select('created_at');
        return $data;
    }

    protected function time_format(array $data){
        $data = modelTimeISO($data, ['created_at']);
        return $data;
    }

    protected function insert_fields(array $data){
        $uuid = Uuid::uuid4();
        $data['data']['id'] = $uuid->toString();
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        $data['data']['role'] = isset($data['data']['role']) ? $data['data']['role'] : 'member';
        return $data;
    }

    public function login($email, $password){
        $this->select('password');
        $user = $this->where('email', $email)->first();
        if(!$user) return null;
        if(!password_verify($password, $user['password'])) return null;

        unset($user['password']);
        return $user;
    }
}
