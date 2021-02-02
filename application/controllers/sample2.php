<?php 
include_once (dirname(__FILE__) ."/Data_format.php");

class Item extends Data_format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array("Item_Model"));
    }

    //add Item to validate
    public function addItem_post(){
      
        $img1 = $_FILES['img1']['name'];
        $img2 = $_FILES['img2']['name'];
        $img3 = $_FILES['img3']['name'];
        $name = $this->post('name');
        $desc = $this->post('description');
        $cat = $this->post('category');
        $iop = $this->post('price');
        $quantity = $this->post('quantity');
        $unit = $this->post('unit');      
        $status = "validate";
        $date = date('Y-m-d');
        $acnt = $this->post('acnt_id');
        if(empty($img1) || empty($img2) || empty($img3)){
            $this->res(0,null,"pls complete the 3 photos ");
        }
        else if(empty($name) || empty($desc) || empty($cat) || empty($iop) || empty($quantity) || empty($unit)){
            $this->res(0,null,"Fill out all fields");
        }
        else{
            $move1 = move_uploaded_file($_FILES['img1']['tmp_name'],"items/".$img1);
            $move2 = move_uploaded_file($_FILES['img2']['tmp_name'],"items/".$img2);
            $move3 = move_uploaded_file($_FILES['img3']['tmp_name'],"items/".$img3);
            if($move1 || $move2 ||  $move){
                $item = array(
                    "acnt_id" => $acnt,
                    "item_pic1" => "http://localhost/tabogarahe/items/".$img1,
                    "item_pic2" => "http://localhost/tabogarahe/items/".$img2,
                    "item_pic3" => "http://localhost/tabogarahe/items/".$img3,
                    "item_name" => $name,
                    "item_description" => $desc,
                    "item_catergory" => $cat,
                    "item_orig_price" => $iop,
                    "item_quantity" => $quantity,
                    "item_unit" => $unit,
                    "item_status" => $status,
                    "date_added" => $date
                );

    
                $res = $this->Item_Model->addItem($item);
                    if($res){
                        $this->res(1,null,"successfully added");
                    }else{
                        $this->res(0,null,"error");
                    }
            }
            else{
                $this->res(0,null,"error");
            }
          
        }
    }

    //get all item 
    public function itemList_get(){    
        $row = $this->Item_Model->itemList();
        if(count($row) > 0){
            $this->res(1,$row,"data found");
        }else{
            $this->res(0,null,"data not found");
        }

    }

    //view the item in user inventory     
    public function useritem_get($id){
        $data = $this->Item_Model->useritem($id,"inventory");
        if(count($data) > 0){
            $this->res(1,$data,"data found");
        }else{
            $this->res(0,null,"data not found");
        }
    }
    //update item details
    public function update_post(){
        $data = $this->decode();
        $name = isset($data->name) ? $data->name : "";
        $desc = isset($data->desc) ? $data->desc : "";
        $category = isset($data->category) ? $data->category : "";
        $id = isset($data->item_id) ? $data->item_id : "";
        $item = array(
            "item_name" => $name,
            "item_description" => $desc,
            "item_catergory" => $category
        );
        $res = $this->Item_Model->updateItem($id,$item);
        if($res){
            $this->res(1,null,"successfully updated");
        }else{
            $this->res(1,null,"error");
        }
    
    }

    //view all item to validated for admin
    public function allitem_get(){
        $data = $this->Item_Model->allitem();
        if(count($data) > 0){
            $this->res(1,$data,"data found");
        }
        else{
            $this->res(0,null,"data not found");
        }
    }
    
    //add item in to inventory , already validated by the admin
    public function toInventory_post($id){
        $item = array(
            "item_status" => "inventory" 
        );

        $res = $this->Item_Model->updateItem($id,$item);
        if($res){
            $this->res(1,null,"successfully updated");
        }else{
            $this->res(0,null,"error");
        }
    }

    //get item with specific id
    public function id_get($item_id){
            $data = $this->Item_Model->itemId($item_id);
            if(count($data)){
                $this->res('1',$data,'data found');
            }else{
                $this->res('1',null,"data not found");
            }
            
    }

    

    


}

?>