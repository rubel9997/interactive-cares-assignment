<?php


namespace App\Auth;


use App\Session;
use App\Storage\DB;
use App\Validation;
use App\TransactionType;

class DepositController
{
    private DB $db;
    private Validation $validate;


    public function __construct()
    {
        $this->db = new DB();
        $this->validate = new Validation();

    }


    public function addDeposit(array $data)
    {
        $amount =$this->validate->validated($data['amount']);
        $user_id = Session::get('user_id');
        $transaction_type = TransactionType::DEPOSIT;
        $transaction_date = \date('d-m-Y');

        if(empty($amount)){
            Session::set('error_message','Amount are required.');
            header("Location: /deposit");
            exit();
        }

         $insert = $this->db->conn->prepare("INSERT INTO transactions (user_id,sender_id,receiver_id,transaction_type,amount,transaction_date) VALUES (?,?,?,?,?,?)");
         $result = $insert->execute([$user_id,$user_id,$user_id,$transaction_type,$amount,$transaction_date]);

         if($result){
             Session::set('success_message','Deposit has been added successfully.');
             header("Location: /dashboard");
             exit();
         }else{
             Session::set('error_message','Deposit has not been added.');
             header("Location: /deposit");
             exit();
         }


    }


}