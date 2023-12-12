<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use App\Controllers\BaseController;

use App\Libraries\Auth;
use App\Libraries\ImageResizer;
use App\Models\OrganizationModel;
use App\Models\OrganizationMemberModel;
use App\Models\ChatModel;

class Chat extends BaseController
{
    use ResponseTrait;

    public function send($organizationId = null)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return $this->failUnauthorized('Unauthorized');

        $text = $this->request->getVar('text');
        if(!$organizationId || !$text){
            return $this->failValidationError('Gagal mengirim pesan, silahkan coba kembali.');
        }

        $chatModel = new ChatModel();
        $orgModel = new OrganizationModel();
        $organization = $orgModel->getMyOrg($organizationId, $auth->get('id'));
        if(!$organization){
            return $this->failValidationError('Gagal mengirim pesan, silahkan coba kembali.');
        }

        $save = $chatModel->insert([
            'member_id' => $organization['member']['id'],
            'text' => $text
        ]);
        if(!$save){
            return $this->failValidationError('Gagal mengirim pesan, silahkan coba kembali.');
        }

        return $this->setResponseFormat('json')->respondCreated($chatModel->find($save));
    }
}