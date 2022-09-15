<?php 

    class OrderItem_Model extends CI_Model{

        private $tbl_name = "orderitem";
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function insert($data=array()){
            return $this->db->insert($this->tbl_name,$data);
        }

        public function getOrderItem($order_id,$shop_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("product.shop_id",$shop_id);
            $this->db->where("order_id",$order_id);
            $this->db->join("product","product.product_id=orderitem.product_id");
            $query = $this->db->get();
            return $query->result();
        }

        public function getOrderItemByOrderId($order_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("order_id",$order_id);
            $this->db->join("product","product.product_id=orderitem.product_id");
            $query = $this->db->get();
            return $query->result();
        }

    }
?>