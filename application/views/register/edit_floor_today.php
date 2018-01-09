  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h3 class="text-center">Floors</h3>
          <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>
        </div>
        <div class="wrap">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
            <div class="panelone  plr10">
			<center>
			<?php

			if(isset($success) && !empty($success))
			{
				echo "<span style='font-weight:bold;color:green'>".$success."</span>";
			}
		
			?>
			<span style="font-weight:bold;color:red;padding:10px !important;" id="error_sucess"></span>
			<span style="font-weight:bold;color:green;padding:10px !important;" id="error_save"></span>
			</center>
              <form role="form" class="wrap mt25" >
			   <input type="text" style="display:none" placeholder="Enter your Floor Name" class="form-control" id="floor_id"  name="floor_no no_of_columns" value="<?php echo $floor_info[0]['floor_id'];?>" required>
			   <input type="hidden" name="relationship_id" value="<?php echo $this->session->userdata('business_id');?>" />
			   <?php
						if($this->session->userdata('branch') == 0)
						{
					?>
						  <div class="form-group col-md-12">
						  Select Branch
							  <select class="selectpicker"  name="branch" id="business_id">
									<option value="">Select Branch</option>
									<?php
									if(isset($branches) && !empty($branches))
									{
										foreach($branches as $branch)
										{
											echo $floor_info[0]['business_id']." ".$branch['business_id'];
									?>
										<option value="<?php echo $branch['business_id']; ?>" <?php if($floor_info[0]['business_id'] == $branch['business_id']) { echo "selected='selected'"; }  ?>><?php echo $branch['business_name']; ?></option>
									<?php
										}
									}
									?>
							 </select>
								<span style="color:red"><?php echo form_error('branch'); ?></span>
						  </div>
					<?php
						}
						else
						{
					?>
						
						 <div class="form-group col-md-12"> 
						 Select Branch
						 <input type="text" class="form-control" value="<?php echo $this->session->userdata('business_name');?>" readonly>
						<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
					</div>
				   <?php
						}
					?>			   
			   
                <div class="form-group col-md-6">
				Enter Floor Name
				 <input type="text" placeholder="Enter your Floor Name" class="form-control" id="floor_no" maxlength="25" name="floor_no no_of_columns" required value="<?php echo $floor_info[0]['floor_no'];?>">
                </div>
                <div class="form-group col-md-6">
				Enter Number Of Tables
				 <input type="text" placeholder="No of Tables" class="form-control"  maxlength="2"  name="no_of_tables" required id="no_of_tables" value="<?php echo $floor_info[0]['no_of_tables'];?>" readonly>
                </div>
                <div class="form-group col-md-6">
				Enter Number of Rows
				 <input type="text" placeholder="No of rows" class="form-control"   maxlength="2" name="no_of_rows" required id="no_of_rows" value="<?php echo $floor_info[0]['floor_rows'];?>" readonly> <br/>
                </div>
                <div class="form-group col-md-6">
				Enter Number of Columns
				 <input type="text" placeholder="No of Columns" maxlength="2" class="form-control no_of_columns"   name="no_of_columns" required id="no_of_columns" value="<?php echo $floor_info[0]['floor_columns'];?>" readonly>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="floor-layout">
    <div class="table-responsive" id="sub_cat_data">
    <?php
	$floor_array=array();
	foreach($floor_info as $floor_info1)
	{
	$floor_array[$floor_info1['serial_no']]=$floor_info1;
	}
	//echo '<pre>';print_r($floor_array);
		 $arr_array  = array();
		   $no_of_columns='';
		if(isset($floor_info[0]['floor_columns']) && $floor_info[0]['floor_columns']!='')
		{
		   $no_of_columns=$floor_info[0]['floor_columns'];
		   
		}else
		{
		echo $no_of_columns=2;
		
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
		
		if(isset($floor_array[$x.''.$n]['table_type']) && $floor_array[$x.''.$n]['table_type']!='')
		{
		 if($floor_array[$x.''.$n]['no_of_seats']>8)
		 {
		 $class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 green';
		 }else
		 {
		 
		   if ($floor_array[$x.''.$n]['no_of_seats'] % 2 == 0) {
				
				$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' green'; 
				}else
				{
				
				$number=$floor_array[$x.''.$n]['no_of_seats']+1;
				$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' green'; 
				}
         
		 }
		 $no_of_seats=$floor_array[$x.''.$n]['no_of_seats'];
		  $table_no=$floor_array[$x.''.$n]['table_no'];
		  if($no_of_seats > 8)
		 $table_no= $table_no.'-'.$no_of_seats;
		 else
		 $table_no= $table_no;
		 
		 $edit="Edit";
		}else
		{
		$class='tb rectangle six green';
		$no_of_seats='';
		$table_no='';
		$edit='Add';
		}
		
		$output.= '<td><div class="'.$class.'" id="change_color_'.$k.'"><span id="change_capacity_'.$k.'" >'.$table_no.'</span><div class="hover"><a href="javascript:void(0)" id="click_model_'.$k.'" title="'.$x.'" onclick="click_model('.$k.')" data-toggle="modal" data-target="#myModal_'.$k.'"  class="btn btn-xs btn-default mt03">'.$edit.'</a><a href="javascript:void(0)"  title="'.$x.'" onclick="delete_table('.$k.')"  class="btn btn-xs btn-default mt03 ">Delete</a></div></div><input type="text" style="display:none" id="click_input_'.$k.'" value="" /><input type="text" style="display:none" value="'.$x.''.$n.'" name="serialno" /></td>
		';
		$i++;
		$j++;
        $k++;
		}
		$y=$n;
		for( $i = 0; $i < $amount_td; $i++ ) {
		
		if(isset($floor_array[$x.''.$y]['table_type']) && $floor_array[$x.''.$y]['table_type']!='')
		{
		 if($floor_array[$x.''.$y]['no_of_seats']>8)
		 {
		 $class='tb '.$floor_array[$x.''.$y]['table_type'].' t8 green';
		 }else
		 {
		 
		   if ($floor_array[$x.''.$y]['no_of_seats'] % 2 == 0) {
				
				$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$floor_array[$x.''.$y]['no_of_seats'].' green'; 
				}else
				{
				
				$number=$floor_array[$x.''.$y]['no_of_seats']+1;
				$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$number.' green'; 
				}
         
		 }
		 $no_of_seats=$floor_array[$x.''.$y]['no_of_seats'];
		}else
		{
		$class='tb rectangle six green';
		$no_of_seats='';
		}
		
		$output.= '<td><div class="'.$class.'" id="change_color_'.$y.'">'.$no_of_seats.'<div class="hover"><a href="javascript:void(0)" id="click_model_'.$y.'" title="'.$y.'" onclick="click_model('.$y.')" data-toggle="modal" data-target="#myModal_'.$y.'"  class="btn btn-sm btn-default">Edit</a><a href="javascript:void(0)"  title="'.$y.'" onclick="delete_table('.$y.')"  class="btn btn-sm btn-default btnresize">Delete</a></div></div><input type="text" style="display:none" id="click_input_'.$y.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="serialno" /></td>
		';
		
		
		$y++;
		}
		$output .= '</tr>
		</table>';
       echo $output;
		 
		 ?>
  </div>
  </div>
  <div class="form-group col-md-9"><button  class="btn btn-success pull-right icon-btn" type="button" onclick="save_tables()"> <i class="fa fa-plus-circle"></i> Update Floor</button> </div>
   
   <div id="load_popup_data">  
	<?php
$i=1;
foreach($floor_info as $floor_info1)
{
?>

  <div class="modal fade " id="myModal_<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:300px;">
      <div class="modal-content">
        <div class="modal-body " >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <div class="clearfix"></div>
          <h4 class="text-center mt10"> Select Seats</h4>
		   <div class="form-group">
            <input type="text"  placeholder="Table Number" value="<?php echo $floor_info1['table_no'];?>"   id="table_no<?php echo $i;?>"   name="table_no" maxlength="3" class="form-control">
          </div>
          <div class="form-group">
            <input type="text"  placeholder="Seats" value="<?php if($floor_info1['no_of_seats'] != 0) { echo $floor_info1['no_of_seats']; } else {} ?>"  maxlength="2" id="no_seats_<?php echo $i;?>"   name="tables"  class="form-control">
          </div>
            <div class="form-group">
			<select class="selectpicker" id="selectpicker_<?php echo $i;?>">
			<option value="">Table Type</option>
			<option value="rectangle" <?php if($floor_info1['table_type'] == "rectangle") { echo "selected='selected'"; }  ?>>Rectangle</option>
			<option value="square" <?php if($floor_info1['table_type'] == "square") { echo "selected='selected'"; }  ?>>Square</option>
			<option value="circle" <?php if($floor_info1['table_type'] == "circle") { echo "selected='selected'"; }  ?>>Circle</option>
			</select>
          </div>
          
          <div class="form-group">
            <button type="submit" class="btn btn-success modal-login-btn" onclick="save_pop(<?php echo $i;?>)">Submit</button>
          </div>
       
		</div>
      </div>
    </div>
  </div>
<input type="text"  name="images" id="save_images_<?php echo $floor_info1['table_no'];?>" value="<?php echo $floor_info1['image'];?>" style="display:none" />
<input type="text"  name="table_type" id="table_type_<?php echo $i;?>" value="<?php echo $floor_info1['table_type'];?>"  style="display:none" />

<?php
$i++;
}


?></div>
		<script type="text/javascript">
			
			
			$('#no_of_tables,#no_of_rows,#no_of_columns').keydown(function(event) 
			{
               
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
                    || event.keyCode == 27 || event.keyCode == 13 
                    || (event.keyCode == 65 && event.ctrlKey === true) 
                    || (event.keyCode >= 35 && event.keyCode <= 39)){
                        return;
                }else {
                    
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                        event.preventDefault(); 
                    }   
                }
            });
            
			$( "input[id^='table_no'],input[id^='no_seats_']" ).keydown(function(event) 
			{
               
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
                    || event.keyCode == 27 || event.keyCode == 13 
                    || (event.keyCode == 65 && event.ctrlKey === true) 
                    || (event.keyCode >= 35 && event.keyCode <= 39)){
                        return;
                }else {
                    
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                        event.preventDefault(); 
                    }   
                }
            });
            
			
			
			$(".no_of_columns").blur(function() 
			{
				if($.trim($("#floor_no").val()) =='')
				{
				
					$('#error_sucess').html('Please enter floor');
					return false;
				}
				
				var no_of_rows=$("#no_of_rows").val();
				var no_of_columns=$("#no_of_columns").val();
			
			
				
				$.ajax({
				type :	"POST",
				url	 :	"<?php echo base_url();?>bookmyt/tables_arrange_edit",
				data :	{'no_of_tables' : $("#no_of_tables").val(),'no_of_rows' : $("#no_of_rows").val(),'no_of_columns' : $("#no_of_columns").val(),'floor_id':$("#floor_id").val()},
				success : function(data)
				{	
					$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url();?>bookmyt/getpopup_edit",
					data :	{'no_of_tables' : $("#no_of_tables").val(),'floor_id':$("#floor_id").val(),'no_of_rows' : $("#no_of_rows").val(),'no_of_columns' : $("#no_of_columns").val()},
					success : function(data1)
					{
					}

					});	
			 
				}

				});
			
			
			});
			
			
			function click_model(id)
			{
			  $('#click_input_'+id).val(id)

			}
			function saveimg(imagename,id)
			{

			$("#save_images_"+id).val(imagename)

			}
			
			var table_no = [];
            function save_pop(id)
			{				
				table_no = [];
				t_nos = $('#table_no'+id).val();				
				$("input:text[name=table_no]").each(function()
				{
					if($(this).val()!='' && $(this).attr('id')!='table_no'+id)
					{
						table_no.push($(this).val());
					}
				});
				
				var found = $.inArray(t_nos, table_no);
			
				
				if (found != -1) 
				{
				alert("Table number should be unique!");
					return false;
				}else
				{
				table_no.push(t_nos);
				}
				var no_of_tables=$('#no_of_tables').val();
				if(table_no.length > no_of_tables)
				{
				 alert("You can't add the table more than No of tables!");
				 $('#no_seats_'+id).val('');  
				  $('#table_no'+id).val(''); 
			
				return false;	
				}
				table_no.push(t_nos);
				var seats=$('#no_seats_'+id).val();
				
				var shape=$('#selectpicker_'+id).val();
				if($('#no_seats_'+id).val()=='')
				{
				 alert('Please Enter No of seats');
				 return false;
				}
			
				
				
				if($('#selectpicker_'+id).val()=='')
				{
				 alert('Please Select table type');
				 return false;
				}
				$('#table_no'+id).val(t_nos);
				$('#save_images_'+id).val(seats1+''+shape+'.jpg');
				if(seats > 8)
				{
				$('#change_capacity_'+id).html(t_nos+'-'+seats);
				}else
				{
				$('#change_capacity_'+id).html(t_nos);
				}
				$('#table_type_'+id).val(shape);
				$('#change_color_'+id).removeClass($('#change_color_'+id).attr('class'));
				if($('#no_seats_'+id).val()>8)
				{
				$('#change_color_'+id).addClass('tb '+shape+' t8 green')
				}
				else
				{
				 if(seats%2==0)
				{
				 $('#change_color_'+id).addClass('tb '+shape+' t'+seats+' green')
				}else
				{
				      var seats1=Number(seats)+Number(1);
					$('#change_color_'+id).addClass('tb '+shape+' t'+seats1+' green')
				
				}


				}
				$('.close').trigger('click');
			}
			
			
			function save_tables()
			{
			 if($.trim($("#floor_no").val()) =='')
			{
			
			$('#error_sucess').html('Please enter floor');
			return false;
			}
			var tables = new Array();
			$("input:text[name=tables]").each(function(){
			tables.push($(this).val());
			});
			var images = new Array();
			$("input:text[name=images]").each(function(){
			images.push($(this).val());
			});
			var table_no = new Array();
			$("input:text[name=table_no]").each(function(){
			table_no.push($(this).val());
			});
			var serialno = new Array();
			$("input:text[name=serialno]").each(function(){
			serialno.push($(this).val());
			});
			var table_type = new Array();
			$("input:text[name=table_type]").each(function(){
			table_type.push($(this).val());
			});
			var business_id=$('#business_id').val();
		    $.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/updatefloor",
			data :	{'no_of_floors':$("#no_of_floors").val(),'floor_no' : $("#floor_no").val(),'tables':tables,'serialno':serialno,'table_no':table_no,'no_of_tables':$("#no_of_tables").val(),'images':images,
			'no_of_rows':$("#no_of_rows").val(),'no_of_columns':$("#no_of_columns").val(),'floor_id':$("#floor_id").val(),'business_id':business_id,'table_type':table_type},
			success : function(data){
          
			$('#error_save').html(data);
				
		       window.location='<?php echo base_url();?>bookmyt/floors';
					
			

			}

			});   
			
			}
			function delete_table(id)
			{
			
				$('#save_images_'+id).val('');
				$('#table_type_'+id).val('');
				$('#change_capacity_'+id).html('');

				$('#no_seats_'+id).val('');	
				$('#table_no'+id).val('');
				var selectedval=$('#selectpicker_'+id).val();
				
				$('#selectpicker_'+id+' option[value='+selectedval+']').attr('selected',false);
				$('#selectpicker_'+id+' option[value=""]').attr('selected','selected');
				$('#selectpicker_'+id+' option:selected').text('Table Type');
				 $('#selectpicker_'+id).attr("title", 'Table Type');
				$('#change_color_'+id).removeClass($('#change_color_'+id).attr('class'));
				$('#change_color_'+id).addClass('tb rectangle six green');
			
			}
	  </script>