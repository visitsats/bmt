<div class="container">
<?php //pr($floors_info);?>
 <div class="floor-panel-one">
   <div class="floor-panel-cnt">
    <div class="floor-section ">
	
    <h3 class="mnone ">Occupancy</h3>
    <ul class="list-unstyled ">
	<?php
		$sections=array();
		$i=1;
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
				$i++;
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
  <div class="floor-layout  floor-section-seates  text-center">
    <div class="table-responsive" id="sub_cat_data">
 <?php
 	if($this->session->userdata('time_zone')){
		time_zone_set($this->session->userdata('time_zone'));
	}
	$floor_array=array();

	foreach($available as $floor_info1)
	{
	$floor_array[$floor_info1['serial_no']]=$floor_info1;
	}
	//pr($floor_array);
	//echo '<pre>';print_r($floor_array);exit;
		 $arr_array  = array();
		   $no_of_columns='';
		if(isset($floor_info[0]['no_of_columns']) && $floor_info[0]['no_of_columns']!='')
		{
		   $no_of_columns=$floor_info[0]['no_of_columns'];
		}else
		{
		 $no_of_columns=2;
		
		}
		for( $i = 0; $i < count($floor_info); $i++ ) {
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
		foreach( $floor_info as $key => $value ) {
			if ( $i >= $columns ) {
			$output .= '</tr><tr>';
			$i = 0;
			$x++;
			}
			if ( $j <= $columns ) {
			$class = 'first';
			} else if ( (($amount+$amount_td)-$j) < $columns ) {
			$class = 'last';        
			} else {
			$class = '';
			}
			$n=$i+1;
			if(isset($floor_array[$x.''.$n]['serial_no']) && $floor_array[$x.''.$n]['serial_no']!='' && $floor_array[$x.''.$n]['available_status']==1)
			{
				if($floor_array[$x.''.$n]['no_of_seats'] >8 )
				{
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 green'; 
		
				}else
				{
					if ($floor_array[$x.''.$n]['no_of_seats'] % 2 == 0) {
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' green'; 
					}else{
						$number=$floor_array[$x.''.$n]['no_of_seats']+1;
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' green'; 
					}
		
				}
				if($floor_array[$x.''.$n]['no_of_seats']!=0)
				{
					$table_id=$floor_array[$x.''.$n]['table_id'];
					$book="Book";
				}
				else
				{
					 $table_id='';
					 $book="Not Avialble";
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
			
			}else
			{
			 $table_id='';
			 $book="Booked";
			   if(isset($floor_array[$x.''.$n]['no_of_seats']) &&  $floor_array[$x.''.$n]['no_of_seats'] >8 )
			{
					$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 red'; 
	
			}else
			{
					if ( isset($floor_array[$x.''.$n]['no_of_seats']) && $floor_array[$x.''.$n]['no_of_seats'] % 2 == 0)
					{
					
					$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' red'; 
					}else
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
			}	//echo date_default_timezone_get();
				if($floor_array[$x.''.$n]['in_time'] != "")
				{
					//$intime = date("g:i A", strtotime($floor_array[$x.''.$n]['in_time']));
					$intime = date("m/d/Y H:i:s", strtotime($floor_array[$x.''.$n]['in_time']));
					//$intime=strtotime($floor_array[$x.''.$n]['in_time']);
				}
				else
				{
					$intime = $floor_array[$x.''.$n]['in_time'];
				}
			
			$output.= '<td><b style="font-family:Arial" id="intime_'.$k.'">'.$intime.'</b><div class="'.$class.'" >'.$no_of_seats.'<div class="table-cont">'.$table_no.'</div><div class="hover"><a  id="click_model_'.$table_id.'_'.$section_id.'"  title="'.$no_of_seats1.'"  data-toggle="modal" data-target="#myModal_'.$k.'"  class="btn btn-sm btn-default">'.$book.'</a><a  id="join_model_'.$k.'"  title="'.$no_of_seats1.'" onclick="get_tables('.$k.')"  data-toggle="modal"  class="btn btn-sm btn-default">Join</a></div></div><input type="text" style="display:none" id="click_input_'.$k.'" value="" /><input type="text" style="display:none" value="'.$x.''.$n.'" name="serialno" /></td>
			';
?>
<script type="text/javascript">
$(document).ready(function(){
<?php if($intime!=""){ ?>
var intie='<?php echo "intime_".$k; ?>';

var intime=$("#"+intie).text();

  var fiveSeconds = new Date(intime).getTime();
  //alert(fiveSeconds.getHours());
  //alert(fiveSeconds.getMinutes());
  //alert(fiveSeconds.getSeconds());
	//alert(fiveSeconds);
 $('#'+intie).countdown(fiveSeconds,{elapse:true}).on('update.countdown', function(event) {
    var $this = $(this);
    if (event.elapsed) {
     $this.html(event.strftime('%H:%M:%S'));
    } else {
      $this.html(event.strftime('%H:%M:%S'));
    }
  });
 // $clock.countdown(fiveSeconds);
 
<?php } ?>  
}); 
</script>
<div class="modal fade" id="joinModal_<?php echo $k; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="close__<?php echo $k; ?>" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        <h4 class="modal-title" id="myModalLabel">Book Table</h4>
      </div>
	  
	<div class="modal-body">
	  <input type="hidden" id="reservation_id" value=""/>
	 
         <div class="form-group col-md-10  col-sm-10 col-md-offset-1" id="load_div_floor">	
			<label class="form-lable ">Select floor<span class="star">*</span></label>			 
                <select class="selectpicker" id="floors_<?php echo $k; ?>" name="floor"  onchange="get_tables(<?php echo $k; ?>)" required>
				<!--<option value="" style="display:none;">Select Floor</option> -->
					<?php
					if(is_array($floors_info) && !empty($floors_info))
					{
						foreach($floors_info as $floors1)
						{						
					?>
						<option value="<?php echo $floors1['floor_id']; ?>" ><?php echo $floors1['floor_no'].' - '.$floors1['business_name']; ?></option>
					<?php
						}
					}
					?>
				 </select>
                     </div>
			<!--<div class="form-group col-md-10 col-md-offset-1">	 

			<input type="text" placeholder="Enter No of members" class="form-control"   name="table_for" required id="select_no_of_members" onblur="get_tables()">
			</div>-->
		<div class="form-group col-md-10 col-sm-10 col-md-offset-1" id="sub_cat_data<?php echo $k; ?>">	 
			<label class="form-lable ">Select Table Number<span class="star">*</span></label>		
				<select    placeholder="Select Table Number" class="selectpicker"  name="table_id" required>
				<!--<option value="" style="display:none;">Select Your Table Number</option>-->			
				</select>
		</div>
		
		
	</div>
	<div class="clearfix"></div>
      <div class="modal-footer ">
        
		<div class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="buzz_done(<?php echo $k; ?>)">Allocate Table</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php			
			$i++;
			$j++;
			$k++;
		}
		$y=$i;
		for( $i = 0; $i < $amount_td; $i++ ) {
		if(isset($floor_array[$x.''.$y]['serial_no']) && $floor_array[$x.''.$y]['serial_no']!='' &&  $floor_array[$x.''.$y]['no_of_seats']!='')
		{
	    if($floor_array[$x.''.$y]['no_of_seats'] >8 )
		{
				$class='tb '.$floor_array[$x.''.$y]['table_type'].' t8 green'; 

		}else
		{
				$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$floor_array[$x.''.$y]['no_of_seats'].' green'; 

		}
		$table_id=$floor_array[$x.''.$y]['table_id'];

		
		}else
		{
		 $table_id='';
		 $class='tb rectangle t8 red';

		}
		$output.= '<td><div class="'.$class.'" ><div class="hover"><a  id="click_model_'.$table_id.'" data-toggle="modal" title="'.$x.'"  data-target="#myModal_'.$y.'" class="btn btn-sm btn-default">Book</a><input type="text" style="display:none" id="click_input_'.$y.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="tablenos" /></div></div></td>';
		
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
		 <script>
		 
		$('[id^=click_model_]').click(function()
		{
			var error = [];
			var table_ids=	$(this).attr('id').split("_");
			var section_id=table_ids[3];
			var table_id = $(this).attr('id').substr(12);			
			if(table_id =='')
			{
				return false;
			}
			
			var name=$.trim($('#name').val());
			var phone_no=$.trim($('#phone_no').val());
			var booked_date=$('#booked_date').val();
			var in_time=$('#in_time').val();
			var select_no_of_members=$.trim($('#select_no_of_members1').val());
			var permitted_seats=$.trim($(this).attr('title'));
			
			if(parseInt(select_no_of_members) > parseInt(permitted_seats))
			{
				$('#error').show();
				$('#error').html('No of members should be less than table capacity.');
				return false;
			}
			else
			{
				$('#error').html('');
			}
			
			if((name == "" || $.isNumeric(name)) && (phone_no=="" || phone_no.length!=10 || !$.isNumeric(phone_no)))
			{
				error.push('e1');				
			}
			else
			{
				if($.isNumeric(name) )
				{
					error.push('e1');
				}
			}
			if(select_no_of_members == ''|| select_no_of_members == 0)
			{
				error.push('e2');
			}
			/*if(phone_no=="" || phone_no.length!=10){
				error.push('e3');
			}
			else
			{
				if(!$.isNumeric(phone_no) )
				{
					error.push('e3');
				}
			}*/
			if(error.length != 0)
			{
				if($.inArray("e1", error) !== -1){ alert("Either Name or Phone number is required"); $("#name").addClass('error');} else { $("#name").removeClass('error');}
				if($.inArray("e2", error) !== -1){alert("Number of Guests is required"); $("#select_no_of_members1").addClass('error'); } else { $("#select_no_of_members1").removeClass('error'); }
				//if($.inArray("e3", error) !== -1){  $("#phone_no").addClass('error');} else { $("#phone_no").removeClass('error');}
				return false;
			}
			else
			{
				//$('#phone_no').removeClass('error');
				 $("#name").removeClass('error');
				 $("#select_no_of_members1").removeClass('error'); 
				 error = [];
			}
			
		//var floors=$("[id^=floor_]").attr('class');
		var floor=$.trim($('#floor').val());
		var floor_id1=floor.split("_");
		floor_id=floor_id1[0];
		//var section_id=floor_id1[1];
		var is_vip=$.trim($('#is_vip:checked').val());
		var dob=$.trim($('#date_of_birth').val());
		
		$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/quick_reservation",
			data :	{'name':name,'phone_no' : phone_no,'in_time':in_time,'booked_date':booked_date,'table_id':table_id,'table_for':select_no_of_members,'floor':floor_id,'section_id':section_id,'is_vip':is_vip,'dob':dob},
			success : function(data)
			{	
				if(data=="Failed"){
					setTimeout( function ( ) { $('#error').html("Can't Book the table with the same phone number"); }, 1000 );				
					setTimeout( function ( ) { $('#error').html(''); }, 4000 );
				}else{
					var floor_id = $("#floor").val();
					var select_no_of_members=$('#select_no_of_members1').val();
					location.reload();
					$.ajax({
						type :	"POST",
						url	 :	"<?php echo base_url();?>bookmyt/get_table_data",
						data :	{'floor_id':floor_id,'select_no_of_members':select_no_of_members},
							success : function(data)
							{
		
								$('#table_data').html(data);
								$('#name').val('');
								$('#phone_no').val('');
								$('#is_vip').attr('checked',false);
								$('#date_of_birth').val('');
								$('#select_no_of_members1').val('');
								$('#sucess').html('');		
							}		
						});
					
						$.ajax({
							type :	"POST",
							url	 :	"<?php echo base_url();?>bookmyt/quick_booking_done_details",
							data :	{},
								success : function(data)
								{
									$('#append_data').html(data);
								}		
							});
							setTimeout( function ( ) { $('#sucess').html('Table is booked'); }, 1000 );				
							setTimeout( function ( ) { $('#sucess').html(''); }, 4000 );
				}		
			}
		});
});


		$("#name,#phone_no,#select_no_of_members1").change(function()
		{
			if($("#phone_no").val() != "")
			{	
				$('#phone_no').removeClass('error');							
			}
			if($("#name").val() != "")
			{
				$("#name").removeClass('error');
			}
			if($("#select_no_of_members1").val() != '')
			{
				$("#select_no_of_members1").removeClass('error'); 
			}
		});
		$('#tabs1').scrollTabs();
	$('#tabs2').scrollTabs();
	
	$('[id^=sect_]').click(function(){
		var id=this.id.split("_");
		var section_id=id[1];
		var floor_id=id[2];
		var business_id=id[3];
		$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/get_table_data",
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
		var section_id_1=section_id.split(",");
		var floor_id=id[1];
		var business_id=id[3];
		$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/get_table_data",
			data :	{'floor_id':floor_id,'section_id':section_id,'business_id':business_id},
			beforeSend:function(){
				$('#sub_cat_data').html('<div style="text-align:center;"><img src="<?php echo base_url(); ?>images/ajax-loader.gif" ></div>');
			},
			success : function(data){
						//alert(floor_id+'_'+section_id_1[0]+'_'+business_id);
						$("#floor").val(floor_id+'_'+section_id_1[0]+'_'+business_id);
						$('.selectpicker').selectpicker('refresh')
						$('#table_data').html(data);						
					}
		});
	});
	$("[id^=join_model_]").click(function(){
			var error = [];
			var k=$(this).attr('id').substr(11);
			var name=$.trim($('#name').val());
			var phone_no=$.trim($('#phone_no').val());
			var booked_date=$('#booked_date').val();
			var in_time=$('#in_time').val();
			var select_no_of_members=$.trim($('#select_no_of_members1').val());
			var permitted_seats=$.trim($(this).attr('title'));
			
			/*if(parseInt(select_no_of_members) > parseInt(permitted_seats))
			{
				$('#error').show();
				$('#error').html('No of members should be less than table capacity.');
				return false;
			}
			else
			{
				$('#error').html('');
			}*/
			
			if((name == "" || $.isNumeric(name)) && (phone_no=="" || phone_no.length!=10 || !$.isNumeric(phone_no)))
			{
				error.push('e1');				
			}
			else
			{
				if($.isNumeric(name) )
				{
					error.push('e1');
				}
			}
			if(select_no_of_members == ''|| select_no_of_members == 0)
			{
				error.push('e2');
			}
			/*if(phone_no=="" || phone_no.length!=10){
				error.push('e3');
			}
			else
			{
				if(!$.isNumeric(phone_no) )
				{
					error.push('e3');
				}
			}*/
			if(error.length != 0)
			{
				if($.inArray("e1", error) !== -1){ alert("Either Name or Phone number is required"); $("#name").addClass('error');} else { $("#name").removeClass('error');}
				if($.inArray("e2", error) !== -1){alert("Number of Guests is required"); $("#select_no_of_members1").addClass('error'); } else { $("#select_no_of_members1").removeClass('error'); }
				//if($.inArray("e3", error) !== -1){  $("#phone_no").addClass('error');} else { $("#phone_no").removeClass('error');}
				
				
				return false;
			}
			else
			{
				//$('#phone_no').removeClass('error');
				 $("#name").removeClass('error');
				 $("#select_no_of_members1").removeClass('error'); 
				 error = [];
				 $("#join_model_"+k).attr("data-target","#joinModal_"+k);
				 $("#join_model_"+k).trigger("click");
				 get_tables(k);
			}
	});
	function get_tables(k)
	{
		//alert($("#floors").val());
		$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/get_tables_quick",
			data :	{'no_of_members' : $("#select_no_of_members1").val(),'floor_id':$("#floors_"+k).val(),'reservation_id' : $("#reservation_id").val(),'no_of_k':k},
			success : function(data)
			{
				//alert(data);
				$('#sub_cat_data'+k).html(data);
			}

			});
			 
	}
	function buzz_done(k)
	{
		var err = [];
		var floor=$('#floors_'+k).val();
		
		var select_no_of_members=$.trim($('#select_no_of_members1').val());
		var sub_cat_data=$('#sub_cat_data1'+k).val();
		//alert(sub_cat_data);return false;
		var reservation_id=$('#reservation_id').val();
		var name=$.trim($('#name').val());
		var phone_no=$.trim($('#phone_no').val());
		var booked_date=$('#booked_date').val();
		var in_time=$('#in_time').val();
		//var select_no_of_members=$.trim($('#select_no_of_members1').val());
		//alert(sub_cat_data);return false;
		//alert( floor);alert( sub_cat_data); return false;
		/*if(floor=='')
		{
			err.push('e1');
		}*/
		if(sub_cat_data=='' || sub_cat_data==null)
		{
			err.push('e2');
		}
		
		if(err.length != 0)
		{
			//alert("Hi");
			//if($.inArray("e1", err) !== -1){ $("[data-id=floor]").addClass('error'); } else { $("[data-id=floor]").removeClass('error'); }
			if($.inArray("e2", err) !== -1){ $("[data-id=sub_cat_data1"+k+"]").addClass('error'); } else { $("[data-id=sub_cat_data1"+k+"]").removeClass('error'); }
			return false;
		}
		else
		{
			$('[data-id=floor]').removeClass('error');
			$('[data-id=sub_cat_data]').removeClass('error');
			err = [];
		}
		var floor=$.trim($('#floors_'+k).val());
		var is_vip=$.trim($('#is_vip:checked').val());
		var dob=$.trim($('#date_of_birth').val());
		
		$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/quick_reservation",
			data :	{'name':name,'phone_no' : phone_no,'sub_cat_data':sub_cat_data,'in_time':in_time,'booked_date':booked_date,'table_for':select_no_of_members,'floor':floor,'is_vip':is_vip,'dob':dob},
			success : function(data)
			{	
				//alert(data);return false;
				if(data=="Failed"){
					setTimeout( function ( ) { $('#error').html("Can't Book the table with the same phone number"); }, 1000 );				
					setTimeout( function ( ) { $('#error').html(''); }, 4000 );
				}else{
					var floor_id = $("#floor").val();
					var select_no_of_members=$('#select_no_of_members1').val();
					location.reload();
					$.ajax({
						type :	"POST",
						url	 :	"<?php echo base_url();?>bookmyt/get_table_data",
						data :	{'floor_id':floor_id,'select_no_of_members':select_no_of_members},
							success : function(data)
							{
		
								$('#table_data').html(data);
								$('#name').val('');
								$('#phone_no').val('');
								$('#is_vip').attr('checked',false);
								$('#date_of_birth').val('');
								$('#select_no_of_members1').val('');
								$('#sucess').html('');		
							}		
						});
					
						$.ajax({
							type :	"POST",
							url	 :	"<?php echo base_url();?>bookmyt/quick_booking_done_details",
							data :	{},
								success : function(data)
								{
									$('#append_data').html(data);
								}		
							});
							setTimeout( function ( ) { $('#sucess').html('Table is booked'); }, 1000 );				
							setTimeout( function ( ) { $('#sucess').html(''); }, 4000 );
				}		
			}
		});	
	
	}
</script>
<script>
$('.selectpicker').selectpicker();
</script>