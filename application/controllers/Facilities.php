<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Facilities extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Facility_Model"));
        }


        public function getfac_get($user_id){
            $result = $this->Facility_Model->getfac($user_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    }

?>