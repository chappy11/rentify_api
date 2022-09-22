<?php 
class Admin_Model extends CI_Model{
    
    private $tbl = "admin";

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function insertAdmin($data){
        return $this->db->insert($this->tbl,$data);
    }

    public function getAdminByUserId($user_id){
        $this->db->select("*");
        $this->db->from($this->tbl);
        $this->db->where("admin.user_id",$user_id);
        $this->db->join("user","user.user_id=admin.user_id");
        $query = $this->db->get();
        return $query->result();
    }
}
?>