<?php 
include_once (dirname(__FILE__) ."/Data_format.php");

class User extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model(array("User_Model"));
    }


    //view all user
    public function userlist_get(){
      $data = $this->User_Model->user_list();
        if(count($data)<1){
            $this->res(0,null,"No data found",0);
        }
        else{
            $this->res(1,$data,"Data found",0);
        }
    }

    //register all user
    public function register_post(){
         $user_pic = $_FILES['user_pic']['name'];
       $license = $_FILES['license']['name'];
        $fname = $this->post("fname");
        $mname = $this->post("mname");
        $lname = $this->post("lname");
        $email = $this->post("email");
        $password = $this->post("password");
        $contact = $this->post("contact");

       
        if($this->User_Model->isEmailExist($email)){
            $this->res(0,null,"Email is Already Exist",0);
        }else{
            $data = array(
                "email" => $email,
                "password" => $password,
                "firstname" => $fname,
                "middlename" => $mname,
                "lastname" => $lname,
                "contact" => $contact,
                "user_pic" => "profiles/".$user_pic,
                "license_pic" => "certification/".$license,
                "user_type" => "user",
                "isActive" => 1
            ); 
            $res = $this->User_Model->register($data);
            if($res){
                move_uploaded_file($_FILES['user_pic']['tmp_name'],"profiles/".$user_pic);
                move_uploaded_file($_FILES['license']['tmp_name'],"certification/".$license);
                $this->res(1,null,"Successfully Registerd",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

    }
        
    
    

    public function login_post(){
        $data = $this->decode();
        $email = isset($data->email) ? $data->email : "";
        $password = isset($data->password) ? $data->password : "";
        
        
        $resp = $this->User_Model->login($email,$password);
        if(count($resp) > 0) {
            $this->res(1,$resp,"Succesfully Login",0);
        }else{
            $this->res(0,null,"Error",0);
        }
        
    }

    public function update_post(){
        $data = $this->decode();
        $id = isset($data->user_id) ? $data->user_id : "";
        $fname = isset($data->fname) ? $data->fname : "";
        $mname = isset($data->mname) ? $data->mname : "";
        $lname = isset($data->lname)  ? $data->lname  : "";
        $contact = isset($data->contact) ? $data->contact : "";

        //old data
        $current = $this->User_Model->getProfile($id);
        $fn = $fname == "" ? $current[0]->firstname : $fname;
        $mn = $mname == "" ? $current[0]->middlename : $mname;
        $ln = $lname == "" ? $current[0]->lastname : $lname;
        $cont = $contact == "" ? $current[0]->contact : $contact;

        $array = array(
            "firstname" => $fn,
            "middlename" => $mn,
            "lastname" => $ln,
            "contact" => $cont
        );
        $resp = $this->User_Model->update($id,$array);
        if($resp){
            $this->res(1,null,"Successfully Updated",0);
        }else{
            $this->res(1,$array,"Something went wrong",0);
        }
    }

    public function changeStatus_post(){
        $data = $this->decode();
        $id = $data->id;
        $status = $data->status;
        
        $paylaod = array(
            "isActive" => $status
        );

        $resp = $this->User_Model->update($id,$payload);
        if($resp){
            $this->res(1,null,"Successfully Updated",0);
        }else{
            $this->res(0,null,"Something Went Wrong",0);
        }
    }

    public function 
}

?>