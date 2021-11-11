<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Routine extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Routine_Model"));
        }


        public function createRoutine_post(){
            $data = $this->decode();
            $this->res(1,$data->arr,"GG",0);
        }
    }

?>