<?php


namespace App;


class Transaction
{

    protected TransactionType $type;

    private float $amount;

    protected string $email;

    public static function getModelName(): string
    {
        return 'transactions';
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setEmail(string $email):void
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setType(TransactionType $type): void
    {
        $this->type = $type;
    }

    public function getType():TransactionType
    {
        return $this->type;
    }


}