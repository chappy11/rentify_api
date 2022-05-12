<?php 
include_once(dirname(__FILE__)."/Data_format.php");


    class Reports extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Report_Model"));
        }


        public function getallreport_get(){
            $data = $this->Report_Model->getallreport();
            $total = 0;
            foreach($data as $val){
                $total = $total + $val->amount;
            }
            if(count($data) > 0){
                $this->res(1,$data,"Successfully ",$total);
            }else{
                $this->res(0,null,"Successfully ",0);
            }
        }
    }

?>