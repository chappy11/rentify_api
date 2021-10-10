<?php

class User_Model extends CI_Model{

    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //view all user
    public function user_list(){
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("user_type","user");
        $q = $this->db->get();
        return $q->result();
    }

    //register user
    public function register($data=array()){
        return $this->db->insert("user",$data);
    }

    //login user
    public function login_admin($email,$password){
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("email",$email);
        $this->db->where("password",$password);
        $query = $this->db->get();
        return $query->result();
    }

    public function login($email,$password){
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("email",$email);
        $this->db->where("password",$password);
      
        $query =$this->db->get();
        return $query->result();
    }

    //update user such a password, status, and acount details
    public function update($id,$data=array()){
        return $this->db->update('user', $data, "user_id = ".$id);
    }

    //search this email
    public function isEmailExist($email){
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("email",$email);
        $query = $this->db->get();
        return $query->result();
    }

   
}


?>