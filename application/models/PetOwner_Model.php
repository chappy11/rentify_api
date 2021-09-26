<?php 

    

    class PetOwner_Model extends CI_Model{
       
        private $table = 'pet_owner';

        public function __construct(){
            parent::__construct();
            $this->load->database(); 
        }

        // public function isEmailExist($email){
        //     $this->db->select("*"); // select (*)
        //     $this->db->from($this->table); // from table
        //     $this->db->where('owner_email',$email); // where email='datainput'
        //     $query = $this->db->get(); // run the sql 
        //     return count($query->result) > 0 ? true : false;
        // }
        

        public function login($email,$password){
            $this->db->select("*"); //select *
            $this->db->from("pet_owner"); //from table petowner
            $this->db->where("owner_email",$email); // where email='admin'
            $this->db->where("password",$password); // password="123"
            $query = $this->db->get();
            return $query->result();
            //select * from pet_owner where owner_email='admin' AND password='123';
        }

        public function register($data){
            return $this->db->insert("pet_owner",$data);
        }
    }

?>