<?php 
include_once(dirname(__FILE__)."/Data_format.php");

class Booking extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("Booking_Model"));
    }

    public function insert_post(){
        $data = $this->decode();
        $user_id = isset($data->user_id) ? $data->user_id : "";
        $motor_id = isset($data->motor_id) ? $data->motor_id : "";
        $date_start = isset($data->date_start) ? $data->date_start : "";
        $date_end = isset($data->date_end) ? $data->date_end : "";
        $time = isset($data->time) ? $data->time : "";
        $no_days = isset($data->no_days) ? $data->no_days : "";
        $arr = array(
            "user_id" => $user_id,
            "motor_id" => $motor_id,
            "time" => $time,
            "start_date" => $date_start,
            "end_date" => $date_end,
            "booking_status" => 0,
            "no_days" => $no_days
        ); 
        $resp = $this->Booking_Model->insert($arr);
        if($resp){
            $this->res(1,null,"You Book Successfully",0);
        }else{
            $this->res(0,null,"Something went wrong",0);
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
}

?>