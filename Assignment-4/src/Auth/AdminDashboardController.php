<?php


namespace App\Auth;


use App\Session;

class AdminDashboardController
{
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
}