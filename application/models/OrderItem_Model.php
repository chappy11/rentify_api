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

        public function getitemSalable($shop_id){
            $query = $this->db->query("SELECT DISTINCT orderitem.product_id FROM `orderitem` LEFT JOIN product ON orderitem.product_id = product.product_id LEFT JOIN shopreport ON orderitem.order_id = shopreport.order_id WHERE product.shop_id =".$shop_id." AND MONTH(shopreport.date_success) =  MONTH(CURRENT_DATE())");
            return $query->result();
        }

        public function getitemSalableByMonth($shop_id,$month){
            $query = $this->db->query("SELECT DISTINCT orderitem.product_id FROM `orderitem` LEFT JOIN product ON orderitem.product_id = product.product_id LEFT JOIN shopreport ON orderitem.order_id = shopreport.order_id WHERE product.shop_id =".$shop_id." AND MONTH(shopreport.date_success) =  $month");
            return $query->result();
        }

        public function getOrderItemByProductId($product_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("product.product_id",$product_id);
            $this->db->join("product","product.product_id=orderitem.product_id");
            $query = $this->db->get();
            return $query->result();
        }
    }
?>