<?php 

    class Motorcycle_Model extends CI_Model{

        private $table = "motorcycle";
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function addMotor($data=array()){
             return $this->db->insert($this->table,$data);
        }

        public function getlist(){
            $this->db->select("*");
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }
    }
?>