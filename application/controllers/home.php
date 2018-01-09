<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends KM_Controller {
  public function index()
	{ 
 		$this->title='Shop Guard';
		$this->layout=false;
		echo 'Access forbidden';		
 	} 
	public function mailsend()
	{
		$config = array(
							'protocol' => "mail",	
							'smtp_host' => 'mail.knowledgematrixinc.com',
							'smtp_port' => 587,
							'charset' => 'utf-8',
							'smtp_user' => 'pradeepp@knowledgematrixinc.com',
							'smtp_pass' => 'mac!roni_67',
							);
	
		$this->load->library('email',$config);
		$this->email->set_mailtype("html");	
		$this->email->set_newline("\r\n");
		
		$this->email->from('no-reply@bookmyt.com', 'BookMyT');
		$this->email->to('dayakarv@toyaja.com');

		$this->email->subject('Business Details ');
		$this->email->message('dfada sd ');
		$this->email->send();
		print_r($this->email->print_debugger());
		exit;
	}
}
