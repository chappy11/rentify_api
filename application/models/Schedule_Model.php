<?php 

    class Schedule_Model extends CI_Model{

        private  $table = "schedule";
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
           return $this->db->insert_batch($this->table,$data);
        }

        public function getSchedule($service_id){
            $this->db->select("*");
            $this->db->where("service_id",$service_id);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function remove($data){
            return $this->db->delete($this->table,$data);
        }

    }


?>