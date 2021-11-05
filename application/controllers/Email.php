<?php 
    include_once(dirname(__FILE__)."/Data_format.php");

    class Email extends Data_format {

        public function __construct(){
            parent::__construct();
            $this->load->model(array("User_Model"));
        }
    
        public function sendEmail_post(){
            $data = $this->decode();
            $email = isset($data->email) ? $data->email : "";
            $code = isset($data->code) ? $data->code : "";
            $config['protocol']    = 'smtp';
            $config['smtp_host']    = 'smtp.mailtrap.io';
            $config['smtp_port']    = '2525';
            $config['smtp_user'] = '9d029ad9cac28d';
            $config['smtp_pass'] = 'bcf3804b878028';
            $config['charset']    = 'utf-8';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'html'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not      
            $this->load->library('email');

            $this->email->initialize($config);
            $this->email->from("happypet@gmail.com");
            $this->email->to($email);
            $this->email->subject("Email Verificatoin Code");
            $this->email->message($code);
        $count  = count($this->User_Model->isEmailExist($email));
      
        if(empty($email)){
            $this->res(0,null,"Fill out all Fields",0);
        }
        else if($count > 0){
            $this->res(0,null,"Email is already exist.. pls choose another email",0);
        }
        else if($this->isEmail($email)){
            $this->res(0,null,"Invalid Email",0);
        }
        else{
            $res = $this->email->send();
            if($res){
                $this->res(1,null,"We send verification code to your email",0);
            }else{
                $this->res(0,null,$this->email->print_debugger());
            }
        }
    }
}

?>