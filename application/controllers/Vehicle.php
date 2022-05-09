<?php 
include_once(dirname(__FILE__)."/Data_format.php");
require(dirname(__FILE__)."/config.php");
class Vehicle extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("Motor_Model","History_Model","Notification_Model","Booking_Model","Notification_Model","Payment_Model","Report_Model"));
    }

    public function addMotor_post(){
        $pic1 = $_FILES['pic1']['name'];
        $pic2 = $_FILES['pic2']['name'];
        $pic3 = $_FILES['pic3']['name'];
        $offRec = $_FILES['offRec']['name'];
        $certReg = $_FILES['certReg']['name'];
        $user_id = $this->post("user_id");
        $m_id = $this->post("m_id");
        $name = $this->post("name");
        $transmission = $this->post("transmission");
        $rate = $this->post("rate");
        $brand = $this->post("brand");
        $date = $this->post("date");
        $arr = array(
            "pic1" => "motor/".$pic1,
            "pic2" => "motor/".$pic2,
            "pic3" => "motor/".$pic3,
             "offRec" => "or/".$offRec,
             "certReg" => "cr/".$certReg,
            "user_id" => $user_id,
            "m_id" => $m_id,
            "name" => $name,
            "rate" => $rate * 0.15,
            "transmission" => $transmission,
            "brand"=>$brand,
            "onRent" => 0,
            "isActive" => 0,
            "tourmopoints" => 0,
            "isVerified"=>0,
            "expire" => 0,
            "docu_exp" =>$date
        );
        $resp = $this->Motor_Model->addMotor($arr);
        if($resp){
            move_uploaded_file($_FILES['pic1']['tmp_name'],"motor/".$pic1);
            move_uploaded_file($_FILES['pic2']['tmp_name'],"motor/".$pic2);
            move_uploaded_file($_FILES['pic3']['tmp_name'],"motor/".$pic3);
            move_uploaded_file($_FILES['offRec']['tmp_name'],"or/".$offRec);
            move_uploaded_file($_FILES['certReg']['tmp_name'],"cr/".$certReg);
            $this->res(1,null,"Successfully Added",0);
        }else{
            $this->res(0,null,"Something went wrong",0);
        }
    } 

    public function update_post(){
        $id = $this->post("motor_id");
        $offRec = $_FILES['offRec']['name'];
        $certReg = $_FILES['certReg']['name'];
        $date = $this->post("date");
        $arr = array(
            "offRec" => "or/".$offRec,
             "certReg" => "cr/".$certReg,
             "docu_exp" => $date
        );

        $resp = $this->Motor_Model->update($id,$arr);
        if($resp){
            move_uploaded_file($_FILES['offRec']['tmp_name'],"or/".$offRec);
            move_uploaded_file($_FILES['certReg']['tmp_name'],"cr/".$certReg);
            $this->res(1,null,"Successfully Updated",0);
        }else{
            $this->res(0,null,"Error while updating",0);
        }
    }

    public function getbyid_get($motor_id){
        $data = $this->Motor_Model->getmotorbyid($motor_id);
        
        if(count($data) > 0){
            $this->check($motor_id);
            $this->res(1,$data[0],"Data Retrive",count($data));
        }else{
            $this->res(0,null,"Error",0);
        }
    }

    public function getbyuser_get($user_id){
        $data = $this->Motor_Model->getmotorbyuser($user_id);
        if(count($data)){
            $this->res(1,$data,"Successfully Retrieve",count($data));
        }else{
            $this->res(0,null,"No data found",0);
        }
    }

    public function getbymid_get($m_id){
        $data = $this->Motor_Model->getmotorbymid($m_id);
        if(count($data) > 0){
            $this->res(1,$data,"Data found",0);
        }else{
            $this->res(0,null,"No Data found",0);
        }
    }

    public function addpoints($motor_id,$points){
     
        $motor = $this->Motor_Model->getmotorbyid($motor_id)[0];
        
        $total = $motor->tourmopoints + $points;
        $updated = array(
            "tourmopoints" => $total
        );

        $resp = $this->Motor_Model->update($motor_id,$updated);
        if($resp){
            $ar = array(
                "notif_title" => "Adding Tourmopoint",
                "notif_body" => "You have successfully Top up Tourmopoint",
                "isRead" => 0,
                "notif_type" => 0,
                "user_id" => $motor->user_id
            );
            $this->Notification_Model->insert($ar);
            $this->res(1,null,"Points Successfully Added",0);
        }else{
            $this->res(0,null,"Something went wrong",0);
        }

    }

    public function allVehicle_get(){
        $data = $this->Motor_Model->allvehicle();
        if(count($data) > 0){
            $this->res(1,$data,"Data found",count($data));
        }else{
            $this->res(0,null,"No data found",0);
        }
    }

    public function verify_post(){
        $data = $this->decode();
        $id = $data->id;
        $arr = array(
            "isVerified" => 1
        );
        $res = $this->Motor_Model->update($id,$arr);
        if($res){
            $this->res(1,null,"Successfully Updated",0);
        }else{
            $this->res(0,null,"Error",0);
        }
    }

    public function allpostvehicle_get(){
        $data = $this->Motor_Model->getpostvehicle();
        if(count($data) > 0){
            $this->res(1,$data,"data found",count($data));
        }else{
            $this->res(0,null,"data not found",0);
        }
    }

    public function history_insert($date,$rec_id,$booking_id,$motor_id,$amount,$type){
        $en = str_replace("-","",$date);
        $rand = mt_rand(1111,9999);
        $trn = "TRN-".$en."-".$rand;
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

        public function sample_get(){
         $this->res(1,null,"HI",0);         
        }

    
    public function check($motor_id){
        $data = $this->Motor_Model->getmotorbyid($motor_id)[0];
        if($data->docu_exp == date("Y-m-d")){
            $ar = array(
                "expire" => 1
            );
            $this->Motor_Model->update($motor_id,$ar);
        }

       
    }

    public function deactivate_post($id){
        $data = $this->Booking_Model->checkbooking($id);   
        $arr = array(
            "isActive" => 0
        );
       $resp = $this->Motor_Model->update($id,$arr);
        if($resp){
            if(count($data) > 0){
                foreach ($data as $value) {
                    $r = array(
                        "booking_status" => 3
                    );
                    $this->Booking_Model->update($value->booking_id,$r);
                    $notif_title = "Booking Canceled";
                    $notif_body = "Your Booking has been cancel because motorbike is deactivated it may have some issue";
                    $usr_id = $value->user_id;
                    $notif_type = 2;
                    $this->notif($notif_title,$notif_body,$usr_id,$notif_type);
                }
                $this->res(1,null,"Successfully Deactivated",0);
            }else{
                $this->res(1,null,"Successfully Deactivated",0);
            }
        }else{
            
            $this->res(0,null,"Something went wrong",0);
        }

    }

    public function activate_post($vehicle_id){
        $payload = array(
            "isActive" => 1
        );
        $res = $this->Motor_Model->update($vehicle_id,$payload);
        if($res){
            $this->res(1,null,"Successfully Activated",0);
        }else{
            $this->res(0,null,"Something went wrong",0);
        }
    }

    public function notif($notif_title,$notif_body,$user_id,$notif_type){
        $payload = array(
            "notif_title" => $notif_title,
            "notif_body" => $notif_body,
            "isRead" => 0,
            "notif_type" => $notif_type,
            "user_id" => $user_id
        );
        $this->Notification_Model->insert($payload);
    }

    public function pay_post(){
        $payload = $this->decode();
        $motor_id = isset($payload->motor_id) ? $payload->motor_id : "";
        $amount = isset($payload->amount) ? $payload->amount : "";
        $user_id = isset($payload->user_id) ? $payload->user_id : "";
        $stripe = new \Stripe\StripeClient(
            'sk_test_51IlXo6G5BhKeRDfTmCYLpZjnDUjIECIgBZUlFNzYGQqXepWsBCxj6lVHrBWAm4iYNUbvABO7jEpcgf8VEsGp6K0G00X9HlI94e'
          );
           $data =  $stripe->charges->create([
            'amount' => $amount * 100,
            'currency' => 'php',
            'source' => 'tok_mastercard',
            'description' => 'Pay Tourmopoints',
          ]);

        
          if($data->status == "succeeded"){
            if($this->insert_payment($user_id,$data->id,$amount,$data->receipt_url)){
                $getpayment = $this->Payment_Model->getbyuser($user_id)[0];
                if($this->insert_history($getpayment->payment_id,$user_id)){
                    if($this->insert_report($user_id,$amount)){
                        $this->addpoints($motor_id,$amount);
                    }else{
                        $this->res(0,null,"Something went wrong",0);
                    }
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }

            }else{
                $this->res(0,null,"Something went wrong",0);
            }
          }else{
              $this->res(1,null,"Payment",0);
          }


    }   

    public function insert_payment($user_id,$trans_id,$amount,$link){
        $arr = array(
            "user_id" => $user_id,
            "trans_id" => $trans_id,
            "amount" => $amount,
            "receipt_link" => $link
        );
        return $this->Payment_Model->insert($arr);
    }

    public function insert_report($user_id,$amount){
        $arr = array(
            "amount" => $amount,
            "user_id" => $user_id,
            "month" => date("M"),
            "year" => date("Y")
        );
        return  $this->Report_Model->insert($arr);
    }

    public function insert_history($payment_id,$rec_id){
        $trn = $this->trngenerator(date("Y-m-d"));
        $type = 0;
        $arr = array(
            "ref_no" => $trn,
            "his_type" => 0,
            "amount" => 0,
            "payment_id" => $payment_id,
            "rec_id" => $rec_id
        );
        return $this->History_Model->insert($arr);
    }

    public function trngenerator($date){
        $en = str_replace("-","",$date);
        $rand = mt_rand(1111,9999);
        $trn = "TRN-".$en."-".$rand;
        return $trn;
    }
}


?>