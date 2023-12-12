<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Auth;
use App\Models\PertemuanModel;
use App\Models\OrganizationModel;
use App\Models\OrganizationMemberModel;
use App\Models\PresensiModel;

class Pertemuan extends BaseController
{
    public function index()
    {
        
    }

    public function absensi($id)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $presensiModel = new PresensiModel();
        $orgModel = new OrganizationModel();
        $pertemuanModel = new PertemuanModel();
        $pertemuan = $pertemuanModel->find($id);
        if(!$pertemuan){
            return view('pages/not_found', ['title'=>'Page not found']);
        }

        $organization = $orgModel->getMyOrg($pertemuan['organization_id'], $auth->get('id'));
        if(!$organization){
            $this->session->setFlashdata('warning', 'Maaf, anda belum terdaftar di organisasi ini.');
            return redirect()->to('organizations');
        }

        $memberModel = new OrganizationMemberModel();
        $memberModel->select("IFNULL((SELECT presensi.status FROM presensi WHERE presensi.pertemuan_id = '$id' AND presensi.member_id = organization_member.id), '-') as presensi_status");
        $memberModel->where('organization_member.organization_id', $pertemuan['organization_id']);
        $memberModel->where('organization_member.status', 'verified');

        $data['title'] = $pertemuan['title'];
        $data['data'] = $pertemuan;
        $data['saya'] = $presensiModel->where('member_id', $organization['member']['id'])->where('pertemuan_id', $id)->first();
        $data['members'] = $memberModel->findAll();
        return view('pertemuan/absensi', $data);
    }

    public function absensi_save($id){
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');
        $status = $this->request->getVar('status') ?? 'A';

        $presensiModel = new PresensiModel();
        $orgModel = new OrganizationModel();
        $pertemuanModel = new PertemuanModel();
        $pertemuan = $pertemuanModel->find($id);
        if(!$pertemuan){
            return view('pages/not_found', ['title'=>'Page not found']);
        }

        $organization = $orgModel->getMyOrg($pertemuan['organization_id'], $auth->get('id'));
        if(!$organization){
            $this->session->setFlashdata('warning', 'Maaf, anda belum terdaftar di organisasi ini.');
            return redirect()->to('organizations');
        }

        $kehadiran = $presensiModel->where('member_id', $organization['member']['id'])->where('pertemuan_id', $id)->first();
        if($kehadiran){
            $save = $presensiModel->update([$kehadiran['id']], ['status' => $status]);
        }else{
            $save = $presensiModel->insert([
                'member_id' => $organization['member']['id'],
                'pertemuan_id' => $id,
                'status' => $status
            ]);
        }

        return redirect()->to('pertemuan/absensi/'.$id);
    }
}
