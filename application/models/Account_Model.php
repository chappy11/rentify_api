<?php

class Account_Model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //Registration for user
    public function register($user=array()){
        return $this->db->insert("account",$user);
    }

    //Login For User
    public function login($email,$password){
        $this->db->select("*")->from("account")->group_start()->where("email",$email)->or_where("username",$email)->group_end()->where("password",$password);
        $query =  $this->db->get();
        return $query->result();
    }
    
    //Update user profile and status
    public function update($user=array(),$id){
        return $this->db->update('account',$user,'acnt_id='.$id);
    }

    //Get all all user
    public function getAll(){
        $this->db->select("*");
        $this->db->from("account");
        $query = $this->db->get();
        return $query->result();
    }
    
    //check wether the Email is Existed
    public function isEmailExist($email){
        $this->db->select("*");
        $this->db->where("email",$email);
        $this->db->from("account");
        $query = $this->db->get();
        $count = count($query->result());
        if($count > 0 ){
            return true;
        }else{
            return false;
        }
    
    }
    
    //View all user that is active or inactive
    public function user_status($status){
        $this->db->select("*");
        $this->db->where("status",$status);
        $this->db->from("account");
        $query = $this->db->get();
        return $query->result();
    }

    //get the Profile details
    public function profile($id){
        $this->db->select("*");
        $this->db->where("acnt_id",$id);
        $this->db->from("account");
        $query =  $this->db->get();
        return $query->result();
    }

    //check if the password is correct
    public function checkpass($id, $password){
        $this->db->select('*');
        $this->db->where('acnt_id',$id);
        $this->db->where("password",$password);
        $this->db->from("account");
        $query = $this->db->get();
        $count =  count($query->result());
        
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }  
    
    public function userlist($user){
        $this->db->select("*");
        $this->db->where('type',$user);
        $this->db->from('account');
        $query = $this->db->get();
        return $query->result();
    }
}

?>