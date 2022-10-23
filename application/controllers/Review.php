<?php
    include_once(dirname(__FILE__)."/Data_format.php");

    class Review extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Review_Model"));
        }

        public function create_post(){
            $data = $this->decode();
            $resp = $this->Review_Model->create($data);

            if($resp){
                $this->res(1,null,"Successsfully Created",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
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