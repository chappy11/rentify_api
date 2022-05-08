<?php 
include_once(dirname(__FILE__)."/Data_format.php");

class Booking extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("Booking_Model","User_Model","Motor_Model","Notification_Model","History_Model"));
    }

    public function insert_post(){
        $data = $this->decode();
        $user_id = isset($data->user_id) ? $data->user_id : "";
        $motor_id = isset($data->motor_id) ? $data->motor_id : "";
        $date_start = isset($data->date_start) ? $data->date_start : "";
        $date_end = isset($data->date_end) ? $data->date_end : "";
        $time = isset($data->time) ? $data->time : "";
        $no_days = isset($data->no_days) ? $data->no_days : "";
        $total = isset($data->total) ? $data->total : "";
        $arr = array(
            "user_id" => $user_id,
            "motor_id" => $motor_id,
            "time" => $time,
            "start_date" => $date_start,
            "end_date" => $date_end,
            "booking_status" => 0,
            "no_days" => $no_days,
            "onStart" => 0,
            "total_amount" => $total
        ); 
        $check = $this->Booking_Model->checkpending($user_id,$motor_id);
        if(count($check) > 0){
            $this->res(0,null,"You Have Current Pending Transaction ",0);
        }else{
               $resp = $this->Booking_Model->insert($arr);
                if($resp){
                    $this->res(1,null,"You Book Successfully",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
        }
     
    }

    public function getbyuser_get($user_id){
        $data = $this->Booking_Model->getbyuserid($user_id);
        if(count($data) > 0){
            $this->res(1,$data,"Data found",0);
        }else{
            $this->res(0,null,"No data found",0);
        }

    }

    public function getbooking_get($id){
        $data = $this->Booking_Model->getbyid($id);
        if(count($data) > 0){
            $this->res(1,$data,"Data found",count($data));
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }

    public function getbymotorid_get($id){
        $data = $this->Booking_Model->getbymotorid($id);
        if(count($data) > 0){
            $this->res(1,$data,"Data Found",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }

    public function getbookinglist_get($owner_id){
        $data = $this->Booking_Model->getmybookinglist($owner_id);
        if(count($data) > 0){
            $this->res(1,$data,"Data found",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }

    public function getongoing_get($owner_id){
        $data = $this->Booking_Model->getongoing($owner_id);
        if(count($data) > 0){
            $this->res(1,$data,"Data found",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }

    public function getdatelist_get($motor_id){
        $data = $this->Booking_Model->getvalidate($motor_id);
        if(count($data) > 0){
            $this->res(1,$data,"Data found",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }


    public function cancelbooking_post($booking_id){
        $bookingData = $this->Booking_Model->getbyid($booking_id)[0];
        $vehicleData = $this->Motor_Model->getmotorbyid($bookingData->motor_id)[0];
        $userdata = $this->User_Model->getProfile($vehicleData->user_id)[0];
        $arr = array(
            "booking_status" => "3"
        );
        //print_r($bookingData);
        $resp = $this->Booking_Model->update($booking_id,$arr);
        if($resp){
            $notif = array(
                "notif_title" => "Booking Cancel",
                "notif_body" => $userdata->firstname." ".$userdata->lastname." cancel his/her booking",
                "isRead" => 0,
                "notif_type" => 2,
                "user_id" => $vehicleData->user_id
            );

            $this->Notification_Model->insert($notif);
            $this->res(1,null,"Successfully Canceled",0);
        }else{
            $this->res(0,null,"Something went wrong",0);
        }
    }

    public function acceptbooking_post($booking_id){
       
        $bdata = $this->Booking_Model->getbyid($booking_id)[0];
        $mdata = $this->Motor_Model->getmotorbyid($bdata->motor_id)[0];
       
      
        if($mdata->tourmopoints < ($bdata->total_amount * 0.15)){
            $this->res(1,null,"Your tourmopoints is insufficient",0);
        }else{
            $arr = array(
                "booking_status" => 1
            );
            $isAccept = $this->Booking_Model->update($booking_id,$arr);
            if($isAccept){
                $r = array(
                    "tourmopoints" => $mdata->tourmopoints - ($bdata->total_amount * 0.15)
                );
                $onRent = $this->Motor_Model->update($bdata->motor_id,$r);
                if($onRent){
                    $x = array(
                        "isRent" => 1
                    );
                    $isRent = $this->User_Model->update($bdata->user_id,$x);
                    if($isRent){
                        $notif = array(
                            "notif_title" => "Booking Accepted",
                            "notif_body" => "Your Booking has successfully accepted",
                            "isRead" => 0,
                            "notif_type" => 2,
                            "user_id" => $bdata->user_id
                        );
                        $this->Notification_Model->insert($notif);
                        $trn = $this->trngenerator($bdata->end_date);
                        $this->history_insert($bdata->user_id,$booking_id,0,0,2,$trn);
                        $this->history_insert($mdata->user_id,$booking_id,0,0,2,$trn);
                        $this->declinebooking($booking_id,$bdata->motor_id);     
                        $this->res(1,null,"Successfully Accepted",0);
                    }else{
                        $this->res(0,null,"Something went wrong",0);
                    }
                }else{
                    $this->res(1,null,"Something went wrong",0);
                }
            }else{
                $this->res(1,null,"Something went wrong",0);
            }
    
        }

    }

    public function declinebooking_post($booking_id){
        $arr =  array(
            "booking_status" => 3
        );
        $id = $this->Booking_Model->getbyuser($booking_id);
        $resp = $this->Booking_Model->update($booking_id,$arr);
        if($resp){
            $notif = array(
                "notif_title" => "Booking Declined",
                "notif_body" => "Sorry your booking has been declined by owner",
                "isRead" => 0,
                "notif_type" => 2,
                "user_id" => $id->user_id
            );
        $this->Notification_Model->insert($notif);
            $this->res(1,null,"Successfully Declined",0);
        }else{
            $this->res(0,null,"Something went wrong",0);
        }
    }
  
    public function declinebooking($booking_id,$motor_id){
        $list = [];
        $bookaccepted = $this->Booking_Model->getbyid($booking_id)[0];
        $curr = $this->getDatesFromRange($bookaccepted->start_date,$bookaccepted->end_date);
       // print_r($curr);
        $other = $this->Booking_Model->getpending($motor_id);
        foreach($other as $val){
               $d = $this->getDatesFromRange($val->start_date,$val->end_date);
                $dat = array_intersect($d,$curr);
                if(count($dat) > 0){
                    array_push($list,$val->booking_id);
                }
            }
        if(count($list) > 0){
            foreach($list as $val){
                $id = $this->Booking_Model->getbyid($val)[0];
                $decline = array(
                    "booking_status" => 3
                );
                $update = $this->Booking_Model->update($val,$decline);
                if($update){
                     $notif = array(
                            "notif_title" => "Booking Declined",
                            "notif_body" => "Sorry your booking has been decline because it may the motorbike that you select is already book by another user",
                            "isRead" => 0,
                            "notif_type" => 2,
                            "user_id" => $id->user_id
                        );
                    $this->Notification_Model->insert($notif);
                }else{
                    $this->res(0,null,"Something went wrong while updating",0);
                }
               
                
            }
        }
    }

    public function startbooking_post($booking_id){
        $data = $this->Booking_Model->getbyid($booking_id)[0];     
        $mdata =  $this->Motor_Model->getmotorbyid($data->motor_id)[0];
        
        $dat = array(
            "onStart" => 1
        );
        $onRent = $this->Booking_Model->update($booking_id,$dat);
        if($onRent){
            $arr = array(
                "onRent" => 1
            );
            $isArr = $this->Motor_Model->update($data->motor_id,$arr);
            if($isArr){
                $this->res(1,null,"Successfully",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }else{
            $this->res(0,null,"Something went wrong",0);
        }
    }
  
    public function returnMotor_post($booking_id){
        $onStart = array(
            "onStart" => 3,
            "booking_status" => 2
        );
        $data = $this->Booking_Model->getbyid($booking_id)[0];
        $mdata = $this->Motor_Model->getmotorbyid($data->motor_id)[0];
        $resp = $this->Booking_Model->update($booking_id,$onStart);
        $notif = array(
            "user_id" => $mdata->user_id,
            "isRead" => 0,
            "notif_type" => 3,
            "notif_title" => "Return Motorbike",
            "notif_body" => "User return motorbike"
        ); 
        if($resp){
            $this->Notification_Model->insert($notif);
            $this->res(1,null,"Successfully Return",0);
        }else{
            $this->res(0,null,"Something went wrong",0);
        }
    }

    

    public function confirmReturn_post($booking_id){
        $bdata = $this->Booking_Model->getbyid($booking_id)[0];
        $motor = array(
            "onRent" => 0
        );

        $user = array(
            "isRent" => 0
        );

        $update = $this->Motor_Model->update($bdata->motor_id,$motor);
            if($update){
                $updateuser = $this->User_Model->update($bdata->user_id,$user);
                if($updateuser){
                    $book_stat = array(
                        "booking_status" => 5
                    );
                    $updatebooking = $this->Booking_Model->update($booking_id,$book_stat);
                   
                    if($updatebooking){
                        $this->res(1,null,"Successfully Confirm",0);
                    }else{
                        $this->res(0,null,"Something went wrong",0);
                    }
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
    }
  
    public function getDatesFromRange($start, $end, $format='Y-m-d') {
    return array_map(function($timestamp) use($format) {
        return date($format, $timestamp);
    },
    range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
    }

    public function history_insert($rec_id,$booking_id,$motor_id,$amount,$type,$trn){
     
        $arr = array(
            "ref_no" => $trn,
            "amount" => $amount,
            "his_type" => $type,
            "motor_id" => $motor_id,
            "booking_id" => $booking_id,
            "rec_id" => $rec_id
        );
        $this->History_Model->insert($arr);
    }
    
    public function trngenerator($date){
        $en = str_replace("-","",$date);
        $rand = mt_rand(1111,9999);
        $trn = "TRN-".$en."-".$rand;
        return $trn;
    }
   
}

?>