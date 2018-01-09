  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Edit Section</h4>
          <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div><div class='clearfix'></div>
		<center>
			<!--<span style="font-weight:bold;color:red;padding:10px !important;" id="error_sucess"></span>
			<span style="font-weight:bold;color:green;padding:10px !important;" id="error_save"></span>-->
			<center><span style="font-weight:bold;color:red;padding:10px !important;" id="error_sucess"></center>
			</center>
        <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
            <div class="panelone  plr10">             
			 <form role="form" class="wrap mt10" >
			   <input type="text" style="display:none" placeholder="Enter your Floor Name" class="form-control" id="floor_id"  name="floor_no no_of_columns" value="<?php echo $floor_id;?>">
			   <input type="hidden" name="section_id" id="section_id" value="<?php echo $section_id; ?>" />
			   <input type="hidden" name="relationship_id" value="<?php echo $this->session->userdata('business_id');?>" />
			   <?php
				
				if($this->session->userdata('branch') == '0')
				{
					if($this->session->userdata('have_branches') == '0')
					{
				?>
						<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
			
				<?php
					}
					else
					{
						if($floor_info[0]['business_id'] == $this->session->userdata('business_id'))
						{
				?>
							<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
				<?php
						}
						else
						{
				?>
							<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $floor_info[0]['business_id'];?>" name="branch" id="business_id">	
							
				<?php
						}
					}
				}
				else
				{
				?> 
					<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
				
				<?php
				}
				?>			   
			   
                <div class="form-group col-md-6">
				<label class="form-lable "> Section Name<span class="star">*</span></label>	
				 <input type="text" placeholder="" class="form-control" id="floor_no" maxlength="25" name="floor_no no_of_columns" required value="<?php echo $floor_info[0]['section_name'];?>">
                </div>
                <div class="form-group col-md-6">
				<label class="form-lable ">No of Tables<span class="star">*</span></label>
				 <input type="text" placeholder="" class="form-control no_of_columns"  maxlength="2"  name="no_of_tables" required id="no_of_tables" value="<?php echo $floor_info[0]['no_of_tables'];?>" >
                </div>
                <div class="form-group col-md-6">
				<label class="form-lable ">No of rows</label>
				 <input type="text" placeholder="" class="form-control no_of_columns"   maxlength="2" name="no_of_rows" required id="no_of_rows" value="<?php echo $floor_info[0]['no_of_rows'];?>" > <br/>
                </div>
                <div class="form-group col-md-6">
				<label class="form-lable "> No of Columns</label>
				 <input type="text" placeholder="" maxlength="2" class="form-control no_of_columns"   name="no_of_columns" required id="no_of_columns" value="<?php echo $floor_info[0]['no_of_columns'];?>" >
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="floor-layout" style="text-align:center">
    <div class="table-responsive" id="sub_cat_data">
    <?php
	
	$floor_array=array();
	//pr($floor_info);
	foreach($floor_info as $floor_info1)
	{
	$floor_array[$floor_info1['serial_no']]=$floor_info1;
	}
	
	//echo '<pre>';print_r($floor_array);
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
			$style1='';
			if(isset($floor_array[$x.''.$n]['table_type']) && $floor_array[$x.''.$n]['table_type']!='')
			{
				if($floor_array[$x.''.$n]['no_of_seats']>8)
				{
					if($floor_array[$x.''.$n]['Booked_Status']==0)
					{
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 green';
					}else{
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 red';
						$style1='display:none';
					}
				 }else
				 {
					if ($floor_array[$x.''.$n]['no_of_seats'] % 2 == 0) 
					{
						if($floor_array[$x.''.$n]['Booked_Status']==0)
						{
							$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' green'; 
						}else{
							$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' red'; 
							$style1='display:none';
						}
					}else
					{
						$number=$floor_array[$x.''.$n]['no_of_seats']+1;
						if($floor_array[$x.''.$n]['Booked_Status']==0)
						{
							$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' green'; 
						}else{
							$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' red'; 
							$style1='display:none';
						}
					}
				 
				 }
				$no_of_seats=$floor_array[$x.''.$n]['no_of_seats'];
				$table_no=$floor_array[$x.''.$n]['table_no'];
				if($no_of_seats > 8){
					$table_no= "Table ".$table_no;
				}else{
					$table_no= "Table ".$table_no;
				}
				$edit="Edit";
			}
			else
			{
				$class='tb rectangle six green';
				$no_of_seats='';
				$table_no='';
				$edit='';
				$style1 = 'display:none';
			}
			if($edit == "Edit")
			{
				$style ="";
			}
			else
			{
				$style = 'style="display:none"';
			}
			
			$output.= '<td><div class="'.$class.'" id="change_color_'.$k.'"><span id="change_capacity_'.$k.'" >'.$no_of_seats.'</span><div class="table-cont" id="change_table_'.$k.'">'.$table_no.'</div><div class="hover" style="'.$style1.'"><a href="javascript:void(0)" id="click_model_'.$k.'" title="'.$x.'" onclick="click_model('.$k.')" data-toggle="modal" data-target="#myModal_'.$k.'"  class="btn btn-xs btn-default mt10"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="javascript:void(0)"  title="'.$x.'" onclick="delete_table('.$k.')" id="del_'.$k.'" class="btn btn-xs btn-default mt10" '.$style.'><i class="fa fa-trash-o" aria-hidden="true"></i></a></div></div><input type="text" style="display:none" id="click_input_'.$k.'" value="" /><input type="text" style="display:none" value="'.$x.''.$n.'" name="serialno" /></td>
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
				}else{
					if ($floor_array[$x.''.$y]['no_of_seats'] % 2 == 0) {
						$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$floor_array[$x.''.$y]['no_of_seats'].' green'; 
					}else{
						$number=$floor_array[$x.''.$y]['no_of_seats']+1;
						$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$number.' green'; 
					}
				}
				$no_of_seats=$floor_array[$x.''.$y]['no_of_seats'];
			}else{
				$class='tb rectangle six green';
				$no_of_seats='';
			}		
			$output.= '<td><div class="'.$class.'" id="change_color_'.$y.'">'.$no_of_seats.'<div class="hover"><a href="javascript:void(0)" id="click_model_'.$y.'" title="'.$y.'" onclick="click_model('.$y.')" data-toggle="modal" data-target="#myModal_'.$y.'"  class="btn btn-xs btn-default mt10 "><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="javascript:void(0)"  title="'.$y.'" onclick="delete_table('.$y.')"  class="btn btn-xs btn-default mt10" ><i class="fa fa-trash-o" aria-hidden="true"></i></a></div></div><input type="text" style="display:none" id="click_input_'.$y.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="serialno" /></td>
			';
			$y++;
		}
		$output .= '</tr>
		</table>';
       echo $output;
		 
		 ?>
  </div>
  </div>
  <div class="form-group col-md-9"><a href="<?php echo base_url().'bookmyt/section_list/'.$floor_id; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a> <button  class="btn btn-success pull-right icon-btn" type="button" onclick="return save_tables();" id="save_button"> <i class="fa fa-plus-circle"></i> Update Section</button> </div>
   
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
		   <span style="color:red" id="error_p"></span>
		   <span style="color:red;font-weight:bold" id="tn<?php echo $i; ?>"></span>
		   <div class="form-group">
		   <label class="form-lable ">Table Number<span class="star">*</span></label>
		   
            <input type="text"  placeholder="" value="<?php echo $floor_info1['table_no'];?>"   id="table_no<?php echo $i;?>"   name="table_no" maxlength="3" class="form-control">
			 <span style="color:red" id="error_p"></span>
          </div>
          <div class="form-group">
		  <label class="form-lable ">No of seats<span class="star">*</span></label>
            <input type="text"  placeholder="" value="<?php if($floor_info1['no_of_seats'] != 0) { echo $floor_info1['no_of_seats']; } else {} ?>"  maxlength="2" id="no_seats_<?php echo $i;?>"   name="tables"  class="form-control">
          </div>
            <div class="form-group">
			 <label class="form-lable ">Table type<span class="star">*</span></label>
			<select class="selectpicker" id="selectpicker_<?php echo $i;?>">
			
			<option value="" style="display:none;">Table Type</option>
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
            
			
			
			$(".no_of_columns,#no_of_rows").keyup(function() 
			{
				var no_of_tables=$("#no_of_tables").val();
				var no_of_rows=$("#no_of_rows").val();
				var no_of_columns=$("#no_of_columns").val();
				table_no = [];
				
				if(parseInt(no_of_rows)>10)
				{
					$('#error_sucess').html("Please enter no of rows less than or equal to 10.");
					return false;
				}
				if(parseInt(no_of_columns)>10)
				{
					$('#error_sucess').html("Please enter no of columns less than or equal to 10.");
					return false;
				}
				$("input:text[name=table_no]").each(function()
				{
					if($(this).val()!='')
					{
						table_no.push($(this).val());
					}
				});
				
				if(table_no.length > no_of_tables)
				{
				 $('#error_sucess').show();
					$('#error_sucess').html("No of tables should not be less than floor tables");
				   $('#save_button').prop('disabled', true);
					return false;
				}else
				{
				$('#save_button').prop('disabled', false);
				}
			  	if(parseInt(no_of_tables) > (parseInt(no_of_columns))*(parseInt(no_of_rows)))
				{
					$('#error_sucess').show();
					$('#error_sucess').html("Multiplication of columns and rows should be grater than no of tables.");
					return false;
				}
				else
				{
					$('#error_sucess').html("");
				}
			   
				
				$.ajax({
				type :	"POST",
				url	 :	"<?php echo base_url();?>bookmyt/tables_arrange_edit",
				data :	{'no_of_tables' : $("#no_of_tables").val(),'no_of_rows' : $("#no_of_rows").val(),'no_of_columns' : $("#no_of_columns").val(),'floor_id':$("#floor_id").val()},
				success : function(data)
				{	
				   $('#sub_cat_data').html(data);
					$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url();?>bookmyt/getpopup_edit",
					data :	{'no_of_tables' : $("#no_of_tables").val(),'floor_id':$("#floor_id").val(),'no_of_rows' : $("#no_of_rows").val(),'no_of_columns' : $("#no_of_columns").val()},
					success : function(data1)
					{
						$('#load_popup_data').html(data1);
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
				var shape=$('#selectpicker_'+id).val();	
				var seats=$('#no_seats_'+id).val();
				
				
				$('#table_no'+id).change(function()
				{
					if($('#table_no'+id).val() != "")
					{
						$('#table_no'+id).removeClass('error');
					}
				});
				
				$('#no_seats_'+id).change(function()
				{
					if($('#no_seats_'+id).val() != "")
					{
						$('#no_seats_'+id).removeClass('error');
					}
				});
				
				$('#selectpicker_'+id).change(function()
				{
					if($('#selectpicker_'+id).val() != "")
					{
						$("[data-id=selectpicker_"+id+"]").removeClass('error');
					}
				});
				
				
				

				var bad = [];
				if(t_nos == "")
				{
					bad.push('e1');
				}
				if(seats == "" || seats == '0')
				{
					bad.push('e2');
				}
				if(shape == "")
				{
					bad.push('e3');
				}
				
				if(bad.length != 0)
				{
					if($.inArray("e1", bad) !== -1){ $('#table_no'+id).addClass('error'); } else { $('#table_no'+id).removeClass('error'); }
					if($.inArray("e2", bad) !== -1){ $('#no_seats_'+id).addClass('error'); } else { $('#no_seats_'+id).removeClass('error'); }
					if($.inArray("e3", bad) !== -1){ $("[data-id=selectpicker_"+id+"]").addClass('error');	 } else { $("[data-id=selectpicker_"+id+"]").removeClass('error'); }
					return false;
				}
				else
				{
					$('#table_no'+id).removeClass('error');
					$('#no_seats_'+id).removeClass('error');
					$("[data-id=selectpicker_"+id+"]").removeClass('error');
					bad = [];
				}
				
				
			
				
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
					$("#tn"+id).html("Table number already exists");	
					$('#table_no'+id).addClass('error');
					$('#no_seats_'+id).val('');  
					$('#table_no'+id).val(''); 
					return false;
					
				}
				else
				{
					$("#tn"+id).html("");
					$('#table_no'+id).removeClass('error');
					table_no.push(t_nos);
				}
				var no_of_tables=parseInt($('#no_of_tables').val());
			
				if(table_no.length > no_of_tables)
				{
				 
					//$(".close").click();
					
					$("#tn"+id).html("You can't add the table more than No of tables!");
					$('#no_seats_'+id).val('');  
					$('#table_no'+id).val(''); 			
					return false;	
				}
				else
				{
					$("#tn"+id).html("");
				}
				table_no.push(t_nos);				
						
			
				$('#del_'+id).show();				
				

				var text = $('#click_model_'+id).text();
				
				if($('#del_'+id).show())
				{
					$('#click_model_'+id).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
				}
				else
				{
					$('#click_model_'+id).html('<i class="fa fa-plus" aria-hidden="true"></i>');
				}
				
				$('#table_no'+id).val(t_nos);
				$('#save_images_'+id).val(seats1+''+shape+'.jpg');
				if(seats > 8)
				{
				$('#change_capacity_'+id).html(seats);
				}else
				{
				$('#change_capacity_'+id).html(seats);
				}
				$("#change_table_"+id).html("Table "+t_nos);
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
				$(".hover").hide();
				
				
				
			}
			
			
			function save_tables()
			{
				var error = [];
				var no_of_tables=$("#no_of_tables").val();
				
				var no_of_rows=parseInt($("#no_of_rows").val());
				var no_of_columns=parseInt($("#no_of_columns").val());
				
				if(no_of_rows>10)
				{
					$('#error_sucess').html("Please enter no of rows less than or equal to 10.");
					return false;
				}
				if(no_of_columns>10)
				{
					$('#error_sucess').html("Please enter no of columns less than or equal to 10.");
					return false;
				}
				if(parseInt(no_of_tables) > (parseInt(no_of_columns))*(parseInt(no_of_rows)))
				{		
					$("#error_sucess").show();
					$('#error_sucess').html("Multiplication of columns and rows should be grater than no of tables.");	
					return false;
				}
				else
				{				
					$('#error_sucess').html("");
				}
				
				if($.trim($("#business_id").val()) =='')
				{
					error.push('e1');
				}
				if($.trim($("#floor_no").val()) =='')
				{
					error.push('e2');
				}
				if($.trim($("#no_of_tables").val()) =='' || $.trim($("#no_of_tables").val()) == 0)
				{
					error.push('e3');
				}
				if($.trim($("#no_of_rows").val()) =='0')
				{
					error.push('e4');
				}
				if($.trim($("#no_of_columns").val()) =='0')
				{
					error.push('e5');
				}
				
				if(error.length != 0)
				{
					if($.inArray("e1", error) !== -1){ $("#business_id").addClass('error'); } else { $("#business_id").removeClass('error'); }
					if($.inArray("e2", error) !== -1){ $("#floor_no").addClass('error'); } else { $("#floor_no").removeClass('error'); }
					if($.inArray("e3", error) !== -1){ $("#no_of_tables").addClass('error'); } else { $("#no_of_tables").removeClass('error'); }
					if($.inArray("e4", error) !== -1){ $("#no_of_rows").addClass('error'); } else { $("#no_of_rows").removeClass('error'); }
					if($.inArray("e5", error) !== -1){ $("#no_of_columns").addClass('error'); } else { $("#no_of_columns").removeClass('error'); }
					return false;
				}
				else
				{
					$("#business_id").removeClass('error');
					$("#floor_no").removeClass('error');
					$("#no_of_tables").removeClass('error');
					$("#no_of_rows").removeClass('error');
					$("#no_of_columns").removeClass('error');error = [];
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
			
			var avail = [];
			avail = $.grep(table_no,function(n){ return (n); });
			
			var business_id=$('#business_id').val();
			if(avail.length > parseInt(no_of_tables))
			{
					$("#error_sucess").html("No of tables are not match with allocated tables.");
					return false;
			}
			else
			{
				$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url();?>bookmyt/updatesection",
					data :	{'no_of_floors':$("#no_of_floors").val(),'floor_no' : $("#floor_no").val(),'tables':tables,'serialno':serialno,'table_no':table_no,'no_of_tables':$("#no_of_tables").val(),'images':images,
					'no_of_rows':$("#no_of_rows").val(),'no_of_columns':$("#no_of_columns").val(),'floor_id':$("#floor_id").val(),'business_id':business_id,'table_type':table_type,'section_id':$("#section_id").val()},
					success : function(data)
						{
							alert(data);
							window.location='<?php echo base_url();?>bookmyt/section_list/'+$("#floor_id").val();			
						}
					});   
				$("#error_sucess").html("");
			}
			
			
		    
			
			}
			
			$("#floor_no,#no_of_tables,#no_of_rows,#no_of_columns").change(function()
			{
				if($.trim($("#floor_no").val()) !='')
				{
					$("#floor_no").removeClass('error');
					
				}
				if($.trim($("#no_of_tables").val()) !='')
				{
					$("#no_of_tables").removeClass('error');
					
				}
				if($.trim($("#no_of_rows").val()) !='0')
				{
					$("#no_of_rows").removeClass('error');
					
				}
				if($.trim($("#no_of_columns").val()) !='0')
				{
					$("#no_of_columns").removeClass('error');
				}
				
			});
			
			
			
			function delete_table(id)
			{
			
				if(confirm("Are you sure to delete this table")){
					$('#save_images_'+id).val('');
					$('#table_type_'+id).val('');
					$('#change_capacity_'+id).html('');
					var no_of_tables=$('#no_of_tables').val();
					table_no=[];
					 if(table_no.length > no_of_tables)
					{
					 $('#error_sucess').show();
						$('#error_sucess').html("No of tables should not be less than floor tables");
					   $('#save_button').prop('disabled', true);
						return false;
					}else
					{
					$('#error_sucess').html("");
					$('#save_button').prop('disabled', false);
					} 
					$('#no_seats_'+id).val('');	
					$('#table_no'+id).val('');
					var selectedval=$('#selectpicker_'+id).val();
					
					$('#selectpicker_'+id+' option[value='+selectedval+']').attr('selected',false);
					$('#selectpicker_'+id+' option[value=""]').attr('selected','selected');
					$('#selectpicker_'+id+' option:selected').text('Table Type');
					 $('#selectpicker_'+id).attr("title", 'Table Type');
					$('#change_color_'+id).removeClass($('#change_color_'+id).attr('class'));
					$('#change_color_'+id).addClass('tb rectangle six green');
					$('#del_'+id).hide();
					var text = $('#click_model_'+id).text();
					if($.trim(text) == 'add')
					{
						$('#click_model_'+id).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					}
					else
					{
						$('#click_model_'+id).html('<i class="fa fa-plus" aria-hidden="true"></i>');
					}
				}
			}
			
			$("body").delegate('.tb','click',function(){
				$(".hover").hide();
				$(".hover",this).show();
			});
			$("body").delegate('.red','click',function(){
				$(".hover").hide();
				$(".hover",this).hide();
			});
			/*$(".six").click(function(){
				$(".hover").hide();
				$(".hover",this).hide();
			});*/
			
			
			
	  </script>
	  
	  
	  