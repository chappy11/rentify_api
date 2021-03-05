<?php

include_once(dirname(__FILE__)."/Data_format.php");

    class Product extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Product_Model","Item_Model","Garage_Model","Cart_Model"));
            
        }

        public function addProduct_post(){
            $data = $this->decode();
            $id = isset($data->acnt_id) ? $data->acnt_id : "";
            $item_id = isset($data->item_id) ? $data->item_id : "";
            $sellprice = isset($data->sellprice) ? $data->sellprice : "";
            $selltype = isset($data->selltype) ? $data->selltype : "";
            $havegarage = $this->Garage_Model->myGarage($id);

               if(count($havegarage) < 1){
                   $this->res(0,null,"You dont have any garage pls create one..");
               }
               else if(empty($sellprice))
               {
                   $this->res(0,null,"Pls put a price",0);
               }
               else if(empty($selltype)){
                   $this->res(0,null,"Pls choose sell type ",0);
               }
                else{
                    $product = array(
                        "garage_id" => $havegarage[0]->garage_id,
                        "item_id" => $item_id,
                        "sellprice" => $sellprice,
                        "selltype" => $selltype,
                        "product_status" => "active"
                    );
                    
                    $response = $this->Product_Model->add($product);
                        if($response){
                            $item = array("item_status" => "garage");
                            $update = $this->Item_Model->update($item_id,$item);
                                if($update){
                                    $this->res(1,null,"Successfully Added",0);
                                }else{
                                    $this->res(0,null,"there is something error",0);
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
                $this->res(1,$product,"data found",count($product));
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function  availableprod_get($garage_id){
            $product = $this->Product_Model->viewProduct($garage_id);
            $available = array();
                foreach ($product as $item) {
                    if($item->item_quantity != 0){
                        array_push($available,$item);
                    }
                }
                if(count($available) > 0){
                    $this->res(1,$available,"data found",0);
                }else{
                    $this->res(0,null,"data not found",0);
                }
        }

        public function checkproduct_get($product_id){
            $data = $this->Product_Model->getproduct($product_id);
            $this->res(1,$data,"",0);
        }

        public function removeproduct_post($item_id){
            $product = $this->Product_Model->getproductitem($item_id);
            $removefromcart = $this->Cart_Model->removeproduct($product[0]->product_id);   
            $dat = array("item_status"=>"validated");
            $update = $this->Item_Model->update($item_id,$dat);     
             if($update){
                    $delete = $this->Product_Model->removeproduct($item_id);        
                    if($delete){
                        $this->res(1,null,"Successfully Remove",0);
                    }else{
                        $this->res(0,null,"Error",0);
                    }
                }else{
                    $this->res(0,null,"error",0);
                }
        
        }

        
        
    }

?>