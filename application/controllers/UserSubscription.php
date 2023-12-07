<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class UserSubscription extends Data_format{

        public function __construct(){
            parent::__construct();

            $this->load->model(array("UserSubscription_Model","Subscription_Model","Payment_Model","User_Model"));
        }

        public function isHasSubscription($userId){
            $data = $this->UserSubscription_Model->getusersub($userId);

           
            if(count($data) < 1){
                return false;
            }else{
                $validity = strtotime($data[0]->validity);
                
                $today = strtotime(date('d-m-Y'));
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

        public function warmp_get(){
            $arr = array(
                "user_id" => 1
            );

            $arr2 = array("veh_id"=>3);
        
            $arr3 = (object)array_merge((array)$arr,(array)$arr2);
        
        
            $this->res(1,$arr3,"GG",0);
        }

        public function check_get($userId){
            $resp = $this->isHasSubscription($userId);

            if($resp){
               $data =  $this->UserSubscription_Model->getusersub($userId);
            
               $this->res(1,$data[0],"Successfully Get",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

        public function subscribe_post(){
            $data = $this->decode();
            $userId = $data->userId;
            $amount = $data->amount;
            $sub_id = $data->sub_id;
            $subData = $this->Subscription_Model->getSubscriptionById($sub_id);
            $userData = $this->User_Model->getUserById($userId);
            $currentDate = new DateTime(); // Create a DateTime object with the current date

// Add the specified number of months to the current date
            $currentDate->add(new DateInterval('P' . $subData->monthly . 'M'));

// Format the date as desired
            $formattedDate = $currentDate->format('Y-m-d');

            $insertpayload = array(
                "user_id" => $userId,
                "sub_id" => $sub_id,
                "validity" => $formattedDate,
                "usersub_status" => "ACTIVE"
            );
  
            $isInsert = $this->UserSubscription_Model->create($insertpayload);

            if($isInsert){
                $paymentPayload = array(
                    "amount"=> $amount,
                    "sender" => $userData->mobileNumber,
                    "reciever" => '09999999999',
                    "notes" => "Payment for Subscription"
                );

                $isInserPayment = $this->Payment_Model->create($paymentPayload);

                if($isInserPayment){
                    $mySub = $this->UserSubscription_Model->getusersub($userId);
                    $this->res(1,$paymentPayload,"Successfully Paid",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
  
        }

        public function income_get(){
            $data =  $this->UserSubscription_Model->getAllusersub();
            
            $this->res(1,$data,"Subscritpion",0);
        }
    }
?>