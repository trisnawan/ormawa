<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class PertemuanModel extends Model
{
    protected $table            = 'pertemuan';
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
    protected $beforeInsert   = ['insert_field'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = ['selection_field'];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function selection_field(array $data){
        $this->select('pertemuan.*, organization_member.organization_id');
        $this->join('organization_member', 'organization_member.id = pertemuan.member_id');
        $this->orderBy('pertemuan.start_at', 'DESC');
        return $data;
    }

    protected function insert_field(array $data){
        $uuid = Uuid::uuid4();
        $data['data']['id'] = $uuid->toString();
        return $data;
    }
    
}
