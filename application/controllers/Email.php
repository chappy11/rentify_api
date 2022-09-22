<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Email extends Data_format {

        public function __construct(){
            parent::__construct();
            $this->load->model(array("Customer_Model","Shop_Model","User_Model"));
        }
    
        public function sendEmail_post(){
            $data = $this->decode();
            $email = isset($data->email) ? $data->email : "";
            $username = isset($data->username) ? $data->username: "";
            $code = isset($data->code) ? $data->code : "";
            
            $config['protocol']    = 'smtp';
            $config['smtp_host']    = 'smtp.mailtrap.io';
            $config['smtp_port']    = '2525';
            $config['smtp_user'] = '6d5ff02ecee7f8';
            $config['smtp_pass'] = 'ca6a6441b64634';
            $config['charset']    = 'utf-8';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'html'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not      
            $this->load->library('email');

            $this->email->initialize($config);
            $this->email->from("no-reply@petsoceity.com");
            $this->email->to($email);
            $this->email->subject("Email Verificatoin Code");
            $this->email->message($code);

        $isCustomerEmailExist  = $this->Customer_Model->checkIsEmailExist($email);
        $isShopEmailExist = $this->Shop_Model->checkShopEmailExist($email);
        $isUsernameExist = $this->User_Model->checkUserNameExist($username);
        if($isUsernameExist){
            $this->res(0,null,"Username is already exist, Please choose another username",0);
        }
        else if($isCustomerEmailExist && $isShopEmailExist){
            $this->res(0,null,"Email is already Exist",0);
        }
        else if($this->isEmail($email)){
            $this->res(0,null,"Invalid Email",0);
        }
        else{
            $res = $this->email->send();
            if($res){
                $this->res(1,null,"We send verification code to your email",0);
            }else{
                $this->res(0,null,"Something went wrong",0);
            }
        }
    }

    public function emailVerification($send_to,$ver_code){
        // Email Sender order placed
        $to =  $send_to;  // User email pass here
        $subject = 'PetSociety | Code';
        $from = 'no-reply@jannrey.tech';              // Pass here your mail id
                  
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'smtp.hostinger.com'; // ssl://smtp.gmail.com //hostinger
        $config['smtp_port']    = '587'; //465 //587
        $config['smtp_timeout'] = '60';
    
        $config['smtp_user']    = 'no-reply@jannrey.tech';    //Important
        $config['smtp_pass']    = 'tzwvhA@4';  //Important
    
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not
    
        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message("Use this as your verification code: $ver_code");
        $this->email->send();
        // show_error($this->email->print_debugger());
        // Email Sender order placed
    
    }

}

?>