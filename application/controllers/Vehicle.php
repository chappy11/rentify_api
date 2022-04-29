<?php 
include_once(dirname(__FILE__)."/Data_format.php");

class Vehicle extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("Motor_Model","History_Model"));
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
            "isVerified"=>0
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

    public function getbyid_get($motor_id){
        $data = $this->Motor_Model->getmotorbyid($motor_id);
        if(count($data) > 0){
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

    public function addpoints_post(){
        $data = $this->decode();
        $motor_id =isset($data->motor_id) ? $data->motor_id : "";
        $points = isset($data->points) ? $data->points : "";
        $motor = $this->Motor_Model->getmotorbyid($motor_id)[0];
        
        $total = $motor->tourmopoints + $points;
        $updated = array(
            "tourmopoints" => $total
        );

        $resp = $this->Motor_Model->update($motor_id,$updated);
        if($resp){
            $this->history_insert(date("Y-m-d"),$motor->user_id,0,$motor_id,$points,1);
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
}


?>