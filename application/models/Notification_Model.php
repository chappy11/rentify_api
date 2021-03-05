<?php 

    class Notification_Model extends CI_Model{

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
  
        //create notification
        public function create_notif($notif=array()){
            return $this->db->insert("notification",$notif);
        }

        public function view_notif($usr_id){
            $this->db->select("*");
            $this->db->where("acnt_id",$usr_id);
            $this->db->from("notification");
            $query = $this->db->get();
            return $query->result();
        }

        public function check_notif($notif_id){
            $this->db->select("*");
            $this->db->where("notif_id",$notif_id);
            $this->db->from("notifcation");
            $query = $this->db->result();
            return $query->result();
        }

        public function notif_unread($acnt_id){
            $this->db->select("*");
            $this->db->where("acnt_id",$acnt_id);
            $this->db->where("notif_read",0);
            $this->db->from("notification");
            $query = $this->db->get();
            return $query->result();
        }

        public function read($notif_id){
            $update = array(
                "notif_read"=>1
            );
            return $this->db->update("notification",$update,"notif_id=".$notif_id);
        }

        public function remove($notif_id){
            $this->db->where("notif_id",$notif_id);
            $this->db->delete("notification");
        }

        public function readAll($acnt_id){
            $update = array(
                "notif_read"=>1
            );
            return $this->db->update("notification",$update,"acnt_id=".$acnt_id);
        }

        public function removeall($acnt_id){
            $this->db->where("acnt_id",$acnt_id);
            $this->db->delete("notification");
        }
    }
?>