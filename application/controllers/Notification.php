<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Notification extends Data_format{


        public function __construct(){
            parent::__construct();
            $this->load->model(array("Notification_Model"));
        }


        public function notifications_get($recieverId){
            $data =$this->Notification_Model->getnotif($recieverId);

            $this->res(1,$data,"GG",count($data));
        }

        public function getactive_get($recieverId){
            $data = $this->Notification_Model->getactivenotif($recieverId);
        
            $this->res(1,$data,"GG",count($data));
        }

        public function updatestatus_post(){
            $data = $this->decode();
            
            $notif_id = $data->notif_id;

            $payload = array(
                "notif_status" => 0, 
            );            

            $resp = $this->Notification_Model->updateData($notif_id,$payload);

            if($resp){
                $this->res(1,null,"GG",0);
            }else{
                $this->res(0,null,"Somethingwent wrong",0);
            }
        }
    }

?>