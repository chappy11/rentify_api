 <?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Convo extends Data_format{

            public function __construct(){
                parent::__construct();
                $this->load->model(array('Convo_Model','Message_Model',"User_Model","Drivers_Model"));
            }
        
            public function convos_get($id,$type){
                $queryArr = array();
                switch ($type) {
                    case 'OWNER':
                        $queryArr = array(
                            "owner_id" => $id
                        );
                        break;
                    case 'RENTER':
                        $queryArr = array(
                            "renter_id" => $id
                        );
                        break;
                    case 'DRIVER':
                        $queryArr = array(
                            "driver_id" => $id
                        );
                        break;
                    default:
                        $queryArr = array();
                        break;
                }

                $resp = $this->Convo_Model->getConvo($queryArr);
                $responseContainer = array();
                foreach ($resp as $value) {
                    $respData = array();
                    switch ($type) {
                        case 'OWNER':
                            $respData = array(
                                "owner" => null,
                                "renter" => $this->User_Model->getUserById($value->renter_id),
                                "driver" => null,
                                "message" => $value,
                                "lastMessage" => $this->Message_Model->getByConvoId($value->convo_id)[0]
                            );
                            break;
                        case 'RENTER':
                            $ownerData = $value->isDriver === '0' ? $this->User_Model->getUserById($value->owner_id) : null;
                            $driverData = $value->isDriver === '1' ? $this->Drivers_Model->getDriverById($value->driver_id) : null;
                            $respData = array(
                                "owner" => $ownerData,
                                "renter" => null,
                                "driver" => $driverData,
                                "message" => $value,
                                "lastMessage" => $this->Message_Model->getByConvoId($value->convo_id)[0]
                            );
                            break;
                        case 'DRIVER':
                            $respData = array(
                                "owner" => null,
                                "renter" => $this->User_Model->getUserById($value->renter_id),
                                "driver" => null,
                                "message" => $value,
                                "lastMessage" => $this->Message_Model->getByConvoId($value->convo_id)[0]
                            );
                            break;
                        default:
                            $queryArr = array();
                            break;
                    }
                    array_push($responseContainer,$respData);
                }

                $this->res(1,$responseContainer,'Successfully Fetch',0);

            }

            public function create_post(){
                $data = $this->decode();
                $owner_id = $data->owner_id ? $data->owner_id : 0;
                $renter_id = $data->renter_id ? $data->renter_id : 0;               
                $driver_id = $data->driver_id ? $data->driver_id : 0;
                $isDriver = $data->isDriver ? $data->isDriver : '';
                $message = $data->message ? $data->message : '';
                $sender_type = $data->sender_type ? $data->sender_type : "";
                $checkConvo = array();
                
                if($isDriver === '0'){
                    $checkConvo = array(
                        "renter_id" => $renter_id,
                        "owner_id" => $owner_id,
                    );
                }else{
                    $checkConvo = array(
                        "renter_id" => $renter_id,
                        "driver_id" => $driver_id,
                    );
                }

                $convo = $this->Convo_Model->getConvo($checkConvo);
            
                if(count($convo) > 0){
                    $senderId = '';
                    switch ($sender_type) {
                        case 'OWNER':
                            $senderId = $owner_id;
                            break;
                        case 'RENTER':
                            $senderId = $renter_id;
                            break;
                        default:
                            $senderId = $driver_id;
                            break;
                    }
                    $messagePayload = array(
                        "sender_type" => $sender_type,
                        "convo_id" => $convo[0]->convo_id,
                        "sender" => $senderId,
                        "message" => $message
                    );                  

                    $mpayload = $this->Message_Model->create($messagePayload);

                    if($mpayload){
                        $this->res(1,null,'Successfully Created',0);
                    }else{
                        $this->res(0,null,'Something went wrong',0);
                    }

                }else{
                    $newConvoPayload = array(
                        "owner_id" => $owner_id,
                        'renter_id' => $renter_id,
                        'driver_id' => $driver_id,
                        'isDriver' => $isDriver,  
                    );

                   $isNewConvoCreated = $this->Convo_Model->create($newConvoPayload);
                    
                    if($isNewConvoCreated){
                        $queryArr = array(
                            "owner_id" => $owner_id,
                            'renter_id' => $renter_id,
                            'driver_id' => $driver_id,
                        );
                        $thisConvo = $this->Convo_Model->getConvo($queryArr);
                        $sender_id = '';
                        switch ($sender_type) {
                            case 'OWNER':
                                $sender_id = $owner_id;
                                break;
                            case 'RENTER':
                                $sender_id = $renter_id;
                                break;
                            default:
                                $sender_id = $driver_id;
                                break;
                        }
                        $msgPayload = array(
                            "sender_type" => $sender_type,
                            "convo_id" => $thisConvo[0]->convo_id,
                            "sender" => $sender_id,
                            "message" => $message
                        );                  
    
                        $isNewMessage = $this->Message_Model->create($msgPayload);

                        if($isNewMessage){
                            $this->res(1,null,'Successfully Created',0);
                        }else{
                            $this->res(0,null,'Something went wrong',0);
                        }
                    }else{
                        $this->res(0,null,"Something went wrong",0);
                    }
                }
            
            }

    }
?>