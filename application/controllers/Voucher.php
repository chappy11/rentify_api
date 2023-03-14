<?php 
 include_once(dirname(__FILE__)."/Data_format.php");

 class Voucher extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array('Voucher_Model'));
    }

    public function create_post(){
        $data = $this->decode();
        $shop_id = $data->shop_id;
        $percent = $data->percent;
        $voucher_limit = $data->voucherLimit;

        $payload = array(
            "shop_id" => $shop_id,
            "percent" => $percent,
            "voucherLimit" => $voucher_limit
        );

        $resp = $this->Voucher_Model->create($payload);

        if($resp){
            $this->res(1,null,"Successfully Added",0);
        }else{
            $this->res(0,null,"Error",0);
        }
    }

    public function shopvouchers_get($shop_id){
        $data = $this->Voucher_Model->getShopVoucher($shop_id);

        if(count($data) > 0){
            $this->res(1,$data,"Data found",count($data));
        }else{
            $this->res(0,null,"Data not found",0);
        }
    }
 }

?>