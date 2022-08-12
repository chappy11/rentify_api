<?php
    include_once(dirname(__FILE__)."/Data_format.php");

    class Category extends Data_format{
        
        public function __construct(){
            parent::__construct();
            $this->load->model(array("Category_Model"));
        }

        public function createcategory_post(){
            $data = $this->decode();

            $isCreated = $this->Category_Model->createNewCategory($data);
            
            if($isCreated){
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

        public function getcategories_get(){
            $categoryList = $this->Category_Model->getAllCategory();

            if(count($categoryList) > 0){
                $this->res(1,$categoryList,"Data found",0);
            }else{
                $this->res(0,null,"No data found",0);
            }
        }
    }

?>