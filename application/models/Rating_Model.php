<?php 

    class Rating_Model extends CI_Model{

        private $table = "rating";
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        public function getRating($user_id){
            $this->db->select("*");
            $this->db->where("user_id",$user_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        

    }

?>