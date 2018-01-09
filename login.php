<?php
 
    $username = 'admin';
    $password = '1234';
     
    
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, 'http://123.176.39.59/dev_bookmyt_phase1/services/get_floor_data');
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_POST, 1);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array( 
			'X-API-KEY' => 'Q4UuCOB9qngqdZhLL1PDqEVCMcDrifru', 
			'business_id' => '240',
			'floor_id' => '241',
			'user_id' => '' ,
			'hb' => '0'
        // 'name' => 'raghu', 
		// 'user_id'=>'89', 
		//'user_id'=>'90', 
		// 'event_date'=>'2016-04-01', 
		// 'event_start_time'=>'09:00', 
		// 'event_end_time'=>'11:00', 
		// 'event_id'=>'34', 
		//'user_id'=>'71', 
		 // 'event_latitute'=>'13.5425', 
		// 'event_langitute'=>'24.4145', 
		 // 'password'=>'123456', 
		// 'phone'=>'123456', 
		// 'user_latitute'=>'123456', 
		// 'user_langitute'=>'123456', 
    ));
     
    // Optional, delete this line if your API is open
    curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
     //echo "<pre>";
   	echo  $buffer = curl_exec($curl_handle);
/*    curl_close($curl_handle);
     
    $result = json_decode($buffer);
	
	print_r($result);
	*/
 
 
?>
