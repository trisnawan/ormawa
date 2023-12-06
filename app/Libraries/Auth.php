<?php 
namespace App\Libraries;
class Auth {
    private $isLogin = false;
    private $data = null;

    public function __construct(){
        $session = session();
        if($session->get('id') ?? false){
            $this->isLogin = true;
        }
    }

    public function isLogin(){
        return $this->isLogin;
    }

    public function get($key){
        if(!$this->isLogin) return null;

        $session = session();
        return $session->get($key) ?? null;
    }

}
?>