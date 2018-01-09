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
	 public function get_floors_list($business_id)
	 {
	 $sql="select * from floor_chart where business_id='$business_id'";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	 public function get_tables_list($business_id,$floor_id)
	 {
	  $sql="select * from table_info tf left join floor_chart ft on ft.floor_id=tf.floor_id and ft.business_id=tf.business_id  where tf.business_id='$business_id' and tf.floor_id='$floor_id'";
	 $res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	 
	 public function reservation_list($business_id)
	 {
		$sql="select * from reservation tf   where tf.business_id='$business_id'";
		$res = $this->db->query($sql);	
		return $res->result_array(); 
		 
	 }
	 
	 public function add_user()
	 {
		
	 }
}
?>
