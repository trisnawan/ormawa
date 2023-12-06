<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;
use App\Models\OrganizationMemberModel;

class OrganizationModel extends Model
{
    protected $table            = 'organizations';
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
    protected $beforeFind     = ['select_field'];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function insert_field(array $data){
        $uuid = Uuid::uuid4();
        $data['data']['id'] = $uuid->toString();
        $data['data']['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['data']['title'])));
        $data['data']['status'] = 'verifing';
        return $data;
    }

    protected function select_field(array $data){
        $this->select('id, slug, title, description, status, created_at');
        $this->select("CONCAT('".base_url('content/organization/avatar/')."', IFNULL(avatar, 'default.png')) as avatar");
        $this->select("kas.saldo");
        $this->select("(SELECT COUNT(m.id) FROM organization_member m WHERE m.organization_id = organizations.id AND m.status = 'verified') as jumlah_anggota");
        $this->join("kas", "kas.organization_id = organizations.id", "left");
        return $data;
    }

    public function getMyOrg($id, $user_id){
        $memberModel = new OrganizationMemberModel();
        $memberModel->where('organization_member.organization_id', $id);
        $memberModel->where('organization_member.user_id', $user_id);
        $member = $memberModel->first();
        if(!$member) return null;

        $data = $this->find($id);
        if(!$data) return null;
        $data['member'] = $member;
        return $data;
    }
}
