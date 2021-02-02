<?php

include_once(dirname(__FILE__)."/Data_format.php");

    class Product extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Product_Model","Item_Model"));
        }

        public function addProduct(){
            $data = $this->decode();
            $garage_id = isset($data->garage_id) ? $data->garage_id : "";
            $item_id = isset($data->item_id) ? $data->item_id : "";
            $sellprice = isset($data->sellprice) ? $data->sellprice : "";
            $selltype = isset($data->selltype) ? $data->selltype : "";
       
                if(empty($garage_id) && empty($item_id) && empty($sellprice) && empty($selltype)){
                    $this->res(0,null,"Fill out fields");
                }
                else{
                    $product = array(
                        "garage_id" => $garage_id,
                        "item_id" => $item_id,
                        "sell_price" => $sellprice,
                        "selltype" => $selltype
                    );
                    
                    $response = $this->Product_Model->add($product);
                        if($response){
                            $item = array("item_status" => "garage");
                            $update = $this->Item_Model->update($item_id,$item);
                                if($update){
                                    $this->res(1,null,"Successfully Added");
                                }else{
                                    $this->res(0,null,"there is something error");
                                }
                            
                        }
                        else{
                            $this->res(0,null,"Error Added");
                        }
                }
        }
        
        public function viewProduct_get($garage_id){
            $product = $this->Product_Model->viewProduct($garage_id);
            if(count($product) > 0){
                $this->res(1,$product,"data found");
            }else{
                $this->res(0,null,"Data not found");
            }
        }
    
    }

?>