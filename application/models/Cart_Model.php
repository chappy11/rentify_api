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
        $this->db->join("category","category.category_id=product.category_id");
        $query =$this->db->get();
        return $query->result();
    }

    public function updateCart($cart_id,$updatedData=array()){
        return $this->db->update($this->tbl_name,$updatedData,"cart_id=".$cart_id);
    }

    public function removeItem($cart_id){
        return $cart_id;
    }

    public function getCartItemById($cart_id){
        $this->db->select("*");
        $this->db->from($this->tbl_name);
        $this->db->where("cart_id",$cart_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function deleteCart($cart_id){
        return $this->db->delete($this->tbl_name,array("cart_id"=>$cart_id));
    }

    public function getCartItemByUser($user_id,$product_id){
        $this->db->select("*");
        $this->db->from($this->tbl_name);
        $this->db->where('user_id',$user_id);
        $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getActiveItemByUser($user_id){
        $this->db->select("*");
        $this->db->from($this->tbl_name);
        $this->db->where("cart.user_id",$user_id);
        $this->db->where("cart.item_status",1);
        $this->db->join("product","product.product_id=cart.product_id");
        $this->db->join("shop","shop.shop_id=product.shop_id");
        $query = $this->db->get();
        return $query->result();
    }

    public function getCartByShopId($user_id,$shop_id){
        $this->db->select("*");
        $this->db->from($this->tbl_name);
        $this->db->where("cart.user_id",$user_id);
        $this->db->where("product.shop_id",$shop_id);
        $this->db->join("product","product.product_id=cart.product_id");
        $this->db->join("category","category.category_id=product.category_id");
        $query = $this->db->get();
        return $query->result();
    }
}
?>