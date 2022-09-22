<?php 
 include_once(dirname(__FILE__)."/Data_format.php");

class Dashboard extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("User_Model","Product_Model","Customer_Model","Shop_Model"));
    }

    public function getadmin_get(){
        
        $noCustomer = count($this->Customer_Model->getAllCustomer());
        $noShops = count($this->Shop_Model->getAllShop());
        $noProducts = count($this->Product_Model->getAllProducts());
        $data = array(
            "customers"=>$noCustomer,
            "shops"=>$noShops,
            "product"=>$noProducts
        );

        $this->res(1,$data,"Data found",0);
        
    }
}

?>