<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends KM_Controller {

  function __construct(){
  	parent::__construct(); 
	$this->admin_session=$this->session->userdata('admin'); 
  } 
  
  public function index(){ 
		$this->title='Shop Guard';	 
		$this->load->model('buggies_model');
		 
		$data['abstract']=$this->buggies_model->customersUsageCounts(); 
		$data['outlets']=$this->buggies_model->outletsAbstract(); 
		$this->load->view('admin/dashboard',$data);
  }
  
   public function logout(){ 
		$this->layout=false;	 
		$this->session->sess_destroy();
		redirect('admin/');
  }  
	
	
}
