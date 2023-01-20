<?php 

    class Message_Connection_Model extends CI_Model{

        private $table = 'message_connection';
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($data){
            return $this->db->insert($this->table,$data);
        }

        public function getCustomerMessage($customer_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("message_connection.customer_id",$customer_id);
            $this->db->join("shop","shop.shop_id=message_connection.shop_id","LEFT");
            $query = $this->db->get();
            return $query->result();
        }

        public function getShopMessage($shop_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("message_connection.shop_id",$shop_id);
            $this->db->join("customer","customer.customer_id=message_connection.customer_id","LEFT");
            $query = $this->db->get();
            return $query->result();
        }

        public function getLatest($customer_id,$shop_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where('customer_id',$customer_id);
            $this->db->where("shop_id",$shop_id);
            $this->db->order_by("conn_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }

  
        public function getByConnectionId($conn_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("conn_id",$conn_id);
            $this->db->order_by("conn_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }
    }

?>