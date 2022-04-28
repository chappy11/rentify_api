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

    public function getmybookinglist($owner_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("vehicle.user_id",$owner_id);
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

    
}


?>