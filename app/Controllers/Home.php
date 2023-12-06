<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrganizationModel;

class Home extends BaseController
{
    public function index()
    {
        $orgModel = new OrganizationModel();
        $data['orgs'] = $orgModel->where('organizations.status', 'verified')->findAll();
        return view('pages/home', $data);
    }

    public function login()
    {
        if(!$this->request->is('post')){
            $data['title'] = 'Login';
            $data['warning'] = $this->session->getFlashdata('warning') ?? null;
            return view('pages/login', $data);
        }

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];
        if(!$this->validate($rules)){
            $error = getErrors($this->validator->getErrors());
            $this->session->setFlashdata('warning', $error);
            return redirect()->back()->withInput();
        }

        $userModel = new UserModel();
        $validData = $this->validator->getValidated();
        $user = $userModel->login($validData['email'], $validData['password']);
        if($user){
            $this->session->set($user);
            return redirect()->to('profile');
        }
        $this->session->setFlashdata('warning', 'Email atau kata sandi yang Anda masukan tidak tepat!');
        return redirect()->back()->withInput();
    }

    public function registration()
    {
        if(!$this->request->is('post')){
            $data['title'] = 'Daftar Sekarang';
            $data['warning'] = $this->session->getFlashdata('warning') ?? null;
            return view('pages/registration', $data);
        }

        $rules = [
            'full_name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|max_length[20]',
            'password' => 'required',
            'password_conf' => 'required|matches[password]',
        ];
        if(!$this->validate($rules)){
            $error = getErrors($this->validator->getErrors());
            $this->session->setFlashdata('warning', $error);
            return redirect()->back()->withInput();
        }

        $userModel = new UserModel();
        $validData = $this->validator->getValidated();
        unset($validData['password_conf']);

        $id = $userModel->insert($validData);
        if(!$id){
            $this->session->setFlashdata('warning', 'Pendaftaran gagal, silahkan coba kembali.');
            return redirect()->back()->withInput();
        }

        $user = $userModel->where('id', $id)->first();
        if($user){
            $this->session->set($user);
            return redirect()->to('profile');
        }
        $this->session->setFlashdata('warning', 'Pendaftaran berhasil, silahkan untuk masuk.');
        return redirect()->to('login');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('login');
    }
}
