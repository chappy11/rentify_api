<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class PetUpdate extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("PetUpdate_Model","Pet_Model","Notification_Model"));
        }

        public function request_post(){
            $data = $this->decode();
            $id = $data->id;
            $pet_id = $data->pet_id;
            $user_id = $data->user_id;
            $arr = array(
                "transac_id" => $id,
                "mediaType" => "",
                "media" => "",
                "isUpdate" => 0
            );
           
            $owner = $this->Pet_Model->getOwner($pet_id);
            $result = $this->PetUpdate_Model->insert($arr);
           
            if($result){
                $this->res(1,null,"Successfully Requested",0);
                $name = $owner[0]->firstname." ".$owner[0]->lastname;
                $body = $name." requested for update for ".$owner[0]->petname;
                $this->notification($user_id,$name,$body,"transaction",$id);
            }else{
                $this->res(0,null,"Error Requesting",0);
            }

        }

        public function update_post(){
            $id = $this->post("id");
            $type = $this->post("type");
            $media = $_FILES['media']['name'];
            $pet_id = $this->post("pet_id");
            
            $arr = array(
                "mediaType" => $type,
                "media" => "update/".$media,
                "isUpdate" => 1

            );
            $owner = $this->Pet_Model->getOwner($pet_id);
            
            $result = $this->PetUpdate_Model->update($id,$arr);
            $name = $owner[0]->firstname." ".$owner[0]->lastname;
            $body = "View ".$owner[0]->petname." has a new update";
            
            if($result){
                move_uploaded_file($_FILES['media']['tmp_name'],"update/".$media);
                $this->res(1,null,"Successfully Updated",0);
                $this->notification($owner[0]->user_id,$name,$body,"pet",$pet_id);
            }else{
                $this->res(0,null,"Error Updated",0);
            }
 
        
        }
  
        public function getUpdate_get($transac_id){
            $result = $this->PetUpdate_Model->getupdate($transac_id);
            if(count($result) > 0){
                $this->res(1,$result,"Data found",0);
            }else{
                $this->res(0,null,"Data not found",0);
            }
        }

        public function notification($id,$name,$body,$type,$target_id){
            $arr = array(
                "user_id" => $id,
                "notif_name" => $name,
                "notif_body" => $body,
                "notif_status" => 0,
                "notif_type" => $type,
                "target_id" => $target_id
            );
  
             $this->Notification_Model->createNotif($arr);
            
        }
  
  
    }

?>