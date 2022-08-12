<?php 

    class Subscription_Model extends CI_Model{
        
        private $tbl_name = "subscription";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function createNewSubcription($data=array()){
            return $this->db->insert($this->tbl_name,$data);
        }

        public function getAllSubscription(){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $query = $this->db->get();
            return $query->result();
        }

        public function getSubscriptionById($id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("subscription_id",$id);
            $query = $this->db->get();
            return $query->result();
        }

        public function updateSubscription($id,$data){
            return $this->db->update($this->tbl_name,$data,"subscription_id=".$id);
        }
    }

?>