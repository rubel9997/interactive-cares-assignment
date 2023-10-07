<?php

namespace App\Repository;


use App\Auth\RegisterController;
use App\Session;
use App\Storage\DB;
use App\Validation;
use PDO;

class UserDBRepository implements Repository
{
    private DB $db;
    private Validation $validation;

    public function __construct()
    {
        $this->db = new DB();
        $this->validation = new Validation();

    }

    public function get(){

    }

    public function insert(array $data){

        $name = $this->validation->validated($data['name']);
        $firstName = $this->validation->validated($data['first-name']);
        $lastName = $this->validation->validated($data['last-name']);
        $email = $this->validation->validated($data['email']);
        $password = $this->validation->validated($data['password']);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $user_exists = (new RegisterController())->userExists($email);

        if(empty($firstName) || empty($lastName) || empty($email) || empty($password)){
            Session::set('error_message','All fields are required.');
            header("Location: /add-customer");
            exit();
        }

        if($user_exists){
            Session::set('error_message','This email has already exists.');
            header("Location: /add-customer");
            exit();
        }
        if(strlen($password) < 2){
            Session::set('error_message','Password must be at least 3 Character.');
            header("Location: /add-customer");
            exit();
        }

        $name = $firstName.' '.$lastName;

        $sql = "INSERT INTO users (role,name,email,password) VALUES ('customer','$name','$email','$hashed_password')";
        $this->db->insertData($sql);
    }

    public function update(){

    }

    public function delete(){

    }



}