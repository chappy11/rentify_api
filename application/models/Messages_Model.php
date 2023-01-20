<?php 

    class Messages_Model extends CI_Model{

        private $table = 'messages';
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($data){
            return $this->db->insert($this->table,$data);
        }

        public function getMessagesByConnectionId($conn_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("conn_id",$conn_id);
            $this->db->order_by("message_date","DESC");
            $query = $this->db->get();
            return $query->result();
        }
    }
?>