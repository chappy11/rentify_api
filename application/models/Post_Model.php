<?php

    class Post_Model extends CI_Model{

        private $table = "posts";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function createPost($data){
            return $this->db->insert($this->table,$data);
        }


        public function allPost(){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->join("service","service.service_id=posts.service_id");
            $this->db->join("user","user.user_id=service.user_id");
            $query = $this->db->get();
            return $query->result();
        }
    
        public function getpostservice($service_id){
            $this->db->select("*");
            $this->db->where("service_id",$service_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }        
    
    }

?>