<?php 

    class UserVoucher_Model extends CI_Model{
        private $tbl_name = 'user_voucher';
        public function __construct(){
            parent::__construct();
            $this->load->database();
        
        }

        public function create($payload){
            return $this->db->insert($this->tbl_name,$payload);
        }

        public function getUserVoucher($user_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function getUserVoucherById($userVoucher_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("user_voucher.uservoucher_id",$userVoucher_id);
            $this->db->join("voucher","voucher.voucher_id=user_voucher.voucher_id");
            $query = $this->db->get();
            return $query->result();
        }


        public function update($uservoucher_id,$payload){
            return $this->db->update($tbl_name,$payload,'uservoucher_id='.$uservoucher_id);
        }

        public function getMyVoucherId($user_id,$shop_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("user_voucher.user_id",$user_id);
            $this->db->where("user_voucher.isUse","0");
            $this->db->join("voucher","voucher.voucher_id=user_voucher.voucher_id");
            $this->db->where("voucher.shop_id",$shop_id);
            $query = $this->db->get();
            return $query->result();
        }
    }
?>