<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\KasModel;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = ['update_action'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function update_action(array $data){
        if(isset($data['id']) && isset($data['data']['status'])){
            $this->select('tagihan.organization_id');
            $this->join('tagihan', 'tagihan.id = transaksi.tagihan_id');
            $get = $this->where('transaksi.id', $data['id'])->first();
            if($get){
                $this->select('SUM(transaksi.amount) as saldo');
                $this->join('tagihan', 'tagihan.id = transaksi.tagihan_id');
                $this->where('transaksi.status', 'paid');
                $this->where('tagihan.organization_id', $get['organization_id']);
                $saldo = $this->first();
                $saldo = $saldo['saldo'] ?? 0;

                $kasModel = new KasModel();
                $kasModel->update([$get['organization_id']], ['saldo' => $saldo]);
            }
        }
    }
}
