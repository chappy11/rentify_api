<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require APPPATH.'libraries/REST_Controller.php';

    class Data_format extends Rest_Controller{
        
        
        public function __construct(){
            parent::__construct();

        }


        public function res($status,$data = array(),$mes,$count){
            if($status==1){
                $this->response(array(
                    "status" => $status,
                    "message" => $mes,
                    "data" => $data,
                    "count"=>$count
                ),200);
            }
            else if($status==0){
                $this->response(array(
                    "status" => $status,
                    "message" => $mes
                ),200);

            }
        
        }

  
        public function decode(){
            return json_decode(file_get_contents("php://input"));
        }
  
        public function isMobile($number){
            return !preg_match("/^[0-9]{3}[0-9]{4}[0-9]{4}$/", $number);
        }

        public function isEmail($email){
            return !filter_var($email, FILTER_VALIDATE_EMAIL);
        }
        
        public function containNumbers($string) {
            return preg_match('/[0-9]+/', $string) > 0;
        }
        
        public function all_ext($file_path){
            $allow = array("jpeg","png","jpg");
            if(!in_array($file_path,$allow)){
                return true;
            }else{
                return false;
            }
        }
    
    }

?>