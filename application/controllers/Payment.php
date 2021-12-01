<?php 
include_once(dirname(__FILE__)."/Data_format.php");


    class Payment extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Payment_Model","Transaction_Model","Notification_Model","Pet_Model"));
        }

        public function notification($user_id,$name,$body,$type,$target_id){
            $arr = array(
                "user_id" => $user_id,
                "notif_name" => $name,
                "notif_body" => $body,
                "notif_status" => 0,
                "notif_type" => $type,
                "target_id" => $target_id
            );
        }

        public function withreciept_post(){
            $image = $_FILES['reciept']['name'];
            $trans_id = $this->post('transac_id');
            $amount = $this->post('amount');
            $withReceipt = $this->post("withReciept");
            
            $arr = array(
                "transac_id" => $trans_id,
                "amount" => $amount,
                "withReciept" => $withReceipt,
                "reciept" => "payment/".$image,
                "approve" =>0
            );
            $trans = $this->Transaction_Model->getTransaction($trans_id);
            $result = $this->Payment_Model->insert($arr);
            if($result){
                move_uploaded_file($_FILES['reciept']['tmp_name'],"payment/".$image);
                    $name = "New Payment";
                    $pet = $this->Pet_Model->getOwner($trans[0]->pet_id);
                    $body = $pet[0]->firstname." ".$pet[0]->lastname;
                    $this->notification($trans[0]->user_id,$name,$body,"transaction",$trans_id);                       
                    $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Error",0);
            }

        }

        public function nonereciept_post(){
            $data = $this->decode();
            $transac_id = $data->transac_id;
            $amount = $data->amount;
            $withReceipt = $data->withreciept;
            $arr = array(
                "transac_id" => $transac_id,
                "amount" => $amount,
                "withReciept" => $withReceipt,
                "reciept" => "",
                "approve" => 0
            );

            $result =$this->Payment_Model->insert($arr);
            if($result){
                    $this->res(1,null,"Successfully Created",0);
                    $trans = $this->Transaction_Model->getTransaction($transac_id);
                    $pet = $this->Pet_Model->getOwner($trans[0]->pet_id);
                    $name = "";
                    $body = $pet[0]->firstname." ".$pet[0]->lastname;
                    $this->notification($trans[0]->user_id,$name,$body,"transaction",$transac_id);
                }else{
                $this->res(0,null,"Error Paid",0);
            }
        
        }
        
        public function getpayment_get($transac_id){
            $result = $this->Payment_Model->getPayment($transac_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function disapprove_post(){
            $data = $this->decode();
            $payment_id = $data->payment_id;
        
            $arr = array(
                "approve" => 1
            );
            $result = $this->Payment_Model->update($payment_id,$arr);
            if($result){
                $this->res(1,null,"Your concerned will be send to the owner",0);
            }else{
                $this->res(0,null,"Server Error",0);
            }
        }
        
        public function  updateWithReciept_post(){
            $payment_id = $this->post("payment_id");
            $reciept = $_FILES['image']['name'];
            $amount = $this->post("amount"); 
            $method = $this->post("method");
            
            $arr = array(
                "reciept" => "payment/".$reciept,
                "amount" => $amount,
                "withReciept" => $method,
                "approve" => 0
            );

            $result = $this->Payment_Model->update($payment_id,$arr);
            if($result){
                move_uploaded_file($_FILES['image']['tmp_name'],"payment/".$reciept);
                $this->res(1,null,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }

        public function updateNoneReciept_post(){
            $data= $this->decode();
            $payment_id = $data->payment_id;
            $amount = $data->amount;
            $method = $data->method;
            $arr = array(
                "amount" => $amount,
                "withReciept" => $method,
                "approve" => 0
            );

            $result = $this->Payment_Model->update($payment_id,$arr);
            if($result){
                $this->res(1,null,"Successfully Updated",0);
                
            }else{
                $this->res(0,null,"Error Updating",0);
            }
        }
    }
?>