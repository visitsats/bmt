<style type="text/css">
.ui-datepicker-year{ display:none !important;}
</style>
<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Walkin Details</h4>
		 </div>
		 <div class="clearfix"></div>
			
			<?php			
				if($this->session->flashdata('success'))
				{
			?>			
				<div class='alert alert-success text-center' id='ss_fo'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('success'); ?></strong></div>		
			<?php
				}
				if($this->session->flashdata('fail'))
				{
			?>
				<div class='alert alert-danger text-center'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('fail'); ?></strong> </div>	
			<?php
				}
			?>
			
			 <center><b><span style="color:green" id="sucess"></span><span style="color:green" id="reslt"></span><span style="color:red" id="error"></span></b></center>
			
        <div class="wrap mnone">
          <div class="col-xs-12 "> 		  
			<form name="guest_add" method="post" id="guest_add" class="wrap mnone" action="">			
				<div class="form-group col-md-2">
					<label class="form-lable ">Guest Phone<span class="star">*</span></label>
					<input type="text" required name="phone_no" id="phone_no" maxlength='13' class="form-control" placeholder="">  
				</div>
					 
				<div class="form-group col-md-2">
					<label class="form-lable ">Guest Name<span class="star">*</span></label>
					<input type="text" required name="name" id="name" class="form-control" maxlength="20" placeholder="">
				</div>
				<!--   
				<div class="form-group col-md-2">
					<label class="sr-only" for="name">Date</label>
					<input type="text" required class="form-control datepicker" id="booked_date" placeholder="Enter Date" >
				</div>
				
				<div class="form-group col-md-2">
					<label class="sr-only" for="name">In time</label>
					<input type="text" required id="in_time" name="in_time" class="form-control" placeholder="Enter Your In Time">
				</div>	--> 
					
				<div class="form-group col-md-2">
				<label class="form-lable ">No Of Guests<span class="star">*</span></label>
				<input type="text" placeholder="" class="form-control"   name="table_for" required id="select_no_of_members1" >
				</div>	
				<div class="form-group col-md-3" style="display:none">
					<label class="form-lable ">Select Floor<span class="star">*</span></label>
					 <select  class="selectpicker" id="floor" name="floor" required>
					 <?php if(empty($floors_info)) 
					 { 
					 ?>
						<option value="" style="display:none;">Select Floor</option>
						<?php
						}
							if(isset($floors_info) && !empty($floors_info))
							{
								foreach($floors_info as $floors1)
								{
									if($floors1['section_id']!=""){
										$section_ids=explode(",",$floors1['section_id']);
										$section_names=explode(",",$floors1['section_name']);
										$sections=array_combine($section_ids,$section_names);
										foreach($sections as $key=>$value){
							?>
											<option value="<?php echo $floors1['floor_id']."_".$key."_".$floors1['business_id']; ?>" ><?php echo $value." - ".$floors1['floor_no'].' - '.$floors1['business_name']; ?></option>
							<?php
										}
									}
								}
							}
							?>
					
				 </select>
				</div>			
				<div class="form-group col-md-1">
				<label class="form-lable ">Fav. Date</label>
				<input type="text"  class="form-control datepicker" name="date_of_birth" id="date_of_birth" placeholder="" >
				</div>
				<div class="form-group col-md-1">
				<label class="form-lable ">Is VIP?</label>
				<input type="checkbox" class="form-control"   name="is_vip" id="is_vip" value="1" >
				</div>
				
				
				<div class="form-group col-md-1 text-left mt30 text-right-xs">
				<a href="" class="btn btn-success btn-xss">Clear</a>
				</div>		
				  
				</form>
				<div class="wrap " id="table_data">
				
			  </div>
			  <div class="wrap mnone">
			  <h4>Ongoing Dining</h4>
			
			    <div class="table-responsive">
                <table class="table table-style-one table-striped " >
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>phone</th>
                      <th>Start Time</th>
                   
					   <th class="text-center">No of members</th>
					   <th>Floor</th>
					     <th>Table No</th>
					   <th>Booked Date</th>
					   
                      <th class="text-center">Actions</th>
                    
                    </tr>
                  </thead>
                  <tbody id="append_data">
				  <?php
					if(count($res_list->res_list) != '0')
					{
					  foreach($res_list->res_list as $branches)
					  {
					 
					  ?>
						<tr id="remove_div_<?php echo $branches->reservation_id;?>">
						  <td id="name:<?php echo $branches->reservation_id;?>" contenteditable="false"><?php echo $branches->name;?></td>
						  <td id="phone_no:<?php echo $branches->reservation_id;?>" contenteditable="false"><?php echo $branches->phone_no;?></td>
						  <td id="in_time:<?php echo $branches->reservation_id;?>" contenteditable="false"><?php echo date("g:i A", strtotime($branches->in_time));?></td>
					   
						 <td class="text-center" id="table_for:<?php echo $branches->reservation_id;?>" contenteditable="false"><?php echo $branches->table_for;?></td>
						 <td id="floor_no:<?php echo $branches->reservation_id;?>" contenteditable="false"><?php echo $branches->floor_no.' - '.$branches->business_name;?></td>						 
						 <?php
						 	if($branches->table_nos==""){
						 ?>	
						 <td id="table_n:<?php echo $branches->reservation_id;?>"  contenteditable="false">Table No - <?php echo $branches->table_no;?></td>
						 <?php
						 	}else{
						?>
							<td id="table_n:<?php echo $branches->reservation_id;?>"  contenteditable="false">Table No - <?php echo $branches->table_no.",".$branches->table_nos;?></td>
						<?php
							}
						?>
						  <td id="booked_date:<?php echo $branches->reservation_id;?>" contenteditable="false"><?php $date = date_create($branches->booked_date); echo date_format($date,'d-M-Y');?></td>
					   
						  <td class="text-center">
							
							<?php 
							
							if($branches->visits>=3)
							{
								echo '<img src="'.base_url().'theme/images/star.png" width="22" style="padding-top:8px;">&nbsp;';
							}
							else{
								echo '<img src="'.base_url().'theme/images/star-d.png" width="22" style="padding-top:8px;">&nbsp;';
							}
							
							if(date('Y-').date('m-d',strtotime($branches->date_of_birth)) == date('Y-m-d'))
							{
								echo '<img src="'.base_url().'theme/images/birthday.png" width="22" style="padding-top:8px;">&nbsp;';
							}
							else{
								echo '<img src="'.base_url().'theme/images/birthday-d.png" width="22" style="padding-top:8px;">&nbsp;';
							}
							
							if($branches->is_vip ==1)
							{
								echo '<img src="'.base_url().'theme/images/vip.png" width="22" style="padding-top:8px;">&nbsp;';
							}
							else{
								echo '<img src="'.base_url().'theme/images/vip-d.png" width="22" style="padding-top:8px;">&nbsp;';
							}
							?>
							<div class="action done three black">
							<?php
							if($branches->confirmed==1)
							{
							?>
								<a href="<?php echo base_url()."bookmyt/feedback/".$branches->reservation_id; ?>" class="btn btn-success btn-xss pull-left"> Done </a>
							<?php
								if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') 
								{
									echo "";
								} 
								else
								{							
							?>
								<span class="divider"></span>
								<a href="javascript:void(0)" data-toggle="modal" data-target="#myModal_<?php echo $branches->reservation_id;?>" class="edit-sm-icon" title="Edit" onclick = "get_tablesbyfloor(<?php echo $branches->reservation_id;?>)"></a>
								<span class="divider"></span>
								<a href="<?php echo base_url()."bookmyt/delete_reservation1/".$branches->reservation_id;?>" class="cancel-sm-icon" title="Cancel" onclick = "if(confirm('Are you sure you want to cancel reservation')) { return true; } else {return false; }"></a>
						
							<?php
								}
							}
							?>
						  </td>
						</tr>
						<div class="modal fade" id="myModal_<?php echo $branches->reservation_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog" style="width:300px;">
							  <div class="modal-content">
								<div class="modal-body ">
								  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								 
								  <div class="clearfix"></div>
								  <h4 class="text-center mt10">Edit Reservation</h4>
								   <center><b><span style="color:red" id="error_<?php echo $branches->reservation_id;?>"></span></b></center>
								   <span style="color:red;font-weight:bold" id="tn3"></span>
								   <div class="form-group">
								   <label class="form-lable ">No Of Guests<span class="star">*</span></label>
								    <input value="<?php echo $branches->phone_no;?>" id="phone_no_<?php echo $branches->reservation_id;?>" name="phone_no_<?php echo $branches->reservation_id;?>" type="hidden">
									<input placeholder="" value="<?php echo $branches->table_for;?>" id="no_guests_<?php echo $branches->reservation_id;?>" name="no_guests" maxlength="3" class="form-control" type="text">
									 <span style="color:red" id="error_p"></span>
								  </div>
								  <div class="form-group">
								  <label class="form-lable ">Date<span class="star">*</span></label>
									<input placeholder="" value="<?php $date = date_create($branches->booked_date); echo date_format($date,'d-M-Y'); ?>" name="booked_date" id="booked_date_<?php echo $branches->reservation_id;?>" class="form-control booked_date datepicker" type="text">
								  </div>
								  <div class="form-group">
									<label class="form-lable ">In Time<span class="star">*</span></label>
									<input type="text" value="<?php echo date("g:i A", strtotime($branches->in_time)); ?>" id="in_time_<?php echo $branches->reservation_id;?>" name="in_time" class="form-control in_time" placeholder="">
								  </div>
								 <div class="form-group">
									<label class="form-lable ">Floor<span class="star">*</span></label>
									
								    <select  class="selectpicker" id="floor_<?php echo $branches->reservation_id;?>" name="floor">
									 <?php if(empty($floors_info)) 
									 { 
									 ?>
									<option value="" style="display:none;">Select Floor</option>
									<?php
									}
									if(isset($floors_info) && !empty($floors_info))
									{
										foreach($floors_info as $floors1)
										{
									?>
									<option value="<?php echo $floors1['floor_id']; ?>" <?php echo ($floors1['floor_id'] == $branches->floor_id) ? 'selected="selected"': ''?>><?php echo $floors1['floor_no'].' - '.$floors1['business_name']; ?></option>
									<?php
										}
									}
									?>
								 </select>
								 </div>
								 <div class="form-group">
									<div id="table_floor_<?php echo $branches->reservation_id;?>"></div>
								</div>
								<?php if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";}else{ ?>
								<div class="form-group">
								<button type="button" class="btn btn-success modal-login-btn" onclick="update_table('<?php echo $branches->reservation_id;?>')">Update</button>
								</div>
								<?php } ?>
								</div>
							  </div>
							</div>
						  </div>
						<?php
						}
					}
					else
					{
					?>
						<tr><td colspan="8" class="text-center"><span style="color:red">No Records Found.</span></td></tr>
					<?php
					}
					?>
             
                  </tbody>
                </table>
              </div>
			   </div>
						
           
			
			
			
          </div>
        </div>
      </div>
    </div>
  </div>
  

<script type="text/javascript" src="<?php echo base_url();?>theme/js/daterangepicker.js"></script> 
    <script type="text/javascript" src="<?php echo base_url();?>theme/js/jquery.timepicker.min.js"></script>
	  <link rel="stylesheet" href="<?php echo base_url();?>theme/css/jquery.timepicker.min.css" type="text/css"/>
	  
	  <script src="<?php echo base_url().'theme/js/jquery-ui.js'; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'theme/css/jquery-ui.css'; ?>" />

	<link rel="stylesheet" href="<?php echo base_url().'theme/css/qunit.css'; ?>" type="text/css"/>
   
	  
<script language="javascript">


	$(document).ready(function()
	{
			$('.selectpicker').selectpicker('refresh')
			$('#date_of_birth').datepicker({
				'changeMonth'		: true,
				'changeYear'		: false,
				'dateFormat'		: 'dd-MM',
				'showButtonPanel'	: false,
			});	
			$("#name").change(function()
			{
				if($.isNumeric($("#name").val()))
				{
					$('#error').show();
					$('#error').html("Name sholud not be numeric");
					$("#name").addClass('error');
					$('#error').fadeOut(2000);
					return false;
				}
				else
				{
					$('#error').html("");
					$("#name").removeClass('error');
				}
				
			});
			
            $('#phone_no,#select_no_of_members1').keydown(function(event) 
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
            
        
		   var floor_id=$("#floor").val().split("_");
		   var flr_id=floor_id[0];
		   var section_id=floor_id[1];
		   var business_id=floor_id[2];
			$.ajax({
				type :	"POST",
				url	 :	"<?php echo base_url();?>bookmyt/get_table_data",
				data :	{'floor_id':flr_id,'section_id':section_id,'business_id':business_id},
				success : function(data){

				$('#table_data').html(data);

				}

				});
         
		 
		    $("#floor").change(function()
			{
				var floor_id = $("#floor").val().split("_");
			   var flr_id=floor_id[0];
			   var section_id=floor_id[1];
			   var business_id=floor_id[2];
				var select_no_of_members=$('#select_no_of_members1').val();
				$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url();?>bookmyt/get_table_data",
					data :	{'floor_id':flr_id,'section_id':section_id,'business_id':business_id,'select_no_of_members':select_no_of_members},
					success : function(data)
					{
						$('#table_data').html(data);
					}
					});
			});
			$("[id^=floor_]").change(function() {
				var id = $(this).attr('id').substr(6);
				$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url();?>bookmyt/get_tables_edit",
					data :	{'no_of_members' : $("#no_guests_"+id).val(),'floor_id':$(this).val(), 'reservation_id':id, 'res_edit':1},
					success : function(data)
					{
						$('#table_floor_'+id).html(data);
					}
				});
			});
			
			// $("#phone_no").change(function()
			// { 
				
				// var phone_no = $("#phone_no").val();
				
				// $.ajax({
					// type :	"POST",
					// url	 :	"<?php echo base_url().'bookmyt/get_names'; ?>",
					// data :	{'phone' : phone_no},
					// success : function(data)
					// {
						// $('#name').val($.trim(data));					
					// }

				// });
			// });
			
			$("#phone_no").change(function()
			{ 
				if($("#phone_no").val() != "")
				{					
					$("#phone_no").removeClass('error');		
				}
				var phone_no = $("#phone_no").val();					
				$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url().'bookmyt/get_names'; ?>",
					data :	{'phone' : phone_no},
					dataType: "json",
					success : function(data)
					{
						if($.trim(data) != 1)
						{
							$('#name').val($.trim(data.name));	
							$('#date_of_birth').val($.trim(data.dob));	
							$('#is_vip').prop('checked',data.is_vip);	
						}
						else
						{
							//$('#error').html("");
							$("#phone_no").removeClass('error');
							$("#table_data").show();
						}
						//$('#name').val($.trim(data));					
					}
				});
			});
			$('.booked_date').datetimepicker({
				timepicker:false,
				format:'d-M-Y',
				formatDate:'Y-m-d',
				minDate: 0
			});
			$('#in_time').timepicker();
			$('.in_time').datetimepicker({
				datepicker:false,
				format:'g:i A',
				formatTime: 'g:i A',
				step:15,
				ampm: true
			});
			
	});
		function get_tablesbyfloor(res_id)
		{
			$("#floor_"+res_id).trigger('change');
		}
		function validate_guest(frm)
		{
			var notReq = Array();
			var ok = true;
			if(required(frm,notReq))
			{
				ok = false;
			}
			return ok;

		}

function book_table(table_id)
{
	
  	var name=$.trim($('#name').val());
	var phone_no=$.trim($('#phone_no').val());
	var select_no_of_members=$('#select_no_of_members1').val();
	
  if(phone_no !='')
	{
		if(phone_no.length < 10 )
		{
			$('#error').show();
			$('#error').html('phone number should be more than 10 digits');
			$('#phone_no').addClass('error');
			$('#error').fadeOut(2000);	
			return false;
		}
		else
		{
			$('#error').html('');
			$('#phone_no').removeClass('error');
		}
	}
	else
	{
		$('#error').html('');
		$('#phone_no').removeClass('error');
	}
    
	if(name=='')
	{
		$('#error').show();
		$('#error').html('Please enter guest name');
		$('#name').addClass('error');
		$('#error').fadeOut(2000);
		return false;
	}
	else if(name!='')
	{
		if($.isNumeric(name))
		{
			$('#error').show();
			$('#error').html("Name sholud not be numeric");
			$("#name").addClass('error');
			$('#error').fadeOut(2000);
			return false;
		}
		else
		{
			$('#error').html("");
			$("#name").removeClass('error');
		}
	}
	else
	{
		$('#error').html('');
		$('#name').removeClass('error');
	}
	
	
	if(select_no_of_members=='')
	{
	
		$('#error').show();
		$('#error').html('Please enter no of members');
		$('#select_no_of_members1').addClass('error');
		$("#error").fadeOut(2000);
		return false;
	}
	else
	{
		$('#error').html('');
		$('#select_no_of_members1').removeClass('error');
	}
	
	var floor=$.trim($('#floor').val());
	var is_vip=$.trim($('#is_vip:checked').val());
	//alert(is_vip);
	$.ajax({
		type :	"POST",
		url	 :	"<?php echo base_url();?>bookmyt/quick_reservation",
		data :	{'name':name,'phone_no' : phone_no,'table_id':table_id,'table_for':select_no_of_members,'floor':floor,'is_vip':is_vip},
		success : function(data)
		{
			
			$('#sucess').html("Table is alloted.");
			$('#append_data').prepend(data);
		}

	});


}
function update_table(res_id)
{
	var error = [];			
	var booked_date=$('#booked_date_'+res_id).val();
	var in_time=$('#in_time_'+res_id).val();
	var no_mem = $('#no_guests_'+res_id).val();
	var floor = $('#floor_'+res_id).val();
	var table_id = $('#table_id_'+res_id).val();
	
	var phone_no = $('#phone_no_'+res_id).val();
	var res_id = res_id;
	if(no_mem == ''|| no_mem == 0)
	{
		error.push('e3');
	}
	if(booked_date == '')
	{
		error.push('e4');
	}
	if(in_time == '')
	{
		error.push('e5');
	}
	if(error.length != 0)
	{
		if($.inArray("e3", error) !== -1){ $("#no_mem_"+res_id).addClass('error'); } else { $("#no_mem_"+res_id).removeClass('error'); }
		if($.inArray("e4", error) !== -1){ $("#booked_date_"+res_id).addClass('error'); } else { $("#booked_date_"+res_id).removeClass('error'); }
		if($.inArray("e5", error) !== -1){ $("#in_time_"+res_id).addClass('error'); } else { $("#in_time_"+res_id).removeClass('error'); }
		return false;
	}
	else
	{
		$("#no_mem_"+res_id).removeClass('error');
		$("#booked_date_"+res_id).removeClass('error');
		$("#in_time_"+res_id).removeClass('error');
		error = [];
	}
	$.ajax({
		type :	"POST",
		url	 :	"<?php echo base_url();?>bookmyt/update_reservation",
		data :	{'phone_no':phone_no,'res_id':res_id, 'in_time':in_time, 'booked_date':booked_date, 'members':no_mem, 'floor':floor, 'table_id':table_id},
		success : function(data)
		{
			if(data=="Failed"){
				$('#error_'+res_id).html("Can't Book the table with the same phone number");	
			}else{
				$('#error_'+res_id).html("");
				$('.close').trigger('click');
				$('#reslt').html('Reservation updated!');						
				$('#reslt').fadeOut(4000);
				location.reload();
			}
		}

	});


}	
$(function(){

    var message_status = $("#status_data");
    $("td[contenteditable=true]").blur(function(){
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        $.post('<?php echo base_url();?>bookmyt/savetable' , field_userid + "=" + value, function(data){
            if(data != '')
			{
				message_status.show();
				message_status.text('Data Updated');
				
				setTimeout(function(){message_status.hide()},3000);
			}
        });
    });
});    


  $('#myModal').on('shown.bs.modal', function () 
  {
	$('#myInput').focus()
	});

function buzz_done()
{

  	var floor=$.trim($('#floor').val());
	var select_no_of_members=$.trim($('#select_no_of_members').val());
	var sub_cat_data=$('#sub_cat_data').val();
	var reservation_id=$('#reservation_id').val();

	if(floor=='')
	{
		$('#error_popup').html('Please select floor');
		return false;
	}else
	{
	$('#error_popup').html('');
	}
	if(select_no_of_members=='')
	{
	$('#error_popup').html('Please enter no of members');
	return false;
	}else
	{
	$('#error_popup').html('');
	}
	if(sub_cat_data=='')
	{
	$('#error_popup').html('Please select table');
	return false;
	}else
	{
	$('#error_popup').html('');
	}
	
	$.ajax({
	type :	"POST",
	url	 :	"<?php echo base_url();?>bookmyt/buzz_reservation",
	data :	{'floor':floor,'table_for' : select_no_of_members,'table_id':sub_cat_data,'reservation_id':reservation_id},
	success : function(data)
		{
			//alert('Hia'); return false;
			$('#sucess').html('Your table is booked!');
			$('#sucess').fadeOut(2000);
			location.reload();
		}

	});


}


function bill_info()
{
	var bill_amt = $('#bill_amount').val();
	var reser_id = $('#reser_id').val();
	var feedback = $('#feedback').val();
	
	
	if($.trim(bill_amt) == '')
	{
		$('#err_amt').html("Please enter bill amount");
		return false;
	}
	else if($.trim(bill_amt) != '')
	{
		if($.isNumeric($.trim(bill_amt)) == false)
		{
			$('#err_amt').html("Bill amount should numeric");
			return false;
		}
	}
	else if($.trim(bill_amt) == 0)
	{
		$('#err_amt').html("Bill Amount should not be zero");
		return false;
	}
	else
	{
		$('#err_amt').html("");
	}
	
	if(feedback == "")
	{
		$('#err_amt').html("Please mention feedback");
		return false;
	}
	else
	{
		$('#err_amt').html("");
	}
	
	 	$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url().'bookmyt/done_reservation'; ?>",
					data :	{'bil_amt': bill_amt,'res_id' : reser_id , 'feedback' : feedback},
					success : function(data)
					{
						$('#remove_div_'+reser_id).hide();
						$('.close').click();
						$('#bill_amount').val('');
						$('#feedback').val('');
						
						var floor_id=$("#floor").val();
						
						$.ajax({
						type :	"POST",
						url	 :	"<?php echo base_url();?>bookmyt/get_table_data",
						data :	{'floor_id':floor_id},
						success : function(data){
						 $('#sucess').html('Billing Is Done!');	
								//$("#sucess").fadeOut(2000);
							$('#table_data').html(data);

						}

						});
					}

					});
	

	
}

</script>
		<script>
			function done_reservation(reservation_id)
			{
				$('#reser_id').val(reservation_id);			 
			}
			
			function buzz_reservation(reservation_id)
			{
				$('#reservation_id').val(reservation_id);			 
			}
			
			function get_tables()
			{
			 	$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url();?>bookmyt/get_tables",
					data :	{'no_of_members' : $("#select_no_of_members").val(),'floor_id':$("#floor").val()},
					success : function(data)
					{
						$('#sub_cat_data1').html(data);
					}

					});
					 
			}
		
		</script>
          
 <div class="modal fade" id="reservationpop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Book Table</h4>
      </div>
	<div class="modal-body">
	  <center><span style="color:red" id="error_popup"></span></center>
	  <div style="margin:10px"></div>
	  <input type="hidden" id="reservation_id" value=""/>
         <div class="form-group col-md-10 col-md-offset-1">
		 
                <select  placeholder="Select Country" class="selectpicker" id="floor" name="floor" required>
				 <option value="" style="display:none;">Select Floor</option>
					<?php
					if(isset($floors_info) && !empty($floors_info))
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
				<input type="text" placeholder="Enter No of members" class="form-control"   name="table_for" required id="select_no_of_members" >
				</div>-->
		<div class="form-group col-md-10 col-md-offset-1" id="sub_cat_data1">	
				<select    placeholder="Select Your Table Number" class="selectpicker"   name="table_id" required>
				<option value="" style="display:none;">Select Your Table Number</option>
				</select>
		</div>
	</div>
	<div class="clearfix"></div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="buzz_done()">Buzz Now</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() 
	{
            
            $('#phone_no,#select_no_of_members').keydown(function(event) 
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
            
        });
</script>

<div class="modal fade" id="donepop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        <h4 class="modal-title" id="myModalLabel">Billing Info</h4>
      </div>
	  
	<div class="modal-body">
	  <center><span style="color:red" id="err_amt"></span></center>
	  <div style="margin:10px"></div>
	  <input type="hidden" id="reser_id" value=""/>
         <div class="form-group col-md-10 col-md-offset-1">
			<input type="text" name="bill_amount" id="bill_amount" placeholder="Enter Bill Amount" class="form-control" required/>
		 </div>
		  <div class="form-group col-md-10 col-md-offset-1">
			<textarea name="feedback" placeholder="Feedback" class="form-control" id="feedback"></textarea>
		 </div>
		
	</div>
	<div class="clearfix"></div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="bill_info()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$("body").delegate(".tb",'click',function(){	
	$(".hover").hide();
	<?php if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";}else{ ?>
	$(".hover",this).show();
	<?php } ?>
});
$("body").delegate(".red",'click',function(){	
	$(".hover").hide();
	$(".hover",this).hide();
});
$("body").delegate(".t0",'click',function(){	
	$(".hover").hide();
	$(".hover",this).hide();
});
</script>
