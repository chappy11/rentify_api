<?php 

    class UserSub_Model extends CI_Model{

        private $table = "user_subscribe";
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function insert($data){
            return $this->db->insert($this->table,$data);
        }


        public function update($id,$data){
            return $this->db->update($this->table,$data,"usubscribe_id=".$id);
        }

        public function mysub($id){
            $this->db->select("*");
            $this->db->where("user_id",$id);
            $this->db->from($this->table);
            $this->db->join("subscription","subscription.sub_id=user_subscribe.sub_id");
            $query = $this->db->get();
            return $query->result();
        }
    
        public function getsub($id){
            $this->db->select("*");
            $this->db->where("usubscribe_id",$id);
            $this->db->from($this->table);
            $query =$this->db->get();
            return $query->result();
        }
    }

?>