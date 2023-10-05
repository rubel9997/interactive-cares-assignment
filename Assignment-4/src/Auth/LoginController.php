<?php

namespace App\Auth;


use App\Helper;
use App\Session;
use App\Storage\DB;
use PDO;

class LoginController
{

    private DB $db;
    public function __construct()
    {
        $this->db = new DB();
    }


    public function getLoginPage()
    {
        if(!Session::get('login')){
            require_once __DIR__ . '/../Views/Auth/Login.php';
        }else{
            header("Location: /dashboard");
        }
    }

    public function login(array $data)
    {
        $email = htmlspecialchars($data['email']);
        $password = htmlspecialchars($data['password']);

        if (!Helper::validateEmail($email)) {
            Session::set('error_message','Invalid email');
            header("Location: /");
            exit();
        }


        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($password, $result['password'])) {

                Session::set('user_id',$result['id']);
                Session::set('name',$result['name']);
                Session::set('email',$result['email']);
                Session::set('success_message','Login successfully!');
                Session::set('login',true);
                if($result['role'] == 'admin'){
                    header("Location: /admin-dashboard");
                }else{
                    header("Location: /dashboard");
                }
                exit();

            } else {
                Session::set('error_message','Password does not match!');
                header("Location: /");
                exit();
            }
        } else {
            Session::set('error_message','This user does not exists our records.');
            header("Location: /");
            exit();
        }
    }

    public function logout(){
        Session::destroy();
        header("Location: /");
        exit();
    }

}