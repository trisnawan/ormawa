<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Auth;
use App\Models\UserModel;
use App\Models\OrganizationMemberModel;

class Profile extends BaseController
{
    public function index()
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $userModel = new UserModel();
        $memberModel = new OrganizationMemberModel();
        $data['title'] = 'Profile';
        $data['profile'] = $userModel->find($auth->get('id'));
        $data['orgs'] = $memberModel->where('organization_member.user_id', $auth->get('id'))->findAll();
        $data['warning'] = $this->session->getFlashdata('warning');
        $data['success'] = $this->session->getFlashdata('success');
        return view('account/profile', $data);
    }

    public function update_save()
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $rules = [
            'full_name' => 'required|max_length[120]',
            'phone' => 'required',
            'gender' => 'required|in_list[male,female]',
        ];
        if(!$this->validate($rules)){
            $this->session->setFlashdata('warning', getErrors($this->validator->getErrors()));
            return redirect()->to('profile');
        }

        $validData = $this->validator->getValidated();
        $userModel = new UserModel();
        $saving = $userModel->update([$auth->get('id')], $validData);
        if($saving){
            $this->session->setFlashdata('success', 'Profile berhasil di ubah.');
        }else{
            $this->session->setFlashdata('warning', 'Profile gagal di ubah, silahkan coba kembali.');
        }
        return redirect()->to('profile');
    }
}
