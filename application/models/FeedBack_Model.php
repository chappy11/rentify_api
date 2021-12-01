<?php 


    class FeedBack_Model extends CI_Model{

        private $table = "feedback";
        public function __construct(){
            parent::__construct();
            $this->load->database();            
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        public function getfeedback($user_id){
            $this->db->select("*");
            $this->db->where("feedback.user_id",$user_id);
            $this->db->from($this->table);
            $this->db->join("user","user.user_id=feedback.sender_id");
            $query = $this->db->get();
            return $query->result();
        }
    }
?>