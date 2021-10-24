<?php 

    class ServiceUser_Model extends CI_Model{

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function getapply(){
            $this->db->select("*");
            $this->db->from("serviceuser");
            $this->db->where('sStatus','apply');
            $query = $this->db->get();
            return $query->result();
        }

        public function insert($data){
            return $this->db->insert("serviceuser",$data);
        }

        public function getuser($id){
            $this->db->select("*");
            $this->db->from("serviceuser");
            $this->db->where("user_id",$id);
            $query = $this->db->get();
            return $query->result();
        }

        public function getusers(){
            $this->db->select("*");
            $this->db->from('serviceuser');
            $this->db->where('sstatus!=','apply');
            $query = $this->db->get();
            return $query->result();
        }

        public function getprofile($id){
            $this->db->select("*");
            $this->db->from("serviceuser");
            $this->db->where("sUser_id",$id);
            $query = $this->db->get();
            return $query->result();
        }
        
    }

?>