<?php 

    class Drivers_Model extends CI_Model{

        private $tble = "drivers";

        public function __construct(){
            parent::__construct();

            $this->load->database();
        }


        public function create($payload){
            return $this->db->insert($this->tble,$payload);
        }
    
        public function getDriversByOwner($owner_id){
            $this->db->select("*");
            $this->db->from($this->tble);
            $this->db->where("owner_id",$owner_id);
            $query = $this->db->get();
            return $query->result();
        }


        public function login($username,$password){
            $this->db->select("*");
            $this->db->from($this->tble);
            $this->db->where('username',$username);
            $this->db->where('password',$password);
            $query = $this->db->get();
            return $query->result();
        }
    
    }

?>