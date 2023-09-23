<?php


namespace App;

use App\TransactionType;

class Withdraw extends Transaction
{
    public function __construct()
    {
        $this->type = TransactionType::WITHDRAW;
    }
}