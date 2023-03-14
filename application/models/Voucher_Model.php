<?php

class Voucher_Model extends CI_Model{

    private $tbl_name = 'voucher';

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function create($payload){
        return $this->db->insert($this->tbl_name,$payload);
    }


    public function getShopVoucher($shop_id){
        $this->db->select("*");
        $this->db->from($tbl_name);
        $this->db->where('shop_id',$shop_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update($voucher_id,$data){
        return $this->db->update($this->tbl_name,$data,'voucher_id='.$voucher_id);
    }


}

?>