<?php 

    class Brand_Model extends CI_Model{

        private $table = 'brand';
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }


        public function insert($payload){
            return $this->db->insert($this->table,$payload);
        }  

        public function getAllBrand(){
            $this->db->select("*");
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }
    }

?>