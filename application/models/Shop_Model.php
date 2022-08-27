<?php 

    class Shop_Model extends CI_Model{

        private $tbl = 'shop';

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function createShop($shopData=array()){
            return $this->db->insert($this->tbl,$shopData);
        }

        public function getShopByUserId($user_id){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("shop.user_id",$user_id);
            $this->db->join("user","user.user_id=".$user_id);
            $query = $this->db->get();
            return $query->result();
        }

        public function getAllShop(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $query = $this->db->get();
            return $query->result();
        }

        public function getShopByid($shop_id){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("shop_id",$shop_id);
            $query =$this->db->get();
            return $query->result();
        }

        public function latestShop(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->order_by("user_id","DESC");
            $query = $this->db->get();
            return $query->result();
        }

        public function updateShop($id,$data=array()){
            return $this->db->update($this->tbl,$data,"shop_id=".$id);
        }

        public function getPendingShop(){
            $this->db->select("*");
            $this->db->from($this->tbl);
            $this->db->where("user.user_roles!=",0);
            $this->db->where("user.user_status",0);
            $this->db->join("user","user.user_id=shop.user_id");
            $query = $this->db->get();
            return $query->result();
        }

        
        public function hasSubscription($shop_id){
           
            $this->db->select("subscription_id");
            $this->db->from($this->tbl);
            $this->db->where("shop_id",$shop_id);
            $query = $this->db->get();
            $subscription = $query->result()[0];
            if($subscription->subscription_id === "0"){
                return false;
            }else{
                return true;
            }
        }

        public function checkIsSubscriptionExpire($shop_id){
            $dateNow = date("Y-m-d");
               $shopSubscription = $this->getShopByid($shop_id)[0];
           
            if($shopSubscription->subscription_id  > 0){
           
                if($shopSubscription->subExp > $dateNow){
                    $isUpdated = $this->updateShop($shop_id,array("subExp"=>null,"subscription_id"=>0));
                    if($isUpdated){
                        return $this->getShopByid($shop_id)[0];
                    }
                }else{
                    return  $shopSubscription;
                }
            }else{
                return $shopSubscription;
            }
        }

    
    }
?>