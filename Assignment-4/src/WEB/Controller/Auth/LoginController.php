<?php

namespace App\WEB\Controller\Auth;


use App\Common\Helper;
use App\Common\Repository\UserDBRepository;
use App\Common\Service\UserService;
use App\WEB\Session;
use App\WEB\Storage\DB;
use PDO;

class LoginController extends  AuthController
{


    public function getLoginPage()
    {
        if(!Session::get('login')){
            require_once __DIR__ . '/../../Views/Auth/Login.php';
        }else{
            if(Session::get('role') == 'admin'){
                header("Location: /admin-dashboard");
            }else{
                header("Location: /dashboard");
            }

        }
    }

    public function login(array $data)
    {
        $this->user_service->getCustomer($data);
    }

    public function logout(){
        Session::destroy();
        header("Location: /");
        exit();
    }

}