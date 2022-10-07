<?php 

class ShopReport_Model extends CI_Model{

    private $table = 'shopreport'
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function create($payload=array()){
        return $this->db->insert($this->table,$payload);
    }

    public function getAllDataByShop($shop_id){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('shop_id',$shop_id);
        $this->db->join('shoporder','shoporder.shop_id=shopreport.shop_id');
        $query = $this->db->get();
        return $query->result();
    }

}

?>