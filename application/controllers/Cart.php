<?php 
  include_once(dirname(__FILE__)."/Data_format.php");

  class Cart extends Data_format{
      public function __construct(){
        parent::__construct();
        $this->load->model(array("Cart_Model","Product_Model","Negotiable_Model"));
      }
      
      public function addcart_post(){
          $data =  $this->decode();
          $product_id = isset($data->product_id) ? $data->product_id : "";
          $garage_id = isset($data->garage_id) ? $data->garage_id:"";
          $buyer_id = isset($data->buyer_id) ? $data->buyer_id :"";
        
          $check = $this->Cart_Model->checkitem($product_id,$garage_id,$buyer_id);
          if(count($check) > 0){
            $checkitem = $this->Product_Model->getproduct($product_id);
            if($checkitem[0]->item_quantity < 1){
              $this->res(0,null,"This item is out of stock",0); 
            }
            else if($checkitem[0]->item_quantity === $check[0]->item_no){
              $this->res(0,null,"This item has only ".$checkitem[0]->item_quantity." ".$checkitem[0]->item_unit." you cannot add anymore",0);
            }else{
                $dat = array("item_no"=> $check[0]->item_no + 1);
                $update = $this->Cart_Model->updatecart($check[0]->cart_id,$dat);
                if($update){
                  $this->res(1,null,"Successfully Update your cart",0);
                }else{
                  $this->res(0,null,"error update cart",0);
                }

            }
          }else{
          $dat = array(
            "product_id" => $product_id,
            "garage_id" => $garage_id,
            "buyer_id" => $buyer_id,
            "item_no" =>1
          );
          $isadd = $this->Cart_Model->addtocart($dat);
          if($isadd){
              $this->res(1,null,"Successfully Added to your Cart",0);
          }else{
              $this->res(0,null,"Error",0);
          }
        }
      }

      public function getcart_get($buyer_id,$garage_id){
          $result = $this->Cart_Model->getcart($buyer_id,$garage_id);
          $available = array();
          foreach ($result as $res) {
            $product = $this->Product_Model->getProduct($res->product_id);
            $nego = $this->Negotiable_Model->viewnegotiable($buyer_id,$res->product_id);
            if($product[0]->item_quantity > 0){
              if($product[0]->selltype==="negotiable" && $nego[0]->neg_status==="accept" && $nego[0]->user_id===$buyer_id){
                  $res->sellprice=$nego[0]->neg_price;
              }else{

              }
               array_push($available,$res);
            }
          }          
          if(count($available) > 0){
            $this->res(1,$available,"datafound",count($available));
          }else{
            $this->res(0,null,"data not found",0);
          }
          
        }

      
        public function addcartno_post($cart_id){
          $item =  $this->Cart_Model->checkcart($cart_id);
         
          $checkproduct = $this->Product_Model->getproduct($item[0]->product_id);
          if($checkproduct[0]->item_quantity === $item[0]->item_no){
              $this->res(0,null,"This item has only ".$checkproduct[0]->item_quantity." ".$checkproduct[0]->item_unit." you cannot add anymore",0);
          }else{
            $data = array("item_no"=>$item[0]->item_no + 1); 
            $update = $this->Cart_Model->updatecart($cart_id,$data);
            if($update){
              $this->res(1,null,"Successfully updated",0);
            }else{
              $this->res(0,null,"Error",0);
            }
          }
        }

        public function minuscartno_post($cart_id){
          $item = $this->Cart_Model->checkcart($cart_id);
          $data = array("item_no"=> $item[0]->item_no - 1);
          $update = $this->Cart_Model->updatecart($cart_id,$data);
          if($update){
            $this->res(1,null,"",0);
          }else{
            $this->res(0,null,"",0);
          }

        }

        public function removeitem_post($cart_id){
            $delete = $this->Cart_Model->removeitem($cart_id);
            if($delete){
              $this->res(1,null,"Successfully remove",0);
            }else{
              $this->res(0,null,"Error", 0);
            }
        }

        public function getitem_post(){
          $data = $this->decode();
          $product_id = isset($data->product_id) ? $data->product_id : "";
          $itemcount = $this->Product_Model->getproduct($product_id);
          $this->res(1,$itemcount,"gg",0);
        }

        public function sample_post(){
          $data = $this->decode();
          $array = array();
          foreach ($data->data as $res) {
              array_push($array,$res);
          }
          $this->res(1,$array,"data found",1);
        }
  }
?>