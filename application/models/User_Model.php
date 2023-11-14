<?php 

    class User_Model extends CI_Model{
        private $tbl = "users";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        //create new User
        public function createUser($user=array()){
            return $this->db->insert($this->tbl,$user);
        }

        //login user

        //select * from user where username='kye' && password='1234kye'
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
            return $this->db->update($this->tbl,$data,"users.user_id=".$id);
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

        public function getuser($user_id){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function getUserById($userId){
            return $this->db->get_where($this->tbl,['user_id'=>$userId])->row();
        }

        public function update($id,$payload){
            return $this->db->update($this->tbl,$payload,'user_id='.$id);
        }
  
        public function getuserbystatus($status){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("user_status",$status);
            $this->db->join("owner_documents",'owner_documents.user_id=users.user_id','LEFT');
            $query= $this->db->get();
            return $query->result();
        }
    }

?>