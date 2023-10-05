<?php


namespace App\Auth;


use App\FileStorage;
use App\Session;

class RegisterController
{

    public function getRegisterPage()
    {
        if(!Session::get('login')){
            require_once __DIR__ . '/../Views/Auth/Register.php';
        }else{
            header("Location: /dashboard");
        }
    }

//    public function register(array $users)
//    {
//        $file_storage = new FileStorage();
//        $file_storage->save($users);
//    }
}