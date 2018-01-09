<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Bookmyt extends KM_Controller 
	{
		public function __construct()
		{
			parent::__construct();
			$sess_data = $this->session->all_userdata();
			$this->clear_cache();
			$this->load->model('Bookmyt_model','bookmyt_model');
			
			$this->permissions='';
			
			if(isset($sess_data['user_type_id']) && $sess_data['user_type_id']!='')			
			{
				$permissions = $this->bookmyt_model->role_permissions($sess_data['user_type_id']);
				$permissions = isset($permissions[0]) ? $permissions[0]['permissions'] : '';
				$this->permissions = json_decode($permissions);
				
			}
			if($this->session->userdata('business_id')!=""){
				$tzone = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'time_zone','is_active'
						),
						"conditions" => array(
						  "business_id" => $this->session->userdata('business_id')
						)
					));
				if($tzone['is_active']==0){
					if($this->uri->segment(2)=='payToRenew'){
					}else if($this->uri->segment(2)=='log_out'){
					}else if($this->uri->segment(2)=='upgrade_plan'){
					}else{
						echo '<script>window.location="'.base_url('bookmyt/payToRenew').'"</script>';
					}
				}
				if($tzone['time_zone']=='M'){
					//$timezone=""
					$timezne=date_default_timezone_set("America/Denver");
				}else if($tzone['time_zone']=='P'){
					$timezne=date_default_timezone_set("America/Los_Angeles");
				}else if($tzone['time_zone']=='K'){
					$timezne=date_default_timezone_set("America/Anchorage");
				}else if($tzone['time_zone']=='C'){
					$timezne=date_default_timezone_set("America/Chicago");
				}else if($tzone['time_zone']=='E'){
					$timezne=date_default_timezone_set("America/New_York");
				}else if($tzone['time_zone']=='A'){
					$timezne=date_default_timezone_set("America/Puerto_Rico");
				}
			}
			
		}
		
		// public function sess_des()
		// {
			// $this->session->sess_destroy();
			// redirect(base_url());
		// }
		 function clear_cache()
		{
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
		}
		public function index()
		{	
			/*if($this->input->post())
			{
				$login = $this->bookmyt_model->KM_first(array(
				"class" => "site_login",
				"fields" => array(
					'uname',
					'password'
				),
				"conditions" => array(				   
					"uname" => $this->input->post('uname'),
					"password" => md5($this->input->post('pwd'))
				)
				));			
				
				if($login)
				{
					$this->session->set_userdata('admin_log',$login);
					redirect('bookmyt/home/');
				}
				else
				{
					$this->session->set_flashdata('fail',"Invalid credentials");
					redirect();
				}
			
			}*/
			//redirect('bookmyt/home/');
			/*else
			{
				$add_sess = $this->session->userdata('admin_log');
				if($add_sess['uname'] != '')
				{
					redirect('bookmyt/home/');
				}
				else
				{
					$this->layout = false;
					$this->load->view('first_login');
				}
			}*/
		}
		public function load_curl_data($url,$post_array)
		{
			$username = 'admin';
			$password = '1234';
			
			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL,$url);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_array);
			curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);

			$buffer = curl_exec($curl_handle);
		    return $buffer;
		
		
		}
		
		public function howitworks(){
			$this->title="How It Works";
			$this->load->view('howitworks');
		}
		public function connectwithus(){
			$this->title="Connect With Us";
			$this->load->view('connectwithus');
		}
		public function demo(){
			$this->title="Demo";
			$this->load->view('demo');
		}
		public function home($var='')
		{
			
			//pr($this->session->all_userdata());pr($this->permissions);echo 'Hi';exit;
			/*if($this->session->userdata('admin_log'))
			{*/
				if($this->session->userdata('business_id')==""){
					$url=base_url().'api/business/getformdetails/format/json';				
					$post_array =array(  
						'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru' 
					);
					$buffer = $this->load_curl_data($url,$post_array);
	
					
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$data['zones']          = $this->bookmyt_model->get_zones();
					$data['time_zone'] = json_decode($buffer);			
					$this->load->view('home',$data);
					
				}else{
					//pr($this->permissions);
					if(!empty($this->permissions))
					{
						if($this->permissions->reservation->view == '' && $this->permissions->reservation->view == 0)
						{
							$this->session->set_flashdata('perm','Access Denied');
							redirect('bookmyt/home/');
						}
					}
					
					$bid = $this->session->userdata('business_id');
					$data['branches'] = $this->bookmyt_model->get_branches($bid);
					$url=base_url().'api/business/reservationlist/format/json';				
					$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
						'business_id' => $this->session->userdata('business_id'),
					'user_id' => $this->session->userdata('user_id'),'have_brchs' => $this->session->userdata('have_branches')
					);
					$buffer = $this->load_curl_data($url,$post_array);
			
					$data['reservation_list'] = json_decode($buffer);
					
					
					$url=base_url().'api/business/reslist/format/json';				
					$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
						'business_id' => $this->session->userdata('business_id'),'branch_id' => $this->session->userdata('branch_id'),
						'user_id' => $this->session->userdata('user_id') , 'hb' => $this->session->userdata('have_branches')
					);
					$buffer = $this->load_curl_data($url,$post_array);
					$data['res_list'] = json_decode($buffer);
	
					$url=base_url().'api/business/floorslist/format/json';				
					$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
						'business_id' => $this->session->userdata('business_id')
					);
					$buffer = $this->load_curl_data($url,$post_array);			
					
					$data['floors'] = json_decode($buffer);
					$bid = $this->session->userdata('business_id');
					$hb = $this->session->userdata('have_branches');
					$data['floors_info'] = $this->bookmyt_model->get_flrs_branches($bid,$hb);
					
					$this->load->view('reservation_list',$data);
				}
			/*}
			else
			{
				
				$add_sess = $this->session->userdata('admin_log');
				if($add_sess['uname'] == '')
				{
					redirect();
				}
			}*/
		}
		//public function 
		public function add_customer()
		{
		
			if($this->input->post())
			{				
				
				$email_phn = $this->input->post('business_email_phn');
				if(strstr($email_phn,'@')){
				//if(!is_numeric($email_phn)){
					$result = $this->bookmyt_model->b_email($email_phn);
				}else if(is_numeric($email_phn)){
					$result = $this->bookmyt_model->b_phone($email_phn);
				}
				$business_name=$this->input->post('business_name');
				$c=$this->bookmyt_model->KM_count(array("class" => "business_entity","conditions" => array(
				"business_name" => $business_name)));
				if ($c!=0)
				{
				
				//$this->session->set_flashdata('perm','Business already exists');
				echo '<script>alert("Business already exists");window.location="'.base_url('bookmyt/home').'";</script>';
				//redirect('bookmyt/home/');
				}
				if(!empty($result))
				{
					//$this->session->set_flashdata('perm','Your Emailid or Phone number already registered. Try another.');
					echo '<script>alert("Your Emailid or Phone number already registered. Try another.");window.location="'.base_url('bookmyt/home').'";</script>';
					//redirect('bookmyt/home/');
				}
				else
				{					
					$random_pwd = mt_rand(100000, 999999);
					$username = 'admin';
					$password = '1234';
					$ip_address = $_SERVER['REMOTE_ADDR'];
					//$ip_address = '123.176.39.51';
					//$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip_address));
					//$country = $query['countryCode'];
					//$state = $query['regionName'];						
					//$tz = $query['timezone'];
					$zip=$this->input->post("location");
					//$sql = "select zone_id from zone where zone_name='$tz'";
					//$qc = $this->db->query($sql);
					//$reslt = $qc->result_array();
					$details=file_get_contents("http://www.webservicex.net/uszip.asmx/GetInfoByZIP?USZip=".$zip);
					$xml = simplexml_load_string($details);
					if(!empty($xml)){
						$time_zone=$xml->Table->TIME_ZONE;
						$location=$xml->Table->CITY;
						$country="US";
						$state=$xml->Table->STATE;
					}else{
						$time_zone = '';
					}
					/*$country="US";
					$location='';
					$state='';
					$time_zone=$this->input->post('time_zone');*/
					/*if(count($reslt) != '0')
					{
						if(isset($reslt) && $reslt[0]['zone_id'] != '')
						{
							$time_zone = $reslt[0]['zone_id'];
						}
					}
					else
					{
						$time_zone = '';
					}*/
					//echo "Hi1";exit;
					$url=base_url().'api/business/add_business_customer/format/json';
					$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'country' => $country ,'zipcode'=>$zip,'city'=>$location, 't_zone' => $time_zone ,'state' =>$state);
					$post_array = array_merge($_POST,$arr);
					 $buffer = $this->load_curl_data($url,$post_array);
					
					$buffer=json_decode($buffer);
					$buss_type=$buffer->data->business_type;
					$buss_type=(isset($buss_type) && $buss_type=='L')?'Large Enterprise':'Small Enterprise';
					if(!empty($buffer))
					{  
						$l_business_name=$this->input->post('l_business_name');
						if($l_business_name==''){
							if(!is_numeric($this->input->post('business_email_phn'))){
								/*$config = array(
									'protocol' => "smtp",	
									'smtp_host' => "mail510.opentransfer.com",
									'smtp_port' => 587,
									'charset' => 'utf-8',
									'smtp_user' => 'info@trugeek.in',
									'smtp_pass' => 'Km!pl!123',
									);*/
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
								
								//$phone_no = $buffer->data->phone_no;
								//$branch_id = $buffer->data->Id;				
								
								$body = "<p>Dear Customer,</p><p>We appreciate your interest with Book My T. Your account activation email will be sent shortly, after verification process.</p><p>For any help, please connect us on <a href='mailto:info@bookmyt.com'>info@bookmyt.com</a></p></br><p>Regards,</p><p>Book My T</p>";
								//$emailid = $this->input->post('email');
								$this->email->from('info@bookmyt.com', 'Book My T');
								$this->email->to($this->input->post('business_email_phn'));
								$this->email->cc('');
								$this->email->bcc('');
		
								$this->email->subject('Welcome to Book My T.');
								$this->email->message($body);
		
								if($this->email->send())
								{}
								
							}else if(is_numeric($this->input->post('business_email_phn'))){
								/*$username = "visitsats@gmail.com";
								$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
								$username = "dayakarv@toyaja.com";
								$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
								$test = "0";
								$username = "am_desai@yahoo.com";
								$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
								$sender = urlencode("BMYTBL"); */
								$numbers = $this->input->post('business_email_phn'); 
								/* $message = "Appreciate your interest in Book My T. Your account will be activated shortly by another message/email after verification process. For any help, please connect us on info@bookmyt.com ";*/
								$message="Appreciate your interest in Book My T. You will receive a sms/email after activation. For any help, connect us on info@bookmyt.com";
								/*$message = $message;
							   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
								
								$this->load->library("request_rest");
								$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
								$request_data=array(						
													"mobile_number" => $numbers,
													"message" => $message			
												);
						
								$this->request_rest->setRequestURL($request_url);
								$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
								$this->request_rest->setRequestBody(json_encode($request_data));
								$this->request_rest->setMethod("PUT");
								$result = $this->request_rest->execute();
								$res=json_decode($result);
								
							}
								// Mail intimation to admin
								/*$config = array(
									'protocol' => "smtp",	
									'smtp_host' => "mail510.opentransfer.com",
									'smtp_port' => 587,
									'charset' => 'utf-8',
									'smtp_user' => 'info@trugeek.in',
									'smtp_pass' => 'Km!pl!123',
									);*/
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
								
								//$phone_no = $buffer->data->phone_no;
								//$branch_id = $buffer->data->Id;				
								
								$body = "<p>Dear Admin,</p><p>This is to inform you that, new restaurant ".$business_name." is awaiting for your verification and approval. Please login to the portal to approve.</p></br><p>Regards,</p><p>Book My T</p>";
								//$emailid = $this->input->post('email');
								$this->email->from('info@bookmyt.com', 'Book My T');
								$this->email->to('bmytable@gmail.com');
								$this->email->cc('');
								$this->email->bcc('');
		
								$this->email->subject('Welcome to Book My T.');
								$this->email->message($body);
		
								if($this->email->send())
								{}
								//Message for Admin
								$username = "visitsats@gmail.com";
								$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
								$username = "dayakarv@toyaja.com";
								$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
								$test = "0";
								$username = "am_desai@yahoo.com";
								$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
								$sender = urlencode("BMYTBL"); 
								$numbers = '9000550399,8143700849'; 
								 $message = "Dear Admin, This is to inform you that, new restaurant is awaiting for your verification and approval. Restaurant Name: ".$business_name.", ".$buss_type.", USA";
								$message = urlencode($message);
							   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
								
								$ch = curl_init('http://api.textlocal.in/send/?');
								curl_setopt($ch, CURLOPT_POST, true);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								 $result = curl_exec($ch); 
								curl_close($ch);
								$res=json_decode($result);
							//$this->session->set_flashdata('succ','Business added successfully. You will get your password from admin.');
							echo '<script>alert("Restaurant '.$business_name.' has been registered successfully.\nAppreciate your interest in Book My T. Your account will be activated shortly by another message/email");window.location="'.base_url('bookmyt/home').'";</script>';
						}else{
							//$this->session->set_flashdata('succ','Our Representative will contact you soon');
							echo '<script>alert("Our Representative will contact you soon");window.location="'.base_url('bookmyt/home').'";</script>';
						}
						//redirect('bookmyt/home/');
					}
				}
			
							
			}
			else
			{
				
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				$data['zones']          = $this->bookmyt_model->get_zones();
				$this->load->view('home',$data);
			}
			
		}
		
		
		function b_email()
		{
			$b_email = $this->input->post('business_email');
			$result = $this->bookmyt_model->b_email($b_email);
			if(!empty($result))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
		
				//public function 
		public function add_branch()
		{
			if($this->session->userdata('business_id'))
			{	
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				if(!empty($this->permissions))
				{
					if($this->permissions->branch->add == '' || $this->permissions->branch->add == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
								
				if($this->input->post())
				{
					$this->form_validation->set_rules('business_name', 'Business name', 'required|is_unique[business_entity.business_name]');
					$this->form_validation->set_rules('business_types', 'Business type', 'required');
					//$this->form_validation->set_rules('user_name', 'Name', 'required');
					//if($this->input->post('business_email')!=''){
					$this->form_validation->set_rules('business_email', 'Business email', 'required|valid_email|is_unique[business_entity.business_email]');
					//}
					//if($this->input->post('phone_no')!=''){
					$this->form_validation->set_rules('phone_no', 'Business phone number', 'required|numeric|min_length[10]|max_length[15]|is_unique[business_entity.phone_no]');
					//}
					$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|numeric|min_length[3]|max_length[5]');
					
					/*if($this->input->post('business_email')=='' && $this->input->post('phone_no')==''){
						$this->form_validation->set_rules('business_email', 'Business email or Phone number', 'required|valid_email|is_unique[business_entity.business_email]');
						
					}*/
					$this->form_validation->set_rules('state', 'Business State', 'required');
					$this->form_validation->set_rules('city', 'Business City', 'required');
					
					if ($this->form_validation->run() == FALSE)
					{
						$data['business_types'] = $this->bookmyt_model->get_business_types();
						$data['userdata'] = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "business_id" => $this->session->userdata('business_id')
							)
						));			
						$this->load->view('register/add_brach',$data);
					}
					else
					{
						$business_email     = $this->input->post('business_email');
						$phone_no           = $this->input->post('phone_no');
						$dupNames=$this->bookmyt_model->checkDupEmailcheck($business_email,$phone_no);
						
						if(empty($dupNames)){
							$bid=$this->input->post('relationship_id');
							$users_count = $this->bookmyt_model->KM_first(array(
									"class" => "business_entity",
									"fields" => array(
										'relationship_id','no_of_users','branch','subscription_type'
									),
									"conditions" => array(
									  "business_id" => $bid
									)
								));	
							$query = $this->db->query("select a.business_id from
(select business_id from user_details where business_id='$bid' or relationship_id='$bid'
union all
select business_id from business_entity where business_id='$bid' or relationship_id='$bid') a");
							$no_of_users=$query->result_array();							
							if($users_count['subscription_type']!=1){
							if(($users_count['subscription_type']==4 || $users_count['subscription_type']==5) &&$users_count['branch']==0){
								if(count($no_of_users)<=$users_count['no_of_users']){
							$random_pwd = mt_rand(100000, 999999);
							$username = 'admin';
							$password = '1234';
							$ip_address=$_SERVER['REMOTE_ADDR'];	
							//$ip_address = '123.176.39.51';
							$url=base_url().'api/business/add_branch/format/json';
							$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'rand_pwd' => md5($random_pwd));
							$post_array = array_merge($_POST,$arr);
							$buffer = $this->load_curl_data($url,$post_array);
							$buffer=json_decode($buffer);
							
							/*$config = array(
								'protocol' => "smtp",	
								'smtp_host' => "mail510.opentransfer.com",
								'smtp_port' => 587,
								'charset' => 'utf-8',
								'smtp_user' => 'info@trugeek.in',
								'smtp_pass' => 'Km!pl!123',
								);*/
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
							$branch_email = $buffer->data->business_email;
							$phone_no = $buffer->data->phone_no;
							$branch_id = $buffer->data->Id;				
							$branch_name=$buffer->data->business_name;
							if($branch_email!=''){
							$body = "<p>Dear Branch Admin,</p><p>Congratulations for creating new branch, To get started using your account, please create your new password by clicking the following link and password.</p><br/><a href='".base_url()."bookmyt/create_branch_pwd/".urlencode($branch_id)."' style='color:blue; font-size:15px'>".base_url()."bookmyt/create_branch_pwd/".urlencode($branch_id)."</a><br/><p>Your username is: ".$branch_email."<br/>Your Password is: ".$random_pwd."</p>";
							//$emailid = $this->input->post('email');
							$this->email->from('info@bookmyt.com', 'Book My T');
							$this->email->to($branch_email);
							$this->email->cc('');
							$this->email->bcc('');
	
							$this->email->subject('Create Your New Password');
							$this->email->message($body);
	
							if($this->email->send())
							{
								
							}
							}
							if( $phone_no != ''){
							/*$username = "visitsats@gmail.com";
							$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
							$username = "dayakarv@toyaja.com";
							$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
							$test = "0";
							$username = "am_desai@yahoo.com";
							$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
							$sender = urlencode("BMYTBL"); */
							$numbers = $phone_no; 
							$message = "Dear Branch Admin, The password for new branch ".$branch_name." is: ".$random_pwd.", Your username is: ".$phone_no;
							/*$message = $message;
							$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
							
							$this->load->library("request_rest");
							$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
							$request_data=array(						
												"mobile_number" => $numbers,
												"message" => $message			
											);
					
							$this->request_rest->setRequestURL($request_url);
							$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
							$this->request_rest->setRequestBody(json_encode($request_data));
							$this->request_rest->setMethod("PUT");
							$result = $this->request_rest->execute();
							//$res=json_decode($result);
							if($result[0]=="200"){
								$success=1;
							}else{
								$success=0;
							}
							
							}
							if($branch_email!='' && $phone_no != ''){
							$this->session->set_flashdata('success','Branch added successfully. Password sent to branch admin email. Please check in spam or junk if email not received in inbox. Also password sent on admin phone.');
							redirect('bookmyt/add_floor/');
							}else if($branch_email!=''){
							$this->session->set_flashdata('success','Branch added successfully. Password sent to branch admin mail.Please check in spam or junk if email not received in inbox.');
							redirect('bookmyt/add_floor/');
							}
							else if($phone_no!=''){
							$this->session->set_flashdata('success','Branch added successfully. Password sent on admin phone');
							redirect('bookmyt/add_floor/');	
							}
							else
							{
								$this->session->set_flashdata('fail','Password not sent to your mail.');
								redirect('bookmyt/add_branch/');
							}				
							$data['sucess']=$buffer->success;
							
							if(!empty($buffer))
							{
								$this->session->set_flashdata('success','Branch added successfully.');
								redirect('bookmyt/add_floor/');
							}
							else
							{
								$this->session->set_flashdata('fail','Branch not added.');
								redirect('bookmyt/add_branch/');
							}
							}else{
								$this->session->set_flashdata('fail','Exceeding No. of Users.');
								redirect('bookmyt/add_branch/');
							}							
							}else {
							if(count($no_of_users)<$users_count['no_of_users']){
							$random_pwd = mt_rand(100000, 999999);
							$username = 'admin';
							$password = '1234';
							$ip_address=$_SERVER['REMOTE_ADDR'];	
							//$ip_address = '123.176.39.51';
							$url=base_url().'api/business/add_branch/format/json';
							$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'rand_pwd' => md5($random_pwd));
							$post_array = array_merge($_POST,$arr);
							$buffer = $this->load_curl_data($url,$post_array);
							$buffer=json_decode($buffer);
							
							/*$config = array(
								'protocol' => "smtp",	
								'smtp_host' => "mail510.opentransfer.com",
								'smtp_port' => 587,
								'charset' => 'utf-8',
								'smtp_user' => 'info@trugeek.in',
								'smtp_pass' => 'Km!pl!123',
								);*/
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
							$branch_email = $buffer->data->business_email;
							$phone_no = $buffer->data->phone_no;
							$branch_id = $buffer->data->Id;				
							$branch_name=$buffer->data->business_name;
							if($branch_email!=''){
							$body = "<p>Dear Branch Admin,</p><p>Congratulations for creating new branch, To get started using your account, please create your new password by clicking the following link and password.</p><br/><a href='".base_url()."bookmyt/create_branch_pwd/".urlencode($branch_id)."' style='color:blue; font-size:15px'>".base_url()."bookmyt/create_branch_pwd/".urlencode($branch_id)."</a><br/><p>Your username is: ".$branch_email."<br/>Your Password is: ".$random_pwd."</p>";
							//$emailid = $this->input->post('email');
							$this->email->from('info@bookmyt.com', 'Book My T');
							$this->email->to($branch_email);
							$this->email->cc('');
							$this->email->bcc('');
	
							$this->email->subject('Create Your New Password');
							$this->email->message($body);
	
							if($this->email->send())
							{
								
							}
							}
							if( $phone_no != ''){
							/*$username = "visitsats@gmail.com";
							$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
							$username = "dayakarv@toyaja.com";
							$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
							$test = "0";
							$username = "am_desai@yahoo.com";
							$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
							$sender = urlencode("BMYTBL"); */
							$numbers = $phone_no; 
							$message = "Dear Branch Admin, The password for new branch ".$branch_name." is: ".$random_pwd.", Your username is: ".$phone_no;
							/*$message = $message;
							$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
							
							$this->load->library("request_rest");
							$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
							$request_data=array(						
												"mobile_number" => $numbers,
												"message" => $message			
											);
					
							$this->request_rest->setRequestURL($request_url);
							$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
							$this->request_rest->setRequestBody(json_encode($request_data));
							$this->request_rest->setMethod("PUT");
							$result = $this->request_rest->execute();
							//$res=json_decode($result);
							if($result[0]=="200"){
								$success=1;
							}else{
								$success=0;
							}
							
							}
							if($branch_email!='' && $phone_no != ''){
							$this->session->set_flashdata('success','Branch added successfully. Password sent to branch admin email. Please check in spam or junk if email not received in inbox. Also password sent on admin phone.');
							redirect('bookmyt/add_floor/');
							}else if($branch_email!=''){
							$this->session->set_flashdata('success','Branch added successfully. Password sent to branch admin mail.Please check in spam or junk if email not received in inbox.');
							redirect('bookmyt/add_floor/');
							}
							else if($phone_no!=''){
							$this->session->set_flashdata('success','Branch added successfully. Password sent on admin phone');
							redirect('bookmyt/add_floor/');	
							}
							else
							{
								$this->session->set_flashdata('fail','Password not sent to your mail.');
								redirect('bookmyt/add_branch/');
							}				
							$data['sucess']=$buffer->success;
							
							if(!empty($buffer))
							{
								$this->session->set_flashdata('success','Branch added successfully.');
								redirect('bookmyt/add_floor/');
							}
							else
							{
								$this->session->set_flashdata('fail','Branch not added.');
								redirect('bookmyt/add_branch/');
							}
							}else{
								$this->session->set_flashdata('fail','Exceeding No. of Users.');
								redirect('bookmyt/add_branch/');
							}
							
							}
							}
						}else{
							$this->session->set_userdata('fail','Duplicate Email or Phone Number');
							$this->load->view('register/add_brach',$data);
							//redirect('bookmyt/add_branch');
						}
					}
						
						
				}
				else
				{

					
					
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $this->session->userdata('business_id')
						)
					));			
					$this->load->view('register/add_brach',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
		}
		
		function validate_business($bid)
		{
			$sql = "select * from business_entity where business_id = '$bid'";
			$query = $this->db->query($sql);
			$result = $query->result_array();
			if(count($result) != 0)
			{
				$buss_email = $result[0]['business_email'];
				$buss_id = $bid;
				
				if($result[0]['is_active'] == 0)
				{
					$system_array = array('is_active' => 1,'subscription_type'=>$this->input->post("subscription"),'substart'=>date("Y-m-d H:i:s"));
					$res = $this->bookmyt_model->KM_update(array(
						"class" => "business_entity",
						"update" => $system_array
							), array(
							'business_id' => $buss_id
							));
							
					if($res)
					{
						if($result[0]['login_count'] == 0)
						{
							$random_pwd = mt_rand(100000, 999999);
							$sys_array = array('password' => md5($random_pwd));
							$reslt = $this->bookmyt_model->KM_update(array(
								"class" => "business_entity",
								"update" => $sys_array
									), array(
									'business_id' => $buss_id
									));
							//if(!is_numeric($result[0]['business_email']))
							if(strstr($result[0]['business_email'],'@'))
							{
							/*$config = array(
								'protocol' => "smtp",	
								'smtp_host' => "mail510.opentransfer.com",
								'smtp_port' => 587,
								'charset' => 'utf-8',
								'smtp_user' => 'info@trugeek.in',
								'smtp_pass' => 'Km!pl!123',
								);	*/	
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
							$body = "Dear ".$result[0]['business_name'].",<br/><br/><p>Welcome To Book My T.</p><br/><p>Thanks for Signing up for a Book My T account. We're very excited to have you on board.</p><br/><p>To get started using Book My T, please create your new password by clicking the following link and password.</p><br/><a href='".base_url()."bookmyt/create_pwd/".urlencode($buss_id)."' style='color:blue; font-size:15px'>".base_url()."bookmyt/create_pwd/".urlencode($buss_id)."</a><br/><p>Your Username is: ".$buss_email."<br/>Your Password Is : ".$random_pwd."</p><br/><p>Thank You</p><p>Book My T</p>";
						
							$this->email->from('no-reply@bookmyt.com', 'Book My T');
							$this->email->to($buss_email);
							

							$this->email->subject('Create Your New Password');
							$this->email->message($body);
							$success=$this->email->send();
							}else
							{
							  
								
								/*$test = "1";
								$username = "visitsats@gmail.com";
								$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
								$username = "dayakarv@toyaja.com";
								$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
								$test = "0";
								$username = "am_desai@yahoo.com";
								$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
								$sender = urlencode("BMYTBL"); */
								$numbers = $result[0]['phone_no']; 
								$owner=$result[0]['your_name'];
								 /*$message = "Dear ".$owner.", Thanks for Signing up for a Book My T account. Your password for Book My T account is ".$random_pwd.". Your username is: ".$result[0]['phone_no'];*/
								 $message="Thanks for Signing up for a Book My T account. Your password for Book My T account is ".$random_pwd.".Your username is: ".$result[0]['phone_no'];
								 //$message = "Hi";
								/*$message = $message;
							   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
								
								$this->load->library("request_rest");
								
								
								$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
								$request_data=array(						
													"mobile_number" => $numbers,
													"message" => $message			
												);
								$this->request_rest->setRequestURL($request_url);
								$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
								$this->request_rest->setRequestBody(json_encode($request_data));
								$this->request_rest->setMethod("PUT");
								$result = $this->request_rest->execute();
								//pr($result);exit;
								$res=json_decode($result);
								//pr($result);pr($res);exit;
								
								if($result[0]==200){
									$success=1;
								}else{
									$success=0;
								}
							
							}

							if($success)
							{
								$this->session->set_flashdata('success','Password sent to business email/phone number.');
								redirect('bookmyt/admin_dashboard/');
							}
							else
							{
								$this->session->set_flashdata('fail','Password not sent to business admin email/phone number.');
								redirect('bookmyt/admin_dashboard/');
							}
						}
						else
						{
							$system_array1 = array('is_active' => 1);
							$res1 = $this->bookmyt_model->KM_update(array(
								"class" => "business_entity",
								"update" => $system_array1
									), array(
									'business_id' => $buss_id
									));
							$res2 = $this->bookmyt_model->KM_update(array(
								"class" => "business_entity",
								"update" => $system_array1
									), array(
									'relationship_id' => $buss_id
									));
							if($res1 && $res2)		
							{
								$this->session->set_flashdata('success','Business activated successfully.');
								redirect('bookmyt/admin_dashboard/');
							}
							else
							{
								$this->session->set_flashdata('fail','Operation Failed.');
								redirect('bookmyt/admin_dashboard/');
							}
						}
					}
				}
				else if($result[0]['is_active'] == 1)
				{
					
					$system_array = array('is_active' => 0);
					$res = $this->bookmyt_model->KM_update(array(
						"class" => "business_entity",
						"update" => $system_array
							), array(
							'business_id' => $buss_id
							));
					
					$res1 = $this->bookmyt_model->KM_update(array(
						"class" => "business_entity",
						"update" => $system_array
							), array(
							'relationship_id' => $buss_id
							));
							
					if($res && $res1)
					{
						$this->session->set_flashdata('success','Business is In-activated.');
						redirect('bookmyt/admin_dashboard/');
					}
					else
					{
						$this->session->set_flashdata('fail','Operation Failed.');
						redirect('bookmyt/admin_dashboard/');
					}
				}
			}			
		}
		function geoCheckIP( $ip )
		{
			//check, if the provided ip is valid
			if( !filter_var( $ip, FILTER_VALIDATE_IP ) )
			{
				throw new InvalidArgumentException("IP is not valid");
			}

			//contact ip-server
			$response=@file_get_contents( 'http://www.netip.de/search?query='.$ip );

			if( empty( $response ) )
			{
				throw new InvalidArgumentException( "Error contacting Geo-IP-Server" );
			}

			//Array containing all regex-patterns necessary to extract ip-geoinfo from page
			$patterns=array();
			$patterns["domain"] = '#Domain: (.*?) #i';
			$patterns["country"] = '#Country: (.*?) #i';
			$patterns["state"] = '#State/Region: (.*?)<br#i';
			$patterns["town"] = '#City: (.*?)<br#i';

			//Array where results will be stored
			$ipInfo=array();

			//check response from ipserver for above patterns
			foreach( $patterns as $key => $pattern )
			{
				//store the result in array

				$ipInfo[$key] = preg_match( $pattern, $response, $value ) && !empty( $value[1] ) ? $value[1] : 'not found';
			}
			
			/*I've included the substr function for Country to exclude the abbreviation (UK, US, etc..)
			To use the country abbreviation, simply modify the substr statement to:
			substr($ipInfo["country"], 0, 3)
			*/
			$ipdata = $ipInfo["state"];

			return $ipdata;
		}		
		//add table
			//Add floor
		public function add_table()
		{
			if($this->session->userdata('business_id'))
			{
				if($this->input->post())
				{	


					$url=base_url().'api/business/add_table/format/json';
					$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru');
					$post_array = array_merge($_POST,$arr);
					$buffer = $this->load_curl_data($url,$post_array);
					$buffer=json_decode($buffer);
					$data['sucess']=$buffer->success;
					if(!empty($buffer))
					{
						$this->session->set_flashdata('success','Table added successfully.');
						redirect('bookmyt/add_table/');
					}
					else
					{
						$this->session->set_flashdata('fail','Table not added.');
						redirect('bookmyt/add_table/');
					}	
				}
				else
				{
					$business_id=$this->session->userdata('business_id');
					$data['floors'] = $this->bookmyt_model->get_floors($business_id);
					$this->load->view('register/add_table',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
		}
		
		
		
	   //login
	   
	   	
		public function log_out()
		{
			$array_items = array('log_type'=>'',
			'business_id'=>'',
			'business_name'=>'',
			'business_email'=>'',
			'branch'=>'',
			'relationship_id'=>'',
			'have_branches'=>'' ,
			'login_count'=>'', 
			'last_login'=>'',
			'user_id'=>'',
			'email'=>'',
			'user_type_id'=>'',
			'login_sup'=>'',
			'sup'=>''
			);			
			//$this->session->unset_userdata($array_items);
			$this->session->set_userdata($array_items);
		//	$this->session->sess_destroy();
			redirect('bookmyt/home/');
			
		}
		
		public function edit_business()
		{
			if($this->session->userdata('business_id'))
			{
				if ($this->input->post())
				{
					$id = $this->session->userdata('business_id');
					//$this->load->library('form_validation');
					$this->form_validation->set_rules('business_name', 'Business name', 'required');
					$this->form_validation->set_rules('business_types', 'Business type', 'required');
					$this->form_validation->set_rules('business_email', 'Business email', 'required|edit_unique[business_entity.business_email.'.$id.']');
					//$this->form_validation->set_rules('business_email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('phone_no', 'Phone number', 'required|numeric|min_length[10]|max_length[15]');
					$this->form_validation->set_rules('address', 'Address', 'required');			
					$this->form_validation->set_rules('state', 'State', 'required');
					$this->form_validation->set_rules('b_check', 'Branch confirmation', 'required');
					
					if ($this->form_validation->run() == FALSE)
					{
							$data['userdata'] = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "business_id" => $this->session->userdata('business_id')
							)
						));
						
						$data['business_types'] = $this->bookmyt_model->get_business_types();
						
						$data['zones']          = $this->bookmyt_model->get_zones();
						$data['coutries']  = $this->bookmyt_model->get_countries();			    
						$this->load->view('register/edit_business',$data);
					}
					else
					{
						$business_name    = $this->input->post('business_name');					  
						$business_email     = $this->input->post('business_email');
						$country          = $this->input->post('country');
						$state        = $this->input->post('state');
						$phone_no           = $this->input->post('phone_no');
						$address       = $this->input->post('address');
						$email          = $this->input->post('email');
						$business_typeid = $this->input->post('business_types');
						$time_zone    = $this->input->post('time_zone');
						$have_branches = $this->input->post('b_check');
						
						$system_array   = array(
							'business_name' => $business_name,
							 'business_email' => $business_email,
							 'address' => $address,
							  'phone_no' => $phone_no,
							'state' => $state,
							'country' => $country,
							'time_zone' => $time_zone,
							'business_typeid' => $business_typeid,
							'branch' => 0,
							'have_branches' => $have_branches
						  
						);
						
						
						$result = $this->bookmyt_model->KM_update(array(
						"class" => "business_entity",
						"update" => $system_array
							), array(
							'business_id' => $this->session->userdata('business_id')
							));
						
						$b_check = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'have_branches'
							),
							"conditions" => array(
							  "business_id" => $this->session->userdata('business_id')
							)
						));
							
						$this->session->set_userdata('have_branches',$b_check);
						if($result)
						{
							$this->session->set_flashdata('success',"Business details is updated.");
							redirect('bookmyt/edit_business');
						}
					}
				}
				else
				{
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $this->session->userdata('business_id')
						)
					));
					
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$data['zones']          = $this->bookmyt_model->get_zones();
					$data['coutries']  = $this->bookmyt_model->get_countries();			    
					$this->load->view('register/edit_business',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
			
		}
		
		public function create_business()
		{
			$this->my_business();
		}
		
		public function my_business()
		{
			//pr($this->session->all_userdata());
			if($this->session->userdata('business_id'))				
			{
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $this->session->userdata('business_id')
						)
					));
					
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					//$data['zones']          = $this->bookmyt_model->get_zones1();
					$data['coutries']  = $this->bookmyt_model->get_countries();			    

				if ($this->input->post())
				{ 
					//echo "<pre>"; print_r($this->input->post()); echo "</pre>"; exit;
					$id = $this->session->userdata('business_id');
					//$this->load->library('form_validation');
					$this->form_validation->set_rules('business_name', 'Business Name', 'required');
					$this->form_validation->set_rules('business_types', 'Business Type', 'required');
					//$this->form_validation->set_rules('business_email', 'Business Email', 'required|edit_unique[business_entity.business_email.'.$id.']');
					//$this->form_validation->set_rules('user_name', 'Name', 'required');
					//$this->form_validation->set_rules('phone_no', 'Phone Number', 'required|numeric|min_length[10]|max_length[15]');
					//$this->form_validation->set_rules('address', 'Address', 'required');			
					$this->form_validation->set_rules('state', 'State', 'required');
					//$this->form_validation->set_rules('b_check', 'Branch Confirmation', 'required');
					
					if ($this->form_validation->run() == FALSE)
					{
							$data['userdata'] = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "business_id" => $this->session->userdata('business_id')
							)
						));
						
						$data['business_types'] = $this->bookmyt_model->get_business_types();
						//$data['zones']          = $this->bookmyt_model->get_zones1();
						$data['coutries']  = $this->bookmyt_model->get_countries();			    
						$this->load->view('register/my_business',$data);
					}
					else
					{
						
						$business_details=$data['userdata'];
						$subscription_type=$business_details['subscription_type'];
						if($subscription_type==1){
						}else if($subscription_type==2 || $subscription_type==3){
							$no_of_users=$business_details['no_of_users'];
							$posted_users=$this->input->post('no_of_users');
							if($no_of_users>$posted_users){
								//Degrading the account
								$sub_created_date=date("m-d",strtotime($business_details['created_ts']));
								$cur_date=date('m-d');
								
							}else if($no_of_users<$posted_users){
								//Upgrading the account
							}else{
								// Leaving as it is
							}
							
						}else if($subscription_type==4 || $subscription_type==5){
							$no_of_users=$business_details['no_of_users'];
							$posted_users=$this->input->post('no_of_users');
							if($no_of_users>$posted_users){
								//Degrading the account
							}else if($no_of_users<$posted_users){
								//Upgrading the account
							}else{
								// Leaving as it is
							}
						}
						$business_name    = $this->input->post('business_name');
						// $branch            = $this->input->post('branch');
					  
						$business_email     = $this->input->post('business_email');
						$country          = $this->input->post('country');
						$state        = $this->input->post('state');						
						$city        = $this->input->post('city');
						$zipcode        = $this->input->post('zipcode');
						$phone_no           = $this->input->post('phone_no');
						$address       = $this->input->post('address');
						$email          = $this->input->post('email');
						$business_typeid = $this->input->post('business_types');
						$time_zone    = $this->input->post('time_zone');
						$have_branches = $this->input->post('b_check');
						$reward = $this->input->post('reward');
						
						$system_array   = array(
							'business_name' => $business_name,
							 'business_email' => $business_email,
							 'address' => $address,
							  'phone_no' => $phone_no,							  
							'state' => $state,
							'city' => $city,
							'zipcode' => $zipcode,
							'country' => $country,
							'time_zone' => $time_zone,
							'business_typeid' => $business_typeid,
							'branch' => 0,
							'have_branches' => $have_branches,
							'rewards_bill' => $reward
						  
						);
						
						// echo "<pre>";
							// print_r($system_array);
						// echo "</pre>"; exit;
						$dupNames=$this->bookmyt_model->updateProfile($business_name,$this->session->userdata('business_id'));
						$dupEmail=$this->bookmyt_model->checkEmail($business_email,$this->session->userdata('business_id'));
						$dupPhone=$this->bookmyt_model->checkPhone($phone_no,$this->session->userdata('business_id'));
						if(empty($dupNames) && empty($dupEmail) && empty($dupPhone)){
							$result = $this->bookmyt_model->KM_update(array(
							"class" => "business_entity",
							"update" => $system_array
								), array(
								'business_id' => $this->session->userdata('business_id')
								));
							
							if($result)
							{
								$this->session->set_userdata('business_name',$business_name);
							}
								
							$b_check = $this->bookmyt_model->KM_first(array(
								"class" => "business_entity",
								"fields" => array(
									'have_branches'
								),
								"conditions" => array(
								  "business_id" => $this->session->userdata('business_id')
								)
							));
							
							$this->session->set_userdata('have_branches',$b_check['have_branches']);
							
							if($b_check['have_branches'] == '0')
							{
								$this->bookmyt_model->KM_update(array(
									"class" => "business_entity",
									"update" => array('is_active' => '0')
										), array(
										'relationship_id' => $this->session->userdata('business_id')
										));
									$this->bookmyt_model->KM_update(array(
									"class" => "user_details",
									"update" => array('is_active' => '0')
										), array(
										'relationship_id' => $this->session->userdata('business_id')
										));
							}
							else
							{
								$this->bookmyt_model->KM_update(array(
									"class" => "business_entity",
									"update" => array('is_active' => '1')
										), array(
										'relationship_id' => $this->session->userdata('business_id')
										));
									$this->bookmyt_model->KM_update(array(
									"class" => "user_details",
									"update" => array('is_active' => '1')
										), array(
										'relationship_id' => $this->session->userdata('business_id')
										));
							}
							
							if($result)
							{
								if($this->session->userdata('login_count') == '0' && $this->session->userdata('have_branches')>0)
								{
									$this->session->set_flashdata('success',"Business updated successfully. Create branch for business.");
									$this->session->set_userdata('login_count','');
									redirect('bookmyt/branches');
								}
								else
								{
									$this->session->set_flashdata('success',"Your profile updated successfully.");
									$this->session->set_userdata("time_zone",$this->input->post("time_zone"));
									redirect('bookmyt/my_business');
								}
							}
						}else{
							if(!empty($dupNames)){
								$this->session->set_userdata("fail","Duplicate Business Name");
								$this->load->view('register/my_business',$data);
							}else if(!empty($dupEmail)){
								$this->session->set_userdata("fail","Duplicate Business Email");
								$this->load->view('register/my_business',$data);
							}else if(!empty($dupPhone)){
								$this->session->set_userdata("fail","Duplicate Phone Number");
								//redirect('bookmyt/my_business');
								$this->load->view('register/my_business',$data);
							}
							
						}
					}
				}
				else{
					$this->load->view('register/my_business',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
			
		}
		
		public function Update_business()
		{
			if($this->session->userdata('business_id'))
			{
				$data['userdata'] = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "business_id" => $this->session->userdata('business_id')
					)
				));
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				$data['zones']          = $this->bookmyt_model->get_zones();
				$data['coutries']  = $this->bookmyt_model->get_countries();			    
				$this->load->view('register/edit_business',$data);
			}
			else
			{
				redirect(base_url());
			}
		}
		
		public function admin_dashboard()
		{
		    
			$this->layout = 'admin_layout.php';
			$data['business_info'] = $this->bookmyt_model->dashboard_businesses();
			$this->load->view('dashboard',$data);
		}
		public function request_demo_list()
		{
		    
			$this->layout = 'admin_layout.php';
			$data['business_info'] = $this->bookmyt_model->request_demo_list();
			$this->load->view('request_demo_list',$data);
		}
		
		public function login_action()
		{
			$this->layout = false;	
           $email=$this->input->post('business_email');
			 $password=md5($this->input->post('password'));
			$dashboard = $this->bookmyt_model->business_entity_login($email,$password);		
			//print_r($email);
			$userdata = $this->bookmyt_model->business_entity_user_login($email,$password);	
		
			//pr($userdata);exit;
			if(count($userdata) == 0)
			{
			
				$user_data = $this->bookmyt_model->user_detatails_user_login($email,$password);			
				
				
			}			
			if(count($dashboard) != 0)
			{
				$dashboard['sup'] = 'sup';
				$this->session->set_userdata($dashboard);
				$bbid = $this->session->userdata('business_id');
				$time=date("Y-m-d H:i:s");				
				$sql = "update business_entity set last_login = '$time' where business_id='$bbid'";
				$this->db->query($sql);
				echo "sup_admin";
			}
			else if (count($userdata) != 0) 
			{
				$this->session->set_userdata("log_type","Business");
				$this->session->set_userdata($userdata);
				
				$bbid = $this->session->userdata('business_id');
				$time=date("Y-m-d H:i:s");
				$sql = "update business_entity set last_login = '$time' where business_id='$bbid'";
				$this->db->query($sql);
				
				$tes = $this->bookmyt_model->KM_update(array(
								'class' => "business_entity",
								'update' => array(
									'login_count' => '1'
								)
							), array(
								"business_id" => $this->session->userdata('business_id')
							));
			
				
				$redirect = $this->session->all_userdata();
				
				if(count($redirect) != 0)
				{
					if($redirect['branch'] == '0' || $redirect['branch'] == '')
					{
						if($redirect['login_count'] == '0' && $redirect['login_via']=='1')
						{
							echo $this->session->userdata('business_id');
							$tes1 = $this->bookmyt_model->KM_update(array(
										'class' => "business_entity",
										'update' => array(
											'login_via' => '0'
										)
									), array(
										"business_id" => $this->session->userdata('business_id')
									));
						}else if($redirect['login_count'] == '0' && $redirect['login_via']=='0'){
							echo "business_first";
						}else if($redirect['have_branches'] == '0')
						{
							echo "branch";
						}
						else
						{
							echo "business";
						}
						
					}
					else{
						echo "branch";
					}
				}
			}
			else if(!empty($user_data))
			{
				
				$this->session->set_userdata("log_type","User");
				$this->session->set_userdata($user_data);
				$uuid = $this->session->userdata('user_id');
				$sql = "update user_details set last_login = now() where user_id='$uuid'";
				$this->db->query($sql);
				
				// $this->session->set_userdata('have_branches',$b_check['have_branches']);
				$redirect = $this->session->all_userdata();
				
				if(!empty($redirect))
				{
					if(isset($redirect['user_type_id']) && $redirect['user_type_id'] == 2)
					{
						echo "admin";
					}
					if(isset($redirect['user_type_id']) && $redirect['user_type_id'] == 4)
					{
						echo "user";
					}
					if(isset($redirect['user_type_id']) && $redirect['user_type_id'] == 3)
					{
						echo "editor";
					}
				}
				
			}			
			else
			{
				echo "0";
			}
			/*if($this->session->userdata('business_id'))
			{
			
			            /**$bid=$this->session->userdata('business_id');
						//$sql = "select timezone from business_entity be inner join timezonebyzipcode z on be.time_zone=z.idtimezonebyzipcode where be.business_id='$bid'";
						$qc = $this->db->query($sql);
						$reslt = $qc->result_array();
						
						if(count($reslt) != '0')
						{
							if(isset($reslt[0]['timezone']) && $reslt[0]['timezone'] != '')
							{
							    $userdata=array('zone_name'=>$reslt[0]['timezone']);
								$this->session->set_userdata($userdata);
							}
						}
						else
						{
							$userdata=array('zone_name'=>'Asia/Kolkata');
								$this->session->set_userdata($userdata);
						}	
			
			
			}*/
		}
	
		
		public function branches()
		{
			
			if(!empty($this->permissions))
			{
				if($this->permissions->branch->view == '' || $this->permissions->branch->view == 0)
				{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					
				}
			}
			
			$brn = $this->session->userdata('relationship_id');
			
			if(!empty($brn))
			{
				$this->session->set_flashdata('perm','Access Denied');
				redirect('bookmyt/home/');
			}
			
			if($this->session->userdata('business_id'))
			{
                $url=base_url().'api/business/brancheslist/format/json';
				$post_array=array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id')
				);

				$buffer = $this->load_curl_data($url,$post_array);
				
				if(!empty($this->permissions))
				{
					$data['perms'] = $this->permissions;
				}
				$data['branches'] = json_decode($buffer);
				$this->load->view('branches_list',$data);
			}
			else
			{
				redirect(base_url());
			}
		}
		
		public function edit_branch($business_id=null)
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->branch->edit == '' || $this->permissions->branch->edit == 0)
					{
							$this->session->set_flashdata('perm','Access Denied');
							redirect('bookmyt/home/');
						
					}
				}
				if($this->input->post())
				{
					$id = $this->input->post('business_id');
					$this->form_validation->set_rules('business_name', 'Business name', 'required');
					$this->form_validation->set_rules('business_types', 'Business type', 'required');
					
					
					//$this->form_validation->set_rules('phone_no', 'Business phone number', 'required|numeric|min_length[10]|max_length[15]');
					if($this->input->post('business_email')!=''){
					$this->form_validation->set_rules('business_email', 'Business email', 'required|edit_unique[business_entity.business_email.'.$id.']');
					}
					if($this->input->post('phone_no')!=''){
					$business_id=$this->input->post('business_id');
					$business_data = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $business_id
						)
					));
					$validation_str = '';
					if($business_data['phone_no']!=$this->input->post('phone_no')){
						$validation_str ='|is_unique[business_entity.phone_no]';
					}
					$this->form_validation->set_rules('phone_no', 'Business phone number', 'required|numeric|min_length[10]|max_length[15]'.$validation_str);
					}
					
					if($this->input->post('business_email')=='' && $this->input->post('phone_no')==''){
						$this->form_validation->set_rules('business_email', 'Business email', 'required|edit_unique[business_entity.business_email.'.$id.']');
					}
					//$this->form_validation->set_rules('user_name', 'Name', 'required');
					$this->form_validation->set_rules('state', 'Business state', 'required');
					// $this->form_validation->set_rules('country', 'Country', 'required');
					// $this->form_validation->set_rules('time_zone', 'Time Zone', 'required');
					
					if ($this->form_validation->run() == FALSE)
					{
						$business_id=$this->input->post('business_id');
						$data['business_types'] = $this->bookmyt_model->get_business_types();
					
						$data['userdata'] = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "business_id" => $business_id
							)
						));					
						$this->load->view('register/edit_branch',$data);
					}
					else
					{
					
						$business_id=$this->input->post('business_id');
						$business_name    = $this->input->post('business_name');
						$business_email     = $this->input->post('business_email');
						$phone_no           = $this->input->post('phone_no');
						$dupNames=$this->bookmyt_model->updateProfile($business_name,$business_id);
						$dupEmail=$this->bookmyt_model->checkEmail($business_email,$business_id);
						$dupPhone=$this->bookmyt_model->checkPhone($phone_no,$business_id);
						if(empty($dupNames) && empty($dupEmail) && empty($dupPhone)){					
							$url=base_url().'api/business/edit_branch/format/json';
							$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru');
							$post_array = array_merge($_POST,$arr);
							$buffer = $this->load_curl_data($url,$post_array);
							$buffer=json_decode($buffer);
							
							$data['sucess']=$buffer->success;
							if(!empty($buffer))
							{
								$this->session->set_flashdata('success', 'Branch details updated sucessfully.');
								redirect('bookmyt/branches');
							}
						}else{
						
							if(!empty($dupNames)){
								$this->session->set_flashdata("fail","Duplicate Business Name ");
								redirect('bookmyt/edit_branch/'.$business_id);
							}else if(!empty($dupEmail)){
								$this->session->set_flashdata("fail","Duplicate Business Email");
								redirect('bookmyt/edit_branch/'.$business_id);
							}else if(!empty($dupPhone)){
								$this->session->set_flashdata("fail","Duplicate Phone Number");
								//redirect('bookmyt/my_business');
								redirect('bookmyt/edit_branch/'.$business_id);
							}
							
						}
						
					}
				}
				else
				{
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$data['zones']          = $this->bookmyt_model->get_zones1();
					$data['coutries']  = $this->bookmyt_model->get_countries();
					
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $business_id
						)
					));					
					$this->load->view('register/edit_branch',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
		}
		
		public function edit_my_branch($business_id=null)
		{
			if($this->session->userdata('business_name')=='Admin')
			{
			 $this->layout='admin_layout.php';
			}else{
				$this->layout='default.php';
			}
			if($this->session->userdata('business_id'))
			{
				if($this->input->post())
				{
					$id = $this->input->post('business_id');
					$this->form_validation->set_rules('business_name', 'Business name', 'required');
					//$this->form_validation->set_rules('business_types', 'Business type', 'required');
					if($this->input->post('business_email')!=''){
					$this->form_validation->set_rules('business_email', 'Business Email', 'required|edit_unique[business_entity.business_email.'.$id.']');
					}
					if($this->input->post('phone_no')!=''){
					$business_id=$this->input->post('business_id');
					$business_data = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $business_id
						)
					));
					$validation_str = '';
					if($business_data['phone_no']!=$this->input->post('phone_no')){
						$validation_str ='|is_unique[business_entity.phone_no]';
					}
					$this->form_validation->set_rules('phone_no', 'Business Phone Number', 'required|numeric|min_length[10]|max_length[15]'.$validation_str);
					}
					if($this->input->post('business_email')=='' && $this->input->post('phone_no')=='')
					{
						$this->form_validation->set_rules('business_email', 'Business Email', 'required|edit_unique[business_entity.business_email.'.$id.']');
					}
					
					$this->form_validation->set_rules('address', 'Business address', 'required');
					$this->form_validation->set_rules('state', 'Business state', 'required');
					// $this->form_validation->set_rules('country', 'Country', 'required');
					// $this->form_validation->set_rules('time_zone', 'Time Zone', 'required');
					
					if ($this->form_validation->run() == FALSE)
					{
						$business_id=$this->input->post('business_id');
						$data['business_types'] = $this->bookmyt_model->get_business_types();
						$data['zones']          = $this->bookmyt_model->get_zones();
						$data['coutries']  = $this->bookmyt_model->get_countries();
					
						$data['userdata'] = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "business_id" => $business_id
							)
						));					
						$this->load->view('register/my_branch',$data);
					}
					else
					{
						$business_id=$this->input->post('business_id');
						$business_name    = $this->input->post('business_name');
						$business_email     = $this->input->post('business_email');
						$phone_no           = $this->input->post('phone_no');
						$dupNames=$this->bookmyt_model->updateProfile($business_name,$business_id);
						$dupEmail=$this->bookmyt_model->checkduplicateEmail($business_email,$business_id);
						$dupPhone=$this->bookmyt_model->checkduplicatePhone($phone_no,$business_id);
						if(empty($dupNames) && empty($dupEmail) && empty($dupPhone)){
							$url=base_url().'api/business/edit_branch/format/json';
							$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru');
							$post_array = array_merge($_POST,$arr);
							$buffer = $this->load_curl_data($url,$post_array);
							$buffer=json_decode($buffer);						
							$data['sucess']=$buffer->success;
							
							if(!empty($buffer))
							{
								$data['business_types'] = $this->bookmyt_model->get_business_types();
								$data['zones']          = $this->bookmyt_model->get_zones();
								$data['coutries']  = $this->bookmyt_model->get_countries();
								
								$data['userdata'] = $this->bookmyt_model->KM_first(array(
									"class" => "business_entity",
									"fields" => array(
										'*'
									),
									"conditions" => array(
									  "business_id" => $business_id
									)
								));	
								
								$business_name    = $this->input->post('business_name');
								$this->session->set_userdata('business_name',$business_name);
								
								$this->session->set_flashdata('success', 'Your profile updated sucessfully.');
								redirect("bookmyt/my_branch/".$business_id);
							}
						}else{
							if(!empty($dupNames)){
								$this->session->set_flashdata("fail","Duplicate Business Name");
								redirect("bookmyt/my_branch/".$business_id);
							}else if(!empty($dupEmail)){
								$this->session->set_flashdata("fail","Duplicate Business Email");
								redirect("bookmyt/my_branch/".$business_id);
							}else if(!empty($dupPhone)){
								$this->session->set_flashdata("fail","Duplicate Phone Number");
								//redirect('bookmyt/my_business');
								redirect("bookmyt/my_branch/".$business_id);
							}
						}
					}
				}
				else
				{
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$data['zones']          = $this->bookmyt_model->get_zones();
					$data['coutries']  = $this->bookmyt_model->get_countries();
					
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $business_id
						)
					));					
					$this->load->view('register/my_branch',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
		}
		
		public function my_branch($business_id=null)
		{
			if($this->session->userdata('business_name')=='Admin')
			{
			 $this->layout='admin_layout.php';
			}else{
				$this->layout='default.php';
			}
			if($this->session->userdata('business_id'))
			{
				
				if($this->input->post())
				{
					$id = $this->input->post('business_id');
					$this->form_validation->set_rules('business_name', 'Business Name', 'required');
					$this->form_validation->set_rules('business_types', 'Business Type', 'required');
					if($this->input->post('business_email')!=''){
					$this->form_validation->set_rules('business_email', 'Business Email', 'required|edit_unique[business_entity.business_email.'.$id.']');
					}
					if($this->input->post('phone_no')!=''){
					$business_id=$this->input->post('business_id');
					$business_data = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $business_id
						)
					));
					$validation_str = '';
					if($business_data['phone_no']!=$this->input->post('phone_no')){
						$validation_str ='|is_unique[business_entity.phone_no]';
					}
					$this->form_validation->set_rules('phone_no', 'Business Phone Number', 'required|numeric|min_length[10]|max_length[15]'.$validation_str);
					}
					if($this->input->post('business_email')=='' && $this->input->post('phone_no')=='')
					{
						$this->form_validation->set_rules('business_email', 'Business Email', 'required|edit_unique[business_entity.business_email.'.$id.']');
					}
					$this->form_validation->set_rules('address', 'Business Address', 'required');
					$this->form_validation->set_rules('state', 'Business State', 'required');
					$this->form_validation->set_rules('country', 'Country', 'required');
					$this->form_validation->set_rules('time_zone', 'Time Zone', 'required');
					
					if ($this->form_validation->run() == FALSE)
					{
						$business_id=$this->input->post('business_id');
						$data['business_types'] = $this->bookmyt_model->get_business_types();
						$data['zones']          = $this->bookmyt_model->get_zones();
						$data['coutries']  = $this->bookmyt_model->get_countries();
					
						$data['userdata'] = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "business_id" => $business_id
							)
						));					
						$this->load->view('register/my_branch',$data);
					}
					else
					{
						$business_id=$this->input->post('business_id');
						$url=base_url().'api/business/edit_branch/format/json';
						$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru');
						$post_array = array_merge($_POST,$arr);
						$buffer = $this->load_curl_data($url,$post_array);
						$buffer=json_decode($buffer);
						
						$data['sucess']=$buffer->success;
						if(!empty($buffer))
						{
							$this->session->set_flashdata('success', 'Your profile updated successfully.');
							redirect('bookmyt/my_branch');
						}
					}
				}
				else
				{
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$data['zones']          = $this->bookmyt_model->get_zones1();
					$data['coutries']  = $this->bookmyt_model->get_countries();
					
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $business_id
						)
					));					
					$this->load->view('register/my_branch',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
		}
		
		
		
		
		public function delete_branch($business_id)
		{
		  	if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->branch->delete == '' || $this->permissions->branch->delete == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
				$url=base_url().'api/business/delete_branch/format/json';
				$post_array=array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','business_id'=>$business_id);
				$buffer = $this->load_curl_data($url,$post_array);
				$buffer=json_decode($buffer);
				$this->session->set_flashdata('success',"Branch deleted successfully.");
				redirect('bookmyt/branches');
				
			}
			else
			{
				redirect(base_url());
			}
		}
		
		public function floors()
		{
			if($this->session->userdata('business_id'))
			{
				//echo $this->session->userdata('have_branches');
				if(!empty($this->permissions))
				{
					if($this->permissions->floor->view == '' || $this->permissions->floor->view == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
			    $url=base_url().'api/business/floorslist/format/json';
				$post_array=array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id'),'relationship_id' => $this->session->userdata('relationship_id'),'user_id' => $this->session->userdata('user_id'),'have_brchs'=> $this->session->userdata('have_branches')
				);

				$buffer = $this->load_curl_data($url,$post_array);
				$buffer=json_decode($buffer);
				if(!empty($this->permissions))
				{
					$data['perms'] = $this->permissions;
				}
				$data['floors'] = $this->bookmyt_model->get_floors_list($this->session->userdata('business_id'),$this->session->userdata('have_branches'));
				$this->load->view('floors_list',$data);
			}
			else
			{
				redirect(base_url());
			}
		
		}		
			
		
		public function delete_floor($floor_id)
		{
		  	if($this->session->userdata('business_id'))
			{
			
				if(!empty($this->permissions))
				{
					if($this->permissions->floor->delete == '' || $this->permissions->floor->delete == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
			
				$url=base_url().'api/business/delete_floor/format/json';
				$post_array=array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','floor_id'=>$floor_id);

				$buffer = $this->load_curl_data($url,$post_array);
				$buffer=json_decode($buffer);
				
				if(!empty($buffer))
				{
					$this->session->set_flashdata('success',"Floor deleted successfully.");
					redirect('bookmyt/floors');
				}
			}
			else
			{
				redirect(base_ur());
			}
				
		}
		
		public function tables()
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->floor->view == '' || $this->permissions->floor->view == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
					
				
				$username = 'admin';
				$password = '1234';
				$curl_handle = curl_init();
				curl_setopt($curl_handle, CURLOPT_URL, 'http://123.176.39.59/shop_guard1/api/business/tableslist/format/json');
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl_handle, CURLOPT_POST, 1);
				curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id')
				));
				curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);

				$buffer = curl_exec($curl_handle);
				
				$data['tables'] = json_decode($buffer);
				
				$this->load->view('tables_list',$data);
			}
			else
			{
				redirect(base_url());
			}	
		
		}		
			
		public function edit_table($table_id=null)
		{
			if($this->session->userdata('business_id'))
			{		
			
				if(!empty($this->permissions))
				{
					if($this->permissions->floor->edit == '' || $this->permissions->floor->edit == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				if($this->input->post())
				{
					
					
					$business_id= $this->session->userdata('business_id');
					$data['floors'] = $this->bookmyt_model->get_floors($business_id);	
					$table_id=$this->input->post('table_id');
					$username = 'admin';
					$password = '1234';
					$curl_handle = curl_init();
					curl_setopt($curl_handle, CURLOPT_URL, 'http://123.176.39.59/shop_guard1/api/business/edit_table/format/json');
					$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru');
					$post_data = array_merge($_POST,$arr);
					curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl_handle, CURLOPT_POST, 1);
					curl_setopt($curl_handle, CURLOPT_POSTFIELDS,$post_data);
					 
					// Optional, delete this line if your API is open
					curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
					 //echo "<pre>";
					 $buffer = curl_exec($curl_handle);
					$buffer=json_decode($buffer);				
					$data['sucess']=$buffer->success;
					
					if(!empty($buffer))
					{
						$this->session->set_flashdata('success',"Table updated successfully.");
						redirect('bookmyt/edit_table/'.$table_id);
					}
					
				}
				else
				{
					$business_id= $this->session->userdata('business_id');
					$data['floors'] = $this->bookmyt_model->get_floors($business_id);
			 
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
					"class" => "table_info",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "table_id" => $table_id
					)
					));	
						
					$this->load->view('register/edit_table',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
		}
		
		public function delete_table($table_id)
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->floor->delete == '' || $this->permissions->floor->delete == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
				
				$username = 'admin';
				$password = '1234';
				 $curl_handle = curl_init();
				curl_setopt($curl_handle, CURLOPT_URL, 'http://123.176.39.59/shop_guard1/api/business/delete_table/format/json');
				$post_data = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','table_id'=>$table_id);
				
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl_handle, CURLOPT_POST, 1);
				curl_setopt($curl_handle, CURLOPT_POSTFIELDS,$post_data);
				 
				// Optional, delete this line if your API is open
				curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
				 //echo "<pre>";
				 $buffer = curl_exec($curl_handle);
				$buffer=json_decode($buffer);
				if(!empty($buffer))
				{
					$this->session->set_flashdata('success',"Table deleted successfully.");
					redirect('bookmyt/tables');
				}
			}
			else
			{
				redirect(base_url());
			}
		}	
		
		public function book_table()
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->floor->add == '' || $this->permissions->floor->add == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
				$url=base_url().'api/business/floorslist/format/json';				
				$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id')
				);
				$buffer = $this->load_curl_data($url,$post_array);
				$data['floors'] = json_decode($buffer);
				$this->load->view('register/book_table',$data);
			}
			else
			{
				redirect(base_url());
			}
		}	
		
		public function  savetable()
		{
			if($this->session->userdata('business_id'))
			{
				foreach($_POST as $field_name => $val)
				{
					//clean post values
					$field_userid = strip_tags(trim($field_name));
					$val = strip_tags(trim(mysql_real_escape_string($val)));

					//from the fieldname:user_id we need to get user_id
					$split_data = explode(':', $field_userid);
					$user_id = $split_data[1];
					$field_name = $split_data[0];
					if(!empty($user_id) && !empty($field_name) && !empty($val))
					{
						//update the values
						  $this->bookmyt_model->KM_update(array(
								'class' => "reservation",
								'update' => array(
									$field_name => $val
								)
							), array(
								"reservation_id" => $user_id
							));
						//mysql_query("UPDATE user_details SET $field_name = '$val' WHERE user_id = $user_id") or mysql_error();
						echo "Data Updated";
					} 
					else 
					{
						echo "Invalid Requests";
					}
				}	
			}
			else
			{
				redirect(base_url());
			}
		
		}
		
		// Function changed by leela kumar.
		public function add_reservation()
		{	
			$this->layout = false;
			if($this->session->userdata('business_id'))
			{
				$customer_id=$this->session->userdata('business_id');
				$name=$this->input->post('name');
				$phone_no=$this->input->post('phone_no');
				if($phone_no=='')
				{
					//$phone_no=rand(1111111111,9999999999);
				}
				$time=$this->input->post('in_time');	
				$in_time  = date("H:i:s", strtotime($time));			
				$reltion_id = $this->input->post('rel_id');				
				$business = $this->input->post('business');
                
				$user_id = $this->session->userdata('user_id');
				
				if($reltion_id == "")
				{
					$rel_id = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'relationship_id'
							),
							"conditions" => array(
							  "business_id" => $business
							)
						));
						
					if(count($rel_id) != 0)
					{
						
						if($rel_id['relationship_id'] === NULL)
						{
							$relationship_id = NULL;
						}
						else
						{
							$relationship_id = $rel_id['relationship_id'];
						}
					}
					else if($user_id != '' && $rel_id['relationship_id'] === NULL)
					{
						$relationship_id = NULL;
					}
					else
					{
					}
					
				}			
				else
				{
					$relationship_id = $reltion_id;
				}
				
				$no_members = $this->input->post('members');
				
				$booked_date1=$this->input->post('booked_date');
				$date = date_create($booked_date1);
				$booked_date =  date_format($date, 'Y-m-d');
				$confirmed=0;
				if($this->input->post('date_of_birth')!=''){
				$date_of_birth=$this->input->post('date_of_birth');
				$date_birth = date_create($date_of_birth);
				$date_of_birth =  date_format($date_birth, 'd-M');
				}
				else{
					$date_of_birth = '';
				}
				$business_id=$this->session->userdata('business_id');
				if ($phone_no !='' && $this->bookmyt_model->KM_count(array(
					"class" => "reservation",
					"conditions" => array(
						'phone_no' => $phone_no,
						'booked_date' => $booked_date,
						'status'=>1
					)
				))>0) 
				{
					/*$data = array(
							"status" => false,
							"success" => "Can't Book the table with the same phone number"
						);
						$this->response($data, 200);*/
						echo "Failed";exit;
				}					
				else 
				{	
					if($phone_no!=''){
						$rel_id = $this->bookmyt_model->KM_first(array(
							"class" => "customer",
							"fields" => array(
								'customer_id'
							),
							"conditions" => array(
							  "phone_no" => $phone_no
							)
						));
						if(count($rel_id) != 0)
						{
							 $this->bookmyt_model->KM_update(array(
								'class' => "customer",
								'update' => array(
									'name' => $name,
									'phone_no' => $phone_no
								)
							), array(
								"customer_id" => $rel_id['customer_id']
							));
							$is_new = 0;
							$customer_id = $rel_id['customer_id'];
							$busi_cus = $this->bookmyt_model->KM_first(array(
								"class" => "business_customer",
								"fields" => array(
									'customer_id'
								),
								"conditions" => array(
								  "customer_id" => $customer_id,
								  "business_id" => $business
								)
							));
							if(count($busi_cus) == 0)
							{
								$this->bookmyt_model->KM_save(array(
								'class' => "business_customer",
									'insert' => array(
										'business_id' => $business,
										'customer_id' => $customer_id,
									)
								));
							}
						}else{
							$customer_id = $this->bookmyt_model->KM_save(array(
							'class' => "customer",
								'insert' => array(
									'name' => $name,
									'phone_no' => $phone_no,
								),
								'return_id' => true
							));
							$is_new = 1;
							$this->bookmyt_model->KM_save(array(
							'class' => "business_customer",
								'insert' => array(
									'business_id' => $business,
									'customer_id' => $customer_id,
								)
							));
						}
					}
					else{
						$customer_id = $this->bookmyt_model->KM_save(array(
						'class' => "customer",
							'insert' => array(
								'name' => $name,
								'phone_no' => $phone_no,
							),
							'return_id' => true
						));
						$is_new = 1;
						$this->bookmyt_model->KM_save(array(
						'class' => "business_customer",
							'insert' => array(
								'business_id' => $business,
								'customer_id' => $customer_id,
							)
						));
					}
					$userid = $this->bookmyt_model->KM_save(array(
						'class' => "reservation",
						'insert' => array(
							'customer_id' => $customer_id,
							'name' => $name,
							'phone_no' => $phone_no,
							'in_time' => $in_time,
							'business_id' => $business,
							'table_for' => $no_members,
							 'booked_date' => $booked_date,
							 'date_of_birth' => $date_of_birth,
							'confirmed' => $confirmed,
							'relationship_id'=>$relationship_id,
							'is_new'=>$is_new
						),
						'return_id' => true
					));
						//sms functionality added on 14-04-2016
						$bus_name = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'business_name'
							),
							"conditions" => array(
							  "business_id" => $business
							)
						));
						
						/*$test = "1";
						$username = "visitsats@gmail.com";
						$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
						$username = "am_desai@yahoo.com";
						$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
						$test = "0";
						$sender = urlencode("BMYTBL");*/ 
						$numbers = $phone_no; 
						$message = "We confirm your reservation. Kindly give us some time to make your table ready. Thank you - ". $bus_name['business_name'];
						/*$message = $message;
						$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
						$this->load->library("request_rest");
						$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
						$request_data=array(						
											"mobile_number" => $numbers,
											"message" => $message			
										);
				
						$this->request_rest->setRequestURL($request_url);
						$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
						$this->request_rest->setRequestBody(json_encode($request_data));
						$this->request_rest->setMethod("PUT");
						$result = $this->request_rest->execute();
						
						//sms functionality added on 14-04-2016
					$info = date_create($booked_date); $booked_date1 = date_format($info,'d-M-Y');
					$data1['values'] = array('name' => $name,'phone_no' => $phone_no,'in_time' => $in_time,'booked_date'=>$booked_date1,'date_of_birth'=>$this->input->post('date_of_birth'), 'userid' => $userid,'no_of_mem'=>$no_members);
					//pr($data['values']);exit;
					$this->load->view('load_res_grid',$data1);
				}
			}
			else
			{
				redirect(base_url());
			}
		
		
		}
		
		public function buzz_reservation()
		{
			//echo date_default_timezone_get();exit;
			//pr($this->session->all_userdata());exit;
			if($this->session->userdata('business_id'))
			{
				$table_for=$this->input->post('table_for');
				$table_id=$this->input->post('table_id');
				
				//print_r($table_id);exit;
				//$section_id=$this->input->post('section_id');
				$floor=$this->input->post('floor');
				$reservation_id=$this->input->post('reservation_id');
				/*if($this->session->userdata('time_zone')=='M'){
					//$timezone=""
					$timezne=date_default_timezone_set("MST");
				}else if($this->session->userdata('time_zone')=='P'){
					$timezne=date_default_timezone_set("PST");
				}else if($this->session->userdata('time_zone')=='K'){
					$timezne=date_default_timezone_set("AKST");
				}else if($this->session->userdata('time_zone')=='C'){
					$timezne=date_default_timezone_set("CST");
				}else if($this->session->userdata('time_zone')=='E'){
					$timezne=date_default_timezone_set("EST");
				}else if($this->session->userdata('time_zone')=='A'){
					$timezne=date_default_timezone_set("AST");
				}*/
				time_zone_set($this->session->userdata('time_zone'));
	           //date_default_timezone_set($timezne);
               $ctime =  Date('H:i:s');
			   	$reservation_data = $this->bookmyt_model->KM_first(array(
									"class" => "reservation",
									"fields" => array(
									'*'
									),
									"conditions" => array(
									"reservation_id" => $reservation_id
									)
									));	
				//$tables=explode(",",$table_id);
				if(!empty($table_id)){
					$i=1;
					foreach($table_id as $tab){
						$tab_sec=explode("_",$tab);						
						if($i==1){
							$this->bookmyt_model->KM_update(array(
								'class' => "reservation",
								'update' => array(
								'floor'=>$floor,
								'section_id'=>$tab_sec[1],                                
								'table_id' => $tab_sec[0],
								'booked_date' => date('Y-m-d'),
								'in_time' => $ctime,
								'confirmed'=>1,
								'status'=>1,
								'is_vip' =>($this->input->post('is_vip') !='') ?1:null
								)
								), array(
									"reservation_id" => $reservation_id
								));

						}else{
							$arr=array(
										'floor'					=> $floor,
										'section_id'			=> $tab_sec[1],                                
										'table_id' 				=> $tab_sec[0],
										'customer_id'			=> $reservation_data['customer_id'],
										'name'					=> $reservation_data['name'],
										'phone_no'				=> $reservation_data['phone_no'],
										'table_for'				=> $reservation_data['table_for'],
										'business_id'			=> $this->session->userdata('business_id'),
										'booked_date'			=> date("Y-m-d"),
										'in_time'				=> $ctime,
										'confirmed'				=> 1,
										'status'				=> 1,
										'is_vip' 				=> ($this->input->post('is_vip') !='') ?1:null,
										'parent_reservation'	=> $reservation_id
									);
							$this->db->insert("reservation",$arr);	
						}
						$i++;
					}
				}
				
			//send sms added by raghu
			
		
			//sms functionality added on 14-04-2016
			
			/*$test = "1";
			$username = "visitsats@gmail.com";
			$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
			$username = "dayakarv@toyaja.com";
			$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
			$username = "am_desai@yahoo.com";
			$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
			$test = "0";
			$sender = urlencode("BMYTBL"); */
			$numbers = $reservation_data[0]['phone_no']; 
			$message = "Your reservation is confirmed";
			/*$message = $message;
			$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/

			$this->load->library("request_rest");
			$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
			$request_data=array(						
								"mobile_number" => $numbers,
								"message" => $message			
							);
	
			$this->request_rest->setRequestURL($request_url);
			$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
			$this->request_rest->setRequestBody(json_encode($request_data));
			$this->request_rest->setMethod("PUT");
			$result = $this->request_rest->execute();
			//date_default_timezone_set("Asia/Kolkata");
			//sms functionality added on 14-04-2016
			}
			else
			{
				redirect(base_url());
			}
		
		}
		
		
		public function done_reservation()
		{
			if($this->session->userdata('business_id'))
			{
				$bill_amt=$this->input->post('bil_amt');
				$res_id=$this->input->post('res_id');
				$feedback = $this->input->post('feedback');
										
				$this->bookmyt_model->KM_update(array(
						'class' => "reservation",
						'update' => array(
						'bill_amount' => $bill_amt,
						'feedback' => $feedback,
						'status'=>0
					)
					), array(
						"reservation_id" => $res_id
					));
			}
			else
			{
				redirect(base_url());
			}
		
		}
		
			
		
     	public function reservation()
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->reservation->add == '' || $this->permissions->reservation->add == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
				$url=base_url().'api/business/floorslist/format/json';				
				$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
				'business_id' => $this->session->userdata('business_id')
				);
				$buffer = $this->load_curl_data($url,$post_array);
				$data['floors'] = json_decode($buffer);
				if($this->input->post('sub'))
				{
				$customer_id=$this->session->userdata('business_id');
				$name=$this->input->post('name');
				$phone_no=$this->input->post('phone_no');
				$in_time=$this->input->post('in_time');
				$table_for=$this->input->post('table_for');
				$out_time=$this->input->post('out_time');
				$table_id=$this->input->post('table_id');
				$floor=$this->input->post('floor');
				
				$booked_date=date('Y-m-d');
				$confirmed=0;
				$business_id=$this->session->userdata('business_id');
				$userid = $this->bookmyt_model->KM_save(array(
					'class' => "reservation",
					'insert' => array(
						'customer_id' => $customer_id,
						'name' => $name,
						'phone_no' => $phone_no,
						'in_time' => $in_time,
						'table_for' => $table_for,
						'out_time' => $out_time,
						'table_id' => $table_id,
						'floor'=>$floor,
						'booked_date' => $booked_date,
						'confirmed' => $confirmed,
						'business_id'=>$business_id
					),
					'return_id' => true
				));
				$this->session->set_flashdata('sucess',"Reservation deatils saved sucessfully.");
				redirect('bookmyt/book_table');
				
				}
			}
			else
			{
				redirect(base_url());
			}
				
					
					
				
		}	
		
		 public function edit_reservation($reservation_id=null)
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->reservation->edit == '' || $this->permissions->reservation->edit == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect(base_url());
					}
				}
				$url=base_url().'api/business/floorslist/format/json';				
				$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
				'business_id' => $this->session->userdata('business_id')
				);
				$buffer = $this->load_curl_data($url,$post_array);

				
				$data['floors'] = json_decode($buffer);
				
				if($this->input->post('sub'))
				{			
					$customer_id=$this->session->userdata('business_id');
					$name=$this->input->post('name');
					$phone_no=$this->input->post('phone_no');
					$in_time=$this->input->post('in_time');
					$table_for=$this->input->post('table_for');
					$out_time=$this->input->post('out_time');
					$table_id=$this->input->post('table_id');
					$booked_date=date('Y-m-d');
					$confirmed=1;
					$business_id=$this->session->userdata('business_id');
					$reservation_id=$this->input->post('reservation_id');
					$floor=$this->input->post('floor');
				
					
					$this->bookmyt_model->KM_update(array(
							'class' => "reservation",
							'update' => array(
							'floor'=>$floor,
							'name' => $name,
							'phone_no' => $phone_no,
							'in_time' => $in_time,
							'table_for' => $table_for,
							'out_time' => $out_time,
							'table_id' => $table_id
						)
						), array(
							"reservation_id" => $reservation_id
						));
					$this->session->set_flashdata('sucess',"Reservation deatils updated sucessfully.");
					
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "reservation",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "reservation_id" => $reservation_id
						)
					));	
					redirect('bookmyt/edit_reservation/'.$reservation_id);
					
				}
				else
				{
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "reservation",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "reservation_id" => $reservation_id
						)
					));	
					
					$this->load->view('register/edit_reservation',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
					
				
		}

        public function table_confirm($reservation_id=null)
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->reservation->add == '' || $this->permissions->reservation->add == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect(base_url());
					}
				}
			
				
				$confirmed=1;
				$this->bookmyt_model->KM_update(array(
						'class' => "reservation",
						'update' => array(
						'confirmed'=>$confirmed
					 
					)
					), array(
						"reservation_id" => $reservation_id
					));
				$this->session->set_flashdata('sucess',"Sucessfully table confirmed");
				redirect('bookmyt/reservation_list/');
			}
			else
			{
			redirect(base_url());
			}
			
		}
				
					
					
				
		// Code Changed by leela Kumar	
		public function reservation_list()
		{
			//pr($this->session->all_userdata());
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->reservation->view == '' && $this->permissions->reservation->view == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				$bid = $this->session->userdata('business_id');
				$data['branches'] = $this->bookmyt_model->get_branches($bid);
				$url=base_url().'api/business/reservationlist/format/json';				
				$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id'),
				'user_id' => $this->session->userdata('user_id'),'have_brchs' => $this->session->userdata('have_branches')
				);
				$buffer = $this->load_curl_data($url,$post_array);
		
				$data['reservation_list'] = json_decode($buffer);
				
				//pr($data['reservation_list']);
				$url=base_url().'api/business/reslist/format/json';				
				$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id'),'branch_id' => $this->session->userdata('branch_id'),
					'user_id' => $this->session->userdata('user_id') , 'hb' => $this->session->userdata('have_branches')
				);
				$buffer = $this->load_curl_data($url,$post_array);
				$data['res_list'] = json_decode($buffer);
				//pr($buffer);
				//pr($data['res_list']);
				$url=base_url().'api/business/floorslist/format/json';				
				$post_array =array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id')
				);
				$buffer = $this->load_curl_data($url,$post_array);			
				
				$data['floors'] = json_decode($buffer);
				$bid = $this->session->userdata('business_id');
				$hb = $this->session->userdata('have_branches');
				$data['floors_info'] = $this->bookmyt_model->get_flrs_branches($bid,$hb);
				//pr($data['floors_info']);
				if(!empty($data['floors_info'])){
					$sql =  "call GetAvailableTablesByFloor('".$data['floors_info'][0]['floor_id']."','".date("Y-m-d")."')"; 
					$test = $this->db->query($sql);
					$data['test']=$test->result_array();
				}
				$this->load->view('reservation_list',$data);
			}
			else
			{
				redirect(base_url());
			}
					
				
		}
		
		public function get_flr()
		{
		   $this->layout=false;
			$res_id = $this->input->post('res_id');
			$data['ex_flr'] = $this->bookmyt_model->get_flr($res_id);
			$this->load->view('load_floors',$data);
			
		}
				
				
		public function delete_reservation($reservation_id)
		{
		  
			if($this->session->userdata('business_id'))
			{	
				if(!empty($this->permissions))
				{
					if($this->permissions->reservation->delete == '' || $this->permissions->reservation->delete == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
				$url=base_url().'api/business/delete_reservation/format/json';				
				$post_array =array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','reservation_id'=>$reservation_id);
				$buffer = $this->load_curl_data($url,$post_array);	
				
				$buffer=json_decode($buffer);
				if(!empty($buffer))
				{
					$this->session->set_flashdata('success',"Reservation deleted successfully.");
					redirect('bookmyt/reservation_list');	
				}
			}
			else
			{
				redirect(base_url());
			}
				
		}

		public function delete_reservation1($reservation_id)
		{
		  
			if($this->session->userdata('business_id'))
			{	
				if(!empty($this->permissions))
				{
					if($this->permissions->reservation->delete == '' || $this->permissions->reservation->delete == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
			   $url=base_url().'api/business/delete_reservation/format/json';			
				$post_array =array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','reservation_id'=>$reservation_id);
				$buffer = $this->load_curl_data($url,$post_array);					
				$buffer=json_decode($buffer);
				if(!empty($buffer))
				{
					$this->session->set_flashdata('success',"Reservation deleted successfully.");
					redirect('bookmyt/quick_book');	
				}
			}
			else
			{
				redirect(base_url());
			}
				
		}	
		
		public function can_reservation($reservation_id)
		{
			if($this->session->userdata('business_id'))
			{

				$reservation_data = $this->bookmyt_model->KM_first(array(
				"class" => "reservation",
				"fields" => array(
				'*'
				),
				"conditions" => array(
				"reservation_id" => $reservation_id
				)
				));
				
				$numbers = $reservation_data['phone_no'];
				$url=base_url().'api/business/can_reservation/format/json';			
				$post_array =array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','reservation_id'=>$reservation_id);
				$buffer = $this->load_curl_data($url,$post_array);				
				$buffer=json_decode($buffer);
				
				/*$username = "visitsats@gmail.com";
				$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
				$username = "dayakarv@toyaja.com";
				$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
				$username = "am_desai@yahoo.com";
				$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
				$test = "0";
				$sender = urlencode("BMYTBL"); 	*/			
				$message = "Dear ".$reservation_data['name'].", Your reservation has been cancelled ".$this->session->userdata('business_name').". Visit again. Thank you.";
				/*$message = $message;
				$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
				
				$this->load->library("request_rest");
				$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
				$request_data=array(						
									"mobile_number" => $numbers,
									"message" => $message			
								);
		
				$this->request_rest->setRequestURL($request_url);
				$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
				$this->request_rest->setRequestBody(json_encode($request_data));
				$this->request_rest->setMethod("PUT");
				$result = $this->request_rest->execute();
				//pr($result);exit;
				//echo  $result; exit;
				$res=json_decode($result);
				if($result[0]=="200"){
					$success=1;
				}else{
					$success=0;
				}
				$this->session->set_flashdata('success',"Reservation cancelled successfully.");
				redirect('bookmyt/reservation_list');
			}
			else
			{
				redirect(base_url());
			}
				
		}	
		
        public function get_tables()
		{
			if($this->session->userdata('business_id'))
			{
				$this->layout = false;
				$no_of_members=$this->input->post('no_of_members');				
				$floor_id1=explode("_",$this->input->post('floor_id'));				
				$floor_id=$floor_id1[0];
				$section_id=$floor_id1[1];
				$business_id=$this->session->userdata('business_id');
			    $reservation_id=$this->input->post('reservation_id');
			    $res_edit=$this->input->post('res_edit');
				
					$mem = $this->bookmyt_model->KM_first(array(
							"class" => "reservation",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "reservation_id" => $reservation_id
							)
						));	
				if($no_of_members!='' && $no_of_members!=0){
					$no_of_members = $no_of_members;
				}else{
					$no_of_members = $mem['table_for'];
				}
				//$sql = "call GetAvailableTablesBySeatsAndFloor('".$no_of_members."','".$floor_id."','".$section_id."','".$mem['table_id']."')"; 
				$sql =  "call GetAvailableTablesByFloor('".$floor_id."','".date("Y-m-d")."')"; 
				$test = $this->db->query($sql);
				$data['test']=$test->result_array();		
				$data['table_id']=$mem['table_id'];		
				$data['res_edit']=$res_edit;		
				$data['reservation_id']=$reservation_id;		
				$this->load->view('register/get_tables_list',$data);
			}
			else
			{
				redirect(base_url());
			}			
		}
		public function get_tables_edit()
		{
			if($this->session->userdata('business_id'))
			{
				$this->layout = false;
				$no_of_members=$this->input->post('no_of_members');				
				$floor_id1=explode("_",$this->input->post('floor_id'));				
				$floor_id=$floor_id1[0];
				$section_id=$floor_id1[1];
				$business_id=$this->session->userdata('business_id');
			    $reservation_id=$this->input->post('reservation_id');
			    $res_edit=$this->input->post('res_edit');
				
					$mem = $this->bookmyt_model->KM_first(array(
							"class" => "reservation",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "reservation_id" => $reservation_id
							)
						));	
				$sql="select group_concat(table_id) table_ids from reservation where reservation_id='$reservation_id' or parent_reservation='$reservation_id'";
				$query=$this->db->query($sql);
				$tables=$query->result_array();
				if($no_of_members!='' && $no_of_members!=0){
					$no_of_members = $no_of_members;
				}else{
					$no_of_members = $mem['table_for'];
				}
				//$sql = "call GetAvailableTablesBySeatsAndFloor('".$no_of_members."','".$floor_id."','".$section_id."','".$mem['table_id']."')"; 
				$sql =  "call GetAvailableTablesByFloor('".$floor_id."','".date("Y-m-d")."')"; 
				$test = $this->db->query($sql);
				$data['test']=$test->result_array();		
				$data['table_id']=$tables[0]['table_ids'];		
				$data['res_edit']=$res_edit;		
				$data['reservation_id']=$reservation_id;		
				$this->load->view('register/get_tables_edit',$data);
			}
			else
			{
				redirect(base_url());
			}			
		}

        public function get_tables_quick()
		{
			if($this->session->userdata('business_id'))
			{
				$this->layout = false;
				$no_of_members=$this->input->post('no_of_members');				
				$floor_id=$this->input->post('floor_id');				
				//$floor_id=$floor_id1[0];
				//$section_id=$floor_id1[1];
				$business_id=$this->session->userdata('business_id');
			    //$reservation_id=$this->input->post('reservation_id');
			    //$res_edit=$this->input->post('res_edit');
				
					$mem = $this->bookmyt_model->KM_first(array(
							"class" => "reservation",
							"fields" => array(
								'*'
							),
							"conditions" => array(
							  "reservation_id" => $reservation_id
							)
						));	
				if($no_of_members!='' && $no_of_members!=0){
					$no_of_members = $no_of_members;
				}else{
					$no_of_members = $mem['table_for'];
				}
				$sql = "call GetAvailableTablesByFloor('".$floor_id."','".date("Y-m-d")."')"; 
				$test = $this->db->query($sql);
				$data['test']=$test->result_array();		
				$data['table_id']=$mem['table_id'];		
				$data['res_edit']=$res_edit;	
				$data['no_of_k']=$this->input->post('no_of_k');
				$data['reservation_id']=$reservation_id;		
				$this->load->view('register/get_tables_list_quick',$data);
			}
			else
			{
				redirect(base_url());
			}			
		}
	// Code Added By Leela Kumar.
	public function add_user()
	{
		if($this->session->userdata('business_id'))
		{
			if(!empty($this->permissions))
			{
				if($this->permissions->users->add == '' || $this->permissions->users->add == 0)
				{
					$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
				}
			}
			
		
			if($this->input->post())
			{

				$this->form_validation->set_rules('branch', 'Branch', 'required');
				$this->form_validation->set_rules('username', 'Username', 'required');
				if(!is_numeric($this->input->post('email_phn')))
				{
					$this->form_validation->set_rules('email_phn', 'Email', 'required|valid_email|is_unique[user_details.email]');
				}
				else
				{
					$this->form_validation->set_rules('email_phn', 'Phone number', 'required|numeric|min_length[10]|max_length[15]');
				}
				//$this->form_validation->set_rules('pwd', 'Password', 'required|matches[cpwd]');
				//$this->form_validation->set_rules('cpwd', 'Password Confirmation', 'required');
				$this->form_validation->set_rules('user_type[]', 'User type', 'required');
								
				if ($this->form_validation->run() == FALSE)
				{
					$business_id=$this->session->userdata('business_id');
					$data['branches'] = $this->bookmyt_model->get_branches($business_id);		
					$data['roles'] = $this->bookmyt_model->get_roles();
					$this->load->view('register/add_user',$data);
				}
				else
				{	
					if(is_numeric($this->input->post('email_phn')))
					{
						$this->session->set_flashdata('fail','Now it takes only email.');
						redirect();
					}
					else
					{
						$email = $this->input->post('email_phn');
						$check = $this->bookmyt_model->email_duplicate($email);
						if(!empty($check))
						{
							$this->session->set_flashdata('fail','Email already rgistered for business try another.');
							redirect('bookmyt/add_user/');
						}
						else
						{
							$rel_id = $this->bookmyt_model->KM_first(array(
									"class" => "business_entity",
									"fields" => array(
										'relationship_id'
									),
									"conditions" => array(
									  "business_id" => $this->input->post('branch')
									)
								));	
						
							$username = 'admin';
							$password = '1234';
							$random_pwd = mt_rand(100000, 999999);
							$ip_address=$_SERVER['REMOTE_ADDR'];
							$url=base_url().'api/business/add_user/format/json';$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'rand_pwd' => md5($random_pwd) ,'rel_id' => $rel_id['relationship_id']);
							$post_array = array_merge($this->input->post(),$arr);
							$buffer = $this->load_curl_data($url,$post_array);									
							$buffer=json_decode($buffer);
				
							$user_email = $buffer->email;
							$usid = $buffer->uid; 
							
							
							/*$config = array(
								'protocol' => "smtp",
								//'smtp_host' => "mail.knowledgematrixinc.com",
								'smtp_host' => "mail510.opentransfer.com",
								'smtp_port' => 587,
								'charset' => 'utf-8',
								'smtp_user' => 'info@trugeek.in',
								'smtp_pass' => 'Km!pl!123',
							);	*/
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
							
							$body = "Welcome to Book My T.<br/>Click below link to create new password.<br/><a href='".base_url()."bookmyt/create_user_pwd/".urlencode($usid)."' style='color:blue; font-size:15px'>".base_url()."bookmyt/create_user_pwd/".urlencode($usid)."</a><br/>Your Password is: ".$random_pwd."</br><p>Regards,</p><p>Book My T</p>";
							
							$this->email->from('no-reply@bookmyt.com', 'Book My T');
							$this->email->to($user_email);
							

							$this->email->subject('Create Your New Password');
							$this->email->message($body);
							
							if($this->email->send())
							{
								$this->session->set_flashdata('success','Password sent to user mail.Please check in spam or junk if email not received in inbox.');
								redirect('bookmyt/users/');
							}
							else
							{
								$this->session->set_flashdata('fail','Password not sent to user mail.');
								redirect('bookmyt/users/');
							}
						
						}
					}
				}
			
			}
			else
			{	
				$business_id=$this->session->userdata('business_id');
				$data['branches'] = $this->bookmyt_model->get_branches($business_id);
				$data['roles'] = $this->bookmyt_model->get_roles();
				$this->load->view('register/add_user',$data);	
			}
		}
		else
		{
			redirect(base_url());
		}
	}
		
		public function users()
		{		
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->users->view == '' || $this->permissions->users->view == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
				if($this->input->post())
				{
					$random_pwd = mt_rand(100000, 999999);
					$this->form_validation->set_rules('branch', 'Branch', 'required');
					$this->form_validation->set_rules('username', 'Username', 'required');
					if(strstr($this->input->post('email_phn'),'@'))
					{
						$this->form_validation->set_rules('email_phn', 'Email', 'required|valid_email');
					}
					else
					{
						$this->form_validation->set_rules('email_phn', 'Phone number', 'required|min_length[10]|max_length[15]');
					}
					//$this->form_validation->set_rules('pwd', 'Password', 'required|matches[cpwd]');
					//$this->form_validation->set_rules('cpwd', 'Password Confirmation', 'required');
					$this->form_validation->set_rules('user_type', 'User Type', 'required');
									
					if ($this->form_validation->run() == FALSE)
					{
						$business_id=$this->session->userdata('business_id');
						$data['branches'] = $this->bookmyt_model->get_branches($business_id);		
						$data['roles'] = $this->bookmyt_model->get_roles();
						
						$url=base_url().'api/business/userslist/format/json';				
						$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
							'business_id' => $this->session->userdata('business_id') ,'have_branches' => $this->session->userdata('have_branches')
						);
						$buffer = $this->load_curl_data($url,$post_array);
								
						if(!empty($this->permissions))
						{
							$data['perms'] = $this->permissions;
						}
						$data['vusers'] = json_decode($buffer);
						
						$data['branch_name'] = $this->bookmyt_model->get_branch_name();
						$this->load->view('users_list',$data);
					}
					else
					{	
						$email = $this->input->post('email_phn');
						$check = $this->bookmyt_model->email_duplicate($email);
						$user_check = $this->bookmyt_model->chk_usr_email_duplicate($email);
						if(!empty($check) || !empty($user_check))
						{
							$this->session->set_flashdata('fail','Email or Phone Number already registered for this business, try another.');
							redirect('bookmyt/users/');
						}
						else
						{
							$rel_id = $this->bookmyt_model->KM_first(array(
									"class" => "business_entity",
									"fields" => array(
										'relationship_id','no_of_users'
									),
									"conditions" => array(
									  "business_id" => $this->input->post('branch')
									)
								));	
							$bid=$this->input->post('business_admin');
							$users_count = $this->bookmyt_model->KM_first(array(
									"class" => "business_entity",
									"fields" => array(
										'relationship_id','no_of_users','branch','subscription_type'
									),
									"conditions" => array(
									  "business_id" => $bid
									)
								));	
							$query = $this->db->query("select a.business_id from
(select business_id from user_details where business_id='$bid' or relationship_id='$bid'
union all
select business_id from business_entity where business_id='$bid' or relationship_id='$bid') a");
							$no_of_users=$query->result_array();							
							if($users_count['subscription_type']!=1){
							if(($users_count['subscription_type']==4 || $users_count['subscription_type']==5) && $users_count['branch']==0){
								if(count($no_of_users)<=$users_count['no_of_users']){
									$url=base_url().'api/business/add_user/format/json';	
									$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'rand_pwd' => md5($random_pwd) ,'rel_id' => $rel_id['relationship_id'],'no_of_users' => $rel_id['no_of_users']);
									$post_array = array_merge($this->input->post(),$arr);
									$buffer = $this->load_curl_data($url,$post_array);									
									$buffer=json_decode($buffer);
						
									$user_email = $buffer->email;
									$user_name=$buffer->user_name;
									$usid = $buffer->uid; 
									$business_name=$buffer->business_name;
									$role_name=$buffer->role_name;
									if(strstr($this->input->post('email_phn'),'@'))
									{
									
									$config = array(
										'protocol' => "mail",
										'smtp_host' => "mail.knowledgematrixinc.com",
										//'smtp_host' => "mail510.opentransfer.com",
										'smtp_port' => 587,
										'charset' => 'utf-8',
										'smtp_user' => 'pradeepp@knowledgematrixinc.com',
										'smtp_pass' => 'mac!roni_67',
									);	
								
									$this->load->library('email',$config);
									$this->email->set_mailtype("html");	
									$this->email->set_newline("\r\n");
									
									$body = "<p>Dear ".$user_name.",</p><p>Congratulations, you have been assigned to access the ". $business_name." as ".$role_name."</p><p>To get started using your account, please create your new password by clicking the following link and password.</p><a href='".base_url()."bookmyt/create_user_pwd/".urlencode($usid)."' style='color:blue; font-size:15px'>".base_url()."bookmyt/create_user_pwd/".urlencode($usid)."</a><p>Your Username is: ".$user_email."</p><p>Your Password is: ".$random_pwd."</p>";
									
									$this->email->from('info@bookmyt.in', 'Book My T');
									$this->email->to($user_email);
									
		
									$this->email->subject('Create Your New Password');
									$this->email->message($body);
									$success = $this->email->send();
									}
									else{
										
										$username = "visitsats@gmail.com";
										$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
										$username = "dayakarv@toyaja.com";
										$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
										$username = "am_desai@yahoo.com";
										$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
										$test = "0";
										$sender = urlencode("BMYTBL"); 
										 $numbers = $this->input->post('email_phn'); 
										 $message = "Dear ".$user_name.", you have been assigned to access the ". $business_name." as ".$role_name.". The Password to access your account is: ".$random_pwd.", Your username is: ".$numbers;
										//$message = urlencode($message);
									   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
										
										/*$ch = curl_init('http://api.textlocal.in/send/?');
										curl_setopt($ch, CURLOPT_POST, true);
										curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										 $result = curl_exec($ch); 
										curl_close($ch);
										
										$res=json_decode($result);
										//pr($res);exit;
										if($res->status=="success"){
											$success=1;
										}else{
											$success=0;
										}*/
										$this->load->library("request_rest");
										$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
										$request_data=array(						
															"mobile_number" => $numbers,
															"message" => $message			
														);
								
										$this->request_rest->setRequestURL($request_url);
										$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
										$this->request_rest->setRequestBody(json_encode($request_data));
										$this->request_rest->setMethod("PUT");
										//Disabled in testing purpose
										$result = $this->request_rest->execute();
										$res=json_decode($result);
										if($res){
											$success=1;
										}else{
											$success=0;
										}
									}
									if($success)
									{
										$this->session->set_flashdata('success','Password sent to user '.((strstr($this->input->post('email_phn'),'@')) ? 'mail':'phone'));
										redirect('bookmyt/users/');
									}
									else
									{
										$this->session->set_flashdata('fail','Password not sent to user '.((strstr($this->input->post('email_phn'),'@')) ? 'mail':'phone'));
										redirect('bookmyt/users/');
									}
								}else{
									$this->session->set_flashdata('fail','Please delete the existing users to create new user(s) as user limit got exceeded.');
									redirect('bookmyt/users/');
								}
							
							}else{
								if(count($no_of_users)<$users_count['no_of_users']){
									$url=base_url().'api/business/add_user/format/json';	
									$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'rand_pwd' => md5($random_pwd) ,'rel_id' => $rel_id['relationship_id'],'no_of_users' => $rel_id['no_of_users']);
									$post_array = array_merge($this->input->post(),$arr);
									$buffer = $this->load_curl_data($url,$post_array);									
									$buffer=json_decode($buffer);
						
									$user_email = $buffer->email;
									$user_name=$buffer->user_name;
									$usid = $buffer->uid; 
									$business_name=$buffer->business_name;
									$role_name=$buffer->role_name;
									if(strstr($this->input->post('email_phn'),'@'))
									{
									
									$config = array(
										'protocol' => "smtp",
										'smtp_host' => "mail.knowledgematrixinc.com",
										//'smtp_host' => "mail510.opentransfer.com",
										'smtp_port' => 587,
										'charset' => 'utf-8',
										'smtp_user' => 'pradeepp@knowledgematrixinc.com',
										'smtp_pass' => 'mac!roni_67',
									);	
								
									$this->load->library('email',$config);
									$this->email->set_mailtype("html");	
									$this->email->set_newline("\r\n");
									
									$body = "<p>Dear ".$user_name.",</p><p>Congratulations, you have been assigned to access the ". $business_name." as ".$role_name."</p><p>To get started using your account, please create your new password by clicking the following link and password.</p><a href='".base_url()."bookmyt/create_user_pwd/".urlencode($usid)."' style='color:blue; font-size:15px'>".base_url()."bookmyt/create_user_pwd/".urlencode($usid)."</a><p>Your Username is: ".$user_email."</p><p>Your Password is: ".$random_pwd."</p>";
									
									$this->email->from('info@bookmyt.in', 'Book My T');
									$this->email->to($user_email);
									
		
									$this->email->subject('Create Your New Password');
									$this->email->message($body);
									$success = $this->email->send();
									}
									else{
										
										/*$username = "visitsats@gmail.com";
										$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
										$username = "dayakarv@toyaja.com";
										$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
										$username = "am_desai@yahoo.com";
										$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
										$test = "0";
										$sender = urlencode("BMYTBL"); 
										 $numbers = $this->input->post('email_phn'); 
										 $message = "Dear ".$user_name.", you have been assigned to access the ". $business_name." as ".$role_name.". The Password to access your account is: ".$random_pwd.", Your username is: ".$numbers;
										$message = urlencode($message);
									   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
										
										$ch = curl_init('http://api.textlocal.in/send/?');
										curl_setopt($ch, CURLOPT_POST, true);
										curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										 $result = curl_exec($ch); 
										curl_close($ch);
										
										$res=json_decode($result);*/
										$numbers = $this->input->post('email_phn'); 
										 $message = "Dear ".$user_name.", you have been assigned to access the ". $business_name." as ".$role_name.". The Password to access your account is: ".$random_pwd.", Your username is: ".$numbers;
										$this->load->library("request_rest");
										$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
										$request_data=array(						
															"mobile_number" => $numbers,
															"message" => $message			
														);
								
										$this->request_rest->setRequestURL($request_url);
										$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
										$this->request_rest->setRequestBody(json_encode($request_data));
										$this->request_rest->setMethod("PUT");
										//Disabled in testing purpose
										$result = $this->request_rest->execute();
										$res=json_decode($result);
										//pr($res);exit;
										if($res){
											$success=1;
										}else{
											$success=0;
										}
									}
									if($success)
									{
										$this->session->set_flashdata('success','Password sent to user '.((strstr($this->input->post('email_phn'),'@')) ? 'mail':'phone'));
										redirect('bookmyt/users/');
									}
									else
									{
										$this->session->set_flashdata('fail','Password not sent to user '.((strstr($this->input->post('email_phn'),'@')) ? 'mail':'phone'));
										redirect('bookmyt/users/');
									}
								}else{
									$this->session->set_flashdata('fail','Please delete the existing users to create new user(s) as user limit got exceeded.');
									redirect('bookmyt/users/');
								}
							}
							}else{
									$url=base_url().'api/business/add_user/format/json';	
									$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'rand_pwd' => md5($random_pwd) ,'rel_id' => $rel_id['relationship_id'],'no_of_users' => $rel_id['no_of_users']);
									$post_array = array_merge($this->input->post(),$arr);
									$buffer = $this->load_curl_data($url,$post_array);									
									$buffer=json_decode($buffer);
						
									$user_email = $buffer->email;
									$user_name=$buffer->user_name;
									$usid = $buffer->uid; 
									$business_name=$buffer->business_name;
									$role_name=$buffer->role_name;
									if(strstr($this->input->post('email_phn'),'@'))
									{
									
									$config = array(
										'protocol' => "smtp",
										'smtp_host' => "mail.knowledgematrixinc.com",
										//'smtp_host' => "mail510.opentransfer.com",
										'smtp_port' => 587,
										'charset' => 'utf-8',
										'smtp_user' => 'pradeepp@knowledgematrixinc.com',
										'smtp_pass' => 'mac!roni_67',
									);	
								
									$this->load->library('email',$config);
									$this->email->set_mailtype("html");	
									$this->email->set_newline("\r\n");
									
									$body = "<p>Dear ".$user_name.",</p><p>Congratulations, you have been assigned to access the ". $business_name." as ".$role_name."</p><p>To get started using your account, please create your new password by clicking the following link and password.</p><a href='".base_url()."bookmyt/create_user_pwd/".urlencode($usid)."' style='color:blue; font-size:15px'>".base_url()."bookmyt/create_user_pwd/".urlencode($usid)."</a><p>Your Username is: ".$user_email."</p><p>Your Password is: ".$random_pwd."</p>";
									
									$this->email->from('info@bookmyt.in', 'Book My T');
									$this->email->to($user_email);
									
		
									$this->email->subject('Create Your New Password');
									$this->email->message($body);
									$success = $this->email->send();
									}
									else{
										
										/*$username = "visitsats@gmail.com";
										$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
										$username = "dayakarv@toyaja.com";
										$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
										$username = "am_desai@yahoo.com";
										$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
										$test = "0";
										$sender = urlencode("BMYTBL"); 
										 $numbers = $this->input->post('email_phn'); 
										 $message = "Dear ".$user_name.", you have been assigned to access the ". $business_name." as ".$role_name.". The Password to access your account is: ".$random_pwd.", Your username is: ".$numbers;
										$message = urlencode($message);
									   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
										
										$ch = curl_init('http://api.textlocal.in/send/?');
										curl_setopt($ch, CURLOPT_POST, true);
										curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										 $result = curl_exec($ch); 
										curl_close($ch);
										
										$res=json_decode($result);*/
										$numbers = $this->input->post('email_phn'); 
										$message = "Dear ".$user_name.", you have been assigned to access the ". $business_name." as ".$role_name.". The Password to access your account is: ".$random_pwd.", Your username is: ".$numbers;
										$this->load->library("request_rest");
										$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
										$request_data=array(						
															"mobile_number" => $numbers,
															"message" => $message			
														);
								
										$this->request_rest->setRequestURL($request_url);
										$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
										$this->request_rest->setRequestBody(json_encode($request_data));
										$this->request_rest->setMethod("PUT");
										//Disabled in testing purpose
										$result = $this->request_rest->execute();
										$res=json_decode($result);
										
										//pr($res);exit;
										if($res){
											$success=1;
										}else{
											$success=0;
										}
									}
									if($success)
									{
										$this->session->set_flashdata('success','Password sent to user '.((strstr($this->input->post('email_phn'),'@')) ? 'mail':'phone'));
										redirect('bookmyt/users/');
									}
									else
									{
										$this->session->set_flashdata('fail','Password not sent to user '.((strstr($this->input->post('email_phn'),'@')) ? 'mail':'phone'));
										redirect('bookmyt/users/');
									}
							}							
						}						
					}				
				}
				else
				{	
					$business_id=$this->session->userdata('business_id');
					$data['branches'] = $this->bookmyt_model->get_branches($business_id);
					$data['roles'] = $this->bookmyt_model->get_roles();
					$url=base_url().'api/business/userslist/format/json';				
					$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
						'business_id' => $this->session->userdata('business_id') ,'have_branches' => $this->session->userdata('have_branches')
					);
					$buffer = $this->load_curl_data($url,$post_array);
									
					if(!empty($this->permissions))
					{
						$data['perms'] = $this->permissions;
					}
					$data['vusers'] = json_decode($buffer);	
					
					$data['branch_name'] = $this->bookmyt_model->get_branch_name();
					$this->load->view('users_list',$data);	
				}
				
				
			}
			else
			{
				redirect(base_url());
			}
		
		}
		
		
		public function edit_user($uid)
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->users->edit == '' || $this->permissions->users->edit == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				$url=base_url().'api/business/edit_user/format/json';				
				$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
				'business_id' => $this->session->userdata('business_id'),'user_id' => $uid
				);
				$buffer = $this->load_curl_data($url,$post_array);
				
				$data['user_info'] = json_decode($buffer);			
				$business_id=$this->session->userdata('business_id');
				$data['branches'] = $this->bookmyt_model->get_branches($business_id);
				$data['roles'] = $this->bookmyt_model->get_roles();
				$this->load->view('register/edit_user',$data);
			}
			else
			{
				redirect(base_url());
			}
			
		}
		
		public function my_user($uid)
		{
			if($this->session->userdata('business_id'))
			{
			
				$url=base_url().'api/business/edit_user/format/json';				
				$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id'),'user_id' => $uid
				);
				$buffer = $this->load_curl_data($url,$post_array);
				
				$data['user_info'] = json_decode($buffer);			
				$business_id=$this->session->userdata('business_id');
				$data['branches'] = $this->bookmyt_model->get_branches($business_id);
				$data['roles'] = $this->bookmyt_model->get_roles();
				$this->load->view('register/my_user',$data);
			}
			else
			{
				redirect(base_url());
			}		
		}
		
		public function update_my_user($uid)
		{
			if($this->session->userdata('business_id'))
			{
				// if(!empty($this->permissions))
				// {
					// if($this->permissions->users->edit == '' || $this->permissions->users->edit == 0)
					// {
						// $this->session->set_flashdata('perm','Access Denied');
						// redirect('bookmyt/home/');
					// }
				// }
				$this->form_validation->set_rules('branch', 'Branch', 'required');
				$this->form_validation->set_rules('username', 'Username', 'required');
				$this->form_validation->set_rules('email_phn', 'User email', 'required');
				//$this->form_validation->set_rules('email_phn', 'Email', 'required|valid_email');
				//$this->form_validation->set_rules('user_type', 'User type', 'required');
								
				if ($this->form_validation->run() == FALSE)
				{
					$this->my_user($uid);
				}
				else
				{
					$rel_id = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
						'relationship_id'
						),
						"conditions" => array(
						"business_id" => $this->input->post('branch')
						)
						));	
				$url=base_url().'api/business/update_my_user/format/json';				
				$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'user_id' => $uid , 'prev_pwd' => $pswd ,'rel_id' => $rel_id['relationship_id']);
				$post_array = array_merge($this->input->post(),$arr);
				$buffer = $this->load_curl_data($url,$post_array);
					
					$buffer=json_decode($buffer);
					
					if(!empty($buffer))
					{
						$name = $this->input->post('username');
						$this->session->set_userdata('business_name',$name);
						$this->session->set_flashdata('success',$buffer->success);
						redirect('bookmyt/my_user/'.$uid);
					}
					
				}	
			}
			else
			{
				redirect(base_url());
			}
			
		}
		
		
		public function update_user($uid)
		{
			if($this->session->userdata('business_id'))
			{
				
				$this->form_validation->set_rules('branch', 'Branch', 'required');
				$this->form_validation->set_rules('username', 'Username', 'required');
				if(strstr($this->input->post('email_phn'),'@'))
				{
					$this->form_validation->set_rules('email_phn', 'User Email', 'required|callback_edituser_unique[user_details.email.'.$uid.']');
				}else{
					$this->form_validation->set_rules('email_phn', 'User Phone', 'required|callback_edituser_unique[user_details.phone_no.'.$uid.']');
				}
				//$this->form_validation->set_rules('email_phn', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('user_type', 'User Type', 'required');
								
				if ($this->form_validation->run() == FALSE)
				{
					$this->edit_user($uid);
				}
				else
				{
					$rel_id = $this->bookmyt_model->KM_first(array(
								"class" => "business_entity",
								"fields" => array(
									'relationship_id'
								),
								"conditions" => array(
								  "business_id" => $this->input->post('branch')
								)
							));	
				$url=base_url().'api/business/update_user/format/json';				
				$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'user_id' => $uid , 'prev_pwd' => $pswd,'rel_id' => $rel_id['relationship_id']);					
				$post_array = array_merge($this->input->post(),$arr);
				$buffer = $this->load_curl_data($url,$post_array);		
					$buffer=json_decode($buffer);
					
					if(!empty($buffer))
					{
						$this->session->set_flashdata('success',$buffer->success);
						redirect('bookmyt/users');
					}
					
				}	
			}
			else
			{
				redirect(base_url());
			}
			
		}
		
		public function delete_user($uid)
		{
			if($this->session->userdata('business_id'))
			{
				if(!empty($this->permissions))
				{
					if($this->permissions->users->delete == '' || $this->permissions->users->delete == 0)
					{
						$this->session->set_flashdata('perm','Access Denied');
						redirect('bookmyt/home/');
					}
				}
				
				$url=base_url().'api/business/delete_user/format/json';				
				$post_array = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','user_id' => $uid);
				$buffer = $this->load_curl_data($url,$post_array);		

				$buffer=json_decode($buffer);
		
				if(!empty($buffer))
				{
					$this->session->set_flashdata('success',"User deleted successfully.");
					redirect('bookmyt/users');	
				}
			}
			else
			{
				redirect(base_url());
			}
				
		}

		public function create_pwd($bid)
		{
			$buss_id = urlencode($bid);
			if($this->input->post())
			{	
				$this->load->library('form_validation');
				$this->form_validation->set_rules('old_pwd', 'Old password', 'required');
				$this->form_validation->set_rules('new_pwd', 'New password', 'required|matches[cnf_pwd]');
				$this->form_validation->set_rules('cnf_pwd', 'Confirmation', 'required');
				if ($this->form_validation->run() == FALSE)
				{
					$data['bid'] = $buss_id;
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$this->load->view('register/create_pwd',$data);
				}
				else
				{
					$old = md5($this->input->post('old_pwd'));
					$new = md5($this->input->post('new_pwd'));
					$check = $this->bookmyt_model->pswd_match($buss_id,$old);
					
					if(!empty($check))
					{
					
					
					$url=base_url().'api/business/create_password/format/json';				
					$post_array = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','reservation_id'=>$reservation_id,'business_id' => $buss_id,'new' => $new);
					$buffer = $this->load_curl_data($url,$post_array);
						
						$buffer=json_decode($buffer);
						if(!empty($buffer))
						{
							
							//$this->session->set_flashdata('succ',$buffer->success);
							//redirect('bookmyt/login_action/'.$user['business_email'].'/'.$this->input->post('new_pwd'));
							redirect('bookmyt/home/success');
						}
						
					}
					else
					{
						$this->session->set_flashdata('fail',"You are unable to create password again.");
						redirect('bookmyt/create_pwd/'.$buss_id);	
					}
				}
			}			
			else
			{
				$data['bid'] = $buss_id;
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				$this->load->view('register/create_pwd',$data);
			}
		}
		
		public function create_user_pwd($uid)
		{
			$user_id = urldecode($uid);
			if($this->input->post())
			{	
				$this->load->library('form_validation');
				$this->form_validation->set_rules('old_pwd', 'Old password', 'required');
				$this->form_validation->set_rules('new_pwd', 'New password', 'required|matches[cnf_pwd]');
				$this->form_validation->set_rules('cnf_pwd', 'Confirmation', 'required');
				if ($this->form_validation->run() == FALSE)
				{
					$data['uid'] = $user_id;
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$this->load->view('register/create_user_pwd',$data);
				}
				else
				{
					$old = md5($this->input->post('old_pwd'));
					$new = md5($this->input->post('new_pwd'));
					$check = $this->bookmyt_model->pswd_user_match($user_id,$old);
					
					if(!empty($check))
					{
					$url=base_url().'api/business/create_user_password/format/json';	
					$post_array = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','reservation_id'=>$reservation_id,'user_id' => $user_id,'new' => $new);
					$buffer = $this->load_curl_data($url,$post_array);
						
						$buffer=json_decode($buffer);
						
						if(!empty($buffer))
						{
							//$this->session->set_flashdata('succ',$buffer->success);
							//redirect('bookmyt/create_user_pwd/'.$user_id);
							//redirect('bookmyt/home/');
							redirect('bookmyt/home/success');
						}
						
					}
					else
					{
						$this->session->set_flashdata('fail',"You are unable to create password again.");
						redirect('bookmyt/create_user_pwd/'.$user_id);	
					}
				}
			}
			
			else
			{
				$data['uid'] = $user_id;
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				$this->load->view('register/create_user_pwd',$data);
			}
		}
		
		public function create_branch_pwd($bid)
		{
			$branch_id = urldecode($bid);
			if($this->input->post())
			{	
				//$this->load->library('form_validation');
				
				$this->form_validation->set_rules('old_pwd', 'Old Password', 'required');
				$this->form_validation->set_rules('new_pwd', 'New Password', 'required|matches[cnf_pwd]');
				$this->form_validation->set_rules('cnf_pwd', 'Confirmation', 'required');
				if ($this->form_validation->run() == FALSE)
				{
					$data['uid'] = $branch_id;
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$this->load->view('register/create_branch_pwd',$data);
				}
				else
				{
					$old = md5($this->input->post('old_pwd'));
					$new = md5($this->input->post('new_pwd'));
					$check = $this->bookmyt_model->pswd_branch_match($branch_id,$old);					
					
					if(!empty($check))
					{
						$url=base_url().'api/business/create_branch_password/format/json';	
						$post_array = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','reservation_id'=>$reservation_id,'branch_id' => $branch_id,'new' => $new);
						$buffer = $this->load_curl_data($url,$post_array);
						
						$buffer=json_decode($buffer);
						
						if(!empty($buffer))
						{
							//$this->session->set_flashdata('succ',$buffer->success);
							//redirect('bookmyt/create_branch_pwd/'.$branch_id);
							//redirect('bookmyt/home/');
							redirect('bookmyt/home/success');
						}
						
					}
					else
					{
						$this->session->set_flashdata('fail',"You are unable to create password again.");
						redirect('bookmyt/create_branch_pwd/'.$branch_id);	
					}
				}
			}
			
			else
			{
				$data['uid'] = $branch_id;
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				$this->load->view('register/create_branch_pwd',$data);
			}
		}
			
		public function get_names()
		{
			$this->layout = false;
			$phone = $this->input->post('phone');
			//$bid = $this->input->post('bid');
			$bid = $this->session->userdata('business_id');
			$phone = $this->bookmyt_model->get_names($phone,$bid);
			
			if(!empty($phone) && isset($phone[0]['name']))
			{
				echo json_encode(array('name'=>$phone[0]['name'],'dob'=> (($phone[0]['date_of_birth']!='' && $phone[0]['date_of_birth']!='0000-00-00')) ? date('d-F',strtotime($phone[0]['date_of_birth'])) : '','is_vip'=>($phone[0]['is_vip']!='') ? $phone[0]['is_vip'] : 0));
			}
			else
			{
				echo json_encode(array('name'=>'','dob'=>'','is_vip'=>($phone[0]['is_vip']!='') ? $phone[0]['is_vip'] : 0));
			}		
		}
		
		public function change_password($buss_id)
		{
		
		    if($this->session->userdata('business_name')=='Admin')
			{
			 $this->layout='admin_layout.php';
			}else
			{
			$this->layout='default.php';
			}
			if($this->input->post())
			{	
			
				//$this->load->library('form_validation');
				$this->form_validation->set_rules('old_pwd', 'Old password', 'required');
				$this->form_validation->set_rules('new_pwd', 'New password', 'required|matches[cnf_pwd]');
				$this->form_validation->set_rules('cnf_pwd', 'Confirmation', 'required');
				
				if ($this->form_validation->run() == FALSE)
				{
					$data['bid'] = $buss_id;
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$this->load->view('register/change_password',$data);
				}
				else
				{
				
					$old = md5($this->input->post('old_pwd'));
					$check = $this->bookmyt_model->pswd_match($buss_id,$old);					
					$new = md5($this->input->post('new_pwd'));
					if(!empty($check))
					{
						$set = $this->bookmyt_model->change_password($buss_id,$new);
						if($set == true)
						{
							$this->session->set_flashdata('success',"Your password updated successfully.");
							//redirect('bookmyt/change_password/'.$buss_id);
							redirect('bookmyt/reservation_list/');
						}
									
					}
					else
					{
						$this->session->set_flashdata('fail',"You are unable to change password again.");
						redirect('bookmyt/change_password/'.$buss_id);	
					}
				}
			}			
			else
			{
				$data['bid'] = $buss_id;
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				$this->load->view('register/change_password',$data);
			}
		}
		
		
		public function forgot_password()
		{
			if($this->input->post())
			{				
				$this->form_validation->set_rules('email','Email', 'required');
				
				if ($this->form_validation->run() == FALSE)
				{
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$this->load->view('register/forgot_password',$data);
				}
				else
				{
					$random_pwd = mt_rand(100000, 999999);
					
					$email = $this->input->post('email');
					
						
					/*$config = array(
							'protocol' => "smtp",
							//'smtp_host' => "mail.knowledgematrixinc.com",
							'smtp_host' => "mail510.opentransfer.com",
							'smtp_port' => 587,
							'charset' => 'utf-8',
							'smtp_user' => 'info@trugeek.in',
							'smtp_pass' => 'Km!pl!123',
						);	*/
					$config = array(
								'protocol' => "mail",	
								'smtp_host' => 'mail.knowledgematrixinc.com',
								'smtp_port' => 587,
								'charset' => 'utf-8',
								'smtp_user' => 'pradeepp@knowledgematrixinc.com',
								'smtp_pass' => 'mac!roni_67',
								);	
					
					$check = $this->bookmyt_model->frgt_match($email);
					
					if(count($check) != 0)
					{
					
					
						$user_email = $check[0]['business_email'];
						$usid  = $check[0]['business_id'];
						
						$this->load->library('email',$config);
						$this->email->set_mailtype("html");	

						$success = $this->bookmyt_model->up_busi_pwd($usid,$random_pwd);
						
						if(isset($email) && !is_numeric($email))
						{
						
							$body = "<p>Dear User,</p><p>This email confirms that your password has been changed.</p><p>To access your account, please use the following credentials:</p><p>Username: ".$email."<br/>Password: ".$random_pwd."</p><p>If you have any questions or encounter any problems logging in, please contact a site administrator.</p>";
							
							$this->email->from('info@bookmyt.com', 'Book My T');
							$this->email->to($user_email);
							

							$this->email->subject('Your Password has been changed');
							$this->email->message($body);						
					
							if($this->email->send())
							{
								$this->session->set_flashdata('success',"Your new password is sent to your mail id. Please check in spam or junk if email not received in inbox.");
								redirect('bookmyt/forgot_password/');
							}
							else
							{
								$this->session->set_flashdata('fail',"Problem");
								redirect('bookmyt/forgot_password/');
							}
						}else if(is_numeric($email))
						{
						   //sms functionality added on 14-04-2016
						 	
							/*$test = "1";
							$username = "visitsats@gmail.com";
							$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
							$username = "dayakarv@toyaja.com";
							$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
							$username = "am_desai@yahoo.com";
							$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
							$test = "0";
							$sender = urlencode("BMYTBL"); */
							$numbers = $email; 
							/*$message = "Hi Customer, this is to confirm you that your password has been changed as per your request. Please use the following credentials to access your account Username: ".$email.", Password: ".$random_pwd.'.';*/
							$message="Please use the following credentials to access your account Username: ".$email.", Password: ".$random_pwd.'.';
							/*$message = $message;
							$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/

							$this->load->library("request_rest");
							$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
							$request_data=array(						
												"mobile_number" => $numbers,
												"message" => $message			
											);
					
							$this->request_rest->setRequestURL($request_url);
							$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
							$this->request_rest->setRequestBody(json_encode($request_data));
							$this->request_rest->setMethod("PUT");
							$result = $this->request_rest->execute();
							if($result)
							{
							$this->session->set_flashdata('success',"Password sent to your phone");
							}else
							{
							$this->session->set_flashdata('fail',"Password not sent to your phone.please try later");
							}
							curl_close($ch);
							//sms functionality added on 14-04-2016
						   redirect('bookmyt/forgot_password/');
						}
						
							
						
					}
					
					$user_check = $this->bookmyt_model->user_check($email);
					if(count($user_check) != 0)
					{
						
						$user_email = $user_check[0]['email'];
						$usid  = $user_check[0]['user_id'];
							
						$this->load->library('email',$config);
						$this->email->set_mailtype("html");	
						
						$success = $this->bookmyt_model->up_pwd($usid,$random_pwd);
						if(!empty($success) && !is_numeric($user_check[0]['email']))
						{
						
							//$body = "Welcome To BookMyT.<br/>Your Password Is : ".$random_pwd;
							$body = "<p>Dear User,</p><p>This email confirms that your password has been changed.</p><p>To access your account, please use the following credentials:</p><p>Username: ".$user_email."<br/>Password: ".$random_pwd."</p><p>If you have any questions or encounter any problems logging in, please contact a site administrator.</p>";
							$this->email->from('no-reply@bookmyt.com', 'Book My T');
							$this->email->to($user_email);
							

							$this->email->subject('Your Password has been changed');
							$this->email->message($body);						
					
							if($this->email->send())
							{
								$this->session->set_flashdata('succ',"Your new password is sent to your mail.Please check for spam or junk if email not received in inbox.");
								redirect('bookmyt/forgot_password/');
							}
							else
							{
								$this->session->set_flashdata('fail',"Problem");
								
								redirect('bookmyt/forgot_password/');
							}
						}
                        else
						{
						   //sms functionality added on 14-04-2016
						 	
							/*$test = "1";
							$username = "visitsats@gmail.com";
							$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
							$username = "dayakarv@toyaja.com";
							$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
							$username = "am_desai@yahoo.com";
							$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
							$test = "0";
							$sender = urlencode("BMYTBL");*/ 
							$numbers = $check[0]['business_email']; 
							$message = "Your new Password Is : ".$random_pwd;
							/*$message = $message;
							$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/

							$this->load->library("request_rest");
							$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
							$request_data=array(						
												"mobile_number" => $numbers,
												"message" => $message			
											);
					
							$this->request_rest->setRequestURL($request_url);
							$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
							$this->request_rest->setRequestBody(json_encode($request_data));
							$this->request_rest->setMethod("PUT");
							$result = $this->request_rest->execute();
							if($result)
							{
							$this->session->set_flashdata('success',"Password sent to your phone");
							}else
							{
							$this->session->set_flashdata('fail',"Password sent to your phone.please try later");
							}
							 curl_close($ch);
							 //sms functionality added on 14-04-2016
							 redirect('bookmyt/forgot_password/');
						
						}						
					
					}
					
					if(count($check) == 0 && count($user_check) == 0)
					{
						$this->session->set_flashdata('fail',"Your email/phone number is not found");
						redirect('bookmyt/forgot_password/');
						
					}
					
				}
			
			}			
			else
			{
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				$this->load->view('register/forgot_password',$data);
			}
		}
		
		public function change_user_pd($uid)
		{
			if($this->input->post())
			{	
			
				//$this->load->library('form_validation');
				$this->form_validation->set_rules('old_pwd', 'Old password', 'required');
				$this->form_validation->set_rules('new_pwd', 'New password', 'required|matches[cnf_pwd]');
				$this->form_validation->set_rules('cnf_pwd', 'Confirmation', 'required');
				
				if ($this->form_validation->run() == FALSE)
				{
					$data['uid'] = $uid;
					$data['business_types'] = $this->bookmyt_model->get_business_types();
					$this->load->view('register/change_user_pd',$data);
				}
				else
				{
				
					$old = md5($this->input->post('old_pwd'));
					$check = $this->bookmyt_model->user_pswd_match($uid,$old);					
					$new = md5($this->input->post('new_pwd'));
					if(!empty($check))
					{
						$set = $this->bookmyt_model->change_user_pd($uid,$new);
						if($set == true)
						{
							$this->session->set_flashdata('success',"Your password updated successfully.");
							redirect('bookmyt/reservation_list/');
						}
									
					}
					else
					{
						$this->session->set_flashdata('fail',"Incorrect old password.");
						redirect('bookmyt/change_user_pd/'.$uid);	
					}
				}
			}			
			else
			{
				$data['uid'] = $uid;
				$data['business_types'] = $this->bookmyt_model->get_business_types();
				$this->load->view('register/change_user_pd',$data);
			}
		}
	
		public function tables_arrange()
		{
			$no_of_tables=$_POST['no_of_tables'];
			
			$arr_array  = array();
			if($_POST['no_of_columns']!='' && $_POST['no_of_columns']!=0)
			{
			   $no_of_columns=$_POST['no_of_columns'];
			   if($_POST['no_of_rows']==''){
				$_POST['no_of_rows'] = floor($no_of_tables/$_POST['no_of_columns']);
			   }
			   $no_of_tables=($_POST['no_of_rows'])*($_POST['no_of_columns']);
			}
			else
			{
				$no_of_columns=2;
			
			}
			for( $i = 0; $i < $no_of_tables; $i++ ) 
			{
				$arr_array[$i] = $i+1;
			}
		
			$columns    = $no_of_columns;                                                 
			$amount     = count($arr_array);                                
			$amount_td  = $columns * (ceil( $amount / $columns )) - $amount;  
			$i          = 0;
			$j          = 1;
			$k=1;
			$output='';
			$output.= '<table>
			<tr>';
			$x=1;
			foreach( $arr_array as $key => $value ) 
			{
				if ( $i >= $columns ) {
				$output .= '</tr><tr>';
				$i = 0;
				$x++;
				}
				if ( $j <= $columns ) {
				$class = 'first';
				} else if ( (($amount+$amount_td)-$j) < $columns ) {
				$class = 'last';        
				} else {
				$class = '';
				}
				$n=$i+1;
        
				$output.= '<td><div class="tb rectangle six green" id="change_color_'.$k.'"><span id="change_capacity_'.$k.'" ></span><div class="table-cont" id="change_table_'.$k.'"></div><div class="hover"><a href="javascript:void(0)" id="click_model_'.$k.'" title="'.$x.'" onclick="click_model('.$k.')" data-toggle="modal" data-target="#myModal_'.$k.'"  class="btn btn-xs btn-default mt10"><i class="fa fa-plus" aria-hidden="true"></i></a> <a href="javascript:void(0)"  title="'.$x.'" onclick="delete_table('.$k.')" id="del_'.$k.'" class="btn btn-xs btn-default mt10" style="display:none"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div></div><input type="text" style="display:none" id="click_input_'.$k.'" value="" /><input type="text" style="display:none" value="'.$x.''.$n.'" name="serialno" /></td>
				';
				$i++;
				$j++;
				$k++;
			}
			if(isset($n) && $n != "")
			{
				$y=$n;	
			}
			for( $i = 0; $i < $amount_td; $i++ ) 
			{
				$output.= '<td><div class="tb rectangle six green" id="change_color_'.$y.'"><div class="hover"><a href="javascript:void(0)" id="click_model_'.$y.'" title="'.$x.'" onclick="click_model('.$y.')" data-toggle="modal" data-target="#myModal_'.$k.'"  class="btn btn-sm btn-default"><i class="fa fa-plus" aria-hidden="true"></i></a></div></div><input type="text" style="display:none" id="click_input_'.$k.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="serialno" /></td>';
				// $output.= '<td class="'.$class.'" style="width:50px"><a href="javascript:void(0)"  data-toggle="modal" title="'.$x.'" id="click_model_'.$y.'" onclick="click_model('.$y.')"data-target="#myModal_'.$y.'" class="edittable">Add</a><input type="text" style="display:none" id="click_input_'.$y.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="serialno" /></td>';
				$y++;
			}
			$output .= '</tr>
			</table>';
		   echo $output;
		   exit;
			
		}
		
		public function tables_arrange_edit()
		{
			$floor_id=$_POST['floor_id'];
			$floor_info=$data['floor_info']= $this->bookmyt_model->getfloor_info($floor_id);
			$floor_array=array();
			foreach($floor_info as $floor_info1)
			{
				$floor_array[$floor_info1['serial_no']]=$floor_info1;
			}
			$arr_array  = array();
			$no_of_columns='';
			if($_POST['no_of_columns']!='')
			{
				$no_of_columns=$_POST['no_of_columns'];
				if($_POST['no_of_rows']==''){
					$_POST['no_of_rows'] = floor($_POST['no_of_tables']/$_POST['no_of_columns']);
				}
				$no_of_tables=($_POST['no_of_rows'])*($_POST['no_of_columns']);
			}else{
				$no_of_columns=2;
				$no_of_tables=count($data['floor_info']);		
			}
	    
		if($_POST['no_of_columns']!='')
		{
		$no_of_columns=$_POST['no_of_columns'];
		}else
		
		if(isset($floor_info[0]['floor_columns']) && $floor_info[0]['floor_columns']!='')
		{
		   $no_of_columns=$floor_info[0]['floor_columns'];
		   
		}else
		{
			$no_of_columns=2;
		
		}
		//echo '<prE>'; print_r($floor_info[0]); exit;
		//echo $no_of_tables;exit;
		for( $i = 0; $i < $no_of_tables; $i++ ) {
		$arr_array[$i] = $i+1;
		}
		$columns    = $no_of_columns;                                                 
		 $amount     = count($arr_array);                           
		$amount_td  = $columns * (ceil( $amount / $columns )) - $amount;  
		
		if( $arr_array > $floor_info){
			$cint = count($floor_info);
			for( $i = $cint; $i < count($arr_array); $i++ ) {
				$floor_info[$i] = array();
			}
		}
		else if($arr_array < $floor_info)
		{
			$cint = count($arr_array);
			$cint1 = count($floor_info);
			for( $i = $cint; $i < $cint1; $i++ ) {
				unset($floor_info[$i]);
			}
		}
		//echo '<prE>'; print_r($floor_info); exit;
		$i          = 0;
		$j          = 1;
		$k=1;
		$output='';
		$output.= '<table>
		<tr>';
		$x=1;
	    foreach( $floor_info as $key => $value ) {
		if ( $i >= $columns ) {
		$output .= '</tr><tr>';
		$i = 0;
		$x++;
		}
		if ( $j <= $columns ) {
		$class = 'first';
		} else if ( (($amount+$amount_td)-$j) < $columns ) {
		$class = 'last';        
		} else {
		$class = '';
		}
		$n=$i+1;
		$style1='';
		if(isset($floor_array[$x.''.$n]['table_type']) && $floor_array[$x.''.$n]['table_type']!='')
		{
		 if($floor_array[$x.''.$n]['no_of_seats']>8)
		 {
		 if($floor_array[$x.''.$n]['Booked_Status']==0)
		 {
		 $class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 green';
		 }else
		 {
		 $class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 red';
		 $style1='display:none';
		 }
		 }else
		 {
		 
		   if ($floor_array[$x.''.$n]['no_of_seats'] % 2 == 0) {
				
					if($floor_array[$x.''.$n]['Booked_Status']==0)
		       {
				$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' green'; 
				}else
				{
				$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' red'; 
				$style1='display:none';
				}
				}else
				{
				$number=$floor_array[$x.''.$n]['no_of_seats']+1;
					if($floor_array[$x.''.$n]['Booked_Status']==0)
		       {
				 $class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' green'; 
			   }else
			   {
			    $class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' red'; 
				$style1='display:none';
			   } 
				}
         
		 }
		 $no_of_seats=$floor_array[$x.''.$n]['no_of_seats'];
		  $table_no=$floor_array[$x.''.$n]['table_no'];
		if($no_of_seats!="0" && $no_of_seats > 8)
			$table_no= "Table ".$table_no;
		else if($no_of_seats!="0" && $no_of_seats <= 8)
			$table_no= "Table ".$table_no;
		else
			$table_no= "Table ".$table_no;		 
		 $edit="Edit";
		}else
		{
		$class='tb rectangle six green';
		$no_of_seats='';
		$table_no='';
		$edit='Add';
		}
		
		if($edit == "Edit")
		{
			$style ="";
		}
		else
		{
			$style = 'style="display:none"';
		}
		$edit=(isset($edit) && $edit=="Add")?'<i class="fa fa-plus" aria-hidden="true"></i>':'<i class="fa fa-pencil" aria-hidden="true"></i>';
		
		$output.= '<td><div class="'.$class.'" id="change_color_'.$x.''.$n.'"><span id="change_capacity_'.$x.''.$n.'" >'.$no_of_seats.'</span><div class="table-cont"  id="change_table_'.$x.''.$n.'">'.$table_no.'</div><div class="hover" style="'.$style1.'"><a href="javascript:void(0)" id="click_model_'.$x.''.$n.'" title="'.$x.'" onclick="click_model('.$x.''.$n.')" data-toggle="modal" data-target="#myModal_'.$x.''.$n.'"  class="btn btn-xs btn-default mt03">'.$edit.'</a><a href="javascript:void(0)"  title="'.$x.'" onclick="delete_table('.$x.''.$n.')" id="del_'.$x.''.$n.'" class="btn btn-xs btn-default mt03 " '.$style.'>Delete</a></div></div><input type="text" style="display:none" id="click_input_'.$x.''.$n.'" value="" /><input type="text" style="display:none" value="'.$x.''.$n.'" name="serialno" /></td>
		';
		$i++;
		$j++;
        $k++;
		//echo $i;
		}
		if(isset($n) && $n != "")
		{
			$y=$n;
		}
		for( $i = 0; $i < $amount_td; $i++ ) {
		if(isset($floor_array[$x.''.$y]['table_type']) && $floor_array[$x.''.$y]['table_type']!='')
		{
		 if($floor_array[$x.''.$y]['no_of_seats']>8)
		 {
		 $class='tb '.$floor_array[$x.''.$y]['table_type'].' t8 green';
		 }else
		 {
		 
		   if ($floor_array[$x.''.$y]['no_of_seats'] % 2 == 0) {
				$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$floor_array[$x.''.$y]['no_of_seats'].' green'; 
				}else
				{
				$number=$floor_array[$x.''.$y]['no_of_seats']+1;
				$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$number.' green'; 
				}
         
		 }
		 $no_of_seats=$floor_array[$x.''.$y]['no_of_seats'];
		}else
		{
		$class='tb rectangle six green';
		$no_of_seats='';
		}
		
		$output.= '<td><div class="'.$class.'" id="change_color_'.$y.'">'.$no_of_seats.'<div class="hover"><a href="javascript:void(0)" id="click_model_'.$y.'" title="'.$y.'" onclick="click_model('.$y.')" data-toggle="modal" data-target="#myModal_'.$y.'"  class="btn btn-sm btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a></div></div><input type="text" style="display:none" id="click_input_'.$y.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="serialno" /></td>
		';
		
		
		$y++;
		}
		$output .= '</tr>
		</table>';
       echo $output;
	   exit;
		
		}
     public function getpopup()
	{
		$this->layout=false;
		
		 if($_POST['no_of_columns']!='')
			{
			   $no_of_columns=$_POST['no_of_columns'];
			   $no_of_tables=($_POST['no_of_rows'])*($_POST['no_of_columns']);
			   $data['no_of_tables']=$no_of_tables;
			   $data['floor_id']=$this->input->post('floor_id');
			}else
			{
			 $data['no_of_tables']=$_POST['no_of_tables'];
				$data['floor_id']=$this->input->post('floor_id');
			}
		$this->load->view('register/load_popup',$data);
	
	}
	function table_unique(){
		$this->layout=false;
		$floor_id=$this->input->post('floor_id');
		$table_no=$this->input->post('t_no');
		$data=$this->bookmyt_model->table_unique($floor_id,$table_no);
		if(empty($data)){
			echo "success";
		}else{
			echo "failure";
		}
	}
   public function getpopup_edit()
	{
	$this->layout=false;
	if($_POST['no_of_columns']!='')
	{
	$data['no_of_columns']=$no_of_columns=$_POST['no_of_columns'];
	$no_of_tables=($_POST['no_of_rows'])*($_POST['no_of_columns']);
	$data['no_of_tables']=$no_of_tables;
	}else
	{
	$data['no_of_tables']=$_POST['no_of_tables'];

	}
	$data['no_of_rows']=$_POST['no_of_rows'];
	$floor_id=$_POST['floor_id'];
	$data['floor_info']= $this->bookmyt_model->getfloor_info($floor_id);
	$this->load->view('register/load_popup_edit',$data);
	
	}
 	 function addfloor()
    {
        
		if($this->session->all_userdata())
		{
			$this->layout=false;
			$floor_no = $this->input->post('floor_no');
			$business_id= $this->input->post('business_id');
			$no_of_tables = (int)$this->input->post('no_of_tables');
			$no_of_floors= $this->input->post('no_of_floors');
			$this->load->model('bookmyt_model');
			$tables = $this->input->post('tables');
			$no_of_rows = (int)$this->input->post('no_of_rows');
			$no_of_columns = (int)$this->input->post('no_of_columns');
			//echo '<pre>';print_r($this->input->post());exit;
			
			if($no_of_rows>10)
			{
				echo 'Please enter no of rows less than or equal to 10.';
				exit;
			}
			if($no_of_columns>10)
			{
				echo 'Please enter no of columns less than or equal to 10.';
				exit;
			}
			
			if($no_of_rows == "" || $no_of_rows == '0')
			 {
				 if($no_of_columns !=''){
					$no_of_rows = ceil($no_of_tables/$no_of_columns);
				 }else{
				 $no_of_rows = ceil($no_of_tables/2);
				 }
				
			 }
			 
			
			
			if($no_of_columns == "" || $no_of_columns == "0")
			{
				 if($no_of_rows != ''){
					$no_of_columns = ceil($no_of_tables/$no_of_rows);
				 }else{
					$no_of_columns = 2;
				 }
			}
			
			
			 
			 $table_count=$this->bookmyt_model->KM_count(array(
				"class" => "floor_chart",
				"conditions" => array(
				  "business_id" => $business_id
				)
			));
			
			if ($this->bookmyt_model->KM_count(array(
				"class" => "floor_chart",
				"conditions" => array(
					"floor_no" => $floor_no,
					"business_id" => $business_id
				)
			))) 
			{   
				$this->session->set_flashdata('fail','Duplicate Floor');
				echo 'Duplicate Floor';
				exit;
			} 
			else 
			{
			
				$created_date = date("Y-m-d H:i:s");
				$userid       = $this->bookmyt_model->KM_save(array(
					'class' => "floor_chart",
					'insert' => array(
						'floor_no' => $floor_no,
						'business_id' => $business_id,
						'no_of_tables' => $no_of_tables,
					'floor_rows'=>$no_of_rows,
					'floor_columns'=>$no_of_columns
					),
					'return_id' => true
				));
			  
				if ($userid) 
				{
					$i=0;
					foreach($tables as $table)
					{
				 
						$table       = $this->bookmyt_model->KM_save(array(
						'class' => "table_info",
						'insert' => array(
						'serial_no' => $_POST['serialno'][$i],
						'table_no' => $_POST['table_no'][$i],
						'table_type' => $_POST['table_type'][$i],
						'no_of_seats' => $_POST['tables'][$i],
						'floor_id' => $userid,
						"business_id" => $business_id,
						'image'=>$_POST['images'][$i]
						),
						'return_id' => true
						));
						$i++;
						
					}	
					//$this->__save_to_log($hwid,$userid,0,'register',$created_date);
				   // $this->users_model->KM_save(array("class"=>"userdevice","insert"=>array("userid"=>$userid,"hwid"=>$hwid)));
					$data = array(
						"status" => true,
						"success" => "Floor added successfully",
						"data" => array(
							"Id" => $userid,
							"business_id" => $business_id,
							"floor_no" => $floor_no,
							"Created date" => $created_date
						)
					);
					$this->session->set_flashdata('success',$data['success']);
					echo $data['success'];
				}            
				else 
				{
					$this->response(array(
						"status" => false,
						'error' => 'Not Found'
					), 400);
				}
			}
		}
		else
		{
			redirect(base_url());
		}
		//redirect('bookmyt/floors');
		
    }
		    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( ! isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( ! isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
	function updatefloor()
    {
        
		if($this->session->all_userdata())
		{
			$this->layout=false;
			$floor_no = $this->input->post('floor_no');
			$business_id=$this->input->post('business_id');
			$no_of_tables = $this->input->post('no_of_tables');
			$no_of_floors= $this->input->post('no_of_floors');
			$this->load->model('bookmyt_model');
			$tables = $this->input->post('tables');
			 $no_of_rows = (int)$this->input->post('no_of_rows');
			 $no_of_columns = (int)$this->input->post('no_of_columns');
			if($no_of_rows>10)
			{
				echo 'Please enter no of rows less than or equal to 10.';
				exit;
			}
			if($no_of_columns>10)
			{
				echo 'Please enter no of columns less than or equal to 10.';
				exit;
			}
			 if($no_of_columns =='' && $no_of_columns==0){
				if($no_of_rows!='' && $no_of_rows!=''){
				$no_of_columns = floor($no_of_tables/$no_of_rows);
				}else{
					$no_of_columns = 2;
				}
			 }
			  if($no_of_rows =='' && $no_of_rows==0){
				if($no_of_columns!='' && $no_of_columns!=''){
				$no_of_rows = floor($no_of_tables/$no_of_columns);
				}else{
					$no_of_rows = 2;
				}
			 }
			//echo '<pre>';print_r($_POST['images']);exit;
			$floor_id = $this->input->post('floor_id');

			//print_r( $tables); exit;
				$created_date = date("Y-m-d H:i:s");
				
				$userid = $this->bookmyt_model->KM_update(array(
						'class' => "floor_chart",
						'update' => array(
						'floor_no' => $floor_no,
						'business_id' => $business_id,
						'no_of_tables' => $no_of_tables,
					'floor_rows'=>$no_of_rows,
					'floor_columns'=>$no_of_columns
					)
					), array(
						"floor_id" => $floor_id
					));
			   
			   if ($userid) 
				{
							
					$sql = "select serial_no from table_info where floor_id='$floor_id' order by serial_no";
					$query = $this->db->query($sql);
					$res = $query->result_array();	
					
					$serial_no_values = $this->array_column($res, 'serial_no');				
					$result = array_diff($serial_no_values,$_POST['serialno']);
					sort($result);
					$arr=array();
					foreach($serial_no_values as $serial){
						
						if($no_of_rows<substr($serial,0,1)){
							$arr[]=$serial;
						}
					}
					//if(count($serial_no_values) > count($_POST['serialno']))
					//{
						if(count(arr) != 0)
						{
							$combine = implode(',',$arr);
							if($combine!=""){
								$sql =  "select table_id from table_info where floor_id='$floor_id' and serial_no in(".$combine.")";
								$query = $this->db->query($sql);
								$tab_ids = $query->result_array();
								$tabids = $this->array_column($tab_ids, 'table_id');	
								
								$this->db->where('floor',$floor_id);
								$this->db->where_in('table_id', $tabids);
								$this->db->delete('reservation');
								
								$this->db->where('floor_id',$floor_id);
								$this->db->where_in('serial_no', $result);
								$this->db->delete('table_info');
							}
						}
					//}
					
					
					$i=0;	
					foreach($tables as $table)
					{
		
					   if(count($serial_no_values) != 0 && in_array($_POST['serialno'][$i],$serial_no_values))
					   {
							$this->bookmyt_model->KM_update(array(
									'class' => "table_info",
									'update' => array(
									'table_no' => $_POST['table_no'][$i],
									'table_type' => $_POST['table_type'][$i],
									'no_of_seats' => $_POST['tables'][$i]								
								)
								), array(
									"serial_no" => $_POST['serialno'][$i],
									'floor_id' => $floor_id
								));
								$i++;
						}
					   else
					   {
						
							$this->bookmyt_model->KM_save(array(
								'class' => "table_info",
								'insert' => array(
								'serial_no' => $_POST['serialno'][$i],
								'table_no' => $_POST['table_no'][$i],
								'table_type' => $_POST['table_type'][$i],
								'no_of_seats' => $_POST['tables'][$i],
								'floor_id' => $floor_id,
								"business_id" => $business_id,
								'image'=>$_POST['images'][$i]
								),
								'return_id' => true
								));
								$i++;						
						}				
						
						
					}
					
					//echo "<pre>"; print_r($_POST); exit;

						$data = array(
						"status" => true,
						"success" => "Floor updated successfully",
						"data" => array(
							"Id" => $userid,
							"business_id" => $business_id,
							"floor_no" => $floor_no,
							"Created date" => $created_date
						)
					);
					$this->session->set_flashdata('success',$data['success']);
					echo $data['success'];
				}
				
				else {
					$this->response(array(
						"status" => false,
						'error' => 'Not Found'
					), 400);
				}
		}
		else
		{
			redirect(base_url());
		}		
    }
		
		
		/*public function view_floor($floor_id)
		{
			if($this->session->all_userdata())
			{
				$username = 'admin';
				$password = '1234';
				$curl_handle = curl_init();
				curl_setopt($curl_handle, CURLOPT_URL, 'http://192.168.1.29:98/shop_guard/api/business/tableslist/format/json');
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl_handle, CURLOPT_POST, 1);
				curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id'),
					'floor_id'=>$floor_id
				));
				curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);

				 $buffer = curl_exec($curl_handle);
				
				$data['reservation_list'] = json_decode($buffer);	
				 $username = 'admin';
				$password = '1234';
				$curl_handle = curl_init();
				curl_setopt($curl_handle, CURLOPT_URL, 'http://123.176.39.59/shop_guard1/api/business/floorslist/format/json');
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl_handle, CURLOPT_POST, 1);
				curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
					'business_id' => $this->session->userdata('business_id')
				));
				curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);

				 $buffer = curl_exec($curl_handle);
				
				$data['floors'] = json_decode($buffer);
				$this->load->view('reservation_list',$data);
			}
			else
			{
				redirect(base_url());
			}	
	
		}*/
		public function email_duplicate()
		{
			$this->layout = false;
			$email = $this->input->post('email');
			$check = $this->bookmyt_model->email_duplicate($email);
			if(!empty($check))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
		
		public function get_roles_permission($module='',$perm='')
		{
		
			$user_sess = $this->session->all_userdata();
			if(isset($user_sess['user_type_id']) && !empty($user_sess['user_type_id']))
			{
				$check = $this->bookmyt_model->role_permissions($user_sess['user_type_id']);
				$permissions=json_decode($check[0]['permissions']);
				
				$arr=array();
				foreach($permissions as $key=>$val)
				{
					$arr[$key]=$val;
				}
				echo $arr[$module]->$perm;
			}
		
			
		}
		public function quick_book()
		{

		$url=base_url().'api/business/reslist/format/json';	
		$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
				'business_id' => $this->session->userdata('business_id'),'branch_id' => $this->session->userdata('branch_id'),
				'user_id' => $this->session->userdata('user_id') ,'hb' => $this->session->userdata('have_branches')
			);
		$buffer = $this->load_curl_data($url,$post_array);
			$data['res_list'] = json_decode($buffer);

			$url=base_url().'api/business/floorslist/format/json';	
			$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
			'business_id' => $this->session->userdata('business_id')
			);
			$buffer = $this->load_curl_data($url,$post_array);	
			
			$data['floors'] = json_decode($buffer);
			
			$bid = $this->session->userdata('business_id');
			$hb = $this->session->userdata('have_branches');
			$data['floors_info'] = $this->bookmyt_model->get_flrs_branches($bid,$hb);				
			$this->load->view('quick_book',$data);
		
		}
		
		public function get_table_data()
		{
			$this->layout=false;
			$floor_id=$this->input->post('floor_id');
			$business_id=$this->input->post('business_id');
			$section_id=$this->input->post('section_id');
			$hb = $this->session->userdata('have_branches');
			$select_no_of_members=$this->session->userdata('select_no_of_members');
			$data['floor_id']=$floor_id;
			$data['section_id']=$section_id;
			$data['business_id']=$business_id;
			$query = $this->db->query("call GetAvailableTablesInSections('".$business_id."')");
			$data['floors_info'] = $query->result_array();
			$this->db->reconnect();
			$data['floor_info']= $this->bookmyt_model->getfloor_info($this->input->post('section_id'),$floor_id);
			//echo "call GetAvailableTables('".$business_id."',null,'".$floor_id."')";
			
			//echo "call GetAvailableTablesByFloorId('".$section_id."','".$floor_id."','".date('Y-m-d')."')";exit;
			
			$query = $this->db->query("call GetAvailableTablesByFloorId('".$section_id."','".$floor_id."','".date('Y-m-d')."')");
			/*if($select_no_of_members==''){
				//echo "call GetAvailableTablesByFloorId('".$floor_id."','".date('Y-m-d')."')";
				$query = $this->db->query("call GetAvailableTablesByFloorId('".$floor_id."','".date('Y-m-d')."')");
			}else{
				$query = $this->db->query("call GetAvailableTablesByFloorId('".$floor_id."','".date('Y-m-d')."')");
			}*/	
			
			 $data['available']=$query->result_array();
			 //echo '<pre>';print_r($data['available']); exit;
			$this->load->view('register/get_table_data',$data);  
		
		}
		public function quick_reservation()
		{
		
		    $this->layout=false;
			if($this->session->userdata('business_id'))
			{
				$sub_cat=$this->input->post('sub_cat_data');
				$customer_id=$this->session->userdata('business_id');
				$name=$this->input->post('name');
				$phone_no=$this->input->post('phone_no');
				if($phone_no=='')
				{
				//$phone_no=rand(1111111111,9999999999);
				}
				$timezone=$this->bookmyt_model->getTimeZone($this->input->post('floor'));
				/*if(!empty($timezone)){
					
					time_zone_set($timezone[0]['time_zone']);
				
				}else{
					
					time_zone_set($this->session->userdata("time_zone"));
					
				}*/
				$date = date('Y-m-d');
				
				$time = date("H:i:s");
				//$time = $hour.':'.$second;
				
				$in_time = $time;
				$booked_date = $date;
				$table_id=$this->input->post('table_id');	
				$floor=$this->input->post('floor');	
				
				$sql = "select business_id from floor_chart where floor_id = '$floor'";
				$res = $this->db->query($sql);
				$result = $res->result_array();
				
				$have_brch = $this->session->userdata('have_branches');
				$rel_id = $this->session->userdata('relationship_id');		
				$user_id = $this->session->userdata('user_id');
				$is_vip = $this->input->post('is_vip');
				
				if($this->input->post('dob')!=''){
				$dob=$this->input->post('dob');
				$date_birth = date_create($dob);
				$dob =  date_format($date_birth, 'd-M');
				}
				else{
					$dob = '';
				}
				if($have_brch == '0')
				{
					$business_id = $this->session->userdata('business_id');
					$rel_id == '';
				}
				else
				{
					if(count($result) != 0)
					{
						$business_id = $result[0]['business_id'];
					}
					if($rel_id == '')
					{
						if($user_id != '' && $rel_id == '')
						{
							$rel_id == '';
						}
						else
						{
							$rel_id = $this->session->userdata('business_id');
						}
					}
				}
				
				
				
				$table_for=$this->input->post('table_for');
				$confirmed=1;
				//$business_id=$this->session->userdata('business_id');
				
				
				$floor_business = $this->bookmyt_model->KM_first(array(
							"class" => "floor_chart",
							"fields" => array(
								'business_id'
							),
							"conditions" => array(
							  "floor_id" => $floor
							)
						));	
				if ($phone_no !='' &&  $this->bookmyt_model->KM_count(array(
						"class" => "reservation",
						"conditions" => array(
							'phone_no' => $phone_no,
							'booked_date' => $booked_date,
							'status'=>1
						)
					))>0) 
					{
						/*$data = array(
								"status" => false,
								"success" => "Can't Book the table with the same phone number"
							);
							$this->response($data, 200);*/
							echo "Failed";exit;
					}					
					else 
					{		
						
						if($phone_no!=''){
						$rel_id_cus = $this->bookmyt_model->KM_first(array(
							"class" => "customer",
							"fields" => array(
								'customer_id'
							),
							"conditions" => array(
							  "phone_no" => $phone_no
							)
						));
						if(count($rel_id_cus) != 0)
						{
							 $this->bookmyt_model->KM_update(array(
								'class' => "customer",
								'update' => array(
									'name' => $name,
									//'phone_no' => $phone_no,
								)
							), array(
								"customer_id" => $rel_id_cus['customer_id']
							));
							$is_new = 0;
							$customer_id = $rel_id_cus['customer_id'];
							$busi_cus = $this->bookmyt_model->KM_first(array(
								"class" => "business_customer",
								"fields" => array(
									'customer_id'
								),
								"conditions" => array(
								  "customer_id" => $customer_id,
								  "business_id" => $business_id
								)
							));
							if(count($busi_cus) == 0)
							{
								$this->bookmyt_model->KM_save(array(
								'class' => "business_customer",
									'insert' => array(
										'business_id' => $business_id,
										'customer_id' => $customer_id,
									)
								));
							}
						}else{
							$customer_id = $this->bookmyt_model->KM_save(array(
							'class' => "customer",
								'insert' => array(
									'name' => $name,
									'phone_no' => $phone_no,
								),
								'return_id' => true
							));
							$is_new = 1;
							$this->bookmyt_model->KM_save(array(
							'class' => "business_customer",
								'insert' => array(
									'business_id' => $business_id,
									'customer_id' => $customer_id,
								)
							));
						}
					}
					else{
						$customer_id = $this->bookmyt_model->KM_save(array(
						'class' => "customer",
							'insert' => array(
								'name' => $name,
								'phone_no' => $phone_no,
							),
							'return_id' => true
						));
						$is_new = 1;
						$this->bookmyt_model->KM_save(array(
						'class' => "business_customer",
							'insert' => array(
								'business_id' => $business_id,
								'customer_id' => $customer_id,
							)
						));
					}
						
						if(!empty($sub_cat)){
							$i=1;
							foreach($sub_cat as $subcat){
								if($i==1){
									$sec_tab=explode("_",$subcat);
									$section_id=end($sec_tab);
									$table_id=$sec_tab[0];
									$userid = $this->bookmyt_model->KM_save(array(
										'class' => "reservation",
										'insert' => array(
											'customer_id' => $customer_id,
											'name' => $name,
											'phone_no' => $phone_no,
											'in_time' => $in_time,
											 'booked_date' => $booked_date,
											 'table_for'=>$table_for,
											 'table_id' => $table_id,
											 'section_id'=>$section_id,
											 'floor'=>$floor,
											'confirmed' => $confirmed,
											'business_id'=>$business_id,
											'relationship_id' => $rel_id,
											'is_vip'	=> $is_vip,
											'date_of_birth'	=> $dob,
											'is_new'	=> $is_new,
											'status'=>1
										),
										'return_id' => true
									));
								}else{
									$sec_tab=explode("_",$subcat);
									$section_id=end($sec_tab);
									$table_id=$sec_tab[0];
									$userid1 = $this->bookmyt_model->KM_save(array(
										'class' => "reservation",
										'insert' => array(
											'customer_id' => $customer_id,
											'name' => $name,
											'phone_no' => $phone_no,
											'in_time' => $in_time,
											 'booked_date' => $booked_date,
											 'table_for'=>$table_for,
											 'table_id' => $table_id,
											 'section_id'=>$section_id,
											 'floor'=>$floor,
											'confirmed' => $confirmed,
											'business_id'=>$business_id,
											'relationship_id' => $rel_id,
											'parent_reservation'=>$userid,
											'is_vip'	=> $is_vip,
											'date_of_birth'	=> $dob,
											'is_new'	=> $is_new,
											'status'=>1
										),
										'return_id' => true
									));
								}
								$i++;
							}
						}else{
							$section_id=$this->input->post('section_id');
							$userid = $this->bookmyt_model->KM_save(array(
								'class' => "reservation",
								'insert' => array(
									'customer_id' => $customer_id,
									'name' => $name,
									'phone_no' => $phone_no,
									'in_time' => $in_time,
									 'booked_date' => $booked_date,
									 'table_for'=>$table_for,
									 'table_id' => $table_id,
									 'section_id'=>$section_id,
									 'floor'=>$floor,
									'confirmed' => $confirmed,
									'business_id'=>$business_id,
									'relationship_id' => $rel_id,
									'is_vip'	=> $is_vip,
									'date_of_birth'	=> $dob,
									'is_new'	=> $is_new,
									'status'=>1
								),
								'return_id' => true
							));
						}
						//time_zone_set($this->session->userdata("time_zone"));
					}
			
						
			}
			else
			{
				//echo "hisdhfifh";
				redirect(base_url());
			}
		
		
		}
		public function reports()
		{
			if($this->session->userdata('business_id')){
				$this->load->view("dashboard_view");
			}else{
				redirect(base_url());
			}
		}
		public function feedback_report(){
			if($this->session->userdata('business_id')){
				$bid = $this->session->userdata('business_id');
				$data['feedback_report']=$this->bookmyt_model->getFeedbackReport($bid);
				$this->load->view('feedback_report',$data);
			}else{
				redirect(base_url());
			}
		}
		public function occupancy()
		{
			if($this->session->userdata('business_id'))
			{
				$url=base_url().'api/business/floorslist/format/json';	
				$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
				'business_id' => $this->session->userdata('business_id')
				);
				$buffer = $this->load_curl_data($url,$post_array);	
				
				$data['floors'] = json_decode($buffer);
				$bid = $this->session->userdata('business_id');
				$hb = $this->session->userdata('have_branches');
				$data['floors_info'] = $this->bookmyt_model->get_flrs_branches($bid,$hb);
					
				$this->load->view('occupancy',$data);
				
			}else{
				redirect(base_url());
			}
		}
		public function get_reports_data()
		{
		   $this->layout=false;
			$floor_id=$this->input->post('floor_id');
			$business_id=$this->session->userdata('business_id');
	
			$data['floor_info']= $this->bookmyt_model->getfloor_info($floor_id);
			//echo "call GetAvailableTables('".$business_id."',null,'".$floor_id."')";
			 $query = $this->db->query("call GetAvailableTablesByFloorId('".$floor_id."','".date('Y-m-d')."')");
            

			 $data['available']=$query->result_array();
			//echo '<pre>';print_r($data['available']);exit;
			$this->load->view('register/get_reports_data',$data);  
		
		}
		public function get_occupancy_data()
		{
			$this->layout=false;
			$floor_id=$this->input->post('floor_id');
			$business_id=$this->input->post('business_id');
			$section_id=$this->input->post('section_id');
			$hb = $this->session->userdata('have_branches');
			$data['floor_id']=$floor_id;
			$data['section_id']=$section_id;
			$data['business_id']=$business_id;
			//$data['floors_info'] = $this->bookmyt_model->get_flrs_branches2($business_id,$hb);
			$query = $this->db->query("call GetAvailableTablesInSections('".$business_id."')");
			$data['floors_info'] = $query->result_array();
			$this->db->reconnect();
			$data['floor_info']= $this->bookmyt_model->getfloor_info($this->input->post('section_id'),$floor_id);
			//echo "call GetAvailableTablesByFloorId('".$section_id."','".$floor_id."','".date('Y-m-d')."')";
			$query = $this->db->query("call GetAvailableTablesByFloorId('".$section_id."','".$floor_id."','".date('Y-m-d')."')");
			
			$data['available']=$query->result_array();
			//echo '<pre>';print_r($data['available']);exit;
			$this->load->view('register/get_occupancy_data',$data);  
		
		}
		public function quick_booking_done_details()
		{
				$this->layout=false;
				$url=base_url().'api/business/reslist/format/json';	
				$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
				'business_id' => $this->session->userdata('business_id'),'hb' => $this->session->userdata('have_branches')
				);
				$buffer = $this->load_curl_data($url,$post_array);	
				
				$data['res_list'] = json_decode($buffer);
				$this->load->view('register/load_quick_booking',$data);  
		
		}
		
		public function branches_check()
		{
			$this->layout = false;
			$bid = $this->session->userdata('business_id');
			$res = $this->bookmyt_model->branches_check($bid);
			echo count($res);
		}
		public function get_zones_cc()
		{
			$this->layout = false;
			$code = $this->input->post('c_code');
			$data['t_zones'] = $this->bookmyt_model->get_zones_cc($code);
			$this->load->view('register/load_zones',$data);
		}
		
		public function feedback($rid)
		{
			if($this->session->userdata('business_id'))
			{
				if($this->input->post())
				{	
				
					$bill_no = $this->input->post('bill_no');
					$sql = "select count(bill_no) as bil_cnt from reservation where find_in_set(bill_no,'$bill_no')";
					$query = $this->db->query($sql);
					$res = $query->result_array();
					if($res[0]['bil_cnt'] != 0)
					{
						$this->session->set_flashdata('fail','Bill number should be unique.');
						redirect('bookmyt/feedback/'.$rid);
					}
					
					$res_id = $rid;
					$dining = $this->input->post('dining_type');
					
					$bill_amt=$this->input->post('bill_amt');
					$tab_no = $this->input->post('tab_no');
					$stew = $this->input->post('stew');
					$c_name = $this->input->post('c_name');
					$c_phn = $this->input->post('c_phn');
					if($this->input->post('date_of_birth')!=''){
						$date_of_birth=$this->input->post('date_of_birth');
						$date_birth = date_create($date_of_birth);
						$date_of_birth =  date_format($date_birth, 'd-M');
					}
					else{
						$date_of_birth = '';
					}
					$food = array('quality' => $this->input->post('quality') ,
									'presentation' => $this->input->post('presentation') ,
									'taste' => $this->input->post('taste'));
									
					$food_fb = json_encode($food);
					$service = array('promptness' => $this->input->post('promptness') ,
									'courtesy' => $this->input->post('courtesy') ,
									'competence' => $this->input->post('competence'));
					$service_fb = json_encode($service);
				
				
					$spl_rem = $this->input->post('spl_rem');
							
					$succ = $this->bookmyt_model->KM_update(array(
							'class' => "reservation",
							'update' => array(
							'type_of_dining' => $dining,
							'bill_no' => $bill_no,
							'bill_amount' => $bill_amt,
							'steward' => $stew,
							'name' => $c_name,
							'phone_no' => $c_phn,
							'feedback_on_food' => $food_fb,
							'feedback_on_service' => $service_fb,
							'special_remarks' => $spl_rem,
							'status'=>0,
							'phone_status' => 0,
							'date_of_birth' => $date_of_birth
						)
						), array(
							"reservation_id" => $res_id
						));
					$this->bookmyt_model->KM_update(array(
							'class' => "reservation",
							'update' => array(
							'type_of_dining' => $dining,
							'bill_no' => $bill_no,
							'bill_amount' => $bill_amt,
							'steward' => $stew,
							'name' => $c_name,
							'phone_no' => $c_phn,
							'feedback_on_food' => $food_fb,
							'feedback_on_service' => $service_fb,
							'special_remarks' => $spl_rem,
							'status'=>0,
							'phone_status' => 0,
							'date_of_birth' => $date_of_birth
						)
						), array(
							"parent_reservation" => $res_id
						));	
					if($succ)
					{
						$buss_id = $this->session->userdata('business_id');
						if(!empty($this->session->userdata('relationship_id'))){
						$buss_id = $this->session->userdata('relationship_id');
						}
						$res_data = $this->bookmyt_model->KM_first(array(
							"class" => "reservation",
							"fields" => array(
								'customer_id'
							),
							"conditions" => array(
							 "reservation_id" => $res_id
							)
						));
						if(!empty($res_data['customer_id'])){
						$business_data = $this->bookmyt_model->KM_first(array(
							"class" => "business_entity",
							"fields" => array(
								'rewards_bill'
							),
							"conditions" => array(
							 "business_id" => $buss_id
							)
						));
						$feedback_id = $this->bookmyt_model->KM_save(array(
						'class' => "reward_point_history",
							'insert' => array(
								'customer_id' => $res_data['customer_id'],
								'business_id' => $buss_id,
								'rewards' => round($bill_amt/$business_data['rewards_bill'],2),
								'bill' => $bill_amt,
								'date' => date('Y-m-d H:i:s'),
								'res_id' => $res_id
							),'return_id' => true
						));
						$numbers=$this->input->post('c_phn');
						$message="Thank You, We Appreciate your valuable feedback.";
						if(round($bill_amt/$business_data['rewards_bill'],2)>0){
							$message.="Congratulations! Your earned rewards points: ".round($bill_amt/$business_data['rewards_bill'],2);
						}
						$this->load->library("request_rest");
						$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
						$request_data=array(						
											"mobile_number" => $numbers,
											"message" => $message			
										);
				
						$this->request_rest->setRequestURL($request_url);
						$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
						$this->request_rest->setRequestBody(json_encode($request_data));
						$this->request_rest->setMethod("PUT");
						//Disabled in testing purpose
						$result = $this->request_rest->execute();
						$res=json_decode($result);
						$this->session->set_flashdata('success',"Billing is done");
						redirect('bookmyt/feedback_done/'.$feedback_id);
						}
						$this->session->set_flashdata('success',"Billing is done");
						redirect('bookmyt/reservation_list/');
					}
			
				}
				else
				{
					$data['rid'] = $rid;
					if($this->session->userdata('user_id') && $this->session->userdata('user_id'))
					{
						$uid = $this->session->userdata('user_id');
						$data['steward'] = $this->bookmyt_model->u_name($uid);
					}
					else
					{
						$bid = $this->session->userdata('business_id');
						$data['steward'] = $this->bookmyt_model->b_name($bid);
					}
					$data['bill_info'] = $this->bookmyt_model->get_res_info($rid);
					$buss_id = $this->session->userdata('business_id');
					if(!empty($this->session->userdata('relationship_id'))){
					$buss_id = $this->session->userdata('relationship_id');
					}
					$data['promocode']=$this->bookmyt_model->getPromocode($data['bill_info'][0]['phone_no'],$buss_id);
					$data['reward_info'] = $this->bookmyt_model->get_rewards_info($data['bill_info'][0]['customer_id'], $buss_id);
					if(empty($data['bill_info'][0]['customer_id'])){
					$data['reward_info'] = 0;
					}
					$this->load->view('feedback',$data);
				}
			}
			else
			{
				redirect(base_url());
			}
			
		}
		
		
		function get_bill_info()
		{
			$this->layout = false;
			$res_id = $this->input->post('res_id');
		}
		
		function b_dup()
		{
			$this->layout = false;
			$bem = $this->input->post('business_email');
			$data = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_email" => $bem
				)
			));
			if(count($data) != 0)
			{
				echo "1";
			}
		}
		
		function name_verify()
		{
			$this->layout = false;
			$bid = $this->session->userdata('business_id');
			$phone = $this->input->post('phone_no');
			$name = $this->input->post('name');
			$sql = "select name from reservation where phone_no = '$phone' and (business_id='$bid' or relationship_id='$bid'";
			$query = $this->db->query($sql);
			$res = $query->result_array();
			print_r($res);
		}
		
		function bill_no_unique()
		{
			$this->layout = false;
			$bill_no = explode(",",$this->input->post('bill_num'));
			$cnt=array();
			if(!empty($bill_no)){
				foreach($bill_no as $bill){
					$sql = "select count(bill_no) as bil_cnt from reservation where find_in_set('$bill',bill_no)";			
					$query = $this->db->query($sql);
					$res = $query->result_array();
					if(!empty($res)){
						$cnt[]=$res[0]['bil_cnt'];
					}
				}
			}
			if(!empty($cnt)){
				foreach($cnt as $ct){
					if($ct!=0){
						echo $ct;exit;
					}else{
						echo "0";
					}
				}
			}
		}
		
	public function export()
	{		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Business_details');
		
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'Business Details');
		
		$this->excel->getActiveSheet()->setCellValue('A3', 'Business id');
		$this->excel->getActiveSheet()->setCellValue('B3', 'Registered date');
		$this->excel->getActiveSheet()->setCellValue('C3', 'Registered time');
		$this->excel->getActiveSheet()->setCellValue('D3', 'Business Name');
		$this->excel->getActiveSheet()->setCellValue('E3', 'Business Email');
		$this->excel->getActiveSheet()->setCellValue('F3', 'Subscription type');
		$this->excel->getActiveSheet()->setCellValue('G3', 'Subscription end');
		
	
		
		
		//merge cell A1 until G1
		$this->excel->getActiveSheet()->mergeCells('A1:G1');
	
		
		//set aligment to center for that merged cell (A1 to J1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
	
		
		
		
		
		for($col = ord('A'); $col <= ord('H'); $col++)
		{
			//set column dimension
			$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
			//$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
			
			 
			 //change the font size
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
			 
			// $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		
		//retrive contries table data
		//$rs = $this->db->get('products');
		$sql ="select business_id,date(created_ts) as 'RegDate',time(created_ts) as 'RegTime',business_name,if(business_email<>'',business_email,phone_no)business_email,
case when subscription_type = 0 then 'Free' else '' 
end as subscription_type,
DATE_ADD(date(created_ts), INTERVAL 3 MONTH) as 'SubscriptionEnd'  
from business_entity where branch='0' and is_admin is null
order by created_ts";
		$query = $this->db->query($sql);
			
		$exceldata="";
		foreach ($query->result_array() as $row)
		{
				$exceldata[] = $row;
		}
		
		// echo "<pre>";
			// print_r($exceldata);
		// echo "</pre>"; exit;
		
	   //Fill data 
		$this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
		 
		// $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// 
		 
		$filename='business_details.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		  exit;      
	}
	function check_time_zone()
		{
	$this->layout=false;
	echo $this->session->userdata('zone_name');
	date_default_timezone_set("Asia/Dubai");
     echo $time =  Date('Y-m-d h:i:s');
	 exit;
	}
	function connect_with_us()
    { 
	    $this->layout=false;
		$mobile = $this->input->post('mobile');
		$name = $this->input->post('name');
		$res_name = $this->input->post('res_name');
		$userid = $this->bookmyt_model->KM_save(array(
		'class' => "contact_list",
		'insert' => array(
			
			'name' => $name,
			'mobile' => $mobile,
			'email' => $res_name,
			'contact_type' => 'Connect With Us',
			'added_date'=>date('Y-m-d')
		),
		'return_id' => true
		));
		$to='satishk@toyaja.com';
		/*$config = array(
		'protocol' => "smtp",
		//'smtp_host' => "mail.knowledgematrixinc.com",
		'smtp_host' => "mail510.opentransfer.com",
		'smtp_port' => 587,
		'charset' => 'utf-8',
		'smtp_user' => 'info@trugeek.in',
		'smtp_pass' => 'Km!pl!123',
		);	*/
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

		$body = "<p>Connect with us Enquiry Details</p>
		<p>Name:".$name."<br/>
		Restaurant Name:".$name."<br/>
		Phone:".$mobile."<br/></p>";

		$this->email->from('no-reply@bookmyt.com', 'Book My T');
		$this->email->to($to);


		$this->email->subject('Connect with us Enquiry Details');
		$this->email->message($body);
		if($this->email->send())
		{
		 echo '1';
		 exit;
		}
       
     }	
	 
	 	function request_demo()
    { 
	    $this->layout=false;
		$mobile = $this->input->post('mobile');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$to='satishk@toyaja.com';
		/*$config = array(
		'protocol' => "smtp",
		//'smtp_host' => "mail.knowledgematrixinc.com",
		'smtp_host' => "mail510.opentransfer.com",
		'smtp_port' => 587,
		'charset' => 'utf-8',
		'smtp_user' => 'info@trugeek.in',
		'smtp_pass' => 'Km!pl!123',
		);*/
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
        $userid = $this->bookmyt_model->KM_save(array(
					'class' => "contact_list",
					'insert' => array(						
						'name' => $name,
						'mobile' => $mobile,
						'email' => $email,
						'contact_type' => 'Request For demo',
						'added_date'=>date('Y-m-d')
					),
					'return_id' => true
				));
		$body = "<p>Demo Request Details</p>
		<p>Name:".$name."<br/>
		Restaurant Name:".$name."<br/>
		Phone:".$mobile."<br/></p>";

		$this->email->from('no-reply@bookmyt.com', 'Book My T');
		$this->email->to($to);


		$this->email->subject('Demo Request Details');
		$this->email->message($body);
		if($this->email->send())
		{
		 echo '1';
		 exit;
		}
       
     }
     function search_locations()
    {
     $this->layout=false;
	 $string = $this->input->post('string');
	 $data['locations'] = $this->bookmyt_model->search_locations($string);
	 $this->load->view('search_locations_list',$data);
    }	
	function edituser_unique($value, $params)
    {
        //$this->set_message('edituser_unique', "This %s is already in use!");
		$this->form_validation->set_message('edituser_unique', 'This %s is already in use!');
        list($table, $field, $current_id) = explode(".", $params);
        $result = $this->db->where($field, $value)->get($table)->row();
        return ($result && $result->user_id != $current_id) ? FALSE : TRUE;
    }
	
	public function buzz_msg()
	{
	   $this->layout=false;
		$res_id = $this->input->post('res_id');
		
		/*$test = "1";
		$username = "visitsats@gmail.com";
		$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
		$username = "dayakarv@toyaja.com";
		$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
		$username = "am_desai@yahoo.com";
		$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
		$test = "0";
		$sender = urlencode("BMYTBL"); */
		$mem = $this->bookmyt_model->KM_first(array(
					"class" => "reservation",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "reservation_id" => $res_id
					)
				));
		$bus_name = $this->bookmyt_model->KM_first(array(
			"class" => "business_entity",
			"fields" => array(
				'business_name'
			),
			"conditions" => array(
			  "business_id" => $mem['business_id']
			)
		));
		
		$numbers = $mem['phone_no']; 
		$message = "Dear ".$mem['name'].", Your table is ready. Happy dining! Thank you - ". $bus_name['business_name'];
		/*$message = $message;
		$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/

		$this->load->library("request_rest");
		$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
		$request_data=array(						
							"mobile_number" => $numbers,
							"message" => $message			
						);

		$this->request_rest->setRequestURL($request_url);
		$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
		$this->request_rest->setRequestBody(json_encode($request_data));
		$this->request_rest->setMethod("PUT");
		$result = $this->request_rest->execute();
		if($result)
		{
		echo "Reminder message sent to the customer";
		}else
		{
		echo "Message not sent. Please try later";
		}
		 curl_close($ch);
		//$data['ex_flr'] = $this->bookmyt_model->get_flr($res_id);
		//$this->load->view('load_floors',$data);
		
	}
	public function getAddTimezone(){
		$this->layout=false;
		$zip=$this->input->get('zip');
		$details=file_get_contents("http://www.webservicex.net/uszip.asmx/GetInfoByZIP?USZip=".$zip);
		//$details=file_get_contents("http://www.webservicex.net/uszip.asmx/GetInfoByZIP?USZip=35004");
		$xml = simplexml_load_string($details);
		$xml=json_decode(json_encode($xml));
		$arr=array();	
		if(!empty($xml)){
			$time_zone=$xml->Table->TIME_ZONE;
			$location=$xml->Table->CITY;
			$country="United States";
			$state=$xml->Table->STATE;
			$arr=array(
						'city'		=> $xml->Table->CITY,
						'country'	=> $country,
						'state'		=> $state,
						'timezone'	=> $time_zone
					);
		}else{
			$arr = array(
						'city'		=> '',
						'country'	=> '',
						'state'		=> '',
						'timezone'	=> ''
					);
		}
		echo json_encode($arr);exit;
	}
	public function update_reservations(){
		//phpinfo(); 
		$this->layout = false;
		
		$sql = "select customer_id, sum(cnt) cnt, business_id, is_vip from(
			select customer_id, count(customer_id) cnt,  business_id, is_vip from reservation group by business_id
			union 
			select customer_id, count(customer_id) cnt,  business_id, is_vip from  reservation_archive group by business_id)a
			group by business_id";
		$query = $this->db->query($sql);
		$records = $query->result_array();
		if(is_array($records) && count($records)>0)
		{
		
		foreach($records as $record)
		{
			$busi_cust = $this->bookmyt_model->KM_first(array(
					"class" => "business_customer",
					"fields" => array(
						'customer_id','business_id'
					),
					"conditions" => array(
					 'business_id'=>$record['business_id'],
					 'customer_id'=>$record['customer_id'],
					)
				));
			if(!empty($busi_cust)){
				$this->bookmyt_model->KM_update(array(
					'class' => "business_customer",
					'update' => array(							
					'is_vip'=>$record['is_vip'],
					'is_star_customer'=>($record['cnt']>=3 ? 1:0 )
					)
				), array(
					'business_id'=>$record['business_id'],
					'customer_id'=>$record['customer_id'],
				));
			}else{
				$this->bookmyt_model->KM_save(array(
					'class' => "business_customer",
					'insert' => array(	
						'business_id'=>$record['business_id'],
						'customer_id'=>$record['customer_id'],
						'is_vip'=>$record['is_vip'],
						'is_star_customer'=>($record['cnt']>=3 ? 1:0 )
					)
				));
			}
		}
		}
		$succ = $this->bookmyt_model->KM_update(array(
							'class' => "reservation",
							'update' => array(
							'status'=>0,
							)
						), array(
							"booked_date < " => date('Y-m-d'),
							'status' => 1
						));
		
		
		
		$sql = "insert into reservation_archive
		select * from reservation where booked_date < '".date('Y-m-d')."'";
		$query = $this->db->query($sql);
		$sql = "delete from reservation where booked_date < '".date('Y-m-d')."'";
		$query = $this->db->query($sql);
		echo 'sdfs'; exit;
	}
	public function update_reservation()
	{	
		$this->layout = false;
		$time=$this->input->post('in_time');	
		$in_time  = date("H:i:s", strtotime($time));			
		$no_members = $this->input->post('members');
		$phone_no = $this->input->post('phone_no');
		$res_id = $this->input->post('res_id');
		$floor = $this->input->post('floor');
		$table_id = $this->input->post('table_id');
		
		$booked_date1=$this->input->post('booked_date');
		$date = date_create($booked_date1);
		$booked_date =  date_format($date, 'Y-m-d');
		$confirmed=0;
		
		$business_id=$this->session->userdata('business_id');
		if ($phone_no!="" && $this->bookmyt_model->KM_count(array(
			"class" => "reservation",
			"conditions" => array(
				'phone_no' => $phone_no,
				'booked_date' => $booked_date,
				'reservation_id <> ' =>$res_id,
				'parent_reservation != ' =>$res_id,
				'status'=>1
			)
		))>0) 
		{
			echo "Failed";exit;
		}					
		else 
		{
			$reservation = $this->bookmyt_model->KM_first(array(
					"class" => "reservation",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					 'reservation_id'=>$res_id
					)
				));
			$update = array(
						'booked_date'=>$booked_date,
						'in_time'=>$in_time,
						'table_for'=>$no_members,
						);
			if($floor){
			$update['floor'] = $floor;
			}
			if($table_id){
				$update['table_id'] = $table_id;
			}
			/*$sql="insert into reservation select * from reservation where reservation_id='$res_id' or parent_reservation='$res_id'";
			$this->db->query($sql);
			$sql="delete from reservation where reservation_id='$res_id' or parent_reservation='$res_id'"*/
			if(!empty($table_id)){
				$i=1;
				foreach($table_id as $table){
					$sec_tab=explode("_",$table);
					$section_id=end($sec_tab);
					$tab_id=$sec_tab[0];
					if($i==1){
						$userid = $this->bookmyt_model->KM_save(array(
							'class' => "reservation",
							'insert' => array(
								'customer_id' => $reservation['customer_id'],
								'name' => $reservation['name'],
								'phone_no' => $phone_no,
								'in_time' => $in_time,
								 'booked_date' => date('Y-m-d'),
								 'table_for'=>$no_members,
								 'table_id' => $tab_id,
								 'section_id'=>$section_id,
								 'floor'=>$floor,
								'confirmed' => $reservation['confirmed'],
								'business_id'=>$reservation['business_id'],
								'relationship_id' => $reservation['relationship_id'],
								'is_vip'	=> $reservation['is_vip'],
								'date_of_birth'	=> $reservation['date_of_birth'],
								'is_new'	=> $reservation['is_new'],
								'status'=>1
							),
							'return_id' => true
						));
					}else{
						$userid1 = $this->bookmyt_model->KM_save(array(
							'class' => "reservation",
							'insert' => array(
								'customer_id' => $reservation['customer_id'],
								'name' => $reservation['name'],
								'phone_no' => $phone_no,
								'in_time' => $in_time,
								 'booked_date' => date('Y-m-d'),
								 'table_for'=>$no_members,
								 'table_id' => $tab_id,
								 'section_id'=>$section_id,
								 'floor'=>$floor,
								'confirmed' => $reservation['confirmed'],
								'business_id'=>$reservation['business_id'],
								'relationship_id' => $reservation['relationship_id'],
								'parent_reservation'=>$userid,
								'is_vip'	=> $reservation['is_vip'],
								'date_of_birth'	=> $reservation['date_of_birth'],
								'is_new'	=> $reservation['is_new'],
								'status'=>1
							),
							'return_id' => true
						));
					}
					$i++;			
				}
				$sql="delete from reservation where reservation_id='$res_id' or parent_reservation='$res_id'";
				$this->db->query($sql);
			}else{
				$this->bookmyt_model->KM_update(array(
									'class' => "reservation",
									'update' => $update
									
								), array(
									"reservation_id" => $res_id									
								));
			}	
			echo "success";exit;
		}		
	}
	public function terms()
	{
		$this->layout = "pages_default";
		$this->load->view('terms');
	}
	public function admin_terms()
	{
		$this->layout = "admin_pages_layout.php";
		$this->load->view('terms');
	}
	public function contact_us()
	{
		$this->layout = "pages_default";
		$this->load->view('contact-us');
	}
	public function admin_contact_us()
	{
		$this->layout = "admin_pages_layout.php";
		$this->load->view('contact-us');
	}
	public function privacy()
	{
		$this->layout = "pages_default";
		$this->load->view('privacy');
	}
	public function admin_privacy()
	{
		$this->layout = "admin_pages_layout.php";
		$this->load->view('privacy');
	}
	public function editBusinessEntity($id){
		$this->layout = 'admin_layout.php';
		$data['business_id']=$id;	
		$data['business_info']=$this->bookmyt_model->getBusinessEntityInfo($id);
		$this->load->view("admin_business",$data);
	}
	public function updateBusinessEntity(){
		$this->layout='admin_layout.php';
		$update_business=$this->bookmyt_model->updateBusinessEntity();
		if($update_business){
			$this->session->set_flashdata("success","Business Admin updated successfully");
		}
		/*$test = "1";
		$username = "visitsats@gmail.com";
		$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
		$username = "dayakarv@toyaja.com";
		$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
		$username = "am_desai@yahoo.com";
		$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
		$test = "0";
		$sender = urlencode("BMYTBL"); */

		$numbers = $this->input->post("phone_no"); 
		if($this->input->post("phone_no") && $this->input->post("phone_no")!=""){
			if($this->input->post("password")==""){
				$message = "Dear ".$this->input->post("business_name").", Your Business Admin details are updated successfully";
			}else{
				$message = "Dear ".$this->input->post("business_name").", Your Business Admin details are updated successfully and your new password is ".$this->input->post("password");
			}
			/*$message = $message;
			$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
	
			$this->load->library("request_rest");
			$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
			$request_data=array(						
								"mobile_number" => $numbers,
								"message" => $message			
							);
	
			$this->request_rest->setRequestURL($request_url);
			$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
			$this->request_rest->setRequestBody(json_encode($request_data));
			$this->request_rest->setMethod("PUT");
			$result = $this->request_rest->execute();
			if($result)
			{
			//echo "Message sent to user phone";
			}else
			{
			//echo "Message not sent. Please try later";
			}
			 curl_close($ch);
		}else if($this->input->post("business_email") && $this->input->post("business_email")!=""){
			if($this->input->post("password")==""){
				$message = "Dear ".$this->input->post("business_name").", Your Business Admin details are updated successfully";
			}else{
				$message = "Dear ".$this->input->post("business_name").", Your Business Admin details are updated successfully and your new password is ".$this->input->post("password");
			}
			/*$config = array(
			'protocol' => "smtp",
			//'smtp_host' => "mail.knowledgematrixinc.com",
			'smtp_host' => "mail510.opentransfer.com",
			'smtp_port' => 587,
			'charset' => 'utf-8',
			'smtp_user' => 'info@trugeek.in',
			'smtp_pass' => 'Km!pl!123',
			);	*/
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
			
			$this->email->from('no-reply@bookmyt.com', 'Book My T');
			$this->email->to($this->input->post("business_email"));
	
			$this->email->subject('Business Details ');
			$this->email->message($message);
			$this->email->send();			
		}
		
		redirect('bookmyt/admin_dashboard');
	}
	public function getPieChart(){
		$this->layout=false;
		$data['monthly_report'] = $this->bookmyt_model->getMonthlyReport1();
		$this->load->view("ajax_monthly_report",$data);
	}
	public function customerData(){
		$this->layout=false;
		$data['customer_data'] = $this->bookmyt_model->getCustomerData();
		$this->load->view("customer_data_report",$data);
	}
		/*For Customer Report Screen*/
	public function getCustomerReport(){
		if($this->session->userdata('business_id')){
			$data['customers']=$this->bookmyt_model->getCustomerReport();
			$this->load->view("customer_report",$data);
		}else{
			redirect(base_url());
		}
	}
	/*Getting Dashboard Page*/
	public function getDashboard($month=''){
		if($this->session->userdata('business_id'))
		{
			
			if(empty($this->permissions) || $this->permissions->dashboard->view == 1)
			{
				$url=base_url().'api/business/floorslist/format/json';	
				$post_array = array( 'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
									'business_id' => $this->session->userdata('business_id')
									);
				$buffer = $this->load_curl_data($url,$post_array);	
				
				$data['floors'] = json_decode($buffer);
				$bid = $this->session->userdata('business_id');
				$hb = $this->session->userdata('have_branches');
				$data['weekly_report']=$this->bookmyt_model->getWeeklyReport($bid);
				$data['monthly_report'] = $this->bookmyt_model->getMonthlyReport($bid,$month);
				$data['daily_report'] = $this->bookmyt_model->getDailyReport($bid);
					
				$this->load->view('reports',$data);
			}
			else{
				//$this->session->set_flashdata('error','No Access. Invalid Request.');
				$this->session->set_flashdata('perm','Access Denied');
				redirect(base_url('bookmyt/home'));
			}
		}else{
			redirect(base_url());
		}
	}
	/*Detailed Report in Customer Report*/
	function detailed_report(){
		if($this->session->userdata('business_id')){
			$bid=$this->session->userdata('business_id');
			$data['results']=$this->bookmyt_model->detailed_report($bid);
			$this->load->view('detailed_report',$data);
		}else{
			redirect(base_url());
		}
	}
	/*For Sales Report*/
	public function salesReport(){
		if($this->session->userdata('business_id')){
			$data['weekreport']=$this->bookmyt_model->getSalesWeekReport();
			$data['yearlyreport']=$this->bookmyt_model->getYearlyReport();
			$bid=$this->session->userdata('business_id');
			$data['established_year']=$this->bookmyt_model->getEstablishedYear($bid);
			$this->load->view("sales_report",$data);
		}else{
			redirect(base_url());
		}
	}
	function validate_verification($business_id)
	{
		$this->layout=false;
		$verification_code = $this->input->post("verification_code");
		if(empty($verification_code)){
		$this->session->set_flashdata('error','Please Enter verification code.');
		redirect(base_url('bookmyt/admin_dashboard'));
		}else if(($verification_code != SUPERADMIN_VERIFICATIONCODE))
		{
		$this->session->set_flashdata('error','Invalid verification code.');
		redirect(base_url('bookmyt/admin_dashboard'));
		}
		else{
			$userdata = $this->bookmyt_model->business_entity_superuser_login($business_id);	
			if (count($userdata) != 0) 
			{
				$this->session->set_userdata("log_type","Business");
				$this->session->set_userdata("login_sup","sup");
				$this->session->set_userdata($userdata);
				redirect(base_url('bookmyt/occupancy/'));	
			}else{
				$this->session->set_flashdata('error','Invalid input.');
				redirect(base_url('bookmyt/admin_dashboard'));
			}
		}
	}
	function superadmin()
	{
		if($this->session->userdata('login_sup') =='sup')
		{
			$dashboard = $this->bookmyt_model->business_entity_superlogin();		
			if(count($dashboard) != 0)
			{
				$dashboard['sup'] = 'sup';
				$this->session->set_userdata($dashboard);
				redirect(base_url('bookmyt/admin_dashboard'));
			}
			else{
				$array_items = array('log_type'=>'',
				'business_id'=>'',
				'business_name'=>'',
				'business_email'=>'',
				'branch'=>'',
				'relationship_id'=>'',
				'have_branches'=>'' ,
				'login_count'=>'', 
				'last_login'=>'',
				'user_id'=>'',
				'login_sup'=>'',
				'sup'=>'',
				'email'=>'',
				'user_type_id'=>'');			
				$this->session->set_userdata($array_items);
				redirect('bookmyt/home/');
			}
		}else{
				$array_items = array('log_type'=>'',
				'business_id'=>'',
				'business_name'=>'',
				'business_email'=>'',
				'branch'=>'',
				'relationship_id'=>'',
				'have_branches'=>'' ,
				'login_count'=>'', 
				'last_login'=>'',
				'user_id'=>'',
				'login_sup'=>'',
				'sup'=>'',
				'email'=>'',
				'user_type_id'=>'');			
				$this->session->set_userdata($array_items);
				redirect('bookmyt/home/');
		}
	}
	function business_report($business_id)
	{
		$this->layout = 'admin_layout.php';
		$data['business_info'] = $this->bookmyt_model->business_report($business_id);
		$data['business_user_info'] = $this->bookmyt_model->business_user_info($business_id);
		
		$business_bracnch_info = $this->bookmyt_model->business_bracnch_info($business_id);
		$business_bracnch_info_array = array();
		$branch_user_info = array();
		if(is_array($business_bracnch_info)){
			foreach($business_bracnch_info as $business_bracnch_in){
				$business_bracnch_info_array[$business_bracnch_in['business_id']][] = $business_bracnch_in;
				$branch_user_info[$business_bracnch_in['business_id']] = $this->bookmyt_model->branch_user_info($business_bracnch_in['business_id']);
			}
		}
		
		$data['business_bracnch_info_array'] = $business_bracnch_info_array;
		$data['branch_user_info'] = $branch_user_info;
		$this->load->view('business_report',$data);
	}
	function signup(){		
		$this->load->view("signup");
	}
	function cart_register($type=''){
		$data['type']=$type;
		$this->load->view("cart_register",$data);
	}
	// Create Profile
	function create($post,$price,$sub_type,$cust_id,$add,$city,$state,$zip,$date='')
	{
		// Load the ARB lib
		$this->load->library('authorize_arb');
		
		//echo '<h1>Creating Profile</h1>';
		
		// Start with a create object
		$this->authorize_arb->startData('create');
		
		// Locally-defined reference ID (can't be longer than 20 chars)
		$refId = substr(md5( microtime() . 'ref' ), 0, 20);
		$this->authorize_arb->addData('refId', $refId);
		
		// Data must be in this specific order
		// For full list of possible data, refer to the documentation:
		// http://www.authorize.net/support/ARB_guide.pdf
		//$expiry=(date("Y") + 1) . '-12';
		
		$expiry=$post['year'].'-'.$post['month'];
		if($sub_type==2 || $sub_type==4){
			$length=1;
			$unit='months';
			if($sub_type==2){
				$plan="Individual";
				$type="Monthly";
			}else if($sub_type==4){
				$plan="Multiple";
				$type="Monthly";
			}
		}else if($sub_type==3 || $sub_type=5){
			$length=365;
			$unit='days';
			if($sub_type==3){
				$plan="Multiple";
				$type="Annual";
			}else if($sub_type==5){
				$plan="Multiple";
				$type="Annual";
			}
		}
		if(!is_numeric($post['email_phone'])){
			$email=$post['email_phone'];
			$phone='';
		}else{
			$email='';
			$phone=$post['email_phone'];
		}
		//$price=1;
		if($date==""){
			$date=date('Y-m-d');
		}else{
			$date=$date;
		}
		//$expiry='2021-04';
		$subscription_data = array(
			'name' => $post['business_name'],
			'paymentSchedule' => array(
				'interval' => array(
					'length' => $length,
					'unit' => $unit,
					),
				'startDate' => $date,
				'totalOccurrences' => 9999,
				'trialOccurrences' => 0,
				),
			'amount' => $price,
			'trialAmount' => 0.00,
			'payment' => array(
				'creditCard' => array(
					'cardNumber' => str_replace(" ","",$post['card_number']),
					'expirationDate' => $expiry,
					'cardCode' => $post['cvv'],
					),
				),
			'order' => array(
				'invoiceNumber' => $cust_id,
				'description' => $post['business_name'].','.$plan.','.$type.','.$post['no_of_users'],
				),
			'customer' => array(
				'id' => $cust_id,
				'email' => $email,
				'phoneNumber' => $phone,
				),
			'billTo' => array(
				'firstName' => $post['your_name'],
				'lastName' => $post['your_name'],
				'address' => $add,
				'city' => $city,
				'state' => $state,
				'zip' => $zip,
				'country' => 'US',
				),
			);
		
		$this->authorize_arb->addData('subscription', $subscription_data);
		
		// Send request
		if( $this->authorize_arb->send() )
		{
			$data=array("status"=> "success","id"=>$this->authorize_arb->getId());
			$response= $this->authorize_arb->formatXml($this->authorize_arb->getResponse());
			$res=simplexml_load_string($response);
			$data['response']=$res;
		}
		else
		{
			$data=array("status"=>"failure","reason"=>$this->authorize_arb->getError());
			
		}
		return $data;
		// Show debug data
		//$this->authorize_arb->debug();
	}
	public function validate($post,$price,$sub_type,$cust_id,$add,$city,$state,$zip)
	{
		// Authorize.net lib
		$this->load->library('authorize_net_aim');
		$expiry=$post['year'].'-'.$post['month'];
		//$price=1;
		if(!is_numeric($post['email_phone'])){
			$email=$post['email_phone'];
			$phone='';
		}else{
			$email='';
			$phone=$post['email_phone'];
		}
		$auth_net = array(
			'x_card_num'			=> str_replace(" ","",$post['card_number']), // Visa
			'x_exp_date'			=> $expiry,
			'x_card_code'			=> $post['cvv'],
			'x_description'			=> 'Book My T Registration',
			'x_amount'				=> $price,
			'x_first_name'			=> $post['your_name'],
			'x_last_name'			=> $post['your_name'],
			'x_address'				=> $add,
			'x_city'				=> $city,
			'x_state'				=> $state,
			'x_zip'					=> $zip,
			'x_country'				=> 'US',
			'x_phone'				=> $phone,
			'x_email'				=> $email,
			'x_customer_ip'			=> $this->input->ip_address(),
			);
		$this->authorize_net_aim->setData($auth_net);
		$data=array();
		// Try to AUTH_CAPTURE
		if( $this->authorize_net_aim->authorizeAndCapture() )
		{
			$data['status']='success';
			$data['transaction_id']=$this->authorize_net_aim->getTransactionId();
			$data['approval_code']=$this->authorize_net_aim->getApprovalCode();	
			$data['card']=$this->authorize_net_aim->getCard();			
			//$data['debug']=$this->authorize_net_aim->debug();
		}
		else
		{
			$data['status']='failure';
			$data['reason']=$this->authorize_net_aim->getError();
			// Show debug data
			//$this->authorize_net_aim->debug();
		}
		return $data;
	}
	function register_check($type=''){
		$this->form_validation->set_rules('business_name', 'Business name', 'required|is_unique[business_entity.business_name]');
		$this->form_validation->set_rules('zip', 'Business type', 'required|numeric|min_length[3]|max_length[5]');		
		$this->form_validation->set_rules('email_phone', 'Business email', 'required|valid_email|is_unique[business_entity.business_email]');		
		$this->form_validation->set_rules('phone_number', 'Business phone number', 'required|numeric|min_length[10]|max_length[15]|is_unique[business_entity.phone_no]');
		$this->form_validation->set_rules('your_name', 'Your Name', 'required');
		if($type!="free"){
			$this->form_validation->set_rules('no_of_users', 'No. of Users', 'required|numeric');
		}
		if ($this->form_validation->run() == FALSE){
			$data['type']=$type;
			$this->load->view("cart_register",$data);
		}else{
			$data['post_data']=$this->input->post();
			$data['type']=$type;
			$rand_number=rand(1000,9999);
			$EncKey = "Bmt@1234"; //For security
			$block = mcrypt_get_block_size('des', 'ecb');
			if (($pad = $block - (strlen($rand_number) % $block)) < $block) {
				$rand_number .= str_repeat(chr($pad), $pad);
			}
			$rand_number= base64_encode(mcrypt_encrypt(MCRYPT_DES, $EncKey, $rand_number, MCRYPT_MODE_ECB));

			$data['rand_number']=$rand_number;
			$EncKey = "Bmt@1234"; //For security									
			$rand_number = mcrypt_decrypt(MCRYPT_DES, $EncKey, base64_decode($rand_number), MCRYPT_MODE_ECB);
			# Strip padding out.
			$block = mcrypt_get_block_size('des', 'ecb');
			$pad = ord($rand_number[($len = strlen($rand_number)) - 1]);
			$rand_number = substr($rand_number, 0, strlen($rand_number) - $pad);
			
			$config = array(
							'protocol' => "mail",
							'smtp_host' => "mail.knowledgematrixinc.com",
							//'smtp_host' => "mail510.opentransfer.com",
							'smtp_port' => 587,
							'charset' => 'utf-8',
							'smtp_user' => 'pradeepp@knowledgematrixinc.com',
							'smtp_pass' => 'mac!roni_67'
						);
			
			$this->load->library('email',$config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			$body = "<p>Dear Customer,</p><p>Your One Time Password (OTP) for creation of  your Book My T account  is  ".$rand_number."</p><p>Please enter this code in the OTP code box listed on the page.</p><p>For any help, please connect us on info@bookmyt.com</p></br><p>Regards,</p><p>Book My T</p>";
			//$emailid = $this->input->post('email');
			$this->email->from('pradeepp@toyaja.com', 'Book My T');
			$this->email->to($this->input->post('email_phone'));
			$this->email->cc('');
			$this->email->bcc('');

			$this->email->subject('Your OTP for creating Book My T account');
			$this->email->message($body);

			if($this->email->send())
			{}
			
			$numbers = $this->input->post('phone_number'); 
			
			$message = "Please enter your OTP for continuing the registration process. Your OTP is ".$rand_number;			
			
			$this->load->library("request_rest");
			$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
			$request_data=array(						
								"mobile_number" => $numbers,
								"message" => $message			
							);
	
			$this->request_rest->setRequestURL($request_url);
			$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
			$this->request_rest->setRequestBody(json_encode($request_data));
			$this->request_rest->setMethod("PUT");
			//Disabled in testing purpose
			//$result = $this->request_rest->execute();
			//$res=json_decode($result);
			
			$this->load->view("register_check",$data);
		}		
	}
	function resend_otp(){
		$this->layout=false;
		$rand_number=$this->input->post('resend_val');
		$EncKey = "Bmt@1234";
		$rand_number = mcrypt_decrypt(MCRYPT_DES, $EncKey, base64_decode($rand_number), MCRYPT_MODE_ECB);
		# Strip padding out.
		$block = mcrypt_get_block_size('des', 'ecb');
		$pad = ord($rand_number[($len = strlen($rand_number)) - 1]);
		$rand_number = substr($rand_number, 0, strlen($rand_number) - $pad);
		$config = array(
						'protocol' => "mail",
						'smtp_host' => "mail.knowledgematrixinc.com",
						//'smtp_host' => "mail510.opentransfer.com",
						'smtp_port' => 587,
						'charset' => 'utf-8',
						'smtp_user' => 'pradeepp@knowledgematrixinc.com',
						'smtp_pass' => 'mac!roni_67'
					);
		
		$this->load->library('email',$config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$body = "<p>Dear Customer,</p><p>Please enter your OTP for continuing the registration process. Your OTP is ".$rand_number."</p><p>Please enter this code in the OTP code box listed on the page.</p><p>For any help, please connect us on info@bookmyt.com</p></br><p>Regards,</p><p>Book My T</p>";
		//$emailid = $this->input->post('email');
		$this->email->from('pradeepp@toyaja.com', 'Book My T');
		$this->email->to($this->input->post('email_phone'));
		$this->email->cc('');
		$this->email->bcc('');

		$this->email->subject('Your OTP for creating Book My T account');
		$this->email->message($body);

		if($this->email->send()){
			echo "Mail sent Successfully";
		}else{
			echo $this->email->print_debugger();
		}
		
		$numbers = $this->input->post('phone_number'); 
		
		$message = "Please enter your OTP for continuing the registration process. Your OTP is ".$rand_number;			
		
		$this->load->library("request_rest");
		$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
		$request_data=array(						
							"mobile_number" => $numbers,
							"message" => $message			
						);

		$this->request_rest->setRequestURL($request_url);
		$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
		$this->request_rest->setRequestBody(json_encode($request_data));
		$this->request_rest->setMethod("PUT");
		//Disabled in testing purpose
		//$result = $this->request_rest->execute();
		//$res=json_decode($result);
	}
	function card_details($type=''){
		$data['type']=$type;
		$this->load->view('card_details',$data);
	}
	function send_receipt($cust_id,$price,$name,$desc,$trans_id,$auth,$card,$card_type,$email,$zip,$country,$qty='',$plan_name=''){
		if($qty==""){
			$qty=1;
		}
		$body='<table width="100%" cellspacing="0" cellpadding="2" bgcolor="#a0a0a0">
			  <tbody>
				<tr>
				  <td>Order Information </td>
				</tr>
			  </tbody>
			</table>
			<table width="100%" cellspacing="0" cellpadding="2">
			  <tbody>
				<tr>
				  <td width="90" valign="top">Description:</td>
				  <td valign="top">'.$desc.'</td>
				</tr>
			  </tbody>
			</table>
			<table width="100%" cellspacing="0" cellpadding="0">
			  <tbody>
				<tr>
				  <td width="250" valign="top"><table cellspacing="0" cellpadding="2">
					<tbody>
					  <tr>
						<td width="90" valign="top">Customer ID&nbsp;</td>
						<td valign="top">'.$cust_id.'</td>
					  </tr>
					</tbody>
				  </table></td>
				  <td valign="top"><table cellspacing="0" cellpadding="2">
				  </table></td>
				</tr>
			  </tbody>
			</table>
			<hr />
			<table width="100%" cellspacing="0" cellpadding="0">
			  <tbody>
				<tr>
				  <td width="250" valign="top"> Billing Information <br />
					'.$name.'<br />
					'.$zip.'<br />
					'.$country.'<br />
					<a href="mailto:'.$email.'" target="_blank">'.$email.'</a> </td>				  
				</tr>
			  </tbody>
			</table>
			<hr />
			<table width="100%" cellspacing="0" cellpadding="2">
			  <thead>
				<tr>
				  <td>Customer Id</td>
				  <td>Name</td>
				  <td>Description</td>
				  <td align="right">Qty</td>				  
				  <td align="right">Unit&nbsp;Price</td>
				  <td align="right">Item&nbsp;Total</td>
				</tr>
			  </thead>
			  <tbody>
				<tr>
				  <td>'.$cust_id.'</td>
				  <td>'.$plan_name.'</td>
				  <td>'.$desc.'</td>
				  <td align="right">'.$qty.'</td>				 
				  <td align="right">$'.$price.' (USD)</td>
				  <td align="right">$'.$price.' (USD)</td>
				</tr>
			  </tbody>
			</table>
			<hr />
			<table width="100%" cellspacing="0" cellpadding="0">
			  <tbody>
				<tr>
				  <td align="right"><table cellspacing="0" cellpadding="2">
					<tbody>
					  <tr>
						<td valign="top" align="right">Total:</td>
						<td valign="top" align="right"></td>
						<td valign="top" align="right">$'.$price.' (USD)</td>
					  </tr>
					</tbody>
				  </table></td>
				</tr>
			  </tbody>
			</table>
			<br />
			<table width="100%" cellspacing="0" cellpadding="2" bgcolor="#a0a0a0">
			  <tbody>
				<tr>
				  <td> Payment Information </td>
				</tr>
			  </tbody>
			</table>
			<table width="100%" cellspacing="0" cellpadding="0">
			  <tbody>
				<tr>
				  <td valign="bottom"><table cellspacing="0" cellpadding="2">
					<tbody>
					  <tr>
						<td width="130" valign="top">Date/Time:</td>
						<td valign="top">'.date('j-M-Y H:i:s T').'</td>
					  </tr>
					  <tr>
						<td width="130" valign="top">Transaction ID:</td>
						<td valign="top">'.$trans_id.'</td>
					  </tr>
					  <tr>
						<td width="130" valign="top">Payment Method:</td>
						<td valign="top">'.$card_type.' ' .$card.'</td>
					  </tr>
					  <tr>
						<td width="130" valign="top">Transaction Type:</td>
						<td valign="top">Purchase</td>
					  </tr>
					  <tr>
						<td width="130" valign="top">Auth Code:</td>
						<td valign="top">'.$auth.'</td>
					  </tr>
					</tbody>
				  </table></td>
				  <td valign="bottom" align="right"><table>
				  </table></td>
				</tr>
			  </tbody>
			</table>
			<br />
			<table width="100%" cellspacing="0" cellpadding="2" bgcolor="#a0a0a0">
			  <tbody>
				<tr>
				  <td> Merchant Contact Information </td>
				</tr>
			  </tbody>
			</table>
			<div>Book My T Inc.,</div>
			<div>624 University Ave.</div>
			<div>Palo Alto, CA 94301</div>
			<div><a href="mailto:orders@bookmyt.com" target="_blank">orders@bookmyt.com</a></div>';
			$config = array(
							'protocol' => "mail",
							'smtp_host' => "mail.knowledgematrixinc.com",
							//'smtp_host' => "mail510.opentransfer.com",
							'smtp_port' => 587,
							'charset' => 'utf-8',
							'smtp_user' => 'pradeepp@knowledgematrixinc.com',
							'smtp_pass' => 'mac!roni_67'	
						);

			$this->load->library('email',$config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			
			
			$this->email->from('info@bookmyt.com', 'Book My T');
			$this->email->to($email);
			$this->email->cc('');
			$this->email->bcc('');

			$this->email->subject('Book My T payment receipt.');
			$this->email->message($body);

			if($this->email->send())
			{}			
	}
	function insert_register($type=''){
		//pr($this->input->post());exit;
		if($this->input->post())
		{				
			$rand_number=$this->input->post('or_number');
			$EncKey = "Bmt@1234"; //For security									
			$rand_number = mcrypt_decrypt(MCRYPT_DES, $EncKey, base64_decode($rand_number), MCRYPT_MODE_ECB);
			# Strip padding out.
			$block = mcrypt_get_block_size('des', 'ecb');
			$pad = ord($rand_number[($len = strlen($rand_number)) - 1]);
			$rand_number = substr($rand_number, 0, strlen($rand_number) - $pad);
			
			if($this->input->post('rand_number') && $rand_number!=$this->input->post('rand_number')){			
				$this->session->set_flashdata('error',"Invalid OTP");
				$data['post_data']=$this->input->post();
				$data['type']=$type;
				$data['rand_number']=$this->input->post('or_number');				
				$this->load->view("register_check",$data);
			}else{
				
				$random_pwd = mt_rand(100000, 999999);
				$username = 'admin';
				$password = '1234';
				$ip_address = $_SERVER['REMOTE_ADDR'];
				$zip=$this->input->post("zip");
				//$details=file_get_contents("http://www.webservicex.net/uszip.asmx/GetInfoByZIP?USZip=".$zip);
				//$xml = simplexml_load_string($details);
				/*if(!empty($xml)){
					$time_zone=$xml->Table->TIME_ZONE;
					$location=$xml->Table->CITY;
					$country="US";
					$state=$xml->Table->STATE;
				}else{*/
					$time_zone = $this->input->post('time_zone');
					$country="US";
					$location='';
					$state='';
				//}
				
				$no_of_users=$this->input->post("no_of_users");
				if($type=='free'){
					$sub_type=1;
					$start_date=date("Y-m-d");
					$end_date=date('Y-m-d',strtotime('+ 30 days'));
					$bus_type="L";
					$price="";
				}else if($type=='individual'){
					if($this->input->post("RadioGroup1")==1){
						$sub_type=2;
						$sub_type1="Book My T - Individual Monthly";
						$start_date=date("Y-m-d");
						$end_date=date('Y-m-d',strtotime('+ 30 days'));
						$price=INDIVIDUAL_MONTHLY_PRICE*$no_of_users;
					}else{
						$sub_type=3;
						$sub_type1="Book My T - Individual Annual";
						$start_date=date("Y-m-d");
						$end_date=date('Y-m-d',strtotime('+ 1 year'));
						$price=INDIVIDUAL_ANNUAL_PRICE*$no_of_users;
					}						
					$bus_type="S";
					
				}else if($type=='multiple'){
					if($this->input->post("RadioGroup1")==1){
						$sub_type=4;
						$sub_type1="Book My T - Multiple Monthly";
						$start_date=date("Y-m-d");
						$end_date=date('Y-m-d',strtotime('+ 30 days'));
						$price=MULTIPLE_MONTHLY_PRICE*$no_of_users;
					}else{
						$sub_type=5;
						$start_date=date("Y-m-d");
						$sub_type1="Book My T - Multiple Annual";
						$end_date=date('Y-m-d',strtotime('+ 1 year'));
						$price=MULTIPLE_ANNUAL_PRICE*$no_of_users;	
					}						
					$bus_type="L";
					
				}
				$post=$this->input->post();
				$password="Bmt".mt_rand(10000, 99999);
				$url=base_url().'api/business/add_business_customer/format/json';
				$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru','ip_address'=>$ip_address,'country' => $country ,'zipcode'=>$zip,'city'=>$location, 't_zone' => $time_zone ,'state' =>$state,'sub_type'=>$sub_type,'end_date'=>$end_date,'start_date'=>$start_date,'bus_type'=>$bus_type,"price"=>$price,"password"=>$password);
				$post_array = array_merge($_POST,$arr);
				 $buffer = $this->load_curl_data($url,$post_array);
				
				$buffer=json_decode($buffer);
				$buss_type=$buffer->data->business_type;
				$buss_type=(isset($buss_type) && $buss_type=='L')?'Large Enterprise':'Small Enterprise';
				$cust_id=$buffer->data->Id;
				$pay_address=$buffer->data->address;
				$pay_city=$buffer->data->city;
				$pay_state=$buffer->data->state;
				$pay_zip=$buffer->data->zip;					
				$business_name=$this->input->post('business_name');
				if(!empty($buffer))
				{  
					$l_business_name=$this->input->post('business_name');
					if($l_business_name!=''){
						
							//Disabled in testing purpose
						
						if($type!='free'){
							$validate_transaction=$this->validate($post,$price,$sub_type,$cust_id,$pay_address,$pay_city,$pay_state,$pay_zip);	
							//pr($validate_transaction);exit;
							
							if($validate_transaction['status']=='success'){
								$this->send_receipt($cust_id,$price,$validate_transaction['card'][13],$validate_transaction['card'][8],$validate_transaction['transaction_id'],$validate_transaction['approval_code'],$validate_transaction['card'][50],$validate_transaction['card'][51],$validate_transaction['card'][23],$validate_transaction['card'][19],$validate_transaction['card'][20],'',$sub_type1);
							$payment=$this->create($post,$price,$sub_type,$cust_id,$pay_address,$pay_city,$pay_state,$pay_zip);							
								if(!empty($payment)){
									if($payment['status']=="success"){
										$profile_id='';
										$payment_profile_id='';
										if(isset($payment['response'])){
											$profile_id=$payment['response']->profile->customerProfileId;
											$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
										}
										$this->bookmyt_model->update_payment_status($cust_id,$payment['id'],"success",'','',$profile_id,$payment_profile_id);
										$arr=array(
													'sub_start'		=> $start_date,
													'sub_end'		=> $end_date,
													'price'			=> $price,
													'sub_type'		=> $sub_type,
													'business_id'	=> $cust_id,
													'created_ts'	=> date("Y-m-d h:i:s")
												);
										$this->db->insert("transaction_details",$arr);
										$EncKey = "Bmt@1234"; //For security
										$block = mcrypt_get_block_size('des', 'ecb');
										if (($pad = $block - (strlen($cust_id) % $block)) < $block) {
											$cust_id .= str_repeat(chr($pad), $pad);
										}
										$cust_id= base64_encode(mcrypt_encrypt(MCRYPT_DES, $EncKey, $cust_id, MCRYPT_MODE_ECB));
										$config = array(
													'protocol' => "mail",
													'smtp_host' => "mail.knowledgematrixinc.com",
													//'smtp_host' => "mail510.opentransfer.com",
													'smtp_port' => 587,
													'charset' => 'utf-8',
													'smtp_user' => 'pradeepp@knowledgematrixinc.com',
													'smtp_pass' => 'mac!roni_67'	
												);
					
										
										$this->load->library('email',$config);
										$this->email->set_mailtype("html");
										$this->email->set_newline("\r\n");
										
										//$phone_no = $buffer->data->phone_no;
										//$branch_id = $buffer->data->Id;				
										
										$body = "<p>Dear Customer,</p><p>We appreciate your interest with Book My T. You can access your account with the following credentials.</p><p>Username : ".$this->input->post('email_phone')." </p><p>Password : ".$password."</p><p>For any help, please connect us on <a href='mailto:info@bookmyt.com'>info@bookmyt.com</a></p></br><p>Regards,</p><p>Book My T</p>";
										//$emailid = $this->input->post('email');
										$this->email->from('info@bookmyt.com', 'Book My T');
										$this->email->to($this->input->post('email_phone'));
										$this->email->cc('');
										$this->email->bcc('');
				
										$this->email->subject('Welcome to Book My T.');
										$this->email->message($body);
				
										if($this->email->send())
										{}
										
									
										$numbers = $this->input->post('phone_number'); 
										/* $message = "Appreciate your interest in BookMyT. Your account will be activated shortly by another message/email after verification process. For any help, please connect us on info@bookmyt.com ";*/
										$message="Appreciate your interest in Book My T. You will receive a sms/email after activation. For any help, connect us on info@bookmyt.com";
										/*$message = $message;
									   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
										
										$this->load->library("request_rest");
										$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
										$request_data=array(						
															"mobile_number" => $numbers,
															"message" => $message			
														);
								
										$this->request_rest->setRequestURL($request_url);
										$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
										$this->request_rest->setRequestBody(json_encode($request_data));
										$this->request_rest->setMethod("PUT");
										//Disabled in testing purpose
										//$result = $this->request_rest->execute();
										//$res=json_decode($result);
											
									
										// Mail intimation to admin
										$config = array(
												'protocol' => "mail",
												'smtp_host' => "mail.knowledgematrixinc.com",
												//'smtp_host' => "mail510.opentransfer.com",
												'smtp_port' => 587,
												'charset' => 'utf-8',
												'smtp_user' => 'pradeepp@knowledgematrixinc.com',
												'smtp_pass' => 'mac!roni_67'
											);
					
										
										$this->load->library('email',$config);
										$this->email->set_mailtype("html");
										$this->email->set_newline("\r\n");
										
										//$phone_no = $buffer->data->phone_no;
										//$branch_id = $buffer->data->Id;				
										
										$body = "<p>Dear Admin,</p><p>This is to inform you that, new restaurant ".$business_name." is registered. </p></br><p>Regards,</p><p>Book My T</p>";
										//$emailid = $this->input->post('email');
										$this->email->from('info@bookmyt.com', 'Book My T');
										$this->email->to('satishk@toyaja.com');
										$this->email->cc('');
										$this->email->bcc('');
				
										$this->email->subject('Welcome to Book My T.');
										$this->email->message($body);
				
										/*if($this->email->send())
										{}*/
										//Message for Admin
										$username = "visitsats@gmail.com";
										$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
										$username = "dayakarv@toyaja.com";
										$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
										$test = "0";
										$username = "am_desai@yahoo.com";
										$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
										$sender = urlencode("BMYTBL"); 
										$numbers = '9000550399,7731825006';
										
										 $message = "Dear Admin, This is to inform you that, new restaurant is awaiting for your verification and approval. Restaurant Name: ".$business_name.", ".$buss_type;
										$message = urlencode($message);
									   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
										//Disabled in testing purpose
										/*$ch = curl_init('http://api.textlocal.in/send/?');
										curl_setopt($ch, CURLOPT_POST, true);
										curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										 $result = curl_exec($ch); 
										curl_close($ch);
										$res=json_decode($result);*/
										echo '<script>alert("Payment Successful. Restaurant '.$business_name.' has been registered successfully.You will get your login details by text message/email.");window.location="'.base_url('bookmyt/thankyou').'/'.$cust_id.'";</script>';
									}else{
										$profile_id='';
										$payment_profile_id='';
										/*if(isset($payment['response'])){
											$profile_id=$payment['response']->profile->customerProfileId;
											$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
										}*/
										$this->bookmyt_model->update_payment_status($cust_id,$validate_transaction['reason'],"failure",'','',$profile_id,$payment_profile_id);									
										echo '<script>alert("Payment Unsuccessful due to '.$validate_transaction['reason'].'. You will get your login details by text message/email to use 30 days FREE, If your are first time user of Book My T.");window.location="'.base_url('bookmyt/home').'";</script>';
									}
								}else{
									$profile_id='';
									$payment_profile_id='';
									
									$this->bookmyt_model->update_payment_status($cust_id,$validate_transaction['reason'],"failure",'','',$profile_id,$payment_profile_id);									
									echo '<script>alert("Payment Unsuccessful due to '.$validate_transaction['reason'].'. Restaurant '.$business_name.' has been registered successfully.\nAppreciate your interest in Book My T. Still you can continue as a free user for 30 days.");window.location="'.base_url('bookmyt/home').'";</script>';
								}
							}else{
								$this->session->set_userdata("post_data",$this->input->post());
								$this->session->set_flashdata("error",$validate_transaction['reason']);
								$this->db->delete("business_entity",array('business_id'=>$cust_id));
								redirect('bookmyt/card_details/'.$type);
								/*$this->bookmyt_model->update_payment_status($cust_id,$validate_transaction['reason'],"failure",'','',$profile_id,$payment_profile_id);									
									echo '<script>alert("Payment Unsuccessful due to '.$validate_transaction['reason'].'. You will get your login details by text message/email to use 30 days FREE, If your are first time user of BookMyT.");window.location="'.base_url('bookmyt/home').'";</script>';*/
							}
						}else{
							$config = array(
										'protocol' => "mail",
										'smtp_host' => "mail.knowledgematrixinc.com",
										//'smtp_host' => "mail510.opentransfer.com",
										'smtp_port' => 587,
										'charset' => 'utf-8',
										'smtp_user' => 'pradeepp@knowledgematrixinc.com',
										'smtp_pass' => 'mac!roni_67'	
									);
		
							
							$this->load->library('email',$config);
							$this->email->set_mailtype("html");
							$this->email->set_newline("\r\n");
							
							//$phone_no = $buffer->data->phone_no;
							//$branch_id = $buffer->data->Id;				
							
							$body = "<p>Dear Customer,</p><p>We appreciate your interest with Book My T. You can access your account with the following credentials.</p><p>Username : ".$this->input->post('email_phone')." </p><p>Password : ".$password."</p><p>For any help, please connect us on <a href='mailto:info@bookmyt.com'>info@bookmyt.com</a></p></br><p>Regards,</p><p>Book My T</p>";
							//$emailid = $this->input->post('email');
							$this->email->from('info@bookmyt.com', 'Book My T');
							$this->email->to($this->input->post('email_phone'));
							$this->email->cc('');
							$this->email->bcc('');
	
							$this->email->subject('Welcome to Book My T.');
							$this->email->message($body);
	
							if($this->email->send())
							{}
							
						
							$numbers = $this->input->post('phone_number'); 
							/* $message = "Appreciate your interest in BookMyT. Your account will be activated shortly by another message/email after verification process. For any help, please connect us on info@bookmyt.com ";*/
							$message="Appreciate your interest in Book My T. You will receive a sms/email after activation. For any help, connect us on info@bookmyt.com";
							/*$message = $message;
						   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;*/
							
							$this->load->library("request_rest");
							$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
							$request_data=array(						
												"mobile_number" => $numbers,
												"message" => $message			
											);
					
							$this->request_rest->setRequestURL($request_url);
							$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
							$this->request_rest->setRequestBody(json_encode($request_data));
							$this->request_rest->setMethod("PUT");
							//Disabled in testing purpose
							//$result = $this->request_rest->execute();
							//$res=json_decode($result);
								
						
							// Mail intimation to admin
							$config = array(
									'protocol' => "mail",
									'smtp_host' => "mail.knowledgematrixinc.com",
									//'smtp_host' => "mail510.opentransfer.com",
									'smtp_port' => 587,
									'charset' => 'utf-8',
									'smtp_user' => 'pradeepp@knowledgematrixinc.com',
									'smtp_pass' => 'mac!roni_67'
								);
		
							
							$this->load->library('email',$config);
							$this->email->set_mailtype("html");
							$this->email->set_newline("\r\n");
							
							//$phone_no = $buffer->data->phone_no;
							//$branch_id = $buffer->data->Id;				
							
							$body = "<p>Dear Admin,</p><p>This is to inform you that, new restaurant ".$business_name." is registered. </p></br><p>Regards,</p><p>Book My T</p>";
							//$emailid = $this->input->post('email');
							$this->email->from('info@bookmyt.com', 'Book My T');
							$this->email->to('satishk@toyaja.com');
							$this->email->cc('');
							$this->email->bcc('');
	
							$this->email->subject('Welcome to Book My T.');
							$this->email->message($body);
	
							/*if($this->email->send())
							{}*/
							//Message for Admin
							$username = "visitsats@gmail.com";
							$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
							$username = "dayakarv@toyaja.com";
							$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
							$test = "0";
							$username = "am_desai@yahoo.com";
							$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
							$sender = urlencode("BMYTBL"); 
							$numbers = '9000550399,7731825006';
							
							 $message = "Dear Admin, This is to inform you that, new restaurant is awaiting for your verification and approval. Restaurant Name: ".$business_name.", ".$buss_type;
							$message = urlencode($message);
						   $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
							//Disabled in testing purpose
							/*$ch = curl_init('http://api.textlocal.in/send/?');
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							 $result = curl_exec($ch); 
							curl_close($ch);
							$res=json_decode($result);*/
							echo '<script>alert("Restaurant '.$business_name.' has been registered successfully.\nAppreciate your interest in Book My T. You will get your login details by text message/email");window.location="'.base_url('bookmyt/home').'";</script>';
						}
					}else{
						if($type!='free'){
							
							$validate_transaction=$this->validate($post,$price,$sub_type,$cust_id,$pay_address,$pay_city,$pay_state,$pay_zip);
							if($validate_transaction['status']=='success'){
								$payment=$this->create($post,$price,$sub_type,$cust_id,$pay_address,$pay_city,$pay_state,$pay_zip);								
								if(!empty($payment)){
									if($payment['status']=="success"){
										$profile_id='';
										$payment_profile_id='';
										if(isset($payment['response'])){
											$profile_id=$payment['response']->profile->customerProfileId;
											$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
										}
										$this->bookmyt_model->update_payment_status($cust_id,$payment['id'],"success",'','',$profile_id,$payment_profile_id);
										$arr=array(
													'sub_start'		=> $start_date,
													'sub_end'		=> $end_date,
													'price'			=> $price,
													'sub_type'		=> $sub_type,
													'business_id'	=> $cust_id,
													'created_ts'	=> date("Y-m-d h:i:s")
												);
										$this->db->insert("transaction_details",$arr);
										$EncKey = "Bmt@1234"; //For security
										$block = mcrypt_get_block_size('des', 'ecb');
										if (($pad = $block - (strlen($cust_id) % $block)) < $block) {
											$cust_id .= str_repeat(chr($pad), $pad);
										}
										$cust_id= base64_encode(mcrypt_encrypt(MCRYPT_DES, $EncKey, $cust_id, MCRYPT_MODE_ECB));														
										echo '<script>alert("Payment Successful. Our Representative will contact you soon");window.location="'.base_url('bookmyt/thankyou').'/'.$cust_id.'";</script>';		
									}else{
										$profile_id='';
										$payment_profile_id='';
										if(isset($payment['response'])){
											$profile_id=$payment['response']->profile->customerProfileId;
											$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
										}
										$this->bookmyt_model->update_payment_status($cust_id,$validate_transaction['reason'],"failure",'','',$profile_id,$payment_profile_id);
										echo '<script>alert("Payment Unsuccessful due to '.$validate_transaction['reason'].'. Our Representative will contact you soon.");window.location="'.base_url('bookmyt/home').'";</script>';
									}
								}else{
									$profile_id='';
									$payment_profile_id='';
									if(isset($payment['response'])){
										$profile_id=$payment['response']->profile->customerProfileId;
										$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
									}
									$this->bookmyt_model->update_payment_status($cust_id,$validate_transaction['reason'],"failure",'','',$profile_id,$payment_profile_id);
									echo '<script>alert("Payment Unsuccessful due to '.$validate_transaction['reason'].'. Our Representative will contact you soon.");window.location="'.base_url('bookmyt/home').'";</script>';
								}
							}else{
								$this->bookmyt_model->update_payment_status($cust_id,$validate_transaction['reason'],"failure",'','',$profile_id,$payment_profile_id);
								echo '<script>alert("Payment Unsuccessful due to '.$validate_transaction['reason'].'. Our Representative will contact you soon.");window.location="'.base_url('bookmyt/home').'";</script>';
							}
						}else{
							echo '<script>alert("Our Representative will contact you soon");window.location="'.base_url('bookmyt/home').'";</script>';
						}
						//$this->session->set_flashdata('succ','Our Representative will contact you soon');
						
					}
					//redirect('bookmyt/home/');
				}
			}			
		}
		else
		{
			
			$data['business_types'] = $this->bookmyt_model->get_business_types();
			$data['zones']          = $this->bookmyt_model->get_zones();
			$this->load->view('home',$data);
		}
			
	}
	//Thank you Page after Registration
	function thankyou($cust_id){
		$EncKey = "Bmt@1234"; //For security									
		$cust_id = mcrypt_decrypt(MCRYPT_DES, $EncKey, base64_decode($cust_id), MCRYPT_MODE_ECB);
		# Strip padding out.
		$block = mcrypt_get_block_size('des', 'ecb');
		$pad = ord($cust_id[($len = strlen($cust_id)) - 1]);
		$cust_id = substr($cust_id, 0, strlen($cust_id) - $pad);
		$data['userdata'] = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "business_id" => $cust_id
					)
				));
		$this->load->view('thankyou',$data);		
	}
	// Update Profile
	function update_subscription_plan( $subscription_id,$price,$bid,$bname )
	{
		
		// Load the ARB lib
		$this->load->library('authorize_arb');
		// Start with an update object
		$this->authorize_arb->startData('update');
		
		// Locally-defined reference ID (can't be longer than 20 chars)
		$refId = substr(md5( microtime() . 'ref' ), 0, 20);
		$this->authorize_arb->addData('refId', $refId);
		
		// The subscription ID that we're editing
		$this->authorize_arb->addData('subscriptionId', $subscription_id);
		
		// Data must be in this specific order
		// For full list of possible data, refer to the documentation:
		// http://www.authorize.net/support/ARB_guide.pdf
		//$price=1;
		$subscription_data = array(
			'name' => $bname,
			'paymentSchedule' => array(
				'totalOccurrences' => 9999,
				'trialOccurrences' => 0,
				),
			'amount' => $price,
			'trialAmount' => 0,
			'order' => array(
				'invoiceNumber' => $bid,
				'description' => 'Book My T Registration',
				),
			);
		
		$this->authorize_arb->addData('subscription', $subscription_data);
		
		// Send request
		if( $this->authorize_arb->send() )
		{
			$data=array("status"=> "success","id"=>$this->authorize_arb->getRefId());
			return $data;
		}
		else
		{
			$data=array("status"=>"failure","reason"=>$this->authorize_arb->getError());
			return $data;
		}
		// Show debug data
		//$this->authorize_arb->debug();
	}
	//
	// Create a transaction.
	//
	function createtransaction($profile_id, $payment_profile_id, $shipping_profile_id,$amount,$users)
	{
		$this->load->library("authorizecimlib");
		//echo $profile_id.'</br>'.$payment_profile_id.'</br>'.$shipping_profile_id.'</br>'.$amount.'</br>'.$users;exit;
		//$amount=1;
		$this->authorizecimlib->set_data('amount', $amount);
		$this->authorizecimlib->set_data('customerProfileId', $profile_id);
		$this->authorizecimlib->set_data('customerPaymentProfileId', $payment_profile_id);
		$this->authorizecimlib->set_data('customerShippingAddressId', $shipping_profile_id);
		//$this->authorizecimlib->set_data('cardCode', '123');
		
		$unit_price=round($amount/$users,2);
		$this->authorizecimlib->setLineItem($this->session->userdata('business_id'), 'User Addition', 'Adding extra Users', $users, $unit_price);
	
		//echo '<h1>Creating A Transaction Profile - create_customer_transaction_profile()</h1>';
		if($this->authorizecimlib->get_validationmode() != 'none')
		{
			$this->data['approvalcode'] = $this->authorizecimlib->get_direct_response();
		}	
		
		// Types: 'profileTransAuthCapture', 'profileTransCaptureOnly', 'profileTransAuthOnly'
		if(! $this->data['approvalcode'] = $this->authorizecimlib->create_customer_transaction_profile('profileTransAuthCapture'))
		{
			$data=array('status'=>'failure');
			$data['error']=$this->authorizecimlib->get_error_msg();
			
		}else{
			$data=array('status'=>'success');
			$data['transaction_id']=$this->data['approvalcode'];
		}
		
		// Find out if it was approved or not.
		$dat= $this->data['approvalcode'];
		return $data;
	}
	
	//
	// Create complete customer profile.
	//
	function createcustomerprofile()
	{ 
		$this->load->library("authorizecimlib");
		// Create the basic profile
		$this->authorizecimlib->set_data('email', 'satishm@toyaja.com');
		$this->authorizecimlib->set_data('description', 'Monthly Membership No. ' . md5(uniqid(rand(), true)));
		$this->authorizecimlib->set_data('merchantCustomerId', substr(md5(uniqid(rand(), true)), 16, 16));
    
		echo '<h1>Creating Customer Profile - create_customer_profile()</h1>';
		
		if(! $this->data['profileid'] = $this->authorizecimlib->create_customer_profile())
		{
			echo '<p> Error: ' . $this->authorizecimlib->get_error_msg() . '</p>';
			die();
		}
				
		echo '<p> Customer Id: ' . $this->data['profileid'] . '</p>';

 		$expiry=(date("Y") + 1) . '-12';
		//$expiry='2021-04';
    // Create the Payment Profile
		$this->authorizecimlib->set_data('customerProfileId', $this->data['profileid']);
		$this->authorizecimlib->set_data('billToFirstName', 'Satish');
		$this->authorizecimlib->set_data('billToLastName', 'Moka');
		$this->authorizecimlib->set_data('billToAddress', 'Madhapur');
		$this->authorizecimlib->set_data('billToCity', 'Hyderabad');
		$this->authorizecimlib->set_data('billToState', 'NJ');
		$this->authorizecimlib->set_data('billToZip', '12345');
		$this->authorizecimlib->set_data('billToCountry', 'US');
		$this->authorizecimlib->set_data('billToPhoneNumber', '800-555-1234');
		$this->authorizecimlib->set_data('billToFaxNumber', '800-555-2345');
		//$this->authorizecimlib->set_data('cardNumber', '6111111111111111'); // will produce a decline
		$this->authorizecimlib->set_data('cardNumber', '4111111111111111');
		$this->authorizecimlib->set_data('expirationDate', $expiry);
		
		echo '<h1>Creating Payment Profile - create_customer_payment_profile()</h1>';
		
		if(! $this->data['paymentprofileid'] = $this->authorizecimlib->create_customer_payment_profile())
		{
			echo '<p> Error: ' . $this->authorizecimlib->get_error_msg() . '</p>';
			die();
		}
		
		// Find out if it was approved or not.
		$this->_validateresponse();
		
		echo '<p> Payment Profile Id: ' . $this->data['paymentprofileid'] . '</p>';
			 
		 
    // Create the shipping profile
		$this->authorizecimlib->set_data('customerProfileId', $this->data['profileid']);
		$this->authorizecimlib->set_data('shipToFirstName', 'Satish');
		$this->authorizecimlib->set_data('shipToLastName', 'Moka');
		$this->authorizecimlib->set_data('shipToAddress', 'Madhapur');
		$this->authorizecimlib->set_data('shipToCity', 'Hyderabad');
		$this->authorizecimlib->set_data('shipToState', 'NJ');
		$this->authorizecimlib->set_data('shipToZip', '12345');
		$this->authorizecimlib->set_data('shipToCountry', 'US');
		$this->authorizecimlib->set_data('shipToPhoneNumber', '800-555-3456');
		$this->authorizecimlib->set_data('shipToFaxNumber', '800-555-4567');

		echo '<h1>Creating Shipping Profile - create_customer_shipping_profile()</h1>';
		
		if(! $this->data['shippingprofileid'] = $this->authorizecimlib->create_customer_shipping_profile())
		{
			echo '<p> Error: ' . $this->authorizecimlib->get_error_msg() . '</p>';
			die();
		}
		
		echo '<p> Shipping Profile Id: ' . $this->data['shippingprofileid'] . '</p>';
		
		$this->authorizecimlib->clear_data();
	}
	function myBusiness(){
		if($this->session->userdata('business_id')){
			if($this->session->userdata('log_type')=='User'){
				echo '<script>alert("Access denied for this user to access this screen.");window.location="'.base_url('bookmyt/my_user/'.$this->session->userdata('user_id')).'"</script>';
			}else{
				$data['userdata'] = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "business_id" => $this->session->userdata('business_id')
					)
				));
				$data['payment_details']=$this->bookmyt_model->KM_first(array(
					"class" => "payment_details",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "business_id" => $this->session->userdata('business_id')
					)
				));
				$data['transaction_details']=$this->bookmyt_model->KM_first(array(
					"class" => "transaction_details",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "business_id" => $this->session->userdata('business_id')
					)
				));
				
				$bid=$this->session->userdata('business_id');
				$sql="select * from transaction_details where business_id='$bid'";
				$query=$this->db->query($sql);
				$data['transaction_details']=$query->result_array();
				$query = $this->db->query("select a.business_id,a.table,a.business_email,a.phone_no,a.is_delete from
	(select user_id business_id,'user_details' as `table`,email business_email,phone_no,is_delete from user_details where (business_id='$bid' or relationship_id='$bid') and is_delete!=1
	union all
	select business_id,'business_entity' as `table`,business_email,phone_no,is_delete from business_entity where (business_id='$bid' or relationship_id='$bid') and is_delete!=1) a");
				$data['user_details']=$query->result_array();							
				$this->load->view("my_business",$data);
			}
		}else{
			redirect('bookmyt/home');
		}
	}
	// Cancel Profile
	function cancel( $subscription_id )
	{
		// Load the ARB lib
		$this->load->library('authorize_arb');
		
		//echo '<h1>Canceling Profile</h1>';
		
		// Start with a cancel object
		$this->authorize_arb->startData('cancel');
		
		// Locally-defined reference ID (can't be longer than 20 chars)
		$refId = substr(md5( microtime() . 'ref' ), 0, 20);
		$this->authorize_arb->addData('refId', $refId);
		
		// The subscription ID that we're canceling
		$this->authorize_arb->addData('subscriptionId', $subscription_id);
		$data=array();
		// Send request
		if( $this->authorize_arb->send() )
		{
			$data['status']="Success";
			$data['reference_id']=$this->authorize_arb->getRefId();
			//return $this->authorize_arb->getRefId();
		}
		else
		{
			//echo '<h1>Epic Fail!</h1>';
			$data['status']="Failure";
			$data['reason']=$this->authorize_arb->getError();
			//return $this->authorize_arb->getError();
		}
		return $data;
		// Show debug data
		//$this->authorize_arb->debug();
	}
	function change_plan(){
		if($this->session->userdata('business_id')){
			$data['userdata'] = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_id" => $this->session->userdata('business_id')
				)
			));
			$bid=$this->session->userdata('business_id');
			$sql="insert into business_entity_revision (business_id,branch,business_name,business_email,`password`,time_zone,address,phone_no,zipcode,city,state,
country,business_typeid,subscription_type,substart,have_branches,login_count,
last_login,is_active,created_ts,is_admin,your_name,owner_name,no_of_emps,year_establish,
want_demo,business_type,login_via,i_agress,no_of_users,subscription_end_dt,logged_in,price,
payment_status,transaction_status,is_delete,rewards_bill)  
select business_id,branch,business_name,business_email,`password`,time_zone,address,phone_no,zipcode,city,state,
country,business_typeid,subscription_type,substart,have_branches,login_count,
last_login,is_active,created_ts,is_admin,your_name,owner_name,no_of_emps,year_establish,
want_demo,business_type,login_via,i_agress,no_of_users,subscription_end_dt,logged_in,price,
payment_status,transaction_status,is_delete,rewards_bill from business_entity where business_id='$bid'";
			$this->db->query($sql);
			$data['payment_details']=$this->bookmyt_model->KM_first(array(
				"class" => "payment_details",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_id" => $this->session->userdata('business_id')
				)
			));
			$post=$this->input->post();
			$add=$data['userdata']['address'];
			$plan=$this->input->post('plan');
			$city=$data['userdata']['city'];
			$state=$data['userdata']['state'];
			$zip=$data['userdata']['zipcode'];
			$no_of_users=$this->input->post('no_of_users');
			$cust_id=$this->session->userdata('business_id');
			if($this->input->post('subscription_type')==2 && $plan=='multiple' && $this->input->post('RadioGroup1')==1){			
				$date1=date_create(date('Y-m-d',strtotime($data['userdata']['subscription_end_dt'])));
				$date2=date_create(date('Y-m-d'));
				$diff=date_diff($date2,$date1);
				$diff= $diff->format("%R%a");
				$days=cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($data['userdata']['subscription_end_dt'])),date('Y',strtotime($data['userdata']['subscription_end_dt'])));
				$used_days=$days-$diff;
				
				$cur_price_per_day=INDIVIDUAL_MONTHLY_PRICE/$days;
				$cur_price_per_day=round($cur_price_per_day,2);
				$upg_price_per_day=MULTIPLE_MONTHLY_PRICE/$days;
				$upg_price_per_day=round($upg_price_per_day,2);
				$cur_price_per_user=$cur_price_per_day*(int)$used_days;
				$upg_price_per_user=$upg_price_per_day*(int)$diff;
				$rem_amount=INDIVIDUAL_MONTHLY_PRICE-$cur_price_per_user;
				$adj_amount=$upg_price_per_user-$rem_amount;
				$adj_amount=$adj_amount*$no_of_users;//Current Transaction Amount
				
				$price=MULTIPLE_MONTHLY_PRICE*$no_of_users;//Subscription Amount
				
				$transaction_detials=$this->createtransaction($data['payment_details']['profile_id'], $data['payment_details']['payment_profile_id'], $data['payment_details']['shipping_profile_id'],$adj_amount,$no_of_users);
				if($transaction_details['status']=="success"){
					$userdata=$data['userdata'];
					$this->send_receipt($userdata['business_id'],$extra_amount,$userdata['your_name'],"Book My T - Multiple Monthly",$transaction_details['transaction_id'][6],$transaction_details['transaction_id'][4],$transaction_details['transaction_id'][50],$transaction_details['transaction_id'][51],$userdata['business_email'],$userdata['zipcode'],$userdata['country'],'',"Subscription Update");	
					
					$reference_id=$this->update_subscription_plan($this->input->post('subscription_id'),$price,$this->session->userdata('business_id'),$data['userdata']['business_name']);
					$subscription_type=4;
					$bus_type="L";				
					if($reference_id['status']=='success'){
						$this->session->set_userdata('subscription_type',$subscription_type);
						$this->session->set_userdata('have_branches',1);
						$data2=array(
								'no_of_users'			=> $no_of_users,
								'subscription_type'		=> $subscription_type,
								'business_type'			=> $bus_type,
								'transaction_status'	=> (string)$reference_id['id'],
								'price'					=> $price
							);
						
						$this->db->update("business_entity",$data2,array('business_id'=>$this->session->userdata('business_id')));
						$data1=array(
										'sub_start'		=> $data['userdata']['substart'],									
										'sub_end'		=> $data['userdata']['subscription_end_dt'],
										'price'			=> $adj_amount,
										'sub_type'		=> $subscription_type,
										'business_id'	=> $this->session->userdata('business_id'),
										'created_ts'	=> date('Y-m-d H:i:s')
									);
						$this->db->insert("transaction_details",$data1);
						$success="We have upgraded your plan. You can now add multiple branches under Branch menu.";
						$this->session->set_flashdata("success",$success);
					}else{
						$success="Subscription update is failed due to ".$reference_id['reason'];
					}
				}else{
					$success="Subscription update is failed due to ".$transaction_details['error'];
				}
			}else if($this->input->post('subscription_type')==2 && $plan=='multiple' && $this->input->post('RadioGroup1')==2){
				$date1=date_create(date('Y-m-d',strtotime($data['userdata']['subscription_end_dt'])));
				$date2=date_create(date('Y-m-d'));
				$diff=date_diff($date2,$date1);
				$diff= $diff->format("%R%a");
				$days=cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($data['userdata']['subscription_end_dt'])),date('Y',strtotime($data['userdata']['subscription_end_dt'])));
				$used_days=$days-$diff;
				
				$cur_price_per_day=INDIVIDUAL_MONTHLY_PRICE/$days;
				$cur_price_per_day=round($cur_price_per_day,2);
				$upg_price_per_day=MULTIPLE_ANNUAL_PRICE/365;
				$upg_price_per_day=round($upg_price_per_day,2);
				$cur_price_per_user=$cur_price_per_day*(int)$used_days;
				$upg_price_per_user=$upg_price_per_day*(int)$diff;
				$rem_amount=INDIVIDUAL_MONTHLY_PRICE-$cur_price_per_user;
				$adj_amount=$upg_price_per_user-$rem_amount;
				$adj_amount=$adj_amount*$no_of_users;//Current Transaction Amount
				
				$price=MULTIPLE_ANNUAL_PRICE*$no_of_users;//Subscription Amount
				$sub_type=5;
				$validate_transaction=$this->validate($post,$adj_amount,$sub_type,$cust_id,$add,$city,$state,$zip);					
				if($validate_transaction['status']=='success'){
					$this->send_receipt($cust_id,$price,$validate_transaction['card'][13],$validate_transaction['card'][8],$validate_transaction['transaction_id'],$validate_transaction['approval_code'],$validate_transaction['card'][50],$validate_transaction['card'][51],$validate_transaction['card'][23],$validate_transaction['card'][19],$validate_transaction['card'][20],'',$sub_type1);
					$date=$data['userdata']['subscription_end_dt'];
					$payment=$this->create($post,$price,$sub_type,$cust_id,$add,$city,$state,$zip,$date);
					if(!empty($payment)){
						if($payment['status']=='success'){
							$profile_id='';
							$payment_profile_id='';
							if(isset($payment['response'])){
								$profile_id=$payment['response']->profile->customerProfileId;
								$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
							}
							$this->cancel($this->input->post('subscription_id'));
							$this->bookmyt_model->update_payment_status($cust_id,$payment['id'],"success",$sub_type,$price,$profile_id,$payment_profile_id);
							$data1=array(
											'sub_start'		=> $data['userdata']['substart'],									
											'sub_end'		=> $data['userdata']['subscription_end_dt'],
											'price'			=> $adj_amount,
											'sub_type'		=> $sub_type,
											'business_id'	=> $this->session->userdata('business_id'),
											'created_ts'	=> date('Y-m-d H:i:s')
										);
							$this->db->insert("transaction_details",$data1);
							
							$success="We have upgraded your plan. You can now add multiple branches under Branch menu.";
							$this->session->set_flashdata("success",$success);
						}else{
							$profile_id='';
							$payment_profile_id='';
							if(isset($payment['response'])){
								$profile_id=$payment['response']->profile->customerProfileId;
								$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
							}
							//$this->bookmyt_model->update_payment_status($cust_id,$payment['reason'],"failure",'','',$profile_id,$payment_profile_id);
							$success="Subscription update is failed due to ".$payment['reason'];
						}
					}
				}else{
					$success="Subscription update is failed due to ".$validate_transaction['reason'];
				}
			}else if($this->input->post('subscription_type')==3 && $plan=='multiple' && $this->input->post('RadioGroup1')==2){
				$date1=date_create(date('Y-m-d',strtotime($data['userdata']['subscription_end_dt'])));
				$date2=date_create(date('Y-m-d'));
				$diff=date_diff($date2,$date1);
				$diff= $diff->format("%R%a");
				$days=365;				//$days=cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($data['userdata']['subscription_end_dt'])),date('Y',strtotime($data['userdata']['subscription_end_dt'])));
				$used_days=$days-$diff;
				
				$cur_price_per_day=INDIVIDUAL_ANNUAL_PRICE/$days;
				$cur_price_per_day=round($cur_price_per_day,2);
				$upg_price_per_day=MULTIPLE_ANNUAL_PRICE/$days;
				$upg_price_per_day=round($upg_price_per_day,2);
				$cur_price_per_user=$cur_price_per_day*(int)$used_days;
				$upg_price_per_user=$upg_price_per_day*(int)$diff;
				$rem_amount=INDIVIDUAL_ANNUAL_PRICE-$cur_price_per_user;
				$adj_amount=$upg_price_per_user-$rem_amount;
				$adj_amount=$adj_amount*$no_of_users;//Current Transaction Amount
					
				$price=MULTIPLE_ANNUAL_PRICE*$no_of_users;// Next Subscription Amount
				$transaction_details=$this->createtransaction($data['payment_details']['profile_id'], $data['payment_details']['payment_profile_id'], $data['payment_details']['shipping_profile_id'],$adj_amount,$no_of_users);
				if($transaction_details['status']=='success'){
					$this->send_receipt($userdata['business_id'],$extra_amount,$userdata['your_name'],"Book My T - Multiple Monthly",$transaction_details['transaction_id'][6],$transaction_details['transaction_id'][4],$transaction_details['transaction_id'][50],$transaction_details['transaction_id'][51],$userdata['business_email'],$userdata['zipcode'],$userdata['country'],'',"Subscription Update");
					$reference_id=$this->update_subscription_plan($this->input->post('subscription_id'),$price,$this->session->userdata('business_id'),$data['userdata']['business_name']);
					$subscription_type=5;
					$bus_type="L";				
					if($reference_id['status']=='success'){
						$this->session->set_userdata('subscription_type',$subscription_type);
						$data2=array(
								'no_of_users'			=> $no_of_users,
								'subscription_type'		=> $subscription_type,
								'business_type'			=> $bus_type,
								'transaction_status'	=> (string)$reference_id['id'],
								'price'					=> $price
							);
						
						$this->db->update("business_entity",$data2,array('business_id'=>$this->session->userdata('business_id')));
						$data1=array(
										'sub_start'		=> $data['userdata']['substart'],									
										'sub_end'		=> $data['userdata']['subscription_end_dt'],
										'price'			=> $adj_amount,
										'sub_type'		=> $subscription_type,
										'business_id'	=> $this->session->userdata('business_id'),
										'created_ts'	=> date('Y-m-d H:i:s')
									);
						$this->db->insert("transaction_details",$data1);					
						$success="We have upgraded your plan. You can now add multiple branches under Branch menu.";
						$this->session->set_flashdata("success",$success);
					}else{
						$success="Subscription update is failed due to ".$reference_id['reason'];
					}
				}else{
					$success="Subscription update is failed due to ".$reference_id['reason'];
				}
			}
			echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/myBusiness').'"</script>';			
		}else{
			redirect('bookmyt/home');
		}
	}
	function unsubscribe(){
		if($this->session->userdata('business_id')){
			$no_of_users=$this->input->post('no_of_users');
			if($this->input->post('subscription')==2){
				$price=INDIVIDUAL_MONTHLY_PRICE;
			}else if($this->input->post('subscription')==3){
				$price=INDIVIDUAL_ANNUAL_PRICE;
			}else if($this->input->post('subscription')==4){
				$price=MULTIPLE_MONTHLY_PRICE;
			}else if($this->input->post('subscription')==5){
				$price=MULTIPLE_MONTHLY_PRICE;
			}
			$user_count=count($this->input->post('user_id'));
			$users=$this->input->post('user_id');
			$count=$no_of_users-$user_count;
			$updated_price=$price*$count;
			
			// Load the ARB lib
			$this->load->library('authorize_arb');		
			
			// Start with an update object
			$this->authorize_arb->startData('update');
			
			// Locally-defined reference ID (can't be longer than 20 chars)
			$refId = substr(md5( microtime() . 'ref' ), 0, 20);
			$this->authorize_arb->addData('refId', $refId);
			
			// The subscription ID that we're editing
			$this->authorize_arb->addData('subscriptionId', $this->input->post('subscription_id'));
			
			//Changed by Pradeep for price
			//$updated_price=1;
			// Data must be in this specific order
			// For full list of possible data, refer to the documentation:
			// http://www.authorize.net/support/ARB_guide.pdf
			$subscription_data = array(
				'name' => $this->input->post('business_name'),
				'paymentSchedule' => array(
					'totalOccurrences' => 9999,
					'trialOccurrences' => 0,
					),
				'amount' => $updated_price,
				'trialAmount' => 0,
				'order' => array(
					'invoiceNumber' => $this->session->userdata('business_id'),
					'description' => 'Book My T Registration',
					),
				);
			
			$this->authorize_arb->addData('subscription', $subscription_data);
			
			// Send request
			if( $this->authorize_arb->send() )
			{
				$reference_id= $this->authorize_arb->getRefId();
				$success="User(s) unsubscribed successfully. You will not be charged from next billing.";
				$data=array(
							'no_of_users'			=> $count,
							'transaction_status'	=> (string)$reference_id,
							'price'					=> $updated_price							
						);
				$this->db->update("business_entity",$data,array('business_id'=>$this->session->userdata('business_id')));
				if($user_count>0){
					foreach($users as $user){
						$user_d=explode("^",$user);
						$data1=array(
									'is_delete'	=> 1
								);
						if($user_d[1]=='user_details'){
							$this->db->update("user_details",$data1,array('user_id'=>$user_d[0]));
						}else if($user_d[1]=='business_entity'){
							$this->db->update('business_entity',$data1,array('business_id'=>$user_d[0]));
						}
					}
				}
			}
			else
			{
				
				$reference_id= $this->authorize_arb->getError();
				$success="User(s) unsubscription failed due to ".$reference_id;
			}
			echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/myBusiness').'"</script>';		
		}else{
			redirect('bookmyt/home');
		}
	}
	function add_user_subscription(){
		if($this->session->userdata('business_id')){
			$userdata = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_id" => $this->session->userdata('business_id')
				)
			));
			$payment_details = $this->bookmyt_model->KM_first(array(
				"class" => "payment_details",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_id" => $this->session->userdata('business_id')
				)
			));
			$date1=date_create(date('Y-m-d',strtotime($userdata['subscription_end_dt'])));
			$date2=date_create(date('Y-m-d'));
			$diff=date_diff($date2,$date1);
			$diff= $diff->format("%R%a");			
			$days=cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($userdata['subscription_end_dt'])),date('Y',strtotime($userdata['subscription_end_dt'])));
			
			
			$existing_users=$userdata['no_of_users'];
			$new_users=$this->input->post('no_of_users');
			$users=$new_users;
			$sub_type=$this->input->post('subscription_type');
			if($sub_type==2){
				$price=INDIVIDUAL_MONTHLY_PRICE*$users;
				$per_day_price=INDIVIDUAL_MONTHLY_PRICE/$days;
			}else if($sub_type==3){
				$price=INDIVIDUAL_ANNUAL_PRICE*$users;
				$per_day_price=INDIVIDUAL_ANNUAL_PRICE/365;
			}else if($sub_type==4){
				$price=MULTIPLE_MONTHLY_PRICE*$users;
				$per_day_price=MULTIPLE_MONTHLY_PRICE/$days;
			}else if($sub_type==5){
				$price=MULTIPLE_MONTHLY_PRICE*$users;
				$per_day_price=MULTIPLE_MONTHLY_PRICE/365;
			}
			
			$extra_amount=$per_day_price*$users*(int)$diff;
			$extra_amount=round($extra_amount,2);
			$transaction_details=$this->createtransaction($payment_details['profile_id'],$payment_details['payment_profile_id'],$payment_details['shipping_profile_id'],$extra_amount,$users);
			//pr($transaction_details);exit;
			if($transaction_details['status']=="success"){
				$this->send_receipt($userdata['business_id'],$extra_amount,$userdata['your_name'],"User Addition",$transaction_details['transaction_id'][6],$transaction_details['transaction_id'][4],$transaction_details['transaction_id'][50],$transaction_details['transaction_id'][51],$userdata['business_email'],$userdata['zipcode'],$userdata['country'],$users,"Book My T - Adding User");			
				$dat=array(
							'sub_start'		=> $userdata['substart'],						
							'sub_end'		=> $userdata['subscription_end_dt'],
							'price'			=> $extra_amount,
							'sub_type'		=> $sub_type,
							'business_id'	=> $this->session->userdata('business_id'),
							'created_ts'	=> date("Y-m-d H:i:s")
						);
				$this->db->insert("transaction_details",$dat);		
				$this->load->library("authorizecimlib");
				$this->authorizecimlib->clear_data();
				$old_price=$userdata['price'];
				$new_price=$old_price+$price;
				
				// Load the ARB lib
				$this->load->library('authorize_arb');		
				
				// Start with an update object
				$this->authorize_arb->startData('update');
				
				// Locally-defined reference ID (can't be longer than 20 chars)
				$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				$this->authorize_arb->addData('refId', $refId);
				
				// The subscription ID that we're editing
				$this->authorize_arb->addData('subscriptionId', $this->input->post('subscription_id'));
				
				// Data must be in this specific order
				// For full list of possible data, refer to the documentation:
				// http://www.authorize.net/support/ARB_guide.pdf
				//Price Change
				//$new_price=1;
				$subscription_data = array(
					'name' => $userdata['business_name'],
					'paymentSchedule' => array(
						'totalOccurrences' => 9999,
						'trialOccurrences' => 0,
						),
					'amount' => $new_price,
					'trialAmount' => 0,
					'order' => array(
						'invoiceNumber' => $this->session->userdata('business_id'),
						'description' => 'Book My T Registration',
						),
					);
				
				$this->authorize_arb->addData('subscription', $subscription_data);
				
				// Send request
				if( $this->authorize_arb->send() )
				{
					$reference_id= $this->authorize_arb->getRefId();
					$success="Payment successful for the user(s).You can now add user(s) under Users menu";
					$data=array(
								'no_of_users'			=> $new_users+$existing_users,
								'transaction_status'	=> (string)$reference_id,
								'price'					=> $new_price
							);
					$this->db->update("business_entity",$data,array('business_id'=>$this->session->userdata('business_id')));
				}
				else
				{
					
					$reference_id= $this->authorize_arb->getError();
					$success="Users addition failed due to ".$reference_id;
				}
			}else{
				$reference_id= $transaction_details['error'];
				$success="Users addition failed due to ".$reference_id;
				$this->session->set_flashdata("error",$success);
			}
			echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/myBusiness').'"</script>';
		}else{
			redirect('bookmyt/home');
		}
	}
	function cancel_account(){
		if($this->session->userdata('business_id')){
			$subscription_id=$this->input->post('subscription_id');
			$cancel=$this->cancel($subscription_id);
			if($cancel['status']=="Success"){
				$success="Subscription cancelled successfully.";
				echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/cancel_feedback').'"</script>';
			}else{
				$success="Subscription cancellation failed due to ".$cancel['reason'];
				echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/myBusiness').'"</script>';
			}
			
		}else{
			redirect('bookmyt/home');
		}
	}
	function cancel_feedback(){
		if($this->session->userdata('business_id')){
			if($this->input->post()){
				$this->form_validation->set_rules('experience', 'Rate your experience', 'required');
				$this->form_validation->set_rules('reason', 'Specific reason for cancellation', 'required');				
				if ($this->form_validation->run() == FALSE){
					$data['userdata'] = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "business_id" => $this->session->userdata('business_id')
						)
					));
					$this->load->view('cancel_feedback',$data);
				}else{
					$data=array(
								'rating'		=> $this->input->post('experience'),
								'reason'		=> $this->input->post('reason'),
								'business_id'	=> $this->session->userdata('business_id'),
								'created_ts'	=> date("Y-m-d H:i:s")
							);
					$this->db->insert("cancel_feedback",$data);
					$this->session->set_flashdata("success","Feedback Submitted successfully");
					redirect('bookmyt/myBusiness');		
				}
			}else{
				$data['userdata'] = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "business_id" => $this->session->userdata('business_id')
					)
				));
				$this->load->view('cancel_feedback',$data);
			}
		}else{
			redirect('bookmyt/home');
		}
	}
	function feedback_done($feedback_id)
	{
		$data['feedback_details']=$this->bookmyt_model->KM_first(array(
				"class" => "reward_point_history",
				"fields" => array(
					'*'
				),
				"conditions" => array(

				  "id" => $feedback_id
				)
			));

		$data['reward_info'] = $this->bookmyt_model->get_rewards_info($data['feedback_details']['customer_id'], $data['feedback_details']['business_id']);
		
		$this->load->view("feedback_done",$data);
	}
	function change_card(){
		if($this->session->userdata('business_id')){
			$cc=str_replace(" ","",$this->input->post('card_number'));
			$expiry=$this->input->post('year').'-'.$this->input->post('month');
			$cvv=$this->input->post('cvv');
			// Load the ARB lib
			$this->load->library('authorize_arb');		
			
			// Start with an update object
			$this->authorize_arb->startData('update');
			
			// Locally-defined reference ID (can't be longer than 20 chars)
			$refId = substr(md5( microtime() . 'ref' ), 0, 20);
			$this->authorize_arb->addData('refId', $refId);
			
			// The subscription ID that we're editing
			$this->authorize_arb->addData('subscriptionId', $this->input->post('subscription_id'));
			
			// Data must be in this specific order
			// For full list of possible data, refer to the documentation:
			// http://www.authorize.net/support/ARB_guide.pdf
			$subscription_data = array(
				'name' => $this->input->post('business_name'),
				'paymentSchedule' => array(
					'totalOccurrences' => 9999,
					'trialOccurrences' => 0,
					),
				'payment' => array(
					'creditCard' => array(
						'cardNumber' => $cc,
						'expirationDate' => $expiry,
						'cardCode' => $cvv,
						),
					),				
				'order' => array(
					'invoiceNumber' => $this->session->userdata('business_id'),
					'description' => 'Book My T Registration',
					),
				);
			
			$this->authorize_arb->addData('subscription', $subscription_data);
			
			// Send request
			if( $this->authorize_arb->send() )
			{
				$reference_id= $this->authorize_arb->getRefId();
				$success="Credit card details updated successfully";
				$data=array(
							'credit_card'		=> substr($cc,-4),
							'expiry'			=> $expiry,
							'cardholder_name'	=> $this->input->post('cardholder')	
						);
				$this->db->update('payment_details',$data,array('business_id'=>$this->session->userdata('business_id')));
			}
			else
			{
				
				$reference_id= $this->authorize_arb->getError();
				$success="Error in updating the credit card details due to ".$reference_id;
			}
			echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/myBusiness').'"</script>';		
		}else{
			redirect('bookmyt/home');
		}
	}
	function change_subscription_type(){
		if($this->session->userdata('business_id')){
			$no_of_users=$this->input->post('no_of_users');
			$subscription_type=$this->input->post('subscription_type');
			$this->cancel($this->input->post('subscription_id'));
			$data['userdata'] = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_id" => $this->session->userdata('business_id')
				)
			));
			$data['payment_details']=$this->bookmyt_model->KM_first(array(
				"class" => "payment_details",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_id" => $this->session->userdata('business_id')
				)
			));
			$bid=$this->session->userdata('business_id');
			$sql="insert into business_entity_revision (business_id,branch,business_name,business_email,`password`,time_zone,address,phone_no,zipcode,city,state,
country,business_typeid,subscription_type,substart,have_branches,login_count,
last_login,is_active,created_ts,is_admin,your_name,owner_name,no_of_emps,year_establish,
want_demo,business_type,login_via,i_agress,no_of_users,subscription_end_dt,logged_in,price,
payment_status,transaction_status,is_delete,rewards_bill)  
select business_id,branch,business_name,business_email,`password`,time_zone,address,phone_no,zipcode,city,state,
country,business_typeid,subscription_type,substart,have_branches,login_count,
last_login,is_active,created_ts,is_admin,your_name,owner_name,no_of_emps,year_establish,
want_demo,business_type,login_via,i_agress,no_of_users,subscription_end_dt,logged_in,price,
payment_status,transaction_status,is_delete,rewards_bill from business_entity where business_id='$bid'";
			//$this->db->query($sql);
			$post=$this->input->post();
			$add=$data['userdata']['address'];
			$plan=$this->input->post('plan');
			$city=$data['userdata']['city'];
			$state=$data['userdata']['state'];
			$zip=$data['userdata']['zipcode'];			
			$cust_id=$this->session->userdata('business_id');
			$date1=date_create(date('Y-m-d',strtotime($data['userdata']['subscription_end_dt'])));
			$date2=date_create(date('Y-m-d'));
			$date3=date_create(date("Y-m-d",strtotime("+1 year")));
			$diff=date_diff($date2,$date1);			
			$diff= $diff->format("%R%a");
			$diff2=date_diff($date2,$date3);			
			$diff2= $diff2->format("%R%a");			
			$days=cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($data['userdata']['subscription_end_dt'])),date('Y',strtotime($data['userdata']['subscription_end_dt'])));
			
			$used_days=$days-$diff;
			
			$cur_price_per_day=INDIVIDUAL_MONTHLY_PRICE/$days;
			$cur_price_per_day=round($cur_price_per_day,2);
			$upg_price_per_day=MULTIPLE_ANNUAL_PRICE/365;
			$upg_price_per_day=round($upg_price_per_day,2);
			$cur_price_per_user=$cur_price_per_day*(int)$used_days;
			$upg_price_per_user=$upg_price_per_day*(int)$diff;
			$rem_amount=INDIVIDUAL_MONTHLY_PRICE-$cur_price_per_user;
			$adj_amount=$upg_price_per_user-$rem_amount;
			$adj_amount=$adj_amount*$no_of_users;//Current Transaction Amount
			if($subscription_type==2){
				$sub_type=3;
				$sub_typ1="Individual Annual";
				$price=INDIVIDUAL_ANNUAL_PRICE*$no_of_users;
				$current_price=INDIVIDUAL_MONTHLY_PRICE*$no_of_users;
				$per_day_price=$price/365;
				$cur_per_day_price=$current_price/$days;
				$cur_price=$cur_per_day_price*(int)$used_days;
				$upg_price=$per_day_price*(int)$diff2;
				$rem_amount=INDIVIDUAL_MONTHLY_PRICE-$cur_price;
				$adj_amount=$upg_price-$rem_amount;
			}else if($subscription_type==3){
				$sub_type=2;
				$price=INDIVIDUAL_MONTHLY_PRICE*$no_of_users;				
			}else if($subscription_type==4){
				$sub_type=5;
				$sub_typ1="Multiple Annual";
				$price=MULTIPLE_ANNUAL_PRICE*$no_of_users;
				$current_price=MULTIPLE_MONTHLY_PRICE*$no_of_users;
				$per_day_price=$price/365;
				$cur_per_day_price=$current_price/$days;
				$cur_price=$cur_per_day_price*(int)$used_days;
				$upg_price=$per_day_price*(int)$diff2;
				$rem_amount=MULTIPLE_MONTHLY_PRICE-$cur_price;
				$adj_amount=$upg_price-$rem_amount;
				
			}else if($subscription_type==5){
				$sub_type=4;
				$price=MULTIPLE_MONTHLY_PRICE*$no_of_users;
			}
			$adj_amount=round($adj_amount,2);
			$date=$data['userdata']['subscription_end_dt'];
			$validate_transaction=$this->validate($post,$adj_amount,$sub_type,$cust_id,$add,$city,$state,$zip);
			if($validate_transaction['status']=='success'){
				$this->send_receipt($cust_id,$price,$validate_transaction['card'][13],"Subscription Update",$validate_transaction['transaction_id'],$validate_transaction['approval_code'],$validate_transaction['card'][50],$validate_transaction['card'][51],$validate_transaction['card'][23],$validate_transaction['card'][19],$validate_transaction['card'][20],'',"Book My T - ".$sub_typ1);
				$payment=$this->create($post,$price,$sub_type,$cust_id,$add,$city,$state,$zip,$date);
				if(!empty($payment)){
					if($payment['status']=='success'){
						$profile_id='';
						$payment_profile_id='';
						if(isset($payment['response'])){
							$profile_id=$payment['response']->profile->customerProfileId;
							$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
						}
						$dat=array(
							'sub_start'		=> $data['userdata']['substart'],						
							'sub_end'		=> date("Y-m-d",strtotime("+1 year")),
							'price'			=> $adj_amount,
							'sub_type'		=> $sub_type,
							'business_id'	=> $this->session->userdata('business_id'),
							'created_ts'	=> date("Y-m-d H:i:s")
						);
						$this->db->insert("transaction_details",$dat);		
	
						$this->bookmyt_model->update_payment_status($cust_id,$payment['id'],"success",$sub_type,$price,$profile_id,$payment_profile_id);
						$this->db->update("business_entity",array("subscription_end_dt"=>date("Y-m-d",strtotime("+1 year"))),array("business_id"=>$cust_id));
						$success="Subscription updated successfully";
						$this->session->set_flashdata('success',$success);
					}else{
						$profile_id='';
						$payment_profile_id='';
						if(isset($payment['response'])){
							$profile_id=$payment['response']->profile->customerProfileId;
							$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
						}
						//$this->bookmyt_model->update_payment_status($cust_id,$payment['reason'],"failure",'','',$profile_id,$payment_profile_id);
						$success="Subscription update is failed due to ".$payment['reason'];
						$this->session->set_flashdata('success',$success);
					}
				}
			}else{
				$success="Subscription update is failed due to ".$payment['reason'];
				$this->session->set_flashdata('success',$success);
			}
			echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/myBusiness').'"</script>';	
		}else{
			redirect('bookmyt/home');
		}
	}
	public function upgrade_plan(){
		if($this->session->userdata('business_id')){
			$userdata = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_id" => $this->session->userdata('business_id')
				)
			));
			$price='';
			$sub_type=$this->input->post('RadioGroup1');
			if($this->input->post('RadioGroup1')==2){
				$price=INDIVIDUAL_MONTHLY_PRICE;
				$sub_type1="Individual Monthly";
				$bus_type="S";
				$end_date=date("Y-m-d",strtotime("+1 month"));
			}else if($this->input->post('RadioGroup1')==3){
				$price=INDIVIDUAL_ANNUAL_PRICE;
				$sub_type1="Individual Annual";
				$bus_type="S";
				$end_date=date("Y-m-d",strtotime("+1 year"));
			}else if($this->input->post('RadioGroup1')==4){
				$price=MULTIPLE_MONTHLY_PRICE;
				$sub_type1="Multiple Monthly";
				$bus_type="L";
				$end_date=date("Y-m-d",strtotime("+1 month"));
			}else if($this->input->post('RadioGroup1')==5){
				$price=MULTIPLE_MONTHLY_PRICE;
				$sub_type1="Multiple Annual";
				$bus_type="L";
				$end_date=date("Y-m-d",strtotime("+1 year"));
			}
			$no_of_users=$this->input->post('no_of_users');
			$total_price=$price*$no_of_users;
			$cust_id=$this->session->userdata('business_id');
			$add=$userdata['address'];
			$city=$userdata['city'];
			$state=$userdata['state'];
			$zip=$userdata['zipcode'];
			$post=$this->input->post();
			$validate_transaction=$this->validate($post,$price,$sub_type,$cust_id,$add,$city,$state,$zip);
			if($validate_transaction['status']=='success'){
				$this->send_receipt($cust_id,$price,$validate_transaction['card'][13],"Subscription Update",$validate_transaction['transaction_id'],$validate_transaction['approval_code'],$validate_transaction['card'][50],$validate_transaction['card'][51],$validate_transaction['card'][23],$validate_transaction['card'][19],$validate_transaction['card'][20],'',"Book My T - ".$sub_typ1);
			$payment=$this->create($post,$price,$sub_type,$cust_id,$add,$city,$state,$zip);
				if(!empty($payment)){
					if($payment['status']=='success'){
						$profile_id='';
						$payment_profile_id='';
						if(isset($payment['response'])){
							$profile_id=$payment['response']->profile->customerProfileId;
							$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
						}
						
						$this->bookmyt_model->update_payment_status($cust_id,$payment['id'],"success",$sub_type,$total_price,$profile_id,$payment_profile_id);
						$this->load->library("authorizecimlib");
						$this->authorizecimlib->clear_data();
		
						$this->db->update("business_entity",array("substart"=>date("Y-m-d"),"subscription_end_dt"=>$end_date,'no_of_users'=>$no_of_users,'business_type'=>$bus_type,'is_active'=>1),array("business_id"=>$cust_id));
						$dat=array(
									'sub_start'		=> date("Y-m-d"),
									'sub_end'		=> $end_date,
									'price'			=> $total_price,
									'sub_type'		=> $sub_type,
									'business_id'	=> $cust_id,
									'created_ts'	=> date("Y-m-d H:i:s")
								);
						$this->db->insert("transaction_details",$dat);		
						$this->session->set_userdata('subscription_type',$sub_type);
						$res="success";
						$success="Subscription updated successfully";
						$this->session->set_flashdata('success',$success);						
					}else{
						$profile_id='';
						$payment_profile_id='';
						if(isset($payment['response'])){
							$profile_id=$payment['response']->profile->customerProfileId;
							$payment_profile_id=$payment['response']->profile->customerPaymentProfileId;
						}
						//$this->bookmyt_model->update_payment_status($cust_id,$payment['reason'],"failure",'','',$profile_id,$payment_profile_id);
						$res="failure";
						$success="Payment failed due to ".$payment['reason'];
						$this->session->set_flashdata('success',$success);
					}
				}
			}else{
				$res="failure";
				$success="Payment failed due to ".$validate_transaction['reason'];
				$this->session->set_flashdata('success',$success);
			}
			if($res=="success"){
				echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/myBusiness').'"</script>';
			}else{
				echo '<script>alert("'.$success.'");window.location="'.base_url('bookmyt/my_business').'"</script>';
			}
			
		}else{
			redirect('bookmyt/home');
		}
	}
	function renew_subscription(){
		$sql="select * from business_entity where is_active=1 and is_delete!=1 and subscription_type!=1";
		$query=$this->db->query($sql);
		$data=$query->result_array();		
		if(!empty($data)){
			foreach($data as $dat){
				if(date("Y-m-d",strtotime($dat['subscription_end_dt']."-1 day"))==date("Y-m-d")){
					if($dat['subscription_type']==2){
						$end_dt=date("Y-m-d",strtotime($dat['subscription_end_dt']."+30 days"));
					}else if($dat['subscription_type']==3){
						$end_dt=date("Y-m-d",strtotime($dat['subscription_end_dt']."+1 year"));
					}else if($dat['subscription_type']==4){
						$end_dt=date("Y-m-d",strtotime($dat['subscription_end_dt']."+30 days"));
					}else if($dat['subscription_type']==5){
						$end_dt=date("Y-m-d",strtotime($dat['subscription_end_dt']."+1 year"));
					}					
					$update_arr=array('substart'=>$dat['subscription_end_dt'],'subscription_end_dt'	=> $end_dt);
					$this->db->update("business_entity",$update_arr,array('business_id'=>$dat['business_id']));
					$transaction_arr=array(
											'sub_start'			=> $dat['subscription_end_dt'],
											'sub_end'			=> $end_dt,
											'price'				=> $dat['price'],
											'sub_type'			=> $dat['subscription_type'],
											'business_id'		=> $dat['business_id']
										);
					$this->db->insert("transaction_details",$transaction_arr);					
				}
			}
		}		
	}
	function checkDupBusinessName(){
		$this->layout=false;
		$business_name=$this->input->post('business_name');
		$query=$this->db->query("select * from business_entity where business_name='$business_name'");
		$data=$query->result_array();
		if(!empty($data)){
			echo "Failure";
		}else{
			echo "Success";
		}
	}
	//Add Floor
	function add_floor(){
		if($this->session->userdata('business_id')){
			if($this->input->post()){
				$this->form_validation->set_rules('floor_no', 'Floor', 'required|max_length[2]');
				$this->form_validation->set_rules('no_of_sections', 'Number of Sections', 'required|is_natural_no_zero');
				if ($this->form_validation->run() == FALSE)
				{
					$business_id=$this->session->userdata('business_id');
					//$have_branches = $this->session->userdata('business_id');
					$data['branches'] = $this->bookmyt_model->get_branches($business_id, $this->session->userdata('have_branches'));
					$this->load->view('add_floor',$data);
				}else{
					if ($this->bookmyt_model->KM_count(array(
						"class" => "floor_chart",
						"conditions" => array(
							"floor_no" => $this->input->post('floor_no'),
							"business_id" => $this->input->post('branch')
						)
					))) 
					{   
						$this->session->set_flashdata('fail','Duplicate Floor');
						redirect('bookmyt/floors');
					} 
					else 
					{
						$sections=$this->bookmyt_model->insert_sections();
						if($sections){
							//$this->session->set_flashdata('success','Floor added successfully.');
							//redirect('bookmyt/floors/');
							echo '<script>alert("Floor added successfully. Proceeding to create sections under this floor");window.location="'.base_url('bookmyt/section_list/'.$sections).'";</script>';
						}else{

							$this->session->set_flashdata('fail','Floor not added.');
							redirect('bookmyt/floors/');
						}
					}
				}
			}else{			
				$business_id=$this->session->userdata('business_id');
				$data['branches'] = $this->bookmyt_model->get_branches($business_id, $this->session->userdata('have_branches'));
				$this->load->view('add_floor',$data);
			}

		}else{
			redirect('bookmyt/home');
		}
	}
	//Edit Floor
	public function edit_floor($floor_id){
		if($this->session->userdata('business_id')){
			if($this->input->post()){
				$this->form_validation->set_rules('floor_no', 'Floor', 'required|max_length[2]');
				$this->form_validation->set_rules('no_of_sections', 'Number of Sections', 'required|is_natural_no_zero');				
				if ($this->form_validation->run() == FALSE){
					$data['floor_id']=$floor_id;
					$data['floor_info']=$this->bookmyt_model->getFloorInfo($floor_id);
					$this->load->view('register/edit_floor',$data);
				}else{
					$flr_id=$floor_id;
					$flr_name=$this->input->post('floor_no');
					$bus_id=$this->input->post('branch');
					$query=$this->db->query("select * from floor_chart where floor_no='$flr_name' and floor_id!='$flr_id' and business_id='$bus_id'");					
					$dat=$query->result_array();
					if(!empty($dat)){   
						$this->session->set_flashdata('fail','Duplicate Floor');
						redirect('bookmyt/floors');
					}else{
						$this->bookmyt_model->updateFloorInfo($floor_id);
						$this->session->set_flashdata("success","Floor updated successfully.");
						redirect('bookmyt/floors');
					}
				}
			}else{
				$data['floor_id']=$floor_id;
				$data['floor_info']=$this->bookmyt_model->getFloorInfo($floor_id);
				$this->load->view('register/edit_floor',$data);
			}
		}else{
			redirect('bookmyt/home');
		}
	}
	//Section List
	public function section_list($id){
		if($this->session->userdata('business_id'))
		{
			//pr($this->session->all_userdata());
			//echo $this->session->userdata('have_branches');
			if(!empty($this->permissions))
			{
				if($this->permissions->floor->view == '' || $this->permissions->floor->view == 0)

				{
					$this->session->set_flashdata('perm','Access Denied');
					redirect('bookmyt/home/');
				}
			}			
			$data['no_of_sections']=$this->bookmyt_model->get_sections_count($id);
			$data['sections'] = $this->bookmyt_model->get_section_list($id,$this->session->userdata('business_id'),$this->session->userdata('have_branches'));
			$data['floor_id']=$id;
			$this->load->view('section_list',$data);
		}
		else
		{
			redirect(base_url());
		}
	}
	//Add Section
	public function add_sections($floor_id,$bus_id)
	{
	
		if($this->session->userdata('business_id'))
		{
			if(!empty($this->permissions))
			{
				if($this->permissions->floor->add == '' || $this->permissions->floor->add == 0)
				{
					$this->session->set_flashdata('perm','Access Denied');
					redirect('bookmyt/home/');
				}
			}
						
			
			if($this->input->post())
			{
				
				$this->form_validation->set_rules('section_name', 'Section Name', 'required');
				$this->form_validation->set_rules('no_of_tables', 'Number of tables', 'required');
				
				if ($this->form_validation->run() == FALSE)
				{
					$business_id=$this->session->userdata('business_id');
					$data['floor_id']=$floor_id;
					$data['bus_id']=$bus_id;
					$data['branches'] = $this->bookmyt_model->get_branches($business_id, $this->session->userdata('have_branches'));					
					$this->load->view('register/add_section',$data);
				}
				else
				{
				
					$url=base_url().'api/business/add_floor/format/json';
					$arr = array('X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru');
					$post_array = array_merge($_POST,$arr);
					$buffer = $this->load_curl_data($url,$post_array);
					$buffer = json_decode($buffer);
					$data['sucess']=$buffer->success;
					if(!empty($buffer))
					{
						$this->session->set_flashdata('success','Section added successfully.');
						redirect('bookmyt/section_list/'.$floor_id);
					}
					else
					{
						$this->session->set_flashdata('fail','Section not added.');
						redirect('bookmyt/section_list/'.$floor_id);
					}	
				}
			}
			else
			{
				$business_id=$this->session->userdata('business_id');
				$data['floor_id']=$floor_id;
				$data['bus_id']=$bus_id;
				$data['branches'] = $this->bookmyt_model->get_branches($business_id, $this->session->userdata('have_branches'));
				$this->load->view('register/add_section',$data);
			}
		}
		else
		{
			redirect(base_url());
		}
	}
	// Add Section
	function addsection()
    {      
		if($this->session->all_userdata())
		{
			$this->layout=false;
			$section_name = $this->input->post('section_name');
			$business_id= $this->input->post('business_id');
			$floor_id= $this->input->post('floor_id');
			$no_of_tables = (int)$this->input->post('no_of_tables');
			$no_of_floors= $this->input->post('no_of_floors');
			$this->load->model('bookmyt_model');
			$tables = $this->input->post('tables');
			$no_of_rows = (int)$this->input->post('no_of_rows');
			$no_of_columns = (int)$this->input->post('no_of_columns');
			//echo '<pre>';print_r($this->input->post());exit;
			if($no_of_rows>10)
			{
				echo 'Please enter no of rows less than or equal to 10.';
				exit;
			}
			if($no_of_columns>10)
			{
				echo 'Please enter no of columns less than or equal to 10.';
				exit;
			}			
			if($no_of_rows == "" || $no_of_rows == '0')
			 {
				 if($no_of_columns !=''){
					$no_of_rows = ceil($no_of_tables/$no_of_columns);
				 }else{
				 $no_of_rows = ceil($no_of_tables/2);
				 }
			 }			
			if($no_of_columns == "" || $no_of_columns == "0")
			{
				 if($no_of_rows != ''){
					$no_of_columns = ceil($no_of_tables/$no_of_rows);
				 }else{
					$no_of_columns = 2;
				 }
			}		 
			 $table_count=$this->bookmyt_model->KM_count(array(
				"class" => "sections",
				"conditions" => array(
				  "business_id" => $business_id
				)
			));
			
			if ($this->bookmyt_model->KM_count(array(
				"class" => "sections",
				"conditions" => array(
					"section_name" => $section_name,
					"business_id" => $business_id,
					"floor_id"	=> $floor_id
				)
			))) 
			{   
				$this->session->set_flashdata('fail','Duplicate Section');
				echo 'Duplicate Section';
				exit;
			} 
			else 
			{
				$created_date = date("Y-m-d H:i:s");
				$userid       = $this->bookmyt_model->KM_save(array(
					'class' => "sections",
					'insert' => array(
						'section_name' => $section_name,
						'business_id' => $business_id,
						'floor_id'	=> $floor_id,	
						'no_of_tables' => $no_of_tables,
					'no_of_rows'=>$no_of_rows,
					'no_of_columns'=>$no_of_columns,
					'created_ts'	=> date('Y-m-d H:i:s')
					),
					'return_id' => true
				));
			  
				if ($userid) 
				{
					$i=0;
					foreach($tables as $table)
					{
				 
						$table       = $this->bookmyt_model->KM_save(array(
						'class' => "table_info",
						'insert' => array(
						'serial_no' => $_POST['serialno'][$i],
						'table_no' => $_POST['table_no'][$i],
						'table_type' => $_POST['table_type'][$i],
						'no_of_seats' => $_POST['tables'][$i],
						'section_id'	=> $userid,
						'floor_id' => $floor_id,
						"business_id" => $business_id,

						'image'=>$_POST['images'][$i]
						),
						'return_id' => true
						));
						$i++;					
					}	
					//$this->__save_to_log($hwid,$userid,0,'register',$created_date);
				   // $this->users_model->KM_save(array("class"=>"userdevice","insert"=>array("userid"=>$userid,"hwid"=>$hwid)));
					$data = array(
						"status" => true,
						"success" => "Section added successfully",
						"data" => array(
							"Id" => $userid,
							"business_id" => $business_id,
							"floor_no" => $floor_no,
							"Created date" => $created_date
						)
					);
					$this->session->set_flashdata('success',$data['success']);
					echo $data['success'];
				}            
				else 
				{
					$this->response(array(
						"status" => false,
						'error' => 'Not Found'
					), 400);
				}
			}
		}
		else
		{
			redirect(base_url());
		}
		//redirect('bookmyt/floors');
		
    }
	//Edit Section Screen
	public function edit_section($floor_id,$section_id,$business_id)
	{
		if($this->session->all_userdata())
		{
			//$business_id=$business_id;
			$data['branches'] = $this->bookmyt_model->get_branches($business_id);
			$data['floor_info']= $this->bookmyt_model->getfloor_info($section_id,$floor_id);
			$data['floor_id']= $floor_id;
			$data['section_id']= $section_id;
			$data['business_id']= $business_id;
			// echo "<pre>";
				// print_r($data['floor_info']);
			// echo "</pre>"; exit;
			$this->load->view('edit_section',$data);  
		}
		else
		{
			redirect(base_url());
		}	
	}
	//Update Section
	function updatesection()
    {
        
		if($this->session->all_userdata())
		{
			$this->layout=false;
			$section_name = $this->input->post('floor_no');
			$business_id=$this->input->post('business_id');
			$no_of_tables = $this->input->post('no_of_tables');
			$no_of_floors= $this->input->post('no_of_floors');
			$section_id=$this->input->post('section_id');
			$this->load->model('bookmyt_model');
			$tables = $this->input->post('tables');
			 $no_of_rows = (int)$this->input->post('no_of_rows');
			 $no_of_columns = (int)$this->input->post('no_of_columns');
			if($no_of_rows>10)
			{
				echo 'Please enter no of rows less than or equal to 10.';
				exit;
			}
			if($no_of_columns>10)
			{
				echo 'Please enter no of columns less than or equal to 10.';
				exit;
			}
			 if($no_of_columns =='' && $no_of_columns==0){
				if($no_of_rows!='' && $no_of_rows!=''){
				$no_of_columns = floor($no_of_tables/$no_of_rows);
				}else{

					$no_of_columns = 2;
				}
			 }
			  if($no_of_rows =='' && $no_of_rows==0){
				if($no_of_columns!='' && $no_of_columns!=''){
				$no_of_rows = floor($no_of_tables/$no_of_columns);
				}else{
					$no_of_rows = 2;
				}
			 }
			//echo '<pre>';print_r($_POST['images']);exit;
			$floor_id = $this->input->post('floor_id');

			//print_r( $tables); exit;
				$created_date = date("Y-m-d H:i:s");
				$userid = $this->bookmyt_model->KM_update(array(
						'class' => "sections",
						'update' => array(
						'section_name' => $section_name,
						'business_id' => $business_id,
						'no_of_tables' => $no_of_tables,
					'no_of_rows'=>$no_of_rows,
					'no_of_columns'=>$no_of_columns					
					)
					), array(
						"section_id" => $section_id
					));
			   
			   if ($userid) 
				{
					$sql = "select serial_no from table_info where section_id='$section_id' order by serial_no";
					$query = $this->db->query($sql);
					$res = $query->result_array();	
					
					$serial_no_values = $this->array_column($res, 'serial_no');				
					$result = array_diff($serial_no_values,$_POST['serialno']);
					sort($result);
					$arr=array();
					foreach($serial_no_values as $serial){
						
						if($no_of_rows<substr($serial,0,1)){
							$arr[]=$serial;
						}
					}
					//if(count($serial_no_values) > count($_POST['serialno']))
					//{
						if(count(arr) != 0)
						{
							$combine = implode(',',$arr);
							if($combine!=""){
								$sql =  "select table_id from table_info where section_id='$section_id' and serial_no in(".$combine.")";
								$query = $this->db->query($sql);
								$tab_ids = $query->result_array();
								$tabids = $this->array_column($tab_ids, 'table_id');	
								
								$this->db->where('floor',$floor_id);
								$this->db->where_in('table_id', $tabids);
								$this->db->delete('reservation');
								
								$this->db->where('floor_id',$floor_id);
								$this->db->where_in('serial_no', $result);
								$this->db->delete('table_info');
							}
						}
					//}
					
					
					$i=0;	
					foreach($tables as $table)
					{
		
					   if(count($serial_no_values) != 0 && in_array($_POST['serialno'][$i],$serial_no_values))
					   {
							$this->bookmyt_model->KM_update(array(
									'class' => "table_info",
									'update' => array(
									'table_no' => $_POST['table_no'][$i],
									'table_type' => $_POST['table_type'][$i],
									'no_of_seats' => $_POST['tables'][$i]								
								)
								), array(
									"serial_no" => $_POST['serialno'][$i],
									'section_id'=>$section_id,
									'floor_id' => $floor_id
								));
								$i++;
						}
					   else
					   {
						
							$this->bookmyt_model->KM_save(array(
								'class' => "table_info",
								'insert' => array(
								'serial_no' => $_POST['serialno'][$i],
								'table_no' => $_POST['table_no'][$i],
								'table_type' => $_POST['table_type'][$i],
								'no_of_seats' => $_POST['tables'][$i],
								'section_id'=>$section_id,
								'floor_id' => $floor_id,
								"business_id" => $business_id,
								'image'=>$_POST['images'][$i]
								),
								'return_id' => true
								));
								$i++;						
						}				
						
						
					}
					
					//echo "<pre>"; print_r($_POST); exit;

						$data = array(
						"status" => true,
						"success" => "Section updated successfully",
						"data" => array(
							"Id" => $userid,
							"business_id" => $business_id,
							"section_id" => $section_id,
							"floor_no" => $floor_no,
							"Created date" => $created_date
						)
					);
					$this->session->set_flashdata('success',$data['success']);
					echo $data['success'];
				}
				else {
					$this->response(array(
						"status" => false,
						'error' => 'Not Found'
					), 400);
				}
		}
		else
		{
			redirect(base_url());
		}		
    }
	//Deleting Sections
	public function delete_section($section_id,$floor_id)
	{
		if($this->session->userdata('business_id'))
		{
			if(!empty($this->permissions))
			{
				if($this->permissions->floor->delete == '' || $this->permissions->floor->delete == 0)
				{
					$this->session->set_flashdata('perm','Access Denied');
					redirect('bookmyt/home/');
				}
			}	
			/*$this->users_model->KM_delete(array(
			"class" => "reservation",
			"conditions" => array(
			"floor" => $floor_id
			)
			));*/
			$this->db->delete("reservation",array("section_id" => $section_id));
			$this->db->delete("table_info",array("section_id" => $section_id));
			$this->db->delete("sections",array("section_id" => $section_id));
			//if(!empty($buffer))

			//{
				$this->session->set_flashdata('success',"Section deleted successfully.");
				redirect('bookmyt/section_list'."/".$floor_id);

			//}
		}
		else
		{
			redirect(base_url());
		}
			
	}
	function payToRenew(){
		if($this->session->userdata('business_id')){
				$data['userdata'] = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "business_id" => $this->session->userdata('business_id')
				)
			));
			
			$data['business_types'] = $this->bookmyt_model->get_business_types();
			//$data['zones']          = $this->bookmyt_model->get_zones1();
			$data['coutries']  = $this->bookmyt_model->get_countries();			    
			$this->load->view('register/payment',$data);
		}else{
			redirect('bookmyt/home');
		}
	}
	function inActivateUsers(){
		$userdata = $this->bookmyt_model->KM_All(array(
				"class" => "business_entity",
				"fields" => array(
					'*'
				),
				"conditions" => array(
				  "subscription_type" 		=> 1,
				  "subscription_end_dt"		=> date("Y-m-d",strtotime("-1 day"))
				)
			));
		//$sql="select * from business_entity where subscription_type=1 and subscription_end_dt="	
		if(!empty($userdata)){
			foreach($userdata as $user){
				$sql="update business_entity set is_active=0 where business_id='".$user['business_id']."'";
				$this->db->query($sql);
			}
		}
	}
	function send_promocode(){
		if($this->session->userdata('business_id')){
			if($this->input->post()){
				if($this->input->post('discount')!="" && $this->input->post('discount')=='current'){
					$key='disc_on_cur_bill';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
					//$value=$this->input->post('discount_value');
				}else if($this->input->post('discount')!="" && $this->input->post('discount')=='last'){
					$key='disc_on_last_bill';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
				}else if($this->input->post('discount')!="" && $this->input->post('discount')=='group'){
					$key='disc_on_group';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
				}else if($this->input->post('discount')!="" && $this->input->post('discount')=='freq_cust'){
					$key='disc_on_freq_cust';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
				}
				if($this->input->post('discount')==""){
					$key='disc_percent';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
				}
				$promo_type=($this->input->post('promotion_type')=='specific')?1:0;
				$data=array(
							'description'		=> $this->input->post('message'),
							$key				=> $dis_val,
							'promotion_type'	=> $promo_type,
							'promocode'			=> $this->input->post('promocode'),
							'discount_type'		=> $dis_type							
						);
				$this->db->insert("promotion",$data);
				$promo_id=$this->db->insert_id();
				if($key=='disc_on_cur_bill'){
					$promo_type="is valid on current bill";	
					$val=$dis_val;								
				}else if($key=="disc_on_last_bill"){
					$promo_type="is valid on last bill";
					$val=$dis_val;
				}else if($key=='disc_on_group'){
					$promo_type="is valid on group bill";
					$val=$dis_val;
				}else if($key=='disc_on_freq_cust'){
					$promo_type="is valid for frequent customer";
					$val=$dis_val;
				}else if($key=='disc_percent'){
					$promo_type="";
					$val=$dis_val;
				}
				if($dis_type=='percentage'){
					$val=number_format($val)." %";
				}else{
					$val=number_format($val)." Flat";
				}
				$customer_ids=explode("_",$this->input->post('customer_ids'));
				if(!empty($customer_ids)){
					foreach($customer_ids as $cust_id){
						$this->db->update('business_customer',array('promotion_id'=>$promo_id,'promocode'=>$this->input->post('promocode')),array('customer_id'=>$cust_id,'business_id'=>$this->session->userdata('business_id')));
						$sql="select phone_no from customer where customer_id='$cust_id'";
						$query=$this->db->query($sql);
						$result=$query->result_array();
						if(!empty($result) && $result[0]['phone_no']!=""){
							$message="Dear Customer,</br>".$this->input->post('promocode')."(".$val.")".$promo_type;
							$numbers=$result[0]['phone_no'];
							$this->load->library("request_rest");
							$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
							$request_data=array(						
												"mobile_number" => $numbers,
												"message" => $message			
											);
					
							$this->request_rest->setRequestURL($request_url);
							$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
							$this->request_rest->setRequestBody(json_encode($request_data));
							$this->request_rest->setMethod("PUT");
							//Disabled in testing purpose
							$result = $this->request_rest->execute();
							$res=json_decode($result);
						}
					}
				}
				redirect('bookmyt/getCustomerReport');
			}
		}else{
			redirect('bookmyt/home');
		}
	}
	function send_promocode_cust(){
		if($this->session->userdata('business_id')){
			if($this->input->post()){
				if($this->input->post('discount')!="" && $this->input->post('discount')=='current'){
					$key='disc_on_cur_bill';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
					//$value=$this->input->post('discount_value');
				}else if($this->input->post('discount')!="" && $this->input->post('discount')=='last'){
					$key='disc_on_last_bill';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
				}else if($this->input->post('discount')!="" && $this->input->post('discount')=='group'){
					$key='disc_on_group';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
				}else if($this->input->post('discount')!="" && $this->input->post('discount')=='freq_cust'){
					$key='disc_on_freq_cust';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
				}
				if($this->input->post('discount')==""){
					$key='disc_percent';
					$dis_val=strpos($this->input->post('discount_value'),'%');
					if($dis_val===false){
						$dis_val=$this->input->post('discount_value');
						$dis_type="value";
					}else{
						$dis_val=str_replace("%","",$this->input->post('discount_value'));
						$dis_type="percentage";
					}
				}
				$promo_type=($this->input->post('promotion_type')=='specific')?1:0;
				$data=array(
							'description'		=> $this->input->post('message'),
							$key				=> $dis_val,
							'promotion_type'	=> $promo_type,
							'promocode'			=> $this->input->post('promocode'),
							'discount_type'		=> $dis_type							
						);
				$this->db->insert("promotion",$data);
				$promo_id=$this->db->insert_id();
				$customer_id=$this->input->post('customer_id');
				if($key=='disc_on_cur_bill'){
					$promo_type="is valid on current bill";	
					$val=$dis_val;								
				}else if($key=="disc_on_last_bill"){
					$promo_type="is valid on last bill";
					$val=$dis_val;
				}else if($key=='disc_on_group'){
					$promo_type="is valid on group bill";
					$val=$dis_val;
				}else if($key=='disc_on_freq_cust'){
					$promo_type="is valid for frequent customer";
					$val=$dis_val;
				}else if($key=='disc_percent'){
					$promo_type="";
					$val=$dis_val;
				}
				if($dis_type=='percentage'){
					$val=number_format($val)." %";
				}else{
					$val=number_format($val)." Flat";
				}
				$this->db->update('business_customer',array('promotion_id'=>$promo_id,'promocode'=>$this->input->post('promocode')),array('customer_id'=>$customer_id,'business_id'=>$this->session->userdata('business_id')));
				$sql="select phone_no from customer where customer_id='$customer_id'";
				$query=$this->db->query($sql);
				$result=$query->result_array();
				if(!empty($result) && $result[0]['phone_no']!=""){
					$numbers=$result[0]['phone_no'];
					$this->load->library("request_rest");
					$message="Dear Customer,</br>".$this->input->post('promocode')."(".$val.")".$promo_type;
					$request_url = "http://api.trumpia.com/rest/v1/am_desai/sms";
					$request_data=array(						
										"mobile_number" => $numbers,
										"message" => $message			
									);
			
					$this->request_rest->setRequestURL($request_url);
					$this->request_rest->setAPIKey("55acb5c945f7d027579c6b63e326d16b");
					$this->request_rest->setRequestBody(json_encode($request_data));
					$this->request_rest->setMethod("PUT");
					//Disabled in testing purpose
					$result = $this->request_rest->execute();
					$res=json_decode($result);
				}
				redirect('bookmyt/getCustomerReport');
			}
		}else{
			redirect('bookmyt/home');
		}
	}
	function verify_promocode(){
		if($this->session->userdata('business_id')){
			
		}else{
			redirect('bookmyt/home');
		}
	}
}
?>