<?php 

class UserLog_Model extends CI_Model{

    private $tbl = "userlog";
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function insert($data){
        return $this->db->insert($this->tbl,$data);
    }

    public function getLog(){
        $this->db->select("*");
        $this->db->from($this->tbl);
        $this->db->order_by("log_date","DESC");
        $query =$this->db->get();
        return $query->result();
    }
}

?>