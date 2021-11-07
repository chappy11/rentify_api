<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class UserCert extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Certification_Model"));
        }

        public function getCert_get($user_id){
            $result = $this->Certification_Model->getcert($user_id);
            
            if(count($result) > 0 ){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    }


?>