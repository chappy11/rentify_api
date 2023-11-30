<?php 

    class Notification_Model extends CI_Model{

        private $table = "notification";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->table,$payload);
        }

        public function getnotif($reciever_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("reciever_id",$reciever_id);
            $this->db->order_by('createdAt','DESC');
            $query = $this->db->get();
            return $query->result();
        }
    }
?>