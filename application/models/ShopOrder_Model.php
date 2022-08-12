<?php 

    class ShopOrder_Model extends CI_Model{

        public function __construct(){
            
            parent::__construct();
            $this->load->database();
        }

        public function createShopOrder($data=array()){
            return $this->db->insert($data);
        }

    }
?>