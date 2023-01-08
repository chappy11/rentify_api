<?php 
include_once(dirname(__FILE__)."./Data_format.php");

class ShopReport extends Data_format {

    public function __construct(){
        parent::__construct();
        $this->load->model(array("ShopReport_Model","OrderItem_Model"));
    }

    public function getsuccesstransaction_get($shop_id){
        $data = $this->ShopReport_Model->getAllDataByShop($shop_id);
        $newData = [];
        foreach($data as $value){
            $itemData = array(
                "date_success" => $value->date_success,
                "referenceNo" => $value->shopReference,
                "success_date" => $value->date_success,
                "order_total_amout" => $value->order_total_amout,
                "order_item" => $this->OrderItem_Model->getOrderItem($value->order_id,$shop_id)
            );

            array_push($newData,$itemData);
        }

        if(count($data) > 0){
            $this->res(1,$newData,"GG",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }

    public function  getreports_get(){
        $data = $this->ShopReport_Model->getShopReport();

        if(count($data)){
            $this->res(1,$data,"Retrieve",0);
        }else{
            $this->res(0,null,"data not found",0);
        }
    }
}

?>