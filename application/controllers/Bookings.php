<?php 

include_once(dirname(__FILE__)."/Data_format.php");
    class Bookings extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array('Bookings_Model','User_Model','Vehicle_Model','Drivers_Model'));
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
                'driver_id' => 0,
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

        public function getbookingbyid_get($booking_id){
            $data = $this->Booking_Model->getBookingById($booking_id);

            $this->res(1,$data,"Data",0);
        }

        public function getbookingbyrefid_get($refId){
            $data = $this->Bookings_Model->getBookingByRefId($refId)[0];

            $ownerData = $this->User_Model->getuser($data->owner_id)[0];
            $customerData = $this->User_Model->getuser($data->customer_id)[0];
            $vehicleData = $this->Vehicle_Model->getVehicleDataById($data->vehicle_id);
            $driverData = null;

            if($data->driver_id !== '0'){
                $driverData = $this->Drivers_Model->getDriverById($data->driver_id);
            }

            $response = array(
                "booking" => $data,
                "owner" => $ownerData,
                "customer" => $customerData,
                "vehicles" => $vehicleData,
                'driver' => $driverData
            );

            $this->res(1,$response,'Retrieve',0);
        }

    }

?>