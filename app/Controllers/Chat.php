<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Auth;
use App\Libraries\ImageResizer;
use App\Models\OrganizationModel;
use App\Models\OrganizationMemberModel;
use App\Models\ChatModel;

class Chat extends BaseController
{
    public function open($organizationId)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');
        if(!$organizationId) return redirect()->to('organizations');

        $chatModel = new ChatModel();
        $orgModel = new OrganizationModel();
        $organization = $orgModel->getMyOrg($organizationId, $auth->get('id'));
        if(!$organization){
            $this->session->setFlashdata('warning', 'Maaf, anda belum terdaftar di organisasi ini.');
            return redirect()->to('organizations');
        }

        $chatModel->orderBy('chat.send_at', 'DESC');
        $chats = $chatModel->where('organization_member.organization_id', $organizationId)->findAll(30,0);

        $data['title'] = 'Chat '.$organization['title'];
        $data['org'] = $organization;
        $data['chat'] = array_reverse($chats);
        $data['user_id'] = $auth->get('id');
        $data['warning'] = $this->session->getFlashdata('warning');
        return view('chat/open', $data);
    }

}
