<?php 



    class Petimg_Model extends CI_Model{

        private $table = "pet_images";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        public function getimages($pet_id){
            $this->db->select("*");
            $this->db->where("pet_id",$pet_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }
    }


?>