<?php 

class History_Model extends CI_Model{

    private $table = "history";
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }


    public function insert($data=array()){
        return $this->db->insert($this->table,$data);
    }

    public function gethistory($rec_id){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("rec_id",$rec_id);
        $this->db->join("booking","booking.booking_id=history.booking_id","LEFT");
        $this->db->join("payment","payment.payment_id = history.payment_id","LEFT");
        $this->db->order_by("history_id",'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function delete($data=array()){
        return $this->db->delete($this->table,$data);
    }
    
    
}

?>