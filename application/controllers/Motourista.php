<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Motourista extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Motourista_Model"));
        }

        public function becomeMotourista_post(){
            $data = $this->decode();
            $user_id = isset($data->user_id) ? $data->user_id : "";   
            $name = isset($data->name) ? $data->name : "";
            $lat = isset($data->lat) ? $data->lat : "";
            $lng = isset($data->lng) ? $data->lng : "";
            
            $payload = array(
                "user_id" => $user_id,
                "motour_name" => $name,
                "latitude" => $lat,
                "longitude" => $lng,
                "isActive" => 0
            );

            $resp = $this->Motourista_Model->addMotourista($payload);
            if($resp){
                $this->res(1,null,"Successfully Added",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }
        
        public function getmotouristabyuser_get($user_id){
            $data = $this->Motourista_Model->getmotouristabyuser($user_id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",count($data));
            }else{
                $this->res(0,null,"No data found",0);
            }
  
  
        }
  
        public function activateMotourista_post(){
            $data = this
        }
    }
?>