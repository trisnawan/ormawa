<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;
use App\Models\KasModel;
use App\Models\TransaksiModel;

class TagihanModel extends Model
{
    protected $table            = 'tagihan';
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
        $kas = new KasModel();
        $organizationId = $data['data']['organization_id'];
        if(!$kas->find($organizationId)){
            $kas->insert(['organization_id'=>$organizationId]);
        }

        $uuid = Uuid::uuid4();
        $data['data']['id'] = $uuid->toString();
        return $data;
    }

    protected function select_field(array $data){
        $this->select('tagihan.id, tagihan.title, tagihan.amount');
        $this->orderBy('tagihan.created_at', 'DESC');
        return $data;
    }

    public function getTagihan($id, $member_id){
        $transaksiModel = new TransaksiModel();
        $data = $this->find($id);
        if($data){
            $transaksiModel->where('member_id', $member_id);
            $data['transaksi'] = $transaksiModel->where('tagihan_id', $id)->first();
        }
        return $data;
    }
}
