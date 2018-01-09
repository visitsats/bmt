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
		date_default_timezone_set("Asia/Kolkata");
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
		header("Pragma: no-cache"); // HTTP 1.0.
		header("Expires: 0");  
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
	public function KM_send_email($to=array(),$subject='',$body=''){ 			
			
		    $this->load->library('email');
		    $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
			$config['mailtype']='html';
			
		   if(false){
		      $config['protocol'] = 'smtp';
              $config['smtp_host'] = "smtp.gmail.com";
			  $config['smtp_user'] = "raghu.sunkari9@gmail.com";
			  $config['smtp_pass'] = "9948626564";
		      $config['smtp_port'] = "587";
		   }
		   
		   else{
		      $config['protocol'] = 'mail';             
		   }
		    $this->email->clear(TRUE);
		    $this->email->initialize($config);
			$this->email->set_newline("\r\n");
		    //$this->email->from($template['from_email']);
			$this->email->from('no-reply@smartbuggy.com','Smart Buggy');
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($body);
			$this->email->send(); 
			return true;
	}
	
	public function __save_to_log($hwid,$uid=NULL,$qrc_id=NULL,$action=NULL,$actdt=NULL){
		   if($actdt==NULL)  $actdt=date("Y-m-d H:i:s");
		   
	       $this->load->model('log_model');
		   return $this->log_model->KM_save(array("class"=>"act_log","return_id"=>true,"insert"=>array("userid"=>$uid,"hwid"=>$hwid,"qrcid"=>$qrc_id,"action"=>$action,"actdt"=>$actdt)));
		   
	}
	

	 
}	
	
			 
