<?php 
    class Payment_Model extends CI_Model{

        private $table = "payment";
        
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->table,$payload);
        }

        public function getPaymentByReciever($mobileNumber){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where('reciever',$mobileNumber);
            $query = $this->db->get();
            return $query->result();
        }

        public function getPaymentBySender($mobileNumber){
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->where('sender',$mobileNumber);
            $query = $this->db->get();
            return $query->result();
        }

        public function getPaymentByCode($code){
            return $this->db->get_where($this->table, ['code' => $code])->row();
        }
    }

?>