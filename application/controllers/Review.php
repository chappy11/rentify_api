<?php 
include_once(dirname(__FILE__).'/Data_format.php');

    class Review extends Data_format{


        public function __construct(){
            parent::__construct();
            $this->load->model(array("Review_Model"));
        }

        public function review_post(){
            $data = $this->decode();
            $motor_id = isset($data->motor_id) ? $data->motor_id : "";
            $review = isset($data->review) ? $data->review : "";
            $rate = isset($data->rate) ? $data->rate : "";

            $arr = array(
                "motor_id" => $motor_id,
                "user_review" => $review,
                "rate" => $rate
            );

            $insert = $this->Review_Model->insert($arr);
            if($insert){
                $this->res(1,null,"Thank You for the using the app",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }

        public function getreview_get($motor_id){
            $data = $this->Review_Model->getbymotorid($motor_id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    }


?>