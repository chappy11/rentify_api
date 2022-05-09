<?php 

    class Payment_Model extends CI_Model{

        private $table = "payment";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data=array()){
            return $this->db->insert($this->table,$data);
        }

        public function getbyuser($user_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("user_id",$user_id);
            $this->db->order_by("payment_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }
    }
?>