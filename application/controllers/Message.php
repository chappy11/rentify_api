<?php 
 include_once(dirname(__FILE__)."/Data_format.php");

 class Message extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("Message_Model"));
    }

    public function create_post(){
        $data = $this->decode();
        $sender_id = $data->sender_id;
        $reciever_id = $data->reciever_id;
        $message = $data->message;

        $payload = array(
            "sender_id" => $sender_id,
            "reciever_id" => $reciever_id,
            "message" => $message
        );

        $resp = $this->Message_Model->createMessage($payload);
        if($resp){
            $this->res(1,null,"Successfully Send",0);
        }else{
            $this->res(0,null,"Error",0);
        }
    }

    public function recievers_get($sender_id){
        $data = $this->Message_Model->getRecieverList($sender_id);
        $newData = [];
        foreach($data as $item){
            $last = $this->Message_Model->getLastMessage($sender_id,$item->reciever_id)[0];
            $obj = (object) array_merge((array) $item, (array) $last);
            array_push($newData,$obj);
        }

        $this->res(1,$newData,"D",0);
    }

    public function convo_get($sender_id,$reciever_id){
        $data = $this->Message_Model->getMessage($sender_id,$reciever_id);
        $this->Message_Model->updateStatus($sender_id,$reciever_id);
        $this->res(1,$data,"GG",0);
    }
    
 }

?>