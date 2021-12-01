<?php 

    class Payment_Model extends CI_Model{
        private $table = "payment";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        
        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        public function getPayment($transac_id){
            $this->db->select("*");
            $this->db->where("transac_id",$transac_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($payment_id,$data){
            return $this->db->update($this->table,$data,"payment_id=".$payment_id);
        }
   
    }


?>