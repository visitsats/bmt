<?php
class Services_model extends KM_Model { 
	 function __construct()
	 {
	 	parent::__construct(); 
	 }
	 
	 public function get_QR_Details($qr_id,$hwid=0,$uid=0){
		 
		 $sql="SELECT
					  qrc.qrcid        'QR ID',
					  qrc.qrc          'QR Data',
					  qrc.feed,
					  qrc.price        'Price',
					  product.pname as 'Product Name', concat('".base_url(QR_IMAGE_PATH)."/',qrc.qrcimgpath ) as Image, 
					  retname          'Retailer',
					  qrc.StreetName,
					  locname          'Location',
					  subcategory      'Subcategory',
					  category	   'Category',
					  if( `favs`.`isfavstill` is null, 0, 1 ) as Favourite,
					   product.url as 'product_url'
					FROM (`qrc`)
					  LEFT JOIN `favs`
						ON `favs`.`qrcid` = `qrc`.`qrcid`";
			if($uid!=0)			
			$sql.= "	and favs.userid = '$uid'";
			elseif($hwid!='')			
			$sql.= "	and favs.hwid = '$hwid'";
						
						  
				$sql.= "	  LEFT JOIN `product`
						ON `product`.`pid` = `qrc`.`pid`
					  inner JOIN `subcat`
						ON `subcat`.`scatid` = `product`.`subcat`
					  inner JOIN `cat`
						ON `cat`.`catid` = `subcat`.`catid`
					  LEFT JOIN `retailer`
						ON `retailer`.`retid` = `qrc`.`retid`
					  LEFT JOIN `location`
						ON `location`.`locid` = `qrc`.`locid`
					WHERE `qrc`.`qrcid` = '$qr_id'
					LIMIT 1 ";
		 
			
		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 
	 public function get_retailers($param=array()){
		 extract($param); 
		 $sql="SELECT   qrc.retid   as 'retailer id', retname    'retaler name', count(distinct qrc.qrcid) as num_products
				FROM (retailer)
				INNER JOIN qrc ON qrc.retid = retailer.retid
				INNER JOIN act_log ON act_log.qrcid = qrc.qrcid AND act_log.action = 'scan'";
				 if(isset($is_fav) and  $is_fav)
         $sql.=" inner join favs f on f.qrcid = qrc.qrcid and f.isfavstill = '1' and f.userid='$uid'  ";		
		 $sql.=" WHERE retailer.isactive = 1 ";
		 if(isset($uid) and  $uid)
		 $sql.=" AND act_log.userid = '$uid' ";
		 if(isset($qrid) and  $qrid)
		 $sql.=" AND act_log.qrcid = '$qrid' ";
		 
		 $sql.="GROUP BY qrc.retid 
				ORDER BY retailer.retname";

		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 
	 public function get_categories($param=array()){
		 extract($param);
		/* $sql="SELECT   cat.catid, category, count(distinct qrc.qrcid) as num_products
				FROM (cat)
				INNER JOIN subcat ON subcat.catid=cat.catid
				INNER JOIN product ON product.subcat=subcat.scatid
				INNER JOIN qrc ON qrc.qrcid = product.pid
				INNER JOIN act_log ON act_log.qrcid = qrc.qrcid AND act_log.action = 'scan'
				WHERE cat.isactive = 1 ";
		 if(isset($uid) and  $uid)
		 $sql.=" AND act_log.userid = '$uid' ";
		 if(isset($qrid) and  $qrid)
		 $sql.=" AND act_log.qrcid = '$qrid' ";
		 
		 $sql.="GROUP BY cat.catid 
				ORDER BY cat.category";*/
		 $sql="SELECT
  qrc.qrcid,cat.catid,
  category,
  count(distinct qrc.qrcid) as num_products
  FROM qrc
  inner join act_log
    on act_log.qrcid = qrc.qrcid
  inner JOIN product
    ON product.pid = qrc.pid
  inner JOIN subcat
    on subcat.scatid = product.subcat
  inner join cat
    on cat.catid = subcat.catid 
  WHERE act_log.action = 'scan' and  cat.isactive = 1";
    if(isset($uid) and  $uid)
		 $sql.=" AND act_log.userid = '$uid' ";
		 if(isset($qrid) and  $qrid)
		 $sql.=" AND act_log.qrcid = '$qrid' ";
    $sql.="  group by cat.catid
ORDER BY cat.category";	
		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 
	  public function get_subcategories($param=array()){
		 extract($param);
		 $sql="select s.scatid    subcat_id,
			  subcategory,
			  count(distinct q.qrcid) as num_products
			  
			  
			from qrc q
			inner join product p on p.pid=q.pid
			inner join subcat s on s.scatid = p.subcat
			inner join act_log a on a.qrcid=q.qrcid";
			 if(isset($is_fav) and  $is_fav)
			$sql.=" left join favs f on f.qrcid=a.qrcid";
			 $sql.=" where a.action='scan' ";
				
		 if(isset($catid) and  $catid)
		 $sql.=" AND s.catid = '$catid' ";	
		if(isset($is_fav) and  $is_fav == 1)
		 $sql.="  and f.userid='$uid' and f.isfavstill='1' ";			 
		 if(isset($uid) and  $uid)
		 $sql.=" AND a.userid = '$uid' ";
		else if(isset($hwid) and  $hwid)
		 $sql.=" AND a.hwid = '$hwid' "; 
		 
		 $sql.=" group by s.scatid "; 
			
		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 
	  public function get_qrs($param=array()){
		 extract($param);
		 $sql="SELECT   subcat.scatid subcat_id, subcategory, count(distinct qrc.qrcid) as num_products
				FROM (subcat)				
				INNER JOIN product ON product.subcat=subcat.scatid
				INNER JOIN qrc ON qrc.qrcid = product.pid
				INNER JOIN act_log ON act_log.qrcid = qrc.qrcid AND act_log.action = 'scan'
				WHERE subcat.isactive = 1 ";
				
		 if(isset($catid) and  $catid)
		 $sql.=" AND subcat.catid = '$catid' ";		
		 if(isset($uid) and  $uid)
		 $sql.=" AND act_log.userid = '$uid' ";
		 if(isset($qrid) and  $qrid)
		 $sql.=" AND act_log.qrcid = '$qrid' ";
		 
		 $sql.="GROUP BY subcat.catid 
				ORDER BY subcat.subcategory";
		
		
			
		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 
	 public function filter_qrs($param=array()){
		 extract($param);
		
		 $sql="SELECT
			  qrc.qrcid        'QR ID',
			  qrc.qrc          'QR Data',
			  qrc.price        'Price',
			  product.pname as 'Product Name',
			   product.image as 'Product Image', 
						   concat('".base_url(QR_IMAGE_PATH)."/',qrc.qrcimgpath ) as Image, 
			  retname          'Retailer',
			   qrc.StreetName,
			  locname          'Location',
			  if( `favs`.`isfavstill` is null, 0, if( `favs`.`isfavstill` = '', 0, if( `favs`.`isfavstill` = 0, 0, 1 ) ) ) as Favourite,
			  act_log.actdt 'Scan Date',product.url as 'product_url'
			FROM (qrc)
			  left join act_log on act_log.qrcid=qrc.qrcid
			  LEFT JOIN favs ON favs.qrcid = qrc.qrcid ";
			if(isset($uid) && $uid)	
			 $sql.="  and favs.userid=$uid ";
			elseif(isset($hwid) && $hwid)	
			 $sql.="  and favs.hwid=$uid ";   
			   
			$sql.=" left JOIN product ON product.pid = qrc.pid
			  left JOIN subcat on subcat.scatid=product.subcat
			  left join cat on cat.catid=subcat.catid
			  left JOIN retailer ON retailer.retid = qrc.retid
			  left JOIN location ON location.locid = qrc.locid
			WHERE act_log.action='scan'";
		if(isset($uid) && $uid)	
		$sql.="	and act_log.userid=$uid ";		
		else if(isset($hwid) && $hwid )	
		$sql.="	and act_log.hwid='$hwid' ";
		
		if(isset($catid) && $catid)
		$sql.="	and cat.catid =$catid ";
		if(isset($subcatid) && $subcatid)
		$sql.="	and subcat.scatid=$subcatid ";
		if(isset($retailerid) && $retailerid)
		$sql.="	and qrc.retid='$retailerid' ";
		if(isset($price) && $price){
			$price_range=explode("to",$price); 
			$sql.="	and qrc.price BETWEEN ".(isset($price_range[0])?$price_range[0]:0)." and ".(isset($price_range[1])?$price_range[1]:1);
		}
		$sql.="	group by qrc.qrcid ";
		if(isset($chronologic) && (strtolower($chronologic)=='asc' || strtolower($chronologic)=='desc') )
		$sql.="	order by product.pname $chronologic ";
		else
		$sql.="	order by act_log.actdt desc ";
		

		
	$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 
	 	 public function filterfav_categories($param=array()){
		 extract($param);
	
		 $sql="select count(category) as num_products,category,catid  from (SELECT
  cat.category,cat.catid
      FROM qrc
  inner join act_log
    on act_log.qrcid = qrc.qrcid
  inner JOIN favs
    ON favs.qrcid = qrc.qrcid and favs.isfavstill = 1
      and favs.userid = $uid 
  inner JOIN product
    ON product.pid = qrc.pid
  inner JOIN subcat
    on subcat.scatid = product.subcat
  inner join cat
    on cat.catid = subcat.catid
  inner JOIN retailer
    ON retailer.retid = qrc.retid
  inner JOIN location
    ON location.locid = qrc.locid
WHERE  act_log.userid = $uid ";
if(isset($retailerid) && $retailerid) 
 $sql.=" and retailer.retid = '$retailerid'"; 
 if(isset($hwid) && $hwid && $uid =='')
 $sql.=" and act_log.hwid = $hwid ";
$sql.=" group by qrc.qrcid
order by act_log.actdt desc)a group by category";
		

		
		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 	 	 public function filterfav_price($param=array()){
		 extract($param);

		 $sql="SELECT
  cat.category,cat.catid,qrc.qrcid        'QR ID',
  qrc.qrc          'QR Data',
  qrc.price        'Price',
  product.pname as 'Product Name',
   product.image as 'Product Image',
   concat('".base_url(QR_IMAGE_PATH)."/',qrc.qrcimgpath ) as Image, 
  retname          'Retailer',
   qrc.StreetName,
  locname          'Location',
  if( `favs`.`isfavstill` is null, 0, if( `favs`.`isfavstill` = '', 0, if( `favs`.`isfavstill` = 0, 0, 1 ) ) ) as Favourite,
  act_log.actdt    'Scan Date',product.url as 'product_url'
FROM qrc
  inner join act_log
    on act_log.qrcid = qrc.qrcid 
  inner JOIN favs
    ON favs.qrcid = qrc.qrcid and favs.isfavstill = 1
      and favs.userid = $uid 
  inner JOIN product
    ON product.pid = qrc.pid
  inner JOIN subcat
    on subcat.scatid = product.subcat
  inner join cat
    on cat.catid = subcat.catid
  inner JOIN retailer
    ON retailer.retid = qrc.retid
  inner JOIN location
    ON location.locid = qrc.locid
WHERE  act_log.userid = $uid and  act_log.action = 'scan' ";
if(isset($retailerid) && $retailerid)
$sql.="  and retailer.retid = '$retailerid' ";
else if(isset($hwid) && $hwid && $uid =='')	
$sql.="	and  act_log.hwid like '%$hwid%' ";
if(isset($catid) && $catid)
$sql.="	and cat.catid =$catid ";
if(isset($subcatid) && $subcatid)
$sql.="	and subcat.scatid=$subcatid ";
if(isset($price) && $price){
			$price_range=explode("to",$price); 
			$sql.="	and qrc.price BETWEEN ".(isset($price_range[0])?$price_range[0]:0)." and ".(isset($price_range[1])?$price_range[1]:1);
		}
$sql.=" group by qrc.qrcid";
	if(isset($chronologic) && (strtolower($chronologic)=='asc' || strtolower($chronologic)=='desc') )
		$sql.="	order by product.pname $chronologic ";
		else
		$sql.="	order by act_log.actdt desc ";

		$res = $this->db->query($sql);	
		return $res->result_array(); 
	 }
	 public function retunuuid()
	 {
	 $sel="SELECT uuid() as uid";
	 $res = $this->db->query($sel);	
		return $res->result_array(); 
	 }
	 
	 public function nonsmartbuggy_list($userid)
	 {
	   $sel="SELECT q.qrc,q.isnew,q.qrcid,a.userid,a.actdt as 'Scan Date' from qrc q inner join act_log a on a.qrcid=q.qrcid where a.userid='$userid' and a.action='scan' and q.isnew='1'";
	 $res = $this->db->query($sel);	
		return $res->result_array();
	 
	 
	 
	 }
}
?>
