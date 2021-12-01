<?php 

    class Subscription_Model extends CI_Model{

        private $table = "subscription";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }


        public function getSub(){
            $this->db->select("*");
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($id,$data){
            return $this->db->update($this->table,$data,"sub_id=".$id);
        }

        public function sub($id){
            $this->db->select("*");
            $this->db->where("sub_id",$id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }
       
    }

?>