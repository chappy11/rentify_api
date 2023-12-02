<?php 
include_once(dirname(__FILE__)."/Data_format.php");

class Drivers extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array('Convo_Model'));
        }
}
?>