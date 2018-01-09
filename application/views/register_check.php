<div class="container">
	<div class="row">
		<div class="signinpanel-cnt">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">	
						<?php echo validation_errors(); ?>					
						<p class="text-center lead hiwcnt">Please enter 4 digit OTP sent to your phone and email to authenticate for security.</p>
						<p class="text-right lead hiwcnt" id="demo" style="color:#999999;font-size:16px;"></p>				
					</div>
					<form method="post" action="<?php echo base_url('bookmyt/insert_register').'/'.$type; ?>">
					<div class="signinpanel">
						<div class="col-sm-12 p15">
							<div class="col-sm-12 text-center">
							<?php
								if($this->session->flashdata('error')!=""){
									echo "<span style='color:red;'>".$this->session->flashdata('error')."</span>";
								}
							?>
							</div>
							<div class="col-sm-4 col-xs-12 col-md-offset-4 col-sn-offset-4 col-xs-offset-0 ">
								<div class="form-group">
									<input name="rand_number" id="rand_number" maxlength="50" required="" placeholder="OTP" value="<?php echo set_value('rand_number'); ?>" class="form-control login-field" type="text">	 <a id="resend_otp" class="btn btn-success disabled btn" href="javascript:void(0)">Resend OTP</a>								
								</div>
								
							</div>
							<?php
								if($type!="free"){
									if($this->input->post('RadioGroup1')==1){
										$tenure="Monthly";
										$ten="month";
									}else if($this->input->post('RadioGroup1')==2){
										$tenure="Annual";
										$ten="year";
									}
							?>
									<div class="col-sm-4 col-xs-12 col-md-offset-4 col-sn-offset-4 col-xs-offset-0 ">
										<ul class="list-unstyled list-myac ">
											<li>
												<div class="lable">Subscription Type</div>
												<div class="lable-re"><?php echo ucwords($type)." ".$tenure; ?></div>
											</li>
											<li>
												<div class="lable">Number of Users</div>
												<div class="lable-re"><?php echo $this->input->post('no_of_users'); ?></div>
											</li>
											<li>
												<div class="lable">Total Amount</div>
												<div class="lable-re">
													<i class="fa fa-dollar" aria-hidden="true"></i><?php echo $this->input->post('total_price'); ?>							
												</div>  
											</li>										
										</ul>
									</div>
							<div class="col-sm-4 col-xs-12 col-md-offset-4 col-sn-offset-4 col-xs-offset-0 ">
								<div class=" card-details-panel">
									<div class=" card-details-cnt">
										<div class="col-xs-12">
											<input name="card_number" id="card_number"  placeholder="Card Number" value="<?php echo set_value('card_number'); ?>" class="form-control ccFormatMonitor" type="text" maxlength="19">
										</div>
										<div class="col-xs-4">
											<input name="month" id="month"  placeholder="Month(MM)" value="<?php echo set_value('month'); ?>" class="form-control" type="text" maxlength="2">
										</div>
										<div class="col-xs-4">
											<input name="year" id="year"  placeholder="Year(YYYY)" value="<?php echo set_value('year'); ?>" class="form-control" type="text" maxlength="4">
										</div>
										<div class="col-xs-4">
											<input name="cvv" id="cvv"  placeholder="CVV/CCV" value="<?php echo set_value('cvv'); ?>" class="form-control" type="password" maxlength="4">
										</div>
										<div class="col-xs-12">
											<input name="cardholder" id="cardholder"  placeholder=" Card holder Name" value="<?php echo set_value('cardholder'); ?>" class="form-control " type="text">
										</div>
									</div>
									<p class="text-xs mt10">Please note that your card will be charged automatically every <?php echo $ten; ?> based on your billing date.</p>
								</div>  
							</div>
							<?php
								}
							?>
							<div class="clearfix"></div>
							<div class="col-sm-12 mt10 text-center">
								<?php
									if(!empty($post_data)){
										foreach($post_data as $key=>$value){
											if($key!='rand_number' && $key!="or_number"){
								?>
											<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
								<?php
											}
											if($key=='email_phone'){
								?>
												<input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>" />
								<?php
											}			
										}
									}	
								?>
								<input type="hidden" id="or_number" name="or_number" value="<?php echo $rand_number; ?>" />
								<input type="submit" name="submit" value="Submit" id="signup" class="btn btn-success signup"/>
							</div>
						</div>
					</div>	
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
// Set the date we're counting down to
var countDownDate = new Date();
countDownDate.setMinutes(countDownDate.getMinutes() + 5);

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = +minutes + "m " + seconds + "s ";
	//alert(distance);
  // If the count down is finished, write some text
  if(minutes<4){  	
  	document.getElementById("resend_otp").classList.remove("disabled");
  }
  if (distance < 0) {
    clearInterval(x);
	document.getElementById("demo").innerHTML ='';
	window.location='<?php echo $_SERVER['HTTP_REFERER'];?>';
    //document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
<script src="<?php echo base_url(); ?>theme/js/ccformat.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	<?php
		if($type!="free"){
	?>
	$("#signup").click(function(){
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
	<?php
		}
	?>
	$("#resend_otp").click(function(){
		$.ajax({
				url			: '<?php echo base_url('bookmyt/resend_otp'); ?>',
				method		: 'POST',
				data		: {'resend_val':$("#or_number").val(),'email_phone':$("#email_phone").val()},
				success		: function(data){
									alert(data);
									//document.getElementById("resend_otp").classList.add("hide");
									 document.getElementById('resend_otp').style.visibility = 'hidden';
								
								}
		});
	});
});	
</script>