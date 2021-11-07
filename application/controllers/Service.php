
<?php 

include_once(dirname(__FILE__)."/Data_format.php");

    class Service extends Data_format{


        public function __construct(){
            parent::__construct();
            $this->load->model(array("Service_Model","Certification_Model","User_Model"));
        }

        //create service
        public function insert_post(){
           $data = $this->decode();
            $id = isset($data->id) ? $data->id : "";
            $type = isset($data->type) ? $data->type : "";
            $name = isset($data->name) ? $data->name : "";
            $desc = isset($data->desc) ? $data->desc : "";
            $fee = isset($data->fee) ? $data->fee : "";
            $limit =  isset($data->limit) ? $data->limit : "";
            $sitio = isset($data->sitio) ? $data->sitio : "";
            $brgy = isset($data->brgy) ? $data->brgy :"";
            $sDate = isset($data->date_start) ? $data->date_start: "";
            $eDate = isset($data->date_end) ? $data->date_end : "";
            $sTime = isset($data->time_start) ? $data->time_start : "";
            $eTime = isset($data->time_end) ? $data->time_end : "";

            $arr = array(
                "user_id" => $id,
                "service_name" => $name,
                "service_type" => $type,
                "service_description" => $desc,
                "service_fee" => $fee,
                "service_street" => $sitio,
                "service_brgy" => $brgy,
                "no_pet" => $limit,
                "service_location" => "",
                "service_status" => "available",
                "isAvailable" => "1",
                "date_started" => $sDate,
                "date_end" => $eDate,
                "time_start" => $sTime,
                "time_end" => $eTime
            );
         
            $res = $this->Service_Model->insert($arr);
            if($res){
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Error",0);
            }

       }
       

       //get service 
       public function allService_get(){
            $result = $this->Service_Model->getAllService();
            if(count($result) > 0){
                $this->res(1,$result,"Data found",count($result));
            }else{
                $this->res(0,null,"Data not found",0);
            }
       }

       //get services of the user
       public function getservices_get($user_id){
            $result = $this->Service_Model->getservices($user_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"data not found",0);
            }
       }
    
       public function getservice_get($service_id){
            $result = $this->Service_Model->getservice($service_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
       }

       public function getapplication_get(){
           $result = $this->Service_Model->getapplication();
           if(count($result)){
               $this->res(1,$result,"Data found",0);
           }else{
               $this->res(0,null,"Data not found",0);
           }
       }

       public function verify_post(){
           $data = $this->decode();
           $id = $data->id;
           $status = $data->status;
        
           $arr = array(
               "service_status" => $status
           );

           $result = $this->Service_Model->verify($id,$arr);
           if($result){
               $this->res(1,null,"Successfully Update",0);
           }else{
               $this->res(0,null,"Network Error",0);
           }
        }
        public function getCert_get($service_id){
            $data = $this->Certification_Model->getcert($service_id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",count($data));
            }else{
                $this->res(0,null,"Data not found",0);
            }        
        }
    }
?>