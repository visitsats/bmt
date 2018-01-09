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
				<div class='alert alert-success text-center'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('fail'); ?></strong> </div>	
			<?php
				}
			?>
		 
		  <center><b><span style="color:red" id="error"></span>
			<span style="color:green" id="reslt"></b></span>
			</center>
        <div class="wrap mnone">
		  <div class="col-md-12">
		   
		  <form name="guest_add" method="post" id="guest_add" class="wrap mnone" action="">
		  <input type="hidden" name="relationship_id" value="<?php if($this->session->userdata('relationship_id') == '') { echo '';} else {echo $this->session->userdata('relationship_id'); }?>" id="relationship_id"/>
		  <?php 
			
			if($this->session->userdata() && $this->session->userdata('branch') == '0')
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
		  							
				<div class="form-group col-sm-4 col-md-2">
				<label class="form-lable ">Guest Phone<span class="star">*</span></label>
					<input type="text" required name="phone_no" maxlength="13" id="phone_no" class="form-control" placeholder="">  
				</div>
					 
				<div class="form-group col-sm-4 col-md-2">
					<label class="form-lable ">Guest Name<span class="star">*</span></label>
					<input type="text" required name="name" id="name" class="form-control" maxlength="30" placeholder="">
				</div>
				
				<div class="form-group col-sm-4 col-md-2">
					<label class="form-lable ">No Of Guests<span class="star">*</span></label>
					<input type="text" required name="no_mem" id="no_mem" class="form-control" maxlength="3" placeholder="">
				</div>
				   
				<div class="form-group col-sm-2 col-md-1 date-fi">
					<label class="form-lable ">Date<span class="star">*</span></label>
					<input type="text" required class="form-control datepicker" id="booked_date" placeholder="" >
				</div>
				
				<div class="form-group col-sm-2 col-md-1">
					<label class="form-lable ">In Time<span class="star">*</span></label>
					<input type="text" required id="in_time" name="in_time" class="form-control" placeholder="">
				</div>	
				<?php
					if($this->session->userdata('branch') != '0')
					{
				?>
					<div class="form-group col-sm-4 col-md-2 mt30 width-auto text-right-xs">
					<button type="button" onclick="book_table()" class="btn btn-success btn-xss">BOOK</button>
					<a href="" class="btn btn-success btn-xss">Clear</a>
					</div>
				<?php
					}
					else
					{
				?>
				<div class="form-group col-sm-4 col-md-2 text-left mt30 width-auto text-right-xs">
					<button type="button" onclick="book_table()" class="btn btn-success btn-xss ">BOOK</button>
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
					   
                      <th class="text-right">Actions</th>
                    
                    </tr>
                  </thead>
                  <tbody id="append_data">
				  <?php
				  if(count($reservation_list->reservation_list) != '0')
				  {
					  foreach($reservation_list->reservation_list as $branch)
					  {
								
					  ?>
						<tr>
						  <td  contenteditable="false"><?php echo $branch->name;?></td>
						  <td  contenteditable="false"><?php echo $branch->phone_no;?></td>
						  <td  contenteditable="false"><?php echo $branch->in_time;?></td>
					   
						 <td class="text-center" contenteditable="false"><?php echo $branch->table_for;?></td>
						  <td  contenteditable="false"><?php $date = date_create($branch->booked_date); echo date_format($date,'d-M-Y');?></td>
						  
						  
						  <td id="booked_buzz:<?php echo $branch->reservation_id;?>" contenteditable="false">
						  <div class="action three black">
						  <a href="#" class="buzz-sm-icon" title="Buzz"></a> 
						  <span class="divider"></span> 
						  <a href="#" class="book-sm-icon" title="Allocate Table" data-toggle="modal" data-target="#reservationpop" onclick="buzz_reservation('<?php echo $branch->reservation_id;?>')">
						  </a>
						  <?php if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') {echo "";} else
							{
							?>
						  <span class="divider"></span> 
						  <a href="<?php echo base_url()."/bookmyt/can_reservation/".$branch->reservation_id;?>" class="cancel-sm-icon" title="Cancel" onclick = "if(confirm('Are you sure you want to Delete (<?php echo $branch->name;; ?>)')) { return true; } else {return false; }"></a>
							<?php
								}
							?>
						  </div></td>
						  
						</tr>
						<?php
						}
					}
					else
					{
					?>
						<tr><td colspan="6" class="text-center"><span style="color:red">No Records Found.</span></td></tr>
					<?php
					}
					?>
             
          
                  </tbody>
                </table>
              </div>
			  </div>
			  <div class="wrap mnone" style="margin-bottom:100px;">
			  <h4>Ongoing Reservations</h4>
			
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
						  <td  contenteditable="false"><?php echo $branches->name;?></td>
						  <td  contenteditable="false"><?php echo $branches->phone_no;?></td>
						  <td  contenteditable="false"><?php echo $branches->in_time;?></td>
					   
						 <td class="text-center" contenteditable="false"><?php echo $branches->table_for;?></td>
						 <td  contenteditable="false"><?php echo $branches->floor_no.' - '.$branches->business_name;?></td>
						 <td  contenteditable="false">Table - <?php echo $branches->table_no;?></td>
						  <td  contenteditable="false"><?php $date = date_create($branches->booked_date); echo date_format($date,'d-M-Y');?></td>
						  
						   <td class="text-center"><div class="action done three black">
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
								<a href="<?php echo base_url()."/bookmyt/delete_reservation/".$branches->reservation_id;?>" class="cancel-sm-icon" title="Cancel" onclick = "if(confirm('Are you sure you want to cancel reservation')) { return true; } else {return false; }"></a>
						
							<?php
								}
							}
							?>
						  </td>
						</tr>
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
					success : function(data)
					{
						$('#name').val($.trim(data));					
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
				format:'d-m-Y',
				formatDate:'Y-m-d',
				minDate: 0
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
			var in_time=$('#in_time').val();
			var business = $('#business_id').val();
			var no_mem = $('#no_mem').val();
			var rel_id = $('#relationship_id').val();
			
			if(business == '')
			{
				error.push('e1');
			}
			if(phone_no == "" && name == "")
			{
				
					error.push('e2');
				
			}
			else
			{
				if($.isNumeric(name) || phone_no.length < 10 )
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
			
			if(error.length != 0)
			{
				if($.inArray("e1", error) !== -1){ $("#business_id").addClass('error'); } else { $("#business_id").removeClass('error'); }
				if($.inArray("e2", error) !== -1){ $("#phone_no").addClass('error'); $("#name").addClass('error');} else { $("#phone_no").removeClass('error'); $("#name").removeClass('error');}
				if($.inArray("e3", error) !== -1){ $("#no_mem").addClass('error'); } else { $("#no_mem").removeClass('error'); }
				if($.inArray("e4", error) !== -1){ $("#booked_date").addClass('error'); } else { $("#booked_date").removeClass('error'); }
				if($.inArray("e5", error) !== -1){ $("#in_time").addClass('error'); } else { $("#in_time").removeClass('error'); }
				return false;
			}
			else
			{
				$("#business_id").removeClass('error');
				$("#phone_no").removeClass('error');
				$("#name").removeClass('error');		
				$("#no_mem").removeClass('error');
				$("#booked_date").removeClass('error');
				$("#in_time").removeClass('error');
				error = [];
			}
			
			
			
			$.ajax({
				type :	"POST",
				url	 :	"<?php echo base_url();?>bookmyt/add_reservation",
				data :	{'name':name,'phone_no' : phone_no,'in_time':in_time,'booked_date':booked_date,'business':business,'members':no_mem , 'rel_id':rel_id},
				success : function(data)
				{
					
					//$('#append_data').prepend(data);
					$.trim($('#name').val(''));
					$.trim($('#phone_no').val(''));
					$('#booked_date').val('');
					$('#in_time').val('');
					$('#no_mem').val('');			
					
					$('#reslt').html('Reservation added!');					
					location.reload();
					
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
	data :	{'floor':floor,'table_id':sub_cat_data,'reservation_id':reservation_id},
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
			
			function buzz_reservation(reservation_id)
			{
				var res_id = $('#reservation_id').val(reservation_id);			
			
				$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url().'bookmyt/get_flr'; ?>",
					data :	{'res_id': reservation_id},
					success : function(data)
					{
						$('#load_div_floor').html(data);       
					}

					});
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
	 
         <div class="form-group col-md-10  col-sm-10 col-md-offset-1" id="load_div_floor">	
			<label class="form-lable ">Select floor<span class="star">*</span></label>			 
                <select class="selectpicker" id="floor" name="floor"  onchange="get_tables()" required>
				<option value="" style="display:none;">Select Floor</option>
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
				<option value="" style="display:none;">Select Your Table Number</option>				
				</select>
		</div>
		
		
	</div>
	<div class="clearfix"></div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="buzz_done()">Book Now</button>
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

