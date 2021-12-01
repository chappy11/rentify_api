<?php 

    class Notification_Model extends CI_Model{

        private $table = "notification";
        public function __construct(){
            parent::__construct();
            $this->load->database();

        }

        public function createNotif($data){
            return $this->db->insert($this->table,$data);
        }

        public function getNotifications($user_id){
            $this->db->select("*");
            $this->db->where("user_id",$user_id);
            $this->db->from($this->table);
            $this->db->order_by("notif_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }


        public function unread($id){
            $this->db->select("*");
            $this->db->where("user_id",$id);
            $this->db->where("notif_status",0);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function getNotification($notif_id){
            $this->db->select("*");
            $this->db->where("notif_id",$notif_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($id,$data){
            return $this->db->update($this->table,$data,"notif_id=".$id);
        }
    }

?>