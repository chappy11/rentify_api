<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class Vehicle extends Data_Format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Vehicle_Model","VehicleImage_Model"));
        }

        public function warmup_post(){
            $this->res(1,null,"Connected",0);
        }
        
        public function create_post(){
            $orImage = $_FILES['or']['name'];
            $crImage = $_FILES['cr']['name'];
            $nonce = $this->post("nonce");
            $brand = $this->post('brand');
            $model = $this->post('model');
            $description = $this->post('description');
            $capacity =$this->post("capacity");
            $userId  =$this->post('userId');
            $vehicleType = $this->post('vehicleType');
            $vehicleIsActive = 'ACTIVE';
            $price = $this->post("price");

            $payload = array(
                "brand" => $brand,
                "description" => $description,
                "vehicleImage" => $nonce,
                "vehicle_type" => $vehicleType,
                "model" => $model,
                "capacity" => $capacity,
                "vehicleIsActive" => $vehicleIsActive,
                "vehicleOr" => "or/".$orImage,
                "vehicleCr" => "cr/".$crImage,
                "user_id" => $userId,              
                "price" => $price,
            );

            $resp = $this->Vehicle_Model->createVehicle($payload);
        
        
            if($resp){
                move_uploaded_file($_FILES['or']['tmp_name'],"or/".$orImage);
                move_uploaded_file($_FILES['cr']['tmp_name'],"cr/".$crImage);
                $this->res(1,null,"Successfully Added",0);
             
            }else{
                $this->res(0,null,"Something went wrong please try again later");
            }
        }

        public function myvehicle_get($userId){
            $data = $this->Vehicle_Model->getVehicleById($userId);
            $arr_container = [];
            foreach($data as $val){
                $vehicleImg = $this->VehicleImage_Model->getByNonce($val->vehicleImage);
                $imgPayload = array("images" => $vehicleImg);
                $pyload = (object)array_merge((array)$val,(array)$imgPayload);

                array_push($arr_container,$pyload);
            }

            $this->res(1,$arr_container,"Fetch",count($data));
        }


        public function vehicles_get(){
            $data = $this->Vehicle_Model->getVehicles();
            $arr_container = [];
            foreach($data as $val){
                $vehicleImg = $this->VehicleImage_Model->getByNonce($val->vehicleImage);
                $imgPayload = array("images" => $vehicleImg);
                $pyload = (object)array_merge((array)$val,(array)$imgPayload);

                array_push($arr_container,$pyload);
            }

            $this->res(1,$arr_container,"Fetch",count($data));
        }
    

        public function details_get($id){
            $data = $this->Vehicle_Model->getVehicleDetails($id)[0];
            $vehicleImg = $this->VehicleImage_Model->getByNonce($data->vehicleImage);
            $imgPayload = array("images" => $vehicleImg);
            $pyload = (object)array_merge((array)$data,(array)$imgPayload);
            $this->res(1,$pyload,'Fetch',0);
        }

        public function update_post($id){
            $data = $this->decode();
            $resp = $this->Vehicle_Model->updateData($id,$data);

            if($resp){
                $this->res(1,null,"Fetch",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }
    }
?>