
<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Service extends Data_format{


        public function __construct(){
            parent::__construct();
            $this->load->model(array("Service_Model","Certification_Model","User_Model","Schedule_Model","Transaction_Model"));
        }

        //create service
        public function insert_post(){
           
            $id = $this->post("id");
            $type = $this->post("type");
            $specify = $this->post("specify");
            $name = $this->post("name");
            $desc = $this->post("desc");
            $fee = $this->post("fee");
            $limit =  $this->post("limit");
            $sitio = $this->post("sitio");
            $brgy = $this->post("brgy");
            $sDate = $this->post("startDate");
            $eDate = $this->post("endDate");
            $sTime = $this->post("startTime");
            $eTime = $this->post("endTime");
            $publish = $this->post("isPublish");
            $pic = $_FILES['pic']['name'];
            $arr = array(
                "user_id" => $id,
                "service_name" => $name,
                "service_type" => $type,
                "specify_service" => $specify,
                "service_description" => $desc,
                "service_fee" => $fee,
                "service_street" => $sitio,
                "service_brgy" => $brgy,
                "no_pet" => $limit,
                "service_pic" => "banner/".$pic,
                "service_location" => "",
                "service_status" => "available",
                "isAvailable" => "1",
                "date_started" => $sDate,
                "date_end" => $eDate,
                "time_start" => $sTime,
                "time_end" => $eTime,
                "isPublish" => $publish
            );
         
            $res = $this->Service_Model->insert($arr);
            if($res){
                move_uploaded_file($_FILES['pic']['tmp_name'],"banner/".$pic);
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Error",0);
            }

       }
       

      public function createTraining_post(){
        $schedule = json_decode($this->post("sched"));
        $id = $this->post("id");
        $type = $this->post("type");
        $name = $this->post("name");
        $specify = $this->post("specify");
        $desc = $this->post("desc");
        $fee = $this->post("fee");
        $limit =  $this->post("limit");
        $sitio = $this->post("sitio");
        $brgy = $this->post("brgy");
        $sDate = $this->post("startDate");
        $eDate = $this->post("endDate");
        $sTime = $this->post("startTime");
        $eTime = $this->post("endTime");
        $pic = $_FILES['pic']['name'];
        $publish = $this->post("isPublish");
        $arr = array(
            "user_id" => $id,
            "service_name" => $name,
            "service_type" => $type,
            "specify_service" => $specify,
            "service_description" => $desc,
            "service_fee" => $fee,
            "service_street" => $sitio,
            "service_brgy" => $brgy,
            "no_pet" => $limit,
            "service_pic" => "banner/".$pic,
            "service_location" => "",
            "service_status" => "available",
            "isAvailable" => "1",
            "date_started" => $sDate,
            "date_end" => $eDate,
            "time_start" => $sTime,
            "time_end" => $eTime,
            "isPublish" => $publish
        );

        

        $res = $this->Service_Model->insert($arr);
       // var_dump($res); die;
         if($res){
            move_uploaded_file($_FILES['pic']['tmp_name'],"banner/".$pic);
            $last = $this->Service_Model->lastIndex();
           $ar = [];
            if(count($schedule) > 0){
                foreach ($schedule as $value) {
                    $d = array(
                        "service_id" => $last[0]->service_id,
                        "day" => $value->day,
                        "sTime_start"  => $value->timeIn,
                        "eTIme_end" => $value->timeOut
                    );
                    array_push($ar,$d);
                }
                $result =$this->Schedule_Model->insert($ar);
                if($result){
                    $this->res(1,null,"Successfully Added",0);
                }else{
                    $this->res(0,null,"Error added",0);
                }
            }
           
            
            // $result = $this->Schedule_Model->insert($ar);
                // if($result){
                //     $this->res(1,null,"Successfully Added",0);
                // }else{
                //     $this->res(0,null,"error network",0);
                // }
           // }
            
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
            $trans = $this->Transaction_Model->getpets($service_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",count($trans));
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
       
        public function sched($sched){
           
            $last = $this->Service_Model->lastIndex();
            $arr = array();
            foreach ($sched as  $value) {
                $d = array(
                    "service_id" => $last[0]->service_id,
                    "day" => $value->day,
                    "sTime_start" => $value->timeIn,
                    "eTIme_end" => $value->timeOut
                );
               array_push($arr,$d);
            }

           $result = $this->Schedule_Model->insert($arr);
           if($result){
               $this->res(1,null,"Successfully",0);
           }else{
               $this->res(0,null,"Error",0);
           }
            
        }
  
    public function getpost_get(){
        $result = $this->Service_Model->getpost();
        if(count($result) > 0){
            $this->res(1,$result,"Data found",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }

    public function getSched_get($service_id){
        $result = $this->Schedule_Model->getSchedule($service_id);
        if(count($result) > 0){
            $this->res(1,$result,"Data found",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }

    public function nearme_post(){
        $data = $this->decode();
        $brgy = isset($data->brgy) ? $data->brgy : "";
        $result = $this->Service_Model->nearme($brgy);
        
        if(count($result) > 0){
            $this->res(1,$result,"Data found",0);
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }

    public function specify_post(){
        $data = $this->decode();
        $bgy = $data->bgy;
        $bgy_cont = array();
        foreach ($bgy as $value) {
            $result = $this->Service_Model->nearme($value);    # code...
            if(count($result) > 0){
                array_push($bgy_cont,$result[0]);
            }
        }
        $this->res(1,$bgy_cont,"Data",0);
    } 

    public function update_post(){
        $data = $this->decode();
        $id = isset($data->id) ? $data->id : "";
        $name = isset($data->name) ? $data->name : "";
        $desc = isset($data->desc) ? $data->desc : "";
        $no_pet = isset($data->no_pet) ? $data->no_pet : "";
        $fee = isset($data->fee) ? $data->fee : "";
        $street = isset($data->street) ? $data->street : "";
        $brgy = isset($data->brgy) ? $data->brgy : "";       
        
        $arr = array(
            "service_name" => $name,
            "service_description" => $desc,
            "service_fee" => $fee,
            "no_pet" => $no_pet,
            "service_street" => $street,
            "service_brgy" => $brgy 
        );
        $result = $this->Service_Model->update($id,$arr);
        if($result){
            $this->res(1,null,"Successfully Updated",0);
        }
    }

    public function publish_post(){
        $data = $this->decode();
        $id = isset($data->id) ? $data->id : "";
        $publish = isset($data->isPublish) ? $data->isPublish : "";
        $arr = array(
            "isPublish" => $publish
        );
        $result = $this->Service_Model->update($id,$arr);
        if($result){
            $this->res(1,null,"Successfully Updated",0);
        }else{
            $this->res(0,null,"Error",0);
        }
    }

}
?>