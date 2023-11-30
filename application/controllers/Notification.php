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
    }

?>