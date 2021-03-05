 <?php 

class Item_Model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //add item
    public function addItem($item= array()){
        return $this->db->insert("item",$item);
    }

    //user's view its own item
    public function myItem($acnt_id){
        $this->db->select("*");
        $this->db->group_start();
        $this->db->where("item_status","toValidate");
        $this->db->or_where("item_status","validated");
        $this->db->group_end();
        $this->db->where('acnt_id',$acnt_id);
        $this->db->from('item');
        $query = $this->db->get();
        return $query->result();
    }

    //the admin view the item that on validated
    public function toValidated(){
        $this->db->select("*");
        $this->db->where('item_status',"toValidate");
        $this->db->from('item');
        $this->db->join('account','account.acnt_id = item.acnt_id');
        $query = $this->db->get();
        return $query->result();
    }

    //update items
    public function update($id,$item = array()){
      return $this->db->update('item',$item,'item_id='.$id);
    }

    //check if you have any item in inventory
    public function isAvailableItem($id){
        $this->db->select("*");
        $this->db->where('availability','available');
        $this->db->where('item_status',"validated");
        $this->db->from('item');
        $query = $this->db->get();
        $count = count($query->result());
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    //get item with id
    public function getItem($id){
        $this->db->select("*");
        $this->db->where('item_id',$id);
        $this->db->from('item');
        $query = $this->db->get();
        return $query->result();
    }
    //get validated items
    public function getValidated($id){
        $this->db->select("*");
        $this->db->where("acnt_id",$id);
        $this->db->where("item_status","validated");
        $this->db->from("item");
        $query = $this->db->get();
        return $query->result();
    }

    public function getall($acnt_id){
        $this->db->select("*");
        $this->db->where("acnt_id",$acnt_id);
        $this->db->from("item");
        $query = $this->db->get();
        return $query->result();
    }

}
?>