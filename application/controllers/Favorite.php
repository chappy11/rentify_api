<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Favorite extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Favorite_Model"));
        }

        public function insert_post($user_id,$motor_id){
            $payload = array(
                "user_id" => $user_id,
                "motor_id" => $motor_id
            );
            $resp = $this->Favorite_Model->insert($payload);
            if($resp){
                $this->res(1,null,"Successfully Added to You Favorite",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }

        public function check_get($user_id,$motor_id){
            $data = $this->Favorite_Model->check($user_id,$motor_id);
            if(count($data)){
                $this->res(1,$data,"Data found",1);
            }else{
                $this->res(0,null,"Data found",0);
            }
        }

        public function getfav_get($user_id){
            $data = $this->Favorite_Model->getbyuser($user_id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    }


?>