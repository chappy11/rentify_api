<?php 
    class Payment_Model extends CI_Model{

        private $table = "payment";
        
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($data){
            $fourdigit = random_int(1000,9999);
            $sixDigit = random_int(100000, 999999);
        
            $code = $fourdigit.'-'.$sixDigit;
            $codePayload = array("code"=>$code);
            $payload = (object)array_merge((array)$data,(array)$codePayload);
            
            return $this->db->insert($this->table,$payload);
        }

        public function pay($data){
          return $this->db->insert($this->table,$data);
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