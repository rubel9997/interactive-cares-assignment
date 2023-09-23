<?php


namespace App;


class CustomerManager
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


    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->customers = $this->storage->load(Customer::getModelName());
        $this->financeManager = new FinanceManager(new FileStorage());

    }

    public function login(string $email,string $password):void
    {
        if(empty($email) || empty($password)){
            printf(PHP_EOL);
            printf("All option are required.\n\n");
            return;
        }

        $emailValidation = Helper::emailValidator($email);

        if(!$emailValidation){
            printf(PHP_EOL);
            printf("Please enter a valid email.\n\n");
            return;
        }

        $existingCustomer = $this->getExistingCustomer($email,CustomerRole::CUSTOMER);

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
                            $email = trim(readline("Enter your email: "));
                            $this->financeManager->showTransactions($email);
                            break;

                        case self::DEPOSIT_MONEY:
                            $amount = (float)trim(readline("Enter your amount: "));
                            $email = trim(readline("Enter your email: "));
                            $this->financeManager->depositMoney($amount,$email);
                            break;
                        case self::WITHDRAW_MONEY:
                            $amount = (float)trim(readline("Enter your amount: "));
                            $email = trim(readline("Enter your email: "));
                            $this->financeManager->withdrawMoney($amount,$email);
                            break;
                        case self::TRANSFER_MONEY:
                            $amount = (float)trim(readline("Enter your amount: "));
                            $senderEmail = trim(readline("Enter sender email: "));
                            $receiver_email = trim(readline("Enter receiver email: "));

                            $this->financeManager->fundTransfer($amount,$senderEmail,$receiver_email);
                            break;
                        case self::CURRENT_BALANCE:
                            $email = trim(readline("Enter your email: "));
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

    public function register(string $name,string $email,string $password):void
    {

        if(empty($name) || empty($email) || empty($password)){
            printf(PHP_EOL);
            printf("All option are required.\n\n");
            return;
        }

        $emailValidation = Helper::emailValidator($email);

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
        $customer->setRole(CustomerRole::CUSTOMER);

        $this->customers[] = $customer;

        $this->saveCustomers();

        printf("User registration successfully!\n\n");
    }

    public function getExistingCustomer(string $email, CustomerRole $role): ? Customer
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