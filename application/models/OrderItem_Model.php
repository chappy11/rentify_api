<?php 

    class OrderItem_Model extends CI_Model{

        private $tbl_name = "order"
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function insert($data=array()){
            return $this->db->insert($tbl_name,$data);
        }

    }
?>