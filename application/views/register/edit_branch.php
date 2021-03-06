  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Edit Branch</h4>
         <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div>
		<div class='clearfix'></div>
			<?php			
				if($this->session->flashdata('success'))
				{
			?>			
				<div class='alert alert-success text-center' id='fo'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('success'); ?></strong> </div>		
			<?php
				}
				if($this->session->flashdata('fail'))
				{
			?>
				<div class='alert alert-danger text-center' id='fo'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('fail'); ?></strong> </div>	
			<?php
				}
			?>
			<center><span id="addbranch_error" style="color:red;font-weight:bold"><?php echo form_error('business_email'); ?></span></center>
			<center><span id="addphone_error" style="color:red;font-weight:bold"><?php echo form_error('phone_no'); ?></span></center>
		
        <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
            <div class="panelone  plr10">
			
            <form name="" method="post" role="form" class="wrap mt15" action="<?php echo base_url()."bookmyt/edit_branch/"; ?>">
			<input type="hidden" name="business_id" value="<?php echo $userdata['business_id'];?>" />
			
			
			<div class="form-group col-md-6">
		<label class="form-lable "> Branch name/Location/Restaurant Name <span class="star">*</span></label>	
        <input type="text" placeholder="" maxlength="25" class="form-control "  name="business_name" value="<?php echo isset($_POST['business_name'])?$_POST['business_name']:$userdata['business_name'];?>" id="b_name">
		
		</div>
       
			
		 <div class="form-group col-md-6">
		<label class="form-lable "> Branch Type <span class="star">*</span></label>
                 <select  placeholder="" class="selectpicker"   name="business_types" id="b_types">
				<option value="" style="display:none;">Select Your Business Type</option>
					<?php
					if(isset($business_types) && !empty($business_types))
					{
						foreach($business_types as $type)
						{
					?>
						<option value="<?php echo $type['business_typeid']; ?>" <?php  if($type['business_typeid']==$userdata['business_typeid']) { echo 'selected=selected';} ?>><?php echo $type['business_typename']; ?></option>
					<?php
						}
					}
					?>
				 </select>
				
		
		</div>
		
		 <div class="form-group col-md-6">	 
			<label class="form-lable ">Branch Admin Email Id <span class="star">*</span></label>
				 <input type="email" placeholder="" class="form-control" id="b_email" maxlength="25"  name="business_email" value="<?php echo isset($_POST['business_email'])?$_POST['business_email']:$userdata['business_email'];?>">
				
                  
			</div>
		
		 <div class="form-group col-md-6">
	<label class="form-lable ">Phone Number <span class="star">*</span></label>
                 <input type="text" placeholder="" class="form-control"  maxlength="13" name="phone_no" value="<?php echo isset($_POST['phone_no'])?$_POST['phone_no']:$userdata['phone_no'];?>" id="phone">
				
        </div>
		<div class="form-group col-md-6">
		 <label class="form-lable ">Zip code<span class="star">*</span></label>
                 <input type="text" placeholder="" maxlength="150" class="form-control"  value="<?php echo isset($_POST['zipcode'])?$_POST['zipcode']:$userdata['zipcode'];?>"  name="zipcode" id="b_zip" >
                  
		</div>
		<div class="form-group col-md-6">
		 <label class="form-lable">Branch Address <span class="star"></span></label>
                 <input type="text" placeholder="" class="form-control" id="b_add" maxlength="150"  name="address" value="<?php echo isset($_POST['address'])?$_POST['address']:$userdata['address'];?>">
				 
				</div>
		<div class="form-group col-md-6">
	<label class="form-lable ">City<span class="star">*</span></label>	
			<input type="text" placeholder="" maxlength="25" class="form-control" value="<?php echo isset($_POST['city'])?$_POST['city']:$userdata['city'];?>"  name="city" id="city">
             </div>		
		 <div class="form-group col-md-6">
		<label class="form-lable ">State <span class="star">*</span></label>
				 <input type="text" placeholder="" class="form-control" id="state" maxlength="25" name="state" required value="<?php echo isset($_POST['state'])?$_POST['state']:$userdata['state'];?>">                    
		</div>
		
		 <?php $countries = array('US' => 'United States');?>
	
		<div class="form-group col-md-6">
		<label class="form-lable ">Country <span class="star">*</span></label>
			<select  placeholder="" class="selectpicker"  name="country" id='c_code'>
				<option value="" style="display:none;">Select Your Country</option>
					<?php
					if(isset($countries) && !empty($countries))
					{
						foreach($countries as $key => $val)
						{
					?>
						<option value="<?php echo $key; ?>" <?php if($userdata['country'] == $key) { echo "selected='selected'"; } else { echo ""; } ?>><?php echo $val; ?></option>
					<?php
						}
					}
					?>
			</select>			
        </div>
		
		 <div class="form-group col-md-6" >
			<label class="form-lable ">Time Zone <span class="star">*</span></label>		
                 <select  placeholder="" class="selectpicker" name="time_zone">
					<option value="" style="display:none;">Select Your Time Zone</option>
					<?php
						$zones=array("P"=>"Pacific Time Zone","M"=>"Mountain Time Zone","C"=>"Central Time Zone","E"=>"Eastern Time Zone","A"=>"Atlantic Timezone","K"=>"Alaska Time Zone");
						if(isset($zones) && !empty($zones))
						{
							foreach($zones as $key=>$value)
							{
						?>
							<option value="<?php echo $key; ?>" <?php if($userdata['time_zone'] == $key) { echo "selected='selected'"; } else { echo ""; } ?>><?php echo $value; ?></option>
						<?php
							}
						}
					?>
				 </select>
                
			</div>
				 			 
			<div class="form-group col-md-12">
				<a href="<?php echo base_url().'bookmyt/branches/'; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a>
				<button type="submit" name="sub"  onclick="return validate()" class="btn btn-success pull-right">Update</button> 
			</div>			  
				  
				</form>
							
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

	<script>
	function validate()
	{
		var error = [];
		if($("#b_name").val() == "")
		{
			error.push('e1');			
		}
		
		if($("#b_types").val() == "")
		{		
			error.push('e2');	
		}
		if($("#b_user_name").val() == "")
		{		
			error.push('e10');	
		}
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;		
		if(($("#b_email").val() == "" || !filter.test($("#b_email").val())) && ($("#phone").val() == "" || isNaN($("#phone").val()) || $("#phone").val().length < 10))
		{
			error.push('e3');	
		}
		else
		{
			/*if(!filter.test($("#b_email").val()))
			{
				error.push('e3');	
			}*/
		}
		if($("#b_zip").val() == "" || isNaN($("#b_zip").val()) || $("#b_zip").val().length!=5)
		{
			error.push('e4');	
		}
		
		
		if($("#state").val() == "")
		{
			error.push('e6');	
		
		}
		if($("#c_code").val() == "")
		{
			error.push('e7');	
		}

		if($("#tzone").val() == "")
		{
			error.push('e8');	
		}
		if($("#city").val()==""){
			error.push('e9');
		}
		var msg='';
		if(error.length != 0)
		{
			if($.inArray("e1", error) !== -1){ msg+="Please enter Branch Name\n";$("#b_name").addClass('error'); } else { $("#b_name").removeClass('error'); }
			if($.inArray("e2", error) !== -1){ $("[data-id=b_types]").addClass('error'); } else { $("[data-id=b_types]").removeClass('error'); }
			if($.inArray("e3", error) !== -1){ msg+="Please enter valid Email id or enter valid 10 digit phone number\n";	$("#b_email").addClass('error'); } else { $("#b_email").removeClass('error');}
			if($.inArray("e4", error) !== -1){  msg+="Please enter valid 5 digit zipcode\n";$("#b_zip").addClass('error');	 } else { $("#b_zip").removeClass('error');	}
			//if($.inArray("e5", error) !== -1){ msg+="Please enter valid 10 digit phone number\n";$("#phone").addClass('error');	 } else { $("#phone").removeClass('error');	 }
			if($.inArray("e6", error) !== -1){ msg+="Please fill State details\n";$("#state").addClass('error');		 } else { $("#state").removeClass('error');}
			if($.inArray("e7", error) !== -1){msg+="Please select your country\n"; $("[data-id=c_code]").addClass('error');	 } else { $("[data-id=c_code]").removeClass('error'); }
			if($.inArray("e8", error) !== -1){msg+="Please select your timezone\n";  $("[data-id=tzone]").addClass('error');  } else { $("[data-id=tzone]").removeClass('error'); }	
			if($.inArray("e9", error) !== -1){msg+="Please fill city details\n"; $("#city").addClass('error');  } else { $("#city").removeClass('error'); }
			if($.inArray("e10", error) !== -1){msg+="Please enter Name\n"; $("#b_user_name").addClass('error');  } else { $("#b_user_name").removeClass('error'); }
			if(msg!=""){
				alert(msg);
			}				
			return false;
		}
		else
		{
			$("#b_name").removeClass('error');
			$("#b_user_name").removeClass('error');
			$("[data-id=b_types]").removeClass('error');
			$("#b_email").removeClass('error');
			$("#b_add").removeClass('error');	
			$("#phone").removeClass('error');	
			$("#state").removeClass('error');
			$("[data-id=c_code]").removeClass('error');
			$("[data-id=tzone]").removeClass('error');error = [];
		}
		
	}
	
	
	$("#b_name,#b_types,#b_email,#b_add,#phone,#state,#c_code,#tzone").change(function()
	{
		if($("#b_name").val() != "")
		{
			$("#b_name").removeClass('error');		
		}
		
		if($("#b_types").val() != "")
		{		
				$("[data-id=b_types]").removeClass('error');
		}	
			
		if($("#b_email").val() != "")
		{
			$("#b_email").removeClass('error');
		}

		if($("#b_add").val() != "")
		{
			$("#b_add").removeClass('error');	
		}
		
		if($("#phone").val() != "")
		{
			$("#phone").removeClass('error');	
				
		}
		if($("#state").val() != "")
		{
			$("#state").removeClass('error');
		
		}
		if($("#c_code").val() != "")
		{
			$("[data-id=c_code]").removeClass('error');
		}

		if($("#tzone").val() != "")
		{
			$("[data-id=tzone]").removeClass('error');
		}
	});
	
	
	$(document).ready(function() 
	{
			var cc = $("#c_code").val();
			$.ajax({
				type :	"POST",
				url	 :	"<?php echo base_url().'bookmyt/get_zones_cc'; ?>",
				data :	{'c_code' : cc},
				success : function(data)
					{
						$("#tzn_add").html(data);
					}

				});
	});
	
	$(document).ready(function() 
	{
			$("#c_code").change(function()
			{
				var cc = $("#c_code").val();
				$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url().'bookmyt/get_zones_cc'; ?>",
					data :	{'c_code' : cc},
					success : function(data)
						{
							$("#tzn_add").html(data);
						}

					});
			});
			
			$("#b_name").change(function()
			{
				if($.isNumeric($("#b_name").val()))
				{
					alert("Branch name sholud not be numbers.");
					return false;
				}
				
			});
            
            $('#phone').keydown(function(event) 
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

 