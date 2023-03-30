<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Rate extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array('Rate_Model'));
        }

        public function rate_post(){
            $data = $this->decode();
            $user_id = $data->user_id;
            $product_id = $data->product_id;
            $rate = $data->rate;

            $haveRate = $this->Rate_Model->checkRating($user_id,$product_id);
            
            $isSuccess = false;
            
            if(count($haveRate) > 0){
                $updatePayload = array("rate"=>$rate);
                $isSuccess = $this->Rate_Model->update($haveRate[0]->rate_id,$updatePayload);
            }else{
                $payload = array(
                    "user_id"=>$user_id,
                    "product_id"=>$product_id,
                    "rate"=>$rate
                );
                $isSuccess = $this->Rate_Model->create($payload);
            }

            if($isSuccess){
                $this->res(1,null,"Successfully Added",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

        public function rating_get($product_id){
            $data = $this->Rate_Model->getRating($product_id);

            $this->res(1,$data[0],"gg",0);
        }
    }
?>