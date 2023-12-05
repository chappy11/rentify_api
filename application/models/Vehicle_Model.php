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
            $this->db->where('isDeleted',0);
            $query = $this->db->get();
            return $query->result();
       }

       public function getVehicles(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where('vehicles.isDeleted',0);
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

        public function updateData($id,$payload){
            return $this->db->update($this->tbl,$payload,"vehicle_id=".$id);
        }

        public function getVehicleQuery($arr = null){
            $this->db->select("*");
            $this->db->from($this->tbl);
            if($arr !== null){
                $this->db->where($arr);
            }
            $this->db->join('users','users.user_id=vehicles.user_id');
            $query = $this->db->get();
            return $query->result();
        }
    }
?>