<?php 

    class Product_Model extends CI_Model{
        
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function add($product = array()){
            return $this->db->insert("product",$product);
        }

        public function viewProduct($garage_id){
            $this->db->select('*');
            $this->db->from('product');
            $this->db->where('garage_id',$garage_id);
            $this->db->where('item.item_status',"garage");
            $this->db->join('item', 'item.item_id = product.item_id');
            $query = $this->db->get();
            return $query->result();
        }
    }

?>