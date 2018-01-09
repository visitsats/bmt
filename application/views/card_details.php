<div class="container">
	<div class="row">
		<div class="signinpanel-cnt">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 text-center">
						<span style="color:#FF0000"><?php echo $this->session->flashdata('error'); ?></span>
					</div>
					<form method="post" action="<?php echo base_url('bookmyt/insert_register').'/'.$type; ?>">
					<div class="col-sm-4 col-xs-12 col-md-offset-4 col-sn-offset-4 col-xs-offset-0 ">
						<div class=" card-details-panel">
							<div class=" card-details-cnt">
								<div class="col-xs-12">
									<input name="card_number" id="card_number"  placeholder="Card Number" value="<?php echo set_value('card_number'); ?>" class="form-control ccFormatMonitor" type="text" maxlength="19">
								</div>
								<div class="col-xs-4">
									<input name="month" id="month"  placeholder="Month(mm)" value="<?php echo set_value('month'); ?>" class="form-control" type="text" maxlength="2">
								</div>
								<div class="col-xs-4">
									<input name="year" id="year"  placeholder="Year(yyyy)" value="<?php echo set_value('year'); ?>" class="form-control" type="text" maxlength="4">
								</div>
								<div class="col-xs-4">
									<input name="cvv" id="cvv"  placeholder="cvv/cvc" value="<?php echo set_value('cvv'); ?>" class="form-control" type="password">
								</div>
								<div class="col-xs-12">
									<input name="cardholder" id="cardholder"  placeholder=" Card holder Name" value="<?php echo set_value('cardholder'); ?>" class="form-control " type="text">
								</div>
							</div>
							<p class="text-xs mt10">Please note that your card will be charged automatically every <?php echo $ten; ?> based on your billing date.</p>
						</div>  
					</div>
					<div class="col-sm-12 mt10 text-center">
					<?php
						$post_data=$this->session->userdata('post_data');
						foreach($post_data as $key=>$value){
							if($key!="rand_number" && $key!="card_number" && $key!="month" && $key!="year" && $key!="cvv" && $key!="cardholder"){
					?>					
							<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
					<?php
							}
						}
					?>
					<input type="submit" name="submit" value="Submit" id="signup" class="btn btn-success signup"/>						
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>theme/js/ccformat.js"></script>
<script type="text/javascript">
$(document).ready(function(){
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
});
</script>