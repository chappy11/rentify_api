<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Sublog extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Sublog_Model"));
        }
    
        public function getlogs_get($user_id){
            $result = $this->Sublog_Model->getlogs($user_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    
    }


?>