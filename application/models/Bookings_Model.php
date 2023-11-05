<?php 
    class Bookings_Model extends CI_Model{
        private $tbl_name = 'bookings';
        
        public function __construct(){
            parent::__construct();

            $this->load->database();
        }

        public function create($payload){
            return $this->db->insert($this->tbl_name,$payload);
        }

        public function getTransactionById($refId){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->where('ref_id',$refId);
            $query = $this->db->get();
            return $query->result();
        }

        public function getBookingsByStatus($user_id,$status){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where('owner_id',$user_id);
            $this->db->where('status',$status);
            $this->db->join('vehicles','vehicles.vehicle_id=bookings.vehicle_id','LEFT');
            $this->db->join('users','users.user_id=bookings.customer_id','LEFT');
            $query = $this->db->get();
            return $query->result();
        }

        public function getBookingById($bookingId){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where('booking_id',$bookingId);
            $this->db->join('vehicles','vehicles.vehicle_id=bookings.vehicle_id','LEFT');
            $this->db->join('users','users.user_id=bookings.customer_id','LEFT');
            $query = $this->db->get();
            return $query->result();
        }

        public function getBookingByRefId($refId){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where('ref_id',$refId);
            $query = $this->db->get();
            return $query->result();
        }

        public function updateData($refId,$data){
            $this->db->where('ref_id', $refId);
            return $this->db->update('bookings', $data);
        }

        public function checkifdriver($driverId,$date){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where('driver_id',$driverId);
            $this->db->where('book_date',$date);
            $query = $this->db->get();
            return $query->result();
        }

        public function getBookingByDriver($driverId){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where('bookings.driver_id',$driverId);
            $this->db->join('vehicles','vehicles.vehicle_id=bookings.vehicle_id','LEFT');
            $this->db->join('users','users.user_id=bookings.customer_id','LEFT');
            $query = $this->db->get();
            return $query->result();
        }

        public function getbookingbyuserid($userId){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where('bookings.customer_id',$userId);
            $this->db->join('vehicles','vehicles.vehicle_id=bookings.vehicle_id','LEFT');
            $this->db->join('users','users.user_id=bookings.owner_id','LEFT');
            $query = $this->db->get();
            return $query->result();
        }

        public function getTransactionsByOwner($user_id){
            $this->db->select("*");
            $this->db->from($this->tbl_name);
            $this->db->where('owner_id',$user_id);
            $this->db->where('status!=','PENDING');
            $this->db->join('vehicles','vehicles.vehicle_id=bookings.vehicle_id','LEFT');
            $this->db->join('users','users.user_id=bookings.customer_id','LEFT');
            $query = $this->db->get();
            return $query->result();
        }

    }
?>