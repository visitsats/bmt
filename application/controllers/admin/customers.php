<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers extends KM_Controller {

  function __construct(){
  	parent::__construct(); 
	$this->load->model('buggies_model');  
	$this->admin_session=$this->session->userdata('admin');
  } 
  
  public function index(){ 
		$this->title='Shop Guard';		
		$data['outlets']=$this->buggies_model->KM_all(array("class"=>"outlets","fields"=>array("ol_id","outlet"),"conditions"=>array("retid"=>$this->admin_session['retid']))); 	
		$categories=$this->buggies_model->KM_all(array("class"=>"cat",
															   'joins'=>array(
																			array("class"=>"subcat","type"=>"inner","foreignKey"=>"catid","primaryKey"=>"catid")
																		),
																'order'=>'category,subcategory'	
															  )
														  );
														  
		$data['categories']=array();												  
		
		foreach($categories as $cat){
			$data['categories'][$cat['catid']]['cat_name']=$cat['category'];	
			$data['categories'][$cat['catid']]['subcat'][]=$cat;		
		}  
		 												  	
		$this->load->view('admin/customers',$data);
  }
  
  public function abstract_list(){ 
		$this->layout=false;
		$data['num_customers']=$this->buggies_model->customersUsages_count();
		$data['abstract']=$this->buggies_model->customersUsageCounts();
		$this->load->view('admin/customer_report',$data);
  } 
  
  public function customer_list($offset=0){
		$this->layout=false;
		
		$limit=10;
  		$data['customers']=$this->buggies_model->customersUsages($offset,$limit);
		//$data['num_rows']=$this->buggies_model->customersUsages_count();
	
		$this->load->library('pagination');		
		$config = array(); 
		$config['base_url'] = base_url("admin/customers/customer_list");
		$config['total_rows'] = $this->buggies_model->customersUsages_count();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4; 
		$config['first_link'] = 'First';
		$config['last_link'] =  'Last';
		
		$this->pagination->initialize($config);		
	 
		
  		$resp['customers']=$this->load->view('admin/customers_list',$data,true);
		$resp['pagination'] =  utf8_encode($this->pagination->create_links()); ; 
		$resp['page'] = $offset;
		 
		echo json_encode($resp);
		
  }  
  
  
  
    public function fav_list($offset=0){
		$this->layout=false;
		
		$limit=10;
  		$data['favs']=$this->buggies_model->favourites($offset,$limit);
		 
	
		$this->load->library('pagination');		
		$config = array(); 
		$config['base_url'] = base_url("admin/customers/fav_list");
		$config['total_rows'] = $this->buggies_model->favourites_count();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4; 
		$config['first_link'] = 'First';
		$config['last_link'] =  'Last';
		
		$this->pagination->initialize($config);		
	 
		
  		$resp['favs']=$this->load->view('admin/fav_list',$data,true);
		$resp['pagination'] =  utf8_encode($this->pagination->create_links()); ; 
		$resp['page'] = $offset;
		
		 
		echo json_encode($resp);		
  }
  
  
  
  public function active_list($offset=0){
		$this->layout=false;
		
		$limit=10;
  		$data['actives']=$this->buggies_model->active_product($offset,$limit);
		 
	
		$this->load->library('pagination');		
		$config = array(); 
		$config['base_url'] = base_url("admin/customers/active_list");
		$config['total_rows'] = $this->buggies_model->active_product_count();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4; 
		$config['first_link'] = 'First';
		$config['last_link'] =  'Last';
		
		$this->pagination->initialize($config);		
	 
		
  		$resp['actives']=$this->load->view('admin/active_list',$data,true);
		$resp['pagination'] =  utf8_encode($this->pagination->create_links()); ; 
		$resp['page'] = $offset;
		
		 
		echo json_encode($resp);		
  }
  
  
  
  
  
  public function scan_list($offset=0){
		$this->layout=false;	
		$categories=$this->buggies_model->KM_all(array("class"=>"cat",
															   'joins'=>array(
																			array("class"=>"subcat","type"=>"inner","foreignKey"=>"catid","primaryKey"=>"catid")
																		),
																'order'=>'category,subcategory'	
															  )
														  );
														  
		$data['categories']=array();												  
		
		foreach($categories as $cat){
			$data['categories'][$cat['catid']]['cat_name']=$cat['category'];	
			$data['categories'][$cat['catid']]['subcat'][]=$cat;		
		} 
		 
		
		
		$data['customer'] = $this->buggies_model->KM_first(array('class'=>'user','conditions'=>array('id'=>$this->input->post('uid'))));
		
		
		  
  		$this->load->view('admin/scan_list',$data);
				
  }
  
   public function  customer_abstract(){
		$this->layout=false;  
		$data['abstract'] = $this->buggies_model->customersUsageCounts($this->input->post('uid'));
  		$this->load->view('admin/customer_abstract',$data);
				
  }
  
  public function scan_grid($offset=0){
 		$this->layout=false;
  		$limit=10;
  		$data['scans']=$this->buggies_model->scanned_products($offset,$limit); 
		$this->load->library('pagination');		
		$config = array(); 
		$config['base_url'] = base_url("admin/customers/scan_grid");
		$config['total_rows'] = $this->buggies_model->scanned_products_count();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4; 
		$config['first_link'] = 'First';
		$config['last_link'] =  'Last';		
		$this->pagination->initialize($config);	  
		 
		
		$resp['scan_grid']=$this->load->view('admin/scan_data',$data,true);
		$resp['pagination'] =  utf8_encode($this->pagination->create_links()); ; 
		$resp['page'] = $offset;
		 
		echo json_encode($resp);
  
  }
  
   public function delete_sample_data()
   {
   $sp_data = $this->db->query("CALL trunc_test_user_data()");
   }
	
	
}
