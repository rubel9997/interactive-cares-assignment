<?php

namespace App\CLI;

use App\Common\TransactionType;
use App\Common\UserRole;

class FinanceManager
{
    private array $user;
    protected Storage $storage;
    protected array $transactions;

    public function __construct(Storage  $storage)
    {
        $this->storage = $storage;
        $this->users = $this->storage->load(User::getModelName());
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

        $existingCustomer = $this->getExistingCustomer($email,UserRole::CUSTOMER);;

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

        $existingCustomer = $this->getExistingCustomer($email,UserRole::CUSTOMER);

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
        $sender = $this->getExistingCustomer($senderEmail,UserRole::CUSTOMER);
        if (!$sender) {
            printf("Sender with this email does not exist.\n\n");
            return;
        }

        // check this receiver email exist
        $receiver = $this->getExistingCustomer($receiverEmail,UserRole::CUSTOMER);
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

        printf("---------------------------------\n");
//        foreach ($this->transactions as $transaction) {
//            if ($transaction->getEmail() == $email && ($transaction->getType() == TransactionType::DEPOSIT || $transaction->getType() == TransactionType::RECEIVE)) {
//                $balance += $transaction->getAmount();
//            }
//            elseif($transaction->getEmail() == $email &&  ($transaction->getType() == TransactionType::WITHDRAW || $transaction->getType() == TransactionType::TRANSFER)) {
//                $balance -= $transaction->getAmount();
//            }
//        }
        $balance = $this->calculateBalance($email);

        printf("Current Balance: %.2f\n", $balance);
        printf("---------------------------------\n\n");
    }


    public function getExistingCustomer(string $email,string $role): ? User
    {
        foreach ($this->users as $user){
            if ($user->getEmail() == $email && $user->getRole() == $role) {
                return $user;
            }
        }
        return null;
    }

    public function saveTransactions()
    {
        $this->storage->save(Transaction::getModelName(), $this->transactions);
    }

}