<?php 
include_once(dirname(__FILE__)."./Data_format.php");

class ShopReport extends Data_format {

    public function __construct(){
        parent::__construct();
        $this->load->model(array("ShopReport_Model"));
    }

    public function getsuccesstransaction_get($shop_id){
        $data = $this->ShopReport_Model->getAllDataByShop($shop_id);
    
        if(count($data) > 0){
            $this->res(1,$data,"GG",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }
}

?>