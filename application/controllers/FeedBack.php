<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class FeedBack extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("FeedBack_Model"));
        }

        public function getfeedback_get($id){
            
            $result = $this->FeedBack_Model->getfeedback($id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"data not found",0);
            }
        }
    }
?>