<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Notification extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Notification_Model","Pet_Model"));
        }

        public function getNotif_get($user_id){
            $result = $this->Notification_Model->getNotifications($user_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",count($result));
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    
        public function readnotif_post(){
            $data = $this->decode();
            $id = $data->id;
            $arr = array(
                "notif_status" => 1
            );

            $result = $this->Notification_Model->update($id,$arr);
            if($result){
                $this->res(1,null,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }
     
        public function unread_get($id){
            $result = $this->Notification_Model->unread($id);
            $this->res(1,null,"data found",count($result));
        }
    }

?>