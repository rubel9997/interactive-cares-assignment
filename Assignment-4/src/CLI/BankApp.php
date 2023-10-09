<?php

namespace App\CLI;

use App\Common\Repository\UserFileRepository;
use App\Common\Service\UserService;
use App\Common\Validation;

class BankApp
{

    private UserService $userService;
    private const LOGIN=1;
    private const REGISTER=2;

    private array $loginCredentials = [
        self::LOGIN =>"Login",
        self::REGISTER => "Register"
    ];


    public function __construct()
    {
        $this->userService = new UserService(new UserFileRepository());
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

                    $email = readline("Enter your email: ");
                    $password = readline("Enter your password: ");
                    $data =[
                        'email'=>$email,
                        'password'=>$password
                    ];
                    $this->userService->getCustomer($data);
                    break;

                case self::REGISTER:

                    $name = readline("Enter your name: ");
                    $email = readline("Enter your email: ");
                    $password = readline("Enter your Password: ");

                    $data =[
                        'name'=>$name,
                        'email'=>$email,
                        'password'=>$password
                    ];

                    $this->userService->create($data);
                    break;

                default:
                    printf("Invalid option.\n");

            }

        }
    }


    public function adminRun()
    {
        
    }
    
}