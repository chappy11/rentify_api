<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class UserSubscription extends Data_format{

        public function __construct(){
            parent::__construct();

            $this->load->model(array("UserSubscription_Model"));
        }

        public function isHasSubscription($userId){
            $data = $this->UserSubscription_Model->getusersub($userId);

           
            if(count($data) < 1){
                return false;
            }else{
                $validity = strtotime("20-11-2023");
                $today = strtotime("19-11-2023");
                $newDate = date("d-m-Y", strtotime('+1 day', $today));
                $date1 = strtotime($newDate);
                $date2 = $validity;
    
                if ($date1 > $date2) {
                    $payload = array(
                        "usersub_status" => "EXPIRED"
                    );

                    $isUpdated =  $this->UserSubscription_Model->updateStatus($userId,$payload);
                    
                    return false;
                } else {
                    return true;
                }
            }
        }

        public function warmp_get($userId){
            $resp = $this->isHasSubscription($userId);

            $this->res(1,$resp,"GG",0);
        }

        public function check_get(){
            $resp = $this->isHasSubscription($userId);

            if($resp){
               $data =  $this->UserSubscription_Model->getusersub($userId);
            
               $this->res(1,$data[0],"Successfully Get",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

    }
?>