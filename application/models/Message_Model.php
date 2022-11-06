<?php 

    class Message_Model extends CI_Model{

        private $table = "message";
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
 
        public function createMessage($arr){
            return $this->db->insert($this->table,$arr);
        }

        public function getRecieverList($sender_id){
            $this->db->select("*");
            $this->db->group_by('reciever_id'); 
            $this->db->from($this->table);
            $this->db->where("message.sender_id",$sender_id);
            $this->db->join("customer","customer.user_id=message.reciever_id","left");
            $this->db->join("shop","shop.user_id=message.reciever_id",'left');
            $query = $this->db->get();
            return $query->result();
        }

        public function getMessage($sender_id,$reciever_id){
            $wher = "(message.reciever_id='$reciever_id' AND message.sender_id='$sender_id') OR (message.reciever_id='$sender_id' AND message.sender_id='$reciever_id')";
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where($wher);
            $this->db->join("customer","customer.user_id=message.sender_id","left");
            $this->db->join("shop","shop.user_id=message.sender_id",'left');
            $this->db->order_by("message_date");
            $query = $this->db->get();
            return $query->result();
        }
 
        public function getLastMessage($sender_id,$reciever_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("sender_id",$sender_id);
            $this->db->where("reciever_id",$reciever_id);
            $this->db->order_by("msg_id","DESC");
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->result();
        }

        public function updateStatus($sender_id,$reciever_id){
            $status = array("msg_status" => 1);
            $arr = array("sender_id" => $sender_id, "reciever_id" => $reciever_id);
            return $this->db->update($this->table,$status,$arr);
        }
    }
?>