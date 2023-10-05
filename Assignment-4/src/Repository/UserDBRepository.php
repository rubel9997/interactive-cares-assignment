<?php

namespace App\Repository;


use App\Session;
use App\Storage\DB;
use PDO;

class UserDBRepository implements Repository
{
    private DB $db;

    public function __construct()
    {
        $this->db = new DB();

    }

    public function get(){

    }

    public function insert(array $data){

        $name = htmlspecialchars($data['name']);
        $email = htmlspecialchars($data['email']);
        $password = htmlspecialchars($data['password']);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $user_exists = $this->userExists($email);

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
        if(strlen($password) < 2){
            Session::set('error_message','Password must be at least 3 Character.');
            header("Location: /register_page");
            exit();
        }

        $sql = "INSERT INTO users (role,name,email,password) VALUES ('customer','$name','$email','$hashed_password')";
        $this->db->insertData($sql);
    }



    public function update(){

    }

    public function delete(){

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