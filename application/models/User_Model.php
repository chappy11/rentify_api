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

        public function checkUserNameExist($username){
            $this->db->select("username");
            $this->db->from($this->tbl);
            $this->db->where("username",$username);
            $query = $this->db->get();
            if(count($query->result()) > 0){
                return true;
            }else{
                return false;
            }
        }

        public function getNewUser(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->order_by("user_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }
        
        public function updateUser($id,$data){
            return $this->db->update($this->tbl,$data,"user.user_id=".$id);
        }

        public function deleteUser($user_id){
            return $this->db->delete($this->tbl,array("user_id"=>$user_id));
        }

        public function checkDataExist($compareData){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where(array_keys($compareData),array_values($compareData));
            $query = $this->db->get();
            return $query->result();
        }

        public function getUserByStatus($roles,$status){
            $this->db->select("*");
            $this->db->from($this->tbl);
            if($status != 3){
                $this->db->where("user.user_status",$status);
            }
           
            if($roles == 2){
                $this->db->join("customer","customer.user_id=user.user_id");
            }else{
                $this->db->join("shop","shop.user_id=user.user_id");
            }
            $query =$this->db->get();
            return $query->result();
        }

        public function getuser($user_id){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            return $query->result();
        }
    }

?>