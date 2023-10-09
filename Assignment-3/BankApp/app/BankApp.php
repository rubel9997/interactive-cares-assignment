<?php


namespace App;

use App\AdminManager;
use App\CustomerManager;

class BankApp
{
    private CustomerManager $customerManager;
    private AdminManager $adminManager;

    private const LOGIN=1;
    private const REGISTER=2;

    private array $loginCredentials = [
        self::LOGIN =>"Login",
        self::REGISTER => "Register"
    ];

    public function __construct()
    {
        $this->customerManager= new CustomerManager(new FileStorage());

       $this->adminManager= new AdminManager(new FileStorage());
    }


    public function run():void
    {
        while(true){

            foreach ($this->loginCredentials as $option=>$label){
                printf("%d. %s\n",$option,$label);
            }

            $chooseOption = intval(readline("Enter option: "));

            switch ($chooseOption){

                case self::LOGIN:
                    $email = trim(readline("Enter your email: "));
                    $password = trim(readline("Enter your password: "));
                    $this->customerManager->login($email,$password);
                    break;

                case self::REGISTER:
                    $name = trim(readline("Enter your name: "));
                    $email = trim(readline("Enter your email: "));
                    $password = trim(readline("Enter your password: "));
                    $this->customerManager->register($name,$email,$password);
                    break;

                default:
                    printf("Invalid option.\n");

            }

        }
    }

    public function adminRun():void
    {
       // var_dump("Hello");
       
        while(true){

            foreach ($this->loginCredentials as $option=>$label){
                printf("%d. %s\n",$option,$label);
            }

            $chooseOption = intval(readline("Enter option: "));

            switch ($chooseOption){

                case self::LOGIN:
                    $email = trim(readline("Enter your email: "));
                    $password = trim(readline("Enter your password: "));
                    $this->adminManager->adminLogin($email,$password);
                    break;

                case self::REGISTER:
                    $name = trim(readline("Enter your name: "));
                    $email = trim(readline("Enter your email: "));
                    $password = trim(readline("Enter your password: "));
                    $this->adminManager->adminRegister($name,$email,$password);
                    break;

                default:
                    printf("Invalid option.\n");

            }

        }
    }

}