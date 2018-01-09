<?php
class Users_model extends KM_Model { 
	 function __construct()
	 {
	 	parent::__construct(); 
	 }
	 
	 public function get_business_types()
	 {
	 $sql="select * from business_types";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
	 
	 
	 }
	 public function get_zones()
	 {
	 $sql="select * from zone";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	 public function get_country()
	 {
	 $sql="select * from zone";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	 public function get_customerinfo()
	 {
	 $sql="select * from zone";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	  public function get_zone($city)
	 {
	 //$sql="select * from business_entity where relationship_id='$business_id'";
	 $sql="select * from timezonebyzipcode where city like '%$city%'";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	 public function get_branches_list($business_id)
	 {
	 //$sql="select * from business_entity where relationship_id='$business_id'";
	 $sql="select * from business_entity where (business_id='$business_id' or relationship_id='$business_id' )";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	 public function get_floors_list($business_id,$have_branches)
	 {
		$sql="select f.* ,b.business_name as branch from business_entity b inner join floor_chart f on b.business_id = f.business_id inner join sections s on s.business_id=b.business_id and s.floor_id=f.floor_id 
		where b.business_id ='$business_id' union select f.*,be.business_name from business_entity be inner join floor_chart f on be.business_id = f.business_id inner join sections s on s.business_id=be.business_id and s.floor_id=f.floor_id where ";
		
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
	 
	  // public function get_floors_list1($business_id,$rel_id)
	// {
		// $sql="select * from floor_chart where business_id='$business_id' or business_id='$rel_id'";
		// $res = $this->db->query($sql);	
		// return $res->result_array(); 
		 
	 // }
	 
	 public function get_tables_list($business_id)
	 {
	 $sql="select * from table_info tf left join floor_chart ft on ft.floor_id=tf.floor_id and ft.business_id=tf.business_id  where tf.business_id='$business_id'";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	  // Code Added By Leela Kumar.
	 public function reservation_list($business_id,$hb)
	 {	
       $date=date('Y-m-d');	 
		/*$sql="select * from reservation where ";
		if($hb == '0')
		{
			$sql .= "(business_id='$business_id' and relationship_id is null)";
		}
		else
		{
			$sql .= "(business_id='$business_id' or relationship_id='$business_id')";
		}
		$sql .= "  and confirmed='0' and status='0' and booked_date>='$date' order by booked_date desc,in_time desc";*/
		
		
		$date=date('Y-m-d');	 
		$date_t=date('d-F');	 
		$sql="select a.* , ifnull(ifnull(b.booked_date, c.booked_date),'') last_visited
		 from 
		(select *,if(tf.date_of_birth='".$date_t."',1,0)is_dob,ifnull(tf.date_of_birth,'')date_of_birth1, ifnull((select count(phone_no) from  reservation_archive where  tf.phone_no= phone_no and tf.business_id = business_id and confirmed='1'),0)
+ ifnull((select count(phone_no) from  reservation where  tf.phone_no= phone_no and tf.business_id = business_id and confirmed='1' ),0)
visits,ifnull((select is_vip from reservation
where  (business_id='$business_id' or relationship_id='$business_id')  and is_vip is not null and tf.phone_no = phone_no 
union all 
select is_vip from reservation_archive ra
where  (business_id='$business_id' or relationship_id='$business_id')  and is_vip is not null and tf.phone_no = ra.phone_no 
order by reservation_id desc limit 1
) ,0) as is_vip1 from reservation tf where ";
		if($hb == '0' || $hb=="")
		{
			$sql .= "(business_id='$business_id')";
		}
		else
		{
			$sql .= "(business_id='$business_id' or relationship_id='$business_id')";
		}
		$sql .= "  and confirmed='0' and status='0' and booked_date>='$date' order by booked_date asc,in_time asc)a
		left join (select max(booked_date) booked_date, phone_no from reservation where ";
		if($hb == '0' || $hb=="")
		{
			$sql .= "(business_id='$business_id')";
		}
		else
		{
			$sql .= "(business_id='$business_id' or relationship_id='$business_id')";
		}
		$sql .= " and confirmed =1 group by phone_no ) b on a.phone_no = b.phone_no
		left join (select max(booked_date) booked_date,phone_no from reservation_archive where ";
		if($hb == '0' || $hb=="")
		{
			$sql .= "(business_id='$business_id')";
		}
		else
		{
			$sql .= "(business_id='$business_id' or relationship_id='$business_id')";
		}
		$sql .= " and confirmed =1 group by phone_no ) c on a.phone_no = c.phone_no"; 
		
		$res = $this->db->query($sql);
		return $res->result_array(); 
		 
	 }
	 
	 public function res_list($business_id,$hb,$date_t)
	 {
	    $date=date('Y-m-d');
		/*$sql="select tf.name,tf.phone_no,tf.in_time,tf.table_for,tf.booked_date,tf.reservation_id,f.floor_no,be.business_name,t.table_no,tf.confirmed,t.table_type,if(date_format(tf.date_of_birth,'%m-%d')='".$date_t."',1,0)date_of_birth,ifnull(date_format(tf.date_of_birth,'%d-%m-%Y'),'')date_of_birth1,is_vip, ifnull((select count(phone_no) from  reservation_archive where  tf.phone_no= phone_no and tf.business_id = business_id and confirmed='1'),0)
+ ifnull((select count(phone_no) from  reservation where  tf.phone_no= phone_no and tf.business_id = business_id and confirmed='1' ),0)
visits from reservation tf inner join floor_chart f on f.floor_id=tf.floor inner join table_info t on t.table_id=tf.table_id inner join business_entity be on be.business_id = f.business_id where ";
		if($hb == '0')
		{
			//$sql .= "(tf.business_id='$business_id' and tf.relationship_id is null)";
			$sql .= "(tf.business_id='$business_id' )";
		}
		else
		{
			$sql .= "(tf.business_id='$business_id' or tf.relationship_id='$business_id')";
		}
		
		$sql .=" and confirmed='1' and status='1' and booked_date >='$date' order by tf.booked_date asc,tf.in_time asc";*/
		$date_t=date('d-F');
		$sql="select tf.name,tf.phone_no,tf.in_time,tf.table_for,tf.booked_date,tf.reservation_id,f.floor_id,f.floor_no,be.business_name,t.table_no,tf.confirmed,t.table_type, if(tf.date_of_birth='".$date_t."',1,0)date_of_birth,ifnull(tf.date_of_birth,'')date_of_birth1, is_vip, tf.parent_reservation,(select GROUP_CONCAT(tbf.table_no) from reservation r join table_info tbf on tbf.table_id = r.table_id where tf.reservation_id = r.parent_reservation  or tf.reservation_id=r.reservation_id) table_nos, (select count(phone_no) from  reservation_archive where  tf.phone_no= phone_no and tf.business_id = business_id )visits from reservation tf inner join floor_chart f on f.floor_id=tf.floor inner join table_info t on t.table_id=tf.table_id inner join business_entity be on be.business_id = f.business_id where ";
		if($hb == '0'  || $hb=="")
		{
			//$sql .= "(tf.business_id='$business_id' and tf.relationship_id is null)";
			$sql .= "(tf.business_id='$business_id' )";
		}
		else
		{
			$sql .= "(tf.business_id='$business_id' or tf.relationship_id='$business_id')";
		}
		
		$sql .=" and confirmed='1' and status='1' and tf.parent_reservation is null and booked_date >='$date' order by tf.booked_date desc,tf.in_time asc";

		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 
	 
	 public function get_users_list($business_id,$have_branches)
	 {
		$sql="select u.*,rs.role_name from business_entity be inner join user_details u on be.business_id = u.business_id inner join role_permissions rs on u.user_type_id=rs.role_id where u.business_id='$business_id' 
			union 
			select u.*,rs.role_name from business_entity be inner join user_details u on be.relationship_id = u.relationship_id inner join role_permissions rs on u.user_type_id=rs.role_id where ";
		if($have_branches == 0)
		{
			$sql  .= "u.relationship_id =''";
		}
		else
		{
			$sql  .= "u.relationship_id ='$business_id'";
		}
		$res = $this->db->query($sql);	
		return $res->result_array();
	 }
	 
	 public function get_user_info($uid)
	 {
		$sql="select * from user_details where user_id='$uid'";
		$res = $this->db->query($sql);	
		return $res->result_array();
	 }
	
	public function update_user($uid,$data)
	{		
		$this->db->where('user_id', $uid);
		$this->db->update('user_details', $data);
		return true;
	}
	
	public function create_password($bid,$new)
	{
		$data = array(
			'password' => $new,
			);		
		$this->db->where('business_id', $bid);
		$this->db->update('business_entity', $data);
		return true;
	}
	
	public function create_user_password($uid,$new)
	{
		$data = array(
			'password' => $new,
			);		
		$this->db->where('user_id', $uid);
		$this->db->update('user_details', $data);
		return true;
	}
	
	public function create_branch_password($branch_id,$new)
	{
		$data = array(
			'password' => $new,
			);	
			
		$this->db->where('business_id', $branch_id);
		$this->db->update('business_entity', $data);
		return true;
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
	
	public function pswd_match($business_id)
	{
		$sql = "select password from business_entity where business_id='$business_id'";
		$res = $this->db->query($sql);	
		return $res->result_array();
	}
	 
	 public function delete_user($uid)
	 {
		$sql="delete from user_details where user_id='$uid'";
		$res = $this->db->query($sql);	
		return $res->result_array();
	 }	
	 public function reservation_count($business_id,$hb)	 
	 {	       
	 $date=date('Y-m-d');	 		
	 $sql="select count(*) cnt from reservation where ";		
	 if($hb == '0')		{			
	 $sql .= "(business_id='$business_id' )";		
	 }		
	 else		
	 {			
	 $sql .= "(business_id='$business_id' or relationship_id='$business_id')";		
	 }		
	 $sql .= "  and confirmed='0' and status='0' and booked_date>='$date'  ";
	// echo $sql;	
	 $res = $this->db->query($sql);		
	 return $res->result_array(); 		 	 
	 }	 	
	 public function res_count($business_id,$hb)	 {	    $date=date('Y-m-d');		$sql="select count(tf.name) as cnt from reservation tf inner join floor_chart f on f.floor_id=tf.floor inner join sections s on tf.section_id=s.section_id inner join table_info t on t.table_id=tf.table_id inner join business_entity be on be.business_id = f.business_id where ";		if($hb == '0')		{			
	 //$sql .= "(tf.business_id='$business_id' and tf.relationship_id is null)";			
	 $sql .= "(tf.business_id='$business_id' )";		}		
	 else		
	 {			$sql .= "(tf.business_id='$business_id' or tf.relationship_id='$business_id')";		}			
	 $sql .=" and confirmed='1' and status='1' and booked_date >='$date' and tf.parent_reservation is null  order by tf.booked_date desc,tf.in_time desc";
	 //echo $sql;		
	 $res = $this->db->query($sql);			
	 return $res->result_array(); 	 
	 }
}
?>
