<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller Class
 * @Base Controller Class
 * @author Sanjib Kumar Jena
 */
 
class KM_controller extends CI_Controller{
   
   var $title='';
   
   var $scripts=array();
   
   var $css=array();
   
   var $configurations=array(); 
   
   var $session_admin=array();
   
   var $session_user=array();
   
   var $menus = array();
   
   var $current_menus = '';
   
/**
 * Constructor
 * Loding the helpers,libraries,etc.
 * @access public
 */ 
	public function __construct()
	{
		parent::__construct(); 
		 
	}
/**
 * Check Login status of the User
 *
 * @access public
 */	   
 
/**
 * Email send functionallity 
 *  Author : Sanjib
 * @access public
 */	   
	public function KM_send_email($type=null,$to=array(),$variables=array(),$global=0){
	       $this->load->model('EmailTemplateModel');
		   $this->load->library('email');
		   $smtp_settings=$this->EmailTemplateModel->get_smtp_settings($global);
		   $template=$this->EmailTemplateModel->get_emailtemplate($type,$global); 
		   $body=$template['email_description'];
		   $subject=$template['email_subject'];
		   if($this->configurations['client_logo']!=''){
		      $logo_path = str_replace("{client_code}",$this->configurations['client_given_code'], CLIENT_LOGO_PATH);
		      $variables['##logo_path##']=base_url($logo_path.'/'.$this->configurations['client_logo']);
		   }else{
		     $variables['##logo_path##']=base_url('assets/frontend/logo.png');
		   }
		   foreach($variables as $key=>$variable){
		     $body=str_replace($key,$variable,$body);
			 $subject=str_replace($key,$variable,$subject);
		   } 
		    $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
			$config['mailtype']='html';
			
		   if($smtp_settings['smtp_server_host']!=''){
		      $config['protocol'] = 'smtp';
              $config['smtp_host'] = $smtp_settings['smtp_server_host'];
			  $config['smtp_user'] = $smtp_settings['smtp_user_name'];
			  $config['smtp_pass'] = $smtp_settings['smtp_password'];
		      $config['smtp_port'] = $smtp_settings['smtp_port'];
		   }
		   
		   else{
		      $config['protocol'] = 'mail';             
		   }
		    $this->email->clear(TRUE);
		    $this->email->initialize($config);
			$this->email->set_newline("\r\n");
		    //$this->email->from($template['from_email']);
			$this->email->from('no-reply@kmcws.com','Evexia');
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($body);
			$this->email->send(); 
	}
	

	 
}	
	
			 
