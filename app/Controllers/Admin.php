<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Auth;

use App\Models\OrganizationModel;
use App\Models\OrganizationMemberModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function index()
    {
        $auth = new Auth();
        if(!$auth->isAdmin()) return redirect()->to('login');

        $orgModel = new OrganizationModel();
        $orgMemberModel = new OrganizationMemberModel();
        $userModel = new UserModel();

        $data['title'] = 'Dasbor Admin';
        $data['warning'] = $this->session->getFlashdata('warning');
        $data['statistik'] = [
            [
                'title' => 'Total Organisasi',
                'rows' => $orgModel->where('organizations.status', 'verified')->countAllResults()
            ],
            [
                'title' => 'Total Anggota Organisasi',
                'rows' => $orgMemberModel->where('organization_member.status', 'verified')->countAllResults()
            ],
            [
                'title' => 'Total Akun Pengguna',
                'rows' => $userModel->where('users.role', 'member')->countAllResults()
            ]
        ];
        return view('admin/dasbor', $data);
    }
}
