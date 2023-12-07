<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PertemuanModel;

class Pertemuan extends BaseController
{
    public function index()
    {
        
    }

    public function absensi($id)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $pertemuanModel = new PertemuanModel();
        $pertemuan = $pertemuanModel->find($id);
        if(!$pertemuan){
            return view('pages/not_found', ['title'=>'Page not found']);
        }

        $data['title'] = $pertemuan['title'];
        $data['data'] = $pertemuan;
        return view('pertemuan/absensi', $data);
    }
}
