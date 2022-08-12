<?php 

    class User_Model extends CI_Model{
        private $tbl = "user";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        //create new User
        public function createUser($user=array()){
            return $this->db->insert($this->tbl,$user);
        }

        //login user
        public function login($username,$password){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("username",$username);
            $this->db->where("password",$password);
            $query = $this->db->get();
            return $query->result();
        }

        public function getNewUser(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->order_by("user_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }
        
        public function deleteUser($user_id){
            return $this->db->delete($this->tbl,array("user_id"=>$user_id));
        }
    }

?>