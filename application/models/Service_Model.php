<?php 
    

    class Service_Model extends CI_Model{
    
    private $table = "service";
        public function __construct(){
            parent::__construct();
            $this->load->database();
            $this->table = $this->table;
        }

        //insert service
        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        //get service specified by id
        public function getservice($service_id){
            $this->db->select("*");
            $this->db->where("service_id",$service_id);
            $this->db->from($this->table);
            $this->db->join("user","user.user_id=service.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        //get services by user's
        public function getservices($user_id){
            $this->db->select("*");
            $this->db->where("user_id",$user_id);
            $this->db->where("service_status !=","Decline");
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($id,$data){
            return $this->db->update($this->table,$data,"service_id=".$id);
        }
    
        //get get all service
        public function getAllService(){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->order_by("service_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }

        public function lastIndex(){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->limit(1);
            $this->db->order_by("service_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }

        public function getapplication(){
            $this->db->select("*");
            $this->db->where("service_status","apply");
            $this->db->from($this->table);
            $this->db->join("user","user.user_id=service.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        public function verify($id,$data){
            return $this->db->update($this->table,$data,"service_id=".$id);
        }

        public function getpost(){
            $this->db->select("*");
            $this->db->where("isPublish",1);
            $this->db->from($this->table);
            $this->db->join("user",'user.user_id=service.user_id');
            $this->db->order_by("publish_date","DESC");
            $query = $this->db->get();
            return $query->result();   
        }

        public function nearme($brgy){
            $this->db->select("*");
            $this->db->like("service_brgy",$brgy);
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

        public function serviceOwner($service_id){
            $this->db->select("*");
            $this->db->where("service_id",$service_id);
            $this->db->from($this->table);
            $this->db->join("user","user.user_id=service.user_id");
            $query= $this->db->get();
            return $query->result();
        }
    }
?>







