<?php 

class History_Model extends CI_Model{

    private $table = "history";
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }


    public function insert($data=array()){
        return $this->db->insert($this->table,$data);
    }

    
    
}

?>