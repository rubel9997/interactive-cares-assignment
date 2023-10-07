<?php


namespace App\Auth;

use App\Session;
use App\Storage\DB;
use PDO;


class AdminDashboardController
{
    private DB $db;
    public function __construct()
    {
        $this->db = new DB();
    }

    public function adminDashboardPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Admin/customers.php';
        }else{
            header('Location: /');
        }
    }

    public function addCustomer()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Admin/add_customer.php';
        }else{
            header('Location: /');
        }
    }

    public function transaction()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Admin/transactions.php';
        }else{
            header('Location: /');
        }
    }

    public function customerTransaction()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Admin/customer_transactions.php';
        }else{
            header('Location: /');
        }
    }

    public function getCustomer($id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $statement = $this->db->conn->prepare($query);
        $statement->execute([$id]);

        return $statement->fetchAll(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
    }

    public function getCustomers()
    {
        $query = "SELECT * FROM users WHERE role = 'customer'";
        $statement = $this->db->conn->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
    }
}