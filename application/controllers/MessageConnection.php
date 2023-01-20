<?php 
include_once(dirname(__FILE__)."./Data_format.php");

    class MessageConnection extends Data_format{

        public function __construct(){
            parent::__construct();

            $this->load->model(array("Message_Connection_Model","Messages_Model","Shop_Model"));
        }
    
        public function newmessage_post(){
            $data = $this->decode();

            $message = $data->message;
            $customer_id = $data->customer_id;
            $shop_id = $data->shop_id;
            $sender= $data->sender;

            $hasConnection = $this->Message_Connection_Model->getLatest($customer_id,$shop_id);
            $this->res(1,null,$hasConnection,0);
            

        if(count($hasConnection) < 1){

                $payload = array(
                    "customer_id"=>$customer_id,
                    "shop_id"=>$shop_id
                );
                $isCreated = $this->Message_Connection_Model->create($payload);

                $getLatestConnection = $this->Message_Connection_Model->getLatest($customer_id,$shop_id)[0];

                $message_payload = array(
                    "conn_id"=> $getLatestConnection->conn_id,
                    "message" => $message,
                    "msg_isActive"=>1,
                    "sender"=>$sender
                );
                $isSuccessMessage = $this->Messages_Model->create($message_payload);

                if($isSuccessMessage){
                    $this->res(1,null,"Successfully Sent",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }else{
                $getLatestConnection = $this->Message_Connection_Model->getLatest($customer_id,$shop_id)[0];

                $message_payload = array(
                    "conn_id"=> $getLatestConnection->conn_id,
                    "message" => $message,
                    "msg_isActive"=>1,
                );
                $isSuccessMessage = $this->Messages_Model->create($message_payload);

                if($isSuccessMessage){
                    $this->res(1,null,"Successfully Sent",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }
        
         }

         public function getCustomerMessages_get($customer_id){
            $data = $this->Message_Connection_Model->getCustomerMessage($customer_id);
        
            if(count($data)> 0){
                $this->res(1,$data,"Messages",count($data));
            }else{
                $this->res(0,null,"Data not found",0);
            }
          
         }

         public function getShopMessages_get($shop_id){
            $data = $this->Message_Connection_Model->getShopMessage($shop_id);
         
          
            if(count($data)> 0){
                $this->res(1,$data,"Messages",count($data));
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
  
        public function getCustomerConvo_get($conn_id){
            $connection = $this->Message_Connection_Model->getByConnectionId($conn_id)[0];

            $shop = $this->Shop_Model->getShopByid($connection->shop_id);
            $convo = $this->Messages_Model->getMessagesByConnectionId($conn_id);
            $respData = array(
                "shop" => $shop[0],
                "convo" => $convo
            );
            
            $this->res(1,$respData,"Success",0);

        }
  
    }
?>