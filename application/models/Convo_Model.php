<?php 

    class Convo_Model extends CI_Model{

        private $table = 'convo';

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function create($payload){
            $this->db->insert($this->table,$payload);
        }

        public function getConvo($array){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where($array);
            $query = $this->db->get();
            return $query->result();
        }

    }   

?>