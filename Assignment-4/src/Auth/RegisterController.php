<?php


namespace App\Auth;


use App\FileStorage;
use App\Helper;
use App\Session;
use App\Storage\DB;
use App\Validation;
use PDOException;
use PDO;


class RegisterController
{
    private DB $db;
    private Validation $validation;

    public function __construct()
    {
        $this->db = new DB();
        $this->validation = new Validation();

    }
    public function getRegisterPage()
    {
        if(!Session::get('login')){
            require_once __DIR__ . '/../Views/Auth/Register.php';
        }else{
            header("Location: /dashboard");
        }
    }

    public function register(array $data)
    {
//        $file_storage = new FileStorage();
//        $file_storage->save($users);

        $name = $this->validation->validated($data['name']);
        $email = $this->validation->validated($data['email']);
        $password = $this->validation->validated($data['password']);

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
//        $this->db->insertData($sql);

        try {
            $this->db->conn->exec($sql);
            Session::set('success_message','Registration successfully.');
            header("Location: /");
            exit();
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