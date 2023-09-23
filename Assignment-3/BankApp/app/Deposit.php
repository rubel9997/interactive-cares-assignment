<?php


namespace App;
use App\TransactionType;


class Deposit extends Transaction
{
    public function __construct()
    {
        $this->type = TransactionType::WITHDRAW;
    }

}