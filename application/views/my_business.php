<style>
	.ccFormatMonitor.cc_type_vs + p::after { content: "Visa"; }
	.ccFormatMonitor.cc_type_jc + p::after { content: "JCB"; }
	.ccFormatMonitor.cc_type_dc + p::after { content: "Diners Club"; }
	.ccFormatMonitor.cc_type_mc + p::after { content: "Mastercard"; }
	.ccFormatMonitor.cc_type_ax + p::after { content: "American Express"; }
	.ccFormatMonitor.cc_type_unknown + p::after { content: "Unknown"; }
	
</style>
<div class="container">
	<div class="col-sm-7 col-xs-12">
		<h3 class="text-right text-center-xs">My Account</h3>

		
		
		
		
		
		<!--<p class="text-center lead hiwcnt">We have developed a cost effective yet highly efficient solution for restaurant owners. It's for every restaurant big or small, boutique or chain, who </p>-->
	</div>
	
	
	<div class="col-sm-5 col-xs-12 text-right text-center-xs mt15">
			<a class="btn btn-success " id="modal-launcher" href="javascript:void(0)" data-target="#cancel-modal" data-toggle="modal">Cancel Account</a>
	</div>
	<div class="col-xs-12 text-center">
		<?php			
			if($this->session->flashdata('success'))
			{
		?>
		<div class='alert alert-success text-center' id='fo'> 
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('success'); ?></strong>
		</div>
		<?php
			}
		?>		
	</div>	
	
<?php
if($userdata['subscription_type']==2 || $userdata['subscription_type']==3){
	$type='individual';
}else if($userdata['subscription_type']==4 || $userdata['subscription_type']==5){
	$type='multiple';
}
if($userdata['subscription_type']==2 || $userdata['subscription_type']==4){
	$upgrade_type="Annual";
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
$date1=date_create(date('Y-m-d',strtotime($userdata['subscription_end_dt'])));
$date2=date_create(date('Y-m-d'));
$diff=date_diff($date2,$date1);
$diff= $diff->format("%R%a");
$days=cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($userdata['subscription_end_dt'])),date('Y',strtotime($userdata['subscription_end_dt'])));
$used_days=$days-$diff;
/*Individual Monthly to Multiple Monthly Start*/
$cur_price_per_day=INDIVIDUAL_MONTHLY_PRICE/$days;
$cur_price_per_day=round($cur_price_per_day,2);
$upg_price_per_day=MULTIPLE_MONTHLY_PRICE/$days;
$upg_price_per_day=round($upg_price_per_day,2);
$cur_price_per_user=$cur_price_per_day*(int)$used_days;
$upg_price_per_user=$upg_price_per_day*(int)$diff;
$rem_amount=INDIVIDUAL_MONTHLY_PRICE-$cur_price_per_user;
$adj_amount=$upg_price_per_user-$rem_amount;
$adj_amount=$adj_amount*$userdata['no_of_users'];//Current Transaction Amount

$price=MULTIPLE_MONTHLY_PRICE*$userdata['no_of_users'];//Subscription Amount
/*Individual Monthly to Multiple Monthly End*/
/*Individual Monthly to Multiple Annual Start*/
$cur_price_per_day_annual=INDIVIDUAL_MONTHLY_PRICE/$days;
$cur_price_per_day_annual=round($cur_price_per_day_annual,2);
$upg_price_per_day_annual=MULTIPLE_ANNUAL_PRICE/365;
$upg_price_per_day_annual=round($upg_price_per_day_annual,2);
$cur_price_per_user_annual=$cur_price_per_day_annual*(int)$used_days;
$upg_price_per_user_annual=$upg_price_per_day_annual*(int)$diff;
$rem_amount_annual=INDIVIDUAL_MONTHLY_PRICE-$cur_price_per_user_annual;
$adj_amount_annual=$upg_price_per_user_annual-$rem_amount_annual;
$adj_amount_annual=$adj_amount_annual*$userdata['no_of_users'];//Current Transaction Amount

$price_annual=MULTIPLE_ANNUAL_PRICE*$userdata['no_of_users'];//Subscription Amount
/*Individual Monthly to Multiple Annual End*/
/*Individual Annual to Multiple Annual Start*/
$used_days=365-(int)$diff;
$cur_price_per_day_annual1=INDIVIDUAL_ANNUAL_PRICE/365;
$cur_price_per_day_annual1=round($cur_price_per_day_annual1,2);
$upg_price_per_day_annual1=MULTIPLE_ANNUAL_PRICE/365;
$upg_price_per_day_annual1=round($upg_price_per_day_annual1,2);
$cur_price_per_user_annual1=$cur_price_per_day_annual1*(int)$used_days;
$upg_price_per_user_annual1=$upg_price_per_day_annual1*(int)$diff;
$rem_amount_annual1=INDIVIDUAL_ANNUAL_PRICE-$cur_price_per_user_annual1;
$adj_amount_annual1=$upg_price_per_user_annual1-$rem_amount_annual1;
$adj_amount_annual1=$adj_amount_annual1*$userdata['no_of_users'];//Current Transaction Amount

$price_annual1=MULTIPLE_ANNUAL_PRICE*$userdata['no_of_users'];//Subscription Amount

/*Individual Annual to Multiple Annual End*/
?>
	<div class="myacc-panel mt20">
		<?php
			if($userdata['subscription_type']!=1){
		?>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="ac-panel">
				<div class="ac-icon"><img src="<?php echo base_url(); ?>/theme/images/Plan-details.png" alt="Registration Details" /></div>
				<h3 class="text-uppercase text-blue">Plan details</h3>
				<ul class="list-unstyled list-myac ">
					<li>
						<div class="lable">Plan type</div>
						<div class="lable-re"><?php echo ucwords($type); ?></div>
					</li>
					<li>
						<div class="lable">Subscription Type</div>
						<div class="lable-re">
							<?php echo $sub_type; ?>
							<?php if($sub_type!='Annual'){?>
								<a id="modal-launcher" class="btn btn-default btm-small btn-blue" href="#" data-target="#subtype-modal" data-toggle="modal" >Change</a>
							<?php } ?>
						</div>  
					</li>
					<li>
						<div class="lable">Number of users </div>
						<div class="lable-re">
							<?php echo $userdata['no_of_users']; ?> Users  
							<a id="modal-launcher" class="btn btn-default btm-small btn-blue" href="#" data-target="#updateusers-modal" data-toggle="modal" >Manage users</a>
						</div>
					</li>
				</ul>
				<div class="ac-panel-edit-btn text-center">
					<?php
						if($userdata['subscription_type']==5){
					?>
							
					<?php
						}else{
					?>
							<a id="modal-launcher" class="btn btn-default btn-blue" href="#" data-target="#changeplan-modal" data-toggle="modal">Upgrade Plan</a>
					<?php
						}
					?>
				</div>
			</div>
		</div>
		<?php
			}
		?>		
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="ac-panel ">
				<div class="ac-icon"><img src="<?php echo base_url(); ?>/theme/images/registration-details.png" alt="Registration Details" /></div>
				<h3 class="text-uppercase text-orang">Registration details</h3>
				<ul class="list-unstyled list-myac ">
					<li>
						<div class="lable">Restaurant Name</div>
						<div class="lable-re"><?php echo $userdata['business_name']; ?></div>
					</li>
					<li>
						<div class="lable">Owner's Name</div>
						<div class="lable-re"><?php echo $userdata['owner_name']; ?></div>
					</li>
					<li>
						<div class="lable">Email ID </div>
						<div class="lable-re"><?php echo $userdata['business_email']; ?></div>
					</li>
					<li>
						<div class="lable">Phone Number</div>
						<div class="lable-re"><?php echo $userdata['phone_no']; ?></div>
					</li>
					<li>
						<div class="lable">Zip Code</div>
						<div class="lable-re"><?php echo $userdata['zipcode']; ?> </div>
					</li>
				</ul>
				<div class="ac-panel-edit-btn text-center">
					<a class="btn btn-default btn-orang" href="<?php echo base_url('bookmyt/my_business').'/'.$this->session->userdata('business_id'); ?>" >Edit details</a>
				</div>
			</div>
		</div>
		<?php
			if($userdata['subscription_type']!=1){
		?>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="ac-panel sm-mt-60">
				<div class="ac-icon"><img src="<?php echo base_url(); ?>/theme/images/payment-details.png" alt="Registration Details" /></div>
				<h3 class="text-uppercase text-green">Payment Details</h3>
				<ul class="list-unstyled list-myac ">
					<li>
						<div class="lable"><?php echo $sub_type; ?>  Pay</div>
						<div class="lable-re text-right"><span class="price-big">$<?php echo $userdata['price']; ?></span></div>
					</li>
					<li>
						<div class="lable">Next Payment</div>
						<div class="lable-re text-right"><?php echo date('d-M-Y',strtotime($userdata['subscription_end_dt']."+1 day")); ?></div>
					</li>
					<?php /*?><li>
						<div class="lable">Card Number</div>
						<div class="lable-re text-right"><?php echo "xxxxxxxxxxxx".$payment_details['credit_card']; ?></div>
					</li>
					<li>
						<div class="lable">Card Holder Name</div>
						<div class="lable-re text-right"><?php echo $payment_details['cardholder_name']; ?></div>
					</li><?php */?>
				</ul>				
				<div class="ac-panel-edit-btn text-center ">
					<!--<a class="btn btn-default btn-green" id="modal-launcher" href="#" data-target="#editcard-modal" data-toggle="modal" >Edit details</a>-->
					<a class="btn btn-default btn-green" id="modal-launcher" href="#" data-target="#vwtrans-modal" data-toggle="modal"  href="javascript:void(0)">View Transactions</a>
				</div>
			</div>
		</div>	
		<?php
			}
		?>		
	</div>
</div>

<div id="updateusers-modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm2 user-edite">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>			
			</div>
			<div class="modal-body ">
				<ul class="nav nav-tabs ">					
					<li class="active"><a data-toggle="tab" href="#menu1">Buy Additional Users</a></li>
					<li><a data-toggle="tab" href="#home">Delete Users</a></li>
				</ul>			
				<div class="tab-content">
					<div id="home" class="tab-pane fade">
						<div class="clearfix"></div>
						<ul class="list-unstyled users-list">
							<form method="post" action="<?php echo base_url('bookmyt/unsubscribe'); ?>">
							<?php 								
								if(!empty($user_details)){
									foreach($user_details as $user){
										if($user['business_id']!=$this->session->userdata('business_id')){
							?>
										
										<li>
											<div class="checkbox checkbox-success">
												<input name="user_id[]" id="user_email_<?php echo $user['business_id']; ?>" class="styled" <?php if($user['is_delete']==1){echo 'disabled';} ?> value="<?php echo $user['business_id'].'^'.$user['table']; ?>" type="checkbox">
												<label for="user_email_<?php echo $user['business_id']; ?>"><?php echo ($user['business_email']!="")?$user['business_email']:$user['phone_no']; ?></label>
											</div>
										</li>
							<?php
										}
									}
								}else{
									echo '<li>No Users Available</li>';
								}	
							?>
							<li class="text-center">
								<button type="submit" class="btn btn-default btn-block btn-orang <?php if(count($user_details)<=1){echo 'disabled';}?>" <?php if(count($user_details)<=1){echo 'disabled';}?> onclick="if(confirm('This action may lead change in subscription. Would you like to proceed?')){return true}else{return false;}">Unsubscribe</button>
							</li>
							<input type="hidden" name="subscription" value="<?php echo $userdata['subscription_type']; ?>" />
							<input type="hidden" name="subscription_id" value="<?php echo $payment_details['subscription_id']; ?>" />							
							<input type="hidden" name="no_of_users" value="<?php echo $userdata['no_of_users']; ?>" />
							<input type="hidden" name="business_name" value="<?php echo $userdata['business_name']; ?>" />
							</form>
						</ul>
					</div>
					<div id="menu1" class="tab-pane fade in active" style="padding-top:15px;">
						<form method="post" action="<?php echo base_url('bookmyt/add_user_subscription'); ?>">
						<label style="width:60%; float:left;">Current users </label>						
						<span style="width:40%;float:left"><?php echo $userdata['no_of_users']; ?></span>
						<label style="width:60%; float:left;">Current Price </label>
						<span style="width:40%;float:left"><i class='fa fa-dollar' aria-hidden='true'></i><?php echo $userdata['price']; ?></span>
						<label class="mt15" style="width:60%; float:left;">Add Users</label>
						<input type="text" class="form-control " id="no_of_users" onkeypress="return isNumber(event);" name="no_of_users" value=""  style="width:40%; float:right;"/>
						<div class="clearfix"></div>
						<div id="adj_amount"></div>
						<input type="hidden" id="existing_users" name="existing_users" value="<?php echo $userdata['no_of_users']; ?>" />
						<input type="hidden" id="added_users" name="added_users" value="<?php echo count($user_details); ?>" />
						<input type="hidden" name="sub_end_date" value="<?php echo $userdata['subscription_end_dt']; ?>" />
						<input type="hidden" id="subscription_type" name="subscription_type" value="<?php echo $userdata['subscription_type']; ?>" />
						<input type="hidden" name="subscription_id" value="<?php echo $payment_details['subscription_id']; ?>" />
						<button type="submit" id="add_user_sub" class="btn btn-default btn-block btn-orang"  style=" margin-top:10px; text-align:center" >Update Users</button>
						</form>
					</div>
				</div>			
			</div>
			<div class="modal-footer text-center">
			
			</div>
		</div>	
	</div>
</div>

<div id="subtype-modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm2 user-edite">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title text-uppercase text-blue" id="myModalLabel">Current Plan : <?php echo $type; ?></h3>	
			</div>
			<div class="modal-body pnone">	
				<div class="col-sm-12 pnone ">
					<form method="post" action="<?php echo base_url('bookmyt/change_subscription_type'); ?>">
						<div class="payment-panel pnone green">
							<div class="pay-cnt">
								<div class="price-plans-payment">
									<h4 class="text-upercase mnone text-center">Upgrade to <?php echo $upgrade_type; ?></h4>
									<div class="col-xs-6 pp-divider">
										<div class="radio radio-success">
											<input name="RadioGroup2" id="help" class="styled" type="radio" value="1" <?php if($sub_type=="Monthly"){echo 'checked=checked';} ?>/>
											<label for="l_i_Annual text-wight"> 
												<h5>Monthly</h5>
												<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo INDIVIDUAL_MONTHLY_PRICE;}else if($type=='multiple'){echo MULTIPLE_MONTHLY_PRICE;} ?></div>
												<p><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo INDIVIDUAL_MONTHLY_PRICE." month/user";}else if($type=='multiple'){echo MULTIPLE_MONTHLY_PRICE." month/user";} ?></p>
											</label>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="radio radio-success">
											<input name="RadioGroup2" id="Annual" class="styled" type="radio" value="2" <?php if($sub_type=="Annual"){echo 'checked=checked';} ?>/>
											<label for="l_i_Annual text-wight">
												<h5>Annual</h5>
												<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo INDIVIDUAL_ANNUAL_PRICE;}else if($type=='multiple'){echo MULTIPLE_ANNUAL_PRICE;} ?></div>
												<p><i class="fa fa-dollar" aria-hidden="true"></i><?php if($type=='individual'){echo "15 month/user";}else if($type=='multiple'){echo "25 month/user";} ?></p>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 monthly_details hidden-xs" id="plan_details">
							</div>
							<div class="col-sm-12 col-xs-12">
								<div class=" card-details-panel" style="display:none">
									<div class="col-xs-12 mt10"><p class="text-xs text-defult col-xs-12">You need to provide your card details once again as tenure is changing to annual</p></div>
									<div class=" card-details-cnt">
										<div class="col-xs-12">
											<input name="card_number" id="card_number2"  placeholder="Card Number" value="" class="form-control ccFormatMonitor" type="text" maxlength="19">
										</div>
										<div class="col-xs-4">
											<input name="month" id="month2"  placeholder="Month(MM)" value="" class="form-control" type="text" maxlength="2">
										</div>
										<div class="col-xs-4">
											<input name="year" id="year2"  placeholder="Year(YYYY)" value="" class="form-control" type="text" maxlength="4">
										</div>
										<div class="col-xs-4">
											<input name="cvv" id="cvv2"  placeholder="CVV/CCV" value="" class="form-control" type="password">
										</div>
										<div class="col-xs-12">
											<input name="cardholder" id="cardholder2"  placeholder=" Card holder Name" value="" class="form-control " type="text">
										</div>
									</div>
								</div>  
							</div>
							<div class="col-xs-12 text-center ">
								<input type="hidden" name="plan" value="<?php echo $plan; ?>" />
								<input type="hidden" name="subscription_id" value="<?php echo $payment_details['subscription_id']; ?>" />
								<input type="hidden" name="no_of_users" value="<?php echo $userdata['no_of_users']; ?>" />
								<input type="hidden" name="your_name" value="<?php echo $userdata['your_name']; ?>" />
								<input type="hidden" name="business_name" value="<?php echo $userdata['business_name']; ?>" />
								<input type="hidden" name="email_phone" value="<?php echo ($userdata['business_email']!="")?$userdata['business_email']:$userdata['phone_no']; ?>" />
								<input type="hidden" name="subscription_type" value="<?php echo $userdata['subscription_type']; ?>" />
								<input type="submit" name="submit" id="subtype_plan" class="btn btn-default btn-orang mt10 mb10" value="Submit" onclick="if(confirm('This action may lead to charges and change in subscription. Would you like to proceed..?')){return true}else{return false;}" />
							</div>
						</div>
					</form>		
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
				<h3 class="modal-title text-uppercase text-blue" id="myModalLabel">Current Plan : <?php echo $type.' '.$sub_type; ?></h3>
				<!--<h3 class="modal-title text-uppercase text-blue" id="myModalLabel">Number of Users : <?php echo $userdata['no_of_users']; ?></h3>
				<h3 class="modal-title text-uppercase text-blue" id="myModalLabel">Total Price : <i class="fa fa-dollar" aria-hidden="true"></i><?php echo $userdata['price']; ?></h3>-->	
			</div>
			<div class="modal-body pnone">	
				<div class="col-sm-12 pnone ">
					<form method="post" action="<?php echo base_url('bookmyt/change_plan'); ?>">
						<div class="payment-panel pnone green">
							<div class="pay-cnt">
								<div class="price-plans-payment">
									<h4 class="text-upercase mnone text-center">Upgrade to <?php echo $plan; ?></h4>
									<?php
										if($userdata['subscription_type']==3 || $userdata['subscription_type']==4){}else{
									?>
									<div class="col-xs-6 pp-divider">
										<div class="radio radio-success">
											<input name="RadioGroup1" id="help" class="styled" type="radio" value="1" />
											<label for="l_i_Annual text-wight"> 
												<h5>Monthly</h5>
												<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php if($plan=='individual'){echo "19";}else if($plan=='multiple'){echo "29";} ?></div>
												<p><i class="fa fa-dollar" aria-hidden="true"></i><?php if($plan=='individual'){echo "19 month/user";}else if($plan=='multiple'){echo "29 month/user";} ?></p>
											</label>
										</div>
									</div>
									<?php
										}
									?>
									<div class="col-xs-6">
										<div class="radio radio-success">
											<input name="RadioGroup1" id="Annual" class="styled" type="radio" value="2" />
											<label for="l_i_Annual text-wight">
												<h5>Annual</h5>
												<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php if($plan=='individual'){echo "180";}else if($plan=='multiple'){echo "300";} ?></div>
												<p><i class="fa fa-dollar" aria-hidden="true"></i><?php if($plan=='individual'){echo "15 month/user";}else if($plan=='multiple'){echo "25 month/user";} ?></p>
											</label>
										</div>
									</div>
								</div>
							</div>							
							<div class="col-xs-12 monthly_details hidden-xs" id="monthly_details">
<!--								<div class="col-xs-6">
									<div class="pp-plan-details">
										<h4 class="text-left">Current plan details</h4>
										<ul class="list-unstyled">
											<li><label>No. of Users</label><span><?php echo $userdata['no_of_users']; ?></span>  </li>
											<li><label>Current Billing</label><span><i class="fa fa-dollar" aria-hidden="true"></i>10</span> </li>
											<li><label>Subscription</label><span> Monthly</span>   </li>
										</ul>
									</div>
								</div>
								<div class="col-xs-6 upgrade-plan">
									<div class="pp-plan-details">
										<h4 class="text-left">Upgrade plan details</h4>
										<ul class="list-unstyled">
											<li><label>Number of Users</label><span> 9</span>  </li>
											<li><label>Price</label><span> 20</span> </li>
											<li><label>Subscription</label><span> Monthly</span>   </li>
										</ul>
									</div>
								</div>
-->							</div>
							<div class="col-sm-12 col-xs-12">
										<div class=" card-details-panel" style="display:none">
											<div class="col-xs-12 mt10"><p class="text-xs text-defult col-xs-12">You need to provide your card details once again as tenure is changing to annual</p></div>
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
													<input name="cvv" id="cvv"  placeholder="CVV/CCV" value="" class="form-control" type="password">
												</div>
												<div class="col-xs-12">
													<input name="cardholder" id="cardholder"  placeholder=" Card holder Name" value="" class="form-control " type="text">
												</div>
											</div>
										</div>  
									</div>
							
							<div class="col-xs-12 text-center ">
								<input type="hidden" name="plan" value="<?php echo $plan; ?>" />
								<input type="hidden" name="subscription_id" value="<?php echo $payment_details['subscription_id']; ?>" />
								<input type="hidden" name="no_of_users" value="<?php echo $userdata['no_of_users']; ?>" />
								<input type="hidden" name="your_name" value="<?php echo $userdata['your_name']; ?>" />
								<input type="hidden" name="business_name" value="<?php echo $userdata['business_name']; ?>" />
								<input type="hidden" name="email_phone" value="<?php echo ($userdata['business_email']!="")?$userdata['business_email']:$userdata['phone_no']; ?>" />
								<input type="hidden" name="subscription_type" value="<?php echo $userdata['subscription_type']; ?>" />
								<input type="submit" name="submit" id="change_plan" class="btn btn-default btn-orang mt10 mb10" value="Submit"  />
							</div>
						</div>
					</form>		
				</div>
			</div>
			
		</div>	
	</div>
</div>

<div id="vwtrans-modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm2 user-edite">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title text-uppercase text-blue" id="myModalLabel">View Transactions</h3>	
			</div>
			<div class="modal-body pnone">	
				<div class="col-sm-12 pnone">
					<form method="post" action="<?php echo base_url('bookmyt/change_card'); ?>">
						<div class="payment-panel-one pnone green">
							<div class="pay_cnt_one">
								<div class="price-plans-payment-one">									
									<div class="col-sm-12 col-xs-12 table_block_one">
										<table cellpadding="2" border="1" cellspacing="2">
											<tr>
												<th>Subscription Type</th>
												<th>Subscription Start</th>
												<th>Subscription End</th>
												<th>Price</th>												
											</tr>										
											
											<?php
												//pr($transaction_details);
												if(!empty($transaction_details)){
													foreach($transaction_details as $trans){
														if($trans['sub_type']!=1){
															if($trans['sub_type']==2){
																$sub_type1="Individual Monthly";
															}else if($trans['sub_type']==3){
																$sub_type1="Individual Annual";
															}else if($trans['sub_type']==4){
																$sub_type1="Multiple Monthly";
															}else if($trans['sub_type']==5){
																$sub_type1="Multiple Annual";
															} 
											?>
															<tr>
																<td><?php echo $sub_type1; ?></td>
																<td><?php echo date("d-M-Y",strtotime($trans['sub_start'])); ?></td>
																<td><?php echo date("d-M-Y",strtotime($trans['sub_end'])); ?></td>
																<td><?php echo "$".$trans['price']; ?></td>
															</tr>
											<?php
														}
													}
												}	
											?>		
										</table> 
										
									</div>
								</div>
							</div>
							<?php /*?><div class="col-xs-12 text-center ">								
								<input type="hidden" name="subscription_id" value="<?php echo $payment_details['subscription_id']; ?>" />								
								<input type="hidden" name="business_name" value="<?php echo $userdata['business_name']; ?>" />
								<input type="hidden" name="email_phone" value="<?php echo ($userdata['business_email']!="")?$userdata['business_email']:$userdata['phone_no']; ?>" />
								<input type="hidden" name="subscription_type" value="<?php echo $userdata['subscription_type']; ?>" />
								<input type="submit" name="submit" id="change_card" class="btn btn-default btn-orang mt10 mb10" value="Submit" onclick="if(confirm('This action may lead to charges and change in subscription. Would you like to proceed?')){return true}else{return false;}"/>
							</div><?php */?>
						</div>
					</form>		
				</div>
			</div>
		</div>	
	</div>
</div>

<div id="cancel-modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm2 user-edite">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title text-uppercase text-blue" id="myModalLabel">Cancel Account</h3>	
			</div>
			<div class="modal-body pnone">	
				<div class="col-sm-12 pnone ">
					<form method="post" action="<?php echo base_url('bookmyt/cancel_account'); ?>">
						<div class="payment-panel pnone green">
							<div class="pay-cnt">
								<div class="price-plans-payment1">									
									<div class="col-sm-12 col-xs-12">
										<div class=" card-details-panel">
											<p>By Cancelling, you will not be able to access the BOOKMYT services</p>
										</div>  
									</div>
								</div>
							</div>
							<div class="col-xs-12 text-center ">								
								<input type="hidden" name="subscription_id" value="<?php echo $payment_details['subscription_id']; ?>" />								
								<a class="btn btn-default btn-orang mt10 mb10 pull-right" data-dismiss="modal">Cancel</a>
								<input type="submit" name="submit" id="change_card" class="btn btn-default btn-orang mt10 mb10 pull-left" value="Confirm" />
							</div>
						</div>
					</form>		
				</div>
			</div>
			
		</div>	
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url(); ?>theme/js/ccformat.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".reg-details-btn").click(function(){		
		$(".reg-details").toggle();
		if ($(this).text() == "Edit details") {
			$(this).text("Save details")
		} else if ($(this).text() == "Save details") {
			$(this).text("Edit details");
		} 
	});
	$("#add_user_sub").click(function(){
		var existing_users=parseInt($("#existing_users").val());
		var new_users=parseInt($("#no_of_users").val());
		var added_users=parseInt($("#added_users").val());		
		if($("#no_of_users").val()==""){
			alert("Please enter the number of users to be added");
			return false;
		}else{
			if(confirm('This action may charge your card & change in Subscription. Would you like to proceed..?')){return true}else{return false;}
		}
	});
	$("#change_plan").click(function(){
		var chkd_val1=$('input[name=RadioGroup1]:checked').val();
		var sub_type1='<?php echo $sub_val; ?>';
		if($('input[name=RadioGroup1]:checked').length<=0){
			alert("Please select the subscription type");
			return false;
		}else{
			if(confirm('This action may lead to charges & change in Subscription. Would you like to proceed..?')){return true}else{return false;}
		}
	});
	$("#subtype_plan").click(function(){
		var chkd_val=$('input[name=RadioGroup2]:checked').val();
		var sub_type='<?php echo $sub_val; ?>';
		if(chkd_val==sub_type){
			alert("Please select the other option to change the plan");
			return false;
		}
	});
	$('input[name=RadioGroup2]').click(function(){
		var chkd_val=$('input[name=RadioGroup2]:checked').val();
		var sub_type='<?php echo $sub_val; ?>';
		var type='<?php echo $type; ?>';
		var users='<?php echo $userdata['no_of_users']; ?>';
		if(sub_type!=chkd_val){
			if(type=='individual' && sub_type==1){				
				$("#plan_details").html("<div class='col-xs-12'><p class='text-defult text-xs'>*The amount shown below is calaulated on pro-rated basis</p></div><div class='divider-three'></div><div class='col-xs-6  mt05'><div class='pp-plan-details'><h4 class='text-left'>Current plan details</h4><ul class='list-unstyled'><li><label>No. of Users</label><span><?php echo $userdata['no_of_users']; ?></span></li><li><label>Current Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo INDIVIDUAL_MONTHLY_PRICE;?> / user</span></li><li><label>Subscription</label><span>Monthly</span></li></ul></div></div><div class='col-xs-6 upgrade-plan  mt05'><div class='pp-plan-details'><h4 class='text-left'>Upgrade plan details</h4><ul class='list-unstyled'><li><label>Upgrade Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo INDIVIDUAL_ANNUAL_PRICE;?> / user</span> </li><li><label>Updated Subscription</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo $userdata['no_of_users']*INDIVIDUAL_ANNUAL_PRICE; ?></span>  </li><li><label>Subscription</label><span>Annual</span></li></ul></div></div>");
			}else if(type=='multiple' && sub_type==1){				
				$("#plan_details").html("<div class='col-xs-12'><p class='text-defult text-xs'>*The amount shown below is calaulated on pro-rated basis</p></div><div class='divider-three'></div><div class='col-xs-6  mt05'><div class='pp-plan-details'><h4 class='text-left'>Current plan details</h4><ul class='list-unstyled'><li><label>No. of Users</label><span><?php echo $userdata['no_of_users']; ?></span></li><li><label>Current Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo MULTIPLE_MONTHLY_PRICE;?> / user</span></li><li><label>Subscription</label><span>Monthly</span></li></ul></div></div><div class='col-xs-6 upgrade-plan  mt05'><div class='pp-plan-details'><h4 class='text-left'>Upgrade plan details</h4><ul class='list-unstyled'><li><label>Upgrade Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo MULTIPLE_ANNUAL_PRICE;?> / user</span> </li><li><label>Updated Subscription</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo $userdata['no_of_users']*MULTIPLE_ANNUAL_PRICE; ?></span>  </li><li><label>Subscription</label><span>Annual</span></li></ul></div></div>");
			}
			$(".card-details-panel" ).slideToggle();
			$("#subtype_plan").click(function(){
				if($("#card_number2").val()=="" || $("#card_number2").val().length<15){
					alert("Please enter Credit card number");
					$("#card_number2").attr("style","border:1px solid red !important");
					return false;
				}else{
					$("#card_number2").attr("style","border:1px solid #ddd !important");
				}
				if($("#month2").val()=="" || isNaN($("#month2").val())){
					alert("Please enter card expiry month");
					$("#month2").attr("style","border:1px solid red !important");
					return false;
				}else{
					$("#month2").attr("style","border:1px solid #ddd !important");
				}
				if($("#year2").val()=="" || isNaN($("#year2").val())){
					alert("Please enter card expiry year");
					$("#year2").attr("style","border:1px solid red !important");
					return false;
				}else{
					$("#year2").attr("style","border:1px solid #ddd !important");
				}
				if($("#cvv2").val()=="" || $("#cvv2").val().length>4 || isNaN($("#cvv2").val())){
					alert("Please enter card CVV/CVC");
					$("#cvv2").attr("style","border:1px solid red !important");
					return false;
				}else{
					$("#cvv2").attr("style","border:1px solid #ddd !important");
				}
				if($("#cardholder2").val()==""){
					alert("Please enter card holder name");
					$("#cardholder2").attr("style","border:1px solid red !important");
					return false;
				}else{
					$("#cardholder2").attr("style","border:1px solid #ddd !important");
				}
			});
		}else{
			$(".card-details-panel" ).hide();
		}
	});
	$('input[name=RadioGroup1]').click(function(){
		var chkd_val=$('input[name=RadioGroup1]:checked').val();
		var sub_type='<?php echo $sub_val; ?>';
		var sub_ten='<?php echo $sub_type; ?>';
		if(chkd_val==1){
			$("#monthly_details").html("<div class='col-xs-12'><p class='text-defult text-xs'>*The amount shown below is calaulated on pro-rated basis</p> </div> <div class='divider-three'></div><div class='col-xs-6 mt05'><div class='pp-plan-details'><h4 class='text-left'>Current plan details</h4><ul class='list-unstyled'><li><label>No. of Users</label><span><?php echo $userdata['no_of_users']; ?></span></li><li><label>Current Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo INDIVIDUAL_MONTHLY_PRICE;?> / user</span></li><li><label>Subscription</label><span>Monthly</span></li></ul></div></div><div class='col-xs-6 upgrade-plan mt05'><div class='pp-plan-details'><h4 class='text-left'>Upgrade plan details</h4><ul class='list-unstyled'><li><label>Upgrade Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo MULTIPLE_MONTHLY_PRICE;?> / user</span> </li><li><label>Adjusted Amount</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo $adj_amount;?></span>  </li><li><label>Subscription</label><span>Monthly</span></li></ul></div></div>");
		}else if(chkd_val==2 && sub_ten=='Monthly'){
			$("#monthly_details").html("<div class='col-xs-12'><p class='text-defult text-xs'>*The amount shown below is calaulated on pro-rated basis</p></div><div class='divider-three'></div><div class='col-xs-6 mt05'><div class='pp-plan-details'><h4 class='text-left'>Current plan details</h4><ul class='list-unstyled'><li><label>No. of Users</label><span><?php echo $userdata['no_of_users']; ?></span></li><li><label>Current Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo INDIVIDUAL_MONTHLY_PRICE;?> / user</span></li><li><label>Subscription</label><span>Monthly</span></li></ul></div></div><div class='col-xs-6 upgrade-plan mt05'><div class='pp-plan-details'><h4 class='text-left'>Upgrade plan details</h4><ul class='list-unstyled'><li><label>Upgrade Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo MULTIPLE_ANNUAL_PRICE;?> / user</span>  </li><li><label>Adjusted Amount</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo $adj_amount_annual;?></span>  </li><li><label>Subscription</label><span>Annual</span></li></ul></div></div>");
		}else if(chkd_val==2 && sub_ten=='Annual'){
			$("#monthly_details").html("<div class='col-xs-12'><p class='text-defult text-xs'>*The amount shown below is calaulated on pro-rated basis</p></div><div class='divider-three'></div><div class='col-xs-6 mt05'><div class='pp-plan-details'><h4 class='text-left'>Current plan details</h4><ul class='list-unstyled'><li><label>No. of Users</label><span><?php echo $userdata['no_of_users']; ?></span></li><li><label>Current Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo INDIVIDUAL_ANNUAL_PRICE;?> /user</span></li><li><label>Subscription</label><span>Annual</span></li></ul></div></div><div class='col-xs-6 upgrade-plan mt05'><div class='pp-plan-details'><h4 class='text-left'>Upgrade plan details</h4><ul class='list-unstyled'><li><label>Upgrade Billing</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo MULTIPLE_ANNUAL_PRICE;?> / user</span>  </li><li><label>Adjusted Amount</label><span><i class='fa fa-dollar' aria-hidden='true'></i><?php echo $adj_amount_annual1;?></span>  </li><li><label>Subscription</label><span>Annual</span></li></ul></div></div>");
		}
		if(sub_type!=chkd_val){
			$(".card-details-panel" ).slideToggle();
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
		}else{
			$(".card-details-panel" ).hide();
		}
	});
	$("#change_card").click(function(){
		if($("#card_number1").val()=="" || $("#card_number1").val().length<15){
			alert("Please enter Credit card number");
			$("#card_number1").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#card_number1").attr("style","border:1px solid #ddd !important");
		}
		if($("#month1").val()=="" || isNaN($("#month1").val())){
			alert("Please enter card expiry month");
			$("#month1").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#month1").attr("style","border:1px solid #ddd !important");
		}
		if($("#year1").val()=="" || isNaN($("#year1").val())){
			alert("Please enter card expiry year");
			$("#year1").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#year1").attr("style","border:1px solid #ddd !important");
		}
		if($("#cvv1").val()=="" || $("#cvv1").val().length>4 || isNaN($("#cvv1").val())){
			alert("Please enter card CVV/CVC");
			$("#cvv1").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#cvv1").attr("style","border:1px solid #ddd !important");
		}
		if($("#cardholder1").val()==""){
			alert("Please enter card holder name");
			$("#cardholder1").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#cardholder1").attr("style","border:1px solid #ddd !important");
		}
	});
	$("#no_of_users").keyup(function(){
		var existing_users=$("#existing_users").val();
		var new_users=$("#no_of_users").val();
		var tot_users=parseInt(existing_users)+parseInt(new_users);
		if(new_users==0 || new_users<0){
			alert("Zero users cannot be added");
			$("#add_user_sub").attr("disabled","disabled");
			return false;
		}else{
			$("#add_user_sub").removeAttr("disabled");
		}
		var users=new_users;
		var sub_type=$("#subscription_type").val();
		var days='<?php echo $days; ?>';
		if(sub_type==2){
			var price='<?php echo INDIVIDUAL_MONTHLY_PRICE ?>';
			var per_day_price=price/days;
			per_day_price.toFixed(2);
		}else if(sub_type==3){
			var price='<?php echo INDIVIDUAL_ANNUAL_PRICE ?>';
			var per_day_price=price/365;
			per_day_price.toFixed(2);
		}else if(sub_type==4){
			var price='<?php echo MULTIPLE_MONTHLY_PRICE ?>';
			var per_day_price=price/days;
			per_day_price.toFixed(2);
		}else if(sub_type==5){
			var price='<?php echo MULTIPLE_ANNUAL_PRICE ?>';
			var per_day_price=price/365;
			per_day_price.toFixed(2);
		}
		per_day_price=parseFloat(per_day_price);
		//alert(per_day_price);
		var diff='<?php echo (int)$diff; ?>';
		var totl_price=per_day_price*diff*users;
		total_price=parseFloat(totl_price);
		total_price=total_price.toFixed(2);
		//alert(total_price);
		var tot_price=price*tot_users;
		$("#adj_amount").html("<p>*The amount shown below is calaulated on pro-rated basis</p><label>Adjustable Amount</label><span><i class='fa fa-dollar' aria-hidden='true'></i>"+total_price+"</span><label>Updated Subscription</label><span><i class='fa fa-dollar' aria-hidden='true'></i>"+tot_price+"</span>");		
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

              