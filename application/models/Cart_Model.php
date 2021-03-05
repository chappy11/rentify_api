<?php 

    class Cart_Model extends CI_Model{
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }


        public function addtocart($data=array()){
            return $this->db->insert("cart",$data);
        }

        public function getcart($buyer_id,$garage_id){
                $this->db->select("*");
                $this->db->where("cart.buyer_id",$buyer_id);
                $this->db->where("cart.garage_id",$garage_id);
                $this->db->from("cart");
                $this->db->join("product","product.product_id=cart.product_id");
                $this->db->join("item","item.item_id=product.item_id");
              
                $query = $this->db->get();
                return $query->result();
            }

        public function updatecart($cart_id,$data=array()){
            return $this->db->update("cart",$data,"cart_id=".$cart_id);
        }

        public function checkitem($product_id,$garage_id,$buyer_id){
            $this->db->select("*");
            $this->db->where("product_id",$product_id);
            $this->db->where("garage_id",$garage_id);
            $this->db->where("buyer_id",$buyer_id);
            $this->db->from("cart");
            $query = $this->db->get();
            return $query->result();
        }

        public function checkcart($cart_id){
            $this->db->select("*");
            $this->db->where("cart_id",$cart_id);
            $this->db->from("cart");
            $query = $this->db->get();
            return $query->result();
        }

        public function removeitem($cart_id){
            $this->db->where("cart_id",$cart_id);
            return $this->db->delete("cart");
        }

        public function removeproduct($product_id){
            $this->db->where("product_id",$product_id);
            return $this->db->delete("cart");
        }
    }

?>