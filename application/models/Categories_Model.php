<?php 

    class Categories_Model extends CI_Model{

        private $table = "categories";

        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->table,$payload);
        }

        public function getCategories(){
            $this->db->select("*");
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }
    }
?>