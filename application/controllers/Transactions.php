<?php 
include_once(dirname(__FILE__)."/Data_format.php");

    class Transactions extends Data_format{


        public function __construct(){
            parent::__construct();

            $this->load->model(array("Transactions_Model"));
        }

        public function create_post(){
            $data = $this->decode();

            $customer_id = $data->customerId;
            $vehicle_id = $data->vehicleId;
            $booking_id = $data->bookingId;
            $driverId = $data->driverId;
        
        
            $payload = array(
                "driver_id" => $driverId,
                "user_id" => $customer_id,
                "booking_id" => $booking_id,
                "transaction_status" => "PENDING",
            );
        }
    }

?>