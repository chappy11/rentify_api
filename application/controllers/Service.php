
<?php 

include_once(dirname(__FILE__)."/Data_format.php");

    class Service extends Data_format{


        public function __construct(){
            parent::__construct();
            $this->load->model(array("Service_Model","Certification_Model","User_Model"));
        }

        //create service
        public function insert_post(){
            $id = $this->post("id");
            $name = $this->post("name");
            $type = $this->post("type");
            $description = $this->post("description");
            $fee = $this->post("fee");
            $sitio = $this->post("sitio");
            $brgy = $this->post("brgy");
            $location = $this->post("location");
            $no_pet = $this->post("no_pet");
            $date_started = $this->post('date_start'); 
            $date_end = $this->post('date_end'); 
            $time_start = $this->post('time_start');
            $time_end = $this->post('time_end');
            $certif = $_FILES['cert']['name'];
            $fac1 = $_FILES['fac1']['name'];
            $fac2 = $_FILES['fac2']['name'];
            $fac3 = $_FILES['fac3']['name'];
        
            $data = array(
                "user_id" => $id,
                "service_name" => $name,
                "service_type" => $type,
                "service_description" => $description,
                "service_fee" => $fee,  
                "service_street" => $sitio,
                "service_brgy" => $brgy,
                "date_started" => $date_started,
                "date_end" => $date_end,
                "time_start" => $time_start,
                "time_end" => $time_end,
                "service_location" => $location,
                "no_pet" => $no_pet,
                "service_status" => "apply",
                "isAvailable" => 1,
                "fac1" => "facility/".$fac1,
                "fac2" => "facility/".$fac2,
                "fac3" => "facility/".$fac3
            );

            
            move_uploaded_file($_FILES['cert']['tmp_name'],"certification/".$certif);
            move_uploaded_file($_FILES['fac1']['tmp_name'],"facility/".$fac1);
            move_uploaded_file($_FILES['fac2']['tmp_name'],"facility/".$fac2);
            move_uploaded_file($_FILES['fac3']['tmp_name'],"facility/".$fac3);
            $result = $this->Service_Model->insert($data);
            if($result){
                $lastIndex = $this->Service_Model->lastIndex();
                $service_id = $lastIndex[0]->service_id;
                $certData = array(
                    "service_id" => $service_id,
                    "cert_pic" => "certification/".$certif
                );
                $isSuccess = $this->Certification_Model->insert($certData);
                if($isSuccess){
                   $updateUser = array(
                       "service" => $this->serviceType($type)
                   ); 
                   $isUpdate = $this->User_Model->update($id,$updateUser);
                    if($isUpdate){
                        $this->res(1,null,"Successfully Register Please wait for admin to accept it",0);
                    }else{
                        $this->res(0,null,"Error Updating",0);
                    }
                }else{
                    $this->res(0,null,"Error Inserting Cert",0);
                }
            }else{
                $this->res(0,null,"Error Inserting Service",0);
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