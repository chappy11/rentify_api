<?php 

    class Vehicle_Model extends CI_Model{
        private $tbl = "vehicles";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

  
        public function createVehicle($payload=array()){
            return $this->db->insert($this->tbl,$payload);            
       }


       public function getVehicleById($userId){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("user_id",$userId);
            $query = $this->db->get();
            return $query->result();
       }

       public function getVehicles(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $query = $this->db->get();
            return $query->result();
        }

        public function getVehicleDetails($id){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where('vehicles.vehicle_id',$id);
            $this->db->join('users','users.user_id=vehicles.user_id');
            $query = $this->db->get();
            return $query->result();
        }

        public function getVehicleDataById($vehicle_id){
            return $this->db->get_where('vehicles', ['vehicle_id' => $vehicle_id])->row();
        }
    }
?>