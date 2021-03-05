<?php 

 class Garage_Model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function add($garage=array()){
        return $this->db->insert("garage",$garage);
    }

    public function myGarage($acnt_id){
        $this->db->select("*");
        $this->db->where("acnt_id", $acnt_id);
        $this->db->from('garage');
        $query = $this->db->get();;
        return $query->result();
    }
    
    public function update($garage_id,$garage=array()){
        return $this->db->update('garage',$garage,'garage_id='.$garage_id);
    }

    public function getbyid($garage_id){
        $this->db->select("*");
        $this->db->where("garage_id",$garage_id);
        $this->db->from("garage");
        $query = $this->db->get();
        return $query->result();
    }

    public function garages($id){
        $this->db->select("*");
        $this->db->where("garage.garage_status","active");
        $this->db->where('account.status','active');
        $this->db->where("garage.acnt_id !=",$id);
        $this->db->from("garage");
        $this->db->join('account',"account.acnt_id=garage.acnt_id");
        $query = $this->db->get();
        return $query->result();
    }
    
    public function seller_garage($garage_id){
        $this->db->select("*");
        $this->db->where("garage.garage_id",$garage_id);
        $this->db->from("garage");
        $this->db->join("account","account.acnt_id=garage.acnt_id");
        $query = $this->db->get();
        return $query->result();
    }
    
    


}

?>