<?php


namespace App\WEB\Controller;


class DashboardController
{

    public function dashboardPage()
    {
        require_once __DIR__ . '/../../WEB/Views/Customer/customer-dashboard.php';
    }

    public function depositPage()
    {
        require_once __DIR__ . '/../../WEB/Views/Customer/deposit.php';

    }

    public function withdrawPage()
    {
        require_once __DIR__ . '/../../WEB/Views/Customer/withdraw.php';

    }

    public function transferPage()
    {
        require_once __DIR__ . '/../../WEB/Views/Customer/transfer.php';

    }
}