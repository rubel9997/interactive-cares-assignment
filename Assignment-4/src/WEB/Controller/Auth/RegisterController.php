<?php


namespace App\WEB\Controller\Auth;


use App\Common\Helper;
use App\WEB\Session;


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
        $name = $this->validation->validated($data['name']);
        $firstName = $this->validation->validated($data['first-name']);
        $lastName = $this->validation->validated($data['last-name']);
        $email = $this->validation->validated($data['email']);
        $password = $this->validation->validated($data['password']);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $user_exists = $this->userExists($email);

        $emailValidation = Helper::validateEmail($email);

        if($firstName && $lastName){

            if(empty($firstName)  || empty($lastName) || empty($email) || empty($password)){
                Session::set('error_message','All fields are required.');
                header("Location: /add-customer");
                exit();
            }
            if($user_exists){
                Session::set('error_message','This email has already exists.');
                header("Location: /add-customer");
                exit();
            }
            if(!$emailValidation){
                Session::set('error_message','Email must be valid.');
                header("Location: /add-customer");
                exit();
            }
            if(strlen($password) < 2){
                Session::set('error_message','Password must be at least 3 Character.');
                header("Location: /add-customer");
                exit();
            }
        }
        else{
            if(empty($name) || empty($email) || empty($password)){
                Session::set('error_message','All fields are required.');
                header("Location: /register_page");
                exit();
            }
            if($user_exists){
                Session::set('error_message','This email has already exists.');
                header("Location: /register_page");
                exit();
            }
            if(!$emailValidation){
                Session::set('error_message','Email must be valid.');
                header("Location: /register_page");
                exit();
            }
            if(strlen($password) < 2){
                Session::set('error_message','Password must be at least 3 Character.');
                header("Location: /register_page");
                exit();
            }
        }

        if($firstName && $lastName){
            $name = $firstName.' '.$lastName;
        }

        $sql = "INSERT INTO users (role,name,email,password) VALUES ('customer','$name','$email','$hashed_password')";

        try {
            $this->db->conn->exec($sql);

            if($firstName && $lastName){
                Session::set('success_message','User has been created successfully.');
                header("Location: /admin-dashboard");
                exit();
            }else{
                Session::set('success_message','Registration successfully.');
                header("Location: /");
                exit();
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}