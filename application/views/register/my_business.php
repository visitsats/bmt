<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">My Profile</h4>
         <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p> -->
			<?php if($userdata['subscription_type']==1){ ?>
		<p class="text-right"><a id="modal-launcher" data-target="#changeplan-modal" data-toggle="modal" href="" class="btn btn-success pull-right">Upgrade to Premium User</a></p>
		<?php } ?>
        </div>
		
		<div class="clearfix"></div>
			
			<?php	//pr($this->session->all_userdata());echo $this->session->flashdata('fail');		
				if($this->session->flashdata('success'))
				{
			?>			
				<div class='alert alert-success text-center' > <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('success'); ?></strong></div>		
			<?php
				}
				if($this->session->userdata('fail'))
				{
			?>
				<div class='alert alert-danger text-center'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->userdata('fail'); $this->session->unset_userdata("fail"); ?></strong> </div>	
			<?php
				}
				if(validation_errors()!=""){echo '<div class="alert alert-danger text-center">'.validation_errors().'</div>';}
			?>
			
			<center><span style="color:red;font-weight:bold" id="addbranch_error"><?php echo form_error('business_email'); ?></span></center>
			
        <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
            <div class="panelone  plr10">
			
            <form name="" method="post" role="form" class="wrap mt25" action="<?php echo base_url()."bookmyt/my_business/"; ?>"><input type="hidden" name="relationship_id" value="<?php echo $this->session->userdata('business_id');?>" />
			
			<div class="form-group col-md-6">
		<label class="form-lable ">	 Your Business Name<span class="star">*</span></label>
        <input type="text" placeholder="" class="form-control " maxlength="35"  value="<?php echo $userdata['business_name'];?>" name="business_name"  id = "bname"/>       
         </div>
		 
		 
		<div class="form-group col-md-6">
		 <label class="form-lable ">Select Your Business Type<span class="star">*</span></label>	
                 <select  placeholder="(UTC-05:00) Eastern Time (US & Canada)" class="selectpicker"  name="business_types" id="b_types">
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
		<label class="form-lable ">Business Email Id<span class="star">*</span></label>	
				 <input type="email" placeholder="" class="form-control" value="<?php echo (isset($userdata['business_email']) && $userdata['business_email']!="")?$userdata['business_email']:$_POST['business_email'];?>"  name="business_email" maxlength="35" id="b_email">
             
		</div>
		<div class="form-group col-md-6">
		<label class="form-lable ">	Your Phone Number<span class="star">*</span></label>
                 <input type="text" placeholder="" maxlength="13" class="form-control"  value="<?php echo (isset($userdata['phone_no']) && $userdata['phone_no']!="")?$userdata['phone_no']:$_POST['phone_no'];?>"  name="phone_no" id="phone">
                  
		</div>
		<div class="form-group col-md-6">
		 <label class="form-lable ">Zip code<span class="star">*</span></label>
                 <input type="text" placeholder="" maxlength="150" class="form-control"  value="<?php echo (isset($userdata['zipcode']) && $userdata['zipcode']!="")?$userdata['zipcode']:$_POST['zipcode'];?>"  name="zipcode" id="b_zip" >
                  
		</div>
		<div class="form-group col-md-6">
		 <label class="form-lable ">Address<span class="star"></span></label>
                 <input type="text" placeholder="" maxlength="150" class="form-control"  value="<?php echo (isset($userdata['address']) && $userdata['address']!="")?$userdata['address']:$_POST['address'];?>"  name="address" id="b_add" >
                  
		</div>
		<div class="form-group col-md-6">
	<label class="form-lable ">City<span class="star">*</span></label>	
			<input type="text" placeholder="" maxlength="25" class="form-control" value="<?php echo (isset($userdata['city']) && $userdata['city']!="")?$userdata['city']:$_POST['city'];?>"  name="city" id="city">
             </div>
	
		<div class="form-group col-md-6">
	<label class="form-lable ">State<span class="star">*</span></label>	
			<input type="text" placeholder="" maxlength="25" class="form-control" value="<?php echo (isset($userdata['state']) && $userdata['state']!="")?$userdata['state']:$_POST['state'];?>"  name="state" id="state">
             </div>
		<?php $countries = array('US' => 'United States'); ?>
	
		<div class="form-group col-md-6">
		<label class="form-lable ">Country<span class="star">*</span></label>	
			<select  placeholder="(UTC-05:00) Eastern Time (US & Canada)" class="selectpicker"  name="country" id='c_code'>
				<option value="">Select Your Country</option>
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
		<?php //$time_zones = array('(UTC+05:30) Asia/Kolkata ','(UTC-11:00) Samoa Time Zone (US)','(UTC-10:00 ) Hawaii-Aleutian Time Zone (US)','	
			// (UTC-09:00) Alaska Time Zone (US)','(UTC-08:00 Pacific Time Zone (US & Canada)','(UTC-07:00) Mountain Time Zone (US & Canada)','(UTC-06:00) Central Time Zone (US & Canada)','(UTC-05:00) Eastern Time Zone (US & Canada)','(UTC-04:00) Atlantic Time Zone (US & Canada)','(UTC+10:00) Chamorro Time Zone (US)','(UTC-03:30) Newfoundland Time Zone (Canada)'); ?>
		<!--<div class="form-group col-md-6">
		Your Timezone
				<select  placeholder="(UTC-05:00) Eastern Time (US & Canada)" class="selectpicker"  name="country">
				<option value="">Select Your Timezone</option>
					<?php
					// if(isset($time_zones) && !empty($time_zones))
					// {
						// foreach($time_zones as $key => $val)
						// {
					?>
						<option value="<?php //echo $key; ?>"><?php //echo $val; ?></option>
					<?php
						// }
					// }
					?>
			</select>
                     </div>-->
			<div class="form-group col-md-6" >
				<label class="form-lable ">Time Zone<span class="star">*</span></label>		
                 <select  placeholder="(UTC+05:30) Indian Time (India)" class="selectpicker" name="time_zone" id="tzone">
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
		<?php if($userdata['business_type']!='S'){ ?>
				 <div class="form-group col-md-6">
			Business Having Branches?	&nbsp;&nbsp;
			<input type="radio" name="b_check" value="1"<?php if($userdata['have_branches'] == '1') { echo "checked='checked'";} else { } ?> id="b_yes" <?php echo set_radio('b_check','1'); ?>/> Yes
			<input type="radio" name="b_check" value="0"<?php if($userdata['have_branches'] == '0') { echo "checked='checked'";} else { } ?> id="b_no" <?php echo set_radio('b_check','0'); ?>/> No

		</div>
		
		<div class="form-group col-md-6" id="as_no">
			<input type="checkbox" name="as_branch" value="1" id="as_branch" <?php if($userdata['have_branches'] == '1') { echo "checked='checked'";} else { }  ?> onclick="return false" /> Do you want to make this user as branch?
		</div>
		
		 <?php } ?>
		  <div class="form-group col-md-6">
			1 Reward Point =	&nbsp;&nbsp;
			<input type="number" name="reward" style="border-radius: 20px;box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);border: #c6c6c6 solid 1px !important;background: #fff;height: 34px;padding-left: 10px;padding-right: 8px;" id="reward"  value="<?php echo $userdata['rewards_bill']?>" /> 
		 </div>
		 <div class="form-group col-md-12">		
			<a href="<?php echo base_url().'bookmyt/reservation_list/'; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a>
                <input type="submit" name="sub" class="btn btn-success pull-right" onclick="return validate()"  value="Update" >             
          </div>
		  
</form>
					
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div id="changeplan-modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm2 user-edite">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title text-uppercase text-blue" id="myModalLabel">Plans</h3>	
			</div>
			<div class="modal-body pnone">	
				<div class="col-sm-12 pnone ">
					<form method="post" action="<?php echo base_url('bookmyt/upgrade_plan'); ?>">
						<div class="payment-panel pnone green">
							<div class="pay-cnt">
								<div class="price-plans-payment">
									<h4 class="text-upercase mnone text-center">Upgrade to Individual Plan</h4>
									<div class="col-xs-6 pp-divider">
										<div class="radio radio-success">
											<input name="RadioGroup1" id="help" class="styled" type="radio" value="2" checked="checked"/>
											<label for="l_i_Annual text-wight"> 
												<h5>Monthly</h5>
												<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php echo INDIVIDUAL_MONTHLY_PRICE; ?></div>
												<p><i class="fa fa-dollar" aria-hidden="true"></i><?php echo INDIVIDUAL_MONTHLY_PRICE; ?> month/user</p>
											</label>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="radio radio-success">
											<input name="RadioGroup1" id="Annual" class="styled" type="radio" value="3" />
											<label for="l_i_Annual text-wight">
												<h5>Annual</h5>
												<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php echo INDIVIDUAL_ANNUAL_PRICE; ?></div>
												<p><i class="fa fa-dollar" aria-hidden="true"></i>15 month/user</p>
											</label>
										</div>
									</div>
									<h4 class="text-upercase mnone text-center">Upgrade to Multiple Plan</h4>
									<div class="col-xs-6 pp-divider">
										<div class="radio radio-success">
											<input name="RadioGroup1" id="help" class="styled" type="radio" value="4" />
											<label for="l_i_Annual text-wight"> 
												<h5>Monthly</h5>
												<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php echo MULTIPLE_MONTHLY_PRICE; ?></div>
												<p><i class="fa fa-dollar" aria-hidden="true"></i><?php echo MULTIPLE_MONTHLY_PRICE; ?> month/user</p>
											</label>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="radio radio-success">
											<input name="RadioGroup1" id="Annual" class="styled" type="radio" value="5" />
											<label for="l_i_Annual text-wight">
												<h5>Annual</h5>
												<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php echo MULTIPLE_ANNUAL_PRICE; ?></div>
												<p><i class="fa fa-dollar" aria-hidden="true"></i>25 month/user</p>
											</label>
										</div>
									</div>
									<div class="col-xs-12 text-center">
										<div class="form-group">
											<label>Number of Users</label>
											<input name="no_of_users" id="no_of_users" maxlength="50" required="" placeholder="Number of Users " value="1" onkeypress="return isNumber(event);" class="form-control login-field" type="text">
										</div>
									</div>
									<div class="col-xs-12">
										<div class=" totalpric">Total <span id="total_price"><i class="fa fa-dollar" aria-hidden="true"></i>19</span></div>
									</div>
									<div class="col-sm-12 col-xs-12">
										<div class=" card-details-panel">
											<p style="color:#990000">Please provide your card details.</p>
											<div class=" card-details-cnt">
												<div class="col-xs-12">
													<input name="card_number" id="card_number"  placeholder="Card Number" value="" class="form-control ccFormatMonitor" type="text" maxlength="19">
												</div>
												<div class="col-xs-4">
													<input name="month" id="month"  placeholder="Month(MM)" value="" class="form-control" type="text" maxlength="2">
												</div>
												<div class="col-xs-4">
													<input name="year" id="year"  placeholder="Year(YYYY)" value="" class="form-control" type="text" maxlength="4">
												</div>
												<div class="col-xs-4">
													<input name="cvv" id="cvv"  placeholder="CVV/CCV" value="" class="form-control" type="password" maxlength="4">
												</div>
												<div class="col-xs-12">
													<input name="cardholder" id="cardholder"  placeholder=" Card holder Name" value="" class="form-control " type="text">
												</div>
											</div>
										</div>  
									</div>
								</div>
							</div>
							<div class="col-xs-12 text-center ">
								<input type="hidden" name="your_name" value="<?php echo $userdata['your_name']; ?>" />
								<input type="hidden" name="email_phone" value="<?php echo $userdata['business_email']; ?>" />
								<input type="submit" name="submit" id="change_plan" class="btn btn-default btn-orang mt10 mb10" value="Submit" />
							</div>
						</div>
					</form>		
				</div>
			</div>
			
		</div>	
	</div>
</div>
<script src="<?php echo base_url(); ?>theme/js/ccformat.js"></script>
  <script>
$("#no_of_users").blur(function(){
	var sub_type=$("input[name='RadioGroup1']:checked").val();
	var users=$("#no_of_users").val();
	//var type=$("#type").val();
	if(sub_type==2){
		var price=19;
	}else if(sub_type==4){
		var price=29;
	}else if(sub_type==3){
		var price=180;
	}else if(sub_type==5){
		var price=300;
	}
	var total=price*users;
	$("#total_price").html('<i class="fa fa-dollar" aria-hidden="true"></i>'+total);
});
$('input[type=radio][name=RadioGroup1]').change(function(){
	var sub_type=$("input[name='RadioGroup1']:checked").val();
	var users=$("#no_of_users").val();
	//var type=$("#type").val();
	if(sub_type==2){
		var price=19;
	}else if(sub_type==4){
		var price=29;
	}else if(sub_type==3){
		var price=180;
	}else if(sub_type==5){
		var price=300;
	}
	var total=price*users;
	$("#total_price").html('<i class="fa fa-dollar" aria-hidden="true"></i>'+total);
});
$("#change_plan").click(function(){
	if($("#card_number").val()=="" || $("#card_number").val().length<15){
		alert("Please enter Credit card number");
		$("#card_number").attr("style","border:1px solid red !important");
		return false;
	}else{
		$("#card_number").attr("style","border:1px solid #ddd !important");
	}
	if($("#month").val()=="" || isNaN($("#month").val())){
		alert("Please enter card expiry month");
		$("#month").attr("style","border:1px solid red !important");
		return false;
	}else{
		$("#month").attr("style","border:1px solid #ddd !important");
	}
	if($("#year").val()=="" || isNaN($("#year").val())){
		alert("Please enter card expiry year");
		$("#year").attr("style","border:1px solid red !important");
		return false;
	}else{
		$("#year").attr("style","border:1px solid #ddd !important");
	}
	if($("#cvv").val()=="" || $("#cvv").val().length>4 || isNaN($("#cvv").val())){
		alert("Please enter card CVV/CVC");
		$("#cvv").attr("style","border:1px solid red !important");
		return false;
	}else{
		$("#cvv").attr("style","border:1px solid #ddd !important");
	}
	if($("#cardholder").val()==""){
		alert("Please enter card holder name");
		$("#cardholder").attr("style","border:1px solid red !important");
		return false;
	}else{
		$("#cardholder").attr("style","border:1px solid #ddd !important");
	}
});

  function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
	// $("#addbranch_error").show();
	// $("addbranch_error").fadeOut();
	
	function validate()
	{
		var error = [];
		if($("#bname").val() == "")
		{
			error.push('e1');			
		}
		if($("#b_user_name").val() == "")
		{
			error.push('e10');			
		}
		if($("#b_types").val() == "")
		{		
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
		if($("#b_zip").val() == "" || $("#b_zip").val().length!=5)
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
			if($.inArray("e1", error) !== -1){ msg+="Please enter Business Name\n";$("#bname").addClass('error'); } else { $("#bname").removeClass('error'); }
			if($.inArray("e2", error) !== -1){ $("[data-id=b_types]").addClass('error'); } else { $("[data-id=b_types]").removeClass('error'); }
			if($.inArray("e3", error) !== -1){ msg+="Please enter valid Email id or 10 digit Phone number\n";	$("#b_email").addClass('error'); } else { $("#b_email").removeClass('error');}
			if($.inArray("e4", error) !== -1){ msg+="Please enter valid 5 digit zipcode\n";$("#b_zip").addClass('error');	 } else { $("#b_zip").removeClass('error');	}
			//if($.inArray("e5", error) !== -1){ msg+="Please enter valid 10 digit phone number\n";$("#phone").addClass('error');	 } else { $("#phone").removeClass('error');	 }
			if($.inArray("e6", error) !== -1){ msg+="Please fill State details\n";$("#state").addClass('error');		 } else { $("#state").removeClass('error');}
			if($.inArray("e7", error) !== -1){  msg+="Please select your country\n";$("[data-id=c_code]").addClass('error');	 } else { $("[data-id=c_code]").removeClass('error'); }
			if($.inArray("e8", error) !== -1){msg+="Please select your timezone\n"; $("[data-id=tzone]").addClass('error');  } else { $("[data-id=tzone]").removeClass('error'); }	
			if($.inArray("e9", error) !== -1){msg+="Please fill city details\n"; $("#city").addClass('error');  } else { $("#city").removeClass('error'); }	
			if($.inArray("e10", error) !== -1){msg+="Please enter Name\n"; $("#b_user_name").addClass('error');  } else { $("#b_user_name").removeClass('error'); }				
			if(msg!=""){
				alert(msg);
			}
			return false;
		}
		else
		{
			$("#bname").removeClass('error');
			$("#b_user_name").removeClass('error');
			$("[data-id=b_types]").removeClass('error');
			$("#b_email").removeClass('error');
			$("#b_add").removeClass('error');	
			$("#phone").removeClass('error');	
			$("#state").removeClass('error');
			$("[data-id=c_code]").removeClass('error');
			$("[data-id=tzone]").removeClass('error');
			error = [];
		}
		
	}
	
	$("#bname,#b_types,#b_email,#b_zip,#phone,#state,#c_code,#tzone").change(function()
	{
		if($("#bname").val() != "")
		{
			$("#bname").removeClass('error');		
		}
		
		if($("#b_types").val() != "")
		{		
				$("[data-id=b_types]").removeClass('error');
		}	
			
		if($("#b_email").val() != "")
		{
			$("#b_email").removeClass('error');
		}

		if($("#b_zip").val() != "")
		{
			$("#b_zip").removeClass('error');	
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
	
	
	
	
	
		$("#b_yes").on('click',function()
		{
			if($("#b_yes").prop('checked'))
			{
				$('#as_branch').prop('checked',true);
			}
		});
			
		$("#b_no").on('click',function()
		{
			if($("#b_no").prop('checked'))
			{
				$('#as_branch').prop('checked',false);
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
			/*$("#c_code").change(function()
			{
				var cc = $("#c_code").val();
				$.ajax({
					type :	"POST",
					url	 :	"<?php echo base_url().'bookmyt/get_zones_cc'; ?>",
					data :	{'c_code' : cc},
					success : function(data)
						{
							$("#tzone").html(data);
						}

					});
			});*/
			
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
			 $('#b_zip').keydown(function(event) 
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
			/*$("#b_zip").keyup(function(){
				if($("#b_zip").val().length>=3){
					var zip=$("#b_zip").val();
					$.getJSON('<?php echo base_url("bookmyt/getAddTimezone"); ?>', { zip: zip}, function(json){
					$.each(json, function(key, value){
					
						if(key=='city'){
							$("#city").val(value);
						}else if(key=='country'){
							$("#c_code").val(value);
						}else if(key=='state'){
							$("#state").val(value);
							$('.selectpicker').selectpicker('refresh');
						}else if(key=='timezone'){
							$("#tzone").val(value);
							$('.selectpicker').selectpicker('refresh');
						}
					});
					});
					
					/*$.ajax({
						type	: "POST",
						url		: '<?php echo base_url("bookmyt/getAddTimezone"); ?>',
						data	: {'zip':zip},
						datatype: 'json', 
						success	: function(data){
									alert(data.city);
									/*$.each(data.items, function(key, value){				
										alert(key+' '+value);
									});	
								  }
					});
					
				}
			})*/				
            
        });

  </script>
 