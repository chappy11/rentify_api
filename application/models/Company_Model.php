<?php 

    class Company_Model extends CI_Model{

        private $table = "company";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function addComp($data){
            return $this->db->insert($this->table,$data);
        }

        public function getcompany($user_id){
            $this->db->select("*");
            $this->db->where("user_id",$user_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }
    }

?>