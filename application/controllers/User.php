<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class User extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("User_Model",'OwnerDocument_Model'));
        }
        //note:
        //user role:
        //0 admin
        //1 seller
        //2 customer
        
        
        public function warmup_get(){
            $this->res(1,null,"Hello world",1);
        }

        

        public function register_post(){
            $data = $this->decode();
            $username = $data->userName;
            $password = $data->password;
            $firstName = $data->firstName;
            $middleName = $data->middleName;
            $lastName = $data->lastName;
            $gender = $data->gender;
            $birthdate = $data->birthdate;
            $address = $data->address;
            $email = $data->email;
            $mobileNumber = $data->mobileNumber;
            $user_type = 'RENTER';
            $isActive = 'ACTIVE';

            $payload = array(
                "username" => $username,
                "password" => $password,
                "firstname" => $firstName,
                "middleName" => $middleName,
                "lastName" => $lastName,
                "gender" => $gender,
                "birthdate" => $birthdate,
                'email' => $email,
                'mobileNumber' => $mobileNumber,
                'address' => $address,
                "user_type" => $user_type,
                "isActive" => $isActive
            );

            $resp = $this->User_Model->createUser($payload);


            if($resp){
                $this->res(1,null,"Successfully Registered",1);
            }else{
                $this->res(0,null,"Something went wrong",0);   
            }
        }


        public function login_post(){
            $data = $this->decode();
            
            $username = $data->username;
            $password = $data->password;
            
            $resp = $this->User_Model->login($username,$password);

            if(count($resp) < 1){
                $this->res(0,null,"Account is not exist",0);
            }else{
                $this->res(1,$resp[0],"Successfully Login",0);
            }
        }

        public function updatepicture_post(){
            $userId = $this->post('id');
            $img = $_FILES['img']['name'];

            $payload = array(
                'image' => "profiles/".$img,
            );

            $isUpdate = $this->User_Model->update($userId,$payload);
            
        }

        public function updatetoowner_post(){
            $document = $_FILES['docs']['name'];
            $docsType = $this->post("documentType");
            $userId = $this->post("userId");
            $type = "OWNER";

            $userPayload = array(
                "user_status" => 3
            );
            $responseOfUpdateUser = $this->User_Model->updateUser($userId,$userPayload);

            if($responseOfUpdateUser){
                $docsPayload = array(
                    'user_id' => $userId,
                    "documentImage" => "profiles/".$document,
                    "documentType" => $docsType
                );

                $resp = $this->OwnerDocument_Model->create($docsPayload);

                if($resp){
                    move_uploaded_file($_FILES['docs']['tmp_name'],"profiles/".$document);
                    $resp = $this->User_Model->getuser($userId);

                    $this->res(1,$resp[0],'Successfully Update',0);
                }

            }else{
                $this->res(0,null,"Something went wrong",0);
            }

        }


        public function isEmailExist($email,$type){
            $isExist = false;

            if($type === "shop" && $this->Shop_Model->checkShopEmailExist($email)){
                $isExist = true;
            }

            if($type === "customer" && $this->Customer_Model->checkIsEmailExist($email)){
                $isExist =  true;
            }

            return $isExist;

        }

        public function isMobileExist($mobile,$type){
            $isExist = false;

            if($type === "shop" && $this->Shop_Model->checkMobileExist($mobile)){
                $isExist = true;
            }

            if($type === "customer" && $this->Customer_Model->checkMobileNumberExist($mobile)){
                $isExist = true;
            }

            return $isExist;
        }

      
        public function approvedowner_post($user_id){
            $user = $this->User_Model->getUserById($user_id);

            $payload = array(
                "user_type" => 'OWNER',
                "user_status" => 0
            );
        
        
            $isUpdateUser = $this->User_Model->updateUser($user_id,$payload);

            if($isUpdateUser){
                $this->approvedEmail($user->email);

                $this->res(1,null,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }


        }

        public function getuserbystatus_get($status){
            $user = $this->User_Model->getuserbystatus($status);

            $this->res(1,$user,"GET",count($user));
        }

        public function updateuser_post($id){
            $data = $this->decode();

            $isUpdate = $this->User_Model->update($id,$data);

            if($isUpdate) {
                $user = $this->User_Model->getUserById($id);
                $this->res(1,$user,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }


        public function verification_post(){
            $data = $this->decode();
            $email = $data->email;
            $code = $data->code;

            $ht ="<html>
            <div style='margin: auto; width: 600px'>
              <h3 style='text-align: center'>Rentify Verification Code</h3>
          
              <p style='text-align: center'>
                Your verification code is ".$code." please do not share it to anyone
              </p>
            </div>
          </html>";
            $config['protocol']    = 'smtp';
            $config['smtp_host']    = 'smtp.mailtrap.io';
            $config['smtp_port']    = '2525';
            $config['smtp_user'] = 'b335966fcea021';
            $config['smtp_pass'] = '8c7829be9a1f4a';
            $config['charset']    = 'utf-8';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'html'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not      
            $this->load->library('email');

            $this->email->initialize($config);
            $this->email->from("no-reply@petsoceity.com");
            $this->email->to($email);
            $this->email->subject("Verification Code");
            $this->email->message($ht);
  
            $resp = $this->email->send();
        
            if($resp){
                $this->res(1,null,"Successfully Sent",0);
            }else{
                $this->res(0,null,"Error Verification",0);
            }
        }

        public function approvedEmail($email){
            $ht ="<html>
            <div style='margin: auto; width: 600px'>    
              <h3 style='text-align: center'>Welcome to Rentify</h3>
              <p style='text-align: center'>
            Congratulations! Your are now part of Rentify Owners.
              </p>
            </div>
          </html>";
            $config['protocol']    = 'smtp';
            $config['smtp_host']    = 'smtp.mailtrap.io';
            $config['smtp_port']    = '2525';
            $config['smtp_user'] = 'b335966fcea021';
            $config['smtp_pass'] = '8c7829be9a1f4a';
            $config['charset']    = 'utf-8';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'html'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not      
            $this->load->library('email');

            $this->email->initialize($config);
            $this->email->from("no-reply@petsoceity.com");
            $this->email->to($email);
            $this->email->subject("Email Verificatoin Code");
            $this->email->message($ht);
  
            $this->email->send();
        }

        //admin

        public function users_post(){
            $data = $this->decode();

            $resp = $this->User_Model->getuserQuery($data);
            $this->res(1,$resp,'GG',count($resp));
        }
    }

?>