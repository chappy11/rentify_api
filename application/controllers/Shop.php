<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class Shop extends Data_format{
        
        public function __construct(){
            parent::__construct();
            $this->load->model(array("Shop_Model","Subscription_Model"));
        }

        
        public function test_get(){
            $this->res(1,null,"TEST API",0);
        }

        public function subscribe_post(){
            $data= $this->decode();
            $shop_id = isset($data->shop_id) ? $data->shop_id : "";
            $subscription_id = isset($data->subscription_id) ? $data->subscription_id : ""; 

            $subData = $this->Subscription_Model->getSubscriptionById($subscription_id)[0];
            $date = date("Y-m-d");
            $xpiry_date = date('Y-m-d', strtotime($date. ' + '.$subData->noMonths.'  month'));

            $updatedShop = array(
                "subscription_id" => $subscription_id,
                "subExp" => $xpiry_date
            );

            $isUpdated = $this->Shop_Model->updateShop($shop_id,$updatedShop);

            if($isUpdated){
                $shopData = $this->Shop_Model->getShopByid($shop_id);
                $this->res(1,$shopData[0],"You have Successfully Subscribe You can now add  and sell products",0);
            }else{

                $this->res(0,null,"Something went wrong",0);
            }

        }   

        public function getpendingshop_get(){
            $data = $this->Shop_Model->getPendingShop();

            if(count($data) > 0){
                $this->res(1,$data,"DATA FOUND",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function shopdata_get($shop_id){
            $data = $this->Shop_Model->getShopByShopId($shop_id);

                $this->res(1,$data[0],"Data found",0);
        }

        public function getactive_get(){
            $data = $this->Shop_Model->getActiveShop();

            $this->res(1,$data,"Data found",0);
        }

        public function updatepic_post(){
            $logo = $_FILES['shopLogo']['name'];
            $id =  $this->post("id");
 
            $payload = array(
                "logo"=>"shops/".$logo
            );
            
            $isUpdated = $this->Shop_Model->updateShop($id,$payload);
            $this->res(1,$isUpdated,"ff",0);
            if($isUpdated){
                
                $isUploaded = move_uploaded_file($_FILES['shopLogo']['tmp_name'],"shops/".$logo);
                if($isUploaded){
                    $shop = $this->Shop_Model->getShopByid($id);
                    $this->res(1,$shop,"Successfully Updated",0);
                }else{
                    $this->res(0,null,"Something went wrong while updating",0);
                }
               
            }else{
                $this->res(0,null,"Error",0);
            }
          
        }

    }

?>