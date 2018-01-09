<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require APPPATH.'/libraries/REST_Controller.php';
class Services extends KM_Controller {

    function __construct()
    {
       parent::__construct();
	   $this->layout=false;
       $this->load->model('Bookmyt_model','bookmyt_model');
	   $this->load->model('users_model');
		
    }   
	public function servicecheck()
	{
		$json_array=array("status"=>true);
		echo json_encode($json_array);
	}
	public function login()
	{
		
		 $email=$this->input->post('business_email');
		$password=md5($this->input->post('password'));
		
	 	if(!$email || !$password)
        {
        	$json_array = array("status"=>false,'error' => 'Invalid Data',  "user_details"=>array());
			echo json_encode($json_array); exit;
        }
		 
		$userdata = $this->bookmyt_model->business_entity_user_login($email,$password);	
		if(empty($userdata))
		{
			$user_data = $this->bookmyt_model->user_detatails_user_login($email,$password);			
		}
		if(!empty($userdata)){
			$userdata['user_type_id'] = $userdata['business_typeid'];
			$userdata['user_id'] = $userdata['business_id'];
			if($userdata['business_typeid']==2){
			$userdata['have_branches'] = 1;	
			}
			unset($userdata['business_typeid']);
			$json_array=array("status"=>true,"success"=>"User Found","user_details"=>$userdata);
		}
		else if(!empty($user_data)){
			
			$user_data['business_email'] = $user_data['email'];
			if($user_data['relationship_id']==null){
			$user_data['have_branches'] = 0;
			}else{
			$user_data['have_branches'] = 1;	
			}
			$user_data['relationship_id'] = ($user_data['relationship_id']!=null) ? $user_data['relationship_id'] : '';
			
			$user_data['branch'] = 0;
			unset($user_data['email']);
			$json_array=array("status"=>true,"success"=>"User Found","user_details"=>$user_data);	
		}
		else{  
			$json_array=array("status"=>false,"error"=>"Invalid Credentials", "user_details"=>array());	
		}
		echo json_encode($json_array);
		
	}
	public function floors_list()
	{

	   
		$business_id=$this->input->post('business_id');
		//$business_id=411;
		$this->set_timezone($business_id);
		$have_branches = $this->input->post('have_brchs');
		//$have_branches=0;
 	    if(empty($business_id))
        {
        	$json_array = array("status"=>false,'msg' => 'Invalid Data',  "floors_list"=>array());
			echo json_encode($json_array); exit;
        }
		$floors_list= $this->users_model->get_floors_list($business_id,$have_branches);	
		//pr($floors_list);
		$floors=array();
		if(!empty($floors_list)){
			foreach($floors_list as $floor){
				$floors[$floor['floor_id']]=$floor;
			}
		}
		//pr($floors);
		if(empty($floors_list)){
				
				$json_array=array("status"=>false,"msg"=>"No floors found", "floors_list"=>array());
		}
		 else{  
				
				$json_array=array("status"=>true,"msg"=>"Floors Data", "floors_list"=>$floors);
				
			 
		}
		echo json_encode($json_array);
	}
		public function get_floor_data()
	{

		 $floor_id=$this->input->post('floor_id');
		 $floor_id=7;
		 $business_id=$this->input->post('business_id');
		 $business_id=411;
		 $this->set_timezone($business_id);
		if(!$business_id || !$floor_id)
        {
        	$json_array = array("status"=>false,'error' => 'Invalid Data',  "floor_info"=>array());
			echo json_encode($json_array); exit;
        }
		$data['floor_info']= $this->bookmyt_model->getfloor_info($floor_id);
		if(!empty($data['floor_info'])){
			foreach($data['floor_info'] as $key => $floor_info){
				if($floor_info['Booked_Status']==1){
					//$image = substr($floor_info['image'], 0,strrpos($floor_info['image'],'.'));
					$no_of_seats = $floor_info['no_of_seats'];
					if($floor_info['no_of_seats'] % 2==1){
						$no_of_seats = $floor_info['no_of_seats']+1;
					}
					if($no_of_seats>8){
						$no_of_seats = 8;
					}
					$image = $no_of_seats.$floor_info['table_type'];
					if($image!='' && $no_of_seats>0){
					$data['floor_info'][$key]['image'] = $image.'_red';
					}
				}else{
					//$image = substr($floor_info['image'], 0,strrpos($floor_info['image'],'.'));
					$no_of_seats = $floor_info['no_of_seats'];
					if($floor_info['no_of_seats'] % 2==1){
						$no_of_seats = $floor_info['no_of_seats']+1;
					}
					if($no_of_seats>8){
						$no_of_seats = 8;
					}
					$image = $no_of_seats.$floor_info['table_type'];
					if($image!='' && $no_of_seats>0){
					$data['floor_info'][$key]['image'] = $image.'_green';
					}
				}
			}
		}
		$query = $this->db->query("call GetAvailableTablesByFloorId('".$floor_id."','".date('Y-m-d')."')");
		$data['available']=$query->result_array();
		if(empty($data['floor_info'])){
				
				$json_array=array("status"=>false,"error"=>"Floor data empty", "floor_info"=>array(),'availbale_tables'=>array());
		}
		 else{  
				
				$json_array=array("status"=>true, "no_of_rows"=>$data['floor_info'][0]['floor_rows'],"no_of_columns"=>$data['floor_info'][0]['floor_columns'],"floor_info"=>$data['floor_info'],'availbale_tables'=>$data['available']);
				
			 
		}
		echo json_encode($json_array);
	}
	public function add_reservation()
	{
			
			$customer_id1=$this->input->post('business_id');
			$this->set_timezone($customer_id1);
			//echo date('Y-m-d H:i:s');exit;
			$name=$this->input->post('name');
			$phone_no=$this->input->post('phone_no');
			if($phone_no=='')
			{
			//$phone_no='1234567890';
			}
			else if(strlen($phone_no)<10){
				//$phone_no= substr('1234567890',0, (9-strlen($phone_no))).$phone_no;	
				//$phone_no= '1234567890';	
			}
			$booked_date1=$this->input->post('booked_date');
			$date = date_create($booked_date1);
			$booked_date =  date_format($date, 'Y-m-d');
			
			/*$booked_date1=$this->input->post('booked_date');
			$timestamp = DateTime::createFromFormat('Y-d-m', $booked_date1)->getTimestamp();
			$booked_date = date('Y-m-d', $timestamp);*/
			
			$time=$this->input->post('in_time');	
			$in_time  = date("H:i:s", strtotime($time));			
			$reltion_id = $this->input->post('rel_id');				
			$business = $this->input->post('business');
			if($this->input->post('dob')!=''){
			$dob = $this->input->post('dob');
			$date = date_create($dob);
			$dob =  date_format($date, 'd-F');
			}
			else{
			$dob = '';	
			}
			$user_id = $this->input->post('user_id');
			if(!$customer_id1 || (!$name && !$phone_no) || !$time )
			{
			$json_array = array("status"=>false,'msg' => 'Invalid Data',  "floor_info"=>array());
			echo json_encode($json_array); exit;
			}
			
			if(strtotime($booked_date) < strtotime(date('Y-m-d'))){
				$json_array = array("status"=>false,'msg' => 'Invalid Date',  "floor_info"=>array());
				echo json_encode($json_array); exit;
			}
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
			
			
			$confirmed=0;
			
			$business_id=$this->input->post('business_id');
			if ($phone_no !='' && $this->bookmyt_model->KM_count(array(
						"class" => "reservation",
						"conditions" => array(
							'phone_no' => $phone_no,
							'booked_date' => $booked_date,
							'business_id' => $business_id,
							'status'=>1
						)
					)) > 0 ) 
			{
				/*$data = array(
						"status" => false,
						"success" => "Can't Book the table with the same phone number"
					);
					$this->response($data, 200);*/
					$data['values'] = array("status"=>false, 'msg'=>"Can't Book the table with the same phone number");
					echo json_encode($data['values']);
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
					'confirmed' => $confirmed,
					'date_of_birth' => $dob,
					'relationship_id'=>$relationship_id,
					'is_new'	=> $is_new
				),
				'return_id' => true
			));
			
			$reservation_data = $this->bookmyt_model->KM_first(array(
			"class" => "reservation",
			"fields" => array(
			'*'
			),
			"conditions" => array(
			"reservation_id" => $userid
			)
			));	
			$business = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'business_name'
				),
				"conditions" => array(
				  "business_id" => $business
				)
			));
			
			/*$username = "visitsats@gmail.com";
			$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
			$username = "dayakarv@toyaja.com";
			$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
			$username = "am_desai@yahoo.com";
			$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
			$test = "0";
			$sender = urlencode("BMYTBL"); */
			$numbers = $reservation_data['phone_no'];
			/*$message = "Dear ".(($reservation_data['name']!='') ? $reservation_data['name']: 'Customer').", We confirm your reservation. Kindly give us some time to make your table ready. Thank you - ".$business['business_name'];*/
			
			$message="We confirm your reservation. Kindly give us some time to make your table ready. Thank you - ".$business['business_name'];
			//$message = urlencode($message);
			$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
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
			
			$info = date_create($booked_date); $booked_date1 = date_format($info,'d-M-Y');

			$data1['values'] = array('status'=>'true','msg'=>'Reservation completed successfully','name' => $name,'phone_no' => $phone_no,'in_time' => $in_time,'booked_date'=>$booked_date1,'userid' => $userid,'no_of_mem'=>$no_members);				
			echo json_encode($data1['values']);
			}
		
	}
	
		public function quick_reservation()
		{
		
		        $customer_id=$this->input->post('business_id');
				$this->set_timezone($customer_id);
				$name=$this->input->post('name');
				$phone_no=$this->input->post('phone_no');
				$floor_id=$this->input->post('floor_id');
				$table_id=trim($this->input->post('table_id'),'[]');
				if($phone_no=='')
				{
				//$phone_no='1234567890';
				}
				$time=date('H:i:s');	
				$in_time  = date("H:i:s", strtotime($time));			
				$reltion_id = $this->input->post('rel_id');				
				$business = $this->input->post('business');
				$is_vip = $this->input->post('is_vip');
				if($this->input->post('dob')!=''){
				$dob = $this->input->post('dob');
				$date = date_create($dob);
				$dob =  date_format($date, 'd-F');
                }
				else{
					$dob = '';
				}
				$user_id = $this->input->post('user_id');
				if(!$customer_id || (!$name && !$phone_no)  )
				{
				$json_array = array("status"=>false,"status1"=>false,'error' => 'Invalid Data','msg' => 'Invalid Data',  "floor_info"=>array());
				echo json_encode($json_array); exit;
				}
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
				
				$booked_date1=date('Y-m-d');
				$date = date_create($booked_date1);
				$booked_date =  date_format($date, 'Y-m-d');
				$confirmed=1;
				
				$business_id=$this->input->post('business_id');
				
				if ($phone_no !='' && $this->bookmyt_model->KM_count(array(
						"class" => "reservation",
						"conditions" => array(
							'phone_no' => $phone_no,
							'booked_date' => $booked_date,
							'business_id' => $business_id,
							'status'=>1
						)
					))>0) 
					{
						/*$data = array(
								"status" => false,
								"success" => "Can't Book the table with the same phone number"
							);
							$this->response($data, 200);*/
							$data['values'] = array('status'=>"Can't Book the table with the same phone number",'msg'=>"Can't Book the table with the same phone number","status1"=>false);
							echo json_encode($data['values']);
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
					$tables=explode(',',$table_id);
					if(!empty($tables)){
						$i=1;
						foreach($tables as $table){
							$tab=explode("_",$table);
							if($i==1){
						
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
									'confirmed' => $confirmed,
									'relationship_id'=>$relationship_id,
									'floor'=>$floor_id,
									'section_id'=>$tab[0],
									'table_id'=>$tab[1],
									'is_vip'=>$is_vip,
									'date_of_birth'=>$dob,
									'status'=>1,
									'is_new'	=> $is_new,
								),
								'return_id' => true
							));
						}else{
							$userid1 = $this->bookmyt_model->KM_save(array(
								'class' => "reservation",
								'insert' => array(
									'customer_id' => $customer_id,
									'name' => $name,
									'phone_no' => $phone_no,
									'in_time' => $in_time,
									'business_id' => $business,
									'table_for' => $no_members,
									 'booked_date' => $booked_date,
									'confirmed' => $confirmed,
									'relationship_id'=>$relationship_id,
									'floor'=>$floor_id,
									'section_id'=>$tab[0],
									'table_id'=>$tab[1],
									'is_vip'=>$is_vip,
									'date_of_birth'=>$dob,
									'status'=>1,
									'parent_reservation'=>$userid,
									'is_new'	=> $is_new
								),
								'return_id' => true
							));
						}
						$i++;
					}
				}			
				$info = date_create($booked_date); $booked_date1 = date_format($info,'d-M-Y');
				$data['values'] = array('status'=>'Table booked successfully.','msg'=>'Table booked successfully.','name' => $name,'phone_no' => $phone_no,'in_time' => $in_time,'booked_date'=>$booked_date1,'userid' => $userid,'no_of_mem'=>$no_members,"status1"=>true);
				echo json_encode($data['values']);
				}
		
		
		}
	public function set_timezone($business_id){
		$tzone = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'time_zone'
				),
				"conditions" => array(
				  "business_id" => $business_id
				)
			));
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
	public function reservations()
	{
	 
		$business_id=$this->input->post('business_id');
		$this->set_timezone($business_id);
		$have_branches = $this->input->post('have_brchs');
		if(empty($business_id))
		{
		$json_array = array("status"=>false,'error' => 'Invalid Data',  "reservations_info"=>array());
		echo json_encode($json_array); exit;
		}
		$data['reservation_list']= $this->users_model->reservation_list($business_id,$have_branches);
		if(empty($data['reservation_list'])){
				
				$json_array=array("status"=>false,"error"=>"No Records", "reservations_info"=>array());
		}
		 else{  
				
				$json_array=array("status"=>true,"error"=>"","reservations_info"=>$data['reservation_list']);
				
			 
		}	
		echo json_encode($json_array);
	}
	public function ongoing()
	{
	 
		$business_id=$this->input->post('business_id');
		//$business_id=411;
		$this->set_timezone($business_id);
		$have_branches = $this->input->post('have_brchs');
		//$have_branches=0;
		if(empty($business_id))
		{
		$json_array = array("status"=>false,'error' => 'Invalid Data',  "ongoing_reservations_info"=>array());
		echo json_encode($json_array); exit;
		}
		//$data['ongoing_list']= $this->users_model->res_list($business_id,$have_branches,date('m-d'));
		$data['ongoing_list']= $this->users_model->res_list($business_id,$have_branches);
		if(empty($data['ongoing_list'])){
				
				$json_array=array("status"=>false,"error"=>"No Records", "ongoing_reservations_info"=>array());
		}
		 else{  
				
				$json_array=array("status"=>true,"error"=>"","ongoing_reservations_info"=>$data['ongoing_list']);
				
			 
		}	
		echo json_encode($json_array);
	}
	
	public function get_tables()
	{
		$floor_id=$_POST['floor_id'];
		$edit=$this->input->post('edit');
		//$floor_id=5;
		//$business_id=$this->input->post('business_id');
		//$reservation_id=$this->input->post('reservation_id');
		//$reservation_id=78;
		/*if(empty($business_id))
		{
		$json_array = array("status"=>false,'error' => 'Invalid Data',  "available_tables"=>array());
		echo json_encode($json_array); exit;
		}*/
			/*$mem = $this->bookmyt_model->KM_first(array(
					"class" => "reservation",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "reservation_id" => $reservation_id
					)
				));	*/
		$sql = "call GetAvailableTablesByFloor('".$floor_id."','".date('Y-m-d')."')";
		$test = $this->db->query($sql);
		$available_tables=$test->result_array();
		$available_tab=array();
		if(!empty($available_tables)){
			foreach($available_tables as $available){
				if($available['table_no']!="" && $available['available_status']==1 && $edit==""){
					$available_tab[]=$available;
					
				}else if($available['table_no']!="" && $edit!=""){
					$available_tab[]=$available;
				}
			}
		}
		//$available_tab['table_for']=$mem['table_for'];
		//pr($available_tab);exit;
	   $json_array = array("status"=>true,"available_tables"=>$available_tab);				
		echo json_encode($json_array);
				
	}
		public function buzz_reservation()
		{
		
				$table_for=$this->input->post('table_for');
				$table_id=trim($this->input->post('table_id'),'[]');
				$bid=$this->input->post('business_id');
				$floor=$this->input->post('floor');
				//$section_id=$this->input->post('section_id');
				$is_vip=$this->input->post('is_vip');
				$reservation_id=$this->input->post('reservation_id');
				//echo $table_id;
				//pr($this->input->post());exit;
				if(empty($reservation_id))
				{
				$json_array = array("status"=>false,'msg' => 'Invalid Data');
				echo json_encode($json_array); exit;
				}
				/*$sql = "select timezone from business_entity be inner join timezonebyzipcode z on be.time_zone=z.idtimezonebyzipcode where be.business_id='$bid'";
				$qc = $this->db->query($sql);
				$reslt = $qc->result_array();

				if(count($reslt) != '0')
				{
				if(isset($reslt[0]['timezone']) && $reslt[0]['timezone'] != '')
				{
			
				date_default_timezone_set($reslt[0]['timezone']);
				}
				}
				else
				{
				  date_default_timezone_set('Asia/Kolkata');
				}*/
				$tzone = $this->bookmyt_model->KM_first(array(
						"class" => "business_entity",
						"fields" => array(
							'time_zone'
						),
						"conditions" => array(
						  "business_id" => $bid
						)
					));
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
			   	$reservation_data = $this->bookmyt_model->KM_first(array(
									"class" => "reservation",
									"fields" => array(
									'*'
									),
									"conditions" => array(
									"reservation_id" => $reservation_id
									)
									));	
				$ctime =  Date('H:i:s');
				$tables=explode(',',$table_id);
				if(!empty($tables)){
					$i=1;
					foreach($tables as $table){
						$tab=explode("_",$table);
						if($i==1){
							$this->bookmyt_model->KM_update(array(
									'class' => "reservation",
									'update' => array(
									'floor'=>$floor,
									'section_id'=>$tab[0],                            
									'table_id' => $tab[1],
									'booked_date' => date('Y-m-d'),
									'in_time' => $ctime,
									'confirmed'=>1,
									'is_vip'=>$is_vip,
									'status'=>1
									)
								), array(
									"reservation_id" => $reservation_id
								));
						}else{
							$this->bookmyt_model->KM_save(array(
									'class' => "reservation",
									'insert' => array(
									'floor'=>$floor,
									'customer_id'=> $reservation_data['customer_id'],
									'name'		=> $reservation_data['name'],
									'phone_no'	=> $reservation_data['phone_no'],
									'table_for'	=> $reservation_data['table_for'],
									'business_id'=> $bid,
									'section_id'=>$tab[0],                            
									'table_id' => $tab[1],
									'booked_date' => date('Y-m-d'),
									'in_time' => $ctime,
									'confirmed'=>1,
									'is_vip'=>$is_vip,
									'status'=>1,
									'parent_reservation'=>$reservation_id
									)
								,'return_id' => true
								));
						}	
						$i++;	
					}	
				}
				$reservation_data = $this->bookmyt_model->KM_first(array(
				"class" => "reservation",
				"fields" => array(
				'*'
				),
				"conditions" => array(
				"reservation_id" => $reservation_id
				)
				));	
				
				/*$test = "1";
				$username = "visitsats@gmail.com";
				$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
				$username = "dayakarv@toyaja.com";
				$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
				$username = "am_desai@yahoo.com";
				$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
				$test = "0";
				$sender = urlencode("TXTLCL"); 
				$numbers = $reservation_data[0]['phone_no']; 
				$message = "Your reservation is confirmed";
				$message = urlencode($message);
				$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;

				$ch = curl_init('http://api.textlocal.in/send/?');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); 
				curl_close($ch);*/
				
				$json_array = array("status"=>true,'msg'=>'Table confirmed successfully.');				
				echo json_encode($json_array);
		
		}
		public function feedback()
		{
			
			$rid=$this->input->post('rid');
			if(empty($rid))
			{
			$json_array = array("status"=>false,"status1"=>false,'msg' => 'Invalid Data');
			echo json_encode($json_array); exit;
			}
			$bill_no = $this->input->post('bill_no');
			$sql = "select count(bill_no) as bil_cnt from reservation where bill_no='$bill_no'";
			$query = $this->db->query($sql);
			$res = $query->result_array();
			if($res[0]['bil_cnt'] != 0)
			{
				
				$json_array = array("status"=>'fail',"status1"=>false,'msg'=>'Bill number should be unique.');				
				echo json_encode($json_array);
				exit;
			}
			
			$res_id = $rid;
			$dining = $this->input->post('dining_type');
			
			$bill_amt=$this->input->post('bill_amt');
			$tab_no = $this->input->post('tab_no');
			$stew = $this->input->post('stew');
			$c_name = $this->input->post('c_name');
			$c_phn = $this->input->post('c_phn');
			$dob = $this->input->post('dob');
			$date = date_create($dob);
			$dob =  date_format($date, 'd-F');
			
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
					'date_of_birth'=>$dob,
					'phone_status' => 0,
					//'post_val' => json_encode($this->input->post())
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
					'date_of_birth'=>$dob,
					'phone_status' => 0,
					//'post_val' => json_encode($this->input->post())
				)
				), array(
					"parent_reservation" => $res_id
				));	
			if($succ)
			{
				$res_data = $this->bookmyt_model->KM_first(array(
					"class" => "reservation",
					"fields" => array(
						'customer_id', 'business_id'
					),
					"conditions" => array(
					 "reservation_id" => $res_id
					)
				));
				if(!empty($res_data['customer_id'])){
				$businessid_data = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'business_id'
					),
					"conditions" => array(
					 "relationship_id" => $res_data['business_id']
					)
				));
				$buss_id = $res_data['business_id'];
				if(!empty($businessid_data)){
					$buss_id = $businessid_data['business_id'];
				}
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
				}
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
				$feedback_details=$this->bookmyt_model->KM_first(array(
						"class" => "reward_point_history",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "id" => $feedback_id
						)
					));
				$reward_info = $this->bookmyt_model->get_rewards_info($feedback_details['customer_id'], $feedback_details['business_id']);
				$json_array = array("status"=>'success',"status1"=>true,'msg'=>'Thanks for the feedback. We have also updated your reward points', 'result'=>array('total_reward'=>$reward_info, 'rewards_for_this'=>$feedback_details['rewards']));				
				echo json_encode($json_array);
			}else{
				$json_array = array("status"=>'fail',"status1"=>false);			
				echo json_encode($json_array);
			}			
		}
		public function can_reservation()
		{
		    $reservation_id=$this->input->post('reservation_id');
			if(empty($reservation_id))
			{

					$json_array = array("status"=>'fail','error'=>'reservation_id required');				
					echo json_encode($json_array);
					exit;
			}
			else
			{
				
				$userid       = $this->users_model->KM_update(array(
				'class' => "reservation",
				'update' =>  array(
				'confirmed' => 2
				)
				), array(
				"reservation_id" => $reservation_id
				));
				$this->users_model->KM_update(array(
				'class' => "reservation",
				'update' =>  array(
				'confirmed' => 2
				)
				), array(
				"parent_reservation" => $reservation_id
				));
				
				$reservation_data = $this->bookmyt_model->KM_first(array(
				"class" => "reservation",
				"fields" => array(
				'*'
				),
				"conditions" => array(
				"reservation_id" => $reservation_id
				)
				));	
				
				$business = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'business_name'
					),
					"conditions" => array(
					  "business_id" => $reservation_data['business_id']
					)
				));
				
				$username = "visitsats@gmail.com";
				$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
				$username = "dayakarv@toyaja.com";
				$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
				$username = "am_desai@yahoo.com";
				$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
				$test = "0";
				$sender = urlencode("BMYTBL"); 
				$numbers = $reservation_data['phone_no'];
				$message = "Dear ".(($reservation_data['name']!='') ? $reservation_data['name'] : 'Customer').", Your reservation has been cancelled  ".$business['business_name'].". Visit again. Thank you. ";
				//$message = urlencode($message);
				$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
				
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
				//echo  $result; exit;
				//$res=json_decode($result);
				if($result[0]==200){
					$success=1;
				}else{
					$success=0;
				}


				if($userid)
				{
				$json_array = array(
				"status" => true,
				"success" => "Reservation cancelled successfully"
				);
				echo json_encode($json_array);
				}
			}
				
		}	
		public function allocate_table()
		{
			
				
				$res_id = $this->input->post('res_id');
				$floor_id = $this->input->post('floor_id');
				$business_id=$this->input->post('business_id');
			    $reservation_id=$this->input->post('res_id');
				if(empty($business_id))
				{
				$json_array = array("status"=>false,'error' => 'Invalid Data',  "available_tables"=>array());
				echo json_encode($json_array); exit;
				}
				$data['ex_flr'] = $this->bookmyt_model->get_flr($res_id);
				$mem = $this->bookmyt_model->KM_first(array(
						"class" => "reservation",
						"fields" => array(
							'*'
						),
						"conditions" => array(
						  "reservation_id" => $reservation_id
						)
					));	
				$sql = "call GetAvailableTablesBySeatsAndFloor('".$mem['table_for']."','".$floor_id."')";
				$test = $this->db->query($sql);
				$data['available_tables']=$test->result_array();
				
				$json_array = array("status"=>true, 'floors_data'=>$data['ex_flr'], "available_tables"=>$data['available_tables']);echo json_encode($json_array);
					
		}
		
		public function delete_reservation()
		{
		    $reservation_id=$this->input->post('reservation_id');
			if(empty($reservation_id))
			{

					$json_array = array("status"=>'fail','error'=>'reservation_id required');				
					echo json_encode($json_array);
					exit;
			}
			else
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
				
				$this->users_model->KM_delete(array(
				"class" => "reservation",
				"conditions" => array(
				"reservation_id" => $reservation_id
				)
				));
				$this->users_model->KM_delete(array(
				"class" => "reservation",
				"conditions" => array(
				"parent_reservation" => $reservation_id
				)
				));
				
				
				/*$business = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'business_name'
					),
					"conditions" => array(
					  "business_id" => $reservation_data['business_id']
					)
				));
			
				$username = "visitsats@gmail.com";
				$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
				$username = "dayakarv@toyaja.com";
				$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
				$username = "am_desai@yahoo.com";
				$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
				$test = "0";
				$sender = urlencode("TXTLCL"); 
				$numbers = $reservation_data['phone_no'];
				$message = "Dear ".$reservation_data['name'].", Your reservation has been cancelled  ".$business['business_name'].". Visit again. Thank you. ";
				$message = urlencode($message);
				$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
				
				$ch = curl_init('http://api.textlocal.in/send/?');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); 
				curl_close($ch);
				//echo  $result; exit;
				$res=json_decode($result);
				if($res->status=="success"){
					$success=1;
				}else{
					$success=0;
				}*/
				
				$json_array = array(
				"status" => true,
				"success" => "Reservation deleted successfully."
				);
				echo json_encode($json_array);
			}
				
		}	
		public function buzz_msg()
	{
	   
		$res_id = $this->input->post('res_id');
		if(empty($res_id))
		{

				$json_array = array("status"=>'fail','error'=>'Invalid Data');				
				echo json_encode($json_array);
				exit;
		}
		
		$test = "1";
		$username = "visitsats@gmail.com";
		$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
		$username = "dayakarv@toyaja.com";
		$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
		$username = "am_desai@yahoo.com";
		$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
		$test = "0";
		$sender = urlencode("BMYTBL"); 
		$mem = $this->bookmyt_model->KM_first(array(
					"class" => "reservation",
					"fields" => array(
						'*'
					),
					"conditions" => array(
					  "reservation_id" => $res_id
					)
				));
		$numbers = $mem['phone_no']; 
		$business = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'business_name'
					),
					"conditions" => array(
					  "business_id" => $mem['business_id']
					)
				));
		$numbers = $mem['phone_no']; 
		
		$message = "Dear ".(($mem['name']!='') ? $mem['name'] : 'Customer').", Your table is ready. Happy dining! Thank you - ".$business['business_name'];
		//$message = urlencode($message);
		$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;

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
		$json_array = array("status"=>'true');				
		
		if($result[0]==200)
		{
			$json_array['success'] =  "Message sent successfully";
		}else
		{
			$json_array['success'] =  "Message not sent.please try later";
		}
		 curl_close($ch);
		 echo json_encode($json_array);
		 exit;
		//$data['ex_flr'] = $this->bookmyt_model->get_flr($res_id);
		//$this->load->view('load_floors',$data);
		
	}
	
	    public function reservationscount()
	{
	 
		$business_id=$this->input->post('business_id');
		//$business_id=316;
		$this->set_timezone($business_id);
		$have_branches = $this->input->post('have_brchs');
		//$have_branches=0;
		if(empty($business_id))
		{
		$json_array = array("status"=>false,'error' => 'Invalid Data',  "reservations_info"=>array());
		echo json_encode($json_array); exit;
		}
		$reservation_count= $this->users_model->reservation_count($business_id,$have_branches);
		$ongoing_count= $this->users_model->res_count($business_id,$have_branches);
		
		$json_array=array("status"=>true,"reservation_count"=>$reservation_count[0]['cnt'],'ongoing_count'=>$ongoing_count[0]['cnt']);
		 
		echo json_encode($json_array);
	}
	public function get_names()
	{
		$phone = $this->input->post('phone');
		$bid = $this->input->post('business_id');
		$phone = $this->bookmyt_model->get_names($phone,$bid);
				
		if(!empty($phone) && isset($phone[0]['name']))
		{
			$name=$phone[0]['name'];
			$dob= ($phone[0]['date_of_birth']!='' && $phone[0]['date_of_birth']!='00-00') ? date('d-F',strtotime($phone[0]['date_of_birth'])) : '';
			$is_vip=(($phone[0]['is_vip']!='') )?$phone[0]['is_vip']:0;
		}
		else
		{
			$name = ' ';
			$dob = ' ';
			$is_vip=0;
		}		
		$json_array=array("status"=>true,"name"=>$name,'dob' => $dob,'is_vip'=>$is_vip);
		 
		echo json_encode($json_array);
	}
	public function roles(){
		$user_type_id = $this->input->post('user_type_id');
		if(empty($user_type_id))
		{
		$json_array = array("status"=>false,'error' => 'Invalid Data');
		echo json_encode($json_array); exit;
		}
		$check = $this->bookmyt_model->role_permissions($user_type_id);
		$permissions=json_decode($check[0]['permissions']);
		$arr=array();
		foreach($permissions as $key=>$val)
		{
			$arr[$key]=$val;
		}
		$arr['status'] = true;
		echo json_encode($arr);
	}
	public function check_billno()
	{
		$bill_no = $this->input->post('bill_no');
		if(empty($bill_no))
		{
		$json_array = array("status"=>false,'msg' => 'Bill number should not be empty.');
		echo json_encode($json_array); exit;
		}
		$sql = "select count(bill_no) as bil_cnt from reservation where bill_no='$bill_no'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		if($res[0]['bil_cnt'] != 0)
		{
			$json_array = array("status"=>false,'msg'=>'Bill number should be unique.');				
			echo json_encode($json_array);
			exit;
		}else{
			$json_array = array("status"=>true,'msg'=>'');				
			echo json_encode($json_array);
			exit;
		}
	}
	public function change_password()
	{
		$user_id = $this->input->post('user_id');
		$password = $this->input->post('password');
		$old_password = $this->input->post('old_password');
		$user_type_id = $this->input->post('user_type_id');
		if(empty($user_id) or empty($password) or empty($user_type_id) or empty($old_password))
		{
		$json_array = array("status"=>false,'msg' => 'Invalid Data.');
		echo json_encode($json_array); exit;
		}
		if($user_type_id == 3 or $user_type_id == 4){
			$userdata = $this->bookmyt_model->KM_first(array(
					"class" => "user_details",
					"fields" => array(
						'password'
					),
					"conditions" => array(
					  "user_id" => $user_id
					)
				));
			if($userdata['password'] == md5($old_password)){	
			$res       = $this->users_model->KM_update(array(
				'class' => "user_details",
				'update' =>  array(
				'password' => md5($password)
				)
				), array(
				"user_id" => $user_id
				));
			}else{
				$json_array = array("status"=>false,'msg'=>'Incorrect old password.');				
				echo json_encode($json_array);
				exit;
			}
		}
		else{
			$userdata = $this->bookmyt_model->KM_first(array(
					"class" => "business_entity",
					"fields" => array(
						'password'
					),
					"conditions" => array(
					 "business_id" => $user_id
					)
				));
			if($userdata['password'] == md5($old_password)){
				$res       = $this->users_model->KM_update(array(
				'class' => "business_entity",
				'update' =>  array(
				'password' => md5($password)
				)
				), array(
				"business_id" => $user_id
				));
			}else{
				$json_array = array("status"=>false,'msg'=>'Incorrect old password.');				
				echo json_encode($json_array);
				exit;
			}
		}
		if($res)
		{
			$json_array = array("status"=>true,'msg'=>'Profile updated successfully.');				
			echo json_encode($json_array);
			exit;
		}else{
			$json_array = array("status"=>false,'msg'=>'Profile not updated. Please update after some time.');				
			echo json_encode($json_array);
			exit;
		}
	}
	public function forgot_password()
		{
						
				$username = $this->input->post('username');
				if(empty($username) )
				{
				$json_array = array("status"=>false,'msg' => 'Invalid Username.');
				echo json_encode($json_array); exit;
				}
					$random_pwd = mt_rand(100000, 999999);
					$email = $username;
					$config = array(
							'protocol' => "mail",
							'smtp_host' => "mail.knowledgematrixinc.com",
							//'smtp_host' => "mail510.opentransfer.com",
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
						
							$body = "<p>Dear Customer,</p><p>This email confirms that your password has been changed.</p><p>To access your account, please use the following credentials:</p><p>Username: ".$email."</br>Password: ".$random_pwd."</p><p>If you have any questions or encounter any problems logging in, please contact a site administrator.</p>";
							
							$this->email->from('info@bookmyt.in', 'BookMyT');
							$this->email->to($user_email);
							$this->email->subject('Your Password has been changed');
							$this->email->message($body);						
							$this->email->send();
							$json_array = array("status"=>true,'msg'=>'Your new password is sent to your mail id.');				
							echo json_encode($json_array);
							exit;
							
						}else if(is_numeric($email))
						{
						   //sms functionality added on 14-04-2016
						 	
							$test = "1";
							$username = "visitsats@gmail.com";
							$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
							$username = "dayakarv@toyaja.com";
							$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
							$username = "am_desai@yahoo.com";
							$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
							$test = "0";
							$sender = urlencode("BMYTBL"); 
							$numbers = $email; 
							/*$message = "Hi Customer, this is to confirm you that your password has been changed as per your request. Please use the following credentials to access your account Username: ".$email.", Password: ".$random_pwd.'.';*/
							$message="Please use the following credentials to access your account Username: ".$email.", Password: ".$random_pwd.".";
							//$message = urlencode($message);
							$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;

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
							if($result[0]==200)
							{
								$json_array = array("status"=>true,'msg'=>'Password sent to your phone');				
								echo json_encode($json_array);
								exit;
							}else
							{
								$json_array = array("status"=>false,'msg'=>'Password not sent to your phone.please try later');				
								echo json_encode($json_array);
								exit;
							}
							curl_close($ch);
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
						if(!empty($success) && $email!='' && !is_numeric($email))
						{
						
							$body = "<p>Dear ".$user_check[0]['username'].",</p><p>This email confirms that your password has been changed.</p><p>To access your account, please use the following credentials:</p><p>Username: ".$user_email."<br/>Password: ".$random_pwd."</p><p>If you have any questions or encounter any problems logging in, please contact a site administrator.</p>";
							$this->email->from('no-reply@toyaja.com', 'BookMyT');
							$this->email->to($user_email);
							

							$this->email->subject('Your Password has been changed');
							$this->email->message($body);						
					
							if($this->email->send())
							{
								$json_array = array("status"=>true,'msg'=>'Your new password is sent to your mail');				
								echo json_encode($json_array);
								exit;
							}
							else
							{
								$json_array = array("status"=>false,'msg'=>'Problem in sending Email. Please try later.');				
								echo json_encode($json_array);
								exit;
							}
						}
                        else
						{
						    $test = "1";
							$username = "visitsats@gmail.com";
							$hash = "99ada8350096fb44480b63a0bd357c5e9384781b";
							$username = "dayakarv@toyaja.com";
							$hash = "dabb49de6f90e54c6d650d74ea31c0c57b04b938";
							$username = "am_desai@yahoo.com";
							$hash = "5bfe3b5c771f86565a530b61a4b9af57e16fed2b";
							$test = "0";
							$sender = urlencode("BMYTBL"); 
							$numbers = $email; 
							/*$message = "Hi Customer, this is to confirm you that your password has been changed as per your request. Please use the following credentials to access your account Username: ".$email.", Password: ".$random_pwd.'.';*/
							$message="Please use the following credentials to access your account Username: ".$email.", Password: ".$random_pwd.'.';
							//$message = urlencode($message);
							$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;

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
							if($result[0]==200)
							{
								$json_array = array("status"=>true,'msg'=>'Password sent to your phone');				
								echo json_encode($json_array);
								exit;
							}else
							{
								$json_array = array("status"=>false,'msg'=>'Password sent to your phone.please try later');				
								echo json_encode($json_array);
								exit;
							}
							 curl_close($ch);
						}						
					}
					if(count($check) == 0 && count($user_check) == 0)
					{
						$json_array = array("status"=>false,'msg'=>'Your email/phone number is not found');				
						echo json_encode($json_array);
						exit;
					}
			}			
		public function rewards_info()
		{
			
			$rid=$this->input->post('rid');
			//$rid=172;
			if(empty($rid))
			{
			$json_array = array("status"=>false,"status1"=>false,'msg' => 'Invalid Data');
			echo json_encode($json_array); exit;
			}
					
			$res_id = $rid;	
			
			/*$res_data = $this->bookmyt_model->KM_first(array(
				"class" => "reservation",
				"fields" => array(
					'customer_id', 'business_id'
				),
				"conditions" => array(
				 "reservation_id" => $res_id
				)
			));*/
			$sql="select customer_id,business_id from reservation where reservation_id='$res_id' union select customer_id,business_id from reservation_archive where reservation_id='$res_id'";
			$query=$this->db->query($sql);
			$res_data=$query->result_array();
			
			$businessid_data = $this->bookmyt_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'business_id'
				),
				"conditions" => array(
				 "relationship_id" => $res_data[0]['business_id']
				)
			));
			$buss_id = $res_data[0]['business_id'];
			if(!empty($businessid_data)){
				$buss_id = $businessid_data['business_id'];
			}
			//$res_data[0]['customer_id']=194;
			//$buss_id=316;
			$reward_info = $this->bookmyt_model->get_rewards_info($res_data[0]['customer_id'], $buss_id);
			//pr($reward_info);exit;
			$json_array = array("status"=>'success',"status1"=>true,'msg'=>$reward_info[0]['rewards'],'promocode'=>$reward_info[0]['promocode']);				
			echo json_encode($json_array);
				
		}
		function getFloorsList(){
			$business_id=$this->input->post('business_id');
			//$business_id=411;
			$query = $this->db->query("call GetAvailableTablesInSections('".$business_id."')");			
			$floors_info = $query->result_array();
			$this->db->reconnect();
			if(!empty($floors_info)){
				foreach($floors_info as $floor){
					$section_ids=explode(",",$floor['section_id']);
					$section_names=explode(",",$floor['section_name']);
					$sec_tab_count=explode(",",$floor['Available_tables']);
					$sections=array_combine($section_ids,$section_names);
					$i=0;
					foreach($sections as $key=>$value){
						$this->db->reconnect();
						$query = $this->db->query("call GetAvailableTablesByFloorId('".$key."','".$floor['floor_id']."','".date('Y-m-d')."')");
			
						$available[$floor['floor_id']][$key]=$query->result_array();
						$available[$floor['floor_id']][$key]['section_name']=$value;
						$available[$floor['floor_id']][$key]['available_tables']=$sec_tab_count[$i];
						$available[$floor['floor_id']][$key]['floor_name']=$floor['floor_no'];
						$available[$floor['floor_id']][$key]['floor_id']=$floor['floor_id'];
						$i++;
					}
				}
			}
			//pr($available);exit;
			//$available=json_encode($available);
			
			$json_array = array("status"=>'success',"status1"=>true,'available'=>$available);				
			echo json_encode($json_array);
			/*$this->db->reconnect();
			$data['floor_info']= $this->bookmyt_model->getfloor_info($this->input->post('section_id'),$floor_id);
			//echo "call GetAvailableTablesByFloorId('".$section_id."','".$floor_id."','".date('Y-m-d')."')";
			$query = $this->db->query("call GetAvailableTablesByFloorId('".$section_id."','".$floor_id."','".date('Y-m-d')."')");
			
			$data['available']=$query->result_array();*/
		}
		function getSectionList(){
			$floor_id=$this->input->post('floor_id');
			//$floor_id=7;
			/*$sql="select f.floor_id,f.floor_no,f.no_of_sections,s.section_id,s.section_name from floor_chart f
				join sections s on s.floor_id=f.floor_id and s.business_id=f.business_id
				where f.floor_id='$floor_id'";
			$query=$this->db->query($sql);
			$data=$query->result_array();
			$sections=array();
			if(!empty($data)){
				foreach($data as $dat){
					$sections[$dat['section_id']]=$dat;
				}
			}*/
			$business_id=$this->input->post('business_id');
			//$business_id=411;
			$query = $this->db->query("call GetAvailableTablesInSectionsByFloor('".$business_id."','".$floor_id."')");			
			$floors_info = $query->result_array();
			
			if(!empty($floors_info)){
				foreach($floors_info as $floor){
					$section_ids=explode(",",$floor['section_id']);
					$section_names=explode(",",$floor['section_name']);
					$sec_tab_count=explode(",",$floor['Available_tables']);
					$sections=array_combine($section_ids,$section_names);
					$i=0;
					foreach($sections as $key=>$value){
						$available[$key]['section_name']=$value;
						$available[$key]['section_id']=$key;
						$available[$key]['floor_id']=$floor['floor_id'];
						$available[$key]['floor_name']=$floor['floor_no'];
						$available[$key]['available_tables']=$sec_tab_count[$i];
						$i++;
					}
				}
			}
			//pr($available);exit;
			$json_array = array("status"=>'success',"status1"=>true,'sections'=>$available);				
			echo json_encode($json_array);
		}
		function getTablesList(){
			$floor_id=$this->input->post('floor_id');
			//$floor_id=7;
			$section_id=$this->input->post('section_id');
			//$section_id=21;
			$query = $this->db->query("call GetAvailableTablesByFloorId('".$section_id."','".$floor_id."','".date('Y-m-d')."')");
			$data1=$query->result_array();
			$this->db->reconnect();
			$data['floor_info']=$this->bookmyt_model->getfloor_info($section_id,$floor_id);
			if(!empty($data['floor_info'])){
				foreach($data['floor_info'] as $key => $floor_info){
					if($floor_info['Booked_Status']==1){
						//$image = substr($floor_info['image'], 0,strrpos($floor_info['image'],'.'));
						$no_of_seats = $floor_info['no_of_seats'];
						if($floor_info['no_of_seats'] % 2==1){
							$no_of_seats = $floor_info['no_of_seats']+1;
						}
						if($no_of_seats>8){
							$no_of_seats = 8;
						}
						$image = $no_of_seats.$floor_info['table_type'];
						if($image!='' && $no_of_seats>0){
						$data['floor_info'][$key]['image'] = $image.'_red';
						}
					}else{
						//$image = substr($floor_info['image'], 0,strrpos($floor_info['image'],'.'));
						$no_of_seats = $floor_info['no_of_seats'];
						if($floor_info['no_of_seats'] % 2==1){
							$no_of_seats = $floor_info['no_of_seats']+1;
						}
						if($no_of_seats>8){
							$no_of_seats = 8;
						}
						$image = $no_of_seats.$floor_info['table_type'];
						if($image!='' && $no_of_seats>0){
						$data['floor_info'][$key]['image'] = $image.'_green';
						}
					}
				}
			}
			//pr($data['floor_info']);exit;
			$no_of_rows=(isset($data1) && !empty($data1))?$data1[0]['no_of_rows']:'';
			$no_of_columns=(isset($data1) && !empty($data1))?$data1[0]['no_of_columns']:'';
			$json_array = array("status"=>'success',"status1"=>true,'no_of_rows'=>$no_of_rows,'no_of_columns'=>$no_of_columns,'tables'=>$data['floor_info']);				
			echo json_encode($json_array);
		}
	public function update_reservation()
	{			
		$time=$this->input->post('in_time');	
		$in_time  = date("H:i:s", strtotime($time));			
		$no_members = $this->input->post('members');		
		$res_id = $this->input->post('res_id');
		$floor = $this->input->post('floor');
		$table_id = trim($this->input->post('table_id'),'[]');
		$table_id=explode(",",$table_id);
		$booked_date1=$this->input->post('booked_date');
		$date = date_create($booked_date1);
		$booked_date =  date_format($date, 'Y-m-d');
		$confirmed=0;
		if($res_id==""){
			$json_array = array("status"=>'failure',"status1"=>false,'msg'=>'Reservation Id is missing');				
			echo json_encode($json_array);exit;
		}
		$business_id=$this->input->post('business_id');
		
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
		if($floor!=""){
		$update['floor'] = $floor;
		}
		if(!empty($table_id) && $table_id[0]!=""){
			$update['table_id'] = $table_id;
		}
		
		if(!empty($table_id) && $table_id[0]!=""){
			$i=1;
			foreach($table_id as $table){
				$sec_tab=explode("_",$table);
				$tab_id=end($sec_tab);
				$section_id=$sec_tab[0];
				if($i==1){
					$userid = $this->bookmyt_model->KM_save(array(
						'class' => "reservation",
						'insert' => array(
							'customer_id' => $reservation['customer_id'],
							'name' => $reservation['name'],
							'phone_no' => $reservation['phone_no'],
							'in_time' => $in_time,
							 'booked_date' => date("Y-m-d"),
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
							'phone_no' => $reservation['phone_no'],
							'in_time' => $in_time,
							 'booked_date' => date("Y-m-d"),
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
			if(!$userid){
				$json_array = array("status"=>'failure',"status1"=>false,'msg'=>'Unable to edit the reservation');				
				echo json_encode($json_array);exit;
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
		$json_array = array("status"=>'success',"status1"=>true,'msg'=>'Reservation updated successfully.');				
		echo json_encode($json_array);				
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */