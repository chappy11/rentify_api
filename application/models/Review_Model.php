<?php 


    class Review_Model extends CI_Model{

        private $table = "review";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }


        public function insert($data = array()){
            return $this->db->insert($this->table,$data);
        }


        public function getbymotorid($motor_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("motor_id",$motor_id);
            $query = $this->db->get();
            return $query->result();
        }
    }


?>