<?php


namespace App\Auth;


use App\Session;
use App\Storage\DB;
use App\TransactionType;
use App\Validation;

class DashboardController
{

    protected DB $db;
    protected Validation $validate;

    public function __construct()
    {
        $this->db = new DB();
        $this->validate = new Validation();
    }

    public function getBalance($user_id)
    {
        $balance = 0;

        $deposit_sql = $this->db->conn->prepare("SELECT * FROM transactions WHERE user_id = ?  AND transaction_type IN (?, ?)");
        $deposit_sql->execute([$user_id, TransactionType::DEPOSIT, TransactionType::RECEIVE]);
        $deposit_data = $deposit_sql->fetchAll();

        foreach ($deposit_data as $depositValue){
            $balance += $depositValue['amount'];
        }

        $withdraw_sql = $this->db->conn->prepare("SELECT * FROM transactions WHERE user_id = ?  AND transaction_type IN (?,?)");
        $withdraw_sql->execute([$user_id,TransactionType::WITHDRAW,TransactionType::TRANSFER]);
        $withdraw_data = $withdraw_sql->fetchAll();

        foreach ($withdraw_data as $withdrawValue){
            $balance -= $withdrawValue['amount'];
        }

        return $balance;
    }

    public function getTransactionList($user_id)
    {

        $query = "SELECT transactions.id AS transaction_id,transactions.transaction_type,transactions.amount, transactions.transaction_date,
        users_sender.name AS sender_name,
        users_sender.email AS sender_email,
        users_receiver.name AS receiver_name,
        users_receiver.email AS receiver_email
        FROM transactions 
        LEFT JOIN users AS users_sender ON transactions.sender_id = users_sender.id
        LEFT JOIN users AS users_receiver ON transactions.receiver_id = users_receiver.id
        WHERE transactions.user_id = ?";

        $transaction_list = $this->db->conn->prepare($query);
        $transaction_list->execute([$user_id]);

        return $transaction_list->fetchAll();
    }


    public function dashboardPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Customer/customer-dashboard.php';
        }else{
          header('Location: /');
        }
    }

    public function depositPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Customer/deposit.php';
        }else{
            header('Location: /');
        }

    }

    public function withdrawPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Customer/withdraw.php';
        }else{
            header('Location: /');
        }

    }

    public function transferPage()
    {
        if(Session::get('login')){
            require_once __DIR__ . '/../Views/Customer/transfer.php';
        }else{
            header('Location: /');
        }

    }
}