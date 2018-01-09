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
	 public function get_branches_list($business_id)
	 {
	 $sql="select * from business_entity where relationship_id='$business_id'";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	 public function get_floors_list($business_id,$have_branches)
	 {
		$sql="select f.* ,b.business_name as branch from business_entity b inner join floor_chart f on b.business_id = f.business_id
		where b.business_id ='$business_id' ";		
		if($have_branches == 'No')
		{
			$sql .= "and b.have_branches='No'";
		}
		
		$sql .= "union select f.*,be.business_name from business_entity be inner join floor_chart f on be.business_id = f.business_id where be.relationship_id = '$business_id' ";		
		if($have_branches == 'No')
		{
			$sql .= "and be.have_branches='No'";
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
	 public function reservation_list($business_id,$hb,$rel_id)
	 {		
		$sql="select * from reservation where ";		
		if($hb == 'No')
		{
			$sql .= "(business_id='$business_id' and brnch_id='$business_id')";
		}
		else if($hb == "")
		{
			$sql .= "(business_id='$rel_id' and brnch_id='$business_id') ";
		}
		else
		{
			$sql .= "(business_id='$business_id' or brnch_id='$business_id')";
		}
		
		$sql .= "  and confirmed='0' and status='0'";
		$res = $this->db->query($sql);
		return $res->result_array(); 
		 
	 }
	 
	 public function res_list($business_id)
	 {
		$sql="select tf.name,tf.phone_no,tf.in_time,tf.table_for,tf.booked_date,tf.reservation_id,f.floor_no,be.business_name,t.table_no,tf.confirmed from reservation tf inner join floor_chart f on f.floor_id=tf.floor inner join table_info t on t.table_id=tf.table_id inner join business_entity be on be.business_id = f.business_id where (tf.business_id='$business_id' or tf.brnch_id='$business_id') and confirmed='1' and status='1' order by tf.booked_date desc";
		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 
	 
	 public function get_users_list($business_id,$have_branches)
	 {
		$sql="select * from user_details where business_id='$business_id'";
		if($have_branches == 'No')
		{
			$sql .= " and branch_id='$business_id'";
		}
		else
		{
			$sql .= " or branch_id='$business_id'";
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
	
	public function update_user($uid,$user_type)
	{
		
		$data = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email_phn'),
			"user_type_id" => $user_type,
			'branch_id' => $this->input->post('branch')
			);
		
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
	 
}
?>
