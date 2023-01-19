<?php 

    class Message_Connection_Model extends CI_Model{

        private $table = 'message_connection';
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create(){
         
        }

    }

?>