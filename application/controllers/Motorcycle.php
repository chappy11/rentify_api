<?php 
    include_once(dirname(__FILE__)."/Data_format.php");
    

    class Motorcycle extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Motorcycle_Model"));
        }

        public function insert_post(){
            $data = $this->decode();
            $name = isset($data->name) ? $data->name : '';
            $brand = isset($data->brand) ? $data->brand : "";
            $trans = isset($data->transmission) ? $data->transmission :"";
            $arr = array(
                   "name"=> $name,
                   'brand' => $brand,
                    "transmission" => $trans
                );
            $res = $this->Motorcycle_Model->addMotor($arr);
            if($res){
                $this->res(1,null,"Successfully Added",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

        public function getlist_get(){
            $data = $this->Motorcycle_Model->getlist();
            if(count($data ) > 0){
                $this->res(1,$data,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
    }

?>