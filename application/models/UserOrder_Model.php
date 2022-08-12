<?php 

    class UserOrder_Model extends CI_Model{

        private $table_name = "orders";

        public function __construct(){
            
            parent::__construct();
            
            $this->load->database();
        }

        public function createNewOrder($payload=array()){
            return $this->db->insert($this->table_name,$payload);
        }

        public function getLatestOrder(){
            $this->db->select("*");
            $this->db->from($this->table_name);
            $this->db->order_by("order_id","DESC");
            $query =$this->db->get();
            return $query->result();
        }

        public function getOrderByUserId($user_id){
            $this->db->select("*");
            $this->db->from($this->table_name);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            return $query->result();
        }
        
    }

?>