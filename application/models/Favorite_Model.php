<?php 

class Favorite_Model extends CI_Model{

    private $table = "favorite";

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function insert($data=array()){
        return $this->db->insert($this->table,$data);
    }

    public function check($user_id,$motor_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("user_id",$user_id);
        $this->db->where("motor_id",$motor_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getbyuser($user_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("favorite.user_id",$user_id);
        $this->db->join("vehicle","vehicle.motor_id=favorite.motor_id");
        $query = $this->db->get();
        return $query->result();
    }

    public function remove($data=array()){
        return $this->db->delete($this->table,$data);
    }
}

?>