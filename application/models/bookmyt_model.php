<?php
	class Bookmyt_model extends KM_Model 
	{
		function __construct()
		{
			parent::__construct();
		}
		public function get_time_zone()
		{
			$sql = "select * from zone";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function get_countries()
		{
			$sql = "select * from country";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function get_businesss()
		{
			$sql = "select * from business_types";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		public function get_business_types()
		{
			$sql="select * from business_types";
			$res = $this->db->query($sql);	
			return $res->result_array();		 
	 
		}
		
		function get_flr($res_id)
		{
			 $sql = "select r.relationship_id, f.floor_id, f.floor_no, b.business_name from reservation r inner join floor_chart f on (f.business_id=r.business_id) inner join business_entity b on b.business_id = f.business_id where r.reservation_id = '$res_id'";
			$res = $this->db->query($sql);	
			return $res->result_array();	
		}
		
		 public function get_zones()
		 {
		 $sql="select * from zone where country_code in('IN','US','CA')";
		 $res = $this->db->query($sql);	
			return $res->result_array(); 
			 
		 }
		  public function get_zones1()
		 {
		 $sql="select * from timezonebyzipcode group by timezone";
		 $res = $this->db->query($sql);	
			return $res->result_array(); 
			 
		 }
		 public function get_zones_cc($cc)
		 {
			$sql="select * from timezonebyzipcode where country='$cc'";
			$res = $this->db->query($sql);	
			return $res->result_array(); 
			 
		 }
		 
		  public function get_floors($business_id)
		 {
			$sql="select * from floor_chart where business_id='$business_id'";
			$res = $this->db->query($sql);	
			return $res->result_array(); 
			 
		 }
		
		// Code Added By Leela Kumar. 
		
		function get_flrs_branches($bid,$hb)
		{
			$sql="select f.floor_id, f.floor_no, f.business_id, be.business_name,GROUP_CONCAT(s.section_id) section_id,GROUP_CONCAT(s.section_name) section_name from floor_chart f  inner join business_entity be on f.business_id = be.business_id left join sections s on s.floor_id=f.floor_id ";
			if($hb == 0)	
			{				
				$sql .= "where be.business_id = '$bid' group by f.floor_id order by f.business_id asc";
			}
			else
			{
				$sql .= "where be.business_id = '$bid' or be.relationship_id = '$bid' group by f.floor_id order by f.business_id asc";
			}
			//echo $sql;
			$res = $this->db->query($sql);	
			return $res->result_array(); 
		}
		function get_flrs_branches2($bid,$hb)
		{
			$sql="select f.floor_id, f.floor_no, f.business_id, be.business_name,GROUP_CONCAT(s.section_id) section_id,GROUP_CONCAT(s.section_name) section_name from floor_chart f  inner join business_entity be on f.business_id = be.business_id left join sections s on s.floor_id=f.floor_id ";
			if($hb == 0)	
			{				
				$sql .= "where be.business_id = '$bid'";
			}
			else
			{
				$sql .= "where be.business_id = '$bid' group by f.floor_id order by f.business_id asc";
			}
			//echo $sql;
			$res = $this->db->query($sql);	
			return $res->result_array(); 
		}
		function get_flrs_branches1($bid)
		{
			$sql = "select
			  f.floor_id,
			  f.floor_no,
			  f.business_id,
			  be.business_name
			from floor_chart f
			  inner join business_entity be
				on f.business_id = be.business_id
			where  f.business_id = '$bid'";
			$res = $this->db->query($sql);	
			return $res->result_array();
		}
		
		
		 public function get_branches($bid,$hb=1)
		 {
			$sql = "select business_id,business_name from business_entity ";
			
			if($hb == 0)	
			{				
				$sql .= "where business_id='$bid'";
			}
			else
			{
				$sql .= "where business_id='$bid' or relationship_id='$bid'";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
		  
		 
		 public function get_branche_name($bid)
		 {
			$sql = "select business_name from business_entity where business_id='$bid' or relationship_id='$bid'";
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
		 
		 public function get_roles()
		 {
			$sql ="select role_id,role_name from role_permissions limit 1,3";
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
		 
		 public function get_users($b_id)
		 {
			$sql = "select * from user_details where business_id='$b_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
		 
		 public function get_branch_name()
		 {
			$sql = "select business_id,business_name from business_entity";
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
		 
		 public function pswd_match($bid,$old)
		 {
			$sql = "select * from business_entity where business_id='$bid' and password='$old'";
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
		 
			//frgt_match($email)
		 
		 public function pswd_user_match($uid,$old)
		 {
			$sql = "select * from user_details where user_id='$uid' and password='$old'";
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
		 
		 public function pswd_branch_match($bid,$old)
		 {
			$sql = "select * from business_entity where business_id='$bid' and password='$old'";
			$query = $this->db->query($sql);
			return $query->result_array();
		 }
		 
		 public function get_names($phn,$bid)
		 {
		    $date=date('Y-m-d');
			//$sql = "select phone_no from reservation where phone_no='$phn' and (business_id='$bid' or relationship_id='$bid') and  phone_status ='1' and booked_date >='$date'";
			$sql = "select name, date_of_birth,ifnull((select is_vip from reservation
			where  (business_id='$bid' or relationship_id='$bid') and tf.phone_no = phone_no  and is_vip is not null
			union all
			select is_vip from reservation_archive ra
			where (business_id='$bid' or relationship_id='$bid')  and is_vip is not null  and tf.phone_no = ra.phone_no 
			order by reservation_id desc limit 1) ,0) as is_vip from reservation tf where phone_no='$phn' and (business_id='$bid' or relationship_id='$bid') order by reservation_id desc  limit 1";
			$query = $this->db->query($sql);
			$phone = $query->result_array();
			if(empty($phone))
			{
				$sql = "select name, date_of_birth,ifnull((select is_vip from reservation
			where  (business_id='$bid' or relationship_id='$bid') and tf.phone_no = phone_no 
			union 
			select is_vip from reservation_archive ra
			where (business_id='$bid' or relationship_id='$bid')  and tf.phone_no = ra.phone_no 
			order by reservation_id desc limit 1) ,0) as is_vip from reservation_archive tf where phone_no='$phn' and (business_id='$bid' or relationship_id='$bid') order by reservation_id desc  limit 1";
				$query = $this->db->query($sql);
				return  $query->result_array();
			}else{
				return $phone;
			}
		 }
		 
		 public function change_password($bid,$new)
		{
			$data = array(
				'password' => $new
				);		
			$this->db->where('business_id', $bid);
			$this->db->update('business_entity', $data);
			return true;
		}
		
		public function change_user_pd($uid,$new)
		{
			$data = array(
				'password' => $new
				);		
			$this->db->where('user_id', $uid);
			$this->db->update('user_details', $data);
			return true;
		}
		
		public function up_pwd($uid,$new)
		{
			$data = array(
				'password' => md5($new)
				);		
			$this->db->where('user_id', $uid);
			$this->db->update('user_details', $data);
			return true;
		}
		
		public function up_busi_pwd($bid,$new)
		{
			$data = array(
				'password' => md5($new)
				);		
			$this->db->where('business_id', $bid);
			$this->db->update('business_entity', $data);
			return true;
		}
		
		
		
		public function user_pswd_match($uid,$old)
		{
			$sql = "select * from user_details where user_id='$uid' and password='$old'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	public function frgt_match($email)
	{
		$sql = "select * from business_entity where (business_email='$email' or phone_no='$email') and is_active=1 and is_delete!=1";
		$query = $this->db->query($sql);
		return $query->result_array();
	} 
	public function user_check($email)
	{
		$sql = "select * from user_details where (email='$email' or phone_no ='$email') and is_active=1 and is_delete!=1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getfloor_info($section_id,$floor_id)
	{
		 $sql="select s.*,t.*,ifnull(r.status,0) as 'Booked_Status', ifnull(TIME_FORMAT(time(r.in_time),'%H:%i'),'')in_time, ifnull(concat(r.booked_date,' ',r.in_time),'')booked_date from sections s 
		 left join floor_chart f on f.floor_id=s.floor_id
		left join table_info t on t.floor_id = f.floor_id
		left join reservation r on t.table_id = r.table_id and r.booked_date = '".date('Y-m-d')."' and r.status=1
		where f.floor_id='$floor_id' and t.section_id ='$section_id' and s.section_id='$section_id' group by  t.table_id  	ORDER BY 
		CASE 
		WHEN LENGTH(t.serial_no)>=4 THEN abs(substring(t.serial_no, 1, 2))        
		WHEN (LENGTH(t.serial_no)=3 and abs(substring(t.serial_no, 3, 1)!=0  )) THEN abs(substring(t.serial_no, 1, 2))
			else abs(substring(t.serial_no, 1, 1))
		END, abs(t.serial_no) ";
		//echo $sql;
		 $res = $this->db->query($sql);	
		return $res->result_array(); 
	}
	public function email_duplicate($email)
	{
		$sql = "select * from business_entity where business_email='$email' or phone_no='$email'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function chk_usr_email_duplicate($email){
		$bid=$this->session->userdata('business_id');
		$sql="select * from user_details where (email='$email' or phone_no='$email') and business_id='$bid'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function role_permissions($role_id)
	{			
		$sql = "select * from role_permissions where role_id='$role_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function b_email($email)
	{
		$sql = "select * from business_entity where business_email='$email'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function b_phone($phone){
		$sql = "select * from business_entity where phone_no='$phone'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function branches_check($bid)
	{
		$sql = "select * from business_entity where relationship_id='$bid'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function get_res_info($rid)
	{
		$sql = "select r.customer_id, name,phone_no, group_concat(t.table_no) as table_no, date_of_birth from reservation r 
inner join table_info t on r.table_id = t.table_id where r.reservation_id = '$rid' or r.parent_reservation='$rid' group by r.customer_id;";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function u_name($uid)
	{
		$sql = "select username as steward from user_details where user_id='$uid'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function b_name($bid)
	{
		$sql = "select business_name as steward from business_entity where business_id='$bid'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function dashboard_businesses()
	{
		$sql = "select * from business_entity where branch='0' and is_admin is null order by business_id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function request_demo_list()
	{
		$sql = "select * from contact_list order by request_id desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function business_entity_login($email,$password)
	{
		$sql = "select business_id,business_name,business_email,time_zone,is_admin,
				last_login from business_entity where (business_email='$email' or phone_no='$email') and password='$password' and is_admin='1' and is_active='2' and is_delete!=1";
				
		$res = $this->db->query($sql);
		
		$res=$res->result_array(); 
		if(is_array($res) && !empty($res)){
			return $res[0]; 
		}else{
			return array(); 
		}
	}
	function business_entity_user_login($email,$password)
	{
		$sql = "select business_id,
				business_name,
				business_email,subscription_type,
				branch,time_zone,
				ifnull(relationship_id,'')relationship_id,
				ifnull(have_branches,0)have_branches,
				login_count,phone_no,is_admin,is_active,
				last_login,login_via,business_typeid from business_entity where (business_email='$email' or phone_no='$email') and password='$password' and is_delete!=1";
			
		$res = $this->db->query($sql);
		$res=$res->result_array(); 
		if(is_array($res) && !empty($res)){
			return $res[0]; 
		}else{
			return array(); 
		}
	}
	function user_detatails_user_login($email,$password)
	{
		$sql = "select user_id,username as business_name,email,user_type_id,business_id,relationship_id,last_login,phone_no,is_active from user_details where (email='$email' or phone_no='$email') and password='$password' and is_delete!=1";
		$res = $this->db->query($sql);
		$res=$res->result_array(); 
		if(is_array($res) && !empty($res)){
			return $res[0]; 
		}else{
			return array(); 
		}
	}
	function search_locations($location)
	{
		$sql = "select city from timezonebyzipcode where city  like '$location%' group by  city limit 5";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function updateProfile($name,$id){
		$name=addslashes($name);
		if($name!=""){
			$query=$this->db->query("select * from business_entity where (business_name='$name') and business_id!='$id'");
			return $query->result_array();
		}
	}
	function checkEmail($email,$id){
		$name=addslashes($name);
		if($email!=""){
			$query=$this->db->query("select * from business_entity where (business_email='$email') and business_id!='$id'");
			return $query->result_array();
		}
	}
	function checkduplicateEmail($email,$id){
		$name=addslashes($name);
		$query=$this->db->query("select * from business_entity where (business_email<>'' and business_email='$email') and business_id!='$id'");
		return $query->result_array();
	}
	function checkPhone($phone,$id){
		$name=addslashes($name);
		if($phone!=""){
			$query=$this->db->query("select * from business_entity where (phone_no='$phone') and business_id!='$id'");
			return $query->result_array();
		}
	}
	function checkduplicatePhone($phone,$id){
		$name=addslashes($name);
		$query=$this->db->query("select * from business_entity where (phone_no<>'' && phone_no='$phone') and business_id!='$id'");
		return $query->result_array();
	}
	function checkDupEmail($email,$phone){
		$query=$this->db->query("select * from business_entity where (business_email='$email' or phone_no='$phone')");
		return $query->result_array();
	}
	function checkDupEmailcheck($email,$phone){
		$query=$this->db->query("select * from business_entity where ((business_email<>'' and business_email='$email') or (phone_no<>'' and phone_no='$phone'))");
		return $query->result_array();
	}
	function getTimeZone($floor_id){

		$query=$this->db->query("select b.time_zone from business_entity b join floor_chart f on f.business_id=b.business_id where f.floor_id='$floor_id'");
		return $query->result_array();
	}
	function getBusinessEntityInfo($id){
		$query=$this->db->query("select * from business_entity where business_id='$id'");
		return $query->result_array();
	}
	function updateBusinessEntity(){
		$business_id=$this->input->post("business_id");
		if($this->input->post("password")!=""){
			$password=md5($this->input->post("password"));
		}else{
			$password="";
		}
		if($this->input->post("b_check")=="L"){
			$have_branches='1';
		}else{
			$have_branches='0';
		}			
		if(isset($password) && $password!=""){
			$data=array(
						'business_name'		=> $this->input->post("business_name"),
						'business_email'	=> $this->input->post("business_email"),
						'phone_no'			=> $this->input->post("phone_no"),
						'password'			=> $password,
						'zipcode'			=> $this->input->post("zipcode"),
						'address'			=> $this->input->post("address"),
						'city'				=> $this->input->post("city"),
						'state'				=> $this->input->post("state"),
						'country'			=> $this->input->post("country"),
						'business_type'		=> $this->input->post("b_check"),
						'have_branches'		=> $have_branches,
						'time_zone'			=> $this->input->post("time_zone")
					);
		}else{
			$data=array(
						'business_name'		=> $this->input->post("business_name"),
						'business_email'	=> $this->input->post("business_email"),
						'phone_no'			=> $this->input->post("phone_no"),							
						'zipcode'			=> $this->input->post("zipcode"),
						'address'			=> $this->input->post("address"),
						'city'				=> $this->input->post("city"),
						'state'				=> $this->input->post("state"),
						'country'			=> $this->input->post("country"),
						'business_type'		=> $this->input->post("b_check"),
						'have_branches'		=> $have_branches,
						'time_zone'			=> $this->input->post("time_zone")
					);
		}
		$this->db->update("business_entity",$data,array("business_id"=>$business_id));
		return true;	
	}
	public function getMonthlyReport($bid,$month){
		$date=date("Y-m-d");		
		if($month!=""){
			$months= date("Y-m-d", strtotime($month));
		}else{
			$months=date('Y-m-d');
		}
		
		$this->db->reconnect();
		$query=$this->db->query("call MonthlyVisits('$bid','$months')");

		$data= $query->result_array();
		return $data;			
	}
	public function getMonthlyReport1(){
		$month=$this->input->post("month");
		$date=date("Y")."-".$month."-01";
		$query=$this->db->query("call MonthlyVisits('$date')");
		return $query->result_array();
	}
	public function getWeeklyReport($bid){
		if($this->input->post("weekrange") && $this->input->post("weekrange")!=""){
			$week=substr($this->input->post("weekrange"),0,10);
			
			$date=date("Y-m-d",strtotime($week));
			
		}else{
			$date=date("Y-m-d");
		}
		$this->db->reconnect();
		$sql="call WeekVisits($bid,'$date')";

		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function getFeedbackReport($bid){
		$sql="select * from (select name, phone_no, bill_no, bill_amount, feedback_on_food,feedback_on_service ,
		type_of_dining,steward,special_remarks, booked_date, in_time
		from reservation_archive 
		where (business_id = $bid or relationship_id = $bid) and confirmed='1' and feedback_on_food is not null
		union
		select name, phone_no, bill_no, bill_amount, feedback_on_food,feedback_on_service ,
		type_of_dining,steward,special_remarks, booked_date, in_time
		from reservation 
		where (business_id = $bid or relationship_id = $bid) and confirmed='1' and feedback_on_food is not null )a  order by booked_date desc, in_time desc";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function getDailyReport($bid){
		//$db=$this->load->database('bookmyti__in_live',true);
		$this->db->reconnect();
		$date=date('Y-m-d');
		$query=$this->db->query("call DailyVisits($bid,'$date')");
		return $query->result_array();
	}
	public function getCustomerData($bid){
		$sql = "select * from customer c join business_customer bc
on c.customer_id=bc.customer_id where bc.business_id=$bid ";
		$query= $this->db->query($sql);
		return $query->result_array();
		
	}
	/*For Getting Customer Report List*/
	function getCustomerReport(){
		$where='';
		if($this->input->post('submit')){
			$date=($this->input->post('date')!="")?$this->input->post('date'):'';
			$cust_priority=($this->input->post('cust_priority')!="")?$this->input->post('cust_priority'):'';
			if($date!=""){
				$date=date('Y-m-d',strtotime($date));
				$where.=" and r.date_of_birth='$date'";
			}
			if($cust_priority!=""){
				if($cust_priority=='is_vip'){
					$where.=" and r.is_vip='1'";
				}else if($cust_priority=='is_star'){
					$where.=" and bc.is_star_customer>='3'";
				}
			}
			
		}
		$bid=$this->session->userdata('business_id');
		$sql="select * from
(select r.reservation_id rid,c.`name`,c.customer_id,c.phone_no,r.date_of_birth,r.is_vip,r.is_new,bc.is_star_customer,bc.promotion_id,
bc.promocode, p.description,p.promotion_type,p.disc_on_cur_bill,p.disc_on_freq_cust,p.disc_on_group,
p.disc_on_last_bill,p.disc_percent,p.discount_type,p.promocode promo from customer c 
join reservation r on r.customer_id=c.customer_id 
left join business_customer bc on bc.customer_id=c.customer_id 
left join promotion p on p.promotion_id=bc.promotion_id where 1=1 and bc.business_id='$bid'  
order by r.reservation_id desc) as a group by a.customer_id";
		//echo $sql;
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	function detailed_report($bid){
		if($this->input->post('from_date')!=""){
			$from_date=date('Y-m-d',strtotime($this->input->post('from_date')));
		}else{
			$from_date=date('Y-m-d',strtotime('-30 days'));
		}
		if($this->input->post('to_date')!=""){
			$to_date=date('Y-m-d',strtotime($this->input->post('to_date')));
		}else{
			$to_date=date('Y-m-d');
		}
		$this->db->reconnect();
		$sql="call DetailReport($bid,'$from_date','$to_date')";		
		$query=$this->db->query($sql);
		return $query->result_array();
	}	
	public function getSalesWeekReport(){
		if($this->input->post('weekrange') && $this->input->post('weekrange')!=""){
			$start_date=date('Y-m-d',strtotime(strstr($this->input->post('weekrange'),' to',true)));
			$end_date=date('Y-m-d',strtotime(substr(strstr($this->input->post('weekrange'),'to'),3)));
		}else{
			$date=date('Y-m-d');
			$start_date=date('Y-m-d',strtotime('sunday last week', strtotime($date)));
			$end_date=date('Y-m-d',strtotime('saturday this week', strtotime($date)));
		}
		$this->db->reconnect();
		$bid=$this->session->userdata('business_id');
		//echo "call LastWeekVisits('$start_date','$end_date',$bid)";
		$query=$this->db->query("call LastWeekVisits('$start_date','$end_date',$bid)");
		return $query->result_array();
	}
	public function getYearlyReport(){
		$this->db->reconnect();
		$bid=$this->session->userdata('business_id');
		if($this->input->post('year') && $this->input->post('year')!=""){
			$year=$this->input->post('year');
		}else{
			$year=date("Y");
		}			
		$query=$this->db->query("call YearlyVisits('$year',$bid)");
		$data=$query->result_array();
		$months=array('January','February','March','April','May','June','July','August','September','October','November','December');
		if($year==date("Y")){
			for($i=count($data)+1;$i<=12;$i++){
				if($i!=count($data)){
					$data[$i-1]=array('Period'=>$months[$i-1].date("Y"),'old_visits'=>0,'new_visits'=>0,'no_of_visits'=>0,'bill_amount'=>0.00);
				}	
			}
		}
		//pr($data);
		return $data;
	}
	 function business_entity_superuser_login($business_id)
	 {
		$sql = "select business_id,
				business_name,
				business_email,
				subscription_type,
				branch,time_zone,
				ifnull(relationship_id,'')relationship_id,
				ifnull(have_branches,0)have_branches,
				login_count,phone_no,
				last_login,login_via,business_typeid from business_entity where business_id='".(int)$business_id."' and is_active='1'";
			
		$res = $this->db->query($sql);
		$res=$res->result_array(); 
		if(is_array($res) && !empty($res))
		{
		return $res[0]; 
		}else
		{
		return array(); 
		}
	 }
	 function business_entity_superlogin()
	 {
		$sql = "select business_id,business_name,business_email,time_zone,
				last_login from business_entity where  is_admin='1' and is_active='2'";
				
		$res = $this->db->query($sql);
		
		$res=$res->result_array(); 
		if(is_array($res) && !empty($res))
		{
		return $res[0]; 
		}else
		{
		return array(); 
		}
	 }
	 function business_report($business_id)
	 {
		$sql = "select b.business_id,business_name, b.last_login, floor_no, no_of_tables, floor_rows,floor_columns ,  count(table_id) table_count
				from business_entity b  
				left join floor_chart f on b.business_id = f.business_id
				left join table_info t on t.floor_id = f.floor_id and f.business_id = t.business_id
				where  b.business_id = ".(int)$business_id."
				group by f.business_id, t.floor_id";				
		$res = $this->db->query($sql);
		return $res->result_array(); 
	}
	 function business_user_info($business_id)
	 {
		$sql = "select username,email,phone_no, last_login from user_details where business_id = ".(int)$business_id." and is_active = 1";				
		$res = $this->db->query($sql);
		return $res->result_array(); 
	}
	function business_bracnch_info($business_id)
	 {
		$sql = "select b.business_id,business_name, b.last_login, floor_no, no_of_tables, floor_rows,floor_columns ,  count(table_id) table_count
				from business_entity b  
				left join floor_chart f on b.business_id = f.business_id
				left join table_info t on t.floor_id = f.floor_id and f.business_id = t.business_id
				where  b.relationship_id = ".(int)$business_id."
				group by b.business_id, f.floor_id";				
		$res = $this->db->query($sql);
		return $res->result_array(); 
	}
	function branch_user_info($business_id)
	{
		$sql = "select username,email,phone_no, last_login from user_details where business_id = ".(int)$business_id." and is_active = 1";				
		$res = $this->db->query($sql);
		return $res->result_array(); 
	}
	function update_payment_status($id,$pay_id,$status,$sub_type='',$price='',$profile_id='',$payment_profile_id=''){
		//$cc=substr($this->input->post('card_number'),-4);
		//$expiry=$this->input->post('year').'-'.$this->input->post('month');
		if($status=='success'){
			$data=array(
						'payment_status'			=> 1,
						'transaction_status'		=> $status
					);
			if($sub_type!=""){
				$data['subscription_type']=$sub_type;
			}
			if($sub_type==2 || $sub_type==3){
				$data['business_type']="S";
			}else if($sub_type==4 || $sub_type==5){
				$data['business_type']="L";
				$this->session->set_userdata('have_branches',1);
			}
			if($price!=""){
				$data['price']=$price;
			}
			$this->session->set_userdata('subscription_type',$sub_type);
			$this->db->update("business_entity",$data,array("business_id"=>$id));
			$this->db->delete("payment_details",array('business_id'=>$id));
			$this->db->insert("payment_details",array("business_id"=>$id,"subscription_id"=>$pay_id,"profile_id"=>$profile_id,"payment_profile_id"=>$payment_profile_id,"created_ts"=>date("Y-m-d H:i:s")));
		}else{
			$date=date("Y-m-d",strtotime("+1 month"));
			$this->db->update("business_entity",array("payment_status"=>0,"transaction_status"=>$pay_id,"subscription_type"=>1,"subscription_end_dt"=>$date),array("business_id"=>$id));			
		}
	}
	function get_rewards_info($customer_id, $business_id)
	{
		$sql = "select sum(rewards) rewards,bc.promocode  from reward_point_history rp
join business_customer bc on bc.customer_id=rp.customer_id and bc.business_id=rp.business_id  where rp.customer_id  = ".(int)$customer_id." and rp.business_id =".(int)$business_id."";
		$res = $this->db->query($sql);
		return $res = $res->result_array(); 
		//return $res[0]['rewards'];
	}
	public function getFloorInfo($floor_id){
		$sql="select * from floor_chart where floor_id='$floor_id'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function updateFloorInfo($floor_id){
		$dat=array(
					'floor_no'			=> $this->input->post('floor_no'),
					'no_of_sections'	=> $this->input->post('no_of_sections')
				);
		$this->db->update('floor_chart',$dat,array('floor_id'=>$floor_id));
		return true;
	}
	public function get_floors_list($business_id,$have_branches)
	{
		$sql="select f.* ,b.business_name as branch from business_entity b inner join floor_chart f on b.business_id = f.business_id
		where b.business_id ='$business_id' union select f.*,be.business_name from business_entity be inner join floor_chart f on be.business_id = f.business_id where ";
		
		if($have_branches == 0)
		{
			$sql  .= "be.relationship_id =''";
		}
		else
		{
			$sql  .= "be.relationship_id ='$business_id'";
		}
		
		$res = $this->db->query($sql);	
		return $res->result_array();	 
	}
	public function get_section_list($id,$business_id,$have_branches){
		$sql="select s.section_id,s.section_name,s.floor_id,s.business_id,s.no_of_tables,b.business_name from sections s join business_entity b on b.business_id=s.business_id where b.business_id='$business_id' and s.floor_id='$id' union select s.section_id,s.section_name,s.floor_id,s.business_id,s.no_of_tables,b.business_name from sections s join business_entity b on b.business_id=s.business_id where s.floor_id='$id'";
		if($have_branches == 0)
		{
			$sql  .= " and b.relationship_id =''";
		}
		else
		{
			$sql  .= " and b.relationship_id ='$business_id'";
		}
		//echo $sql;
		$res = $this->db->query($sql);	
		return $res->result_array(); 
	}
	public function get_sections_count($id){
		$sql="select f.no_of_sections from floor_chart f where f.floor_id='$id'";		
		$res = $this->db->query($sql);	
		return $res->result_array(); 
	}
	function insert_sections(){
		$data=array(
						'floor_no'			=> $this->input->post('floor_no'),
						'no_of_sections'	=> $this->input->post('no_of_sections'),
						'business_id'		=> $this->input->post('branch')
					);
		$this->db->insert("floor_chart",$data);			
		return $this->db->insert_id();
	}
	function getPromocode($phone,$bid){
		$sql="select c.phone_no,bc.business_id,p.promocode,p.disc_on_cur_bill,p.disc_on_last_bill,p.disc_on_group,p.disc_on_freq_cust,
p.disc_percent,p.discount_type from customer c
left join business_customer bc on bc.customer_id=c.customer_id
join promotion p on p.promotion_id=bc.promotion_id
where c.phone_no='$phone' and bc.business_id='$bid' group by c.customer_id";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	function table_unique($fid,$tno){
		$sql="select * from table_info where floor_id='$fid' and table_no='$tno'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	function getEstablishedYear($bid){
		$this->db->reconnect();
		$sql="select created_ts from business_entity where business_id='$bid'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
}
?>