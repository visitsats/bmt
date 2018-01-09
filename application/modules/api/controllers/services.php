<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Services extends REST_Controller
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->layout = false;
        $this->load->model('users_model');
    }
	
	/**
	* Business add form page
	* @param string X-API-KEY
	* @param string format (xml/json)
	* @output json/xml
	*/
    function getformdetails_post()
    {
        
        $this->__output_details();
        
        
    }
    function __output_details()
    {
	      $allowed_params = array(            
            'X-API-KEY'
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
           $this->response(array("status"=>false,'error' => 'Invalid Request'), 400);
		   exit;
        }
        $data['business_types'] = $this->users_model->get_business_types();
        $data['zones']          = $this->users_model->get_zones();
        $this->response($data, 200);
        
    }
	/**
     * BELOW METHOd IS USED To add business entity
     * @param string business_name,business_email,time_zone,address,phone_no,state,country
     * @param int business_typeid,subscription_type
     * @param string X-API-KEY
     * @param string format (xml/json)
     * @output json/xml
     */
    function add_business_post()
    {
        
        $allowed_params = array(
            'business_name',
            'business_email',
            'time_zone',
            'address',
            'phone_no',
            'state',
            'country',
            'business_typeid',
            'subscription_type',
            'X-API-KEY'
        );
		
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
           $this->response(array("status"=>false,'error' => 'Invalid Request'), 400);
		   exit;
        }
        
        $business_name  = $this->post('business_name');
        $business_email = $this->post('business_email');
        $branch_yes     = $this->post('branch_yes');
        
		if ($branch_yes == 'yes') {
            $branch = 1;
        } else {
            $branch = 0;
        }
        
        $time_zone         = $this->post('time_zone');
        $address           = $this->post('address');
        $phone_no          = $this->post('phone_no');
        $state             = $this->post('state');
        $country           = $this->post('country');
        $relationship_id   = $this->post('relationship_id');
        $business_typeid   = $this->post('business_typeid');
        $subscription_type = $this->post('subscription_type');
        $this->load->model('users_model');
        
		if ($this->users_model->KM_count(array(
            "class" => "business_entity",
            "conditions" => array(
                "business_name" => $business_name,
                "branch" => 1
            )
        ))) 
		{
            $brach_data  = $this->users_model->KM_first(array(
                "class" => "business_entity",
                "fields" => array(
                    "business_id",
                    "relationship_id"
                ),
                "conditions" => array(
                    "business_name" => $business_name,
                    "branch" => 1
                )
            ));
            $input_array = array(
                'branch' => 0,
                'business_name' => $business_name,
                'business_email' => $business_email,
                "time_zone" => $time_zone,
                'address' => $address,
                'phone_no' => $phone_no,
                'state' => $state,
                "country" => $country,
                'relationship_id' => $brach_data['business_id'],
                'business_typeid' => $business_typeid,
                'subscription_type' => $subscription_type
            );
            $userid      = $this->users_model->KM_save(array(
                'class' => "user",
                'insert' => $input_array,
                'return_id' => true
            ));
        }
        /*elseif($this->users_model->KM_count(array("class"=>"business_entity","conditions"=>array("business_email"=>$business_email)))){ //checking email		
        $this->response(array("status"=>false,"error"=>"Duplicate Email"), 400);exit;
        }*/
        else 
		{
            $input_array  = array(
                'branch' => 0,
                'business_name' => $business_name,
                'business_email' => $business_email,
                "time_zone" => $time_zone,
                'address' => $address,
                'phone_no' => $phone_no,
                'state' => $state,
                "country" => $country,
                'relationship_id' => '',
                'business_typeid' => $business_typeid,
                'subscription_type' => $subscription_type
            );
            $created_date = date("Y-m-d H:i:s");
            $userid       = $this->users_model->KM_save(array(
                'class' => "business_entity",
                'insert' => $input_array,
                'return_id' => true
            ));
            
            if ($userid) {
               
                $data = array(
                    "status" => true,
                    "success" => "Business registered successfully.",
                    "data" => array(
                        "Id" => $userid,
                        "business_name" => $business_name,
                        "business_email" => $business_email,
                        "Created date" => $created_date
                    )
                );
                $this->response($data, 200);
            }
            
            else {
                $this->response(array(
                    "status" => false,
                    'error' => 'Not Found'
                ), 400);
            }
        }
    }
    
	
	
	function add_business_customer_post()
    {
	
        $allowed_params = array(
            'business_name',
            'business_email_phn',            
            'business_types',           
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
          // $this->response(array("status"=>false,'error' => 'Invalid Request'), 400);
		  // exit;
        }
        
        $business_name  = $this->post('business_name');
        $business_email = $this->post('business_email_phn');
        $location = $this->post('location');
        $your_name = $this->post('your_name');
        $want_demo = $this->post('want_demo');
         $owner_name = (($this->post('owner_name') !='')?$this->post('owner_name'):'');
         $no_of_emps = (($this->post('no_of_emps') !='')?$this->post('no_of_emps'):'');
         $year_establish = (($this->post('year_establish') !='')?$this->post('year_establish'):'');
		//$time_zone = $this->post('t_zone');
		
		$country = $this->post('country');
		$state = $this->post('state');
		//$password = $this->post('rand_pwd');
		$ip_address = $this->post('ip_address');
        //$business_types     = $this->post('business_types');
        $this->load->model('users_model');
        
		if ($this->users_model->KM_count(array(
            "class" => "business_entity",
            "conditions" => array(
                "business_name" => $business_name
            )
        ))) 
		{
			$data = array(
                    "status" => false,
                    "success" => "Business already exists"
                );
                $this->response($data, 200);
        }
        /*elseif($this->users_model->KM_count(array("class"=>"business_entity","conditions"=>array("business_email"=>$business_email)))){ //checking email		
        $this->response(array("status"=>false,"error"=>"Duplicate Email"), 400);exit;
        }*/
        else 
		{
			if($location!='')
			{
			
			$timezones=$this->users_model->get_zone($location);
			if(is_array($timezones) && !empty($timezones))
			{
			$time_zone=$timezones[0]['idtimezonebyzipcode'];
			}else
			{
			
			$time_zone='Asia/Kolkata';
			}
			}
			if(is_numeric($business_email))
			{
				$data = array(
						"status" => false,
						"success" => "Now Its Only For Email."
					);
					$this->response($data, 200);
			}
			else
			{
				
				//'password' => md5($password),
				$created_date = date("Y-m-d H:i:s");
				$input_array  = array(
					'branch' => 0,
					'business_name' => $business_name,
					'business_email' => $business_email,
					'address' => $location,
					'your_name' => $your_name,
					'want_demo' => $want_demo,
					'owner_name' => $owner_name, 
					'no_of_emps' => $no_of_emps, 
					'year_establish' => $year_establish, 
					'time_zone' => $time_zone,
					'country'=>$country,
					'state' => $state,
					'business_typeid' => 1,		
					'created_ts' => $created_date
				);
			//	print_r($input_array);exit();
				//$created_date = date("d-m-Y H:i:s");
				$userid   = $this->users_model->KM_save(array(
					'class' => "business_entity",
					'insert' => $input_array,
					'return_id' => true
				));
				
				if ($userid) 
				{
					$data = array(
						"status" => true,
						"success" => "Business registered successfully.",
						
						"data" => array(
							"Id" => $userid,
							"business_name" => $business_name,
							"business_email" => $business_email,
							"time_zone" => $time_zone,
							"country" => $country,
							"Created date" => $created_date
						)
					);
					$this->response($data, 200);
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
    }
	public function delete_branch_post()
	{
	
			$business_id=$this->input->post('business_id');
	     
     
         $res  =  $this->db->query("CALL RemoveBusinessByBusinessId('$business_id')");
			// $this->users_model->KM_delete(array(
			// "class" => "reservation",
			// "conditions" => array(
			// "business_id" => $business_id
			// )
			// ));
			
			// $this->users_model->KM_delete(array(
			// "class" => "reservation",
			// "conditions" => array(
			// "brnch_id" => $business_id
			// )
			// ));
			
			// $this->users_model->KM_delete(array(
			// "class" => "user_details",
			// "conditions" => array(
			// "business_id" => $business_id
			// )
			// ));
			// $this->users_model->KM_delete(array(
			// "class" => "user_details",
			// "conditions" => array(
			// "branch_id" => $business_id
			// )
			// ));
			// $this->users_model->KM_delete(array(
			// "class" => "table_info",
			// "conditions" => array(
			// "business_id" => $business_id
			// )
			// ));
			// $this->users_model->KM_delete(array(
			// "class" => "floor_chart",
			// "conditions" => array(
			// "business_id" => $business_id
			// )
			// ));
			// $brch = $this->users_model->KM_delete(array(
			// "class" => "business_entity",
			// "conditions" => array(
			// "business_id" => $business_id
			// )
			// ));
			if($res)
			{
				$data = array(
				"status" => true,
				"success" => "Branch deleted successfully."
				);
				
			}
			else
			{
				$data = array(
				"status" => false,
				"fail" => "Branch Not Deleted"
				);
			}
			$this->response($data, 200);




	}
	
	function add_branch_post()
    {
        
		$business_name    = $this->input->post('business_name');
		$business_email     = $this->input->post('business_email');
		$password     = $this->input->post('rand_pwd');
		$branch            = 1;
		$country          = $this->input->post('country');
		$state        = $this->input->post('state');
		$phone_no           = $this->input->post('phone_no');
		$address       = $this->input->post('address');
		$email          = $this->input->post('email');
		$business_typeid = $this->input->post('business_types');
		$time_zone    = $this->input->post('time_zone');
		$relationship_id=$this->input->post('relationship_id');
		$created_date = date("Y-m-d H:i:s");
       
	   $this->load->model('users_model');
       
	   if ($this->users_model->KM_count(array(
            "class" => "business_entity",
            "conditions" => array(
                "business_email" => $business_email
            )
        ))) {
			$data = array(
                    "status" => false,
                    "success" => "Email already exists."
                );
                $this->response($data, 200);
        }
        /*elseif($this->users_model->KM_count(array("class"=>"business_entity","conditions"=>array("business_email"=>$business_email)))){ //checking email		
        $this->response(array("status"=>false,"error"=>"Duplicate Email"), 400);exit;
        }*/
        else {
            $system_array   = array(
                'business_name' => $business_name,             
                'business_email' => $business_email,
				'password' => $password,
                'country'=>$country,
                'address' => $address,
                'phone_no' => $phone_no,
                'state' => $state,
                'time_zone' => $time_zone,
				'relationship_id'=>$relationship_id,
                'business_typeid' => $business_typeid,
				'created_ts' => $created_date,
				'is_active' => 1,
                'branch' => 1
              
            );
			
            $created_date = date("Y-m-d H:i:s");
            $userid       = $this->users_model->KM_save(array(
                'class' => "business_entity",
                'insert' => $system_array,
                'return_id' => true
            ));
            
            if ($userid) {
               
                $data = array(
                    "status" => true,
                    "success" => "Branch added successfully",
                    "data" => array(
                        "Id" => $userid,
                        "business_name" => $business_name,
                        "business_email" => $business_email,
                        "Created date" => $created_date
                    )
                );
                $this->response($data, 200);
            }
            
            else {
                $this->response(array(
                    "status" => false,
                    'error' => 'Not Found'
                ), 400);
            }
        }
    }
	function edit_branch_post()
    {
        
       
		$business_name    = $this->input->post('business_name');
		$business_email     = $this->input->post('business_email');
		$password     = $this->input->post('password');
		$branch            = 1;
		$country          = $this->input->post('country');
		$state        = $this->input->post('state');
		$phone_no           = $this->input->post('phone_no');
		$address       = $this->input->post('address');
		$email          = $this->input->post('email');
		$business_typeid = $this->input->post('business_types');
		$time_zone    = $this->input->post('time_zone');
		$business_id=$this->input->post('business_id');
		//$have_branches = $this->input->post('b_check');
        $this->load->model('users_model');
     
            $system_array   = array(
                'business_name' => $business_name,             
                'business_email' => $business_email,
			    'country'=>$country,
                'address' => $address,
                'phone_no' => $phone_no,
                'state' => $state,
                'time_zone' => $time_zone,				
                'business_typeid' => $business_typeid              
              
            );
			
            $created_date = date("Y-m-d H:i:s");
            $userid       = $this->users_model->KM_update(array(
                    'class' => "business_entity",
                    'update' => $system_array
                ), array(
                    "business_id" => $business_id
                ));
			
			if($userid)
			{
				$this->session->set_userdata('business_name',$business_name);
			}
            
            if ($userid) {
               
                $data = array(
                    "status" => true,
                    "success" => "Branch updated successfully",
                    "data" => array(
                        "Id" => $userid,
                        "business_name" => $business_name,
                        "business_email" => $business_email,
                        "Created date" => $created_date
                    )
                );
                $this->response($data, 200);
            }
            
          
    }
	
	
	
	
	/**
	* BELOW METHOd IS USED TO ADD FLOOR
	* @param int business_id,floor_no,no_of_tables
	* @param string format (xml/json)
	* @output json/xml
	*/ 
    function add_floor_post()
    {
        
        $floor_no     = $this->post('floor_no');
        $business_id  = $this->post('relationship_id');
        $no_of_tables = $this->post('no_of_tables');
        $this->load->model('users_model');
        
        
        if ($this->users_model->KM_count(array(
            "class" => "floor_chart",
            "conditions" => array(
                "floor_no" => $floor_no,
                "business_id" => $business_id
            )
        ))) { 
            $this->response(array(
                "status" => false,
                "success" => "Duplicate Floor"
            ), 400);
            exit;
        } else {
            $created_date = date("Y-m-d H:i:s");
            $userid       = $this->users_model->KM_save(array(
                'class' => "floor_chart",
                'insert' => array(
                    'floor_no' => $floor_no,
                    'business_id' => $business_id,
                    'no_of_tables' => $no_of_tables
                ),
                'return_id' => true
            ));
            
            if ($userid) {
                	//$this->__save_to_log($hwid,$userid,0,'register',$created_date);
               // $this->users_model->KM_save(array("class"=>"userdevice","insert"=>array("userid"=>$userid,"hwid"=>$hwid)));
                $data = array(
                    "status" => true,
                    "success" => "Floor added successfully.",
                    "data" => array(
                        "Id" => $userid,
                        "business_id" => $business_id,
                        "floor_no" => $floor_no,
                        "Created date" => $created_date
                    )
                );
                $this->response($data, 200);
            }
            
            else {
                $this->response(array(
                    "status" => false,
                    'error' => 'Not Found'
                ), 400);
            }
        }
    }
	function edit_floor_post()
    {
        
        $floor_no     = $this->post('floor_no');
        $floor_id  = $this->post('floor_id');
        $no_of_tables = $this->post('no_of_tables');
        $this->load->model('users_model');
        
        
    
            $created_date = date("Y-m-d H:i:s");
       
            $userid       = $this->users_model->KM_update(array(
                    'class' => "floor_chart",
                    'update' =>  array(
                    'floor_no' => $floor_no,
                    'no_of_tables' => $no_of_tables
                )
                ), array(
                    "floor_id" => $floor_id
                ));
            if ($userid) {
                	//$this->__save_to_log($hwid,$userid,0,'register',$created_date);
               // $this->users_model->KM_save(array("class"=>"userdevice","insert"=>array("userid"=>$userid,"hwid"=>$hwid)));
                $data = array(
                    "status" => true,
                    "success" => "Floor updated successfully."
                 
                );
                $this->response($data, 200);
            }
            
          
       
    }
	public function floorslist_post()
	{
		$business_id=$this->input->post('business_id');
		$have_branches = $this->input->post('have_brchs');
		// $user_id = $this->input->post('user_id');
		// if($user_id!='')
		// {
			// $business_id = $this->input->post('branch_id');
		// }		
		$data['floors_list']= $this->users_model->get_floors_list($business_id,$have_branches);		
		$this->response($data, 200);
	
	}
	public function delete_floor_post()
	{
	
			$floor_id=$this->input->post('floor_id');
			
			$this->users_model->KM_delete(array(
			"class" => "reservation",
			"conditions" => array(
			"floor" => $floor_id
			)
			));
			
			$this->users_model->KM_delete(array(
			"class" => "table_info",
			"conditions" => array(
			"floor_id" => $floor_id
			)
			));
			
			$this->users_model->KM_delete(array(
			"class" => "floor_chart",
			"conditions" => array(
			"floor_id" => $floor_id
			)
			));
			
			$data = array(
			"status" => true,
			"success" => "Floor deleted successfully"
			);
			$this->response($data, 200);
	}
	
        /**
	* TO GET FLOOR INFORMATION BY BUSINESS ID
	* @param int pbusiness_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function get_floorinfo_post()
    {
        
        $allowed_params = array(
            'pbusiness_id'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $pbusiness_id = $this->post('pbusiness_id');           
     
        $data['floorinfo'] = $this->db->query("CALL GetFloorInfoByBusinessId('$pbusiness_id')");
        
        if (empty($data['reservationinfo'])) { 	
            $this->response(array(
                "status" => false,
                "error" => "Data Not Found"
            ), 400);
			
            exit;
        } else {

                $this->response($data, 200);
            
            
         
        }
    }
    /**
	* BELOW METHOD IS USED TO TABLE CREATION
	* @param int no_of_seats,floor_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function add_table_post()
    {
         $no_of_seats = $this->post('no_of_seats');
        $floor_id    = $this->post('floor_id');
		$relationship_id=$this->post('relationship_id');
        $table_no=$this->post('table_no');
             if ($this->users_model->KM_count(array(
            "class" => "table_info",
            "conditions" => array(
                "floor_id" => $floor_id,
               	"table_no"=>$table_no
            )
        ))) { 
            $this->response(array(
                "status" => false,
                "success" => "Duplicate Table"
            ), 400);
            exit;
        } else {
       
        $this->load->model('users_model');
        $created_date = date("Y-m-d H:i:s");
        $userid       = $this->users_model->KM_save(array(
            'class' => "table_info",
            'insert' => array(
                'no_of_seats' => $no_of_seats,
                'floor_id' => $floor_id,
				'business_id'=>$relationship_id,
				'table_no'=>$table_no
				
            ),
            'return_id' => true
        ));
        
        if ($userid) {
            
            $data = array(
                "status" => true,
                "success" => "Table added successfully",
                "data" => array(
                    "Id" => $userid,
                    "floor_id" => $floor_id,
                    "no_of_seats" => $no_of_seats
                )
            );
            $this->response($data, 200);
        }
        }
     
        
    }
	function edit_table_post()
    {
        
       
         $no_of_seats = $this->post('no_of_seats');
        $floor_id    = $this->post('floor_id');
		   $table_id=$this->post('table_id');
		 $table_no=$this->post('table_no');
        $this->load->model('users_model');
        
        
    
            $created_date = date("Y-m-d H:i:s");
       
            $userid       = $this->users_model->KM_update(array(
                    'class' => "table_info",
                    'update' =>  array(
                    'no_of_seats' => $no_of_seats,
                'floor_id' => $floor_id,				
				'table_no'=>$table_no
                )
                ), array(
                    "table_id" => $table_id
                ));
            if ($userid) {
                	//$this->__save_to_log($hwid,$userid,0,'register',$created_date);
               // $this->users_model->KM_save(array("class"=>"userdevice","insert"=>array("userid"=>$userid,"hwid"=>$hwid)));
                $data = array(
                    "status" => true,
                    "success" => "Table updated successfully."
                 
                );
                $this->response($data, 200);
            }
            
          
       
    }
	public function delete_table_post()
	{
	
			$table_id=$this->input->post('table_id');
			$this->users_model->KM_delete(array(
			"class" => "table_info",
			"conditions" => array(
			"table_id" => $table_id
			)
			));

			$data = array(
			"status" => true,
			"success" => "Table deleted successfully."
			);
			$this->response($data, 200);




	}
	public function tableslist_post()
	{
	  
	 
	 $business_id=$this->input->post('business_id');
	  $data['tables_list']= $this->users_model->get_tables_list($business_id);
	  $this->response($data, 200);
	
	}
     /**
	* TO GET NO OF SEATS  BY TABLE ID
	* @param int ptable_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function get_noofseatsinfobytable_post()
    {
        
        $allowed_params = array(
            'ptable_id'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $ptable_id = $this->post('ptable_id');           
     
        $data['table_seatsinfo'] = $this->db->query("CALL GetNoOfSeatsByTableId('$ptable_id')");
        
        if (empty($data['table_seatsinfo'])) { 	
            $this->response(array(
                "status" => false,
                "error" => "Data Not Found"
            ), 400);
            exit;
        } else {

                $this->response($data, 200);
            
            
         
        }
    }
	
	
	/**
	* TO GET NO OF TABLES INFO  BY BUSINESS ID
	* @param int pbusiness_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function get_noofseatsinfo_post()
    {
        
        $allowed_params = array(
            'pbusiness_id'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $pbusiness_id = $this->post('pbusiness_id');           
     
        $data['table_seatsinfo'] = $this->db->query("CALL GetNoOfTablesByBusinessId('$pbusiness_id')");
        
        if (empty($data['table_seatsinfo'])) { 	
            $this->response(array(
                "status" => false,
                "error" => "Data Not Found"
            ), 400);
            exit;
        } else {

                $this->response($data, 200);
            
            
         
        }
    }
	
	
	/**
	* TO DELETE TABLES IN FLOOR
	* @param int pbusiness_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function deletetablesinfo_post()
    {
        
        $allowed_params = array(
            'pfloor_id','ptable_id'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $pfloor_id = $this->post('pfloor_id');           
        $ptable_id = $this->post('ptable_id');    
        $sucess = $this->db->query("CALL RemoveTablesInFloor('$ptable_id','$pfloor_id')");
        
        if (!$sucess) { 	
            $this->response(array(
                "status" => false,
                "error" => "Tables is not deleted"
            ), 400);
            exit;
        } else {

                $this->response(array(
                "status" => true,
                "error" => "Tables is deleted"
            ), 200);
            exit;
            
            
         
        }
    }
      /**
	* BELOW METHOd IS USED TO ADD CUSTOMER
	* @param string name,phone_no,password,email
	* @param int app_downloaded,points_scored
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function add_customer_post()
    {
        
        $allowed_params = array(
            'name',
            'phone_no',
            'password',
            'email',
            'app_downloaded',
            'points_scored'
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $name           = $this->post('name');
        $phone_no       = $this->post('phone_no');
        $password       = $this->post('password');
        $email          = $this->post('email');
        $app_downloaded = $this->post('app_downloaded');
        $points_scored  = $this->post('points_scored');
        
        $this->load->model('users_model');
        
        
        if ($this->users_model->KM_count(array(
            "class" => "customer",
            "conditions" => array(
                "email" => $email
            )
        ))) { 	
            $this->response(array(
                "status" => false,
                "error" => "Duplicate Email"
            ), 400);
            exit;
        } else {
            $created_date = date("Y-m-d H:i:s");
            $userid       = $this->users_model->KM_save(array(
                'class' => "customer",
                'insert' => array(
                    'name' => $name,
                    'phone_no' => $phone_no,
                    'password' => $password,
                    "email" => $email,
                    'app_downloaded' => $app_downloaded,
                    'points_scored' => $points_scored
                ),
                'return_id' => true
            ));
            
            if ($userid) {
               	$this->__save_to_log($hwid,$userid,0,'register',$created_date);
                $this->users_model->KM_save(array("class"=>"userdevice","insert"=>array("userid"=>$userid,"hwid"=>$hwid)));
                $data = array(
                    "status" => true,
                    "success" => "Customer registered successfully.",
                    "data" => array(
                        "Id" => $userid,
                        "name" => $name,
                        "email" => $email,
                        "Created date" => $created_date
                    )
                );
                $this->response($data, 200);
            }
            
            else {
                $this->response(array(
                    "status" => false,
                    'error' => 'Not Found'
                ), 400);
            }
        }
    }
     /**
	* TO GET CUSTOMER INFORMATION BY BUSINESS ID
	* @param int pbusiness_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function get_customerinfo_post()
    {
        
        $allowed_params = array(
            'pbusiness_id'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $pbusiness_id = $this->post('pbusiness_id');           
     
        $data['customerinfo'] = $this->db->query("CALL GetCustomersInfoByBusinessId('$pbusiness_id')");
        
        if (empty($data['customerinfo'])) { 	
            $this->response(array(
                "status" => false,
                "error" => "Data Not Found"
            ), 400);
            exit;
        } else {

                $this->response($data, 200);
            
            
         
        }
    }
	
	/**
	* UPDATE CUSTOMER INFORMATION BY CUSTOMER ID
	* @param string pphone_no,ppassword,pemail,ppoints
	* @param int pcustomer_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function updatecustomerinfo_post()
    {
        
        $allowed_params = array(
            'pcustomer_id','pphone_no','ppassword','pemail','ppoints'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $pfloor_id = $this->post('pfloor_id');           
        $ptable_id = $this->post('ptable_id');    
        $sucess = $this->db->query("CALL UpdateCustomerDetailsById('$pcustomer_id','$pphone_no','$ppassword','$pemail','$ppoints')");
        
        if (!$sucess) { 	
            $this->response(array(
                "status" => false,
                "error" => "Customer data is not updated."
            ), 400);
            exit;
        } else {

                $this->response(array(
                "status" => true,
                "error" => "Customer data is updated sucessfully."
            ), 200);
            exit;
            
            
         
        }
    }
   /**
	* BELOW METHOd IS USED TO RESERVE A TABLE
	* @param string name,phone_no,in_time,bill_amount,menu_items
	* @param int table_for,table_id,bill_no,scored_points
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    
    function add_reservation_table_post()
    {
        
        $allowed_params = array(
            'customer_id',
            'name',
            'phone_no',
            'in_time',
            'table_for',
            'out_time',
            'table_id',
            'booked_date',
            'confirmed',
            'bill_no',
            'bill_amount',
            'scored_points',
            'menu_items'
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $customer_id   = $this->post('customer_id');
        $name          = $this->post('name');
        $phone_no      = $this->post('phone_no');
        $in_time       = $this->post('in_time');
        $table_for     = $this->post('table_for');
        $out_time      = $this->post('out_time');
        $table_id      = $this->post('table_id');
        $booked_date   = $this->post('booked_date');
        $confirmed     = $this->post('confirmed');
        $bill_no       = $this->post('bill_no');
        $bill_amount   = $this->post('bill_amount');
        $scored_points = $this->post('scored_points');
        $menu_items    = $this->post('menu_items');
        $business_id   = $this->post('business_id');
        $promotion_id  = $this->post('promotion_id');
        $bill_no       = $this->post('bill_no');
        $disc_amount   = $this->post('disc_amount');
        $status        = $this->post('status');
        
        $this->load->model('users_model');
        
        $created_date = date("Y-m-d H:i:s");
        $userid       = $this->users_model->KM_save(array(
            'class' => "reservation",
            'insert' => array(
                'customer_id' => $customer_id,
                'name' => $name,
                'phone_no' => $phone_no,
                "in_time" => $in_time,
                'table_for' => $table_for,
                'out_time' => $out_time,
                'table_id' => $table_id,
                "booked_date" => $booked_date,
                'confirmed' => $confirmed,
                'bill_no' => $bill_no,
                'bill_amount' => $bill_amount,
                "scored_points" => $scored_points,
                'menu_items' => $menu_items,
                'business_id' => $business_id,
                'promotion_id' => $promotion_id,
                'bill_no' => $bill_no,
                'disc_amount' => $disc_amount,
                'status' => $status
            ),
            'return_id' => true
        ));
        
        if ($userid) {
            
            $data = array(
                "status" => true,
                "success" => "success",
                "data" => array(
                    "Id" => $userid,
                    "Created date" => $created_date
                )
            );
            $this->response($data, 200);
        }
        
        else {
            $this->response(array(
                "status" => false,
                'error' => 'Not Found'
            ), 400);
        }
        
    }
	
	/**
	* UPDATE RESERVATION TABLE INFORMATION
	* @param string p_intime,p_outtime,p_menu
	* @param int p_tableid,p_table_for,p_status
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function updatereservationinfo_post()
    {
        
        $allowed_params = array(
            'p_intime','p_outtime','p_menu','p_tableid','p_table_for','p_status'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $p_intime = $this->post('p_intime');           
        $p_outtime = $this->post('p_outtime');  
		$p_menu = $this->post('p_menu');           
		$p_tableid = $this->post('p_tableid');    
		$p_table_for = $this->post('p_table_for');           
		$p_status = $this->post('p_status');    		
        $sucess = $this->db->query("CALL UpdateReservationDetailsByReservationId('$p_intime','$p_outtime','$p_tableid','$p_table_for','$p_menu','$p_status')");
        
        if (!$sucess) { 	
            $this->response(array(
                "status" => false,
                "error" => "Reservation table data is not updated."
            ), 400);
            exit;
        } else {

                $this->response(array(
                "status" => true,
                "error" => "Reservation table data is updated sucessfully."
            ), 200);
            exit;
            
            
         
        }
    }
	
	
	/**
	* UPDATE TABLE INFORMATION
	* @param int ptable_id,pno_of_seats,pfloor_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function updatetableinfo_post()
    {
        
        $allowed_params = array(
            'ptable_id','pno_of_seats','pfloor_id'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        $ptable_id = $this->post('ptable_id');           
		$pno_of_seats = $this->post('pno_of_seats');  
		$pfloor_id = $this->post('pfloor_id');           
		$sucess = $this->db->query("CALL   UpdateTableInfoByTableId('$ptable_id','$pno_of_seats','$pfloor_id')");        
        if (!$sucess) { 	
            $this->response(array(
                "status" => false,
                "error" => "table info not updated."
            ), 400);
            exit;
        } else {

                $this->response(array(
                "status" => true,
                "error" => "table info updated sucessfully."
            ), 200);
            exit;
            
            
         
        }
    }
    /**
	* TO GET TABLE RESERVETION INFORMATION BY Reservation ID
	* @param int p_reservation_id
	* @param string format (xml/json)
	* @output json/xml
	*/ 

    function get_tablereservationinfo_post()
    {
        
        $allowed_params = array(
            'p_reservation_id'
            
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $p_reservation_id = $this->post('p_reservation_id');           
     
        $data['reservationinfo'] = $this->db->query("CALL GetDetailsByReservationId('$p_reservation_id')");
        
        if (empty($data['reservationinfo'])) { 	
            $this->response(array(
                "status" => false,
                "error" => "Data Not Found"
            ), 400);
            exit;
        } else {

                $this->response($data, 200);
            
            
         
        }
    }
    /**
	* BELOW METHOd IS USED TO ADD DISCOUNT COUPON
	* @param string promotion_type,description
	* @param int disc_on_cur_bill,disc_on_last_bill,disc_on_group,disc_on_freq_cust,disc_percent
	* @param string format (xml/json)
	* @output json/xml
	*/ 
    function add_discount_coupon_post()
    {
        
        $allowed_params = array(
            'promotion_type',
            'disc_on_cur_bill',
            'disc_on_last_bill',
            'disc_on_group',
            'disc_on_freq_cust',
            'disc_percent',
            'description'
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $promotion_type    = $this->post('promotion_type');
        $disc_on_cur_bill  = $this->post('disc_on_cur_bill');
        $disc_on_last_bill = $this->post('disc_on_last_bill');
        $disc_on_group     = $this->post('disc_on_group');
        $disc_on_freq_cust = $this->post('disc_on_freq_cust');
        $disc_percent      = $this->post('disc_percent');
        $description       = $this->post('description');
        
        $this->load->model('users_model');
        
        $created_date = date("Y-m-d H:i:s");
        $userid       = $this->users_model->KM_save(array(
            'class' => "promotion",
            'insert' => array(
                'promotion_type' => $promotion_type,
                'disc_on_cur_bill' => $disc_on_cur_bill,
                'disc_on_last_bill' => $disc_on_last_bill,
                "disc_on_group" => $disc_on_group,
                'disc_on_group' => $disc_on_group,
                'disc_on_freq_cust' => $disc_on_freq_cust,
                'disc_percent' => $disc_percent,
                "description" => $description
            ),
            'return_id' => true
        ));
        
        if ($userid) {
           	$this->__save_to_log($hwid,$userid,0,'register',$created_date);
            $this->users_model->KM_save(array("class"=>"userdevice","insert"=>array("userid"=>$userid,"hwid"=>$hwid)));
            $data = array(
                "status" => true,
                "success" => "Discount added Sucessfully",
                "data" => array(
                    "Id" => $userid,
                    "Created date" => $created_date
                )
            );
            $this->response($data, 200);
        }
        
        else {
            $this->response(array(
                "status" => false,
                'error' => 'Not Found'
            ), 400);
        }
        
    }
    
    
    function login_post()
    {
        
        $allowed_params = array(
            'username',
            'password',
            'format',
            'hardware_id',
            'X-API-KEY'
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $username = $this->post('username');
        $password = $this->post('password');
        $hwid     = $this->post('hardware_id');
        
        if (!$username || !$password) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Data'
            ), 400);
            exit;
        }
        
        
        $this->load->model('users_model');
        
        $userdata = $this->users_model->KM_first(array(
            "class" => "user",
            "fields" => array(
                "id",
                "username",
                "email"
            ),
            "conditions" => array(
                "username" => $username,
                "pwd" => $password
            )
        ));
        if (empty($userdata)) {
            $this->response(array(
                "status" => false,
                "error" => "Invalid Credentials"
            ), 400);
            exit;
        } else {
            $this->__save_to_log($hwid, $userdata['id'], 0, 'login');
            $data = array(
                "status" => true,
                "success" => "User available",
                "data" => $userdata
            );
            $this->response($data, 200);
            
        }
    }
    
    /**
     * social_login_post Method
     *
     * social_login_post check a exists with a supplied email, Used for login through social login . Used for post request. 
     *
     * @param string email	
     * @param string hardware_id
     * @param string X-API-KEY
     * @param string format (xml/json)
     * @output json/xml
     */
    
    function social_login_post()
    {
        
        $allowed_params = array(
            'email',
            'format',
            'hardware_id',
            'social_media',
            'X-API-KEY'
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $email        = $this->post('email');
        $hwid         = $this->post('hardware_id');
        $social_media = $this->post('social_media');
        
        if (!$email) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Data'
            ), 400);
            exit;
        }
        
        
        $this->load->model('users_model');
        $created_date = date("Y-m-d H:i:s");
        $userdata     = $this->users_model->KM_first(array(
            "class" => "user",
            "fields" => array(
                "id",
                "email",
                'smname'
            ),
            "conditions" => array(
                "email" => $email
            )
        ));
        if (empty($userdata)) 
		{
            $userid = $this->users_model->KM_save(array(
                'class' => "user",
                'insert' => array(
                    'email' => $email,
                    'smname' => $social_media,
                    "createddate" => $created_date
                ),
                'return_id' => true
            ));
            
            $this->__save_to_log($hwid, $userid, 0, 'social login');
            $data = array(
                "status" => true,
                "success" => "User available",
                "data" => array(
                    "id" => $userid,
                    "email" => $email
                )
            );
            $this->response($data, 200);
            exit;
            
        } else {
            if (!$userdata['smname']) {
                $this->users_model->KM_update(array(
                    'class' => "user",
                    'update' => array(
                        'smname' => $social_media
                    )
                ), array(
                    "id" => $userdata['id']
                ));
            }
            $this->__save_to_log($hwid, $userdata['id'], 0, 'social login');
            $data = array(
                "status" => true,
                "success" => "User available",
                "data" => $userdata
            );
            $this->response($data, 200);
            exit;
            
        }
    }
    
    /**
     * forgotpassword_post Method
     *
     * forgotpassword_post check a exists with a supplied email, send the password to the user. Used for post request. 
     *
     * @param string email	
     * @param string hardware_id
     * @param string X-API-KEY
     * @param string format (xml/json)
     * @output json/xml
     */
    
    function forgotpassword_post()
    {
        
        $allowed_params = array(
            'email',
            'format',
            'hardware_id',
            'X-API-KEY'
        );
        if (count(array_diff(array_keys($this->_post_args), $allowed_params)) > 0) {
            $this->response(array(
                "status" => false,
                'error' => 'Invalid Request'
            ), 400);
            exit;
        }
        
        $email       = $this->post('email');
        $hwid        = $this->post('hardware_id');
        //raghu code start
        $username    = 'admin';
        $password    = '1234';
        $xapi        = $this->post('X-API-KEY');
        // Alternative JSON version
        // $url = '<span class="skimlinks-unlinked">http://twitter.com/statuses/update.json</span>';
        // Set up and execute the curl process
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'http://knowledgematrix.net/shop_guard/api/users/forgotpassword/format/json');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
            'email' => $email,
            'hardware_id' => $hwid,
            'X-API-KEY' => $xapi
        ));
        
        // Optional, delete this line if your API is open
        curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
        $buffer = curl_exec($curl_handle);
        print_r($buffer);
        //raghu code end
        
        /*if(!$email)
        {
        $this->response(array("status"=>false,'error' => 'Invalid Data'), 400);exit;
        }
        
        
        $this->load->model('users_model');
        
        $userdata=$this->users_model->KM_first(array("class"=>"user","fields"=>array("id","username","email",'pwd'),"conditions"=>array("email"=>$email))) ;
        if(empty($userdata)){
        $this->response(array("status"=>false,"error"=>"Invalid email"), 400);exit;
        }
        else{ 
        
        $this->__save_to_log($hwid,$userdata['id'],0,'forgot password');
        $ema=$this->KM_send_email($to=array($email),$subject='Password for your Smarty Buggy Account',$body='Your Password is:'.$userdata['pwd']);	
        
        if($ema){	
        
        $data=array("status"=>true,"success"=>"Password Sent");
        $this->response($data, 200); 
        }
        else{
        $data=array("status"=>false,"error"=>"Unable to send mail");
        $this->response($data, 400);
        }
        
        }
        */
    }
    
    public function reservationlist_post()
	{
	  
		$business_id=$this->input->post('business_id');
		$have_branches = $this->input->post('have_brchs');
		$user_id=$this->input->post('user_id');
		// if($user_id!='')
		// {
			// $business_id = $this->input->post('branch_id');
		// }
		$data['reservation_list']= $this->users_model->reservation_list($business_id,$have_branches);
		$this->response($data, 200);	
	}
	
	
	
	
	public function delete_reservation_post()
	{
	
			$reservation_id=$this->input->post('reservation_id');
			$this->users_model->KM_delete(array(
			"class" => "reservation",
			"conditions" => array(
			"reservation_id" => $reservation_id
			)
			));

			$data = array(
			"status" => true,
			"success" => "Reservation deleted successfully."
			);
			$this->response($data, 200);

	}
	
	
	
	
	// Code Added By Leela Kumar.
	public function can_reservation_post()
	{
		$reservation_id=$this->input->post('reservation_id');
		$userid       = $this->users_model->KM_update(array(
                    'class' => "reservation",
                    'update' =>  array(
                    'confirmed' => 2
                )
                ), array(
                    "reservation_id" => $reservation_id
                ));
		if($userid)
		{
			$data = array(
			"status" => true,
			"success" => "Reservation cancelled successfully"
			);
			$this->response($data, 200);
		}
		
		
	}
	
	public function reslist_post()
	{
		$business_id=$this->input->post('business_id');
		$user_id=$this->input->post('user_id');
		$hb = $this->input->post('hb');
		// if($user_id!='')
		// {
			// $business_id = $this->input->post('branch_id');
		// }		
		$data['res_list']= $this->users_model->res_list($business_id,$hb);
		$this->response($data, 200);	
	}
	
	public function brancheslist_post()
	{
		$business_id=$this->input->post('business_id');
		$data['braches_list']= $this->users_model->get_branches_list($business_id);
		$this->response($data, 200);
	
	}
	
	public function create_password_post()
	{
		$business_id=$this->input->post('business_id');
		$new = $this->input->post('new');
		$set = $this->users_model->create_password($business_id,$new);
		if($set == true)
		{
			$data = array(
			"status" => 1,
			"success" => "Login with new business password."
			);
			$this->response($data, 200);
		}
	}
	

	
	public function add_user_post()
	{
		
		
		if(is_numeric($this->input->post('email_phn')))
		{
			$data = array(
                    "status" => false,
                    "success" => "Now Its Only For Email."
                );
                $this->response($data, 200);
		}
		else
		{
			$user_type = $this->input->post('user_type');
			$rel_id = $this->input->post('rel_id');
			if($rel_id != '')
			{
				$relationship_id = $rel_id;
			}
			else
			{
				$relationship_id = NULL;
			}
			
			$userid       = $this->users_model->KM_save(array(
				'class' => "user_details",
				'insert' => array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('rand_pwd'),
					'email' => $this->input->post('email_phn'),
					"user_type_id" => $user_type,
					'business_id' => $this->input->post('branch'),
					'relationship_id' => $relationship_id,
				),
				'return_id' => true
			));
			$data = array(
				"status" => 1,
				"email" => $this->input->post('email_phn'),
				"uid" => $userid,
				"success" => "User added successfully"
				);
				$this->response($data, 200);
			
		}
	}
	
	public function userslist_post()
	{
		$business_id=$this->input->post('business_id');
		$have_branches = $this->input->post('have_branches');
		$data['users_list']= $this->users_model->get_users_list($business_id,$have_branches);
		$this->response($data, 200);	
	}
	
	public function edit_user_post()
	{
		$business_id=$this->input->post('business_id');
		$uid = $this->input->post('user_id'); 		 
		$data['get_user'] = $this->users_model->get_user_info($uid);
		$this->response($data, 200);	
	}
	
	public function update_user_post()
	{
		$user_type =$this->input->post('user_type');
		$rel_id = $this->input->post('rel_id');
		
		if($rel_id != '')
		{
			$relationship_id = $rel_id;
		}
		else
		{
			$relationship_id = NULL;
		}
		
		$uid = $this->input->post('user_id'); 
		
		$data = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email_phn'),
			"user_type_id" => $user_type,
			'business_id' => $this->input->post('branch'),
			'relationship_id' => $relationship_id
			);
		$uname = $this->input->post('username');
		$set = $this->users_model->update_user($uid,$data); 
		if($set)
		{
			
			$data = array(
			"status" => 1,
			"success" => "Changes updated successfully."
			);
			$this->response($data, 200);
		}
			
	}

		
	public function update_my_user_post()
	{
		
		$user_type =$this->input->post('user_type');		
		$uid = $this->input->post('user_id');
		if($user_type != "")
		{		
			$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email_phn'),
				"user_type_id" => $user_type,
				'business_id' => $this->input->post('branch'),
				);
		}		
		else
		{		
			$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email_phn'),
				'business_id' => $this->input->post('branch'),
				);
		}
		
		$set = $this->users_model->update_user($uid,$data); 
		if($set)
		{
			$data = array(
			"status" => 1,
			"success" => "User updated successfully"
			);
			$this->response($data, 200);
		}
			
	}
	
	
	public function create_user_password_post()
	{
		$userid=$this->input->post('user_id');
		$new = $this->input->post('new');
		$set = $this->users_model->create_user_password($userid,$new);
		if($set == true)
		{
			$data = array(
			"status" => 1,
			"success" => "Login with user new  password."
			);
			$this->response($data, 200);
		}
	}
	
	public function create_branch_password_post()
	{
		$branch_id = $this->input->post('branch_id');
		$new = $this->input->post('new');
		$set = $this->users_model->create_branch_password($branch_id,$new);
		if($set == true)
		{
			$data = array(
			"status" => 1,
			"success" => "Branch password updated successfully"
			);
			$this->response($data, 200);
		}
	}
	
	public function change_password_post()
	{
		$busi_id = $this->input->post('branch_id');
		$new = md5($this->input->post('new_pwd'));
		$set = $this->users_model->change_password($busi_id,$new);
		if($set == true)
		{
			$data = array(
			"status" => 1,
			"success" => "Password updated successfully"
			);
			$this->response($data, 200);
		}
	}
	
	
	
	public function delete_user_post()
	{
		
		$uid = $this->input->post('user_id'); 		 
		$this->users_model->KM_delete(array(
			"class" => "user_details",
			"conditions" => array(
			"user_id" => $uid
			)
			));
		$data = array(
			"status" => true,
			"success" => "Floor deleted successfully"
			);
			$this->response($data, 200);
	}
	
		// Code Ended By Leela Kumar
		
         public function login_action_post()
		{
			$this->layout = false;				
			$userdata = $this->users_model->KM_first(array(
				"class" => "business_entity",
				"fields" => array(
					'business_id',
					'business_name',
					'business_email',
					'branch',
					'relationship_id',
					'have_branches',
					'login_count','last_login'
				),
				"conditions" => array(				   
					"business_email" => $this->input->post('business_email'),
					"password" => md5($this->input->post('password')),
					"subscription_type" => '0'
				)
			));
			
			
			if(count($userdata) == 0)
			{
			
				$user_data = $this->users_model->KM_first(array(
					"class" => "user_details",
					"fields" => array('user_id','username as business_name','email','user_type_id','business_id','relationship_id','last_login'
					),
					"conditions" => array(				   
						"email" => $this->input->post('business_email'),
						"password" => md5($this->input->post('password'))
					)
				));			
				
				
			}			
		    
			if (count($userdata) != 0) 
			{
							
				$bbid = $userdata['business_id'];
				
				$sql = "update business_entity set last_login = now() where business_id='$bbid'";
				$this->db->query($sql);
				
				$tes = $this->users_model->KM_update(array(
								'class' => "business_entity",
								'update' => array(
									'login_count' => '1'
								)
							), array(
								"business_id" => $bbid
							));
			
			$data['success']=1; 
            $data['result']=$userdata;			

			}
			else if(!empty($user_data))
			{
				
	
				$uuid = $user_data['user_id'];
				$sql = "update user_details set last_login = now() where user_id='$uuid'";
				$this->db->query($sql);
                $data['success']=1;
                $data['result']=$user_data;					
				
			}
			else
			{
				$data['success']=0;
			}
		$this->response($data, 200);
		}
		
		public function feedback_post()
		{
			
				if($_POST['rid']!='')
				{	
				
					$bill_no = $this->input->post('bill_no');
					$sql = "select count(bill_no) as bil_cnt from reservation where bill_no='$bill_no'";
					$query = $this->db->query($sql);
					$res = $query->result_array();
					if($res[0]['bil_cnt'] != 0)
					{
						$data['duplicate']=1;
						$data['success']=0;
					}
					
					$res_id = $_POST['rid'];
					$dining = $this->input->post('dining_type');
					
					$bill_amt=$this->input->post('bill_amt');
					$tab_no = $this->input->post('tab_no');
					$stew = $this->input->post('stew');
					$c_name = $this->input->post('c_name');
					$c_phn = $this->input->post('c_phn');
					$food = array('quality' => $this->input->post('quality') ,
									'presentation' => $this->input->post('presentation') ,
									'taste' => $this->input->post('taste'));
									
					$food_fb = json_encode($food);
					$service = array('promptness' => $this->input->post('promptness') ,
									'courtesy' => $this->input->post('courtesy') ,
									'competence' => $this->input->post('competence'));
					$service_fb = json_encode($service);
				
				
					$spl_rem = $this->input->post('spl_rem');
							
					$succ = $this->users_model->KM_update(array(
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
							'status'=>0
						)
						), array(
							"reservation_id" => $res_id
						));
					if($succ)
					{
						$data['success']=1;
					}
			
				}
			$this->response($data, 200);
		}
	  public function quick_reservation_post()
		{
		
		
				$customer_id=$this->input->post('business_id');
				$name=$this->input->post('name');
				$phone_no=$this->input->post('phone_no');
				
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
				
				$have_brch = $this->input->post('have_branches');
				$rel_id = $this->input->post('relationship_id');		
				$user_id = $this->input->post('user_id');
				if($have_brch == '0')
				{
					$business_id = $this->input->post('business_id');
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
							$rel_id = $this->input->post('business_id');
						}
					}
				}
				
				
				
				$table_for=$this->input->post('table_for');
				$confirmed=1;
				$floor_business = $this->users_model->KM_first(array(
							"class" => "floor_chart",
							"fields" => array(
								'business_id'
							),
							"conditions" => array(
							  "floor_id" => $floor
							)
						));	
				
				$userid = $this->users_model->KM_save(array(
					'class' => "reservation",
					'insert' => array(
						'customer_id' => 1,
						'name' => $name,
						'phone_no' => $phone_no,
						'in_time' => $in_time,
						 'booked_date' => $booked_date,
						 'table_for'=>$table_for,
						 'table_id' => $table_id,
						 'floor'=>$floor,
						'confirmed' => $confirmed,
						'business_id'=>$business_id,
						'relationship_id' => $rel_id,
						'status'=>1
					),
					'return_id' => true
				));
				
			
		$data['reservation_id']=$userid;				
		$data['success']=1;	
		$this->response($data, 200);
		}
	  public function get_reports_data_post()
		{
		   
			$floor_id=$this->input->post('floor_id');
			$business_id=$this->input->post('business_id');
	
			$data['floor_info']= $this->users_model->getfloor_info($floor_id);
			//echo "call GetAvailableTables('".$business_id."',null,'".$floor_id."')";
			 $query = $this->db->query("call GetAvailableTablesByFloorId('".$floor_id."')");
            

			 $data['available']=$query->result_array();
			$this->response($data, 200); 
		
		}
			public function buzz_reservation_post()
		{
			
				$table_for=$this->input->post('table_for');
				$table_id=$this->input->post('table_id');
				$floor=$this->input->post('floor');
				$reservation_id=$this->input->post('reservation_id');
				
				$ctime = date("H:i:s");
				
				$this->users_model->KM_update(array(
						'class' => "reservation",
						'update' => array(
						'floor'=>$floor,                                
						'table_id' => $table_id,
						'in_time' => $ctime,
						'confirmed'=>1,
						'status'=>1
					)
					), array(
						"reservation_id" => $reservation_id
					));
			$data['success']=1;	
		$this->response($data, 200);
		
		}
		function addfloor_post()
    {
        
	
			$floor_no = $this->input->post('floor_no');
			$business_id= $this->input->post('business_id');
			$no_of_tables = $this->input->post('no_of_tables');
			$no_of_floors= $this->input->post('no_of_floors');
			$tables = json_decode($this->input->post('tables'));
			 $no_of_rows = $this->input->post('no_of_rows');
			 $no_of_columns = $this->input->post('no_of_columns');
					
			if($no_of_rows == "" || $no_of_rows == '0')
			 {
				 $no_of_rows = floor($no_of_tables/2);
			 }
			 
			 $no_of_columns = $this->input->post('no_of_columns');
			
			
			if($no_of_columns == "" || $no_of_columns == "")
			{
				 $no_of_columns = 2;
			}
			
			
			 
			 $table_count=$this->users_model->KM_count(array(
				"class" => "floor_chart",
				"conditions" => array(
				  "business_id" => $business_id
				)
			));
			
			if ($this->users_model->KM_count(array(
				"class" => "floor_chart",
				"conditions" => array(
					"floor_no" => $floor_no,
					"business_id" => $business_id
				)
			))) 
			{   
				$data['success']=0;
				$data['message']='duplicate floor';
			} 
			else 
			{
			
				$created_date = date("Y-m-d H:i:s");
				$userid       = $this->users_model->KM_save(array(
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
				 
						$table       = $this->users_model->KM_save(array(
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

					$data = array(
						"status" => true,
						"success" => "Floor added successfully.",
						"data" => array(
							"Id" => $userid,
							"business_id" => $business_id,
							"floor_no" => $floor_no,
							"Created date" => $created_date
						)
					);
				$this->response($data, 200);	
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
	
		function updatefloor_post()
    {
        
		
		
			$floor_no = $this->input->post('floor_no');
			$business_id=$this->input->post('business_id');
			$no_of_tables = $this->input->post('no_of_tables');
			$no_of_floors= $this->input->post('no_of_floors');
			
			$tables = $this->input->post('tables');
			 $no_of_rows = $this->input->post('no_of_rows');
			 $no_of_columns = $this->input->post('no_of_columns');
			//echo '<pre>';print_r($_POST['images']);exit;
			$floor_id = $this->input->post('floor_id');

			//print_r( $tables); exit;
				$created_date = date("Y-m-d H:i:s");
				
				$userid = $this->users_model->KM_update(array(
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
					
					$serial_no_values = array_column($res, 'serial_no');				
					$result = array_diff($serial_no_values,$_POST['serialno']);
					sort($result);
					
					if(count($serial_no_values) > count($_POST['serialno']))
					{
						if(count($result) != 0)
						{
							$combine = implode(',',$result);
							$sql =  "select table_id from table_info where floor_id='$floor_id' and serial_no in(".$combine.")";
							$query = $this->db->query($sql);
							$tab_ids = $query->result_array();
							$tabids = array_column($tab_ids, 'table_id');	
							
							$this->db->where('floor',$floor_id);
							$this->db->where_in('table_id', $tabids);
							$this->db->delete('reservation');
							
							$this->db->where('floor_id',$floor_id);
							$this->db->where_in('serial_no', $result);
							$this->db->delete('table_info');
						}
					}
					
					
					$i=0;	
					foreach($tables as $table)
					{
		
					   if(count($serial_no_values) != 0 && in_array($_POST['serialno'][$i],$serial_no_values))
					   {
							$this->users_model->KM_update(array(
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
						
							$this->users_model->KM_save(array(
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
						"success" => "Floor updated successfully.",
						"data" => array(
							"Id" => $userid,
							"business_id" => $business_id,
							"floor_no" => $floor_no,
							"Created date" => $created_date
						)
					);
					$this->response($data, 200);	
				}
				
				else {
					$this->response(array(
						"status" => false,
						'error' => 'Not Found'
					), 400);
				}
				
    }
		
}
