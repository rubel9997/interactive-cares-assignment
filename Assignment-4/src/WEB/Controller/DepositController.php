<?php


namespace App\WEB\Controller;


use App\Common\TransactionType;
use App\WEB\Session;

class DepositController extends TransactionController
{


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