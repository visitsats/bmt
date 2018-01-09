  <div class="wrap mnone">
    <div class="container">
      <div class="row">
	  	<div class="col-xs-12">
          <h4><a href="<?php echo base_url();?>bookmyt/admin_dashboard">Dashboard</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo base_url();?>bookmyt/request_demo_list">Request demo List</a></h4>
         <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div>
	  	 <div class="wrap mnone">
		 	<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
				<div class="panelone  plr10">
					<form name="" method="post" role="form" class="wrap mt15" action="<?php echo base_url()."bookmyt/updateBusinessEntity/"; ?>">
						<input type="hidden" name="business_id" value="<?php echo $business_id;?>" />
			
			
			<div class="form-group col-md-6">
		<label class="form-lable "> Branch name/Location/Restaurant Name <span class="star">*</span></label>	
        <input type="text" placeholder="" maxlength="25" class="form-control "  name="business_name" value="<?php echo $business_info[0]['business_name'];?>" id="b_name">
		
		</div>
       
		
		 <div class="form-group col-md-6">	 
			<label class="form-lable ">Branch Admin Email Id </label>
				 <input type="email" placeholder="" class="form-control" id="b_email" maxlength="25"  name="business_email" value="<?php echo $business_info[0]['business_email'];?>">
				
                  
			</div>
		
		 <div class="form-group col-md-6">
	<label class="form-lable ">Phone Number </label>
                 <input type="text" placeholder="" class="form-control"  maxlength="13" name="phone_no" value="<?php echo $business_info[0]['phone_no'];?>" id="phone">
				
        </div>
		<div class="form-group col-md-6">
	<label class="form-lable ">Password </label>
                 <input type="password" placeholder="" class="form-control"  maxlength="13" name="password" value="<?php echo "";?>" id="phone">
				
        </div>
		<div class="form-group col-md-6">
		 <label class="form-lable ">Zip code<span class="star">*</span></label>
                 <input type="text" placeholder="" maxlength="150" class="form-control"  value="<?php echo $business_info[0]['zipcode'];?>"  name="zipcode" id="b_zip" >
                  
		</div>
		<div class="form-group col-md-6">
		 <label class="form-lable">Branch Address </label>
                 <input type="text" placeholder="" class="form-control" id="b_add" maxlength="150"  name="address" value="<?php echo $business_info[0]['address'];?>">
				 
				</div>
		<div class="form-group col-md-6">
	<label class="form-lable ">City</label>	
			<input type="text" placeholder="" maxlength="25" class="form-control" value="<?php echo $business_info[0]['city'];?>"  name="city" id="city">
             </div>		
		 <div class="form-group col-md-6">
		<label class="form-lable ">State </label>
				 <input type="text" placeholder="" class="form-control" id="state" maxlength="25" name="state" required value="<?php echo $business_info[0]['state'];?>">                    
		</div>
		
		 <?php $countries = array('US' => 'United States'); ?>
	
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
						<option value="<?php echo $key; ?>" <?php if($business_info[0]['country'] == $key) { echo "selected='selected'"; } else { echo ""; } ?>><?php echo $val; ?></option>
					<?php
						}
					}
					?>
			</select>			
        </div>
		
		 <div class="form-group col-md-6" >
			<label class="form-lable ">Time Zone <span class="star">*</span></label>		
                 <select  placeholder="" class="selectpicker" name="time_zone" id="timezone">
					<option value="" style="display:none;">Select Your Time Zone</option>
					<?php
						$zones=array("P"=>"Pacific Time Zone","M"=>"Mountain Time Zone","C"=>"Central Time Zone","E"=>"Eastern Time Zone","A"=>"Atlantic Timezone","K"=>"Alaska Time Zone");
						if(isset($zones) && !empty($zones))
						{
							foreach($zones as $key=>$value)
							{
						?>
							<option value="<?php echo $key; ?>" <?php if($business_info[0]['time_zone'] == $key) { echo "selected='selected'"; } else { echo ""; } ?>><?php echo $value; ?></option>
						<?php
							}
						}
					?>
				 </select>
                
			</div>			
		<div class="form-group col-md-12" >
			<?php if($business_info[0]['business_type']!='S'){ ?>
			<div class="col-md-6">
			<label class="form-lable ">Do you want to make this Business as Small Enterprise? <span class="star">*</span></label>		
			</div>
                <input type="radio" name="b_check" value="S"<?php if($business_info[0]['business_type'] == 'S') { echo "checked='checked'";} else { } ?> id="b_yes" <?php echo set_radio('b_check','1'); ?>/> Yes
			<input type="radio" name="b_check" value="L"<?php if($business_info[0]['business_type'] == 'L') { echo "checked='checked'";} else { } ?> id="b_no" <?php echo set_radio('b_check','0'); ?>/> No
			<?php }else if($business_info[0]['business_type']=='S'){ ?>
				<label class="form-lable ">Do you want to make this Business as Large Enterprise? <span class="star">*</span></label>
				<input type="radio" name="b_check" value="L"<?php if($business_info[0]['business_type'] == 'L') { echo "checked='checked'";} else { } ?> id="b_yes" <?php echo set_radio('b_check','1'); ?>/> Yes
			<input type="radio" name="b_check" value="S"<?php if($business_info[0]['business_type'] == 'S') { echo "checked='checked'";} else { } ?> id="b_no" <?php echo set_radio('b_check','0'); ?>/> No
			<?php } ?>
			</div>	 			 
			<div class="form-group col-md-12">
				<a href="<?php echo base_url().'bookmyt/admin_dashboard/'; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a>
				<button type="submit" name="sub"  onclick="return validate()" class="btn btn-success pull-right">Update</button> 
			</div>			  
				  
				</form>
					</div>
				</div>
			</div>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
function validate(){
	var error = [];
	if($("#b_name").val() == "")
	{
		error.push('e1');			
	}
	if($("#timezone").val()==""){
		error.push('e2');
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
	
	/*if($("#phone").val() == "" || isNaN($("#phone").val()))
	{
		error.push('e5');				
	}
	else
	{
		
		if($("#phone").val().length < 10)
		{
			error.push('e5');
		}
	}*/
	/*if($("#state").val() == "")
	{
		error.push('e6');	
	
	}*/
	if($("#c_code").val() == "")
	{
		error.push('e7');	
	}
	
	if($("#tzone").val() == "")
	{
		error.push('e8');	
	}
	/*if($("#city").val()==""){
		error.push('e9');
	}*/
	var msg='';
	if(error.length != 0)
	{
		if($.inArray("e1", error) !== -1){ msg+="Please enter Branch Name\n";$("#b_name").addClass('error'); } else { $("#b_name").removeClass('error'); }
		if($.inArray("e2", error) !== -1){ msg+="Please select Timezone\n";$("[data-id=timezone]").addClass('error'); } else { $("[data-id=timezone]").removeClass('error'); }
		if($.inArray("e3", error) !== -1){ msg+="Either enter valid Email id or Phone Number\n";	$("#b_email").addClass('error'); } else { $("#b_email").removeClass('error');}
		if($.inArray("e4", error) !== -1){  msg+="Please enter valid 5 digit zipcode\n";$("#b_zip").addClass('error');	 } else { $("#b_zip").removeClass('error');	}
		//if($.inArray("e5", error) !== -1){ msg+="Please enter valid 10 digit phone number\n";$("#phone").addClass('error');	 } else { $("#phone").removeClass('error');	 }
		//if($.inArray("e6", error) !== -1){ msg+="Please fill State details\n";$("#state").addClass('error');		 } else { $("#state").removeClass('error');}
		if($.inArray("e7", error) !== -1){msg+="Please select your country\n"; $("[data-id=c_code]").addClass('error');	 } else { $("[data-id=c_code]").removeClass('error'); }
		if($.inArray("e8", error) !== -1){msg+="Please select your timezone\n";  $("[data-id=tzone]").addClass('error');  } else { $("[data-id=tzone]").removeClass('error'); }	
		//if($.inArray("e9", error) !== -1){msg+="Please fill city details\n"; $("#city").addClass('error');  } else { $("#city").removeClass('error'); }
		
		if(msg!=""){
			alert(msg);
		}				
		return false;
	}
	else
	{
		$("#b_name").removeClass('error');
		$("[data-id=timezone]").removeClass('error');		
		$("#b_email").removeClass('error');
		$("#b_add").removeClass('error');	
		$("#phone").removeClass('error');	
		$("#state").removeClass('error');
		$("[data-id=c_code]").removeClass('error');
		$("[data-id=tzone]").removeClass('error');error = [];
	}
		
}	
</script>
