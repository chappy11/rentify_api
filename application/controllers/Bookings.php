<?php 

include_once(dirname(__FILE__)."/Data_format.php");
    class Bookings extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array('Bookings_Model','User_Model','Vehicle_Model','Drivers_Model','VehicleImage_Model',"Payment_Model"));
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
            $paymentMethod = $data->paymentMethod;
            $status = 'PENDING';
            $origin = $data->origin;
            $owner_id = $data->owner_id;
            $destination = $data->destination;
            $payment = '';

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
                'owner_id' => $owner_id,
                "paymentMethod" => $paymentMethod,
                "paymentCode" => $payment,
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
            $arr_container = [];
            foreach($data as $val){
                $vehicleImg = $this->VehicleImage_Model->getByNonce($val->vehicleImage);
                $imgPayload = array("images" => $vehicleImg);
                $pyload = (object)array_merge((array)$val,(array)$imgPayload);

                array_push($arr_container,$pyload);
            }

            $this->res(1,$arr_container,"Fetch",count($data));
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


        public function accept_post(){
            $data = $this->decode();
        
            $refId = $data->refId;
            $driverId  = $data->driver_id;
  
            $bookingData = $this->Bookings_Model->getBookingByRefId($refId)[0];

            $checkDriverBookingByDate = $this->Bookings_Model->checkifdriver($driverId,$bookingData->book_date);
           
            if(count($checkDriverBookingByDate) > 0){
                $this->res(0,null,"The driver is currenty no available on this book date",0);
            }else{
                $payload = array(
                    "driver_id" => $driverId,
                    "status" => "ACCEPTED"
                );
                $response = $this->Bookings_Model->updateData($refId,$payload);

                if($response){
                    $this->res(1,null,"Successfully Updated",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }
        }

        public function bookingbydriver_get($driverId){
            $data = $this->Bookings_Model->getBookingByDriver($driverId);
            $arr_container = [];
            foreach($data as $val){
                $vehicleImg = $this->VehicleImage_Model->getByNonce($val->vehicleImage);
                $imgPayload = array("images" => $vehicleImg);
                $pyload = (object)array_merge((array)$val,(array)$imgPayload);

                array_push($arr_container,$pyload);
            }

            $this->res(1,$arr_container,"Fetch",count($data));
        }
    
        public function updatestatus_post($refId,$status){
            $payload = array(
                "status" => $status
            );

            $response = $this->Bookings_Model->updateData($refId,$payload);

            if($response){
                $this->res(1,null,"Data Updated",0);
            }else{
                $this->res(0,null,"Data not updated",0);
            }
        }
  
        public function getbookingbycustomer_get($userId){
            $data = $this->Bookings_Model->getbookingbyuserid($userId);
            $arr_container = [];
            foreach($data as $val){
                $vehicleImg = $this->VehicleImage_Model->getByNonce($val->vehicleImage);
                $imgPayload = array("images" => $vehicleImg);
                $pyload = (object)array_merge((array)$val,(array)$imgPayload);

                array_push($arr_container,$pyload);
            }

            $this->res(1,$arr_container,"Fetch",count($data));
        }

        public function gettransactionbyowner_get($user_id){
            $data = $this->Bookings_Model->getTransactionsByOwner($user_id);
            $arr_container = [];
            foreach($data as $val){
                $vehicleImg = $this->VehicleImage_Model->getByNonce($val->vehicleImage);
                $imgPayload = array("images" => $vehicleImg);
                $pyload = (object)array_merge((array)$val,(array)$imgPayload);

                array_push($arr_container,$pyload);
            }

            $this->res(1,$arr_container,"Fetch",count($data));
        }
  
        public function addfee_post(){
            $data = $this->decode();
            $this->res(1,$data,"GG",0);
            $id = $data->ref_id;
            $amount = $data->amount;

            $payload = array(
                "additionalfee" => $amount
            );

            $resp = $this->Bookings_Model->updateData($id,$payload);

            if($resp){
                $this->res(1,null,"Successfully Added",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }

        public function pay_post(){
            $data = $this->decode();
            $refId = $data->refid;
            $owner_mobile = $data->oMobileNo;
            $customer_mobile = $data->cMobileNo;
            $amount = $data->amount;
            $fourdigit = random_int(1000,9999);
            $sixDigit = random_int(100000, 999999);
        
            $code = $fourdigit.'-'.$sixDigit;
            $payload = array(
                "code" => $code,
                "reciever" => $owner_mobile,
                "sender" => $customer_mobile,
                "amount" => $amount,
                "notes" => "Online Payment"
            );

            $isPaid = $this->Payment_Model->pay($payload);

            if($isPaid){
                $updatePayload = array(
                    "paymentCode" => $code
                );

                $isUpdate = $this->Bookings_Model->updateData($refId,$updatePayload);

                if($isUpdate){
                    $this->res(1,null,"Successfully Paid",0);
                }else{
                    $this->res(0,null,"Something went wrong",0);
                }
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }
    }

?>