<style>
input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
.ui-datepicker-year{ display:none !important;}
</style>
<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4>Reservations</h4>
		 
			<!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div>
			<div class='clearfix'></div>
			<?php			
				if($this->session->flashdata('success'))
				{
			?>			
				<div class='alert alert-success text-center' id='ss_fo'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('success'); ?></strong> </div>		
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
		 
		  <center><b><span style="color:red" id="error"></span><span style="color:green" id="reslt"></span><span style="color:red" id="error"></span></b>
			</center>
        <div class="wrap mnone">
		  <div class="col-md-12">
		   
		  <form name="guest_add" method="post" id="guest_add" class="wrap mnone" action="">
		  <input type="hidden" name="relationship_id" value="<?php if($this->session->userdata('relationship_id') == '') { echo '';} else {echo $this->session->userdata('relationship_id'); }?>" id="relationship_id"/>
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
			?>
			<div class="form-group col-sm-4 col-md-2">
			
					<label class="form-lable ">Select Branch<span class="star">*</span></label>
					 <select  placeholder="" class="selectpicker" id="business_id" name="branch" required>
						<option value="" style="display:none;">Select Branch</option>
						<?php
							if(isset($branches) && !empty($branches))
							{
								foreach($branches as $branch)
								{
								
						?>
							<option value="<?php echo $branch['business_id']; ?>" <?php if($branch['business_id'] == $this->session->userdata('business_id')) { echo "selected='selected'";} ?>><?php echo $branch['business_name']; ?></option>
						<?php
								}
							}
						?>					
					 </select>
				</div>
			<?php
				}
			}
				else
				{
			?>
				<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
			<?php
				}
			
			?>
		  							
				<div class="form-group <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-4"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-4"; } else { echo "col-sm-4"; }  } ?>  col-md-2">
				<label class="form-lable ">Guest Phone<span class="star">*</span></label>
					<input type="number" required name="phone_no" maxlength="13" id="phone_no" class="form-control" placeholder="">  
				</div>
					 
				<div class="form-group col-sm-4 col-md-2">
					<label class="form-lable ">Guest Name<span class="star">*</span></label>
					<input type="text" required name="name" id="name" class="form-control" maxlength="30" placeholder="">
				</div>
				
				<div class="form-group col-sm-4 col-md-2">
					<label class="form-lable ">No Of Guests<span class="star">*</span></label>
					<input type="text" required name="no_mem" id="no_mem" class="form-control" maxlength="3" placeholder="">
				</div>
				   
				<div class="form-group <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-4"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-4"; } else { echo "col-sm-4"; } } ?> <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-md-2"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-md-2"; } else { echo "col-md-1"; } } ?> date-fi">
					<label class="form-lable ">Date<span class="star">*</span></label>
					<input type="text" required class="form-control datepicker" id="booked_date" placeholder="" >
				</div>
				
				<div class="form-group <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-4"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-4"; } else { echo "col-sm-4"; } } ?> <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-md-1"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-md-1"; } else { echo "col-md-1";  }} ?>">
					<label class="form-lable ">In Time<span class="star">*</span></label>
					<input type="text" required id="in_time" name="in_time" class="form-control" placeholder="">
				</div>	
				<div class="form-group <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-4"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-4"; } else { echo "col-sm-4"; } } ?> <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-md-1"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-md-1"; } else { echo "col-md-1"; } } ?> date-fi">
					<label class="form-lable ">Fav. Day</label>
					<input type="text" required class="form-control datepicker" name="date_of_birth" id="date_of_birth" placeholder="" >
				</div>
				<?php
					if($this->session->userdata('branch') != '0')
					{
				?>
					<div class="form-group col-sm-4 col-md-2  mt30 ">
					<?php if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";}else{ ?>
					<button type="button" onclick="book_table()" class="btn btn-success btn-xss" id="bkk">BOOK</button>
					<?php } ?>
					<a href="" class="btn btn-success btn-xss">Clear</a>
					</div>
				<?php
					}
					else
					{
				?>
				<div class="form-group col-sm-4 col-md-2  mt30 ">
				<?php if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";}else{ ?>
					<button type="button" onclick="book_table()" class="btn btn-success btn-xss " id="bkk">BOOK</button>
					<?php } ?>
					<a href="" class="btn btn-success btn-xss">Clear</a>
				 </div>
				 <?php
					}
				?>
				  
				</form>
				<div class="wrap mnone ">
				<h4 >Upcoming Reservations</h4>
				
				 <div class="table-responsive">
                <table class="table table-style-one table-striped " >
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>phone</th>
                      <th>In Time</th>                   
					   <th class="text-center">No of Guests</th>
					   <th>Booked Date</th>
					   <th>Last Visited</th>
					   
                      <th class="text-right">Actions</th>
                    
                    </tr>
                  </thead>
                  <tbody id="append_data">
				  <?php 
				  //pr($reservation_list->reservation_list);
				  if(count($reservation_list->reservation_list) != '0')
				  {
					  foreach($reservation_list->reservation_list as $branch)
					  {
					  ?>
						<tr>
						  <td  contenteditable="false"><?php echo $branch->name;?></td>
						  <td  contenteditable="false"><?php echo $branch->phone_no;?></td>
						  <td  contenteditable="false"><?php echo date("g:i A", strtotime($branch->in_time));?></td>
					   
						 <td class="text-center" contenteditable="false"><?php echo $branch->table_for;?></td>
						  <td  contenteditable="false"><?php $date = date_create($branch->booked_date); echo date_format($date,'d-M-Y');?></td>
						  <td  contenteditable="false"><?php $date = date_create($branch->max_date); echo date_format($date,'d-M-Y');?></td>
						  
						  
						  <td id="booked_buzz:<?php echo $branch->reservation_id;?>" style="width:235px;" contenteditable="false">
						  <?php  if($branch->visits>=3)
							{
								echo '<img src="'.base_url().'theme/images/star.png" width="22" style="padding-top:8px;">&nbsp;';
							}
							else{
								echo '<img src="'.base_url().'theme/images/star-d.png" width="22" style="padding-top:8px;">&nbsp;';
							}
						  
						  if(date('Y-').date('m-d',strtotime($branch->date_of_birth)) == date('Y-m-d'))
							{
								echo '<img src="'.base_url().'theme/images/birthday.png" width="22" style="padding-top:8px;">';
							}
							else{
								echo '<img src="'.base_url().'theme/images/birthday-d.png" width="22" style="padding-top:8px;">';
							}
							if($branch->is_vip1 ==1)
							{
								echo '<img src="'.base_url().'theme/images/vip.png" width="22" style="padding-top:8px;">&nbsp;';
							}
							else{
								echo '<img src="'.base_url().'theme/images/vip-d.png" width="22" style="padding-top:8px;">&nbsp;';
							}
						  ?>
						  <div class="action three black">
						    <?php if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";} else
							{
							?>
						  <a href="#" class="buzz-sm-icon" onclick="buzz_msg('<?php echo $branch->reservation_id;?>')"  title="Buzz"></a> 
						  <?php } ?>
						  <span class="divider"></span> 
						    <?php if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";} else
							{
							?>
						  <a href="#" class="book-sm-icon" title="Allocate Table" data-toggle="modal" data-target="#reservationpop" onclick="buzz_reservation('<?php echo $branch->reservation_id;?>','<?php echo $branch->is_vip1?>',<?php echo $branch->table_for;?>)">
						  </a>
						  
						  <?php }if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";} else
							{
							?>
							<span class="divider"></span> 
						  <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal_<?php echo $branch->reservation_id;?>" class="edit-sm-icon" title="Edit" ></a>
						  
						  
						  
						  <span class="divider"></span> 
						  <a href="<?php echo base_url()."bookmyt/can_reservation/".$branch->reservation_id;?>" class="cancel-sm-icon" title="Cancel" onclick = "if(confirm('Are you sure to cancel reservation')) { return true; } else {return false; }"></a>
							<?php
								}
							?>
						  </div></td>
						  
						</tr>
						<div class="modal fade" id="myModal_<?php echo $branch->reservation_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog" style="width:300px;">
							  <div class="modal-content">
								<div class="modal-body ">
								  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								 
								  <div class="clearfix"></div>
								  <h4 class="text-center mt10">Edit Reservation</h4>
								   <span style="color:red" id="error_<?php echo $branch->reservation_id;?>"></span>
								   <span style="color:red;font-weight:bold" id="tn3"></span>
								   <div class="form-group">
								   <label class="form-lable ">No Of Guests<span class="star">*</span></label>
								    <input value="<?php echo $branch->phone_no;?>" id="phone_no_<?php echo $branch->reservation_id;?>" name="phone_no_<?php echo $branch->reservation_id;?>" type="hidden">
									<input placeholder="" value="<?php echo $branch->table_for;?>" id="no_guests_<?php echo $branch->reservation_id;?>" name="no_guests" maxlength="3" class="form-control" type="text">
									 <span style="color:red" id="error_p"></span>
								  </div>
								  <div class="form-group">
								  <label class="form-lable ">Date<span class="star">*</span></label>
									<input placeholder="" value="<?php $date = date_create($branch->booked_date); echo date_format($date,'d-M-Y'); ?>" name="booked_date" id="booked_date_<?php echo $branch->reservation_id;?>" class="form-control booked_date datepicker" type="text">
								  </div>
								  <div class="form-group">
									<label class="form-lable ">In Time<span class="star">*</span></label>
									<input type="text" value="<?php echo date("g:i A", strtotime($branch->in_time)); ?>" id="in_time_<?php echo $branch->reservation_id;?>" name="in_time" class="form-control in_time" placeholder="">
								  </div>	
								<?php if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";}else{ ?>
								<div class="form-group">
								<button type="button" class="btn btn-success modal-login-btn" onclick="update_table('<?php echo $branch->reservation_id;?>')">Update</button>
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
						<tr  id="no_records"><td colspan="6" class="text-center"><span style="color:red">No Records Found.</span></td></tr>
					<?php
					}
					?>
             
          
                  </tbody>
                </table>
              </div>
			  </div>
			  <div class="wrap mnone" style="margin-bottom:100px;">
			  <h4>Ongoing Dining</h4>
			
			          <div class="table-responsive">
               <table class="table table-style-one table-striped " >
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>phone</th>
                      <th>Start Time</th>
                   
					   <th class="text-center">No of Guests</th>
					   <th>Floor</th>
					     <th>Table No</th>
					   <th>Booked Date</th>
					   
                      <th class="text-right">Actions</th>
                    
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
						  <td  contenteditable="false"><?php echo $branches->name;?></td>
						  <td  contenteditable="false"><?php echo $branches->phone_no;?></td>
						  <td  contenteditable="false"><?php echo date("g:i A", strtotime($branches->in_time));?></td>
					   
						 <td class="text-center" contenteditable="false"><?php echo $branches->table_for;?></td>
						 <td  contenteditable="false"><?php echo $branches->floor_no.' - '.$branches->business_name;?></td>
						 <?php
						 	if($branches->table_nos==""){
						 ?>	
						 <td  contenteditable="false">Table No - <?php echo $branches->table_no;?></td>
						 <?php
						 	}else{
						?>
							<td  contenteditable="false">Table No - <?php echo $branches->table_no.",".$branches->table_nos;?></td>
						<?php
							}
						?>
						  <td  contenteditable="false"><?php $date = date_create($branches->booked_date); echo date_format($date,'d-M-Y');?></td>
						  
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
								<a href="javascript:void(0)" data-toggle="modal" data-target="#myModaledit_<?php echo $branches->reservation_id;?>" class="edit-sm-icon" title="Edit" onclick = "get_tablesbyfloor(<?php echo $branches->reservation_id;?>)"></a>
								<span class="divider"></span>
								<a href="<?php echo base_url()."bookmyt/delete_reservation/".$branches->reservation_id;?>" class="cancel-sm-icon" title="Cancel" onclick = "if(confirm('Are you sure to cancel reservation')) { return true; } else {return false; }"></a>
						
							<?php
								}
							}
							?>
						  </td>
						</tr>
						<div class="modal fade" id="myModaledit_<?php echo $branches->reservation_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog" style="width:300px;">
							  <div class="modal-content">
								<div class="modal-body ">
								  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								 
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
  


	  
	  <script src="<?php echo base_url().'theme/js/jquery-ui.js'; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'theme/css/jquery-ui.css'; ?>" />	
 
	<link rel="stylesheet" href="<?php echo base_url().'theme/css/qunit.css'; ?>" type="text/css"/>
   
	  
<script language="javascript">
// $("#ss_fo").fadeOut(2000);
// $("#reslt").fadeOut(2000);
	$(document).ready(function()
	{

		// get_tables();
		 
			$("#name").change(function()
			{
				if($.isNumeric($("#name").val()))
				{
					$('#error').show();
					$('#error').html("Name sholud not be numeric");
					$("#name").addClass('error');
					return false;
				}
				else
				{
					$('#error').html("");
					$("#name").removeClass('error');
				}
				
			});
			$('#phone_no,#no_mem').keydown(function(event) 
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
							
						}
						else
						{
							//$('#error').html("");
							$("#phone_no").removeClass('error');
							$('#bkk').prop('disabled', false);
						}
						//$('#name').val($.trim(data));					
					}
				});
			});

			$('#in_time').datetimepicker({
				datepicker:false,
				format:'g:i A',
				formatTime: 'g:i A',
				step:15,
				ampm: true
			});
			$('#booked_date').datetimepicker({
				timepicker:false,
				format:'d-M-Y',
				formatDate:'Y-m-d',
				minDate: 0
			});
			$('.in_time').datetimepicker({
				datepicker:false,
				format:'g:i A',
				formatTime: 'g:i A',
				step:15,
				ampm: true
			});
			$('.booked_date').datetimepicker({
				timepicker:false,
				format:'d-M-Y',
				formatDate:'Y-m-d',
				minDate: 0
			});
			$('#date_of_birth').datepicker({
				'changeMonth'		: true,
				'changeYear'		: false,
				'dateFormat'		: 'dd-MM',
				'showButtonPanel'	: false,
			});		
		});

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

		function book_table()
		{
			var error = [];
			
			var name=$.trim($('#name').val());
			var phone_no=$.trim($('#phone_no').val());
			var booked_date=$('#booked_date').val();
			var date_of_birth=$('#date_of_birth').val();
			var in_time=$('#in_time').val();
			var business = $('#business_id').val();
			var no_mem = $('#no_mem').val();
			var rel_id = $('#relationship_id').val();
			
			// $.post('<?php echo base_url().'bookmyt/verify_res'; ?>',{ phn : phone_no , b_date : booked_date, time : in_time},function(data)
			// {
				// alert(data);return false;
			// })
			// return false;
			
			if(business == '')
			{
				error.push('e1');
			}
			if((name == "" || $.isNumeric(name)) && (phone_no=="" || phone_no.length!=10 || !$.isNumeric(phone_no)))
			{
				
					error.push('e2');
				
			}
			else
			{
				if($.isNumeric(name))
				{
					error.push('e2');
				}
			}
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
			/*if(phone_no=="" || phone_no.length!=10){
				error.push('e6');
			}else{
				if(!$.isNumeric(phone_no))
				{
					error.push('e6');
				}
			}*/
			if(error.length != 0)
			{
				if($.inArray("e1", error) !== -1){ $("#business_id").addClass('error'); } else { $("#business_id").removeClass('error'); }
				if($.inArray("e2", error) !== -1){alert("Either Name or Phone number is required");  $("#name").addClass('error');} else { $("#phone_no").removeClass('error'); $("#name").removeClass('error');}
				if($.inArray("e3", error) !== -1){ $("#no_mem").addClass('error'); } else { $("#no_mem").removeClass('error'); }
				if($.inArray("e4", error) !== -1){ $("#booked_date").addClass('error'); } else { $("#booked_date").removeClass('error'); }
				if($.inArray("e5", error) !== -1){ $("#in_time").addClass('error'); } else { $("#in_time").removeClass('error'); }
				//if($.inArray("e6", error) !== -1){ $("#phone_no").addClass('error'); } else { $("#phone_no").removeClass('error'); }
				return false;
			}
			else
			{
				$("#business_id").removeClass('error');
				//$("#phone_no").removeClass('error');
				$("#name").removeClass('error');		
				$("#no_mem").removeClass('error');
				$("#booked_date").removeClass('error');
				$("#in_time").removeClass('error');
				error = [];
			}
			
			
			
			$.ajax({
				type :	"POST",
				url	 :	"<?php echo base_url();?>bookmyt/add_reservation",
				data :	{'name':name,'phone_no' : phone_no,'in_time':in_time,'booked_date':booked_date,'date_of_birth':date_of_birth,'business':business,'members':no_mem , 'rel_id':rel_id},
				success : function(data)
				{
					if(data=="Failed"){
						$('#error').html("Can't Book the table with the same phone number");	
					}else{
						//$('#append_data').prepend(data);
						$.trim($('#name').val(''));
						$.trim($('#phone_no').val(''));
						$('#booked_date').val('');
						$('#date_of_birth').val('');
						$('#in_time').val('');
						$('#no_mem').val('');
						$('#error').html('');
						$("#no_records").hide();
						$('#reslt').html('Reservation successfully done.');						
						$("#append_data").append(data);
						 $('#reslt').fadeOut(4000);
						location.reload();
					}
					
				}

			});


		}
		
		$("#no_mem,#booked_date,#in_time").change(function()
		{
						
			if($("#no_mem").val() != '')
			{
				$("#no_mem").removeClass('error');
			}
			if($("#booked_date").val() != '')
			{
				$("#booked_date").removeClass('error');
			}
			if($("#in_time").val() != '')
			{
				$("#in_time").removeClass('error');
			}
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
		function get_tablesbyfloor(res_id)
		{
			$("#floor_"+res_id).trigger('change');
		}
		function update_table(res_id)
		{
			var error = [];			
			var booked_date=$('#booked_date_'+res_id).val();
			var in_time=$('#in_time_'+res_id).val();
			var no_mem = $('#no_guests_'+res_id).val();
			var phone_no = $('#phone_no_'+res_id).val();
			var floor = $('#floor_'+res_id).val();
			var table_id = $('#table_id_'+res_id).val();
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
	
	var err = [];
  	var floor=$.trim($('#floor').val());
	var select_no_of_members=$.trim($('#select_no_of_members').val());
	var sub_cat_data=$('#sub_cat_data').val();
	var reservation_id=$('#reservation_id').val();

	//alert( floor);alert( sub_cat_data); return false;
	if(floor=='')
	{
		err.push('e1');
	}
	if(sub_cat_data=='')
	{
		err.push('e2');
	}
	
	if(err.length != 0)
	{
		if($.inArray("e1", err) !== -1){ $("[data-id=floor]").addClass('error'); } else { $("[data-id=floor]").removeClass('error'); }
		if($.inArray("e2", err) !== -1){ $("[data-id=sub_cat_data]").addClass('error'); } else { $("[data-id=sub_cat_data]").removeClass('error'); }
		return false;
	}
	else
	{
		$('[data-id=floor]').removeClass('error');
		$('[data-id=sub_cat_data]').removeClass('error');
		err = [];
	}
	
	
	$.ajax({
	type :	"POST",
	url	 :	"<?php echo base_url();?>bookmyt/buzz_reservation",
	data :	{'floor':floor,'table_id':sub_cat_data,'reservation_id':reservation_id,'is_vip':$('#is_vip:checked').val()},
	success : function(data)
		{	
			$("#reslt").show();
			$(".close").click();
			$("#reslt").html("Table is Booked");		
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
		$('#err_amt').html("Bill amount should not be zero");
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
				$('#feedback').val('');
				 alert('Billing is done!');
				
				location.reload();
			}

		});
	

	
}
 

			function done_reservation(reservation_id)
			{
				$('#reser_id').val(reservation_id);			 
			}
			
			function buzz_reservation(reservation_id,is_vip,table_for)
			{
				var res_id = $('#reservation_id').val(reservation_id);
				$("#party_size").html(table_for);
				$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url().'bookmyt/get_flr'; ?>",
					data :	{'res_id': reservation_id},
					success : function(data)
					{
						$('#load_div_floor').html(data);    
						get_tables();
					}

					});
				if(parseInt(is_vip)==1)
				{
					$('#is_vip').prop('checked',true);
				}else
				{
					$('#is_vip').prop('checked',false);
				}
			}
			
			function get_tables()
			{
			 	$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url();?>bookmyt/get_tables",
					data :	{'no_of_members' : $("#select_no_of_members").val(),'floor_id':$("#floor").val(),'reservation_id' : $("#reservation_id").val()},
					success : function(data)
					{
						$('#sub_cat_data1').html(data);
					}

					});
					 
			}
			function buzz_msg(res_id)
			{
			 	$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url();?>bookmyt/buzz_msg",
					data :	{'res_id' : res_id},
					success : function(data)
					{
						//$('#sub_cat_data1').html(data);
						alert(data);
					}

					});
					 
			}
			
			$('.selectpicker').selectpicker();
		</script>
          
 <div class="modal fade" id="reservationpop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        <h4 class="modal-title" id="myModalLabel">Book Table</h4>		
      </div>
	  
	<div class="modal-body">
	  <input type="hidden" id="reservation_id" value=""/>
	  	<div class="form-group col-md-10  col-sm-10 col-md-offset-1"	
		 <label class="form-lable">Party Size: <span id="party_size" style="font-family:Arial, Helvetica, sans-serif"></span></label>	
		 </div>
         <div class="form-group col-md-10  col-sm-10 col-md-offset-1" id="load_div_floor">
		 	
			<label class="form-lable ">Select floor<span class="star">*</span></label>			 
                <select class="selectpicker" id="floor" name="floor"  onchange="get_tables()" required>
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
		<div class="form-group col-md-10 col-sm-10 col-md-offset-1" id="sub_cat_data1">	 
			<label class="form-lable ">Select Table Number<span class="star">*</span></label>		
				<select    placeholder="Select Table Number" class="selectpicker"  name="table_id" required>
				<!--<option value="" style="display:none;">Select Your Table Number</option>-->			
				</select>
		</div>
		
		
	</div>
	<div class="clearfix"></div>
      <div class="modal-footer ">
        <div class="pull-left" style="padding-top:5px;">
		<input type="checkbox" name="is_vip" id="is_vip" value="1" /> Is VIP?
		</div>
		<div class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="buzz_done()">Allocate Table</button>
      </div>
    </div>
  </div>
</div>

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
</div>

