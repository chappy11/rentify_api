<?php 


    class Expenses_Model extends CI_Model{

        private $table = "expenses";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);;
        }

        public function getTrans($trans_id){
            $this->db->select("*");
            $this->db->where("transac_id",$trans_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

    
    }

?>