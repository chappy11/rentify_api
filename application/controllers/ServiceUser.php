<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class ServiceUser extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("ServiceUser_Model"));
        }


        public function getapply_get(){
            $data = $this->ServiceUser_Model->getapply();
            if(count($data) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function getprofile_get($id){
            $data = $this->ServiceUser_Model->getuser($id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",count($data));
            }else{
                $this->res(0,$data,"Data not found",0);
            }
        }

        public function getusers_get(){
            $data = $this->ServiceUser_Model->getusers();
            if(count($data) > 0){
                $this->res(1,$data,'Data found',0);
            }else{
                $this->res(0,null,'Data not found',0);
            }
        }
        public function register_post(){
            $cert = $_FILES['cert']['name'];
            $fac1 = $_FILES['fac1']['name'];
            $fac2 = $_FILES['fac2']['name'];
            $fac3 = $_FILES['fac3']['name'];
            $id = $this->post('user_id');
            $pic = $this->post('pic');
            $fname =$this->post('fname');
            $lname = $this->post('lname');
            $gender = $this->post('gender');
            $bday = $this->post('bday');
            $contact = $this->post('contact');
            $service = $this->post('service');
            $sitio = $this->post('st');
            $brgy = $this->post('brgy');
            
           move_uploaded_file($_FILES['cert']['tmp_name'],"cert/".$cert);
           move_uploaded_file($_FILES['fac1']['tmp_name'],"facility/".$fac1);
           move_uploaded_file($_FILES['fac2']['tmp_name'],"facility/".$fac2);
           move_uploaded_file($_FILES['fac3']['tmp_name'],"facility/".$fac3);
            $data = array(
                'user_id' => $id,
                'sFname' => $fname,
                'sLname' => $lname,
                'sBirthday' => $bday,
                's_gender' => $gender,
                'sContact' => $contact,
                'sSitio' => $sitio,
                'sBarangay' => $brgy,
                'sType' => $service,
                'sStatus' => 'Apply',
                'sRate' =>  0,
                'sub_id' => 0,
                'sPic' => $pic,
                'certification' => "cert/".$cert,
                'fac1' => "facility/".$fac1,
                'fac2' => "facility/".$fac2,
                'fac3' => "facility/".$fac3
            );
            $res = $this->ServiceUser_Model->insert($data);
            if($res){
                $this->res(1,null,"Successfully Register",0);
            }else{
                $this->res(0,null,"Error Register",0);
            }
        }

        public function getserviceuser_get($id){
            $data = $this->ServiceUser_Model->getprofile($id);
            if(count($data) > 0){
                $this->res(1,$data,"Data found",count($data));
            }else{
                $this->res(0,$data,"Data not found",0);
            }
        }

    }

?>