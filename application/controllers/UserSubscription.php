<?php 
    include_once(dirname(__FILE__)."/Data_format.php");
    class UserSubscription extends Data_format{
        
        public function __construct(){
      
            parent::__construct();
            $this->load->model(array("User_Model","UserSub_Model","Subscription_Model","Sublog_Model"));
        }

        public function insert_post(){
            $data = $this->decode();
            $sub_id = $data->sub_id;
            $user_id = $data->user_id;
            $no_month = $data->no_month;
            $card = $data->card;
            $start_date = date("Y-m-d");
            $end_date = date("Y-m-d",strtotime($start_date . "+$no_month months"));

            $arr = array(
                "card" => $card,
                "user_id" => $user_id,
                "sub_id" => $sub_id,
                "sub_start" => $start_date,
                "sub_end" => $end_date,
                "sub_status" => "active"
            );

            $result = $this->UserSub_Model->insert($arr);
            if($result){
                $ar = array(
                    "isSubscribe" => $sub_id
                );
                $update = $this->User_Model->update($user_id,$ar);
                if($update){
                    $logs = array(
                        "sub_id" => $sub_id,
                        "user_id" => $user_id,
                        "log_start" => $start_date,
                        "log_end" => $end_date
                    );
                    $lg = $this->Sublog_Model->insert($logs);
                    if($lg){
                        $this->res(1,null,"Successfully Subscribe",0);
                    }else{
                        $this->res(0,null,"Error Updated",0);
                    }
                    
                }else{
                    $this->res(0,null,"Error",0);
                }

               
            }else{
                $this->res(0,null,"Error",0);
            }

        }

        public function mysub_get($id){
            $result = $this->UserSub_Model->mysub($id);
            if(count($result) > 0){
                $this->res(1,$result,"data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
  
        public function renewal_post(){
            $data = $this->decode();
            $usub_id = $data->usub_id;
            $sub_id = $data->sub_id;
            $sub = $this->Subscription_Model->sub($sub_id);
            $user = $this->UserSub_Model->getsub($usub_id);
            $sub_end = $sub[0]->sub_month;
            $end_date = date("Y-m-d",strtotime($user[0]->sub_end . "+$sub_end months"));
            $start_date = $user[0]->sub_end;
            $arr = array(
                "sub_id" => $sub_id,
                "sub_end" => $end_date
            );
            $update = $this->UserSub_Model->update($usub_id,$arr);
            if($update){
                $lg = array(
                    "sub_id" => $sub_id,
                    "user_id" => $user[0]->user_id,
                    "log_start" => $start_date,
                    "log_end" => $end_date
                );
                $up = $this->Sublog_Model->insert($lg);
                if($up){
                    $this->res(1,null,"Sucessfully Updated",0);
                }else{
                    $this->res(0,null,"Error Updated",0);
                }
            }else{
                $this->res(0,null,"Error Updating",0);
            }
        }
    }

?>