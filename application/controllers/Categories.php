<?php 
include_once(dirname(__FILE__)."/Data_format.php");


    class Categories extends Data_format{

        public function __construct(){
            parent::__construct();

            $this->load->model(array('Categories_Model'));
        }

        public function sample_get(){
            $this->res(1,"GGG","test",0);
        } 
        public function create_post(){
            $data = $this->decode();

            $type = $data->type;
            $min = $data->min;
            $max = $data->max;
            $desc = $data->desc;

            $payload = array(
                "vehicleType" => $type,
                "min" => $min,
                "max" => $max,
                "typeDescription" => $desc
            );

            $isInserted = $this->Categories_Model->create($payload);

            if($isInserted){
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Someting went wrong",0);
            }
        }


        public function categories_get(){
            $data = $this->Categories_Model->getCategories();

            $this->res(1,$data,"Success fetch",count($data));
        }
    }
?>