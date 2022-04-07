<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Motourista extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model();
        }

        public function becomeMotourista_post(){
            $data = $this->decode();
            $user_id = isset($data->$user_id) ? $data->user_id : "";   
            
        }
    
        

    }
?>