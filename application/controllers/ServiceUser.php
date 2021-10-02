<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class ServiceUser extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("ServiceUser_Model"));
        }


        public function getUser_get(){
            $data = $this->ServiceUser_Model->getserviceUsers();
            if(count($data) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }


    }

?>