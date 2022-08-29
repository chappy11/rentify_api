<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class Cart extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Cart_Model","Product_Model"));
        }

        public function addtocart_post(){
            $data = $this->decode();
            $product_id = isset($data->product_id) ? $data->product_id : "";
            $user_id = isset($data->user_id) ? $data->user_id : "";
            $no_item = isset($data->no_item) ? $data->no_item : "";
            $total = 0;
            $productData = $this->Product_Model->getProductById($product_id)[0];
            $cartExistedItem = $this->Cart_Model->getCartItemByUser($user_id,$product_id);

            if($productData->stock < $no_item){
                $this->res(0,null,"Insufficient Stock",0);
            }else{
                if(count($cartExistedItem) > 0){
                    $totalItem = (int)$no_item + $cartExistedItem[0]->noItem;
                    $totalAmount = $productData->price * $totalItem;
                    $pay = array(
                        "noItem" => $totalItem,
                        "totalAmount" => $totalAmount,
                    );

                    $updat = $this->Cart_Model->updateCart($cartExistedItem[0]->cart_id,$pay);

                    if($updat){
                        $this->res(1,null,"Successfully Cart Added",0);
                    }else{
                        $this->res(0,null,"Something went wrong",0);
                    }
                }else{
                    $total = $no_item * $productData->price;

                    $newCart = array(
                        "product_id" => $product_id,
                        "user_id" => $user_id,
                        "noItem" => $no_item,
                        "totalAmount" => $total,
                        "item_status" => 0
                    );



                    $isItemAdded = $this->Cart_Model->addtoCart($newCart);
                    
                    if($isItemAdded){
                        $this->res(1,null,"Successfully Added to your cart",0);
                    }else{
                        $this->res(0,null,"Something went wrong sorry for inconvinience",0);
                    }
                }
                
            }
        }

        public function increament_post(){
            $data =$this->decode();
            $cart_id = isset($data->cart_id) ? $data->cart_id : "";

            $cartData = $this->Cart_Model->getCartItemById($cart_id)[0];

            $totalItem = $cartData->noItem + 1;
            $productData = $this->Product_Model->getProductById($cartData->product_id)[0];
            $newAmount = $totalItem * $productData->price;

            $updatedData = array(
                "noItem" => $totalItem,
                "totalAmount" => $newAmount
            );

            $isUpdated = $this->Cart_Model->updateCart($cart_id,$updatedData);

            if($isUpdated){
                $this->res(1,null,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Something went wrong");
            }
      
        }

        public function decreament_post(){
            $data =$this->decode();
            $cart_id = isset($data->cart_id) ? $data->cart_id : "";

            $cartData = $this->Cart_Model->getCartItemById($cart_id)[0];

            $totalItem = $cartData->noItem - 1;
            $productData = $this->Product_Model->getProductById($cartData->product_id)[0];
            $newAmount = $totalItem * $productData->price;

            $updatedData = array(
                "noItem" => $totalItem,
                "totalAmount" => $newAmount
            );

            $isUpdated = $this->Cart_Model->updateCart($cart_id,$updatedData);

            if($isUpdated){
                $this->res(1,null,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Something went wrong");
            }
      
        }

        public function mycart_get($user_id){
            $cartlist = $this->Cart_Model->myCart($user_id);

            if(count($cartlist) > 0){
                $this->res(1,$cartlist,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function updateItemStatus_post(){
            $data = $this->decode();
            $cart_id = $data->cart_id;
            $status = $data->status;
            $payload = array(
                "item_status"=>$status === "1" ? 0 : 1
            );
            $isUpdated = $this->Cart_Model->updateCart($cart_id,$payload);
            if($isUpdated){
                $this->res(1,null,"Succesfully",0);
            }else{  
                $this->res(1,null,"error",0);
            }
            
        }
        
        public function activeitem_get($user_id){
            $data = $this->Cart_Model->getActiveItemByUser($user_id);

            if(count($data) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    }
?>