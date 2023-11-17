<?php 
    class Subscription_Model extends CI_Model {
        private $table = 'subscription';

        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->table,$payload);
        }

        public function getSubscriptionById($sub_id){
            return $this->db->get_where($this->table, ['sub_id' => $sub_id])->row();
        }


        public function getAllSubscription(){
            $this->db->select("*");
            $this->db->from($this->table);
            $query = $this->db->get();
            return $query->result();
        }

    }
?>