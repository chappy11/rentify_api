<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class Subscription extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Subscription_Model"));
        }

        public function createsubscription_post(){
            $data = $this->decode();

            $subName = isset($data->subscriptionName) ? $data->subscriptionName : "";
            $description = isset($data->description) ? $data->description : "";
            $noMonths = isset($data->noMonths) ? $data->noMonths : "";
            
            $subData = array(
                "subscriptionName" => $subName,
                "subDescription" => $description,
                "noMonths" => $noMonths,
                "isActive" => 1
            );

            $isCreated = $this->Subscription_Model->createNewSubcription($subData);

            if($isCreated){
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Something went wrong sorry for inconvinience",0);
            }
        }

        public function getsubscription_get($subscription_id){
            $subscriptionData = $this->Subscription_Model->getSubscriptionById($subscription_id);

            if(count($subscriptionData) > 0){
                $this->res(1,$subscriptionData[0],"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function getsubscriptions_get(){
            $subscriptionData = $this->Subscription_Model->getAllSubscription();

            if(count($subscriptionData) > 0){
                $this->res(1,$subscriptionData,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function updatestatus_put(){
            $data = $this->decode();
            
            $subscription_id = isset($data->subscription_id) ? $data->subscription_id : "";
            $status = isset($data->status) ? $data->status : "";

            $isUpdated = $this->Subscription_Model->updateSubscription($subscription_id,array("isActive" => $status));
        
            if($isUpdated){
                $this->res(1,null,"Successfully Update",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }
    }
?>