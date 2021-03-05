<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Negotiable extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Negotiable_Model","Product_Model","Notification_Model","Account_Model","Garage_Model"));
        }

        public function reqneg_post(){
            $data = $this->decode();
            $garage_id = isset($data->garage_id) ? $data->garage_id : "";
            $product_id = isset($data->product_id) ? $data->product_id : "";
            $user_id = isset($data->user_id) ? $data->user_id : "";
            $neg_price = isset($data->price) ? $data->price : "";
            $neg_status = "unaccept";
          
            $user = $this->Account_Model->profile($user_id);
            if($neg_price===0){
                $this->res(0,null,"Pls put you price");
            }else{
                $dat = array(
                    "user_id" => $user_id,
                    "garage_id" => $garage_id,
                    "product_id" => $product_id,
                    "neg_price" => $neg_price,
                    "neg_status" => $neg_status
                );
    
                $insert = $this->Negotiable_Model->add($dat);
                if($insert){
                    $product = $this->Product_Model->getproduct($product_id);
                    $message = "You have new price request from".$user[0]->firstname." ".$user[0]->mi." ".$user[0]->lastname." to your item: ".$product[0]->item_name." for ".$neg_price;
      
                    $data = array(
                        "acnt_id" => $product[0]->acnt_id,
                        "notif_name" => "Price Request",
                        "notif_body" => $message,
                        "notif_type" => "price_request",
                        "notif_read" => "unread"
                    );
                    $notif = $this->Notification_Model->create_notif($data);
                    if($notif){
                        $this->res(1,null,"Successfully Requested",0);
                    }else{
                        $this->res(0,null,"error",0);
                    }
                    
                }else{
                    $this->res(0,null,"Error Requesting",0);
                }
            }
           
           
        }

    

        public function getreq_get($acnt_id,$product_id){
            $req = $this->Negotiable_Model->viewnegotiable($acnt_id,$product_id);
            if(count($req)){
                $this->res(1,$req[0],"date found",0);
            }else{
                $this->res(0,null,"data not found",0);
            }
        }

        public function viewrequest_get($acnt_id){
            $garage = $this->Garage_Model->myGarage($acnt_id);
            $garage_id = $garage[0]->garage_id;
            
            $viewrequest = $this->Negotiable_Model->viewrequest($garage_id);
            if(count($viewrequest) > 0){
                $this->res(1,$viewrequest,"data found",count($viewrequest));
            }else{
                $this->res(0,null,"data not found",0);
            }
        }

        public function accept_post($neg_id){
            $data = array("neg_status"=>"accept");
            $update = $this->Negotiable_Model->update($neg_id,$data);
                if($update){
                    $this->res(1,null,"Accepted",0);
                }else{
                    $this->res(0,null,"not accepted",0);
                }
        }
    }

?>