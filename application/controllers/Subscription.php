<?php 
    include_once(dirname(__FILE__)."/Data_format.php");


    class Subscription extends Data_format {


        public function __construct(){
            parent::__construct();
            $this->load->model(array("Subscription_Model"));
        }

        public function createSub_post(){
            $data = $this->decode();
            $name = isset($data->name) ? $data->name : "";
            $month = isset($data->month) ? $data->month : "";
            $amount = isset($data->amount) ? $data->amount : "";
            
            $array = array(
                "sub_name" => $name,
                "sub_fee" => $amount,
                "sub_month" => $month
            );

            $result = $this->Subscription_Model->insert($array);
            if($result){
                $this->res(1,null,"Succefully Created",0);
            }else{
                $this->res(0,null,"Error",0);
            }
        }
        
        public function getsub_get(){
            $result = $this->Subscription_Model->getSub();
            if(count($result) > 0 ){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }
  
        public function update_post(){
            $data= $this->decode();
            $id = $data->id;
            $name = $data->name;
            $fee = $data->amount;
            $month = $data->month;

            $arr = array(
                "sub_name" => $name,
                "sub_fee" => $fee,
                "sub_month" => $month 
            );
            $result = $this->Subscription_Model->update($id,$arr);
            if($result){
                $this->res(1,null,"Successfully Updated",0);
                
            }else{
                $this->res(0,null,"Error Updated",0);
            }
        }

       
    }


?>