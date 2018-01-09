<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Business extends REST_Controller
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
                'branch' => $branch,
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
                'branch' => $branch,
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
                    "success" => "Business registered successfully",
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
		// $time_zone     = $this->post('time_zone');
		 $password = $this->post('rand_pwd');
		 $ip_address = $this->post('ip_address');
        $business_types     = $this->post('business_types');
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
			$location = file_get_contents('http://freegeoip.net/json/'.$ip_address);
			$time_zone=$location->time_zone;
			$country=$location->country_name;
			//$state = $location->country;
			
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
				$input_array  = array(
					'branch' => $branch,
					'business_name' => $business_name,
					'business_email' => $business_email,
					'password' => $password,
					"time_zone" => $time_zone,
					'country'=>$country,
					'business_typeid' => $business_types
				);
			  
				$created_date = date("Y-m-d H:i:s");
				$userid       = $this->users_model->KM_save(array(
					'class' => "business_entity",
					'insert' => $input_array,
					'return_id' => true
				));
				
				if ($userid) 
				{
					$data = array(
						"status" => true,
						"success" => "Business registered successfully",
						
						"data" => array(
							"Id" => $userid,
							"business_name" => $business_name,
							"business_email" => $business_email,
							"time_zone" => time_zone,
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
				"success" => "Branch deleted successfully"
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
       
	   $this->load->model('users_model');
       
	   if ($this->users_model->KM_count(array(
            "class" => "business_entity",
            "conditions" => array(
                "business_email" => $business_email
            )
        ))) {
			$data = array(
                    "status" => false,
                    "success" => "Email already exists"
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
				//'have_branches' => $have_branches
               
              
            );
			
            $created_date = date("Y-m-d H:i:s");
            $userid       = $this->users_model->KM_update(array(
                    'class' => "business_entity",
                    'update' => $system_array
                ), array(
                    "business_id" => $business_id
                ));
            
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
                    "success" => "Floor added successfully",
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
                    "success" => "Floor updated successfully"
                 
                );
                $this->response($data, 200);
            }
            
          
    }
	public function floorslist_post()
	{
		$business_id=$this->input->post('business_id');
		$have_branches = $this->input->post('have_brchs');
		$user_id = $this->input->post('user_id');
		if($user_id!='')
		{
			$business_id = $this->input->post('branch_id');
		}		
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
                    "success" => "Table updated successfully"
                 
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
			"success" => "Table deleted successfully"
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
                    "success" => "Customer registered successfully",
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
                "error" => "Customer data is not updated"
            ), 400);
            exit;
        } else {

                $this->response(array(
                "status" => true,
                "error" => "Customer data is updated sucessfully"
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
                "error" => "Reservation table data is not updated"
            ), 400);
            exit;
        } else {

                $this->response(array(
                "status" => true,
                "error" => "Reservation table data is updated sucessfully"
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
                "error" => "table info not updated"
            ), 400);
            exit;
        } else {

                $this->response(array(
                "status" => true,
                "error" => "table info updated sucessfully"
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
		$user_id = $this->input->post('user_id');
		$rel_id= $this->input->post('rel_id');
		if($user_id!='')
		{
			if($have_branches == '')
			{
				$business_id = $this->input->post('business_id');
			}
			else
			{
				$business_id = $this->input->post('branch_id');
			}
		}
		$data['reservation_list']= $this->users_model->reservation_list($business_id,$have_branches,$rel_id);
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
			"success" => "Reservation deleted successfully"
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
		if($user_id!='')
		{
			$business_id = $this->input->post('branch_id');
		}		
		$data['res_list']= $this->users_model->res_list($business_id);
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
			"success" => "Business password updated successfully"
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
			$userid       = $this->users_model->KM_save(array(
				'class' => "user_details",
				'insert' => array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('rand_pwd'),
					'email' => $this->input->post('email_phn'),
					"user_type_id" => $user_type,
					'business_id' => $this->input->post('relationship_id'),
					'branch_id' => $this->input->post('branch'),
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
		$uid = $this->input->post('user_id'); 
		
		$set = $this->users_model->update_user($uid,$user_type); 
		if($set)
		{
			$data = array(
			"status" => 1,
			"success" => "User updated successfully"
			);
			$this->response($data, 200);
		}
			
	}

		
	public function update_my_user_post()
	{
		
		$user_type =$this->input->post('user_type');		
		$uid = $this->input->post('user_id'); 
		
		$set = $this->users_model->update_user($uid,$user_type); 
		if($set)
		{
			$data = array(
			"status" => 1,
			"success" => "Your profile updated successfully"
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
			"success" => "User password updated successfully"
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
}
