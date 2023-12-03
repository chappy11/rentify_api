<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Rating extends Data_format{
        
        public function __construct(){
            parent::__construct();
            $this->load->model(array("Rate_Model"));
        }


        public function create_post(){
            $data = $this->decode();

            $rate = $data->rate;
            $renter_id = $data->renter_id;
            $owner_id = $data->owner_id;
            $rateExist = $this->Rate_Model->getById($owner_id,$renter_id);

            if(count($rateExist) > 0){
                $updateRatePayload = array(
                    "rating" => $rate,
                ); 

                $isUpdate = $this->Rate_Model->updateRating($rateExist[0]->rating_id,$updateRatePayload);
            
                if($isUpdate){
                    $this->res(1,null,"Successfully Rate",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }else{
                $insertPayload = array(
                    "renter_id"=>$renter_id,
                    "owner_id"=>$owner_id,
                    "rating"=>$rate
                );
                $resp = $this->Rate_Model->create($insertPayload);
                if($resp){
                    $this->res(1,null,"Successfully Rate",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }

            
        }
    }
?>