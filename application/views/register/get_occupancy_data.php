<div class="container">
<?php //pr($floors_info);?>
 <div class="floor-panel-one">
   <div class="floor-panel-cnt">
    <div class="floor-section ">
	<div class="occupancy text-center">
            <img src="<?php echo base_url(); ?>theme/images/logo-sm.png" alt="logo-sm">
    </div>    
    <ul class="list-unstyled ">
	<?php
		$sections=array();
		if(!empty($floors_info)){
			foreach($floors_info as $finfo){
				$sections[$finfo['floor_id']]=$finfo;
				$cnt=explode(",",$finfo['Available_tables']);
				$tab_cnt=0;
				foreach($cnt as $count){
					$tab_cnt+=$count;
				}
	?>
    <li><a href="javascript:void(0)" <?php if($floor_id==$finfo['floor_id']){ ?> class="active"<?php }?> id="floor_<?php echo $finfo['floor_id']."_".$finfo['section_id']."_".$finfo['business_id']; ?>"><span><?php echo $finfo['floor_no'];?></span><i><?php echo $tab_cnt; ?></i></a></li>
<!--     <li><a href="#"><span>Floor-</span>1 <i>30</i></a></li>
      <li><a href="#"><span>Floor-</span>2 <i>30</i></a></li>
       <li><a href="#"><span>Floor-</span>3 <i>30</i></a></li>
        <li><a href="#"><span>Floor-</span>4 <i>30</i></a></li>
         <li><a href="#"><span>Floor-</span>5 <i>30</i></a></li>
-->    
	<?php
			}
		}	
	?>
	</ul>
    </div>
   
   
     <?php
	 	//pr($sections);//exit;
	 ?>
    
    
    <div class="floor-section-result">
   <div class="floorsection-tabs">
    <ul class="scroll_tabs_container" id="tabs2">
	<?php 
		if(!empty($sections)){
			//foreach($sections[$floors_info[0]['floor_id']] as $sect){
				$section_ids=explode(",",$sections[$floor_id]['section_id']);
				$section_names=explode(",",$sections[$floor_id]['section_name']);
				$sec_tab_count=explode(",",$sections[$floor_id]['Available_tables']);
				$sects=array_combine($section_ids,$section_names);
				$i=0;
				foreach($sects as $key=>$value){
	?>
    <li <?php if($section_id==$key){ ?>class="active"<?php } ?>><a href="javascript:void(0)" id="sect_<?php echo $key."_".$floor_id."_".$business_id; ?>" ><?php echo $value; ?> <i><?php echo $sec_tab_count[$i]; ?></i></a></li>
	<?php
				$i++;
			}
		}	
	?>
     <!--<li><a href="#">Grand Room <i>20</i></a></li>
      <li><a href="#"> Out Side <i>20</i></a></li>-->
      
     
    

    </ul>
    </div>
    
    
  

  <div class="floor-layout floor-section-seates text-center">
    <div class="table-responsive" id="sub_cat_data">
<?php
	$floor_array=array();
	//echo '<pre>';print_r($available);exit;
	foreach($available as $floor_info1)
	{
		$floor_array[$floor_info1['serial_no']]=$floor_info1;
	}
		//echo '<pre>';print_r($floor_info);exit;
		$arr_array  = array();
		$no_of_columns='';
		if(isset($floor_info[0]['no_of_columns']) && $floor_info[0]['no_of_columns']!='')
		{
		   $no_of_columns=$floor_info[0]['no_of_columns'];
		}
		else
		{
			$no_of_columns=2;		
		}
		
		for( $i = 0; $i < count($floor_info); $i++ ) 
		{
			$arr_array[$i] = $i+1;
		}
		
		$columns    = $no_of_columns;                                                 
		$amount     = count($arr_array);                                
		
		$amount_td  = $columns * (ceil( $amount / $columns )) - $amount;  
		$i          = 0;
		$j          = 1;
		$k=1;
		$output='';
		$output.= '<table>
		<tr>';
		$x=1;
		
		foreach( $floor_info as $key => $value ) 
		{
			if ( $i >= $columns ) 
			{
				$output .= '</tr><tr>';
				$i = 0;
				$x++;
			}
			if ( $j <= $columns )
			{
				$class = 'first';
			} 
			else if ( (($amount+$amount_td)-$j) < $columns ) 
			{
				$class = 'last';        
			} 
			else 
			{
				$class = '';
			}
			$n=$i+1;
		
			if(isset($floor_array[$x.''.$n]['serial_no']) && $floor_array[$x.''.$n]['serial_no']!='' && $floor_array[$x.''.$n]['available_status']==1)
			{
				if($floor_array[$x.''.$n]['no_of_seats'] >8 )
				{
					$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 green';
				}
				else
				{
					if ($floor_array[$x.''.$n]['no_of_seats'] % 2 == 0) 
					{
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' green'; 
					}
					else
					{				
						$number=$floor_array[$x.''.$n]['no_of_seats']+1;
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' green'; 
					}

				}
				if($floor_array[$x.''.$n]['no_of_seats']!=0)
					$table_id=$floor_array[$x.''.$n]['table_id'];
				else
					$table_id='';
					$no_of_seats=$floor_array[$x.''.$n]['no_of_seats'];
					$no_of_seats1=$floor_array[$x.''.$n]['no_of_seats'];
					$table_no=$floor_array[$x.''.$n]['table_no'];
					
				if($no_of_seats!=0 && $no_of_seats > 8)
					$table_no= "Table ".$table_no;
				else 
					if($no_of_seats!=0 && $no_of_seats <= 8)
					$table_no= "Table ".$table_no;
				else
					$table_no='';
				
				$no_of_seats=($no_of_seats!=0 || $no_of_seats!="")?$no_of_seats:'';	
			}
			else
			{
				$table_id='';
				if($floor_array[$x.''.$n]['no_of_seats'] >8 )
				{
					$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 red'; 
				}
				else
				{
					if ($floor_array[$x.''.$n]['no_of_seats'] % 2 == 0) 
					{				
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' red'; 
					}
					else
					{				
						$number=$floor_array[$x.''.$n]['no_of_seats']+1;
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' red'; 
					}
				}
				$no_of_seats=$floor_array[$x.''.$n]['no_of_seats'];
				$no_of_seats1=$floor_array[$x.''.$n]['no_of_seats'];
				$table_no=$floor_array[$x.''.$n]['table_no'];
				if($no_of_seats!=0 && $no_of_seats > 8)
					$table_no= "Table ".$table_no;
				else
					if($no_of_seats!=0 && $no_of_seats <= 8)
						$table_no= "Table ".$table_no;
					else
						$table_no='';
				$no_of_seats=($no_of_seats!=0 || $no_of_seats!="")?$no_of_seats:'';	
		
			}
			
			if($floor_array[$x.''.$n]['in_time'] != "")
			{
				//$intime = date("g:i A", strtotime($floor_array[$x.''.$n]['in_time']));
				$intime = date("m/d/Y H:i:s", strtotime($floor_array[$x.''.$n]['in_time']));
				
			}
			else
			{
				$intime = $floor_array[$x.''.$n]['in_time'];
			}
			
		
			$output.= '<td><b style="font-family:open_sansbold" id="intime_'.$k.'">'.$intime.'</b><div class="'.$class.'" >'.$no_of_seats.'<div class="table-cont">'.$table_no.'</div><div class="hover"></div></div><input type="text" style="display:none" id="click_input_'.$k.'" value="" /><input type="text" style="display:none" value="'.$x.''.$n.'" name="serialno" /></td>';
		
?>
<script type="text/javascript">
$(document).ready(function(){
<?php if($intime!=""){ ?>
var intie='<?php echo "intime_".$k; ?>';

var intime=$("#"+intie).text();

  var fiveSeconds = new Date(intime).getTime();
	
  $('#'+intie).countdown(fiveSeconds, {elapse: true}).on('update.countdown', function(event) {
    var $this = $(this);
    if (event.elapsed) {
      $this.html(event.strftime('%H:%M:%S'));
    } else {
      $this.html(event.strftime('%H:%M:%S'));
    }
  });
 
<?php } ?>  
}); 
</script>
<?php			
			$i++;
			$j++;
			$k++;
		}
		
		$y=$i;
		for( $i = 0; $i < $amount_td; $i++ ) 
		{
			if(isset($floor_array[$x.''.$y]['serial_no']) && $floor_array[$x.''.$y]['serial_no']!='' &&  $floor_array[$x.''.$y]['no_of_seats']!='')
			{
				if($floor_array[$x.''.$y]['no_of_seats'] >8 )
				{
					$class='tb '.$floor_array[$x.''.$y]['table_type'].' t8 green'; 
				}
				else
				{
					$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$floor_array[$x.''.$y]['no_of_seats'].' green'; 
				}
				$table_id=$floor_array[$x.''.$y]['table_id'];		
			}
			else
			{
				$table_id='';
				$class='tb rectangle t8 red';
			}
			$output.= '<td><div class="'.$class.'" ><div class="hover"><input type="text" style="display:none" id="click_input_'.$y.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="tablenos" /></div></div></td>';
		
			$y++;
		}
		
		$output .= '</tr>
		</table>';
      
			echo $output;
		 
		 ?>
		 </div>
		 </div>
		   </div>
   </div>
   </div>
  </div>
<script type="text/javascript">
$(document).ready(function(){
	$('#tabs1').scrollTabs();
	$('#tabs2').scrollTabs();
	$('[id^=sect_]').click(function(){
		var id=this.id.split("_");
		var section_id=id[1];
		var floor_id=id[2];
		var business_id=id[3];
		$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/get_occupancy_data",
			data :	{'floor_id':floor_id,'section_id':section_id,'business_id':business_id},
			beforeSend:function(){
				$('#sub_cat_data').html('<div style="text-align:center;"><img src="<?php echo base_url(); ?>images/ajax-loader.gif" ></div>');
			},
			success : function(data){
						$('#table_data').html(data);
					}
		});
	});
	$('[id^=floor_]').click(function(){
		var id=this.id.split("_");
		var section_id=id[2];
		var floor_id=id[1];
		var business_id=id[3];
		$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/get_occupancy_data",
			data :	{'floor_id':floor_id,'section_id':section_id,'business_id':business_id},
			beforeSend:function(){
				$('#sub_cat_data').html('<div style="text-align:center;"><img src="<?php echo base_url(); ?>images/ajax-loader.gif" ></div>');
			},
			success : function(data){
						$('#table_data').html(data);
					}
		});
	});
});
</script>