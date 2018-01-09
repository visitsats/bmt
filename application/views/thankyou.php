<div class="container">
	<div class="row">
		<div class="signinpanel-cnt1">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h3 class="text-center">Transaction details</h3>			
						<p class="text-center">Thanks for making the payment. You will receive Transaction details as well as Login detials in separate email.</p>
					</div>
<?php
if($userdata['subscription_type']==2 || $userdata['subscription_type']==3){
	$type='individual';
}else if($userdata['subscription_type']==4 || $userdata['subscription_type']==5){
	$type='multiple';
}
if($userdata['subscription_type']==2){
	$sub_type="Monthly";
	$sub_val=1;
}else if($userdata['subscription_type']==3){
	$sub_type="Annual";
	$sub_val=2;
}else if($userdata['subscription_type']==4){
	$sub_type="Monthly";
	$sub_val=1;
}else if($userdata['subscription_type']==5){
	$sub_type="Annual";
	$sub_val=2;
}
if($type=='individual'){
	$plan="multiple";	
}else if($type=='multiple'){
	$plan="individual";
}

?>
	
					<div class="myacc-panel">
						<div class="col-md-4 col-sm-6 col-xs-12">
						</div>		
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="ac-panel">
								<div class="ac-icon"><img src="<?php echo base_url(); ?>/theme/images/Plan-details.png" alt="Registration Details" /></div>
								<h3 class="text-uppercase text-blue">Transaction details</h3>
								<ul class="list-unstyled list-myac ">
									<li>
										<div class="lable">Payment Status</div>
										<div class="lable-re"><?php echo "Success"; ?></div>
									</li>
									<li>
										<div class="lable">Transaction Date</div>
										<div class="lable-re"><?php echo date('d-M-Y'); ?></div>
									</li>
									<li>
										<div class="lable">Plan type</div>
										<div class="lable-re"><?php echo ucwords($type); ?></div>
									</li>
									<li>
										<div class="lable">Subscription Type</div>
										<div class="lable-re">
											<?php echo $sub_type; ?>							
										</div>  
									</li>
									<li>
										<div class="lable">Number of users </div>
										<div class="lable-re">
											<?php echo $userdata['no_of_users']; ?> Users							
										</div>
									</li>
									<li>
										<div class="lable">Price</div>
										<div class="lable-re">
											<i class="fa fa-dollar" aria-hidden="true"></i><?php echo $userdata['price']; ?>							
										</div>
									</li>
								</ul>				
							</div>
						</div>	
						<div class="col-md-4 col-sm-6 col-xs-12">
						</div>		
					</div>
				</div>
			</div>
		</div>
	</div>
</div>