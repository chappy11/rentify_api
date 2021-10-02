<?php 

    class ServiceUser_Model extends CI_Model{

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function getserviceUsers(){
            $this->db->select("*");
            $this->db->from("serviceuser");
            $query = $this->db->get();
            return $query->result();
        }
    }

?>