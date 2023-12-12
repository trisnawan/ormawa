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

class Org extends BaseController
{
    use ResponseTrait;

    public function list()
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return $this->failUnauthorized('Unauthorized');

        $status = $this->request->getVar('status');
        $search = $this->request->getVar('search');
        $offset = $this->request->getVar('offset') ?? 0;

        $orgModel = new OrganizationModel();
        if(in_array($status, ['verifing', 'verified', 'blocked'])){
            $orgModel->where('organizations.status', $status);
        }
        if($search){
            $orgModel->like('organizations.title', $search, 'both');
        }
        $data = $orgModel->findAll(20, $offset ?? 0);

        $response['result'] = $data;
        $response['query']['status'] = $status;
        $response['query']['search'] = $search;
        $response['query']['offset'] = $offset;

        return $this->setResponseFormat('json')->respondCreated($response);
    }

    public function detail()
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return $this->failUnauthorized('Unauthorized');

        $id = $this->request->getVar('id');
        if(!$id){
            return $this->failValidationError('ID harus di isi.');
        }

        $orgModel = new OrganizationModel();
        return $this->setResponseFormat('json')->respondCreated($orgModel->find($id));
    }

    public function verify()
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return $this->failUnauthorized('Unauthorized');

        $id = $this->request->getVar('id');
        $status = $this->request->getVar('status');
        if(!$id || !$status){
            return $this->failValidationError('ID dan STATUS harus di isi.');
        }

        $orgModel = new OrganizationModel();
        $update = $orgModel->update([$id], ['status' => $status]);
        if($update){
            return $this->setResponseFormat('json')->respondCreated(['status'=>200]);
        }

        return $this->failValidationError('Failed.');
    }
}