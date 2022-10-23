<?php

    class Review_Model extends CI_Model{

        private $tble = "review";
        
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($data=array()){
            return $this->db->insert($this->tble,$data);
        }

        public function getReview($product_id){
            $this->db->select("*");
            $this->db->from($this->tble);
            $this->db->where("product_id",$product_id);
            $this->db->join("user","user.user_id=review.user_id");
            $query = $this->db->get();
            return $query->result();
        }


    }
?>