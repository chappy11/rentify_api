<?php 

    class PetMedical_Model extends CI_Model{

    private $table = "pet_medical";
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

    public function insert($data){
        return $this->db->insert($this->table,$data);
    }

    public function update($id,$data){
        return $this->db->update($this->table,$data,"petmed_id=".$id);
    }

    public function getmedicals($id){
        $this->db->select("*");
        $this->db->where("pet_id",$id);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }
    

 }
?>