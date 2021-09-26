<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class PetOwner extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array('PetOwner_Model'));
        }

        public function sampe_get(){
            echo "Welcome to Happy pet";
        }
    
        public function register_post(){
            $data = $this->decode();
            $fname = isset($data->fname) ? $data->fname : "";
            $lname = isset($data->lname) ? $data->lname : "";
            $email = isset($data->email) ? $data->email : "";
            $password = isset($data->password) ? $data->password : "";
            $cpassword = isset($data->cpassword) ? $data->cpassword : "";
            $gender = isset($data->gender) ? $data->gender : "";
            $contact = isset($data->contact) ? $data->contact : "";
            $address = isset($data->address) ? $data->address : "";
            $pic = "profiles/download.png";

            if(empty($fname) || empty($lname) || empty($email) || empty($password) || empty($cpassword)){
                $this->res(0,null,"Please fill out all fields",0);
            }
            else if(empty($gender) || empty($contact) || empty($address)){
                $this->res(0,null,"Please fill out all fields",0);
            }
            // else if($this->isMobile($contact)){
            //      $this->res(0,null,"Your phone number is invalid",0);
            // }
            // else if($this->PetOwner_Model->isEmailExist($email)){
            //     $this->res(0,null,"Your email is invalid format",0);
            // }
            else{
                $data = array(
                    "owner_firstname" => $fname,
                    "owner_lastname" => $lname,
                    "owner_email" => $email,
                    "password" => $password,
                    "owner_gender" => $gender,
                    "owner_contact" => $contact,
                    "owner_address" => $address,
                    "user_type" => "user"
                );

                $result = $this->PetOwner_Model->register($data);
                if($result){
                    $this->res(1,null,"Successfully Register",0);
                }else{
                    $this->res(0,null,"Something Error in Registration",0);
                }
            }

        }
    
        public function login_post(){
            $data = $this->decode();
            $email =  isset($data->email) ? $data->email : "";
            $password = isset($data->password) ? $data->password : "";

            if(empty($email) || empty($password)){
                $this->res(0,null,"Fill out all fields",0);
            }else{
                $result = $this->PetOwner_Model->login($email,$password);
                if(count($result) > 0){
                    $this->res(1,$result,"Successfully Login",count($result));
                }else{
                    $this->res(0,null,"Wrong Credential",0);
                }
            }
            
        }
    
    }

?>