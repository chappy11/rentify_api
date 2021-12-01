<?php 

    class Sublog_Model extends CI_Model{

        private $table = "sublogs";
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        public function getlogs($user_id){
            $this->db->select("*");
            $this->db->where("user_id",$user_id);
            $this->db->from($this->table);
            $this->db->join("subscription","subscription.sub_id=sublogs.sub_id");
            $this->db->order_by("log_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }
    }
?>