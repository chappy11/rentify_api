<?php 

    class VehicleImage_Model extends CI_Model{
        private $table = "vehicleimage";
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->table,$payload);
        }

        public function  getByNonce($nonce){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("nonce",$nonce);
            $query = $this->db->get();
            return $query->result();
        }
    }
?>