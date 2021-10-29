<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class Pet extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Pet_Model","PetMedical_Model"));
        }

        public function getallpet_get(){
            $data = $this->Pet_Model->getAllpet();
            if(count($data)){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data Not found",0);
            }
        }

        public function insert_post(){
            $user_id = $this->post("id");
            $petname = $this->post("name");
            $category = $this->post("category");
            $weight = $this->post("weight");
            $dob = $this->post("dob");
            $breed = $this->post("breed");
            $color = $this->post("color");
            $pet_pic = $_FILES["petpic"]['name'];
            $med_cert = $_FILES['medcert']['name'];
            
            $data = array(
                "user_id" => $user_id,
                "pet_category" => $category,
                "petname" => $petname,
                "pet_category" => $category,
                "weight" => $weight,
                "dob" => $dob,
                "breed" => $breed,
                "color" => $color,
                "pet_status" => "active",
                "ppic" => "pet/".$pet_pic
            );


            $result = $this->Pet_Model->insert($data);
            if($result){
                $petData = $this->Pet_Model->lastIndex();
                $certData = array(
                    "pet_id" => $petData[0]->pet_id,
                    "medcer_pic" => "petmed/".$med_cert
                );        
                $isSuccess = $this->PetMedical_Model->insert($certData);
                if($isSuccess){
                    $this->res(1,null,"Successfully Added",0);
                }else{
                    $this->res(0,null,"Error Adding medical cert",0);
                }
            }
            else{
                $this->res(0,null,"Error Added",0);
           }
        }
       
       
        public function getpet_get($pet_id){
            $data = $this->Pet_Model->getpet($pet_id);
            if(count($data) > 0){
                $this->res(1,null,"Data found",count($data));
            }
            else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function getpets_get($user_id){
            $data = $this->Pet_Model->getpets($user_id);
            if(count($data) > 0){
                $this->res(1,null,"Data found",count($data));
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    }
?>