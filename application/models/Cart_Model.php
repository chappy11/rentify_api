<?php 

class Cart_Model extends CI_Model{

    private $tbl_name = "cart";

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function addToCart($data=array()){
        return $this->db->insert($this->tbl_name,$data);
    }

    public function myCart($user_id){
        $this->db->select("*");
        $this->db->from($this->tbl_name);
        $this->db->where("cart.user_id",$user_id);
        $this->db->join("product","product.product_id=cart.product_id");
        $this->db->join("shop","shop.shop_id=product.shop_id");
        $query =$this->db->get();
        return $query->result();
    }

    public function updateCart($cart_id,$updatedData=array()){
        return $this->db->update($this->tbl_name,$updatedData,"cart_id=".$cart_id);
    }

    public function getCartItemById($cart_id){
        $this->db->select("*");
        $this->db->from($this->tbl_name);
        $this->db->where("cart_id",$cart_id);
        $query = $this->db->get();
        return $query->result();
    }
}
?>