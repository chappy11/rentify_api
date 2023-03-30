<?php 

    class Rate_Model extends CI_Model{

        private $tbl_name = 'rate';

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function create($arr){
            return $this->db->insert($this->tbl_name,$arr);
        }

        public function getRateByUserId($user_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("user_id",$user_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function getRating($product_id){
            $this->db->select_avg("rate");
            $this->db->from($this->tbl_name);
            $this->db->where("product_id",$product_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function checkRating($user_id,$product_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where("user_id",$user_id);
            $this->db->where("product_id",$product_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function update($rate_id,$data){
            return $this->db->update($this->tbl_name,$data,"rate_id=".$rate_id);
        }
    }
?>