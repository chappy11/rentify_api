<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Drivers extends Data_format{

        public function __construct(){
            parent::__construct();

            $this->load->model(array("Drivers_Model"));
        }


        public function create_post(){
            $img = $_FILES['img']['name'];
            $license = $_FILES['license']['name'];
    

            $owner_id = $this->post('owner_id');
            $username = $this->post('username');
            $password = $this->post('password');
            $firstname = $this->post('fname');
            $middlename = $this->post('mname');
            $lastname = $this->post('lname');
            $contactNumber = $this->post('contact');;
        
            $payload = array(
                "owner_id" => $owner_id,
                "username" => $username,
                "password" => $password,
                "firstName" => $firstname,
                "middleName" => $middlename,
                "lastName" => $lastname,
                "contactNumber" => $contactNumber,
                "driver_pic" => "shops/".$img,
                "driver_license" => "shops/".$license
            );
        
            $result = $this->Drivers_Model->create($payload);

            if($result){
                move_uploaded_file($_FILES['img']['tmp_name'],"shops/".$img);
                move_uploaded_file($_FILES['license']['tmp_name'],"shops/".$license);
                $this->res(1,null,"Successfully Registered",0);
                
            }else{
                $this->res(0,null,"Something went wrong please try again later");
            }
        }

        public function login_post(){
            $data = $this->decode();

            $username = $data->username;
            $password = $data->password;

            $result = $this->Drivers_Model->login($username,$password);
              
            
            if(count($result) < 1){
                $this->res(0,null,"Account Not found",0);
            }else{
                $this->res(1,$result[0],"Successfully Login",0);
            }
        }

        public function getdriverbyowner_get($ownerId){
            $data = $this->Drivers_Model->getDriversByOwner($ownerId);

            $this->res(1,$data,'Success get',0);
        }
    }
?>