<?php
    
    class PetUpdate_Model extends CI_Model{

        private $table = "update_pet";
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        public function getupdate($transac_id){
            $this->db->select("*");
            $this->db->where("transac_id",$transac_id);            
            $this->db->from($this->table);
            $this->db->order_by("update_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }

        public function update($id,$data){
            return $this->db->update($this->table,$data,"update_id=".$id);
        }
    }


?>