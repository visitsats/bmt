<style>
		.ccFormatMonitor.cc_type_vs + p::after { content: "Visa"; }
		.ccFormatMonitor.cc_type_jc + p::after { content: "JCB"; }
		.ccFormatMonitor.cc_type_dc + p::after { content: "Diners Club"; }
		.ccFormatMonitor.cc_type_mc + p::after { content: "Mastercard"; }
		.ccFormatMonitor.cc_type_ax + p::after { content: "American Express"; }
		.ccFormatMonitor.cc_type_unknown + p::after { content: "Unknown"; }
</style>
<link href="https://fonts.googleapis.com/css?family=Raleway:500,600" rel="stylesheet"> 
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="signinpanel-cnt1">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h3 class="text-center signinhedding">Get Started for <?php echo ucwords($type); ?></h3>
						<p class="text-center lead hiwcnt">Cancel Anytime    No Risk   <?php if($type=="free"){ ?> No Credit card required<?php } ?></p>
					</div>
					<div class="col-xs-12 text-center" style="color:#FF0000;">
						<?php echo validation_errors(); ?>
					</div>
					<form name="business_signup" action="<?php echo base_url('bookmyt/register_check').'/'.$type; ?>" method="post">
					<div class="signinpanel">
						<div class="<?php if($type!='free'){ echo 'col-sm-8';}else {echo 'col-sm-12';}?> pnone ">
							<div class="reg">
								<h3>Registation details</h3>
								<div class="col-sm-6">
									<div class="form-group">
										<input name="business_name" id="s_business_name" maxlength="50" required="" placeholder="Restaurant Name*" value="<?php echo set_value('business_name'); ?>" class="form-control login-field" type="text">
										<span id="business_error" style="color:#FF0000"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input name="email_phone" id="s_business_email_phn" maxlength="50" required="" placeholder="Email ID*" value="<?php echo set_value('email_phone'); ?>" class="form-control login-field" type="text">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input name="zip" id="s_location" maxlength="10" required="" placeholder="Zip Code*" value="<?php echo set_value('zip'); ?>" class="form-control login-field" onkeypress="return isNumber(event);" type="text">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input name="phone_number" id="phone_number" maxlength="12" required="" placeholder="Phone Number*" value="<?php echo set_value('phone_number'); ?>" onkeypress="return isNumber(event);" class="form-control login-field" type="text">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input name="your_name" id="s_your_name" maxlength="50" required="" placeholder=" Your Name*" value="<?php echo set_value('your_name'); ?>" class="form-control login-field" type="text">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<select class="form-control select2" id="time_zone" name="time_zone" data-placeholder="Select Time Zone">
											<option value="">Select Time Zone*</option>
											<option value="M" <?php echo set_select('time_zone','M'); ?>>Mountain Time Zone</option>
											<option value="P" <?php echo set_select('time_zone','P'); ?>>Pacific Time Zone</option>
											<option value="E" <?php echo set_select('time_zone','E'); ?>>Eastern Time Zone</option>
											<option value="C" <?php echo set_select('time_zone','C'); ?>>Central Time Zone</option>
											<option value="K" <?php echo set_select('time_zone','K'); ?>>Alaska Time Zone</option>
											<option value="A" <?php echo set_select('time_zone','A'); ?>>Atlantic Time Zone</option>
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<div class="checkbox checkbox-success">
											<input name="i_agree" id="l_i_agree" class="styled" type="checkbox" value="1">
											<label for="l_i_agree">Are you the owner</label>
										</div>
									</div>								
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<input name="owner_name" id="owner_name" maxlength="50" placeholder=" Owner's Name" value="<?php echo set_value('owner_name'); ?>" class="form-control login-field" type="text">
									</div>
								</div>
								<div class="col-xs-12">
									<div class="form-group">
										<div class="checkbox checkbox-success">
											<input name="want_demo" id="l_i_help" class="styled" type="checkbox" value="1">
											<label for="l_i_help">Need a help to set up?</label>
										</div>
									</div>									
								</div>
							</div>
						</div>
						<?php
							if($type!='free'){
						?>
						<div class="col-sm-4 pnone ">
							<div class="payment-panel <?php if($type=='free'){echo 'orang';}else if($type=='individual'){echo 'green';}else if($type=='multiple'){echo 'blue';} ?>">
								<h3>Payment Details</h3>
								<div class="pay-cnt">
									<div class="price-plans-payment">
										<h4 class="text-upercase mnone text-center">Subscription Type</h4>
										<div class="col-xs-6 pp-divider">
											<div class="radio radio-success">
												<input name="RadioGroup1" id="help" class="styled" type="radio" value="1" checked="checked">
												<label for="l_i_Annual text-wight"> 
													<h5>Monthly</h5>
													<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo INDIVIDUAL_MONTHLY_PRICE;}else if($type=='multiple'){echo MULTIPLE_MONTHLY_PRICE;} ?></div>
													<p><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo INDIVIDUAL_MONTHLY_PRICE." month/user";}else if($type=='multiple'){echo MULTIPLE_MONTHLY_PRICE." month/user";} ?></p>
												</label>
											</div>
										</div>
										<div class="col-xs-6">
											<div class="radio radio-success">
												<input name="RadioGroup1" id="Annual" class="styled" type="radio" value="2">
												<label for="l_i_Annual text-wight">
													<h5>Annual</h5>
													<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo INDIVIDUAL_ANNUAL_PRICE;}else if($type=='multiple'){echo MULTIPLE_ANNUAL_PRICE;} ?></div>
													<p><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo "15 month/user";}else if($type=='multiple'){echo "25 month/user";} ?></p>
												</label>
											</div>
										</div>
									</div>
									<div class="col-xs-12 text-center">
										<div class="form-group">
											<label>Number of Users</label>
											<input name="no_of_users" id="no_of_users" maxlength="50" required="" placeholder="Number of Users " value="<?php if($this->input->post('no_of_users')!=""){echo set_value('no_of_users');}else{echo "1";} ?>" onkeypress="return isNumber(event);" class="form-control login-field" type="text">
										</div>
									</div>
								</div>
								<div class="col-xs-12">
									<div class=" totalpric">Total <span id="total_price"><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo INDIVIDUAL_MONTHLY_PRICE;}else if($type=='multiple'){echo MULTIPLE_MONTHLY_PRICE;} ?></span></div>
									<input type="hidden" name="total_price" id="tot_price" value="<?php if($type=='individual'){echo INDIVIDUAL_MONTHLY_PRICE;}else if($type=='multiple'){echo MULTIPLE_MONTHLY_PRICE;} ?>" />
								</div>
							</div>
						</div>
						<?php
							}
						?>
					</div>
					<div class="wrap">
						<div class="col-xs-12 text-center">
							<div class="form-group">
								<div class="checkbox checkbox-success">
									 <input name="agree" id="agree"  class="styled" type="checkbox" value="1">
									<label for="agree">By Checking this box, I Agree <a href="<?php echo base_url('bookmyt/terms'); ?>" target="_blank" style="color:#0066FF !important;">Terms of Use</a> and <a href="<?php echo base_url('bookmyt/privacy'); ?>" target="_blank" style="color:#0066FF !important;">Privacy Policy</a></label>
									<br/>
									<div class="clearfix"></div>
									
									<div class="col-sm-12 text-center">
										<input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
										<input type="submit" name="submit" id="sbutt" class="btn btn-success signup mt20" <?php if($type!='free'){?> value="Pay Now" <?php }else{ ?> value="Submit" <?php } ?>/>
									</div>
								</div>
							</div>						
						</div>
					</div>
					</form>
				</div>
			</div>
      	</div>
	</div>
</div>
<?php if ($this->uri->segment(3) !== FALSE){ ?>
		<script type="text/javascript">
			window.location.hash="no-back-button";
			window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
			window.onhashchange=function(){window.location.hash="no-back-button";}
			$(document).ready(function(){
				//$(".login_pwd").trigger('click');
				$("#s_business_name").focus();
			});
		</script>
<?php  } ?>
<script src="<?php echo base_url(); ?>theme/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery.singlePageNav.js"></script> 

<script>
// Prevent console.log from generating errors in IE for the purposes of the demo
if ( ! window.console ) console = { log: function(){} };

// The actual plugin
$('.single-page-nav').singlePageNav({
	offset: $('.single-page-nav').outerHeight(),
	filter: ':not(.external)',
	updateHash: true,
	beforeStart: function() {
		console.log('begin scrolling');
	},
	onComplete: function() {
		console.log('done scrolling');
	}
});
// Prevent console.log from generating errors in IE for the purposes of the demo
if ( ! window.console ) console = { log: function(){} };

// The actual plugin
$('.single-page-nav2').singlePageNav({
	offset: $('.single-page-nav2').outerHeight(),
	filter: ':not(.external)',
	updateHash: true,
	beforeStart: function() {
		console.log('begin scrolling');
	},
	onComplete: function() {
		console.log('done scrolling');
	}
});
</script>
<script type="text/javascript">
<?php if($type!='free'){ ?> 
$('#agree').click(function(){
	$(".card-details-panel" ).slideToggle();
});
<?php } ?>
$(document).ready(function(){
	$("#sbutt").click(function(){
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var msg='';
		if($("#s_business_name").val()==""){
			msg+="fail";
			alert("Restaurant Name is Mandatory");			
			$("#s_business_name").attr("style","border:1px solid red !important");
			$("#s_business_name").focus();
			return false;
		}else{
			$("#s_business_name").attr("style","border:1px solid #ddd !important");
		}
		if($("#s_business_email_phn").val()==""){
			msg+="fail";
			alert("Email ID is Mandatory");
			$("#s_business_email_phn").attr("style","border:1px solid red !important");
			$("#s_business_email_phn").focus();
			return false;
		}else if(isNaN($("#s_business_email_phn").val()) && !regex.test($("#s_business_email_phn").val())){
			msg+="fail";
			alert("Email ID is Mandatory");
			$("#s_business_email_phn").attr("style","border:1px solid red !important");
			$("#s_business_email_phn").focus();
			return false;
		}else{			
			$("#s_business_email_phn").attr("style","border:1px solid #ddd !important");
		}
		if($("#s_location").val()==""){
			msg+="fail";
			alert("Zipcode is Mandatory");
			$("#s_location").attr("style","border:1px solid red !important");
			$("#s_location").focus();
			return false;
		}else if(isNaN($("#s_location").val()) || $("#s_location").val().length!=5 ){
			msg+="fail";
			alert("Valid Zipcode is Mandatory");
			$("#s_location").attr("style","border:1px solid red !important");
			$("#s_location").focus();
			return false;
		}else{
			$("#s_location").attr("style","border:1px solid #ddd !important");
		}
		if($("#phone_number").val()=="" || isNaN($("#phone_number").val()) || $("#phone_number").val().length<10){
			msg+="fail";
			alert("Valid Phone Number is Mandatory");
			$("#phone_number").attr("style","border:1px solid red !important");
			$("#phone_number").focus();
			return false;
		}else{
			$("#phone_number").attr("style","border:1px solid #ddd !important");
		}
		if($("#s_your_name").val()==""){
			msg+="fail";
			alert("Name is Mandatory");
			$("#s_your_name").attr("style","border:1px solid red !important");
			$("#s_your_name").focus();
			return false;
		}else{
			$("#s_your_name").attr("style","border:1px solid #ddd !important");
		}
		if($("#time_zone").val()==""){
			msg+="fail";
			alert("Timezone is Mandatory");
			$("#time_zone").attr("style","border:1px solid red !important");
			$("#time_zone").focus();
			return false;
		}else{
			$("#time_zone").attr("style","border:1px solid #ddd !important");
		}
		<?php if($type!='free'){ ?>
		if($("#no_of_users").val()=="" || $("#no_of_users").val()==0){
			msg+="fail";
			alert("Please enter number of users");
			$("#no_of_users").attr("style","border:1px solid red !important");
			$("#no_of_users").focus();
			return false;
		}else{
			$("#no_of_users").attr("style","border:1px solid #ddd !important");
		}
		if($("#agree").prop('checked') == true){
		}else{
			msg+="fail";
			alert("Please check I-Agree box");
			$("#i_agree").attr("style","border:1px solid red !important");
			$("#i_agree").focus();
			return false;
		}
		<?php }else if($type=="free"){ ?>
		if($("#agree").prop('checked') == true){
		}else{
			msg+="fail";
			alert("Please check I-Agree box");
			$("#i_agree").attr("style","border:1px solid red !important");
			$("#i_agree").focus();
			return false;
		}	
		<?php } 
		if($type=="free"){ ?>
		if(msg==""){
			if(confirm('For security reasons, the transaction should complete in 5 mins. Please be ready with your phone/email')){return true}else{return false;}
		}
		<?php
		}
		else{ ?>
		if(msg==""){
			if(confirm('For security reasons, the transaction should complete in 5 mins. Please be ready with your credit card and phone/email')){return true}else{return false;}
		}
		<?php
		}
		?>
	});
	$("#l_i_agree").click(function(){
		var agree=$("#s_your_name").val();
		if($("#l_i_agree").is(":checked")){
			$("#owner_name").val(agree);
		}else{
			$("#owner_name").val('');
		}
	});
	$("#s_business_name").blur(function(){
		var business_name=$("#s_business_name").val();
		$.ajax({
				url			: "<?php echo base_url('bookmyt/checkDupBusinessName'); ?>",
				type		: 'POST',
				data		: {business_name:business_name},
				success		: function(data){
					
									if($.trim(data)=="Failure"){
										$("#business_error").html("Business name already exists.");
										return false;
									}
								}
		});
	});
	/*$("#s_business_name").blur(function(){
		var business_name=$("#s_business_name").val();
		$.ajax({
				url			: "<?php echo base_url('bookmyt/checkDupBusinessName'); ?>",
				type		: 'POST',
				data		: {business_name:business_name},
				success		: function(data){
					
									if($.trim(data)=="Failure"){
										$("#business_error").html("Business name already exists.");
										return false;
									}
								}
		});
	});
	$("#s_business_name").blur(function(){
		var business_name=$("#s_business_name").val();
		$.ajax({
				url			: "<?php echo base_url('bookmyt/checkDupBusinessName'); ?>",
				type		: 'POST',
				data		: {business_name:business_name},
				success		: function(data){
					
									if($.trim(data)=="Failure"){
										$("#business_error").html("Business name already exists.");
										return false;
									}
								}
		});
	});*/
	$("#no_of_users").blur(function(){
		var sub_type=$("input[name='RadioGroup1']:checked").val();
		var users=$("#no_of_users").val();
		var type=$("#type").val();
		if(sub_type==1 && type=='individual'){
			var price='<?php echo INDIVIDUAL_MONTHLY_PRICE ?>';
		}else if(sub_type==1 && type=='multiple'){
			var price='<?php echo MULTIPLE_MONTHLY_PRICE ?>';
		}else if(sub_type==2 && type=='individual'){
			var price='<?php echo INDIVIDUAL_ANNUAL_PRICE ?>';
		}else if(sub_type==2 && type=='multiple'){
			var price='<?php echo MULTIPLE_ANNUAL_PRICE ?>';
		}
		var total=price*users;
		$("#total_price").html('<i class="fa fa-dollar" aria-hidden="true"></i>'+total);
		$("#tot_price").val(total);
	});
	$('input[type=radio][name=RadioGroup1]').change(function(){
		var sub_type=$("input[name='RadioGroup1']:checked").val();
		var users=$("#no_of_users").val();
		var type=$("#type").val();
		if(sub_type==1 && type=='individual'){
			var price='<?php echo INDIVIDUAL_MONTHLY_PRICE ?>';
		}else if(sub_type==1 && type=='multiple'){
			var price='<?php echo MULTIPLE_MONTHLY_PRICE ?>';
		}else if(sub_type==2 && type=='individual'){
			var price='<?php echo INDIVIDUAL_ANNUAL_PRICE ?>';
		}else if(sub_type==2 && type=='multiple'){
			var price='<?php echo MULTIPLE_ANNUAL_PRICE ?>';
		}
		var total=price*users;
		$("#total_price").html('<i class="fa fa-dollar" aria-hidden="true"></i>'+total);
		$("#tot_price").val(total);
	});
});
function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
</script>