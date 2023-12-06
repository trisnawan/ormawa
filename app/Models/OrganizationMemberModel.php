<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizationMemberModel extends Model
{
    protected $table            = 'organization_member';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'join_at';
    protected $updatedField  = null;
    protected $deletedField  = null;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = ['select_field'];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function select_field(array $data){
        $this->select('organization_member.id, organization_member.role, organization_member.position, organization_member.status, organization_member.join_at');
        $this->select('organizations.id as organization_id, organizations.title as organization_title');
        $this->select("CONCAT('".base_url('content/organization/avatar/')."', IFNULL(organizations.avatar, 'default.png')) as organization_avatar");
        $this->select("organization_member.user_id, users.full_name as user_full_name");
        $this->select("CONCAT('".base_url('content/profile/avatar/')."', IFNULL(users.avatar, 'default.png')) as user_avatar");
        $this->join('organizations', 'organizations.id = organization_member.organization_id');
        $this->join('users', 'users.id = organization_member.user_id');
        return $data;
    }
}
