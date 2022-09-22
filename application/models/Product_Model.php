<?php

    class Product_Model extends CI_Model{

        private $tbl_name = "product";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function createNewProduct($data=array()){
            return $this->db->insert($this->tbl_name,$data);
        }

        public function getProductById($product_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("product_id",$product_id);
            $this->db->join("category","category.category_id=product.category_id");
            $this->db->join("shop","shop.shop_id=product.shop_id");
            $query = $this->db->get();
            return $query->result();
        }

        
        public function displayProduct(){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("product.stock >",0);
            $this->db->join("category","category.category_id=product.category_id");
            $this->db->join("shop","shop.shop_id=product.shop_id");
            $query = $this->db->get();
            return $query->result();
        }
        
        public function getProductByShopId($shop_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("product.shop_id",$shop_id);
            $this->db->join("category","category.category_id=product.category_id");
            $this->db->join("shop","shop.shop_id=product.shop_id");
            $query =$this->db->get();
            return $query->result();
        }

        public function getAllProducts(){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->join("category","category.category_id=product.category_id");
            $this->db->join("shop","shop.shop_id=product.shop_id");
            $query = $this->db->get();
            return $query->result();
        }

  
        
        public function displayProducts(){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("shop.subscription_id >",0);
            $this->db->join("category","category.category_id=product.category_id");
            $this->db->join("shop","shop.shop_id=product.shop_id");
            $query = $this->db->get();
            return $query->result();
        }

        public function updateProduct($id,$data=array()){
            return $this->db->update($this->tbl_name,$data,"product_id=".$id);
        }
    }
?>