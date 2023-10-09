<?php


namespace App\WEB\Controller\Auth;


use App\Common\Repository\UserDBRepository;
use App\Common\Service\UserService;
use App\Common\Validation;
use App\WEB\Session;
use App\WEB\Storage\DB;


class RegisterController extends  AuthController
{

    public function getRegisterPage()
    {
        if(!Session::get('login')){
            require_once __DIR__ . '/../../Views/Auth/Register.php';
        }else{
            if(Session::get('role') == 'admin'){
                header("Location: /admin-dashboard");
            }else{
                header("Location: /dashboard");
            }

        }
    }

    public function register(array $data)
    {
        $this->user_service->create($data);
    }

}