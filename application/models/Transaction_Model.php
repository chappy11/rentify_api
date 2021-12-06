<?php 

    class Transaction_Model extends CI_Model{

        private $table = 'transaction';
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }

        
        public function getTransaction($transac_id){
            $this->db->select("*");
            $this->db->where("transac_id",$transac_id);
            $this->db->from($this->table);
            $this->db->join("service","service.service_id=transaction.service_id");
            $query =$this->db->get();
            return $query->result();
        }

        public function getApplication($service_id){
            $this->db->select("*");
            $this->db->where("service_id",$service_id);
            $this->db->where("trans_status","apply");
            $this->db->from($this->table);
            $this->db->join("pet","pet.pet_id=transaction.pet_id");
            $this->db->join("user","user.user_id=pet.user_id");
            $this->db->join("pet_medical","pet_medical.pet_id=pet.pet_id");
          
            $query = $this->db->get();
            return $query->result();
        }

        

        public function lastIndex(){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->order_by("transac_id",'DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($id,$data){
            return $this->db->update($this->table,$data,"transac_id=".$id);
        }
        
        
        public function getpetTrans($pet_id){
            $this->db->select("*");
            $this->db->where("pet_id",$pet_id);
            $this->db->from($this->table);
            $this->db->join("service","service.service_id=transaction.service_id");
            $query = $this->db->get();
            return $query->result();
        }
  
        public function getpets($service_id){
            $this->db->select("*");
            $this->db->where("service_id",$service_id);
            $this->db->where("trans_status","accept");
            $this->db->from($this->table);
            $this->db->join("pet","pet.pet_id=transaction.pet_id");
            $this->db->join("user","user.user_id=pet.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        public function cancel($transac_id){
            $arr = array(
                "transac_id" => $transac_id
            );
            return $this->db->delete($this->table,$arr);
        }


        public function gettrans($trans_id){
            $this->db->select("*");
            $this->db->where("transac_id",$trans_id);
            $this->db->from($this->table);
            $this->db->join("pet","pet.pet_id=transaction.pet_id");
            $this->db->join("user","user.user_id=pet.user_id");
            $query = $this->db->get();
            return $query->result();
        }
  
        
      
    }


?>