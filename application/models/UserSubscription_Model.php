<?php 

    class UserSubscription_Model extends CI_Model{

        private $table = "user_subscription";
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($data){
            return $this->db->insert($this->table,$data);
        }
        
        public function getusersub($user_id){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where("user_subscription.user_id",$user_id);
            $this->db->where("user_subscription.usersub_status","ACTIVE");
            $this->db->join("subscription","subscription.sub_id=user_subscription.sub_id");
            $query = $this->db->get();
            return $query->result();
        }

        public function updateStatus($user_id,$payload){
            return $this->db->update($this->table,$payload,"user_id=".$user_id);
        }
    }

?>