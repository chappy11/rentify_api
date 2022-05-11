<?php 


class Booking_Model extends CI_Model{

    private $table = "booking";
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function insert($arr=array()){
        return $this->db->insert($this->table,$arr);
    }

    public function checkpending($user_id,$motor_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("user_id",$user_id);
        $this->db->where("booking_status",0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getbyuserid($user_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("booking.user_id",$user_id);
        $this->db->where("booking.booking_status <",3);
        $this->db->join("vehicle","vehicle.motor_id=booking.motor_id");
        $this->db->join("user","user.user_id=vehicle.user_id");
        $query = $this->db->get();
        return $query->result();
    }

    public function update($id,$arr=array()){
        return $this->db->update($this->table,$arr,"booking_id=".$id);
    }

    public function getbyid($id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("booking_id",$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getbymotorid($motor_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("motor_id",$motor_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getpending($motor_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("booking_status",0);
        $query = $this->db->get();
        return  $query->result();
    }

    public function getmybookinglist($owner_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("vehicle.user_id",$owner_id);
        $this->db->where("booking.booking_status",0);
        $this->db->join("vehicle","vehicle.motor_id=booking.motor_id");
        $this->db->join("user","user.user_id=booking.user_id");
        $query = $this->db->get();
        return $query->result();
    }

    public function getongoing($owner_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("vehicle.user_id",$owner_id);
        $this->db->where("booking.booking_status >",0);
        $this->db->where("booking.booking_status <",3);
     //   $this->db->where("booking.onStart",1);
        $this->db->join("vehicle","vehicle.motor_id=booking.motor_id");
        $this->db->join("user","user.user_id=booking.user_id");
        $query = $this->db->get();
        return $query->result();

    }

    public function getdatelist($motor_id){
        $this->db->select("start_date,end_date");
        $this->db->from($this->table);
        $this->db->where("motor_id",$motor_id);
        $query= $this->db->get();
        return $query->result();
    }

    public function getvalidate($motor_id){
        $this->db->select("start_date,end_date");
        $this->db->from($this->table);
        $this->db->where("motor_id",$motor_id);
        $this->db->where("booking_status",1);
        $query = $this->db->get();
        return $query->result();
    }

    public function tourista($booking_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("booking.booking_id",$booking_id);
        $this->db->join("vehicle","vehicle.motor_id=booking.motor_id");
        $this->db->join("user","user.user_id=vehicle.user_id");
        $this->db->join("motourista","motourista.user_id=vehicle.user_id");
        $query = $this->db->get();
        return $query->result();
    }
  
    public function motourista($booking_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("booking.booking_id",$booking_id);
        $this->db->join("vehicle","vehicle.motor_id=booking.motor_id");
        $this->db->join("user","user.user_id=booking.user_id");
        $this->db->join("motourista","motourista.user_id=vehicle.user_id");    
        $query = $this->db->get();
        return $query->result();
    }

    public function checkbooking($id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("booking.booking_status <",2);
        $this->db->where("motor_id",$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function booking_history($user_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("booking.booking_status",5);
        $this->db->where("booking.booking_status",3);
        $this->db->or_where("vehicle.user_id",$user_id);
        $this->db->join("vehicle","vehicle.motor_id=booking.motor_id");
        $this->db->join("user","user.user_id=booking.user_id");
        $this->db->order_by("booking.booking_id","DESC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getearnings($motor_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("booking.booking_status",5);
        $this->db->where("booking.motor_id",$motor_id);
        $query = $this->db->get();
        return $query->result();
    }
}

?>