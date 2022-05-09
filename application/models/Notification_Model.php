<?php 

    class Notification_Model extends CI_Model{

        private $table = "notification";
        public function __construct(){
            parent::__construct();
            $this->load->database();

        }

        public function insert($data=array()){
            return $this->db->insert($this->table,$data);
        }

        public function getnotifbyuser($user_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("user_id",$user_id);
            $this->db->order_by("notif_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }
        

        public function getnotifbyid($notif_id){
            $this->db->select("*");
            $this->db->from($table);
            $this->db->where("notif_id",$notif_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($notif_id,$data=array()){
            return $this->db->update($this->table,$data,"notif_id=".$notif_id);
        }
    }

?>