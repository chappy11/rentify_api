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
        $q = $this->db->get();
        return $q->result();
    }

    //register user
    public function register($data=array()){
        return $this->db->insert("user",$data);
    }

    //login user
    public function login($data=array()){
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where($data);
        $query = $this->db->get();
        return $query->result();
    }

    //update user such a password, status, and acount details
    public function update($id,$data=array()){
        return $this->db->update('user', $data, "user_id = ".$id);
    }

   
}


?>