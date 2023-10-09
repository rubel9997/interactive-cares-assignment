<?php


namespace App\WEB\Controller;


use App\Common\TransactionType;
use App\WEB\Session;

class WithdrawController extends TransactionController
{

    public function addWithdraw(array $data)
    {
        try{
            $amount =$this->validate->validated($data['amount']);
            $user_id = Session::get('user_id');
            $transaction_type = TransactionType::WITHDRAW;
            $transaction_date = \date('d-m-Y');

            if(empty($amount)){
                Session::set('error_message','Amount are required.');
                header("Location: /withdraw");
                exit();
            }

            if($this->getBalance($user_id) < $amount){
                Session::set('error_message','Insufficient balance for the withdraw');
                header("Location: /withdraw");
                exit();
            }

            $insert = $this->db->conn->prepare("INSERT INTO transactions (user_id,sender_id,receiver_id,transaction_type,amount,transaction_date) VALUES (?,?,?,?,?,?)");
            $result = $insert->execute([$user_id,$user_id,$user_id,$transaction_type,$amount,$transaction_date]);

            if($result){
                Session::set('success_message','Withdraw has been successfully.');
                header("Location: /dashboard");
                exit();
            }else{
                Session::set('error_message','Withdraw has not been successful.');
                header("Location: /withdraw");
                exit();
            }
        }catch (\Exception $e){
            Session::set('error_message', 'An error occurred during withdraw.'.$e->getMessage());
            header("Location: /withdraw");
            exit();
        }
    }

    public function fundTransfer(array $data)
    {
        $this->db->conn->beginTransaction();
        try{
            $recipient_email = $this->validate->validated($data['email']);
            $amount =$this->validate->validated($data['amount']);
            $user_id = Session::get('user_id');
            $transaction_type_transfer = TransactionType::TRANSFER;
            $transaction_type_receive = TransactionType::RECEIVE;
            $transaction_date = \date('Y-m-d H:i:s');

            if(empty($amount) || empty($recipient_email)){
                Session::set('error_message','All fields are required.');
                header("Location: /transfer");
                exit();
            }

            $select_sql = $this->db->conn->prepare("SELECT * FROM users WHERE email =?");
            $select_sql->execute([$recipient_email]);
            $user_exists = $select_sql->fetch();


            if(!$user_exists || $user_exists['role'] !== 'customer'){
                Session::set('error_message','Recipient email does not exist our record.');
                header("Location: /transfer");
                exit();
            }

            if($this->getBalance($user_id) < $amount){
                Session::set('error_message','Insufficient balance for the fund transfer');
                header("Location: /transfer");
                exit();
            }

            $transfer = $this->db->conn->prepare("INSERT INTO transactions (user_id,sender_id,receiver_id,transaction_type,amount,transaction_date) VALUES (?,?,?,?,?,?)");
            $transfer_result = $transfer->execute([$user_id,$user_id,$user_exists['id'],$transaction_type_transfer,$amount,$transaction_date]);

            $receiver = $this->db->conn->prepare("INSERT INTO transactions (user_id,sender_id,receiver_id,transaction_type,amount,transaction_date) VALUES (?,?,?,?,?,?)");
            $receive_result = $receiver->execute([$user_exists['id'],$user_id,$user_exists['id'],$transaction_type_receive,$amount,$transaction_date]);

            if($transfer_result && $receive_result){
                $this->db->conn->commit();
                Session::set('success_message','Fund has been transferred successfully.');
                header("Location: /dashboard");
                exit();
            }else{
                $this->db->conn->rollBack();
                Session::set('error_message','Fund  has not been transferred successfully.');
                header("Location: /transfer");
                exit();
            }

        }catch (\Exception $e){
            $this->db->conn->rollBack();
            Session::set('error_message', 'An error occurred during fund transfer.'.$e->getMessage());
            header("Location: /transfer");
            exit();
        }

    }

}