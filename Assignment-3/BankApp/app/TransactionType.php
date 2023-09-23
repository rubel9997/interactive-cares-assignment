<?php

declare(strict_types=1);

namespace App;

enum TransactionType
{
    case DEPOSIT;
    case WITHDRAW;
    case TRANSFER;
    case RECEIVE;
}
