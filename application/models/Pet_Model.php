<?php 

    class Pet_Model extends CI_Model{

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function getpets(){
            $this->db->select("*");
            $this->db->from("pet");
            $this->db->join('user','user.user_id = pet.user_id');
            $query = $this->db->get();
            return $query->result();
        }
    }

?>