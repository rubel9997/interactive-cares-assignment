<?php

declare(strict_types=1);

namespace App\WEB\Controller\Auth;


use App\Common\Validation;
use App\WEB\Storage\DB;
use PDO;

class AuthController
{
    protected DB $db;
    protected Validation $validation;

    public function __construct()
    {
        $this->db = new DB();
        $this->validation = new Validation();

    }

    public function userExists(string $email):bool
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