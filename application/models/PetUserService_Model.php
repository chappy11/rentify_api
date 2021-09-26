<?php 

    include_once(dirname(__FILE__)."/Data_format.php");

    class PetUserService_Model extends CI_Model{
       
      

        public function __construct(){
            parent::__construct();
            $this->load->database(); 
        }

        public function registertrainer($data){
            return $this->db->insert("petuserservice",$data);
        }
    }

?>