<?php 
namespace App\Libraries;
class Auth {
    private $isLogin = false;
    private $data = null;
    private $session = null;

    public function __construct(){
        $this->session = session();
        if($this->session->get('id') ?? false){
            $this->isLogin = true;
        }
    }

    public function isLogin(){
        return $this->isLogin;
    }

    public function isAdmin(){
        if(!$this->isLogin) return null;

        return ($this->session->get('role') ?? null) == 'admin';
    }

    public function get($key){
        if(!$this->isLogin) return null;

        return $this->session->get($key) ?? null;
    }

}
?>