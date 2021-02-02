<?php 

require_once (dirname(__FILE__)."/Data_format.php");


class Account extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("Account_Model"));
    }

    //create  user's account
    public function register_post(){
        $data = $this->decode();
        $email = isset($data->email) ? $data->email : "";
        $pass = isset($data->pass) ? $data->pass : "";
        $cpass = isset($data->cpass) ? $data->cpass : ""; 
        $fname = isset($data->fname) ? $data->fname : "";
        $mi = isset($data->mi) ? $data->mi : "";
        $lname = isset($data->lname) ? $data->lname : "";
        $gender = isset($data->gender) ? $data->gender : "";
        $contact = isset($data->contact) ? $data->contact : "";
        $address = isset($data->address) ? $data->address : ""; 
        
        if(empty($email) || empty($pass) || empty($cpass) || empty($fname) || empty($mi)|| empty($lname)|| empty($gender)|| empty($contact)|| empty($address)){
            $this->res(0,null,"Pls Fill out all fields");
        }
        else if($this->isEmail($email)){
            $this->res(0,null,"Email is Invalid");
        }
        
        else if($this->containsNumbers($fname) || $this->containsNumbers($mi) || $this->containsNumbers($lname)){
            $this->res(0,null,"Not allowed number");
        }
        
        else if($pass!=$cpass){
            $this->res(0,null,"Password do not match");
        }
        else if($this->isMobile($contact)){
            $this->res(0,null,"Invalid Mobile Number");
        }
        
        else {
            $emailCount = $this->Account_Model->emailExist($email);
            if(count($emailCount)>0){
                $this->res(0,null,"Email is Already Use");
            }else{
                $user = array(
                    "acnt_pic" => "http://localhost/tabogarahe/profiles/download.png",
                    "email" => $email,
                    "password" => $pass,
                    "firstname" => $fname,
                    "mi" => $mi,
                    "lastname" => $lname,
                    "gender" => $gender,
                    "contact" => $contact,
                    "address" => $address,
                    "type" => "user",
                    "status" => "active"
                );
                $res = $this->Account_Model->register($user);
                if($res){
                    $this->res(1,null,"Successfully Registered");
                }else{
                    $this->res(0,null,"Error");
                }
            }
            
        }
    }

    //user's login
    public function login_post(){
       $data = $this->decode();
        
        $email = isset($data->email)? $data->email : "";
        $password = isset($data->password) ? $data->password : "";

        if(empty($email) || empty($password)){
            $this->res(0,null,"Fill out All Fields");
        }else{
            $user = array(
                "email"=> $email,
                "password" => $password
            );
            $res = $this->Account_Model->login($user);
            if(count($res) > 0){
                $this->res(1,$res,"successfully login");
            }
            else{
                $this->res(0,null,"wrong credential");
            }

        }
    }
    
    //change the user's status to active or inactive
    public function status_post($id,$status){ 
        $res = $this->Account_Model->status($id,$status);
    }

    //update user's details
    public function update_post(){
        $data = $this->decode();
        
        $fname = isset($data->fname) ? $data->fname : "";
        $mi = isset($data->mi) ? $data->mi : "";
        $lname = isset($data->lname) ? $data->lname : "";
        $cont = isset($data->contact) ? $data->contact : "";
        $address = isset($data->address) ? $data->address : "";
        
        if($this->isMobile($cont)){
            $this->res(0,null,"Invalid Mobile Number");
        }else{
            $user = array(
                "firstname" => $fname,
                "MI" => $mi,
                "lastname" => $lname,
                "contact" => $cont,
                "address" => $address  
            );
            $res = $this->Account_Model->update(1,$user);
            if($res){
                $this->res(1,null,"successfully updated");
            }else{
                $this->res(0,null,"error");
            }

        }

    }

    //update user's password
    public function upassword_post(){
        $data = $this->decode();
        $id = isset($data->id) ? $data->id : "";
        $npass = isset($data->npass) ? $data->npass : "";
        $cnpass = isset($data->cnpass) ? $data->cnpass : "";
        $opass = isset($data->opass) ? $data->opass : "";
        $count = $this->Account_Model->isPassword($opass);
        if($npass!=$cnpass){
            $this->res(0,null,"Your New password do not match");
        }else if($count<1){
            $this->res(0,null,"You enter the wrong password");
        }else{
            $res = $this->Account_Model->changePassword(1,$npass);
            if($res){
                $this->res(1,null,"successfully updated");
            }
            else{
                $this->res(0,null,"error");
            }
        }

   }

  
   //update user's profile picture
    public function pp_post(){
        $img = $_FILES['img']['name'];
        if(empty($img)){
            $this->res(0,null,"empty");
        }else{
            $s = "http://localhost/tabogarahe/profiles/".$img;
            $move = move_uploaded_file($_FILES['img']['tmp_name'],"profiles/".$img);
            if($move){
                $res = $this->Account_Model->profilepic(1,$s);
                if($res){
                    $this->res(1,null,"Successfully updated");
                }
                else{
                    $this->res(0,null,"error");
                }
            }
        }       
    }

    public function getUser_get($id){
        $user = $this->Account_Model->getUser($id);
        $this->res(1,$user,"data found");
    }
}



?>