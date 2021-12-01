<?php 

    class Routine_Model extends CI_Model{

        private $table = "routine";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }
    
        public function getroutine($pet_id){
            $this->db->select("*");
            $this->db->where("pet_id",$pet_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function removeroutine($data){
            return $this->db->delete($this->table,$data);
        }
    }


?>