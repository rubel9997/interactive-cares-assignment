<?php


namespace App\Auth;


use App\Session;

class DashboardController
{

    public function dashboardPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Customer/customer-dashboard.php';
        }else{
          header('Location: /');
        }
    }

    public function depositPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Customer/deposit.php';
        }else{
            header('Location: /');
        }

    }

    public function withdrawPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Customer/withdraw.php';
        }else{
            header('Location: /');
        }

    }

    public function transferPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Customer/transfer.php';
        }else{
            header('Location: /');
        }

    }
}