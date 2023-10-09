<?php

namespace App\CLI;

use App\Common\Validation;

class CLIBankApp
{

    private Validation $validation;
    private UserController $user;
    private const LOGIN=1;
    private const REGISTER=2;

    private array $loginCredentials = [
        self::LOGIN =>"Login",
        self::REGISTER => "Register"
    ];

    public function __construct()
    {
        $this->validation = new Validation();
        $this->user = new UserController(new FileStorage);
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
                    $email = $this->validation->validated(readline("Enter your email: "));
                    $password = $this->validation->validated(readline("Enter your password: "));
                    $this->user->login($email,$password);
                    break;

                case self::REGISTER:
                    $name = $this->validation->validated(readline("Enter your name: "));
                    $email = $this->validation->validated(readline("Enter your email: "));
                    $password = $this->validation->validated(readline("Enter your password: "));
                    $this->user->register($name,$email,$password);
                    break;

                default:
                    printf("Invalid option.\n");

            }

        }
    }

}