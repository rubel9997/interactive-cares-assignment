<?php


namespace App\Routes;


use App\Auth\AdminDashboardController;
use App\Auth\DashboardController;
use App\Auth\RegisterController;
use App\Auth\LoginController;
use App\Database\Migration;
use App\Repository\UserDBRepository;
use App\Service\UserService;
use App\Session;
use App\Storage\DB;



Router::get('clear',function (){
    clearstatcache();
    echo 'Cache Clear!';
});

//database migration
Router::get('migrate',function (){
    (new Migration(new DB))->run();
});



//login and register route

Router::get('',function (){

//    $id = $_GET['id'];
//    var_dump($id);

    (new LoginController())->getLoginPage();
});

Router::get('register_page',function (){
    (new RegisterController())->getRegisterPage();
});


Router::post('login',function (){
    (new LoginController())->login($_POST);
});

Router::post('register',function (){
    (new RegisterController())->register($_POST);
});

Router::get('logout',function (){
    (new LoginController())->logout();
});

//customer dashboard route

Router::get('dashboard',function (){
    (new DashboardController())->dashboardPage();
});

Router::get('deposit',function (){
    (new DashboardController())->depositPage();
});

Router::get('withdraw',function (){
    (new DashboardController())->withdrawPage();
});

Router::get('transfer',function (){
    (new DashboardController())->transferPage();
});

//admin dashboard

Router::get('admin-dashboard',function (){
    (new AdminDashboardController())->adminDashboardPage();
});

Router::get('add-customer',function (){
    (new AdminDashboardController())->addCustomer();
});

Router::get('transactions',function (){
    (new AdminDashboardController())->transaction();
});

Router::get('customer-transactions',function (){
    (new AdminDashboardController())->customerTransaction();
});

Router::post('customer-store',function (){
    (new UserService(new UserDBRepository()))->create($_POST);
});