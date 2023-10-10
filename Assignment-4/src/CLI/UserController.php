<?php

namespace App\CLI;

use App\Common\Helper;
use App\Common\UserRole;
use App\Common\Validation;
use http\Encoding\Stream;

class UserController
{

    protected array $users;
    protected Storage $storage;

    protected  FinanceManager $financeManager;
    protected  Validation $validation;

    private const TRANSACTION = 1;
    private const DEPOSIT_MONEY = 2;
    private const WITHDRAW_MONEY = 3;
    private const TRANSFER_MONEY = 4;
    private const CURRENT_BALANCE = 5;

    private array $userMenuOptions =[
        self::TRANSACTION => "See all of your transactions",
        self::DEPOSIT_MONEY => "Deposit money to your account",
        self::WITHDRAW_MONEY => "Withdraw money from your account",
        self::TRANSFER_MONEY => "Transfer money to another customer account",
        self::CURRENT_BALANCE => "See the current balance of the account"
    ];

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->users = $this->storage->load(User::getModelName());
        $this->financeManager = new FinanceManager(new FileStorage());
        $this->validation = new Validation();
       // var_dump($this->users);
    }

    public function login(string $email,string $password)
    {

        if(empty($email) || empty($password)){
            printf(PHP_EOL);
            printf("All option are required.\n\n");
            return;
        }

        $emailValidation = Helper::validateEmail($email);

        if(!$emailValidation){
            printf(PHP_EOL);
            printf("Please enter a valid email.\n\n");
            return;
        }

        $existingCustomer = $this->existUser($email,UserRole::CUSTOMER);

        if($existingCustomer){
            if(password_verify($password,$existingCustomer->getPassword())){

                while(true){
                    printf("----------------------------------\n");

                    foreach ($this->userMenuOptions as $menuOption => $menuLabel){
                        printf("%d. %s\n",$menuOption,$menuLabel);
                    }

                    printf("----------------------------------\n");

                    $chooseOption = intval(readline("Enter option: "));

                    switch ($chooseOption){

                        case self::TRANSACTION:
                            $email = $this->validation->validated(readline("Enter your email: "));
                            $this->financeManager->showTransactions($email);
                            break;

                        case self::DEPOSIT_MONEY:
                            $amount = (float)$this->validation->validated(readline("Enter your amount: "));
                            $email = $this->validation->validated(readline("Enter your email: "));
                            $this->financeManager->depositMoney($amount,$email);
                            break;
                        case self::WITHDRAW_MONEY:
                            $amount = (float)$this->validation->validated(readline("Enter your amount: "));
                            $email = $this->validation->validated(readline("Enter your email: "));
                            $this->financeManager->withdrawMoney($amount,$email);
                            break;
                        case self::TRANSFER_MONEY:
                            $amount = (float)$this->validation->validated(readline("Enter your amount: "));
                            $senderEmail = $this->validation->validated(readline("Enter sender email: "));
                            $receiver_email = $this->validation->validated(readline("Enter receiver email: "));

                            $this->financeManager->fundTransfer($amount,$senderEmail,$receiver_email);
                            break;
                        case self::CURRENT_BALANCE:
                            $email = $this->validation->validated(readline("Enter your email: "));
                            $this->financeManager->showCurrentBalance($email);
                            break;
                        default:
                            echo "Invalid option.\n";
                    }

                }


            }else{
                printf(PHP_EOL);
                printf("Password does not match our records.\n\n");
                return;
            }

        }else{
            printf(PHP_EOL);
            printf("This email does not exist in our records.\n\n");
            return;
        }

    }

    public function register(string $name,string $email,string $password)
    {

        if(empty($name) || empty($email) || empty($password)){
            printf(PHP_EOL);
            printf("All option are required.\n\n");
            return;
        }

        $exist_user = $this->existUser($email,UserRole::CUSTOMER);

        if($exist_user){
            printf(PHP_EOL);
            printf("This email is already exist.\n\n");
            return;
        }

        $emailValidation = Helper::validateEmail($email);

        if(!$emailValidation){
            printf(PHP_EOL);
            printf("Please Enter a valid email.\n\n");
            return;
        }

        if(strlen($password) < 2){
            printf(PHP_EOL);
            printf("Password must be at least 3 character.\n\n");
            return;
        }


        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRole(UserRole::CUSTOMER);

        $this->users[] = $user;

        $this->saveUser();

        printf("User registration successfully!\n\n");

    }

    public function existUser(string $email,string $role): ? User
    {
        foreach ($this->users as $user){
            if ($user->getEmail() == $email && $user->getRole() == $role) {
                return $user;
            }
        }
        return null;
    }

    public function saveUser()
    {
        $this->storage->save(User::getModelName(),$this->users);
    }




}