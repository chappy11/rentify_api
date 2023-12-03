<?php

    class Rate_Model extends CI_Model{
        
        private $table = 'rating';

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->table,$payload);
        }

        public function getById($ownerId,$renterId){    
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("renter_id",$renterId);
            $this->db->where('owner_id',$ownerId);
            $query = $this->db->get();
            return $query->result();
        }
    
        public function updateRating($ratingid,$payload){
            return $this->db->update($this->table,$payload,'rating_id='.$ratingid);
        }
    
    }

?>