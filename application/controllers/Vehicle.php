<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class Vehicle extends Data_Format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Vehicle_Model"));
        }

        public function warmup_post(){
            $this->res(1,null,"Connected",0);
        }
        public function create_post(){
            $orImage = $_FILES['or']['name'];
            $crImage = $_FILES['cr']['name'];
            $vehicleImage = $_FILES['img']['name'];
            $brand = $this->post('brand');
            $model = $this->post('model');
            $description = $this->post('description');
            $userId  =$this->post('userId');
            $vehicleType = $this->post('vehicleType');
            $vehicleIsActive = 'ACTIVE';
            
            $payload = array(
                "brand" => $brand,
                "description" => $description,
                "vehicle_type" => $vehicleType,
                "model" => $model,
                "vehicleIsActive" => $vehicleIsActive,
                "vehicleOr" => "or/".$orImage,
                "vehicleCr" => "cr/".$crImage,
                "vehicleImage" => "products/".$vehicleImage,
                "user_id" => $userId              
            );

            $resp = $this->Vehicle_Model->createVehicle($payload);
        
        
            if($resp){
                move_uploaded_file($_FILES['or']['tmp_name'],"or/".$orImage);
                move_uploaded_file($_FILES['cr']['tmp_name'],"cr/".$crImage);
                move_uploaded_file($_FILES['img']['tmp_name'],"products/".$vehicleImage);
                $this->res(1,null,"Successfully Added",0);
             
            }else{
                $this->res(0,null,"Something went wrong please try again later");
            }
        }

        public function myvehicle_get($userId){
            $data = $this->Vehicle_Model->getVehicleById($userId);

            $this->res(1,$data,"Fetch",count($data));
        }
    
    }
?>