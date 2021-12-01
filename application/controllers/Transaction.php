<?php 
     include_once(dirname(__FILE__)."/Data_format.php");

    class Transaction extends Data_format{


        public function __construct(){
            parent::__construct();
            $this->load->model(array("Transaction_Model","Expenses_Model","Pet_Model","Service_Model","Notification_Model","Rating_Model","FeedBack_Model"));
        }

        public function insert_post(){
            $data = $this->decode();
            $service_id = isset($data->service_id) ? $data->service_id : "";
            $date_start = isset($data->date_start) ? $data->date_start : "";
            $no_days = isset($data->no_days) ? $data->no_days : "";
            $service_type = isset($data->service_type) ? $data->service_type : "";
            $pets = $data->pets;
            $total = isset($data->fee) ? $data->fee : "";
            $expenses = $data->expenses;
            $date_end = date("Y-m-d",strtotime($date_start." + $no_days days"));
            $petlist = [];
            $users = $this->Service_Model->getservice($service_id);

            foreach ($pets as $value) {
                $d = array(
                    "pet_id"=>$value->pet_id,
                    "service_id" => $service_id,
                    "date_start" => $date_start,
                    "date_end" => $date_end,
                    "trans_type" => $service_type,
                    "trans_status" => "apply",
                    "total_fee" => $total
                );
                $this->Transaction_Model->insert($d);
                $dat = $this->Transaction_Model->lastIndex();
                if(count($expenses) > 0){
                    foreach ($expenses as  $val) {
                        $ex = array(
                            "transac_id" => $dat[0]->transac_id,
                            "expense_type" => $val->type,
                            "expense_description" => $val->description
                        );
                        $this->Expenses_Model->insert($ex);
                    }
                }
                $myarr = array(
                    "pet_status" => "apply"
                );
                $this->Pet_Model->update($value->pet_id,$myarr);
                $nam = "Dear ".$users[0]->firstname." ".$users[0]->lastname;
                $body = "You have a new applicant for ".$users[0]->service_name;
                $this->notification($users[0]->user_id,$nam,$body,"enroll",$dat[0]->transac_id);
            }
            $this->res(1,null,"Successfully Save",0);
          
        }

        public function enroll_post(){
            $data = $this->decode();
            $service_id = isset($data->service_id) ? $data->service_id : "";
            $service_type = isset($data->service_type) ? $data->service_type : "";
            $date_start = isset($data->date_start) ? $data->date_start : "";
            $date_end = isset($data->date_end) ? $data->date_end : "";
            $fee = isset($data->fee) ? $data->fee : "";
            $pets = $data->pets;
            $dat = $this->Transaction_Model->lastIndex();
            $users = $this->Service_Model->getservice($service_id);
            foreach ($pets as $value) {
                $d = array(
                    "pet_id" => $value->pet_id,
                    "service_id" => $service_id,
                    "date_start" => $date_start,
                    "date_end" => $date_end,
                    "trans_type" => $service_type,
                    "trans_status" => "apply",
                    "total_fee" => $fee
                );
                $this->Transaction_Model->insert($d);
                $myarr =array(
                    "pet_status" => "apply"
                );
                $this->Pet_Model->update($value->pet_id,$myarr);
                $nam = "Dear ".$users[0]->firstname." ".$users[0]->lastname;
                $body = "You have a new applicant for ".$users[0]->service_name;
                $this->notification($users[0]->user_id,$nam,$body,"enroll",$dat[0]->transac_id);
            }
            $this->res(1,null,"Successfully Enrolled",0);
        }




        public function getapply_get($service_id){
            $result = $this->Transaction_Model->getApplication($service_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function getExpense_get($trans_id){
            $result = $this->Expenses_Model->getTrans($trans_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function date_get(){
            $data = $this->decode();
            $no_days = $data->no_days;
            echo date("Y-m-d", strtotime($data->date." + $no_days days"));
            
        }

        public function accept_post(){
            $data = $this->decode();
            $id = $data->id;
            $pet_id =  $data->pet_id;
            
            $d = array(
                "trans_status" => "accept"
            );
            $result = $this->Transaction_Model->update($id,$d);
            if($result){
                $p = array(
                    "pet_status"=>"onBoard"
                );              
        
                $update = $this->Pet_Model->update($pet_id,$p);
                $pet = $this->Pet_Model->getOwner($pet_id);
                if($update){
                    $this->res(1,null,"Succesfully Updated",0);
                    $nam = "Dear ".$pet[0]->firstname." ".$pet[0]->lastname;
                    $body = "You applicatin for enrollment is accepted by trainer ";
                    $this->notification($pet[0]->user_id,$nam,$body,"pet",$pet_id);
                }else{
                    $this->res(0,null,"Error",0);
                 }
            }else{
               
            }


        }
  
        public function notification($id,$name,$body,$type,$target_id){
            $arr = array(
                "user_id" => $id,
                "notif_name" => $name,
                "notif_body" => $body,
                "notif_status" => 0,
                "notif_type" =>$type,
                "target_id" => $target_id
            );
  
             $this->Notification_Model->createNotif($arr);
            
        }
        
        
        public function getPetTrans_get($pet_id){
            $result = $this->Transaction_Model->getpetTrans($pet_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function getpetAccepts_get($service_id){
            $result = $this->Transaction_Model->getpets($service_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function servicerecieve_post(){
            $data = $this->decode();
            $pet_id = $data->pet_id;
            $type = $data->type;
            $service_id = $data->service_id;
            $arr = array(
                "pet_status" => $type
            );
            $sOwner = $this->Service_Model->serviceOwner($service_id);
            $owner = $this->Pet_Model->getOwner($pet_id);
            $result = $this->Pet_Model->update($pet_id,$arr);
            if($result){        
                $name = $owner[0]->firstname ." ". $owner[0]->lastname;
                $body = "Your Pet ".$owner[0]->petname." has been recieve by ".$sOwner[0]->firstname." ".$sOwner[0]->lastname." from ".$sOwner[0]->service_name;
                $this->notification($owner[0]->user_id,$name,$body,"pet",$pet_id);
                $this->res(1,null,"Successfully Accepted",0);
            }else{
                $this->res(0,null,"Error Accepted",0);
            }
        }

        public function confirm_post($trans_id){
            $arr = array(
                "ispayed" => 1
            );
            $result = $this->Transaction_Model->update($trans_id,$arr);
            if($result){
                $this->res(1,null,"Successfully Confirm",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }
  
        public function done_post(){
            $data= $this->decode();
            $transac_id = $data->id;
            $pet_id = $data->pet_id;
            $rate = $data->rate;
            $service_id = $data->service_id;
            $feedback = $data->feedback;
            $tr = array(
                "trans_status" => "done",
                "date_end"=> date("Y-m-d")
            );

            $result =$this->Transaction_Model->update($transac_id,$tr);
            if($result){
                $pr = array(
                    "pet_status" => "active"
                );

                $res = $this->Pet_Model->update($pet_id,$pr);
                if($res){
                    $service = $this->Service_Model->getservice($service_id);
                    if($rate > 0){
                        $rt = array(
                            "rate_count" => $rate,
                            "user_id" => $service[0]->user_id
                        );
                        $r = $this->Rating_Model->insert($rt);
                        if($r){
                            $this->res(1,null,"Successfully Submitted",0);
                            $owner = $this->Pet_Model->getOwner($pet_id);
                            $name = $owner[0]->firstname." ".$owner[0]->lastname;
                            $body = $owner[0]->petname." was successfully recieved by owner";
                            $this->notification($service[0]->user_id,$name,$body,"transaction",$service[0]->user_id);
                            if($feedback != ""){
                                $arr = array(
                                    "user_id" => $service[0]->user_id,
                                    "sender_id" => $owner[0]->user_id,
                                    "feedback" => $feedback
                                );
                                $this->FeedBack_Model->insert($arr);
                            }
                           
                        }else{
                            $this->res(0,null,"Error ",0);
                        }
                    }else{
                        $this->res(1,null,"Successfully Submited",0);

                    }        
                }
            }
        }

        public function cancel_post(){
            $data = $this->decode();
            $trans_id = $data->transac_id;
            $pet_id = $data->pet_id;
            $users = $this->Transaction_Model->getTransaction($trans_id);
            $owner = $this->Pet_Model->getOwner($pet_id);
            $name = $owner[0]->firstname." ".$owner[0]->lastname;
            $body = $name." cancel his/her booking";
           
            $this->notification($users[0]->user_id,$name,$body,"transaction",$trans_id);
            
            $result = $this->Transaction_Model->cancel($trans_id);
            if($result){
                    $arr = array(
                        "pet_status" => "active"
                    );
                    $res = $this->Pet_Model->update($pet_id,$arr);
                    if($res){
                        
                        $this->res(1,null,"Successfully Remove",0);
                       
                    }else{
                        $this->res(0,null,"Error ",0);
                    }
            }else{
                $this->res(0,null,"Error",0);
            }
        }
        
        public function requestReturn_post(){
            $data = $this->decode();
            $trans_id = $data->trans_id;
            $pet_id = $data->pet_id;
            $user_id = $data->user_id;
            $arr = array(
                "reqReturn" => 1
            );

            $result = $this->Transaction_Model->update($trans_id,$arr);
            if($result){
                $owner = $this->Pet_Model->getOwner($pet_id);
                $name = $owner[0]->firstname." ".$owner[0]->lastname;
                $body = $name." request to return his/her pet ".$owner[0]->petname;
                $this->notification($user_id,$name,$body,"transaction",$trans_id);              
                $this->res(1,null,"Successfully Requested",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }

        public function sample_get($trans_id){
            $result = $this->Transaction_Model->getTransaction($trans_id);
            print_r($result);
        }

        public function gettrans_get($trans_id){
            $result = $this->Transaction_Model->gettrans($trans_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
  
    }

?>