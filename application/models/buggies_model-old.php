<?php
class Buggies_model extends KM_Model { 
	 function __construct(){
	 	parent::__construct(); 
	 }
	 
	 public function outletsAbstract(){ 
		 $sql="select
		  o.ol_id, o.outlet,
		  count(distinct a.qrcid) scanned_qrc
		  from outlets o
		  inner join retailer r on o.retid=r.retid
		  left join qrc q on r.retid = q.retid
		  left join act_log a on q.qrcid = a.qrcid
		where q.retid='".$this->admin_session['retid']."' and  a.action = 'scan'
		group by r.retid order by r.retname";
		
		$query=$this->db->query($sql);	
		return $query->result_array();	 
	 }
	 
	 
	 public function customersUsages($offset,$limit){
	 
		 $outlet=$this->input->post('outlet');
		
		 $sql="select u.id, username, email,date(actdt) actdt,  ifnull(count(distinct l.qrcid),0) smt_qr_scanned ,ifnull(count(q.log_id),0) other_qr_scanned,  count(distinct f.qrcid) fav, count(distinct qr.retid) ret
			from user u
			left join act_log l on  u.id=l.userid  and l.qrcid !=0
			left join qrc qr on qr.qrcid=l.qrcid
			left join  qr_data q on l.logid = q.log_id
			left join  favs f on f.userid=u.id and f.qrcid=l.qrcid
			where u.role=2 and username!='' and qr.retid = '".$this->admin_session['retid']."' ";
		if($outlet) $sql.=" and qr.locid= $outlet";
		$sql.=" group by u.id  
			order by username limit $offset,$limit";
		
		$query=$this->db->query($sql);	
		return $query->result_array();	 
	 }	 
	 
	 public function customersUsages_count(){
	 
		 $outlet=$this->input->post('outlet');
		 
		 $sql="select count(*) num_rec from(
		 select u.id from user u
			left join act_log l on  u.id=l.userid  and l.qrcid !=0
			left join qrc qr on qr.qrcid=l.qrcid
			left join  qr_data q on l.logid = q.log_id
			left join  favs f on f.userid=u.id and f.qrcid=l.qrcid
			where u.role=2 and username!='' and qr.retid = '".$this->admin_session['retid']."' ";
		 if($outlet) $sql.=" and qr.locid= $outlet";	
		$sql.=" group by u.id  
			order by username )a ";
		
			$query=$this->db->query($sql);	
			$data = $query->result_array();	 
			return isset($data[0]['num_rec'])?$data[0]['num_rec']:0;
	 }
	 
	  public function customersUsageCounts(){
	 
		 $outlet=$this->input->post('outlet');
		 
		 $sql="
		 select

  count(distinct a.qrcid)    smt_scanned,count(distinct qd.log_id) other_scanned, count(a.qrcid) active_product, count(distinct f.qrcid) tot_fav, count(distinct q.locid) tot_outlets
from outlets o
  inner join retailer r on o.retid = r.retid
  inner join qrc q on r.retid = q.retid
  inner join act_log a on q.qrcid = a.qrcid
  left join favs f on f.qrcid=q.qrcid  and f.isfavstill=1 and f.userid>1
  left join  qr_data qd on a.logid = qd.log_id
where q.retid = '".$this->admin_session['retid']."' and a.action = 'scan' and a.userid>1 ";
		
		 
		$query=$this->db->query($sql);	
		$data = $query->result_array();	
		return isset($data[0])?$data[0]:array("smt_scanned"=>0,"other_scanned"=>0,"tot_fav"=>0,"tot_ret"=>0); 
	 }
	 
	 
	 public function favourites($offset,$limit){
	 
		 $outlet=$this->input->post('outlet');
		 $cat=$this->input->post('cat');
		 
		 $catid=0;
		 if(strpos($cat,'_') !== false){
		 	$catdata = explode('_',$cat); 
			$catid=$catdata[0];
			$subcatid=$catdata[1]; 
		 }
		 else{
		 	$catid=$cat;
			$subcatid=0;		 
		 }
		
		 $sql="select p.pname,f.qrcid,q.pid, count(distinct f.userid) as totfav, o.outlet,q.price,a.actdt
				from product p
				inner join qrc q on p.pid=q.pid
				inner join favs f on f.qrcid=q.qrcid
				inner join retailer r on q.retid=r.retid
				inner join act_log a on a.qrcid=q.qrcid 
				inner join subcat s on s.scatid=p.subcat
				inner join outlets o on o.ol_id = q.locid
				where f.isfavstill=1 and f.userid is not null and q.retid='".$this->admin_session['retid']."'";
				
				if($outlet) $sql.=" and q.locid= $outlet ";
				if($subcatid!=0) $sql.=" and p.subcat= $subcatid ";
				if($catid!=0) $sql.=" and s.catid= $catid ";
				
		$sql.=" group by q.pid
				order by a.actdt desc, p.pname asc limit $offset,$limit";
		
		$query=$this->db->query($sql);	
		return $query->result_array();	 
	 }
	 
	 
	 public function favourites_count(){
	 
		 $outlet=$this->input->post('outlet');
		 $cat=$this->input->post('cat');
		 
		 $catid=0;
		 if(strpos($cat,'_') !== false){
		 	$catdata = explode('_',$cat); 
			$catid=$catdata[0];
			$subcatid=$catdata[1]; 
		 }
		 else{
		 	$catid=$cat;
			$subcatid=0;		 
		 }
		 
		 $sql="select count(*) num_rec from(
		 select p.pname,f.qrcid,q.pid, count(distinct f.userid) as totfav, o.outlet,q.price,a.actdt
				from product p
				inner join qrc q on p.pid=q.pid
				inner join favs f on f.qrcid=q.qrcid
				inner join retailer r on q.retid=r.retid
				inner join act_log a on a.qrcid=q.qrcid 
				inner join subcat s on s.scatid=p.subcat
				inner join outlets o on o.ol_id = q.locid
				where f.isfavstill=1 and f.userid is not null  ";
				
				if($outlet) $sql.=" and q.locid= $outlet ";
				if($subcatid!=0) $sql.=" and p.subcat= $subcatid ";
				if($catid!=0) $sql.=" and s.catid= $catid ";
				
		$sql.=" group by q.pid
				order by a.actdt desc, p.pname asc   )a ";
		
			$query=$this->db->query($sql);	
			$data = $query->result_array();	 
			return isset($data[0]['num_rec'])?$data[0]['num_rec']:0;
	 } 
	 
	 
	 
	  public function active_product($offset,$limit){
	 
		 $outlet=$this->input->post('outlet');
		 $cat=$this->input->post('cat');
		 
		 $catid=0;
		 if(strpos($cat,'_') !== false){
		 	$catdata = explode('_',$cat); 
			$catid=$catdata[0];
			$subcatid=$catdata[1]; 
		 }
		 else{
		 	$catid=$cat;
			$subcatid=0;		 
		 }
		
		 $sql="select p.pname,q.qrcid,q.pid, count(distinct f.userid) as totfav, o.outlet,q.price,a.actdt
				from product p
				inner join qrc q on p.pid=q.pid
				inner join act_log a on a.qrcid=q.qrcid 
				left join favs f on f.qrcid=q.qrcid
				inner join retailer r on q.retid=r.retid				
				inner join subcat s on s.scatid=p.subcat
				inner join outlets o on o.ol_id = q.locid
				where  a.action='scan'  ";
				
				if($outlet) $sql.=" and q.locid= $outlet ";
				if($subcatid!=0) $sql.=" and p.subcat= $subcatid ";
				if($catid!=0) $sql.=" and s.catid= $catid ";
				
		$sql.=" group by q.pid
				order by a.actdt desc, p.pname asc limit $offset,$limit";
		
		$query=$this->db->query($sql);	
		return $query->result_array();	 
	 }
	 
	 
	 public function active_product_count(){
	 
		 $outlet=$this->input->post('outlet');
		 $cat=$this->input->post('cat');
		 
		 $catid=0;
		 if(strpos($cat,'_') !== false){
		 	$catdata = explode('_',$cat); 
			$catid=$catdata[0];
			$subcatid=$catdata[1]; 
		 }
		 else{
		 	$catid=$cat;
			$subcatid=0;		 
		 }
		 
		 $sql="select count(*) num_rec from(
		 select p.pname,q.qrcid,q.pid, count(distinct f.userid) as totfav, r.retname,q.price,a.actdt
				from product p
				inner join qrc q on p.pid=q.pid
				inner join act_log a on a.qrcid=q.qrcid 
				left join favs f on f.qrcid=q.qrcid
				inner join retailer r on q.retid=r.retid				
				inner join subcat s on s.scatid=p.subcat
				where  a.action='scan'  ";
				
				if($outlet) $sql.=" and q.locid= $outlet ";
				if($subcatid!=0) $sql.=" and p.subcat= $subcatid ";
				if($catid!=0) $sql.=" and s.catid= $catid ";
				
		$sql.=" group by q.pid
				order by a.actdt desc, p.pname asc   )a ";
		
			$query=$this->db->query($sql);	
			$data = $query->result_array();	 
			return isset($data[0]['num_rec'])?$data[0]['num_rec']:0;
	 }
	 
}
?>
