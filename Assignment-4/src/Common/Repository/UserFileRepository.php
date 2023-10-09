<?php


namespace App\Common\Repository;


use App\CLI\Customer;
use App\CLI\FileStorage;
use App\CLI\FinanceManager;
use App\CLI\Storage;
use App\Common\Helper;
use App\Common\UserRole;
use App\Common\Validation;

class UserFileRepository implements UserRepository
{

    protected FinanceManager $financeManager;
    protected array $customers;

    private Storage $storage;

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

    private Validation $validation;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->validation = new Validation();
        $this->financeManager = new FinanceManager(new FileStorage());

    }

    public function get(array $data){
        var_dump($data);
    }
    public function save(array $data)
    {

        $name = $this->validation->validated($data['name']);
        $email = $this->validation->validated($data['email']);
        $password = $this->validation->validated($data['password']);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user_exists = $this->userExists($email,UserRole::CUSTOMER);
        $emailValidation = Helper::validateEmail($email);

        if(empty($name) || empty($email) || empty($password)){
            printf(PHP_EOL);
            printf("All option are required.\n\n");
            return;
        }

        if($user_exists){
            printf(PHP_EOL);
            printf("This email is already exist.\n\n");
            return;
        }

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

        $customer = new Customer();
        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setPassword($password);
        $customer->setRole(UserRole::CUSTOMER);

        $this->customers[] = $customer;

        $this->saveCustomers();

        printf("User registration successfully!\n\n");
    }

    public function userExists(string $email, string $role): ? Customer
    {
        foreach ($this->customers as $customer){
            if ($customer->getEmail() == $email && $customer->getRole() == $role) {
                return $customer;
            }
        }
        return null;
    }



    public function saveCustomers()
    {
        $this->storage->save(Customer::getModelName(),$this->customers);
    }

}