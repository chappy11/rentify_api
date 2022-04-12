<?php 
    include_once(dirname(__FILE__)."/Data_format.php");
    

    class Motorcycle extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Motorcycle_Model"));
        }

        public function getlist_get(){
            $data = $this->Motorcycle_Model->getlist();
            if(count($data ) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    }

?>