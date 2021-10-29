<?php 

    class Certification_Model extends CI_Model{

        private $table = "certification";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }
    }
?>