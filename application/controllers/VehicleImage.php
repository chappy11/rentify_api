<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class VehicleImage extends Data_format{
    
        public function __construct(){
            parent::__construct();
            $this->load->model(array("VehicleImage_Model"));
        }

        public function upload_post(){
            $img = $_FILES['img']['name'];
            $nonce = $this->post("nonce");
            $temp = explode(".", $_FILES["img"]["name"]);
            $vehicleName = $nonce."_".$temp[0];
            $newfilename = $vehicleName . '.' . end($temp);
            $uploadPath = "products/".$newfilename;

            $payload = array(
                "nonce"=>$nonce,
                "path"=>$uploadPath
            );

            $isCreated = $this->VehicleImage_Model->create($payload);

            if($isCreated){
                $isUpload = move_uploaded_file($_FILES["img"]["tmp_name"], $uploadPath);
                if($isUpload){
                    $this->res(1,$uploadPath,"Success GG",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
            
        }
    

        public function getimage_get($nonce){
            $data = $this->VehicleImage_Model->getByNonce($nonce);

            $this->res(1,$data,"GG",0);
        }
    
    }
?>