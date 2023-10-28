<?php

declare(strict_types=1);

namespace App\WEB\Controller;


class DashboardController
{

    public function dashboardPage():void
    {
        require_once __DIR__ . '/../../WEB/Views/Customer/customer-dashboard.php';
    }

    public function depositPage():void
    {
        require_once __DIR__ . '/../../WEB/Views/Customer/deposit.php';

    }

    public function withdrawPage():void
    {
        require_once __DIR__ . '/../../WEB/Views/Customer/withdraw.php';

    }

    public function transferPage():void
    {
        require_once __DIR__ . '/../../WEB/Views/Customer/transfer.php';

    }
}