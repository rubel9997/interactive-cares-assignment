<?php

namespace App\WEB\Storage;

use App\WEB\Session;
use PDO;
use PDOException;


class DB
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $databaseName = "bank_app";
    public PDO $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->databaseName", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function createTable(string $sql){
        try{
            $this->conn->exec($sql);
            echo "Database migrated successfully";
        }catch(PDOException $exception){
            echo $exception->getMessage();
        }
    }

    
}
