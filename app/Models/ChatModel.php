<?php

namespace App\Models;

use CodeIgniter\Model;
use Pusher\Pusher;

class ChatModel extends Model
{
    protected $table            = 'chat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'send_at';
    protected $updatedField  = null;
    protected $deletedField  = null;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ['pusher_notify'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = ['selection_field'];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function selection_field(array $data){
        $this->select('chat.id, chat.text, chat.image, chat.send_at');
        $this->select('users.id as user_id, users.full_name as user_full_name');
        $this->select("CONCAT('".base_url('content/profile/avatar/')."', IFNULL(users.avatar, 'default.png')) as user_avatar");
        $this->select('organization_member.organization_id');
        $this->join('organization_member', 'organization_member.id = chat.member_id');
        $this->join('users', 'users.id = organization_member.user_id');
        return $data;
    }

    protected function pusher_notify(array $data){
        if(!$data['id']) return $data;
        $message = $this->find($data['id']);
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            'ad7b1b8dd25e9cd9038d',
            '955e7b1472aae4cee566',
            '1722406',
            $options
        );
        $pusher->trigger($message['organization_id'], 'chat', $message);

        return $data;
    }
}
