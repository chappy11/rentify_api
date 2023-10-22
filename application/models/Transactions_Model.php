<?php 

    class Transactions_Model extends CI_Model{

        private $tbl_name = 'transactions';

        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->tbl_name,$payload);
        }


        public function getTransactionByDriverId($driverId){
            $this->db->select("*");
            $this->db->from($this->tble_name);
            $this->db->where('transactions.driver_id',$driverId);
            $this->db->join('bookings','bookings.booking_id=transactions.booking_id');
            $this->db->join('vehicles','vehicles.vehicle_id=bookings.vehicle_id');
            $this->db->join('user','users.user_id=bookings.customer_id');
            $query = $this->db->get();
            return $query->result();
        }
    }

?>