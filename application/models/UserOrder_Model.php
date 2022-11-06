<?php 

    class UserOrder_Model extends CI_Model{

        private $table_name = "orders";

        public function __construct(){
            
            parent::__construct();
            
            $this->load->database();
        }

        public function createNewOrder($payload=array(),$user_id){
            $isInsert = $this->db->insert($this->table_name,$payload);
            if($isInsert){
                return $this->getLatestOrder($user_id);
            }else{
                return null;
            }
        }

        public function getLatestOrder($user_id){
            $this->db->select("*");
            $this->db->from($this->table_name);
            $this->db->where("user_id",$user_id);
            $this->db->order_by("order_id","DESC");
            $query =$this->db->get();
            return $query->result();
        }

        public function getOrderByUserId($user_id){
            $this->db->select("*");
            $this->db->from($this->table_name);
            $this->db->where("user_id",$user_id);
            $this->db->order_by('order_id','DESC');
            $query = $this->db->get();
            return $query->result();
        }

        public function getOrderByOrderId($order_id){
            $this->db->select("*");
            $this->db->from($this->table_name);
            $this->db->where("orders.order_id",$order_id);
            $this->db->join("customer","customer.user_id=orders.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        public function update($data,$order_id){
            return $this->db->update($this->table_name,$data,array("order_id"=>$order_id));
        }
        
    }

?>