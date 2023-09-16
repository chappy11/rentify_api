<?php 

    class Vehicle_Model extends CI_Model{
        private $tbl = "vehicles";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

  
        public function createVehicle($payload=array()){
            return $this->db->insert($this->tbl,$payload);            
       }


    }
?>