<?php 
include_once(dirname(__FILE__)."/Data_format.php");

class Account extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("Account_Model"));
        $this->load->helper(array("form","url"));
    }

    //Registration for user... 
  
    public function register_post(){
        $data = $this->decode();
        $email = isset($data->email) ? $data->email : "";
        $pass = isset($data->pass) ? $data->pass : "";
        $fname = ucfirst(isset($data->fname) ? $data->fname : "");
        $mi = ucfirst(isset($data->mi) ? $data->mi : "");
        $lname = ucfirst(isset($data->lname) ? $data->lname : "");
        $gender =  isset($data->gender) ? $data->gender : "";
        $bday = isset($data->bday) ? $data->bday : "";
        $civil = isset($data->civil) ? $data->civil : "";
        $contact = isset($data->contact) ? $data->contact : "";
        $sitio = isset($data->sitio) ? $data->sitio : "";
        $brgy =  isset($data->brgy) ? $data->brgy : "";
        $type = "user";
        $status = "active";
         if($this->Account_Model->isEmailExist($email)){
            $this->res(0,null,"This Email is already Existed",0);
        }
        else{

         $user = array(
            "acnt_pic" => "profiles/download.png",
            "email" => $email,
            "password" => $pass,
            "firstname" => $fname,
            "mi" => $mi,
            "lastname" => $lname,
            "civil_status" => $civil,
            "birthdate" => $bday,
            "gender" => $gender,
            "contact" => $contact,
            "sitio" => $sitio,
            "brgy" => $brgy,
            "type" => $type,
            "status" => $status
        );
            $res = $this->Account_Model->register($user);
                if($res){
                    $this->res(1,null,"Successfully Registered",0);
                }
                else{
                    $this->res(0,null,"Network may not availble or server is under maintainance",0);
                }
        }
    }

    public function createadmin_post(){
        $data = $this->decode();
        
        $email =  isset($data->email) ? $data->email : "";
        $fname = ucfirst(isset($data->fname) ? $data->fname : "");
        $mi =  ucfirst(isset($data->mi) ? $data->mi : "");
        $lname = ucfirst(isset($data->lname) ? $data->lname : "");
        $gender = isset($data->gender) ? $data->gender : "";
        $contact = isset($data->contact) ? $data->contact : "";
        $sitio = isset($data->sitio) ? $data->sitio : "";
        $brgy = isset($data->brgy) ? $data->brgy : "";
        $password = mt_rand(100000,999999);
        $username = "admin_".$fname."".$password;
        $message = "<p>Welcome to Tabogarahe we are assign you as a admin</p>
                    <p>Username:{$username}</p>
                    <p>Password:{$password}</p>";
                    
        
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'smtp.mailtrap.io';
        $config['smtp_port']    = '465';
        $config['smtp_user'] = '9d029ad9cac28d';
        $config['smtp_pass'] = 'bcf3804b878028';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      
        $this->load->library('email');

        $this->email->initialize($config);
        $this->email->from("tabogarahe@gmail.com");
        $this->email->to($email);
        $this->email->subject("Your Account");
        $this->email->message($message);
       
       $isExist = $this->Account_Model->isEmailExist($email);
     //  var_dump($isExist);
       if($isExist){
            $this->res(0,null,"This Email is Already Existed",0);
       }
       else if($this->isEmail($email)){
            $this->res(0,null,"Invalid Email",0);
     }else{
            $admin = array(
                "acnt_pic" => "profiles/download.png",
                "username" => $username,
                "password" => $password,
                "email" => $email,
                "firstname" => $fname,
                "mi" => $mi,
                "lastname" => $lname,
                "gender" => $contact,
                "contact" => $contact,
                "civil_status"=>"",
                "birthdate"=>"",
                "sitio" => $sitio,
                "brgy" => $brgy,
                "type"=>"admin2",
                "status"=>"active"
            
            );
            $res = $this->Account_Model->register($admin);
            if($res){
                $send = $this->email->send();
                    if($send){
                        $this->res(1,null,"Successfully Created!",0);
                    }else{
                        $this->res(0,null,"Email was not send",0);
                    }
            }else{
                $this->res(0,null,"Something error",0);
            }
        }  
    }

    //Login for user
    public function login_post(){
        $data = $this->decode();
        $email = isset($data->email) ? $data->email : "";
        $password  = isset($data->password) ? $data->password : "";

        
            $res = $this->Account_Model->login($email,$password);
            $user_status = "";
            foreach($res as $newData){
                $user_status = $newData->status;
            }
           
            if(count($res) > 0){
                if($user_status== "inactive"){
                    $this->res(0,null,"Your Account is inactive due to reports pls try to email the admin",0);
                }else{
                $this->res(1,$res, "Successfuly Login",0);
                }
            }else{
                $this->res(0,null,"Wrong Credentials",0);
            }
    
    }

    //Update your Personal Information
    public function updateDetails_post(){
        $data = $this->decode();
        $id = isset($data->id) ? $data->id : "";
        $fname = isset($data->fname) ?  $data->fname : "";
        $mi = isset($data->mi) ? $data->mi : "";
        $lname = isset($data->lname) ? $data->lname : "";
        $contact = isset($data->contact) ? $data->contact : "";
        $age = isset($data->age) ? $data->age : "";        
        $firstname = "";
        $lastname = "";
        $mis = "";
        $phone = "";
        $nage =  "";
        $profile = $this->Account_Model->profile($id);
        foreach($profile as $newData){
            $firstname = $newData->firstname;
            $lastname = $newData->lastname;
            $mis = $newData->mi;
            $phone = $newData->contact;
            $nage = $newData->age;
        }
        
        if(empty($fname)){
            $fname = $firstname;
        }
         if(empty($mi)){
            $mi = $mis;
        }
         if(empty($lname)){
            $lname = $lastname;
        } 
         if(empty($contact)){
            $contact = $phone;
        }
         if(empty($age)){
             $age = $nage;
         }
    
        $user = array(
            "firstname" => ucfirst($fname),
            "MI" => ucfirst($mi),
            "lastname" => ucfirst($lname),
            "contact" => $contact,
            "age" => $age
        );
        $res =  $this->Account_Model->update($user,$id);
        if($res){
            $this->res(1,null,"Successfully Updated",0);
        }else{
            $this->res(0,null,"Error updating",0);
        }
    }

    //view the all active or inactive users
    public function status_get($status){
        $count = $this->Account_Model->user_status($status);
        if(count($count) < 1){
            $this->res(0,null,"there is no ".$status." user",0);
        }
        else{
            $this->res(1,$count,"data found",0);
        }
    }

    //Update Profile Picture of the user
    public function updateProfilePic_post(){
        $file = $_FILES['pp']['name'];
        $id = $this->post('id');
        $ext = pathinfo($file, PATHINFO_EXTENSION);
       
        if(empty($file)){
            $this->res(0,null,"File is Empty");
        }
        else if($this->all_ext($ext)){
            $this->res(0,null,"Your file extension is not allowed, only jpg,png, and jpeg is allowed");
        }else{
            $profilepic = move_uploaded_file($_FILES['pp']['tmp_name'],"profiles/".$file);
            $user = array("acnt_pic" => "http://localhost/tabogarahe/profiles/".$file);
            $upload = $this->Account_Model->update($user,$id);
            if($upload){
                $this->res(1,null,"successfully updated",0);
            }else{
                $this->res(0,null,"error",0);
            }
        }
        
    }

    //Update the password of the user
    public function updatePassword_post(){
        $data = $this->decode();
        $id = isset($data->id) ? $data->id : "";
        $pass = isset($data->password) ? $data->password : "";
        $npass = isset($data->npassword) ? $data->npassword : "";
        $cpass = isset($data->cpassword) ? $data->cpassword : "";
        $check = $this->Account_Model->checkpass($id,$pass);
        if(empty($pass) || empty($npass) || empty($cpass) || empty($id)){
            $this->res(0,null,"Fill out all Fields",0);
        }
        else if(!$check){
            $this->res(0,$check,"Pls, enter your old password correctly",0);
        }
        else if($npass != $cpass){
            $this->res(0,null,"you password do not match",0);
        }else{
            $user = array("password" => $npass);
            $update = $this->Account_Model->update($user,$id);
            if($update){
                $this->res(1,null,"Successfully Updated",0);
            }else{
                $this->res(0,null,"Error Updated",0);
            }
        }
            
        
       
    }

    //get user's profile with id
    public function profile_get($id){
        $data = $this->Account_Model->profile($id);
        $this->res(1,$data,"data found", count($data));
    }

    //update user status
    public function updateStatus_post($id,$status){
        $user = array(
            "status" => $status
        );
        $res = $this->Account_Model->update($user,$id);
        
        if($res){
            $this->res(1,null,"Successfully Updated",0);
        }else{
            $this->res(0,null,"Error",0);
        }
    }

    public function users_get(){
        $data = $this->Account_Model->getAll();
        $this->res(1,$data,"data found",count($data));
    }

    public function userlist_get($user){
        $data = $this->Account_Model->userlist($user);
        if(count($data) > 0 ){
            $this->res(1,$data,"datafound",count($data));
        }else{
            $this->res(1,null,"data not found",0);
        }
    }

 
}



?>