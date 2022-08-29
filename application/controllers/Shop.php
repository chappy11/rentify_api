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
                
                $this->res(1,null,"You have Successfully Subscribe You can now add  and sell products",0);
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


    }

?>