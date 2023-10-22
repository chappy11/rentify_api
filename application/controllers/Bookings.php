<?php 

include_once(dirname(__FILE__)."/Data_format.php");
    class Bookings extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array('Bookings_Model'));
        }


        public function create_post(){
            $data = $this->decode();
            $refId = $this->generateRefId();
            $customerId = $data->customerId;
            $distance = $data->distance;
            $amount = $data->amount;
            $vehicleId = $data->vehicleId;
            $bookdate = $data->bookdate;
            $pickuptime = $data->time;
            $status = 'PENDING';
            $origin = $data->origin;
            $owner_id = $data->owner_id;
            $destination = $data->destination;

            $payload = array(
                'ref_id' => $refId,
                'customer_id' => $customerId,
                'vehicle_id' => $vehicleId,
                'distance' => $distance,
                'amount' => $amount,
                'book_date' => $bookdate,
                'pickup_time' => $pickuptime,
                'status' => $status,
                'origin' => $origin,
                'destination' => $destination,
                'owner_id' => $owner_id
            );

            $resp = $this->Bookings_Model->create($payload);

            if($resp){
                $this->res(1,null,"Successfully Created",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

  
        public function getbookingbystatus_get($user_id,$status){
            $data = $this->Bookings_Model->getBookingsByStatus($user_id,$status);

            $this->res(1,$data,'Data found',0);
        }
    }

?>