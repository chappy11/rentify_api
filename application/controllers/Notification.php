<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Notification extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model("Notification_Model");
        }

        
        public function getnotifbyuser_get($user_id){
            $data = $this->Notification_Model->getnotifbyuser($user_id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",count($data));
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function getunread_get($user_id){
            $data = $this->Notification_Model->unread($user_id);
            $this->res(1,$data,"Data not found",count($data));
        }

        public function getnotifbyid_get($notif_id){
            $data = $this->Notification_Model->getnotifbyid($notif_id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",count($data));
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function read_post(){
            $data = $this->decode();
            $notif_id = isset($data->notif_id) ? $data->notif_id : "";
            $payload = array(
                "isRead" => 1
            );

            $resp = $this->Notification_Model->update($notif_id,$payload);
            if($resp){
                $this->res(1,null,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Error Updated",0);
            }
        }
    }

?>