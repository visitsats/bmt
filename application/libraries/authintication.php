<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Rest Controller
 *
 * A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Phil Sturgeon, Chris Kacerguis
 * @license         http://philsturgeon.co.uk/code/dbad-license
 * @link			https://github.com/philsturgeon/codeigniter-restserver
 * @version         3.0.0-pre
 */

class authintication extends KM_Controller
{
	 function check_user($username,$password){
	 	$this->load->model('services_model');
		return true;
		/*if($this->services_model->KM_count(array("class"=>"user","conditions"=>array("username"=>$username,"pwd"=>$password)))){
				return true;
		}else{
			return false;
		}*/
	 
	 }
	 

}
