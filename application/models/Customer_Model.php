<?php 

    class Customer_Model extends CI_Model{

        private $tbl = "customer";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        
        //create new Customer
        public function createCustomer($customerData=array()){
            return $this->db->insert($this->tbl,$customerData);
        }

        //get Customer by Id
        public function getCustomerByUserId($user_id){
           $this->db->select("*");
           $this->db->from($this->tbl);
           $this->db->where("customer.user_id",$user_id);
           $this->db->join("user","user.user_id=".$user_id);
           $query = $this->db->get();
           return $query->result();
        }
        
        public function getCustomerByStatus($status){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("user.user_status",$status);
            $this->db->join("user","user.user_id=customer.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        //get all customer
        public function getAllCustomer(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->join("user","user.user_id=customer.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        public function getCustomerEmail($email){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("email",$email);
            $query = $this->db->get();
            return $query->result();
        }       

        public function getPendingCustomer(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("user.user_roles!=",0);
            $this->db->where("user.user_status",0);
            $this->db->join("user","user.user_id=customer.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        public function checkIsEmailExist($email){
            $this->db->select("email");
            $this->db->from($this->tbl);
            $this->db->where("email",$email);
            $query = $this->db->get();
            if(count($query->result()) > 0){
                return true;
            }else{
                return false;
            }
        }

        public function checkMobileNumberExist($mobile){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("contact",$mobile);
            $query = $this->db->get();
            if(count($query->result()) > 0){
                return true;
            }else{
                return false;
            }
        }

        public function isEmailExist($user_id){
            $this->db->select("email");
            $this->db->from($this->tbl);
            $query = $this->db->get();
            if($query->result() > 0){
                return true;
            }
            return false;
        }

        public function getCustomer($user_id){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("user_id",$user_id);
            $this->db->join("user","user.user_id=customer.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        
              
    }
?>