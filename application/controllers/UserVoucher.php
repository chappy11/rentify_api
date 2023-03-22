<?php 
  include_once(dirname(__FILE__)."/Data_format.php");

  class UserVoucher extends Data_format{

    public function __construct(){
        parent::__construct();

        $this->load->model(array("UserVoucher_Model"));
    }

    public function create_post(){
        $data = $this->decode();

        $user_id = $data->user_id;
        $voucher_id = $data->voucher_id;

        $payload = array(
            "voucher_id" => $voucher_id,
            "user_id" => $user_id
        );

        $isInsert = $this->UserVoucher_Model->create($payload);
        if($isInsert){
            $this->res(1,null,"Successfully Added",0);
        }else{
            $this->res(0,null,"Something went wrong",0);
        }
    }

    public function myvouchers_post(){
        $data = $this->decode();
        $user_id = $data->user_id;
        $shops = $data->shops;
       
        $arr = array();
        foreach($shops as $value){
            $getShops = $this->UserVoucher_Model->getMyVoucherId($user_id,$value);
            $arr = array(...$arr,...$getShops);
        }
    
    
        $this->res(1,$arr,"data found",0);
    }
  }
?>