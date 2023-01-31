<?php 
 include_once(dirname(__FILE__)."/Data_format.php");

    
 class Notification extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("UserOrder_Model","Remarks_Model","ShopOrder_Model","OrderItem_Model","Product_Model","Cart_Model","ShopReport_Model","Notification_Model","User_Model","Shop_Model"));
    }

    public function undreadnotif_get($user_id){
        $this->autoCancelPendingOrder();
        $this->res(1,null,"Data found",count($this->Notification_Model->getUnread($user_id)));
    }

    public function getNotification_get($user_id){
        $this->autoCancelPendingOrder();
        $data = $this->Notification_Model->getNotif($user_id);
        $this->res(1,$data,"",count($data));
    }

    public function read_post($notif_id){
       $payload = array(
        "isRead" => 1
       );

       $resp = $this->Notification_Model->updateNotification($notif_id,$payload);

       if($resp){
        $this->res(1,null,"Successfully Updated",0);
       }else{
        $this->res(0,null,"Error",0);
       }
    }    

    public function autoCancelPendingOrder(){
        $data = $this->ShopOrder_Model->getPendingOrder();

         $arr = [];
        foreach($data as $val){
            $date2 = date_create($val->shopOrderUpdateAt);
            $date1 = date_create(date('m/d/Y h:i:s a'));
            $diff = date_diff($date1,$date2);
            $totalDiff = (int)$diff->format("%d") + 1;

            if($totalDiff >= 3){
                $this->cancelOrder($val->shop_id,$val->order_id);
            }
        }

    }


    public function cancelOrder($shop_id,$order_id){
        $orderData = $this->UserOrder_Model->getOrderByOrderId($order_id);
        $shopOrderData = $this->ShopOrder_Model->getOrderIdAndShopId($order_id,$shop_id);
        $orderItem = $this->OrderItem_Model->getOrderItem($order_id,$shop_id);
        $orderpayload = array("totalAmount" => floatval($orderData[0]->totalAmount) - floatval($shopOrderData[0]->shopordertotal));
        $isOrderUpdated = $this->UserOrder_Model->update($orderpayload,$order_id);
        $shoporderpayload = array("shop_order_status" => 4);
        $isShopOrderUpdated = $this->ShopOrder_Model->update($shopOrderData[0]->shoporder_id,$shoporderpayload);
        
        foreach ($orderItem as $value) {
            # code...
            $productData = $this->Product_Model->getProductById($value->product_id); 
            $payload = array("stock" => $productData[0]->stock + $value->orderItemNo);
            $this->Product_Model->updateProduct($value->product_id,$payload);
        }

        $notif = array(
            "notif_title" => "Your order has been canceled",
            "notif_message" => "Your order: ".$shopOrderData[0]->shopReference." has been canceled its been 3 days pending",
            "notif_receiver" => $orderData[0]->user_id,
            "isRead" => 0,
            "notif_link" => "/vieworder/".$order_id."/".$orderData[0]->referenceNo
        );

            $this->Notification_Model->create($notif);
    }

 }
?>