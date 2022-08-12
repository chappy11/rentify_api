<?php 

    class Category_Model extends CI_Model{

        private $tbl_name = "category";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function createNewCategory($data){
            return $this->db->insert($this->tbl_name,$data);
        }

        public function getAllCategory(){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $query =$this->db->get();
            return $query->result();
        }

    }

?>