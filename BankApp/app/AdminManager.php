<?php


namespace App;


class AdminManager
{
    private array $transactions;
    protected array $customers;

    private Storage $storage;

    private const TRANSACTION = 1;
    private const TRANSACTION_BY_CUSTOMER = 2;
    private const CUSTOMER_LIST = 3;

    private array $userMenuOptions =[
        self::TRANSACTION => "See all the transactions by all the users",
        self::TRANSACTION_BY_CUSTOMER => "See transactions by a specific user (searching by their email)",
        self::CUSTOMER_LIST => "See the list of all the customers",
    ];


    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->customers = $this->storage->load(Customer::getModelName());
        $this->transactions = $this->storage->load(Transaction::getModelName());

    }

    public function adminLogin(string $email,string $password):void
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

        $existingCustomer = $this->getExistingCustomer($email,CustomerRole::ADMIN);

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
                            $this->showAllTransactions();
                            break;

                        case self::TRANSACTION_BY_CUSTOMER:
                            $email = trim(readline("Enter your email: "));
                            $this->transactionByCustomer($email);
                            break;
                        case self::CUSTOMER_LIST:
                    
                            $this->customerList();
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

    public function adminRegister(string $name,string $email,string $password):void
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
        $customer->setRole(CustomerRole::ADMIN);

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

    public function showAllTransactions(){
        printf("---------------------------------\n");

        if(!empty($this->transactions)){
            foreach ($this->transactions as $transaction) {

                if ( $transaction->getType() == TransactionType::DEPOSIT) {
                
                    printf("Customer Email: %s\n Deposit amount: %.2f\n",$transaction->getEmail(), $transaction->getAmount());
                }
                else if($transaction->getType() == TransactionType::WITHDRAW){
                    printf("Customer Email: %s\n Withdraw amount: %.2f\n",$transaction->getEmail(), $transaction->getAmount());
                }

                else if($transaction->getType() == TransactionType::TRANSFER){
                    printf("Customer Email: %s\n Transfer amount: %.2f\n",$transaction->getEmail(),  $transaction->getAmount());
                }
                else if($transaction->getType() == TransactionType::RECEIVE){
                    printf("Customer Email: %s\n Received amount: %.2f\n",$transaction->getEmail(), $transaction->getAmount());
                }
            }
        }else{
            printf("No Transaction available\n");
        }

        printf("---------------------------------\n\n");

    }

    public function transactionByCustomer(string $email){
        printf("---------------------------------\n");

        if($this->transactions !== []){
            foreach ($this->transactions as $transaction) {
                if ($transaction->getEmail() == $email && $transaction->getType() == TransactionType::DEPOSIT) {
                    //var_dump($transaction);
                    printf("Deposit amount: %.2f\n", $transaction->getAmount());
                }
                else if($transaction->getEmail() == $email && $transaction->getType() == TransactionType::WITHDRAW){
                    printf("Withdraw amount: %.2f\n", $transaction->getAmount());
                }

                else if($transaction->getEmail() == $email && $transaction->getType() == TransactionType::TRANSFER){
                    printf("Transfer amount: %.2f\n", $transaction->getAmount());
                }
                else if($transaction->getEmail() == $email && $transaction->getType() == TransactionType::RECEIVE){
                    printf("Received amount: %.2f\n", $transaction->getAmount());
                }
            }
        }else{
            printf("No Transaction available\n");
        }

        printf("---------------------------------\n\n");
    }

    public function customerList(){
        $serialNumber = 1;
        foreach ($this->customers as $customer){
        
            if($customer->getRole() !== CustomerRole::ADMIN){
                printf(PHP_EOL);
                printf("Customer ID: %d\n", $serialNumber);
                printf("Customer Name: %.s\n", $customer->getName());
                printf("Customer Email: %.s\n", $customer->getEmail());
                $serialNumber++;
            }
    
        }
    }



}