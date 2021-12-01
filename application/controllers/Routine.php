<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Routine extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Routine_Model"));
        }


        public function createRoutine_post(){
            $data = $this->decode();
            $id = $data->pet_id;
            $day = isset($data->day) ? $data->day : "";
            $hour = isset($data->hours) ? $data->hours : "";
            $des = isset($data->des) ? $data->des : "";
            
            $arr = array(
                "pet_id" => $id,
                "day" => $day,
                "hours" => $hour,
                "routine" => $des
            );
            
            $result = $this->Routine_Model->insert($arr);
            if($result){
                $this->res(1,null,"Successfully Added",0);
            }else{
                $this->res(0,null,"Error Adding",0);
            }
        }

        public function getroutine_get($pet_id){
            $result = $this->Routine_Model->getroutine($pet_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function removeroutine_post($routine_id){
            $arr = array(
                "routine_id" => $routine_id
            );
            
            $result = $this->Routine_Model->removeroutine($arr);
            if($result){
                $this->res(1,null,"Successfully Removed",0);
            }else{
                $this->res(0,null,"Error Removing",0);
            }
        }
    }

?>