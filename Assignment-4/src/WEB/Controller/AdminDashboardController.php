<?php
declare(strict_types=1);

namespace App\WEB\Controller;

use App\WEB\Storage\DB;
use PDO;


class AdminDashboardController
{
    private DB $db;
    public function __construct()
    {
        $this->db = new DB();
    }

    public function adminDashboardPage():void
    {
        require_once __DIR__ . '/../../WEB/Views/Admin/customers.php';
    }

    public function addCustomer():void
    {
        require_once __DIR__ . '/../../WEB/Views/Admin/add_customer.php';
    }

    public function transaction():void
    {
        require_once __DIR__ . '/../../WEB/Views/Admin/transactions.php';
    }

    public function customerTransaction():void
    {
        require_once __DIR__ . '/../../WEB/Views/Admin/customer_transactions.php';
    }

    public function getCustomer(string $id):array
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $statement = $this->db->conn->prepare($query);
        $statement->execute([$id]);

        return $statement->fetch(); //PDO::FETCH_ASSOC - PDO::FETCH_OBJ
    }

    public function getCustomerList():array
    {
        $query = "SELECT * FROM users WHERE role = 'customer'";
        $statement = $this->db->conn->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
    }
}