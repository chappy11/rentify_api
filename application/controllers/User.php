<?php 
include_once (dirname(__FILE__) ."/Data_format.php");

class User extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model(array("User_Model","Company_Model","Facility_Model","Certification_Model"));
    }


    //view all user
    public function userlist_get(){
      $data = $this->User_Model->user_list();
        if(count($data)<1){
            $this->res(0,null,"no data founds",0);
        }
        else{
            $this->res(1,$data,"data found",0);
        }
    }

    //register all user
    public function register_post(){
        $data = $this->decode();
           
            $dat = array(
                "email" => $data->email,
                "password" => $data->password,
                "user_pic" => "profiles/download.png",
                "firstname" => $data->fname,
                "lastname" => $data->lname,
                "contact" => $data->contact,
                "birthday" => "",
                "street" => $data->sitio,
                "barangay" => $data->brgy,
                "user_type" => "user",
                "user_status" => "active",
                "service_status" => "none",
                "service" => "none",
                "isSubscribe" => 0
            );
            // $this->res(1,$dat,"Data",0);
            $res = $this->User_Model->register($dat);
            if($res){
                $this->res(1,null,"success",0);
            }else{
                $this->res(0,null,"error network",0);
            }
    }
        
    
    
    //login admin
    public function loginAdmin_post(){
        $data = $this->decode();
        $email = isset($data->email) ? $data->email : "";
        $password = isset($data->password) ? $data->password : "";
        if(empty($email) || empty($password)){
            $this->res(0,null,"Fillout All Fields",0);
        }else{
            $res = $this->User_Model->login_admin($email,$password);
            if(count($res) > 0){
                $this->res(1,$res,"Successfully Login",1);
            }else{
                $this->res(0,null,"Wrong Credential",0);
            }
        }
    }


    //login user
    public function login_post(){
        $d = $this->decode();
       
        $email = isset($d->email) ? $d->email : "";
        $password = isset($d->password) ? $d->password : "";
        
        if(empty($email) || empty($password)){
            $this->res(1,null,"Fill out all Fields",0);
        }else{
           $res = $this->User_Model->login($email,$password);
           if(count($res)>0){
                $this->res(1,$res,"Successfully login",0);
           }else{
                $this->res(0,null,"Wrong credential",0);
           }
            
        }
    }

    //get profile 
    public function getprofile_get($id){
        $data = $this->User_Model->getProfile($id);
        if(count($data) > 0 ){
            $this->res(1,$data,"Data found",count($data));
        }else{
            $this->res(0,null,"data not found",0);
        }
    }

    //update user details
    public function update_post(){
        $d = $this->decode();
        $user_id = isset($d->user_id) ? $d->user_id : "";
        $username = isset($d->username) ? $d->username : "";
        $password = isset($d->password) ? $d->password : "";
        
        $data = array(
            "username"=>$username,
            "password"=>$password
        );

        $res = $this->User_Model->update($user_id,$data);
        if($res){
            $this->res(1,null,"successfully updated");
        }else{
            $this->res(0,null,"error updated");
        }
    }
    
    public function apply_post(){
        $id = $this->post('id');
        $type = $this->post("type");
        $company = json_decode($this->post("company"));
        $cert = $_FILES['cert']['name'];
        $fac1 = $_FILES['fac1']['name'];
        $fac2 = $_FILES['fac2']['name'];
        $fac3 = $_FILES['fac3']['name'];

        $data = array(
            "service" => $type,
            "service_status" => "apply"
        );

        $update = $this->User_Model->update($id,$data);
        if($update){
            if(count($company) > 0){
                foreach($company as $val){
                    $comp = array(
                        "user_id" => $id,
                        "company_name" => $val->comp,
                        "exp_years" => $val->yrs
                    );
                     $this->Company_Model->addComp($comp);
                }
            }
        $cer = array(
            "user_id" => $id,
            "cert_pic" => "certification/".$cert
        );
        $this->Certification_Model->insert($cer);
        $f1 = array(
            "user_id" => $id,
            "fac_pic" => "facility/".$fac1
        );
        $this->Facility_Model->insert($f1);
        $f2 = array(
            "user_id" => $id,
            "fac_pic" => "facility/".$fac2
        );
        $this->Facility_Model->insert($f2);
        $f3 = array(
            "user_id" => $id,
            "fac_pic" => "facility/".$fac3
        );
        $this->Facility_Model->insert($f3);
        move_uploaded_file($_FILES['cert']['tmp_name'],"certification/".$cert);
        move_uploaded_file($_FILES['fac1']['tmp_name'],"facility/".$fac1);
        move_uploaded_file($_FILES['fac2']['tmp_name'],"facility/".$fac2);
        move_uploaded_file($_FILES['fac3']['tmp_name'],"facility/".$fac3);
        $this->res(1,null,"Application Successfully Submitted",0);

        }else{
            $this->res(0,null,"Error Creating Application",0);
        }
    }
    
    
    
    public function sample_post(){
        $file = $_FILES['videoFile']['name'];
        $this->res(1,$file,"gg",0);
        move_uploaded_file($_FILES['videoFile']['tmp_name'],"uploads/".$file);
    }


    public function sample2_post(){
        
        $data = json_decode($this->post('arr'));
        $this->res(1,$data[0],"Data fond",0);
    }
}


?>