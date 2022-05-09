<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class History extends Data_format{
        
        public function __construct(){
            parent::__construct();
            $this->load->model(array("History_Model"));
        }

        public function gethistory_get($rec_id){
            $data = $this->History_Model->gethistory($rec_id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"data not found",0);
            }
        }
    }


?>