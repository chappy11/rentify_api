<?php
    include_once(dirname(__FILE__)."/Data_format.php");

    class Advertis extends Data_format{


        public function __construct(){
            parent::__construct();
            $this->load->model(array("Post_Model"));
        }

        public function createpost_post(){
            $id = $this->post("id");
            $type = $this->post("type");
            $media = $_FILES['media']['name'];
            $desc = $this->post("desc");
            
           
            $data = array(
                "service_id" => $id,
                "mediaType" => $type,
                "media" => "post/".$media,
                "post_description" => $desc 
            );
           
                $result = $this->Post_Model->createPost($data);
            if($result){
                $this->res(1,null,"Posted Successfully",0);
                move_uploaded_file($_FILES['media']['tmp_name'],"post/".$media);
            }else{
                $this->res(0,null,"Unsuccessfully Save",0);
            }
         }

         public function getposts_get(){
             $data = $this->Post_Model->allpost();
             if(count($data) > 0){
                 $this->res(1,$data,"Data found",0);
             }else{
                 $this->res(0,null,"Data not found",0);
             }
         }
    }
?>