<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class Pet extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Pet_Model"));
        }

        public function getpet_get(){
            $data = $this->Pet_Model->getpets();
            if(count($data)){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data Not found",0);
            }
        }
    }
?>