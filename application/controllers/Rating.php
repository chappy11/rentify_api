<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Rating extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Rating_Model"));
        }

        public function getRating_get($user_id){
            $result = $this->Rating_Model->getRating($user_id);
            $count = 0;
            foreach ($result as $value) {
                $count = $count + $value->rate_count;
            }
            
            $total = ceil($count / count($result));
            $this->res(1,$total,"Data count",0);
            
        } 
    }

?>