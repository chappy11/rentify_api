<?php 

    class Message_Model extends CI_Model{


        private $table = 'message';

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->table,$payload);
        }

        public function getMessage($filterArray){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where($filterArray);
            $query = $this->db->get();
            return $query->result();
        }
    }

?>