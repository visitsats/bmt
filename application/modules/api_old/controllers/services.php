<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Services  extends REST_Controller {
	
	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct(); 
		$this->layout=false; 
	}	 

	/**
	 * scanqr_get Method
	 *
	 * scanqr_get saves scanned qr_id for a user/device. Used for get request. 
	 *
	 * @param int qrid
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function scanqr_get()
    {  
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY','qr_type','qr_data','qr_scan_data');
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			"qrid"=>$this->get('qrid'),
			"uid"=>(int)$this->get('userid'),
			"hwid"=>$this->get('hardware_id'),
			"qr_type"=>(int)$this->get('qr_type'),
			"qr_data"=>(int)$this->get('qr_data'),
			"qr_scan_data"=>$this->post('qr_scan_data')
		);
	 	
		$this->__output_scan($param); 
    }
	
	/**
	 * scanqr_post Method
	 *
	 * scanqr_post saves scanned qr_id for a user/device. Used for post request. 
	 *
	 * @post param int qrid
	 * @post param int userid
	 * @post param string hardware_id
	 * @post param string X-API-KEY
	 * @post param string format (xml/json)
	 * @output json/xml
	 */
	function scanqr_post()
    {  
	   
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY','qr_type','qr_data','qr_scan_data');
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 
		$param=array(
			"qrid"=>$this->post('qrid'),
			"uid"=>(int)$this->post('userid'),
			"hwid"=>$this->post('hardware_id'),
			"qr_type"=>$this->post('qr_type'),
			"qr_data"=>$this->post('qr_data'),
			"qr_scan_data"=>$this->post('qr_scan_data')
		); 
		
		$this->__output_scan($param);	 
    }
	/**
	 * __output_scan Method
	 *
	 * __output_scan saves scanned qr_id for a user/device and displays qr data data for the passed qr_id. commomn function used by scanqr_post and scanqr_get. 
	 *
	 * @post param int qrid
	 * @post param int userid
	 * @post param string hardware_id
	 * @post param string X-API-KEY
	 * @post param string format (xml/json)
	 * @output json/xml
	 */
	
	function __output_scan($param){
	
		extract($param);
	
		if(!$qrid){
		
        	 //$this->response(array('error' => 'Invalid Data'), 400);exit;
			//$created_date = date("Y-m-d H:i:s"); 
			//$this->load->model('services_model');				
			//$retunuuid=$this->services_model->retunuuid();
		
			// $qrid=$retunuuid[0]['uid'];		
			// $logid=$this->__save_to_log($hwid,$uid,$qrid,'scan',$created_date);
			
			  //$this->services_model->KM_save(array('class'=>'qrc','insert'=>array("qrcid"=>$qrid,"qrc"=>$qr_scan_data,"isnew"=>1)));
        }else{
	 	$this->load->model('services_model');
		//$qrid=$qrid;
		/*if($qr_type!="smtbuggy"){
			$qrid=0;
			//changed by raghu other for other qr codes
		}
		else*/
		
		if($uid){ 
		
				/*$data=$this->services_model->KM_first(
					array("class"=>"qrc",
						  'select'=>'qrc.qrcid "QR ID",qrc.qrc "QR Data",qrc.feed,qrc.price "Price",product.pname as "Product Name",retname "Retailer", locname "Location",  if( `favs`.`isfavstill`="",0,1 ) as Favourite',
						  "conditions"=>array("qrcid"=>$qrid),
						  'protect_identifiers'=>false,
						  'joins'=>array(
										array("class"=>"favs","type"=>"left","foreignKey"=>"qrcid","primaryKey"=>"qrcid",
												"join_and_cond"=>array("userid"=>$uid)), 
										array("class"=>"product","type"=>"left","foreignKey"=>"pid","primaryKey"=>"pid"),
										array("class"=>"retailer","type"=>"left","foreignKey"=>"retid","primaryKey"=>"retid"),
										array("class"=>"location","type"=>"left","foreignKey"=>"locid","primaryKey"=>"locid"),
								)
						  )
				   ); */ 
				   $data=$this->services_model->get_QR_Details($qrid,0,$uid);
			}
			elseif($hwid){
				/*$data=$this->services_model->KM_first(
					array("class"=>"qrc",
						'select'=>'qrc.qrcid "QR ID",qrc.qrc "QR Data",qrc.price "Price",product.pname as "Product Name",retname "Retailer", locname "Location",  if( `favs`.`isfavstill`="",0,1 ) as Favourite',
						  "conditions"=>array("qrcid"=>$qrid),
						  'protect_identifiers'=>false,
						  'joins'=>array(
										array("class"=>"favs","type"=>"left","foreignKey"=>"qrcid","primaryKey"=>"qrcid",
												"join_and_cond"=>array("hwid"=>$hwid)), 
										array("class"=>"product","type"=>"left","foreignKey"=>"pid","primaryKey"=>"pid"),
										array("class"=>"retailer","type"=>"left","foreignKey"=>"retid","primaryKey"=>"retid"),
										array("class"=>"location","type"=>"left","foreignKey"=>"locid","primaryKey"=>"locid"),
								)
						  )
				   );*/
				   $data=$this->services_model->get_QR_Details($qrid,$hwid);
			}
			else{
				$this->response(array("error"=>"Invalid Parameter"), 400);exit;
			}
			/*$i=0;
			foreach($data as $data1)
			{
			$data[$i]['Product Image']='<img src="data:image/png;base64,' . base64_encode($data1['Product Image']) . '" width="290" height="290">';
			
			$i++;
			}
			*/
		
			if(empty($data)){
					$this->response(array("error"=>"Data Not Found"), 400);exit;
			}else{ 
				$created_date = date("Y-m-d H:i:s"); 
				
				$logid=$this->__save_to_log($hwid,$uid,$qrid,'scan',$created_date);
				if($qr_type!="smtbuggy" && $qr_data!=""){
					$this->services_model->KM_save(array('class'=>'qr_data','insert'=>array("log_id"=>$logid,"qr_data"=>$qr_data)));
				}else
				 {
				 
				   $this->services_model->KM_save(array('class'=>'qr_data','insert'=>array("log_id"=>$logid,"qr_data"=>$qr_data)));
				 
				 }
				$this->response($data, 200); 
			} 
		}
	}
	
	
	/* other qr code scan start*/
	
		function scanotherqr_post()
    {  
	   
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY','qr_type','qr_data','qr_scan_data','otherid');
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 
		$param=array(
			
			"uid"=>(int)$this->post('userid'),
			"hwid"=>$this->post('hardware_id'),
			"qr_type"=>$this->post('qr_type'),
			"qr_data"=>$this->post('qr_data'),
			"qr_scan_data"=>$this->post('qr_scan_data'),
			"otherid"=>$this->post('otherid')
		); 
		
		$this->__output_otherqr_scan($param);	 
    }
	
	
	function __output_otherqr_scan($param){
	
		extract($param);
	
		if($qr_scan_data){
		
        	//$this->response(array('error' => 'Invalid Data'), 400);exit;
			$created_date = date("Y-m-d H:i:s"); 
			$this->load->model('services_model');				
			$retunuuid=$this->services_model->retunuuid();
		
			 $qrid=$retunuuid[0]['uid'];		
			;
			$data=$this->services_model->KM_first(
					array("class"=>"qrc",
						  'select'=>'qrc.qrcid,qrc.qrc', "conditions"=>array("qrc"=>$qr_scan_data)));
				//		  print_r($data);exit;
			if(!empty($data))
			{
			 $qrid=$data['qrcid'];	
			if($this->services_model->KM_count(array("class"=>"act_log","conditions"=>array("qrcid"=>$qrid,"userid"=>$uid)))>0)
			{
			  
			
			  $this->response(array('error' => 'already exists'), 400);exit;
			  
			}
			else{
			 
			  $logid=$this->__save_to_log($hwid,$uid,$qrid,'scan',$created_date);
			   $this->response(array('sucess' => 'saved','otherid'=>$otherid), 400);exit;
			 
			 }
			 }else
			 {
			  $this->services_model->KM_save(array('class'=>'qrc','insert'=>array("qrcid"=>$qrid,"qrc"=>$qr_scan_data,"isnew"=>1)));
			  $logid=$this->__save_to_log($hwid,$uid,$qrid,'scan',$created_date);
			   $this->response(array('sucess' => 'saved','otherid'=>$otherid), 400);exit;
			 
			 
			 }
			}
       
	}
	/*other qr code scan end */
	
	
		/* non-smartbuggy list start*/
	
		function nonsmartbuggy_list_post()
    {  
	  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY');
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 
		$param=array(			
			"uid"=>(int)$this->post('userid'),
			"hwid"=>$this->post('hardware_id')
		); 
		
		$this->__output_nonsmartbuggylist_scan($param);	 
    }
	
	
	function __output_nonsmartbuggylist_scan($param){
	
		extract($param);
	
		if($uid){
		$this->load->model('services_model');
			$data=$this->services_model->nonsmartbuggy_list($uid);
			if(!empty($data)){			
				//$this->__save_to_log($hwid,$uid,0,'sub categories list',$created_date);
				$this->response($data, 200); 
			}else{
				$this->response(array("error"=>"No data found"), 200);exit;									 
			}  
		}
       
	}
	
		function removenonsmartbuggy_post()
    {  
	    $allowed_params=array('qrcid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 			
		$qrid=$this->post('qrcid');
		$uid=(int)$this->post('userid');
		$hwid=$this->post('hardware_id');
		$created_date=date("Y-m-d H:i:s");
	 
		if(!$qrid){
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		$this->load->model('services_model');
		if($uid){ 
			if($this->services_model->KM_count(array("class"=>"act_log","conditions"=>array("userid"=>$uid,"qrcid"=>$qrid)))>0)
			{
				
				$this->services_model->KM_delete(array("class"=>"act_log",													
														"conditions"=>array("userid"=>$uid,"qrcid"=>$qrid)));
														
			
				//$this->__save_to_log(0,$uid,$qrid,'removed from buggy',$created_date);	
				$this->response(array("success"=>"removed buggy"), 200);exit;
			}else{
				$this->response(array("error"=>"no buggy to remove"), 200);exit;
			}								 
		}else{
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}		 
    }
	
	/*non-smartbuggy list end */
	
	
	
	/**
	 * removebuggy_get Method
	 *
	 * removebuggy_get deletes scanned qr_id exists for a user/device. Used for get request. 
	 *
	 * @param int qrid
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function removebuggy_get()
    {  
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 			
		$qrid=$this->get('qrid');
		$uid=(int)$this->get('userid');
		$hwid=$this->get('hardware_id');
		$created_date=date("Y-m-d H:i:s");
		if(!$qrid){
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		$this->load->model('services_model');
		if($uid){ 
			if($this->services_model->KM_count(array("class"=>"act_log","conditions"=>array("userid"=>$uid,"qrcid"=>$qrid,"action !="=>"removed from buggy" )))>0)
			{
				$this->services_model->KM_delete(array("class"=>"act_log",													
														"conditions"=>array("userid"=>$uid,"qrcid"=>$qrid)));
														
				$this->services_model->KM_delete(array("class"=>"favs",													
														"conditions"=>array("userid"=>$uid,"qrcid"=>$qrid)));										
				$this->__save_to_log(0,$uid,$qrid,'removed from buggy',$created_date);	
				$this->response(array("success"=>"removed buggy"), 200);exit;
			}else{
				$this->response(array("error"=>"no buggy to remove"), 200);exit;
			}								 
		}elseif($hwid){
			if($this->services_model->KM_count(array("class"=>"act_log","conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid,"action !="=>"removed from buggy" )))>0)
			{
			$this->services_model->KM_delete(array("class"=>"act_log",													
												 	"conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid)));
			$this->services_model->KM_delete(array("class"=>"favs",													
												 	"conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid)));
			
			$this->__save_to_log($hwid,0,$qrid,'removed from buggy',$created_date);
			$this->response(array("success"=>"removed buggy"), 200);exit;
			}else{
				$this->response(array("error"=>"no buggy to remove"), 200);exit;
			}
		}else{
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}		 
    }
	
	/**
	 * removebuggy_post Method
	 *
	 * removebuggy_post deletes scanned qr_id exists for a user/device. Used for post request. 
	 *
	 * @param int qrid
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function removebuggy_post()
    {  
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 			
		$qrid=$this->post('qrid');
		$uid=(int)$this->post('userid');
		$hwid=$this->post('hardware_id');
		$created_date=date("Y-m-d H:i:s");
	 
		if(!$qrid){
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		$this->load->model('services_model');
		if($uid){ 
			if($this->services_model->KM_count(array("class"=>"act_log","conditions"=>array("userid"=>$uid,"qrcid"=>$qrid,"action !="=>"removed from buggy" )))>0)
			{
				$this->services_model->KM_delete(array("class"=>"act_log",													
														"conditions"=>array("userid"=>$uid,"qrcid"=>$qrid)));
														
				$this->services_model->KM_delete(array("class"=>"favs",													
														"conditions"=>array("userid"=>$uid,"qrcid"=>$qrid)));										
				$this->__save_to_log(0,$uid,$qrid,'removed from buggy',$created_date);	
				$this->response(array("success"=>"removed buggy"), 200);exit;
			}else{
				$this->response(array("error"=>"no buggy to remove"), 200);exit;
			}								 
		}elseif($hwid){
			if($this->services_model->KM_count(array("class"=>"act_log","conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid,"action !="=>"removed from buggy" )))>0)
			{
			$this->services_model->KM_delete(array("class"=>"act_log",													
												 	"conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid)));
			$this->services_model->KM_delete(array("class"=>"favs",													
												 	"conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid)));
			
			$this->__save_to_log($hwid,0,$qrid,'removed from buggy',$created_date);
			$this->response(array("success"=>"removed buggy"), 200);exit;
			}else{
				$this->response(array("error"=>"no buggy to remove"), 200);exit;
			}
		}else{
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}		 
    }
	
	
	/**
	 * qrs_get Method
	 *
	 * qrs_get get all  scanned qr_id exists for a user/device. Used for get request. 
	 *	  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function qrs_get()
    {  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		$param=array( 			
			'uid'=>(int)$this->get('userid'),
			'hwid'=>$this->get('hardware_id')
		);
		$this->__output_qrs($param);
		 
    }
	/**
	 * qrs_post Method
	 *
	 * qrs_post get all  scanned qr_id exists for a user/device. Used for post request. 
	 *	  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function qrs_post()
    {  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		$param=array( 			
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id')
		);
		$this->__output_qrs($param);
		 
    }
	/**
	 * __output_qrs Method
	 *
	 * Used by qrs_post and qrs_get functions to output all scanned qr_id exists for a user/device 
	 *	  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */	
	function __output_qrs($param){
		extract($param);
		$this->load->model('services_model');
		if($uid){ 
				$data=$this->services_model->KM_all(
					array("class"=>"qrc",
						  'select'=>'qrc.qrcid "QR ID",qrc.qrc "QR Data",qrc.price "Price",product.pname as "Product Name",product.image as "Product Image", qrc.StreetName as "StreetName", 
						   concat("'.base_url(QR_IMAGE_PATH).'/",qrc.qrcimgpath ) as Image , retname "Retailer", locname "Location",act_log.actdt "Scan Date", if( `favs`.`isfavstill` is null, 0, if( `favs`.`isfavstill` = "", 0, if( `favs`.`isfavstill` = 0, 0, 1 ) ) ) as Favourite,product.url as "product_url"',
						   'order_prefix'=>false,
						   'protect_identifiers'=>false,
						  'joins'=>array(
										array("class"=>"act_log","type"=>"inner","foreignKey"=>"qrcid","primaryKey"=>"qrcid",
												"join_and_cond"=>array("action"=>"scan"),"conditions"=>array("userid"=>$uid)),
										array("class"=>"favs","type"=>"left","foreignKey"=>"qrcid","primaryKey"=>"qrcid", "join_and_cond"=>array("userid"=>$uid,'isfavstill'=>1)), 
										array("class"=>"product","type"=>"inner","foreignKey"=>"pid","primaryKey"=>"pid"),
										array("class"=>"retailer","type"=>"inner","foreignKey"=>"retid","primaryKey"=>"retid"),
										array("class"=>"location","type"=>"inner","foreignKey"=>"locid","primaryKey"=>"locid"),
								),
							'order'=>'act_log.actdt desc',
							'groupby'=>'qrc.qrcid'	
						  )
				   );  
		}elseif($hwid){
				$data=$this->services_model->KM_all(
					array("class"=>"qrc",
						  'select'=>'qrc.qrcid "QR ID",qrc.qrc "QR Data",qrc.price "Price",product.pname as "Product Name",product.image as "Product Image",qrc.StreetName as "StreetName", 
						   concat("'.base_url(QR_IMAGE_PATH).'/",qrc.qrcimgpath ) as Image , retname "Retailer", locname "Location",act_log.actdt "Scan Date",  if( `favs`.`isfavstill` is null,0,1 ) as Favourite,product.url as "product_url"',
						   'order_prefix'=>false,
						   'protect_identifiers'=>false,
						  'joins'=>array(
										array("class"=>"act_log","type"=>"inner","foreignKey"=>"qrcid","primaryKey"=>"qrcid",
												"join_and_cond"=>array("action"=>"scan"),"conditions"=>array("hwid"=>$hwid)),
										array("class"=>"favs","type"=>"left","foreignKey"=>"qrcid","primaryKey"=>"qrcid", "join_and_cond"=>array("userid"=>$uid)), 
										array("class"=>"product","type"=>"left","foreignKey"=>"pid","primaryKey"=>"pid"),
										array("class"=>"retailer","type"=>"left","foreignKey"=>"retid","primaryKey"=>"retid"),
										array("class"=>"location","type"=>"left","foreignKey"=>"locid","primaryKey"=>"locid"),
								),
							'order'=>'act_log.actdt desc',
							'groupby'=>'qrc.qrcid'	
						  )
				   );
				   
			}
		else{
				$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
			
		if(empty($data)){
					$this->response(array("error"=>"Data Not Found"), 400);exit;
		}else{ 
				$created_date = date("Y-m-d H:i:s"); 
				
				$this->__save_to_log($hwid,$uid,0,'blog',$created_date);
				$this->response($data, 200); 
			}
	}
	
	/**
	 * readqr_get Method
	 *
	 * readqr_get finds qr data for a qr_id. Used for get request. 
	 *	  
	 * @param int qrid
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function readqr_get()
    {  
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		$param=array(
			"qrid"=>$this->get('qrid'),
			"uid"=>(int)$this->get('userid'),
			"hwid"=>$this->get('hardware_id')
		); 
		$this->__output_qr($param); 
    }
	/**
	 * readqr_post Method
	 *
	 * readqr_post finds qr data for a qr_id. Used for post request. 
	 *
	 * @param int qrid	  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function readqr_post()
    {  
	     $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		$param=array(
			"qrid"=>$this->post('qrid'),
			"uid"=>(int)$this->post('userid'),
			"hwid"=>$this->post('hardware_id')
		);
		
		$this->__output_qr($param,hardware_id);
		 
    }
	/**
	 * readqr_post Method
	 *
	 * readqr_post ouput qr data for a qr_id. Used by readqr_get and readqr_post functions. 
	 *
	 * @param int qrid	  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function __output_qr($param){	
		extract($param);	 
		$this->load->model('services_model');
		if($qrid){ 
				$data=$this->services_model->KM_first(
					array("class"=>"qrc",
						  'select'=>'qrc.qrcid "QR ID",qrc.qrc "QR Data",qrc.price "Price",product.pname as "Product Name",product.image as "Product Image",qrc.StreetName as "StreetName", 
						   concat("'.base_url(QR_IMAGE_PATH).'/",qrc.qrcimgpath ) as Image , retname "Retailer", locname "Location", if( `favs`.`isfavstill`="",0,1 ) as Favourite,product.url as "product_url"',
						   'order_prefix'=>false,
						   'protect_identifiers'=>false,
						   'conditions'=>array("qrcid"=>$qrid),
						   'joins'=>array(										
										array("class"=>"favs","type"=>"left","foreignKey"=>"qrcid","primaryKey"=>"qrcid"), 
										array("class"=>"product","type"=>"left","foreignKey"=>"pid","primaryKey"=>"pid"),
										array("class"=>"retailer","type"=>"left","foreignKey"=>"retid","primaryKey"=>"retid"),
										array("class"=>"location","type"=>"left","foreignKey"=>"locid","primaryKey"=>"locid"),
								), 
						  )
				   );  
		} 
		else{
				$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
			
		if(empty($data)){
					$this->response(array("error"=>"Data Not Found"), 400);exit;
		}else{ 
				$created_date = date("Y-m-d H:i:s"); 
				
				$this->__save_to_log($hwid,$uid,$qrid,'read qr',$created_date);
				$this->response($data, 200); 
			}
	}
	
	/**
	 * addtofavourite_get Method
	 *
	 * addtofavourite_get add a qr_id to userid/hardware_id. Used for get request. 
	 *	
	 * @param int qrid  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function addtofavourite_get()
    {  
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 			
		$qrid=$this->get('qrid');
		$uid=(int)$this->get('userid');
		$hwid=$this->get('hardware_id');
		$created_date=date("Y-m-d H:i:s");
		if(!$qrid){
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		$this->load->model('services_model');
		if($uid){
			if($this->services_model->KM_count(array("class"=>"favs","conditions"=>array("userid"=>$uid,"qrcid"=>$qrid,"isfavstill"=>1)))==0)
			{
				$this->services_model->KM_save(array("class"=>"favs",
													 "insert"=>array("userid"=>$uid,"qrcid"=>$qrid,"favdt"=>$created_date,"isfavstill"=>1)));
				$this->__save_to_log(0,$uid,$qrid,'add to favourite',$created_date);	
				$this->response(array("Favourite"=>0,"success"=>"added to favourite"), 200);exit;
			}else{
				$this->response(array("Favourite"=>1,"success"=>"already in favourite"), 400);exit;				
			}								 
		}elseif($hwid){
			if($this->services_model->KM_count(array("class"=>"favs","conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid,"isfavstill"=>1)))==0)
			{
				$this->services_model->KM_save(array("class"=>"favs",
													 "insert"=>array("hwid"=>$hwid,"qrcid"=>$qrid,"favdt"=>$created_date,"isfavstill"=>1))); 
				$this->__save_to_log($hwid,0,$qrid,'add to favourite',$created_date);
				$this->response(array("Favourite"=>0,"success"=>"added to favourite"), 200);exit;
			}else{
				$this->response(array("Favourite"=>1,"success"=>"already in favourite"), 400);exit;				
			}
		}else{
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		 
    } 
	
	/**
	 * addtofavourite_post Method
	 *
	 * addtofavourite_post add a qr_id to userid/hardware_id. Used for post request. 
	 *	
	 * @param int qrid  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function addtofavourite_post()
    {  
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 			
		 $qrid=$this->post('qrid');
		$uid=(int)$this->post('userid');
		$hwid=$this->post('hardware_id');
		$created_date=date("Y-m-d H:i:s");
		if(!$qrid){
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		$this->load->model('services_model'); 
		
	   
		if($uid){
			if($this->services_model->KM_count(array("class"=>"favs","conditions"=>array("userid"=>$uid,"qrcid"=>$qrid,"isfavstill"=>1)))==0)
			{
				$this->services_model->KM_save(array("class"=>"favs",
													 "insert"=>array("userid"=>$uid,"qrcid"=>$qrid,"favdt"=>$created_date,"isfavstill"=>1)));
				$this->__save_to_log(0,$uid,$qrid,'add to favourite',$created_date);	
				$this->response(array("Favourite"=>1,"success"=>"added to favourite"), 200);exit;
			}else{
				$this->response(array("Favourite"=>0,"success"=>"already in favourite"), 400);exit;				
			}								 
		}elseif($hwid){
			if($this->services_model->KM_count(array("class"=>"favs","conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid,"isfavstill"=>1)))==0)
			{
				$this->services_model->KM_save(array("class"=>"favs",
													 "insert"=>array("hwid"=>$hwid,"qrcid"=>$qrid,"favdt"=>$created_date,"isfavstill"=>1))); 
				$this->__save_to_log($hwid,0,$qrid,'add to favourite',$created_date);
				$this->response(array("Favourite"=>1,"success"=>"added to favourite"), 200);exit;
			}else{
				$this->response(array("Favourite"=>0,"success"=>"already in favourite"), 400);exit;				
			}
		}else{
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		 
    }
	
	/**
	 * removefromfavourite_get Method
	 *
	 * removefromfavourite_get remove a qr_id from userid/hardware_id favourites. Used for get method. 
	 *	
	 * @param int qrid  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function removefromfavourite_get()
    {  
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 			
		$qrid=$this->get('qrid');
		$uid=(int)$this->get('userid');
		$hwid=$this->get('hardware_id');
		$created_date=date("Y-m-d H:i:s");
		
		if(!$qrid){
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		$this->load->model('services_model');
		if($uid){ 
			if($this->services_model->KM_count(array("class"=>"favs","conditions"=>array("userid"=>$uid,"qrcid"=>$qrid,"isfavstill"=>1)))>0){
			$this->services_model->KM_update(array("class"=>"favs",
													"update"=>array("isfavstill"=>0,"unfavdt"=>$created_date)),array("userid"=>$uid,"qrcid"=>$qrid,"isfavstill"=>1)); 
			$this->__save_to_log(0,$uid,$qrid,'remove from favourite',$created_date);
			$this->response(array("success"=>"removed from favourite"), 200);exit;
			}else{
				$this->response(array("error"=>"no qr code to remove from favourite"), 400);exit;
			}									 
		}elseif($hwid){
			if($this->services_model->KM_count(array("class"=>"favs","conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid,"isfavstill"=>1)))>0){
			$this->services_model->KM_update(array("class"=>"favs",
													"update"=>array("isfavstill"=>0,"unfavdt"=>$created_date)),array("hwid"=>$hwid,"qrcid"=>$qrid,"isfavstill"=>1)); 
			$this->__save_to_log($hwid,0,$qrid,'remove from favourite',$created_date);
			$this->response(array("success"=>"removed from favourite"), 200);exit;
			}else{
				$this->response(array("error"=>"no qr code to remove from favourite"), 400);exit;
			}
		}else{
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		 
    }
	
	/**
	 * removefromfavourite_post Method
	 *
	 * removefromfavourite_post remove a qr_id from userid/hardware_id favourites. Used for post method. 
	 *	
	 * @param int qrid  
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	  
	function removefromfavourite_post()
    {  
	    $allowed_params=array('qrid','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			$this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		 			
		$qrid=$this->post('qrid');
		$uid=(int)$this->post('userid');
		$hwid=$this->post('hardware_id');
		$created_date=date("Y-m-d H:i:s");
		
		if(!$qrid){
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		$this->load->model('services_model');
		if($uid){ 
			if($this->services_model->KM_count(array("class"=>"favs","conditions"=>array("userid"=>$uid,"qrcid"=>$qrid,"isfavstill"=>1)))>0){
			$this->services_model->KM_update(array("class"=>"favs",
													"update"=>array("isfavstill"=>0,"unfavdt"=>$created_date)),array("userid"=>$uid,"qrcid"=>$qrid,"isfavstill"=>1)); 
			$this->__save_to_log(0,$uid,$qrid,'remove from favourite',$created_date);
			$this->response(array("success"=>"removed from favourite"), 200);exit;
			}else{
				$this->response(array("error"=>"no qr code to remove from favourite"), 400);exit;
			}									 
		}elseif($hwid){
			if($this->services_model->KM_count(array("class"=>"favs","conditions"=>array("hwid"=>$hwid,"qrcid"=>$qrid,"isfavstill"=>1)))>0){
			$this->services_model->KM_update(array("class"=>"favs",
													"update"=>array("isfavstill"=>0,"unfavdt"=>$created_date)),array("hwid"=>$hwid,"qrcid"=>$qrid,"isfavstill"=>1)); 
			$this->__save_to_log($hwid,0,$qrid,'remove from favourite',$created_date);
			$this->response(array("success"=>"removed from favourite"), 200);exit;
			}else{
				$this->response(array("error"=>"no qr code to remove from favourite"), 400);exit;
			}
		}else{
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}		 
    }
	
	/**
	 * favourites_get Method
	 *
	 * favourites_get output all favourites for a userid/hardware_id. Used for get method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	 
	function favourites_get()
    {  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		$param=array( 			
			'uid'=>(int)$this->get('userid'),
			'hwid'=>$this->get('hardware_id')
		);
		$this->__output_favourites($param);
		 
    }
	/**
	 * favourites_post Method
	 *
	 * favourites_post output all favourites for a userid/hardware_id. Used for post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function favourites_post()
    {  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		$param=array( 			
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id')
		);
		$this->__output_favourites($param);
		 
    }
	/**
	 * favourites_post Method
	 *
	 * favourites_post output all favourites for a userid/hardware_id. Used by favourites_get and favourites_post function. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function __output_favourites($param){
		extract($param); 
		$this->load->model('services_model');
		if($uid){ 
				$data=$this->services_model->KM_all(
					array("class"=>"qrc",
						  'select'=>'qrc.qrcid "QR ID",qrc.qrc "QR Data",qrc.price "Price",product.pname as "Product Name",product.image as "Product Image",qrc.StreetName as "StreetName", 
						   concat("'.base_url(QR_IMAGE_PATH).'/",qrc.qrcimgpath ) as Image , retname "Retailer", locname "Location",act_log.actdt "Scan Date", if( `favs`.`isfavstill`="",0,1 ) as Favourite,product.url as "product_url"',
						   'order_prefix'=>false,
						   'protect_identifiers'=>false, 
						   
						  'joins'=>array(
										array("class"=>"act_log","type"=>"inner","foreignKey"=>"qrcid","primaryKey"=>"qrcid",
												"join_and_cond"=>array("action"=>"scan")),
										array("class"=>"favs","type"=>"left","foreignKey"=>"qrcid","primaryKey"=>"qrcid",
												"join_and_cond"=>array("isfavstill"=>"1"),'conditions'=>array("userid"=>$uid,"isfavstill"=>"1")), 
										array("class"=>"product","type"=>"left","foreignKey"=>"pid","primaryKey"=>"pid"),
										array("class"=>"retailer","type"=>"left","foreignKey"=>"retid","primaryKey"=>"retid"),
										array("class"=>"location","type"=>"left","foreignKey"=>"locid","primaryKey"=>"locid"),
								),
							'order'=>'act_log.actdt desc',
							'groupby'=>'qrc.qrcid'	
						  )
				   ); 
				   
				    
		}elseif($hwid){
				$data=$this->services_model->KM_all(
					array("class"=>"qrc",
						  'select'=>'qrc.qrcid "QR ID",qrc.qrc "QR Data",qrc.price "Price",product.pname as "Product Name",product.image as "Product Image", 
						   concat("'.base_url(QR_IMAGE_PATH).'/",qrc.qrcimgpath ) as Image , retname "Retailer", locname "Location",act_log.actdt "Scan Date",  if( `favs`.`isfavstill`="",0,1 ) as Favourite,product.url as "product_url"',
						   'order_prefix'=>false,
						   'protect_identifiers'=>false,
						  'joins'=>array(
										array("class"=>"act_log","type"=>"inner","foreignKey"=>"qrcid","primaryKey"=>"qrcid",
												"join_and_cond"=>array("action"=>"scan")),
										array("class"=>"favs","type"=>"left","foreignKey"=>"qrcid","primaryKey"=>"qrcid", 
										"join_and_cond"=>array("isfavstill"=>"1"),'conditions'=>array("hwid"=>$hwid)), 
										array("class"=>"product","type"=>"left","foreignKey"=>"pid","primaryKey"=>"pid"),
										array("class"=>"retailer","type"=>"left","foreignKey"=>"retid","primaryKey"=>"retid"),
										array("class"=>"location","type"=>"left","foreignKey"=>"locid","primaryKey"=>"locid"),
								),
							'order'=>'act_log.actdt desc',
							'groupby'=>'qrc.qrcid'	
						  )
				   );
				   
			}
		else{
				$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
			
		if(empty($data)){
					$this->response(array("error"=>"Data Not Found"), 400);exit;
		}else{ 
				$created_date = date("Y-m-d H:i:s"); 
				$this->__save_to_log($hwid,$uid,0,'blog',$created_date);
				$this->response($data, 200); 
			}
	}  
	
	/**
	 * comparebuggies_get Method
	 *
	 * comparebuggies_get output details about passed qr_ids. Used for get method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	 
	function comparebuggies_get()
    {  
	    $allowed_params=array('qrids','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array( 			
			'qrids'=>$this->get('qrids'),
			'uid'=>(int)$this->get('userid'),
			'hwid'=>$this->get('hardware_id'),
			'created_date'=>date("Y-m-d H:i:s")
		);
		$this->__output_comparebuggies($param);
    }
	/**
	 * comparebuggies_post Method
	 *
	 * comparebuggies_post output details about passed qr_ids. Used for post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function comparebuggies_post()
    {  
	    $allowed_params=array('qrids','userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array( 			
			'qrids'=>$this->post('qrids'),
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id'),
			'created_date'=>date("Y-m-d H:i:s")
		);
		$this->__output_comparebuggies($param);
    }
	/**
	 * comparebuggies_post Method
	 *
	 * comparebuggies_post output details about passed qr_ids. Used by comparebuggies_get and comparebuggies_post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function __output_comparebuggies($param){
		extract($param);
		if(!$qrids){
			$this->response(array("error"=>"Invalid Parameter"), 400);exit;
		}
		$this->load->model('services_model');
		
		$data=$this->services_model->KM_all(
					array("class"=>"qrc",
						  'select'=>'qrc.qrcid "QR ID",qrc.qrc "QR Data",qrc.price "Price",product.pname as "Product Name",product.image as "Product Image",qrc.StreetName as "StreetName", 
						   concat("'.base_url(QR_IMAGE_PATH).'/",qrc.qrcimgpath ) as Image , retname "Retailer", locname "Location",act_log.actdt "Scan Date", if( `favs`.`isfavstill`="",0,1 ) as Favourite,product.url as "product_url"',
						   'order_prefix'=>false,
						   'protect_identifiers'=>false,
						   "conditions_in"=>array("qrcid"=>explode(',',$qrids)),
						   'joins'=>array(
										array("class"=>"act_log","type"=>"inner","foreignKey"=>"qrcid","primaryKey"=>"qrcid",
												"join_and_cond"=>array("action"=>"scan")),
										array("class"=>"favs","type"=>"left","foreignKey"=>"qrcid","primaryKey"=>"qrcid"), 
										array("class"=>"product","type"=>"left","foreignKey"=>"pid","primaryKey"=>"pid"),
										array("class"=>"retailer","type"=>"left","foreignKey"=>"retid","primaryKey"=>"retid"),
										array("class"=>"location","type"=>"left","foreignKey"=>"locid","primaryKey"=>"locid"),
								),
							'order'=>'act_log.actdt desc',
							'groupby'=>'qrc.qrcid'	
						  )
				   );	
		
		if(!empty($data)){			
			$this->__save_to_log($hwid,$uid,$qrids,'compare buggies',$created_date);
			$this->response($data, 200); 
		}else{
		$this->response(array("error"=>"Product not available"), 200);exit;									 
		}	
		
	}
	
	/**
	 * retailers_get Method
	 *
	 * retailers_get output list of retailer concern to particular user/device. Used for get method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function retailes_get()
    {  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY','is_fav');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'uid'=>(int)$this->get('userid'),
			'hwid'=>$this->get('hardware_id'),
			'created_date'=>date("Y-m-d H:i:s"),
			'is_fav'=>(int)$this->get('is_fav')
		);
		$this->__output_retailers($param);
    }
	/**
	 * retailers_post Method
	 *
	 * retailers_post output list of retailer concern to particular user/device. Used for post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function retailes_post()
    {  
	     $allowed_params=array('userid','hardware_id','format','X-API-KEY','is_fav');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id'),
			'created_date'=>date("Y-m-d H:i:s"),
			'is_fav' => (int)$this->post('is_fav'),
		);
		$this->__output_retailers($param);
    }
	/**
	 * __output_retailers Method
	 *
	 * __output_retailers output list of retailer concern to particular user/device. Used by retailers_get and retailers_post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function __output_retailers($param){
		extract($param);
		 
		$this->load->model('services_model');
		
		$data=$this->services_model->get_retailers($param);	
		
		if(!empty($data)){			
			$this->__save_to_log($hwid,$uid,0,'retailers list',$created_date);
			$this->response($data, 200); 
		}else{
		$this->response(array("error"=>"No retailer found"), 200);exit;									 
		}	
		
	}
	
	/**
	 * categories_get Method
	 *
	 * categories_get output list of product categories concern to scaned produc by particular user/device. Used by get method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function categories_get()
    {  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'uid'=>(int)$this->get('userid'),
			'hwid'=>$this->get('hardware_id'),
			'created_date'=>date("Y-m-d H:i:s")
		);
		$this->__output_categories($param);
    }
	/**
	 * categories_post Method
	 *
	 * categories_post output list of product categories concern to scaned produc by particular user/device. Used by post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	function categories_post()
    {  
	     $allowed_params=array('userid','hardware_id','format','X-API-KEY');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id'),
			'created_date'=>date("Y-m-d H:i:s")
		);
		$this->__output_categories($param);
    }
	
	/**
	 * __output_categories Method
	 *
	 *  __output_categories output list of product categories concern to scaned produc by particular user/device. Used for categories_get and categories_post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function __output_categories($param){
		extract($param);
		 
		$this->load->model('services_model');
		
		$data=$this->services_model->get_categories($param);	
		
		if(!empty($data)){			
			$this->__save_to_log($hwid,$uid,0,'categories list',$created_date);
			$this->response($data, 200); 
		}else{
		$this->response(array("error"=>"No Categories found"), 200);exit;									 
		}	
		
	}
	
	/**
	 *  subcategories_get Method
	 *
	 *  subcategories_get output list of product subcategories_get concern to scaned produc by particular user/device. Used for get method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function subcategories_get()
    {  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY','is_fav');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'catid'=>(int)$this->get('catid'),
			'uid'=>(int)$this->get('userid'),
			'hwid'=>$this->get('hardware_id'),
			'created_date'=>date("Y-m-d H:i:s"),
			'is_fav' =>(int)$this->get('is_fav'),
		);
		$this->__output_subcategories($param);
    }
	
	/**
	 *  subcategories_post Method
	 *
	 *  subcategories_post output list of product subcategories_get concern to scaned produc by particular user/device. Used for post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function subcategories_post()
    {  
	     $allowed_params=array('userid','hardware_id','format','X-API-KEY','is_fav');
		
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'catid'=>(int)$this->get('catid'),
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id'),
			'created_date'=>date("Y-m-d H:i:s"),
			'is_fav' => (int)$this->post('is_fav'),
		);
		$this->__output_subcategories($param);
    }	
	
	/**
	 *  __output_subcategories Method
	 *
	 *  __output_subcategories output list of product subcategories_get concern to scaned produc by particular user/device. Used by subcategories_get and subcategories_post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	function __output_subcategories($param){
		extract($param);
		 
		$this->load->model('services_model');
		
		$data=$this->services_model->get_subcategories($param);	
		
		if(!empty($data)){			
			$this->__save_to_log($hwid,$uid,0,'sub categories list',$created_date);
			$this->response($data, 200); 
		}else{
		$this->response(array("error"=>"No retailer found"), 200);exit;									 
		}	
		
	}
	
	/**
	 *  filterproducts_get Method
	 *
	 *  filterproducts_get output filters and displays product with details. Used for get method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	
	function filterproducts_get()
    {  
	    $allowed_params=array('userid','hardware_id','format','X-API-KEY','catid','subcatid','price','retailer_id','chronologic');
		
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'catid'=>(int)$this->get('catid'),
			'uid'=>(int)$this->get('userid'),
			'hwid'=>$this->get('hardware_id'),
			'catid'=>(int)$this->get('catid'),
			'subcatid'=>(int)$this->get('subcatid'),
			'price'=>(int)$this->get('price'),
			'retailerid'=>$this->get('retailer_id'),
			'chronologic'=>(int)$this->get('chronologic'),
			'created_date'=>date("Y-m-d H:i:s")
		);
		$this->__output_filterProducts($param);
    }
	
	/**
	 *  filterproducts_post Method
	 *
	 *  filterproducts_post output filters and displays product with details. Used for post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */
	
	
	function filterproducts_post()
    {  
	     $allowed_params=array('userid','hardware_id','format','X-API-KEY','catid','subcatid','price','retailer_id','chronologic');
		 
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id'),
			'catid'=>(int)$this->post('catid'),
			'subcatid'=>(int)$this->post('subcatid'),
			'price'=>$this->post('price'),
			'retailerid'=>$this->post('retailer_id'),
			'chronologic'=>(int)$this->post('chronologic'),
			'created_date'=>date("Y-m-d H:i:s")
		);
		
		$this->__output_filterProducts($param);
    }	
	
	/**
	 *  __output_filterProducts Method
	 *
	 *  __output_filterProducts output filters and displays product with details. Used by filterproducts_get and filterproducts_post method. 
	 *	
	 
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */ 
	 
	function __output_filterProducts($param){		
		extract($param); 
		$this->load->model('services_model');	 
		
		$data=$this->services_model->filter_qrs($param);  
		  	
		
		if(!empty($data)){			
			$this->__save_to_log($hwid,$uid,0,'sub categories list',$created_date);
			$this->response($data, 200); 
		}else{
		$this->response(array("error"=>"No data found"), 200);exit;									 
		}	
		
	}
	
	/**
	 *  savebulkqr_get Method
	 *
	 *  savebulkqr_get saves scanned qr_idd for a user/device. Used for get request.
	 *	
	 
	 * @param  qrids (comma separated qr_ids)
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */ 
	
	function savebulkqr_get(){
		$allowed_params=array('qrids','userid','hardware_id','format','X-API-KEY');
		if(count(array_diff(array_keys($this->_get_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			"qrids"=>$this->get('qrids'),
			"uid"=>(int)$this->get('userid'),
			"hwid"=>$this->get('hardware_id')
		);
	 	
		$this->__output_savebulkqr($param); 
	}
	
	/**
	 *  savebulkqr_post Method
	 *
	 *  savebulkqr_post saves scanned qr_idd for a user/device. Used for post request.
	 *	
	 
	 * @param  qrids (comma separated qr_ids)
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */ 
	
	function savebulkqr_post(){
		$allowed_params=array('qrids','userid','hardware_id','format','X-API-KEY');
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			"qrids"=>$this->post('qrids'),
			"uid"=>(int)$this->post('userid'),
			"hwid"=>$this->post('hardware_id')
		);
	 	
		$this->__output_savebulkqr($param); 
	}
	
	/**
	 *  savebulkqr_post Method
	 *
	 *  savebulkqr_post saves scanned qr_idd for a user/device. Used by savebulkqr_get an savebulkqr_post functions.
	 *	
	 
	 * @param  qrids (comma separated qr_ids)
	 * @param int userid
	 * @param string hardware_id
	 * @param string X-API-KEY
	 * @param string format (xml/json)
	 * @output json/xml
	 */ 
	
	function __output_savebulkqr($param){
		extract($param);
		 
		if(!$qrids){
        	 $this->response(array('error' => 'Invalid Data'), 400);exit;
        }else{
	 		$this->load->model('services_model'); 
			$qrids_arr=explode($qrids);
			foreach($qrids_arr as $qrid){
				$this->__save_to_log($hwid,$uid,$qrid,'scan',$created_date);
			}
			$this->response(array('success'=>'QR IDs added to buggy'), 200);  
		}
	}
	
	function favfiltercategories_post()
    {  
	     $allowed_params=array('userid','hardware_id','format','X-API-KEY','catid','subcatid','price','retailer_id','chronologic');
		 
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id'),
			'catid'=>(int)$this->post('catid'),
			'subcatid'=>(int)$this->post('subcatid'),
			'price'=>$this->post('price'),
			'retailerid'=>$this->post('retailer_id'),
			'chronologic'=>(int)$this->post('chronologic'),
			'created_date'=>date("Y-m-d H:i:s")
		);
		
		$this->__output_filterfavcategories($param);
    }	
	
	
		function __output_filterfavcategories($param){		
		extract($param); 
		$this->load->model('services_model');	 
		
		$data=$this->services_model->filterfav_categories($param);  
		  	
		
		if(!empty($data)){			
			$this->__save_to_log($hwid,$uid,0,'sub categories list',$created_date);
			$this->response($data, 200); 
		}else{
		$this->response(array("error"=>"No data found"), 200);exit;									 
		}	
		
	}
	function favfilterprice_post()
    {  
	     $allowed_params=array('userid','hardware_id','format','X-API-KEY','catid','subcatid','price','retailer_id','chronologic');
		 
		if(count(array_diff(array_keys($this->_post_args),$allowed_params))>0){
			 $this->response(array('error' => 'Invalid Request'), 400);exit;
		} 
		
		$param=array(
			'uid'=>(int)$this->post('userid'),
			'hwid'=>$this->post('hardware_id'),
			'catid'=>(int)$this->post('catid'),
			'subcatid'=>(int)$this->post('subcatid'),
			'price'=>$this->post('price'),
			'retailerid'=>$this->post('retailer_id'),
			'chronologic'=>(int)$this->post('chronologic'),
			'created_date'=>date("Y-m-d H:i:s")
		);
		
		$this->__output_filterfavprice($param);
    }	
	
	
		function __output_filterfavprice($param){		
		extract($param); 
		$this->load->model('services_model');	 
		
		$data=$this->services_model->filterfav_price($param);  
		  	
		
		if(!empty($data)){			
			$this->__save_to_log($hwid,$uid,0,'sub categories list',$created_date);
			$this->response($data, 200); 
		}else{
		$this->response(array("error"=>"No data found"), 200);exit;									 
		}	
		
	}
	
}
