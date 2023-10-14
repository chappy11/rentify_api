<?php 
    class Transaction_Model extends CI_Model{
        private $tbl_name = 'transaction';
        
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($payload){
            return $this->db->create($this->tbl_name,$payload);
        }

        public function getTransactionById($refId){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->where('ref_id',$refId);
            $query = $this->db->get();
            return $query->result();
        }

    }
?>