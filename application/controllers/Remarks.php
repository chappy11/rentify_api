<?php 
   include_once(dirname(__FILE__)."/Data_format.php");

    class Remarks extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Remarks_Model"));
        }
  
        public function remark_get($shoporder_id){
            $data = $this->Remarks_Model->getRemarks($shoporder_id);

            $this->res(1,$data[0],"GG",0);
        }
  
    }
?>