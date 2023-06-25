<?php
    include_once(dirname(__FILE__)."/Data_format.php");

    class Review extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Review_Model",'UserOrder_Model','OrderItem_Model'));
        }

        public function create_post(){
            $data = $this->decode();
            $user_id = $data->user_id;
            $product_id = $data->product_id;

            $orders = $this->UserOrder_Model->getOrderByUserId($user_id);
            $hasError = 0;
            foreach($orders as $val){
                $orderItem = $this->OrderItem_Model->getOrderItemByOrderId($val->order_id);
                foreach($orderItem as $item){
                    if($item->product_id == $product_id){
                        $hasError = 1;
                    }
                }
            }

            if($hasError == 0){
                $this->res(0,null," Order first before reviewing this product",0);
            }else{
                $resp = $this->Review_Model->create($data);

                if($resp){
                    $this->res(1,null,"Successsfully Created",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
    
            }            

       }
        
        public function reviews_get($product_id){
            $data = $this->Review_Model->getReview($product_id);

            if(count($data) > 0){
                $this->res(1,$data,"gg",0);
            }else{
                $this->res(0,null,"data not found",0);
            }
        }
    }


?>