<?php 

include_once(dirname(__FILE__)."/Data_format.php");
    class Transactions extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array('Transaction_Model'));
        }


        public function create_post(){
            $data = $this->decode();
            $refId = $this->generateRefId();
            $customerId = $data->customerId;
            $vehicleId = $data->vehicleId;
            $bookdate = $data->bookdate;
            $pickuptime = $data->pickuptime;
            $status = 'PENDING';
            $origin = $data->origin;
            $destination = $data->destination;

            $payload = array(
                'ref_id' => $refId,
                'customer_id' => $customerId,
                'vehicle_id' => $vehicleId,
                'book_date' => $bookdate,
                'pickup_time' => $pickuptime,
                'status' => $status,
                'origin' => $origin,
                'destination' => $destination
            );

            $resp = $this->Transaction_Model->create($payload);

            if($resp){
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

    
    }

?>