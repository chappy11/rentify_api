<?php 

include_once(dirname(__FILE__)."/Data_format.php");
    class Brand extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Brand_Model"));
        }
    
        public function brands_get(){
            $data = $this->Brand_Model->getAllBrand();

            $this->res(1,$data,"Success",count($data));
        }

        public function createbrand_post(){
            $data = $this->decode();
            $brand = $data->brandName;

            $payload = array(
                "brand" => $brand
            );
            $isCreated = $this->Brand_Model->insert($payload);

            if($isCreated){
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }
    }

?>