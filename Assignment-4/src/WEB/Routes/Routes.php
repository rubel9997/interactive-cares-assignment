<?php


namespace App\Routes;


use App\Common\Repository\UserDBRepository;
use App\Common\Service\UserService;
use App\Common\UserRole;
use App\WEB\Controller\AdminDashboardController;
use App\WEB\Controller\Auth\LoginController;
use App\WEB\Controller\Auth\RegisterController;
use App\WEB\Controller\DashboardController;
use App\WEB\Controller\DepositController;
use App\WEB\Controller\WithdrawController;
use App\WEB\Database\Migration;
use App\WEB\Routes\Router;
use App\WEB\Session;
use App\WEB\Storage\DB;


Router::get('xclean',function (){
    clearstatcache();
    echo 'Cache Clear!';
});

//database migration
Router::get('migrate',function (){
    (new Migration(new DB))->run();
});

//login and register route
Router::get('',function (){

    (new LoginController())->getLoginPage();
});

Router::post('login',function (){
    (new LoginController())->login($_POST);
});

//Register route
Router::get('register_page',function (){
    (new RegisterController())->getRegisterPage();
});

Router::post('register',function (){
    (new RegisterController())->register($_POST);
});

//logout route
Router::get('logout',function (){
    (new LoginController())->logout();
});



//customer dashboard route
Router::get('dashboard',function (){
    if(Session::get('login') && Session::get('role') == UserRole::CUSTOMER){
        (new DashboardController())->dashboardPage();
    }else{
        header("Location: /");
    }

});

Router::get('deposit',function (){
    if(Session::get('login') && Session::get('role') == UserRole::CUSTOMER){
        (new DashboardController())->depositPage();
    }else{
        header("Location: /");
    }
});

Router::get('withdraw',function (){

    if(Session::get('login') && Session::get('role') == UserRole::CUSTOMER){
        (new DashboardController())->withdrawPage();
    }else{
        header("Location: /");
    }
});

Router::get('transfer',function (){

    if(Session::get('login') && Session::get('role') == UserRole::CUSTOMER){
        (new DashboardController())->transferPage();
    }else{
        header("Location: /");
    }
});



//deposit route
Router::post('add-deposit',function (){

    if(Session::get('login') && Session::get('role') == UserRole::CUSTOMER){
        (new DepositController())->addDeposit($_POST);
    }else{
        header("Location: /");
    }

});

//withdraw route
Router::post('add-withdraw',function (){

    if(Session::get('login') && Session::get('role') == UserRole::CUSTOMER){
        (new WithdrawController())->addWithdraw($_POST);
    }else{
        header("Location: /");
    }

});

//fund transfer route
Router::post('fund-transfer',function (){

    if(Session::get('login') && Session::get('role') == UserRole::CUSTOMER){
        (new WithdrawController())->fundTransfer($_POST);
    }else{
        header("Location: /");
    }

});


//admin dashboard
Router::get('admin-dashboard',function (){

    if(Session::get('login') && Session::get('role') == UserRole::ADMIN){
        (new AdminDashboardController())->adminDashboardPage();
    }else{
        header("Location: /");
    }
});

Router::get('add-customer',function (){

    if(Session::get('login') && Session::get('role') == UserRole::ADMIN){
        (new AdminDashboardController())->addCustomer();
    }else{
        header("Location: /");
    }

});

Router::get('transactions',function (){

    if(Session::get('login') && Session::get('role') == UserRole::ADMIN){
        (new AdminDashboardController())->transaction();
    }else{
        header("Location: /");
    }
});

Router::get('customer-transactions',function (){

    if(Session::get('login') && Session::get('role') == UserRole::ADMIN){
        (new AdminDashboardController())->customerTransaction();
    }else{
        header("Location: /");
    }

});

Router::post('customer-store',function (){

    if(Session::get('login') && Session::get('role') == UserRole::ADMIN){
        (new UserService(new UserDBRepository()))->create($_POST);
    }else{
        header("Location: /");
    }

});
