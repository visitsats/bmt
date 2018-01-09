<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends KM_Controller {

  function __construct(){
  	parent::__construct();
  
  } 
  
  public function index()
  {		
		if($this->input->post('submit')){
			$this->layout=false;
			//Form Validation
			$this->load->library("form_validation");			 
			$this->form_validation->set_rules('email',"User name", 'trim|required|max_length[60]');
			$this->form_validation->set_rules('password', "Password", 'trim|required|max_length[20]');
			if($this->form_validation->run() == TRUE){			
				$this->load->model("api/users_model");
				$userdata=$this->users_model->KM_first(array("class"=>"retailer","fields"=>array('retid','retname','username','email','lastLogin'),"conditions"=>array("username"=>$this->input->post('email'),"pwd"=>md5($this->input->post('password'))))); 
				if(!empty($userdata)){
					$this->session->set_userdata("admin",$userdata);
					redirect('admin/dashboard');
				}else
                {
				 $this->session->set_flashdata('message1','Invalid Credentials');
				 redirect('admin/home');
				}				
			}			
		} 
		
		$this->title='Shop Guard';
		$this->layout='admin_login';
		$this->load->view('admin/login/login');
		 	
 	} 
	
	
	public function forgotPassword()
	{
		
		if($this->input->post('submit')){
			$this->layout=false;
			//Form Validation
			
			$this->load->library("form_validation");			 
			$this->form_validation->set_rules('email',"Email", 'trim|required|valid_email|max_length[60]');			
			if($this->form_validation->run() == TRUE){
				 $this->load->model("api/users_model");
				 $email=$this->input->post('email');
				 $userdata=$this->users_model->KM_first(array("class"=>"retailer","fields"=>array('retid','retname','username','email','pwd'),"conditions"=>array("email"=>$email)));
				 if(!empty($userdata)){
				 	 $this->load->helper('string');	
					 $pwd=md5(random_string('alnum',8));		
					 $this->users_model->KM_update(array("class"=>"retailer","update"=>array("pwd"=>$pwd)),array('retid'=>$userdata['retid']));		 
				 	 $body="Your new password is : ".$pwd;					 
				 	$this->KM_send_email($email,$subject='Password',$body);
						
					 $this->session->set_flashdata('message','Password Sent');
					
				 }
				 else{
				 	$this->session->set_flashdata('message','Email not recognized!'); 
					redirect('admin/home/forgotPassword');
				 }
			}
			
		} 
		
		$this->title='Shop Guard';
		$this->layout='admin_login';
		$this->load->view('admin/login/forgot_password');
		 	
 	}
	
	
}
