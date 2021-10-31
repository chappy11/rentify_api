<?php 

    class Pet_Model extends CI_Model{

        private $table = "pet";
        
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        public function getAllpet(){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->join('user','user.user_id = pet.user_id');
            $query = $this->db->get();
            return $query->result();
        }


        public function getpet($id){
            $this->db->select("*");
            $this->db->where("pet_id",$id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function getpets($id){
            $this->db->select("*");
            $this->db->where("user_id",$id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($id,$data){
            return $this->db->update($this->table,$data,"pet_id=".$id);
        }

        public function lastIndex(){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->limit(1);
            $this->db->order_by("pet_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }
    }

?>