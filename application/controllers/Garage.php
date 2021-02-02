<?php 
include_once(dirname(__FILE__)."/Data_format.php");

 class Garage extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array('Garage_Model',"Item_Model"));
    }

    //Create Garage
    public function addGarage_post(){
        $data = $this->decode();
        $acnt_id = isset($data->id) ? $data->id : "";
        $name = isset($data->name) ? $data->name : "";
        $description = isset($data->description) ? $data->description : "";
        $loc = isset($data->loc) ? $data->loc : "";
        $week = isset($data->week) ? $data->week : "";
        date_default_timezone_set('asia/manila');
        $no_weeks = strtotime('+'.$week." weeks");
        $sdate = date('Y-m-d');
        $edate = date('Y-m-d',$no_weeks);      
        $time = date("H:i");
        if(empty($name) || empty($description) || empty($week)){
            $this->res(0,null,"Fill out all fields");
        }else if(!$this->Item_Model->isAvailableItem($acnt_id)){
            $this->res(0,null,"You should have available item in Inventory");
        }else{
            $garage = array(
                "acnt_id" => $acnt_id,
                "garage_photo" => "http://localhost/tabogarahe/garages/garg.jpg",
                "garage_name" => $name,
                "garage_description" => $description,
                "date_start" => $sdate,
                "date_end" => $edate,
                "gtime" => $time,
                "status" => "active",
                "location" => $loc
            );
            $response = $this->Garage_Model->add($garage);
                if($response){
                    $this->res(1,null,"Successfully added");
                }else{
                    $this->res(0,null,"error login");
                }
        }
    }

    //View my own Garage
    public function mygarage_get($acnt_id){
        $garage = $this->Garage_Model->myGarage($acnt_id);
        if(count($garage) > 0){
            $this->res(1,$garage,"Data found");
        }else{
            $this->res(0,null,"No garage found");
        }
    }
    
    //change the piicture of garage
    public function chngepic_post(){
        $garage_photo = $_FILES['img']['name'];
        $garage_id = $this->post('id');
        $ext = pathinfo($garage_photo, PATHINFO_EXTENSION);

        if($this->all_ext($ext)){
            $this->res(0,null,"Your extension is invalid");
        }else{
            $move = move_uploaded_file($_FILES['img']['tmp_name'],"garages/".$garage_photo);
                if($move){
                    $garage = array("garage_photo"=>"http://localhost/tabogarahe/garages/".$garage_photo);
                    $response = $this->Garage_Model->update($garage_id,$garage);
                    $this->res(1,null,"Successfully Updated");
                }else{
                    $this->res(0,null,"Error");
                }
        }
        
    
    
    }

    //post all garage in so that the user can view it..
    public function postGarage_get(){
        $posts = $this->Garage_Model->garage();
        if(count($posts) > 0){
            $this->res(1,$posts,"data found");
        }else{
            $this->res(0,null,"data not found");
        }
    }
 }
?>