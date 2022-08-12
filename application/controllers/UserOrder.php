<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class UserOrder extends Data_format{

        public function __construct(){
            parent::__construct();
        }

        public function createorder_post(){
            $data = $this->decode();
            $itemList = $data->itemList;

            $this->res(1,$itemList,"Data found",0);

        }
    }
?>