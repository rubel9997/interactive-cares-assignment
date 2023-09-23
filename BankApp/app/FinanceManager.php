<?php


namespace App;
use App\Customer;
use App\Storage;
use App\Deposite;


class FinanceManager
{
    private array $transactions;
    private array $customers;
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->customers = $this->storage->load(Customer::getModelName());

        $this->transactions = $this->storage->load(Transaction::getModelName());
    }

    public function showTransactions($email): void
    {
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

    public function depositMoney($amount,$email){

        $existingCustomer = $this->getExistingCustomer($email,CustomerRole::CUSTOMER);;

        if($existingCustomer){

            $deposit = new Deposit();
            $deposit->setAmount($amount);
            $deposit->setEmail($email);
            $deposit->setType(TransactionType::DEPOSIT);

            $this->transactions[] = $deposit;

            $this->saveTransactions();

            printf("Cash Deposit added successfully!\n");

        }else{
            printf(PHP_EOL);
            printf("Sorry this email does not exit.\n\n");
            return;
        }

    }

    public function withdrawMoney($amount,$email){

        $existingCustomer = $this->getExistingCustomer($email,CustomerRole::CUSTOMER);

        // Check if customer has enough balance for the withdraw.
        $senderBalance = $this->calculateBalance($email);
        if ($senderBalance < $amount) {
            printf("Insufficient balance for the withdraw.\n\n");
            return;
        }

        if($existingCustomer){
            $withdraw = new Withdraw();
            $withdraw->setAmount($amount);
            $withdraw->setEmail($email);
            $withdraw->setType(TransactionType::WITHDRAW);

            $this->transactions[] = $withdraw;

            $this->saveTransactions();
            printf("Cash Withdrawal successfully!\n");

        }else{
            printf(PHP_EOL);
            printf("Sorry this email does not exit.\n\n");
            return;
        }

    }

    public function fundTransfer($amount, $senderEmail, $receiverEmail)
    {
        // check this sender email exist
        $sender = $this->getExistingCustomer($senderEmail,CustomerRole::CUSTOMER);
        if (!$sender) {
            printf("Sender with this email does not exist.\n\n");
            return;
        }

        // check this receiver email exist
        $receiver = $this->getExistingCustomer($receiverEmail,CustomerRole::CUSTOMER);
        if (!$receiver) {
            printf("Receiver with this email does not exist.\n\n");
            return;
        }

        // Check if sender has enough balance for the transfer
        $senderBalance = $this->calculateBalance($senderEmail);
        if ($senderBalance < $amount) {
            printf("Insufficient balance for the transfer.\n\n");
            return;
        }

        // Create a withdrawal transaction for the sender
        $withdraw = new Withdraw();
        $withdraw->setAmount($amount);
        $withdraw->setEmail($senderEmail);
        $withdraw->setType(TransactionType::TRANSFER);
        $this->transactions[] = $withdraw;

        // Create a deposit transaction for the receiver
        $deposit = new Deposit();
        $deposit->setAmount($amount);
        $deposit->setEmail($receiverEmail);
        $deposit->setType(TransactionType::RECEIVE);
        $this->transactions[] = $deposit;

        $this->saveTransactions();

        printf("Money transferred successfully!\n");

    }


    private function calculateBalance($email)
    {
        $balance = 0;
        foreach ($this->transactions as $transaction) {
            if ($transaction->getEmail() === $email) {
                if ($transaction instanceof Deposit) {
                    $balance += $transaction->getAmount();
                } elseif ($transaction instanceof Withdraw) {
                    $balance -= $transaction->getAmount();
                }
            }
        }
        return $balance;
    }


    public function showCurrentBalance(string $email): void
    {
        $balance = 0;

        printf("---------------------------------\n");
        foreach ($this->transactions as $transaction) {
            if ($transaction->getEmail() == $email && $transaction->getType() == TransactionType::DEPOSIT) {
                $balance += $transaction->getAmount();
            } else if($transaction->getEmail() == $email && $transaction->getType() == TransactionType::WITHDRAW) {
                $balance -= $transaction->getAmount();
            }
            else if($transaction->getEmail() == $email && $transaction->getType() == TransactionType::TRANSFER) {
                $balance -= $transaction->getAmount();
            }
            else if($transaction->getEmail() == $email && $transaction->getType() == TransactionType::RECEIVE) {
                $balance += $transaction->getAmount();
            }

        }

        printf("Current Balance: %.2f\n", $balance);
        printf("---------------------------------\n\n");
    }


    public function getExistingCustomer(string $email,CustomerRole $role): ? Customer
    {
        foreach ($this->customers as $customer){
            if ($customer->getEmail() == $email && $customer->getRole() == $role) {
                return $customer;
            }
        }
        return null;
    }

    public function saveTransactions(): void
    {
        $this->storage->save(Transaction::getModelName(), $this->transactions);
    }


}