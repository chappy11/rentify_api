<?php 

    class OwnerDocument_Model extends CI_Model{
        private $tbl = "owner_documents";

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }


        public function create($payload){
            return $this->db->insert($this->tbl,$payload);
        }

    }
?>