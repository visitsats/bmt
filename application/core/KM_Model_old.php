<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model Class
 * @category	Libraries
 * @author		Knowledge Matrix Dev Team
 */
class KM_Model extends CI_Model {
/**
 * Initialize the table
 *
 * @var bool
 */
       var $table=null;
	   var $model=null;
/**
 * Constructor
 *
 * @access public
 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database(); 
	}	
/**	 
 * Retrieves all records from the table specific to the model.
 *	 	  
 * @access	public
 * @param	Void	
 * @return	multi dimentional array object (If no records found it will retrun false)
 */
	 function KM_all($options=array(),$obj_type=FALSE)
	 {
	    $conditions=array();
		//pr($options);exit;
		if(isset($options['class'])){
		    $table=$this->db->dbprefix.$options['class'];
		}
		else{
		   $table=$this->table;
		}
		
		if(isset($options['limit'])){
		   $offset=0; 
		  if(isset($options['offset'])){
		     $offset=$options['offset'];
		  }
		  $this->db->limit($options['limit'],$offset);
		}
		
		if(isset($options['order'])){
		   $this->db->order_by($table.'.'.$options['order']);
		}
		if(isset($options['conditions'])){
		   if(isset($options['conditions_prefix']) && $options['conditions_prefix']==false){
		     $this->db->where($options['conditions']);
		   }else{
		   	   $this->db->where($this->_conditions($options['conditions'],$table));
		    }		   
		}
		
		if(isset($options['search_conditions'])){
     		$this->db->where($options['search_conditions'],NULL, FALSE);
		}
		if(isset($options['joins'])){
		  $joins=$options['joins'];
		  foreach($joins as $join){
		     $type=''; 
			 if(isset($join['type']))
		        $type=$join['type'];
			$join_table=$this->db->dbprefix($join['class']);
			if(isset($join['join_and_cond'])){
				$this->db->join($join_table,$join_table.'.'.$join['primaryKey'].'='.$table.'.'.$join['foreignKey']." and ".$join_table.'.'.$join['join_and_cond']["field"]." = ".$join['join_and_cond']["value"]  ,$type);
			}
			else{	
            	$this->db->join($join_table,$join_table.'.'.$join['primaryKey'].'='.$table.'.'.$join['foreignKey'],$type);
			}
			if(isset($join['conditions'])){
   			  $this->db->where($this->_conditions($join['conditions'],$join_table));
			}
		  }	  		
		}
		
		if(isset($options['select'])){
		$this->db->select($options['select']);
		}
		else if(isset($options['fields'])){
		   $fields_prefix=(isset($options['fields_prefix']))?$options['fields_prefix']:TRUE;
		   
		   $this->db->select($this->_fields($options['fields'],$table,$fields_prefix));
		}
		if(isset($options['groupby']))
		$this->db->group_by($options['groupby']);
		$query=$this->db->get($table);
		
		if ($query->num_rows() > 0)
		{
		   if($obj_type){
		      return $query->result();
		   }
		   else{
		      return $query->result_array();
		   }	  		    
		}
		else
		{
			return array();
		} 
	 }
/**	 
 * Retrieves all records from the table specific to the model.
 *	with joins 	  
 * @access	public
 * @param	Void	
 * @return	multi dimentional array  (If no records found it will retrun false)
 */
	function KM_find($options=array())
	 {
	 
	    if(isset($options['class'])){
		    $table=$this->db->dbprefix.$options['class'];
		}
		else{
		   $table=$this->table;
		}
		$this->model=$this->_model_generate($table); 
		
		if(isset($options['limit'])){
		  if(isset($options['offset'])){
		  	$this->db->limit($options['limit'],$options['offset']);
		  }else{
		  	$this->db->limit($options['limit']);
		  }
		}
		if(isset($options['order'])){
		   $this->db->order_by($options['order']);
		}
		if(isset($options['conditions'])){
		   $tmp_keys=array_keys($options['conditions']);
		   $conditions=array();
		   $i=0;
		   while(count($tmp_keys)>$i){
		      $temp_key=$tmp_keys[$i];
		      $tmp_keys[$i]=$table.'.'.$tmp_keys[$i];
			  $conditions[$tmp_keys[$i]]=$options['conditions'][$temp_key];
		      $i++;
		   }
		   $this->db->where($conditions);
		}
		if(isset($options['search_conditions'])){
     		$this->db->where($options['search_conditions'],NULL, FALSE);
		}
	    if(isset($options['fields'])){
		   $this->db->select($this->_prefix_table_fields($table,$options,$options['fields']));
		}
		else{
           $this->db->select($this->_prefix_table_fields($table,$options));		
         }
		$this->db->from($table);
		if(isset($options['joins'])){
		   foreach($options['joins'] as $join){
		   $type=isset($join['type'])?$join['type']:'';
		   $join_table=$this->db->dbprefix($join['class']);
		      $this->db->join($join_table,''.$join_table.'.'.$join['primaryKey'].'='.$table.'.'.$join['foreignKey'].'',$type);
			  if(isset($join['conditions'])){
   			    $this->db->where($this->_conditions($join['conditions'],$join_table));
			  }
		   }
		}
		 
		$query=$this->db->get();
		if ($query->num_rows() > 0)
		{
		   $result=array();
		   $tmp_result=$query->result_array();
		   //pr($tmp_result);exit;
		   $i=0;
			while(count($tmp_result)>$i){
				$result[$i]=$this->_array_generation($tmp_result[$i]);
			    $i++;		
			}
			if(isset($options['joins']) && count($options['joins'])>0){
			foreach($options['joins'] as $hasmany_joins){
			
			      if(isset($hasmany_joins['hasMany']) && $hasmany_joins['hasMany']==1){
				       $hasmany_model=$this->_model_generate($this->db->dbprefix.$hasmany_joins['class']);
					   			$j=0;
                         $temp_foreignkeys_values=array();
					   foreach($result as $key=>$temp_value){
							if(in_array($temp_value[$this->model][$hasmany_joins['foreignKey']],$temp_foreignkeys_values)){
						    $temp_foreignkey_key=array_search($temp_value[$this->model][$hasmany_joins['foreignKey']], $temp_foreignkeys_values);
								$result[$temp_foreignkey_key][$hasmany_model][]=$temp_value[$hasmany_model];
								unset($result[$key]);
							}
							else{
							        unset($result[$key][$hasmany_model]);
                                     $result[$j][$hasmany_model][]=$temp_value[$hasmany_model];
							      $temp_foreignkeys_values[$key]=$temp_value[$this->model][$hasmany_joins['foreignKey']];
							}
						$j++; 
					       
					   }
					   
				  }
			}
		  }	
			
		   return array_values($result);		    
		}
		else
		{
			return array();
		} 
	 }
	 
/**	 
 * Retrieves particular record from the table specific to the model.
 *	 	  
 * @access	public
 * @param	Void	
 * @return	single dimentional array object (If no records found it will retrun false)
 */
	 function KM_first($options=array(),$obj_type=FALSE)
	 {
      
	   $options['limit']=1;
	    $result=$this->KM_all($options,$obj_type);
		
		if ($result)
		{
		   return $result[0];		    
		}
		else
		{
			return array();
		} 
	 }
	 	 
/**	 
 * Retrieves particular record from the table specific to the model.
 *	 	  
 * @access	public
 * @param	Void	
 * @return	single dimentional array object (If no records found it will retrun false)
 */
	 function KM_read($options=array())
	 {
      
	   $options['limit']=1;
	    $result=$this->KM_find($options);
		
		if ($result)
		{
		   return $result[0];		    
		}
		else
		{
			return array();
		} 
	 }
/**	 
 * Retrieves a record from the table specific to the model.
 *	 	  
 * @access	public	 
 * @param1	need to pass where conditions in array, array key and value should be table field name and compaire value respectively. * @return	single dimentional array object (If no records found it will retrun false)
 */	
	function KM_getSingleRow($where=array(),$options=array())
	 { 			
		if(is_array($where))
		{
			$where_cond="";
			foreach($where as $key=>$value)
			{
				if($where_cond !="") $where_cond.=" and ";
				$where_cond.=$key."='".$value."'";
			}
			$where=$where_cond;
		}		
		if(isset($options['class']))		 
			$table = $this->db->dbprefix($options['class']);		 
		else
			$table = $this->table;
	 	
		$sql="select * from $table where $where limit 0,1 ";		
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
		   return $query->row();		    
		}
		else
		{
			return array();
		} 
		 
	 }	
	
/**	 
 * Retrieves all records from the table specific to the model.
 *	 	  
 * @access	public
 * @param1	number of records
 * @param2	offset  
 * @param3	sorted by field name.
 * @param4	ASC or DESC 
 * @return	multi dimentional array object (If no records found it will retrun false)
 * Specialy used for manage page 
 */	
	function KM_getDataList($limit,$offset,$sort_by,$sort_order)
	 {
	 	//result query
		$sort_order=($sort_order=='desc')?'desc':'asc';
		$sort_columns=array('id','name');   
		//table columns
		$sort_by=(in_array($sort_by,$sort_columns))?$sort_by:'id';
	    $sql="SELECT  * from $table order by $sort_by $sort_order limit $offset, $limit "; 	   
	   	$query = $this->db->query($sql);	    
	   	$result['rows']= $query->result();	 
		  
	   	//count query
	  	$this-> db -> select("COUNT(*) AS count",FALSE);
	  	$this-> db -> from($table);
	  	$query = $this -> db -> get();		 	 
	  	$tmp = $query->result();	 
	 
	 	$result['num_rows'] = $tmp[0] -> count;		
	 	return $result;	  
	 } 	
/**	 
 * Retrieves all records from the table specific to the model.
 *	 	  
 * @access	public
 * @param	array of data to be inserted, Array key should be table field name and value will be value for the field 	 
 * @return	Boolean	 
 */			
	  function KM_save($options=array())
	 {	
	  
		if(isset($options['class'])){
		  $table=$this->db->dbprefix.$options['class'];
		}
		else{
		   $table=$this->table;
		}
		
		if(isset($options['series'])){
              $primaryKey=$this->__generate_code($options['series'],$options['primaryKey']);			 
			  $options['insert']=array_merge($options['insert'],$primaryKey);	
		}
		
	    if(!empty($options['insert'])){ 			
			if($this->db->insert($table, $options['insert'])){	
			   if(isset($options['series'])){
			      return $primaryKey[$options['primaryKey']];
				}
				else if(isset($options['return_id']) && $options['return_id']){
				 return $this->db->insert_id();
				}
				  return true;
		    }
			
			else{
                 return false;			
			}		
		}
		else{
		    return false;
		}
	 }
	 
	
/**	 
 * Retrieves edit records from the table specific to the model.
 *	 	  
 * @access	public
 * @param1 	array of data to be updated, Array key should be table field name and value will be value for the field
 * @param2 	where condition in array , Array key should be table field name and value will be value for the field
 * @return	Boolean	 
 */	
		
	 function KM_update($options=array(),$where=array())
	 {
		if(isset($options['class'])){
		   $table=$this->db->dbprefix.$options['class'];
	    }
		else{
		   $table=$this->table;
		}
		if(!empty($options['update']) && !empty($where))
		{
			$update=$this->db->update($table,$options['update'],$where);
			return $update;
		}
		else
		{
			return false;
		}
	 }
		
/**	 
 * Retrieves delete records from the table specific to the model.
 *	 	  
 * @access	public	
 * @param1 	where condition in array , Array key should be table field name and value will be value for the field
 * @return	Boolean	 
 */	
	 function KM_delete($options=array())
	 {	    
		if(isset($options['class'])){
		    $table=$this->db->dbprefix.$options['class'];			
		} 		
		else
		{
			$table= $this->table;
		}			
		if(!empty($options))
		{
			$delete=$this->db->delete($table,$options['conditions']);
			return $delete;	
		}
		else
		{
			return false;
		}	
	 }
/**	 
 * Retrieves delete records from the table specific to the model.
 *	 	  
 * @access	public	
 * @param1 	where condition in array , Array key should be table field name and value will be value for the field
 * @return	Boolean	 
 */	
	function KM_check_duplicate($options=array())
	 {
	 	if(!empty($options['where']))
		{
			$this->db->select('*');
			
			if(isset($options['class']))
			{
				$table=$this->db->dbprefix.$options['class'];			
			} 		
			else
			{
				$table= $this->table;
			}
			
			$this->db->from($table);
			$this->db->where($options['where']);		 
			$query = $this->db->get();
			$result= $query->result();		
			return count($result);
		}
		else
		{
			return false;
		}
	 }
/**	 
 * Retrieves number of records are exist in that particular table.
 * @access	public	
 * @param1 	where condition in array , Array key should be table field name and value will be value for the field
 * @return	Integer	 
 */	
	function KM_count($options=array()){
	    if(isset($options['class'])){
		    $table=$this->db->dbprefix.$options['class'];
		}
		else{
		    $table=$this->table;
		}
		if(isset($options['search_fields'])){
		$tmp_fields='';
		   foreach($options['search_fields'] as $tmp){
	        $tmp_fields .=$table.".".$tmp." LIKE '%".$this->db->escape_like_str($options['keyword'])."%' OR ";
	      }
		  $search_conditions=substr($tmp_fields,0,-4);
          $this->db->where($search_conditions,NULL, FALSE);
		}
		if(isset($options['conditions'])){
		   if(isset($options['conditions_prefix']) && $options['conditions_prefix']==false){
		     $this->db->where($options['conditions']);
		   }else{
		   	   $this->db->where($this->_conditions($options['conditions'],$table));
		    }		   
		}
	    if(isset($options['joins'])){
			  $joins=$options['joins'];
			  foreach($joins as $join){
				 $type=''; 
				 if(isset($join['type']))
					$type=$join['type'];
				$join_table=$this->db->dbprefix($join['class']);	
				$this->db->join($join_table,$join_table.'.'.$join['primaryKey'].'='.$table.'.'.$join['foreignKey'],$type);
				if(isset($join['conditions'])){
				  $this->db->where($this->_conditions($join['conditions'],$join_table));
				}
			  }	  		
		 }
		  $count=$this->db->count_all_results($table);
		  return  $count; 
	}
/**	 
 * Retrieves number of records are exist in that particular table using the search keyword.
 * @access	public	
 * @param1 	options condition in array , Array key should be table field name and value will be value for the field
 * @return	Integer	 
 */		
	function KM_search($options=array(),$obj_type=FALSE){
	  if(isset($options['class'])){
		    $table=$this->db->dbprefix.$options['class'];
		}
		else{
		    $table=$this->table;
		}
	  $tmp_fields='';
	  foreach($options['search_fields'] as $tmp){
	     $tmp_fields .=$table.".".$tmp." LIKE '%".$this->db->escape_like_str($options['keyword'])."%' OR ";
		  }
	  //$conditions="MATCH (".$fields.") AGAINST ('".$options['keyword']."*' IN BOOLEAN MODE) OR ".substr($tmp_fields,0,-4);
	  $conditions=substr($tmp_fields,0,-4);
	  $options['search_conditions']=$conditions;
	  $result=$this->KM_all($options,$obj_type);	
		return $result;		
	}
     //Check the record is exists or not in the database	
	function KM_exists($options=array()){
	    return ($this->KM_count($options) > 0);
	}
	
	
	
	
	function __generate_code($series,$field)
	{
		$res= $this->db->query("select cws_generate_codes('".$series."') as $field");
		$result=$res->result_array();
		return $result[0];
   }
   
   
   function _prefix_table_fields($table,$options=array(),$fields=array()){
          $tmp_fields='';	 
		   $tmp_model=$this->_model_generate($table);
		  //pr($parent_table_fields);exit;
		  if(empty($fields)){
		      $parent_table_fields=$this->db->list_fields($table);
		  }
		  else{
		      $parent_table_fields=$fields;
		  }
		  foreach($parent_table_fields as $pfields){
		       $tmp_fields.=$table.'.'.$pfields.' as '.$tmp_model.'__'.$pfields.',';
		  }
          if(isset($options['joins']) && count($options['joins'])>0){
		      foreach($options['joins'] as $join){
			     $tmp_join_table=$this->db->dbprefix.$join['class'];
				 $tmp_join_model=$this->_model_generate($tmp_join_table);
				 $join_table_fields=$this->db->list_fields($tmp_join_table);
				 foreach($join_table_fields as $jfields){
				    $tmp_fields.=$tmp_join_table.'.'.$jfields.' as '.$tmp_join_model.'__'.$jfields.',';
				 }
			  }   
		  }	
		  $tmp_fields=substr($tmp_fields,0,-1);
		  return $tmp_fields;     
	 
	 }
	 
	 function _array_generation($array){
	     $temp_res=array();
			    foreach($array as $key=>$result_tmp){
				   $tmp_reult_field=explode('__',$key);
				   $temp_res[$tmp_reult_field[0]][$tmp_reult_field[1]]=$result_tmp;
				}
		return 	$temp_res;	
	 
	 }
	 
	 function _model_generate($table){
	 	$tmp_class=explode($this->db->dbprefix,$table);
		return ucfirst($tmp_class[1]); 
	 }
	 
	 function _conditions($conditions=array(),$table){
	       $tmp_conditions=array();
		   foreach($conditions as $key=>$conditon_value){
			 $tmp_conditions[$table.'.'.$key]=$conditon_value;
		   }
	     return $tmp_conditions;
	 }
     function _fields($fields=array(),$table,$fields_prefix=TRUE){
		 $tmp_fields='';
		   foreach($fields as $field){
		     if($fields_prefix){
			   $tmp_fields.=$table.'.'.$field.',';
			 }else{
			   $tmp_fields.=$field.',';
			 }
		   }
	     return substr($tmp_fields,0,-1);
    }
	
	
	 function call_procedure($sql){
	 
		 $sp_data = $this->db->query("CALL $sql");
		 return $sp_data->result();
    }
	
	function lastInsertedId() {
    	return $this->db->insert_id();
	}
	
}
?>