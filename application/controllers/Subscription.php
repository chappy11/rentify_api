<?php 
include_once(dirname(__FILE__)."/Data_format.php");


    class Subscription extends Data_format{

        public function __construct(){
            parent::__construct();

            $this->load->model(array("Subscription_Model"));
        }

        public function create_post(){
            $data = $this->decode();

            $price = $data->price;
            $monthly = $data->monthly;
            $subname = $data->subname;
            $desc = $data->desc;
            $sub_status = 'ACTIVE';

            $payload = array(
                "price" => $price,
                "monthly" => $monthly,
                "sub_name" => $subname,
                "sub_description" => $desc,
                "sub_status" => $sub_status
            );

            $isInserted = $this->Subscription_Model->create($payload);

            if($isInserted){
                $this->res(1,null,"Successfully Inserted",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }
    
        public function subscription_get($sub_id){
            $data = $this->Subscription_Model->getSubscriptionById($sub_id);

            $this->res(1,$data,"Successfully Fetch",1);
        }

        public function subscriptions_get(){
            $data = $this->Subscription_Model->getAllSubscription();
            
            $this->res(1,$data,"Successfully Fetch",count($data));
        }

    }

?>