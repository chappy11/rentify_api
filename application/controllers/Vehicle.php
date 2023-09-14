<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class Vehicle extends Data_Format{

        public function __construct(){
            parent::__construct();
            $this->load->model;
        }
    
        public function create_post(){
            $orImage = $_FILES['or']['name'];
            $crImage = $_FILES['cr']['name'];
            $brand = $this->post('brand');
            $model = $this->post('model');
            $description = $this->post('description');
            $
        }
    
    }
?>