<?php 
    class Negotiable_Model extends CI_Model{
        
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function add($data=array()){
            return $this->db->insert("negotiable",$data);
        }


        public function viewnegotiable($user_id,$product_id){
            $this->db->select("*");
            $this->db->where("product_id",$product_id);
            $this->db->where("user_id",$user_id);
            $this->db->from("negotiable");
            $query = $this->db->get();
            return $query->result();
        }

        public function viewrequest($garage_id){
            $this->db->select("*");
            $this->db->where("negotiable.garage_id",$garage_id);
            $this->db->where("negotiable.neg_status","unaccept");
            $this->db->from("negotiable");
            $this->db->join("product","product.product_id=negotiable.product_id");
            $this->db->join("item","item.item_id=product.item_id");
            $this->db->join("account","account.acnt_id=negotiable.user_id");
            $query = $this->db->get();
            return $query->result();
        }


        public function update($nego_id,$data=array()){
            return $this->db->update("negotiable",$data,"nego_id=".$nego_id);
        }
    }

?>