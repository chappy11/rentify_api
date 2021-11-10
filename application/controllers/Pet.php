<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class Pet extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Pet_Model","PetMedical_Model","Petimg_Model"));
        }

        public function getallpet_get(){
            $data = $this->Pet_Model->getAllpet();
            if(count($data)){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data Not found",0);
            }
        }

        public function addpet_post(){
            $user_id = $this->post("id");
            $petname = $this->post("name");
            $category = $this->post("category");
            $weight = $this->post("weight");
            $dob = $this->post("dob");
            $breed = $this->post("breed");
            $color = $this->post("desc");
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
                "description" => $color,
                "pet_status" => "active",
                "ppic" => "pets/".$pet_pic
            );
            
            

            move_uploaded_file($_FILES['petpic']['tmp_name'],"pets/".$pet_pic);
            move_uploaded_file($_FILES['medcert']['tmp_name'],"medcert/".$med_cert);

            $result = $this->Pet_Model->insert($data);
            if($result){
                $petData = $this->Pet_Model->lastIndex();
                $certData = array(
                    "pet_id" => $petData[0]->pet_id,
                    "medcer_pic" => "medcert/".$med_cert
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
                $this->res(1,$data,"Data found",count($data));
            }
            else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function getpets_get($user_id){
            $data = $this->Pet_Model->getpets($user_id);
            if(count($data) > 0){
                $this->res(1,$data
                ,"Data found",count($data));
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function getcerts_get($pet_id){
            $data = $this->PetMedical_Model->getmedicals($pet_id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function addimg_post(){
            $id = $this->post("id");
            $img = $_FILES['img']['name'];

            $arr = array(
                "pet_id" => $id,
                "petimg" => "pets/".$img
            );
            
            $result = $this->Petimg_Model->insert($arr);
            if($result){
                $this->res(1,null,"Successfully Added",0);
            }else{
                $this->res(0,null,"Error Added",0);
            }
        }
    }
?>