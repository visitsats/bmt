<link href="https://fonts.googleapis.com/css?family=Raleway:500,600" rel="stylesheet"> 
<!-- Container -->
<div class="container">
	<div class="row">
		<div class="signupl">
			<div class="col-xs-12">
				<h3 class="text-center">Signup Now</h3>
				<p class="text-center lead hiwcnt">We have developed a cost effective yet highly efficient solution for restaurant owners.<br/> It's for every restaurant big or small, boutique or chain</p>
				<div class="price-plan-panel">
					<div class="col-md-4 col-sm-4 col-xs-12 free-try  ">
						<div class="price-plans-cnt">
							<div class="price-plans-header text-center">
								<h3 class="text-upercase mnone"> FREE TRIAL </h3>
							</div>
							<div class="price-plans-payment">
								<h4 class="text-upercase mnone">Get Started Free for 30 days</h4>
								<ul class="list-unstyled">
									<li>Cancel Anytime </li>
									<li>No Risk</li>
									<li>No Credit card required</li>
								</ul>
							</div>
							<div class="price-plans-features">
								<ul class="list-unstyled">
									<li>Support  <span> Email</span></li>
									<!--<li>Users <span> Unlimited </span></li>-->
									<li>Tablets  <span> Android, iOS</span></li>
									<li>Reports   <span> Individual level</span></li>
									<li>User Administration  <span> Not applicable</span></li>
									<li>Notifications  <span> Unlimited</span></li>
								</ul>
							</div>
							<div class="price-plans-Signup text-center">
								<a href="<?php echo base_url('bookmyt/cart_register').'/free'; ?>" class="btn btn-success ">Signup</a>
							</div>						
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 ">
						<div class="price-plans-cnt indi">
							<div class="price-plans-header text-center text-upercase">
								<h3 class=" mnone"> INDIVIDUAL  </h3><p>Restaurant</p>
							</div>
							<div class="price-plans-payment">
								<h4 class="text-upercase mnone text-center">Payment</h4>
								<div class="col-xs-6 pp-divider">
									<h5>Monthly</h5>
									<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php echo INDIVIDUAL_MONTHLY_PRICE; ?></div>
									<p>month/user</p>
								</div>
								<div class="col-xs-6">
									<h5>Annual</h5>
									<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php echo INDIVIDUAL_ANNUAL_PRICE; ?></div>
									<p><i class="fa fa fa-dollar" aria-hidden="true"></i>15 month/user</p>
								</div>
							</div>
							<div class="price-plans-features">
								<ul class="list-unstyled">
									<li>Support  <span> Email</span></li>
									<!--<li>Users <span> Unlimited </span></li>-->
									<li>Tablets  <span> Android, iOS</span></li>
									<li>Reports   <span> Individual level</span></li>
									<li>User Administration  <span> Not applicable</span></li>
									<li>Notifications  <span> Unlimited</span></li>
								</ul>
							</div>
							<div class="price-plans-Signup text-center">
								<a href="<?php echo base_url('bookmyt/cart_register').'/individual'; ?>" class="btn btn-success ">Signup</a>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 ">
						<div class="price-plans-cnt mult">
							<div class="price-plans-header text-center">
								<h3 class="text-upercase mnone"> MULTIPLE</h3>
								<p>Restaurants</p>
							</div>
							<div class="price-plans-payment">
								<h4 class="text-upercase mnone text-center">Payment</h4>
								<div class="col-xs-6 pp-divider">
									<h5>Monthly</h5>
									<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php echo MULTIPLE_MONTHLY_PRICE; ?></div>
									<p>month/user</p>
								</div>
								<div class="col-xs-6">
									<h5>Annual</h5>
									<div class="price"><i class="fa fa-dollar" aria-hidden="true"></i><?php echo MULTIPLE_ANNUAL_PRICE; ?></div>
									<p><i class="fa fa-dollar" aria-hidden="true"></i>25 month/user</p>
								</div>
							</div>
							<div class="price-plans-features">
								<ul class="list-unstyled">
									<li>Support  <span> Email + Phone</span></li>
									<!--<li>Users <span> Unlimited </span></li>-->
									<li>Tablets  <span> Android, iOS</span></li>
									<li>Reports   <span> Branch level</span></li>
									<li>User Administration  <span> Free Admin user</span></li>
									<li>Notifications  <span> Unlimited</span></li>
								</ul>
							</div>
							<div class="price-plans-Signup text-center">
								<a href="<?php echo base_url('bookmyt/cart_register').'/multiple'; ?>" class="btn btn-success ">Signup</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if ($this->uri->segment(3) !== FALSE){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".login_pwd").trigger('click');
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
</script>

<script>

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