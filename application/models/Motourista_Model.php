<?php 

    class Motourista_Model extends CI_Model{
        $table = "motourista";
        public function __construct(){
            parent::__construct();
            $this->load->database();
            
        }

        public function addMotourista($data=array()){
            return $this->db->insert($table,$data);
        }

        public function getmotouristabyId($id){
             $this->db->select("*");
             $this->db->from($table);
             $this->db->where("m_id",$id);
             $query = $this->db->get();
             return $query->result();    
        }

        public function getmotouristabyuser($user_id){
            $this->db->select("*");
            $this->db->from($table);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function updatemotourista($id,$data=array()){
            return $this->db->update($table,$data,"m_id=".$id);
        }
        
    }
?>