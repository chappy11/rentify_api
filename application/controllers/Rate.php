<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Rate extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array('Rate_Model','UserOrder_Model','OrderItem_Model'));
        }

        public function rate_post(){
            $data = $this->decode();
            $user_id = $data->user_id;
            $product_id = $data->product_id;
            $rate = $data->rate;
            $orders = $this->UserOrder_Model->getOrderByUserId($user_id);
            $hasError = 0;
            foreach($orders as $val){
                $orderItem = $this->OrderItem_Model->getOrderItemByOrderId($val->order_id);
                foreach($orderItem as $item){
                    if($item->product_id === $product_id){
                        $hasError = 1;
                    }
                }
            }

            if($hasError == 1){
                $this->res(0,null," Order first before rating this product",0);
            }else{

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


            
        }

        public function rating_get($product_id){
            $data = $this->Rate_Model->getRating($product_id);

            $this->res(1,$data[0],"gg",0);
        }
    }
?>