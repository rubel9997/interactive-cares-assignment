<?php

namespace App\CLI;

use App\Common\TransactionType;

class Withdraw extends Transaction
{
    public function __construct()
    {
        $this->type = TransactionType::WITHDRAW;
    }
}