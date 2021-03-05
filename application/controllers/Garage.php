<?php 
include_once(dirname(__FILE__)."/Data_format.php");

 class Garage extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array('Garage_Model',"Item_Model","Product_Model"));
    }

    //Create Garage
    public function addGarage_post(){
        $data = $this->decode();
        $acnt_id = isset($data->id) ? $data->id : "";
        $name = isset($data->name) ? $data->name : "";
        $description = isset($data->description) ? $data->description : "";
        $lng = isset($data->lng) ? $data->lng : "";
        $lat = isset($data->lat) ? $data->lat : "";
        $week = isset($data->week) ? $data->week : "";
      
        if(empty($name) || empty($description) || empty($week)){
            $this->res(0,null,"Fill out all fields",0);
        }else if(!$this->Item_Model->isAvailableItem($acnt_id)){
            $this->res(0,null,"You should have available item in Inventory",0);
        }else{
            $garage = array(
                "acnt_id" => $acnt_id,
                "garage_photo" => "garages/garg.jpg",
                "garage_name" => $name,
                "garage_description" => $description,
                "week" => $week,
                "garage_status" => "inactive",
                "lat" => $lat,
                "lng" => $lng
            );
            $response = $this->Garage_Model->add($garage);
                if($response){
                    $this->res(1,null,"Successfully added",0);
                }else{
                    $this->res(0,null,"error login",0);
                }
        }
    }

    //View my own Garage
    public function mygarage_get($acnt_id){
        $garage = $this->Garage_Model->myGarage($acnt_id);
        if(count($garage) > 0){
            $this->res(1,$garage,"Data found",count($garage));
        }else{
            $this->res(0,null,"No garage found",0);
        }
    }
    
    //change the piicture of garage
    public function chngepic_post(){
        $garage_photo = $_FILES['img']['name'];
        $garage_id = $this->post('id');
        $ext = pathinfo($garage_photo, PATHINFO_EXTENSION);

        if($this->all_ext($ext)){
            $this->res(0,null,"Your extension is invalid",0);
        }else{
            $move = move_uploaded_file($_FILES['img']['tmp_name'],"garages/".$garage_photo);
                if($move){
                    $garage = array("garage_photo"=>"http://localhost/tabogarahe/garages/".$garage_photo);
                    $response = $this->Garage_Model->update($garage_id,$garage);
                    $this->res(1,null,"Successfully Updated",0);
                }else{
                    $this->res(0,null,"Error",0);
                }
        }
        
    
    
    }

    //post all garage in so that the user can view it..
    public function postGarage_get(){
        $posts = $this->Garage_Model->garage();
        if(count($posts) > 0){
            $this->res(1,$posts,"data found",0);
        }else{
            $this->res(0,null,"data not found",0);
        }
    }

    public function getgarageid_get($garage_id){
        $data = $this->Garage_Model->getbyid($garage_id);
        $this->res(1,$data,"data found",count($data));
    }

    public function postgarage_post($garage_id,$week){
        $count_product = $this->Product_Model->viewProduct($garage_id);
        if(count($count_product)===0){
            $this->res(0,null,"Pls add product before activate garage",0);
        }else
        {
               date_default_timezone_set('asia/manila');
               $no_weeks = strtotime('+'.$week." weeks");
               $sdate = date('Y-m-d');
                $edate = date('Y-m-d',$no_weeks);      
                $time = date("H:i");
            $data = array(
                "date_start" => $sdate,
                "date_end" => $edate,
                "gtime" => $time,
                "garage_status" => "active"
            );
                $update = $this->Garage_Model->update($garage_id,$data);
                if($update){
                    $this->res(1,null,"Garage is now activated user's can buy now in your garage",0);
                }else{
                    $this->res(0,null,"Errror",0);
                }
        }
    
    }

    public function deactivategarage_post($garage_id){
        $data = array(
            "garage_status" => "inactive"
        );
        $update = $this->Garage_Model->update($garage_id,$data);
        if($update){
            $this->res(1,null,"successfully updated",0);
        }else{
            $this->res(0,null,"error",0);
        }
    }

    public function updategarage_post(){
        $data = $this->decode();
        $id = isset($data->id) ? $data->id : "";
        $name = isset($data->name) ? $data->name : "";
        $desc = isset($data->desc) ? $data->desc : "";
        $week = isset($data->week) ? $data->week : "";
        $lat = isset($data->lat) ? $data->lat : "";
        $lng = isset($data->lng) ? $data->lng : "";
        $garage = array(
            "garage_name" => $name,
            "garage_description" => $desc,
            "week" => $week,
            "lat" => $lat,
            "lng" => $lng
        );
        $res = $this->Garage_Model->update($id,$garage);
        if($res){
            $this->res(1,null,"Successfully Update",0);
        }else{
            $this->res(0,null,"Error",0);
        }
    }

    public function allgarage_get($id){
        $garages = $this->Garage_Model->garages($id);
        $this->res(1,$garages,"data found",count($garages));
    }

    public function garageuser_get($garage_id){
        $data = $this->Garage_Model->seller_garage($garage_id);
        $this->res(1,$data[0],"",0);
    }

    public function updategaragepic_post(){
        $file = $_FILES['pp']['name'];
        $id = $this->post('id');
        $ext = pathinfo($file, PATHINFO_EXTENSION);
       
        if(empty($file)){
            $this->res(0,null,"File is Empty");
        }
        else if($this->all_ext($ext)){
            $this->res(0,null,"Your file extension is not allowed, only jpg,png, and jpeg is allowed",0);
        }else{
            $profilepic = move_uploaded_file($_FILES['pp']['tmp_name'],"garages/".$file);
            $user = array("garage_photo" => "garages/".$file);
            $upload = $this->Garage_Model->update($user,$id);
            if($upload){
                $this->res(1,null,"successfully updated",0);
            }else{
                $this->res(0,null,"error",0);
            }
        }
    }
    public function updatepic_post(){
        $file = $_FILES['pp']['name'];
        $id = $this->post('id');
       $ext = pathinfo($file,PATHINFO_EXTENSION);
       if($this->all_ext($ext)){
           $this->res(0,null,"Your file extension is not allowed");
       }else{
           $garage_pic = move_uploaded_file($_FILES['pp']['tmp_name'],"garages/".$file);
           $data = array("garage_photo"=>"garages/".$file);
           $upload = $this->Garage_Model->update($id,$data);
           if($upload){
               $this->res(0,null,"Successfully updated",0);
           }else{
               $this->res(0,null,"Error",0);
           }
       }
    }
 }
     // date_default_timezone_set('asia/manila');
        // $no_weeks = strtotime('+'.$week." weeks");
        // $sdate = date('Y-m-d');
        // $edate = date('Y-m-d',$no_weeks);      
        // $time = date("H:i");
?>