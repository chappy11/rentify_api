<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Notif extends Data_format{
        public function __construct(){
            parent::__construct();
            $this->load->model(array("Notification_Model","Item_Model"));
        }
    
        public function createNotif_post(){
            $data = $this->decode();
            $acnt_id = isset($data->acnt_id) ? $data->acnt_id : "";
            $item_id = isset($data->item_id) ? $data->item_id : "";
            $reason = isset($data->reason) ? $data->reason : "";
            $name = "Your item has been Decline";
            $status = array(
                "item_status" => "decline"
            );
            $update = $this->Item_Model->update($item_id,$status);
            if($update){
                $notif = array(
                    "acnt_id"=>$acnt_id,
                    "notif_name"=>$name,
                    "notif_body"=>$reason,
                    "notif_type"=>"decline",
                    "notif_read"=>0
                );
                $create = $this->Notification_Model->create_notif($notif);
                if($create){
                    $this->res(1,null,"Successfully Sent",0);
                }else{
                    $this->res(0,null,"error creating",0);
                }
            }else{
                $this->res(0,null,"error",0);
            }
        }

        public function getnotif_get($acnt_id){
            $res = $this->Notification_Model->view_notif($acnt_id);
            if(count($res) > 0){
                $this->res(1,$res,"data found",count($res));
            }else{
                $this->res(0,null,"No notification",0);
            }
        }

        public function countUnread_get($acnt_id){
            $count = count($this->Notification_Model->notif_unread($acnt_id));
            $this->res(1,null,"",$count);
        }
        

        public function read_post($notif_id){
            $res = $this->Notification_Model->read($notif_id);
            if($res){
                $this->res(1,null,"success",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }

        public function deletenotif_post($notif_id){
            $res = $this->Notification_Model->remove($notif_id);
            if($res){
                $this->res(1,null,"Successfully remove",0);
            }else{
                $this->res(0,null,"Error removing",0);
            }
        }
    
        public function readall_post($acnt_id){
            $res = $this->Notification_Model->readAll($acnt_id);
            if($res){
                $this->res(1,null,"success",0);
            }else{
                $this->res(0,null,"error",0);
            }
        }

        public function removeall_post($acnt_id){
            $res = $this->Notification_Model->removeall($acnt_id);
            if($res){
                $this->res(1,null,"success",0);
            }else{
                $this->res(0,null,"eror",0);
            }
        }
    }

?>