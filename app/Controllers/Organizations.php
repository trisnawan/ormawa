<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Auth;
use App\Libraries\ImageResizer;
use App\Models\OrganizationModel;
use App\Models\OrganizationMemberModel;
use App\Models\TagihanModel;
use App\Models\UserModel;
use App\Models\TransaksiModel;

class Organizations extends BaseController
{
    public function index()
    {
        $data['title'] = 'Organisasi';
        $data['warning'] = $this->session->getFlashdata('warning');
        return view('organization/main', $data);
    }

    public function list()
    {
        $orgModel = new OrganizationModel();
        $data['title'] = 'Join Organisasi';
        $data['orgs'] = $orgModel->where('organizations.status', 'verified')->findAll();
        $data['warning'] = $this->session->getFlashdata('warning');
        return view('organization/list', $data);
    }

    public function desc($id)
    {
        $orgModel = new OrganizationModel();
        $organization = $orgModel->find($id);
        if(!$organization){
            return redirect()->to('organizations/list');
        }

        $data['org'] = $organization;
        $data['title'] = $data['org']['title'] ?? 'Join Organisasi';
        $data['warning'] = $this->session->getFlashdata('warning');
        return view('organization/desc', $data);
    }

    public function join($id)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $orgModel = new OrganizationModel();
        $organization = $orgModel->find($id);
        if(!$organization){
            return redirect()->to('organizations/list');
        }

        if(!$this->request->is('post')){
            $data['org'] = $organization;
            $data['title'] = $data['org']['title'] ?? 'Join Organisasi';
            $data['warning'] = $this->session->getFlashdata('warning');
            return view('organization/join', $data);
        }

        $member['position'] = $this->request->getVar('position') ?? 'Anggota';
        $member['user_id'] = $auth->get('id');
        $member['organization_id'] = $id;
        $member['role'] = 'member';
        $memberModel = new OrganizationMemberModel();
        $saving = $memberModel->insert($member);
        if(!$saving){
            $this->session->setFlashdata('warning', 'Pendaftaran gagal, silahkan coba kembali');
            return redirect()->back();
        }

        return redirect()->to('organizations/dashboard/'.$id);
    }

    public function registration()
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $orgModel = new OrganizationModel();
        $organization = $orgModel->where('user_id', $auth->get('id'))->first();
        if($organization) return redirect()->to('organizations/dashboard/'.$organization['id']);

        if(!$this->request->is('post')){
            $data['title'] = 'Daftarkan Organisasi';
            $data['warning'] = $this->session->getFlashdata('warning');
            return view('organization/registration', $data);
        }

        $rules = [
            'title' => 'required|max_length[120]',
            'avatar' => 'uploaded[avatar]|is_image[avatar]',
            'description' => 'required',
            'legal_doc' => 'uploaded[legal_doc]|ext_in[legal_doc,pdf,jpg,png]'
        ];
        if(!$this->validate($rules)){
            $this->session->setFlashdata('warning', getErrors($this->validator->getErrors()));
            return redirect()->to('organizations/registration');
        }

        $validData = $this->validator->getValidated();
        $validData['user_id'] = $auth->get('id');
        $id = $orgModel->insert($validData);
        if(!$id){
            $this->session->setFlashdata('warning', 'Kegagalan, silahkan coba kembali lagi');
            return redirect()->to('organizations/registration');
        }

        $memberModel = new OrganizationMemberModel();
        $memberModel->insert([
            'user_id' => $auth->get('id'),
            'organization_id' => $id,
            'role' => 'admin',
            'position' => 'Pemilik Organisasi',
            'status' => 'verified'
        ]);

        if(!is_dir('content')) mkdir('content');
        if(!is_dir('content/organization')) mkdir('content/organization');
        if(!is_dir('content/organization/avatar')) mkdir('content/organization/avatar');
        if(!is_dir('content/organization/doc')) mkdir('content/organization/doc');

        $ext = explode('.', $_FILES['avatar']['name']);
        $ext = end($ext);
        $fileLogo = uniqid('', true).'.'.$ext;

        $resizer = new ImageResizer($_FILES['avatar']['tmp_name']);
        $resizer->maxWidth(900);
        $resizer->writeImage('content/organization/avatar/'.$fileLogo);
        $orgModel->update([$id], ['avatar'=>$fileLogo]);

        $ext = explode('.', $_FILES['legal_doc']['name']);
        $ext = end($ext);
        $fileDoc = uniqid('', true).'.'.$ext;

        $save = move_uploaded_file($_FILES['legal_doc']['tmp_name'], 'content/organization/doc/'.$fileDoc);
        if(!$save){
            $orgModel->delete([$id]);
            @unlink('content/organization/doc/'.$fileLogo);
            $this->session->setFlashdata('warning', 'Kegagalan, silahkan coba kembali lagi.');
            return redirect()->to('organizations/registration');
        }
        $orgModel->update([$id], ['legal_doc'=>$fileDoc]);

        return redirect()->to('organizations/dashboard/'.$id);
    }

    public function dashboard($organizationId = null)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');
        if(!$organizationId) return redirect()->to('organizations');

        $orgModel = new OrganizationModel();
        $tagihanModel = new TagihanModel();
        $pertemuanModel = new \App\Models\PertemuanModel();
        $pertemuanModel->where('DATE(start_at) >= DATE(NOW())');

        $organization = $orgModel->getMyOrg($organizationId, $auth->get('id'));
        if(!$organization){
            $this->session->setFlashdata('warning', 'Maaf, anda belum terdaftar di organisasi ini.');
            return redirect()->to('organizations');
        }

        $data['title'] = $organization['title'];
        $data['data'] = $organization;
        $data['tagihan'] = $tagihanModel->where('organization_id', $organization['id'])->findAll();
        $data['acara'] = $pertemuanModel->where('organization_member.organization_id', $organization['id'])->findAll();
        $data['warning'] = $this->session->getFlashdata('warning');
        $data['success'] = $this->session->getFlashdata('success');
        if($organization['member']['role'] == 'admin'){
            $memberModel = new OrganizationMemberModel();
            $memberModel->where('organization_member.organization_id', $organizationId);
            $data['verifing_member'] = $memberModel->where('organization_member.status', 'verifing')->findAll(20,0);
        }
        return view('organization/dashboard', $data);
    }

    public function members($organizationId = null)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');
        if(!$organizationId) return redirect()->to('organizations');

        $orgModel = new OrganizationModel();
        $tagihanModel = new TagihanModel();

        $organization = $orgModel->getMyOrg($organizationId, $auth->get('id'));
        if(!$organization){
            $this->session->setFlashdata('warning', 'Maaf, anda belum terdaftar di organisasi ini.');
            return redirect()->to('organizations');
        }

        $data['title'] = 'Anggota '.$organization['title'];
        $data['warning'] = $this->session->getFlashdata('warning');
        $data['success'] = $this->session->getFlashdata('success');
        $memberModel = new OrganizationMemberModel();
        $memberModel->where('organization_member.organization_id', $organizationId);
        $data['members'] = $memberModel->where('organization_member.status', 'verified')->findAll(20,0);
        return view('organization/members', $data);
    }

    public function member_fragment($id)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return "Unauthentication";

        $memberModel = new OrganizationMemberModel();
        $userModel = new UserModel();
        $data['member'] = $memberModel->find($id);
        if(!$data['member']){
            return "User not found!";
        }
        $data['user'] = $userModel->find($data['member']['user_id']);
        return view('organization/member_fragment', $data);
    }

    public function terima($organizationId)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');
        if(!$organizationId) return redirect()->to('organizations');

        $orgModel = new OrganizationModel();
        $memberModel = new OrganizationMemberModel();

        $organization = $orgModel->getMyOrg($organizationId, $auth->get('id'));
        if($organization['member']['role'] != 'admin'){
            $this->session->setFlashdata('warning', 'Maaf, anda tidak memiliki akses.');
            return redirect()->to('organizations/dashboard/'.$organizationId);
        }

        $rules = [
            'role' => 'required|in_list[member,admin]',
            'position' => 'required',
        ];
        if(!$this->validate($rules)){
            $this->session->setFlashdata('warning', getErrors($this->validator->getErrors()));
            return redirect()->to('organizations/registration');
        }

        $validData = $this->validator->getValidated();
        $validData['status'] = 'verified';
        $memberId = $this->request->getVar('id');

        $update = $memberModel->update($memberId, $validData);
        if($update){
            $this->session->setFlashdata('success', 'Penerimaan anggota berhasil.');
        }else{
            $this->session->setFlashdata('warning', 'Penerimaan anggota gagal, silahkan coba kembali.');
        }

        return redirect()->to('organizations/dashboard/'.$organizationId);
    }

    public function tolak($organizationId)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');
        if(!$organizationId) return redirect()->to('organizations');

        $orgModel = new OrganizationModel();
        $memberModel = new OrganizationMemberModel();

        $organization = $orgModel->getMyOrg($organizationId, $auth->get('id'));
        if($organization['member']['role'] != 'admin'){
            $this->session->setFlashdata('warning', 'Maaf, anda tidak memiliki akses.');
            return redirect()->to('organizations/dashboard/'.$organizationId);
        }

        $validData['status'] = 'blocked';
        $memberId = $this->request->getVar('id');

        $update = $memberModel->update($memberId, $validData);
        if($update){
            $this->session->setFlashdata('success', 'Penolakan anggota berhasil.');
        }else{
            $this->session->setFlashdata('warning', 'Penolakan anggota gagal, silahkan coba kembali.');
        }

        return redirect()->to('organizations/dashboard/'.$organizationId);
    }

    public function kas_create()
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $rules = [
            'organization_id' => 'required',
            'title' => 'required',
            'amount' => 'required',
        ];
        if(!$this->validate($rules)){
            $this->session->setFlashdata('warning', getErrors($this->validator->getErrors()));
            return redirect()->back();
        }

        $validData = $this->validator->getValidated();
        $tagihanModel = new TagihanModel();
        $saving = $tagihanModel->insert($validData);
        if($saving){
            $this->session->setFlashdata('success', 'Tagihan has berhasil disimpan.');
        }else{
            $this->session->setFlashdata('warning', 'Tagihan kas gagal disimpan, silahkan coba kembali.');
        }
        return redirect()->to('organizations/dashboard');
    }

    public function tagihan($organizationId)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $tagihanId = $this->request->getVar('id') ?? $this->request->getVar('tagihan_id');
        $tagihanModel = new TagihanModel();
        $tagihan = $tagihanModel->find($tagihanId);

        if(!$this->request->is('post')){
            $memberModel = new OrganizationMemberModel();
            $memberModel->select("IFNULL((SELECT transaksi.status FROM transaksi WHERE transaksi.tagihan_id = '$tagihanId' AND transaksi.member_id = organization_member.id), 'none') as transaction_status");
            $memberModel->where('organization_member.organization_id', $organizationId);
            $memberModel->where('organization_member.status', 'verified');
            
            $data['tagihan'] = $tagihan;
            $data['members'] = $memberModel->findAll();
            $data['title'] = $data['tagihan']['title'] ?? 'Tagihan Dana Kas';
            $data['warning'] = $this->session->getFlashdata('warning');
            $data['success'] = $this->session->getFlashdata('success');
            return view('organization/tagihan', $data);
        }

        $rules = [
            'tagihan_id' => 'required',
            'payment' => 'required|in_list[online,offline]',
        ];
        if(!$this->validate($rules)){
            $this->session->setFlashdata('warning', getErrors($this->validator->getErrors()));
            return redirect()->back();
        }

        $orgModel = new OrganizationModel();
        $organization = $orgModel->getMyOrg($organizationId, $auth->get('id'));
        $validData = $this->validator->getValidated();
        $validData['member_id'] = $organization['member']['id'] ?? null;
        $validData['type'] = 'income';
        $validData['amount'] = $tagihan['amount'];

        if(!($organization['member']['id'] ?? false)){
            $this->session->setFlashdata('warning', 'Pembayaran gagal, silahkan coba kembali.');
            return redirect()->back();
        }

        if($validData['payment'] == 'online'){
            // ONLINE PAYMENT
            $paymentTerminal = new \App\Libraries\PaymentTerminal($validData['amount'], $organization['title'], $tagihan['title']);
            $paymentTerminal->setPayment([
                'id' => 'payment-link',
                'iss_code' => 'payment-link',
                'endpoint' => 'payment-link',
                'status' => 'active'
            ]);
            $paymentTerminal->setLink(base_url('tagihan/detail/'.$tagihanId));
            $paymentResult = $paymentTerminal->createPayment($tagihanId);
            if($paymentResult['gateway_code'] ?? false){
                $validData['gateway_code'] = $paymentResult['gateway_code'];
                $redirect = $paymentResult['payment_link'] ?? null;
            }
        }

        $transaksiModel = new TransaksiModel();
        $transaksi = $transaksiModel->where('transaksi.tagihan_id', $tagihanId)->first();
        if($transaksi){
            $save = $transaksiModel->update($transaksi['id'], $validData);
            if(!$save){
                $this->session->setFlashdata('warning', 'Pembayaran gagal, silahkan coba kembali.');
            }
        }else{
            $save = $transaksiModel->insert($validData);
            if(!$save){
                $this->session->setFlashdata('warning', 'Pembayaran gagal, silahkan coba kembali.');
            }
        }

        if(($redirect ?? false) && ($save ?? false)){
            return redirect()->to($redirect);
        }
        return redirect()->to('organizations/tagihan/'.$organizationId.'?id='.$tagihanId);
    }

    public function tagihan_view($tagihanId, $memberId){
        $auth = new Auth();
        if(!$auth->isLogin()) return 'Unauthorization';

        $tagihanModel = new TagihanModel();
        $tagihan = $tagihanModel->getTagihan($tagihanId, $memberId);

        return view('organization/tagihan_view', [
            'tagihan' => $tagihan
        ]);
    }

    public function tagihan_verify($status){
        $auth = new Auth();
        if(!$auth->isLogin()) return 'Unauthorization';

        $id = $this->request->getVar('id');
        $transaksiModel = new TransaksiModel();

        if($status == 'paid' && $id){
            $save = $transaksiModel->update([$id], ['status' => 'paid']);
        }

        if($status == 'unpaid' && $id){
            $save = $transaksiModel->update([$id], ['status' => 'unpaid']);
        }

        if($save ?? false){
            $this->session->setFlashdata('success', 'Transaksi berhasil di update');
        }else{
            $this->session->setFlashdata('warning', 'Transaksi gagal di update, silahkan coba kembali');
        }

        return redirect()->back();
    }

    public function kegiatan_create()
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $rules = [
            'member_id' => 'required',
            'title' => 'required',
            'start_time' => 'required',
            'start_date' => 'required',
            'end_time' => 'required',
            'end_date' => 'required',
            'location' => 'required',
        ];
        if(!$this->validate($rules)){
            $this->session->setFlashdata('warning', getErrors($this->validator->getErrors()));
            return redirect()->back();
        }

        $validData = $this->validator->getValidated();
        $validData['start_at'] = date('Y-m-d', strtotime($validData['start_date'])) . ' ' . date('H:i:s', strtotime($validData['start_time']));
        $validData['end_at'] = date('Y-m-d', strtotime($validData['end_date'])) . ' ' . date('H:i:s', strtotime($validData['end_time']));
        unset($validData['start_date']);
        unset($validData['start_time']);
        unset($validData['end_date']);
        unset($validData['end_time']);

        $pertemuanModel = new \App\Models\PertemuanModel();
        $saved = $pertemuanModel->insert($validData);
        if($saved ?? false){
            $this->session->setFlashdata('success', 'Kegiatan berhasil di tambahkan');
            return redirect()->to('pertemuan/absensi/'.$saved);
        }else{
            $this->session->setFlashdata('warning', 'Kegiatan gagal di tambahkan, silahkan coba kembali');
        }
        return redirect()->to('organizations/dashboard');
    }
}
