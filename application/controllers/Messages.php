<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Messages extends Data_format{

        public function __construct(){
            parent::__construct();

            $this->load->model(array("Message_Model","Drivers_Model","User_Model"));
        }

        public function send_post(){
            $data = $this->decode();
        
        
            $isSent = $this->Message_Model->create($data);

            if($isSent){
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

        public function messages_get($convoId){
            $data = $this->Message_Model->getByConvoIdAsc($convoId);
            $responseContainer = array();
            foreach ($data as $value) {
                $senderData = array();
              
                if($value->sender_type == 'DRIVER'){
                    $senderData = $this->Drivers_Model->getDriverById($value->sender);
                }else{
                    $senderData = $this->User_Model->getUserById($value->sender);
                }

                $arr = array(
                    "senderData" => $senderData,
                    "message" => $value
                );

                array_push($responseContainer,$arr);
            }
            
            $this->res(1,$responseContainer,'gg',count($responseContainer));
        }
    }
?>