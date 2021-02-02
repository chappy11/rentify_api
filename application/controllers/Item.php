<?php 

include_once(dirname(__FILE__)."/Data_format.php");

 class Item extends Data_Format{

    public function __construct(){
        parent::__construct();
        $this->load->model(array('Item_Model'));
    }
    

    //Add item to accepted
    public function addItem_post(){
        
        $id = $this->post('id');
        $img1 = $_FILES['img1']['name'];
        $img2 = $_FILES['img2']['name'];
        $img3 = $_FILES['img3']['name'];
        $name = $this->post('name');
        $desc = $this->post('desc');
        $category = $this->post('category');
        $orig_price = $this->post('orig_price');
        $quantity = $this->post('quantity');
        $unit = $this->post('unit');
        $status = "validate";
        $date = date('Y-m-d');
        $ext1 =  $this->extension($img1);
        $ext2 = $this->extension($img2);
        $ext3 = $this->extension($img3);

        if($this->all_ext($ext1) || $this->all_ext($ext2) || $this->all_ext($ext3)){
            $this->res(0,null, "Your file extension is not valid",0);
        }
        else if(empty($name) || empty($desc) || empty($orig_price) || empty($quantity)){
            $this->res(0,null,"Fill out all Fields",0);
        }
        else if(empty($category)){
            $this->res(0,null,"pls choose category",0);
        }
        else if(empty($unit)){
            $this->res(0,null,"pls choose unit",0);
        }
        else{
                         
            $move1 = move_uploaded_file($_FILES['img1']['tmp_name'],"items/".$img1);
            $move2 = move_uploaded_file($_FILES['img2']['tmp_name'],"items/".$img2);
            $move3 = move_uploaded_file($_FILES['img3']['tmp_name'],"items/".$img3);
            if($move1 && $move2 && $move3){
                $item = array(
                    "acnt_id" => $id,
                    "item_pic1" => "http://localhost/tabogarahe/items/".$img1,
                    "item_pic2" => "http://localhost/tabogarahe/items/".$img2,
                    "item_pic3" => "http://localhost/tabogarahe/items/".$img3,
                    "item_name" => $name,
                    "item_description" => $desc,
                    "item_category" => $category,
                    "item_orig_price" => $orig_price,
                    "item_quantity" => $quantity,
                    "item_unit" => $unit,
                    "item_status" => $status,
                    "date_added" => $date, 
                    "availability" => "available"
                );
             $res =  $this->Item_Model->addItem($item);
                if($res){
                    $this->res(1,null,"successfully added,Pls wait for admin Acceptance",0);
                }else{
                    $this->res(0,null,"Server error",0);
                }
            }else{
                $this->res(0,null,"your file didn't save",0);
            }
        } 
    }
    
    //get path of image
    public function extension($file){
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    //view item that on validate
    public function toValidated_get(){
        $data = $this->Item_Model->toValidated();
        if(count($data) > 0){
            $this->res(1,$data,"data found",count($data));
        }else{
            $this->res(0,null,"no data found",0);
        }
    }
    
    //user's view its own garage
    public function myItem_get($acnt_id){
        $data = $this->Item_Model->myItem($acnt_id);
        if(count($data) > 0){
            $this->res(1,$data,"data found",count($data));
        }else{
            $this->res(0,null,'data not found',0);
        }
    }

    //accept item on inventory
    public function updateStatus_post($item_id,$status){
        $item = array(
            "item_status" => $status
        );
       
        $response = $this->Item_Model->update($item_id,$item);
        if($response){
              $this->res(1,null,"succesfully added",0);
        }else{
            $this->res(0,null,"error",0);
        }    
    }

    //update item some of details
    public function updateItem_post(){
        $data = $this->decode();
        $id = isset($data->id) ? $data->id : "";
        $name = isset($data->name) ? $data->name : "";
        $desc = isset($data->desc) ? $data->desc : "";
        $category = isset($data->category) ? $data->category : "";
        $orig_price = isset($data->orig_price) ? $data->orig_price : "";
        $quantity = isset($data->quantity) ? $data->quantity : "";
        $unit = isset($data->unit) ? $data->unit : "";
            
            $res = $this->Item_Model->getItem($id);
            $pic1 = $res[0]->item_pic1;
            $pic2 = $res[0]->item_pic2;
            $pic3 = $res[0]->item_pic3;
            $oname = $res[0]->item_name;
            $odesc = $res[0]->item_description;
            $ocategory = $res[0]->item_category;
            $oorig = $res[0]->item_orig_price;
            $oquantity = $res[0]->item_quantity;
            $ounit = $res[0]->item_unit;

                if(empty($name)){
                    $name = $oname;
                }
                if(empty($desc)){
                    $desc = $odesc;
                }
                if(empty($category)){
                    $category = $ocategory;
                }
                if(empty($orig_price)){
                    $orig_price = $oorig;
                }
                if(empty($quantity)){
                    $quantity = $oquantity;
                }
                if(empty($unit)){
                    $unit = $ounit;
                }
            $item = array(
                "item_pic1" => $pic1,
                "item_pic2" => $pic2,
                "item_pic3" => $pic3,
                "item_name" => $name,
                "item_description" => $desc,
                "item_category" => $category,
                "item_orig_price" => $orig_price,
                "item_quantity" => $quantity,
                "item_unit" => $unit
            );
            $response = $this->Item_Model->update($id,$item);
                if($response){
                    $this->res(1,$item,"Successfully Updated",0);
                }else{
                    $this->res(0,null,"Error in updating data",0);
                }
    }
    
    //get item with id
    public function getItem_get($id){
        $res = $this->Item_Model->getItem($id);
            if(count($res) > 0){
                $this->res(1,$res,"Data found",count($res));   
            }else{
                $this->res(0,null,"Data not found",0);
            }
    }
   
}
?>