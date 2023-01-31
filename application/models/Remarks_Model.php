<?php

    class Remarks_Model extends CI_Model{

        private $table_name = "remarks";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function create($data){
            return $this->db->insert($this->table_name,$data);
        }

        public function getRemarks($shoporder_id){
            $this->db->select("*");
            $this->db->from($this->table_name);
            $this->db->where("shoporder_id",$shoporder_id);
            $query = $this->db->get();
            return $query->result();
        }
    }

?>