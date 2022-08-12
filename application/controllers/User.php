<?php

    include_once(dirname(__FILE__)."/Data_format.php");

    class User extends Data_format{

        public function __construct(){
            parent::__construct();
            $this->load->model(array("User_Model","Customer_Model","Shop_Model"));
        }
        //note:
        //user role:
        //0 admin
        //1 seller
        //2 customer
        
        
        //create account for customer
        public function signupcustomer_post(){
            $profile_picture =  $_FILES["profilePicture"]["name"];
            $username = $this->post("username");
            $password = $this->post("password");
            $firstname = $this->post("firstname");
            $middleInitial = $this->post("mi");
            $lastname = $this->post("lastname");
            $gender = $this->post("gender");
            $birthdate = $this->post("birthdate");
            $address = $this->post("address");
            $email = $this->post("email");
            $contact = $this->post("contact");

            $userData = array(
                "username" => $username,
                "password" => $password,
                "user_roles" => 2, //customer
                "user_status" => 0, //status is active
            );

            $isCreated = $this->User_Model->createUser($userData);
            
            if(!$isCreated){
              $this->res(0,null,"Something went wrong",0);
            }else{
               
                $newUser = $this->User_Model->getNewUser(); //get latest user
          
                try{
                 
                    $newCustomer = array(
                        "user_id" => $newUser[0]->user_id,
                        "email" => $email,
                        "contact" => $contact,
                        "firstname" => $firstname,
                        "lastname" => $lastname,
                        "middlename" => $middleInitial,
                        "gender" => $gender,
                        "birthdate" => $birthdate,
                        "addresss" => $address,
                        "profilePic" => "profiles/".$profile_picture
                    );
        
                    $createCustomer = $this->Customer_Model->createCustomer($newCustomer);
                
                    if($createCustomer){
                        $this->res(1,null,"You Have Successfully Registered",0);
                        move_uploaded_file($_FILES['profilePicture']['tmp_name'],"profiles/".$profile_picture);
                    }else{
                        $this->res(0,null,"Something went wrong",0);
                    }
                    
                  
                } 
                catch(Exception $e){
                    $this->User_Model->deleteUser($newUser[0]->user_id);
                    $this->res(0,null,"Something went wrong",0);
                }
            }

         
          
        }

        //create account for shop
        public function createshop_post(){
            $shop_logo = $_FILES['shopLogo']['name'];
            $username = $this->post("username");
            $password = $this->post("password");
            $shop_email = $this->post("shopEmail");
            $shop_name = $this->post("shopName");
            $shop_description = $this->post("shopDescription");
            $firstname = $this->post("firstname");
            $middlename = $this->post("middlename");
            $lastname = $this->post("lastname");
            $address = $this->post("address");
            $shopContact = $this->post("contact");
    
            $userData = array(
                "username" => $username,
                "password" => $password,
                "user_roles" => 1,
                "user_status" => 0, 
            );

            $isCreated = $this->User_Model->createUser($userData);

            if(!$isCreated){
                $this->res(0,null,"Something went wrong",0);
            }else{
                $newUserData = $this->User_Model->getNewUser();

                try{
                    $newShop = array(
                        "user_id" => $newUserData[0]->user_id,
                        "logo" => "shops/".$shop_logo,
                        "shopName" => $shop_name,
                        "shopEmail" => $shop_email,
                        "shopDescription" => $shop_description,
                        "ownerFirstname" => $firstname,
                        "ownerMiddlename" => $middlename,
                        "ownerLastname" => $lastname,
                        "shopAddress" => $address,
                        "subscription_id" => 0,
                        "shopContact" => $shopContact
                    );
    
                    $isShopCreated = $this->Shop_Model->createShop($newShop);
    
                    if(!$isShopCreated){
                        $this->res(0,null,"Something went wrong, Sorry for Inconvinience",0);
                    }
    
                    $this->res(1,null,$shop_name." is successfully created!",0);
                    move_uploaded_file($_FILES['shopLogo']['tmp_name'],"shops/".$shop_logo);
           
                }catch(Exception $e){
                    $this->User_Model->deleteUser($newUserData[0]->user_id);
                    $this->res(0,null,"Something went wrong",0);
                }
            }

      
        }
        
        //login
        public function login_post(){
            $data = $this->decode();
            $username = isset($data->username) ? $data->username : "";
            $password = isset($data->password) ? $data->password : "";

          

                $user = $this->User_Model->login($username,$password);

                if(count($user) < 1){
                    $this->res(0,null,"Invalid account please check your username or password",0);
                }else{
                  
                    if($user[0]->user_status === "0"){
                        $this->res(0,null,"Your Account is Inactive",0);
                    }
                    else if($user[0]->user_roles == 1){
                        $shopData = $this->Shop_Model->getShopByUserId($user[0]->user_id);
                    
                        $this->res(1,$shopData,"Successfully Login",0);
                    }
                    else if($user[0]->user_roles == 2){
                        $customerData = $this->Customer_Model->getCustomerByUserId($user[0]->user_id);
    
                        $this->res(1,$customerData,"Successfully Login",0);
                    }
                }              
        }
    }

?>