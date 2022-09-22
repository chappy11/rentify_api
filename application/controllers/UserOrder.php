<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class UserOrder extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("UserOrder_Model","ShopOrder_Model","OrderItem_Model","Product_Model","Cart_Model"));
        }

        public function createorder_post(){
            $data = $this->decode();
            
            $user_id = $data->user_id;
            $total_amount = $data->total_amount;
            $isHalf = $data->isHalf;

            $itemList = $this->Cart_Model->getActiveItemByUser($user_id);

            $arr = $this->returnUniqueProperty($itemList,"shop_id");
            $orderNumber = $this->createNewOrder($user_id,$total_amount,$isHalf)[0];
            $listOfShops = array();
            foreach($arr as $value){
                array_push($listOfShops,$value->shop_id);
            }
            
           $isSuccess = 1; 
           foreach($listOfShops as $value){
                $totalByShop = $this->getTotalByShop($value,$itemList);
                $payload = array(
                    "order_id" => $orderNumber->order_id,
                    "shop_id" => $value,
                    "shopReference" => $orderNumber->referenceNo,
                    "shop_order_status"=>"0",
                    "shoporderpaid" => $isHalf == 1 ? $totalByShop / 2 : $totalByShop,
                    "shopordertotal" => $totalByShop,
                );

                $isCreate = $this->ShopOrder_Model->createShopOrder($payload);

                if($isCreate){
                    $isSuccess*=1;
                }else{
                    $isSuccess*=0;
                }
            }

            if($isSuccess === 1){
                $hasError = 1;
               foreach($itemList as $item){
                    $payload = array(
                        "itemReference" => $orderNumber->referenceNo,
                        "product_id" => $item->product_id,
                        "orderItemAmount" => $item->totalAmount,
                        "orderItemNo"=>$item->noItem,
                        "order_id"=> $orderNumber->order_id
                    );

                    $created = $this->OrderItem_Model->insert($payload);

                    if($isCreate){
                        $hasError = $hasError * 1;

                    }else{
                        $hasError = $hasError * 0;
                    }
               }
               if($hasError === 0){
                    $this->res(0,null,"Something went wrong",0);
               }else{

                $isUpdateStock = $this->updateProductStock($itemList);
                
                if($isUpdateStock){
                    $this->removeFromCart($itemList);
                    $this->res(1,null,"Success Order",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
              
               }
            }else{
                $this->res(0,"","ERROR",0);
            }
        }


        public function warmup_get(){
            $dates = $this->getBetweenDates('2022-9-18','2022-9-24');
            $data = $this->ShopOrder_Model->getallorder($dates);
        
            $this->res(1,$data,"NO",null);
        }

        public function orders_get($user_id){
            $orderList = $this->UserOrder_Model->getOrderByUserId($user_id);
            $userOrder = array();
            foreach($orderList as $item){
                $arr = array(
                    "order_id"=>$item->order_id,
                    "reference"=>$item->referenceNo,
                    "totalAmount"=>$item->totalAmount,
                    "products"=>$this->OrderItem_Model->getOrderItemByOrderId($item->order_id)
                );

                array_push($userOrder,$arr);
            }

            if(count($orderList) > 0){
                $this->res(1,$userOrder,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }

        }


        public function order_get($order_id){
            $orderData = $this->UserOrder_Model->getOrderByOrderId($order_id);
            $shopOrderData  = $this->ShopOrder_Model->getShopOrderByOrderId($order_id,1);
            
            $shopOrderList = array();
            foreach($shopOrderData as $item){
                $payload = array(
                    "shopOrder_id" => $item->shoporder_id,
                    "shop_id" => $item->shop_id,
                    "shop_name" => $item->shopName,
                    "logo"=>$item->logo,
                    "totalAmount"=>$item->shopordertotal,
                    "status"=>$item->shop_order_status,
                    "paid"=>$item->shoporderpaid,
                    "items"=>$this->OrderItem_Model->getOrderItem($order_id,$item->shop_id)
                );
            
                array_push($shopOrderList,$payload);
            }

            if(count($shopOrderList) > 0 ){
                $this->res(1,$shopOrderList,"Data found",0);
            }else{
                $this->res(0,null,"No Data Found",0);
            }
        }

        public function shoporderlist_get($shop_id,$status){
            $data = $this->ShopOrder_Model->getOrderShop($shop_id,$status);

            if(count($data)> 0 ){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Someting went wrong",0);
            }
        }

        public function updateorderstatus_post(){
            $data= $this->decode();
            $status = $data->status;
            $id = $data->id;

            $payload = array(
                "shop_order_status" => $status
            );

            $update = $this->ShopOrder_Model->update($id,$payload);
        
            if($update){
                $this->res(1,null,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }






//--------------------------ITERNAL FUNCTION---------------------------------------------------------        

        public function updateProductStock($itemList){
            $flag =1;
            foreach($itemList as $item){
            $productData = $this->Product_Model->getProductById($item->product_id)[0];
            $payload = array(
                "stock" => $productData->stock - $item->noItem
            );
            
                $isUpdate = $this->Product_Model->updateProduct($item->product_id,$payload);
                if($isUpdate){
                    $flag = $flag * 1;
                }else{
                    $flag = $flag * 0;
                }
            }

            if($flag == 1){
                return true;
            }else{
                return false;
            }

        }

        public function removeFromCart($itemList){
            foreach($itemList as $item){
                $this->Cart_Model->deleteCart($item->cart_id);
            }
        }

        public function getTotalByShop($shop_id,$list){
            $amount = 0;
           
            foreach($list as $value){
                if($value->shop_id === $shop_id){
                   $amount = $amount + $value->totalAmount;
                }
            }
            return $amount;
        }

        public function returnUniqueProperty($array, $property) 
        {
                $tempArray = array_unique(array_column($array, $property));
                $moreUniqueArray = array_values(array_intersect_key($array, $tempArray));
                return $moreUniqueArray;
        }

        public function createNewOrder($user_id,$total_amount,$isHalf){
            $random = random_int(100000, 999999);
            $reference = "PTR-".date("y")."".date("d")."".date("m").date("h").date("s").date("i")."-".$random;
            $paid = $isHalf == 1 ? $total_amount / 2 : $total_amount;
            $payload = array(
                "user_id"=> $user_id,
                "totalAmount" => $total_amount,
                "paid" => $paid,
                "isHalf" => $isHalf,
                "referenceNo" => $reference,
                "orderStatus" => 1
            );

            $order = $this->UserOrder_Model->createNewOrder($payload,$user_id);
            return $order;
        }

        public function getAllSunday($y,$m){
            
                $date = "$y-$m-01";
                $first_day = date('N',strtotime($date));
                $first_day = 7 - $first_day + 1;
                $last_day =  date('t',strtotime($date));
                $days = array();
                for($i=$first_day; $i<=$last_day; $i=$i+7 ){
                    $days[] = "$y-$m-$i";
                }
                return  $days;
        }

        function getBetweenDates($startDate, $endDate){
            $rangArray = [];
                
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
                 
            for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                                                    
                $date = date('Y-m-d', $currentDate);
                $rangArray[] = $date;
            }
      
            return $rangArray;
        }     
    
    }
?>