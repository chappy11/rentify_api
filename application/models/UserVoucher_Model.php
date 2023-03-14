<?php 

    class UserVoucher_Model extends CI_Model{
        private $tbl_name = 'user_voucher';
        public function __construct(){
            parent::__construct();
            $this->load->database();
        
        }

        public function create($payload){
            return $this->db->insert($tbl_name,$payload);
        }

        public function getUserVoucher($user_id){
            $this->db->select("*");
            $this->db->from($tbl_name);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($uservoucher_id,$payload){
            return $this->db->update($tbl_name,$payload,'uservoucher_id='.$uservoucher_id);
        }
    }
?>