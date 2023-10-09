<?php

namespace App\Common\Repository;


use App\Common\Helper;
use App\Common\Validation;
use App\WEB\Controller\Auth\RegisterController;
use App\WEB\Session;
use App\WEB\Storage\DB;
use PDO;
use PDOException;

class UserDBRepository implements UserRepository
{
    private DB $db;
    private Validation $validation;

    public function __construct()
    {
        $this->db = new DB();
        $this->validation = new Validation();

    }

    public function get($data){

        $email = $this->validation->validated($data['email']);
        $password = $this->validation->validated($data['password']);

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
                Session::set('role',$result['role']);
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

    public function save(array $data){

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


    public function userExists(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }


}