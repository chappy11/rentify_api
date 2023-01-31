<?php 

 class Notification_Model extends CI_Model{

    private $table_name = 'notification';

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function create($data){
        return $this->db->insert($this->table_name,$data);
    }

    public function getNotif($user_id){
        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where("notif_receiver",$user_id);
        $this->db->order_by("notif_date","DESC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getUnread($user_id){
        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where("notif_receiver",$user_id);
        $this->db->where("isRead",0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNotification($notif_id){
        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where("notif_id",$notif_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateNotification($notif_id,$data){
        return $this->db->update($this->table_name,$data,"notif_id=".$notif_id);
    }

}

?>