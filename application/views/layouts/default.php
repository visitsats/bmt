<!-- Book My T Header Starts Here -->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="author" content="">
<title>Bookmyt|The Best restaurant management solution|Free table management System</title>

<meta name="description" content="Bookmyt is the best restaurant Management solution. Bookmyt is a cost effective and highly efficient solution for restaurant owners to manage their Walk-Ins, Table reservation, billing, feedback, analytics, and customer rewards points."/>

<meta name="keywords" content="Bookmyt, The Best restaurant management solution, Free table management System ,table reservation software, Cost effective restaurant management solution, Highly efficient solution for restaurant, Restaurant Table Management Software, restaurant reservations software, Table Management System, Free Restaurant management Software." />
<!-- Fonta CSS -->
<link href="<?php echo base_url(); ?>theme/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>theme/css/fonts.css" rel="stylesheet">

<!-- Bootstrap Core CSS -->
<link rel="stylesheet"  href="<?php echo base_url(); ?>theme/css/bootstrap.min.css" />
<link href="<?php echo base_url(); ?>theme/css/bootstrap-theme.css" rel="stylesheet">
<link rel="stylesheet"  href="<?php echo base_url(); ?>theme/css/hover.css" />

<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>theme/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>theme/css/style-rwd.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>theme/css/build.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/bootstrap-select.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/banner.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>theme/datetimepicker/jquery.datetimepicker.css"/>
<!--<link rel="stylesheet" href="<?php //echo base_url(); ?>theme/css/material1.min.css" />
 <link rel="stylesheet" href="<?php echo base_url();?>theme/css/bootstrap-material-datetimepicker.css" />-->
<!-- favicon-->

<link rel="shortcut icon" href="<?php echo base_url(); ?>theme/images/favicon.ico">


<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery-1.10.2.min.js"></script> 
 <script type="text/javascript" src="<?php echo base_url(); ?>theme/js/bootstrap.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/html5.js"></script> 

<script src="<?php echo base_url();?>theme/datetimepicker/build/jquery.datetimepicker.full.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/js/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>theme/js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>theme/js/jsapi.js"></script> 
<script src="<?php echo base_url(); ?>theme/js/jquery.countdown.min.js"></script>		 
<!--<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery-2.1.3.min.js"></script>-->

 
<!--script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery.sparkline.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/charts-sparkline.js"></script--> 
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>theme/plugins/slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>theme/dist/demo.js"></script>
<script src="<?php echo base_url(); ?>theme/js/utils.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery-ui.min.js"></script>
<?php
	if($this->uri->segment(2)=='home'){
?>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/carousel-preload.js"></script>
<?php
	}
?>
<!-- Google Analytics code updaed by satish m on 25-05-2017 -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99898475-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- Google Analytics code updaed by satish m on 25-05-2017 -->


</head>

<body>


<div class="menu-nav-bg hidden-sm hidden-md hidden-lg"></div>

<?php if($this->session->userdata('business_id')) { ?>
<div class="m-nav m-nav-cnt <?php if($this->session->userdata('business_id')) { echo "m-nav-inner"; } ?> hidden-sm hidden-md hidden-lg"> <a href="#" class="m-nav-close btn btn-default pull-right "> <i class="fa fa-chevron-right"></i> </a>


</div>
<?php } ?>
<?php if(!$this->session->userdata('business_id')) { ?>
<div class="">
<div class="m-nav  hidden-sm hidden-md hidden-lg "> <a class="m-nav-close btn btn-default pull-right " href="#"> <i class="fa fa-chevron-right"></i> </a>




 
			 <nav class="pull-left mnav-close ">
			  <ul class="list-unstyled ">
				<li><a href="<?php echo base_url(); ?>" class="current">Book My T </a></li>
				<li><a href="<?php echo base_url('bookmyt/howitworks'); ?>">How it Works</a></li>
				<li><a href="<?php echo base_url('bookmyt/connectwithus'); ?>">Connect with us</a></li>
				<li><a href="<?php echo base_url('bookmyt/demo'); ?>">Demo</a></li>	
			  </ul>		  
			</nav>
		
		             <div class="pull-right text-right btns">


					 <a data-toggle="modal" data-target="#login-modal" id="modal-launcher" class="btn btn-default" href="#">Login</a> <a class="btn btn-success signup" href="<?php echo base_url('bookmyt/signup'); ?>">Pricing</a> </div>
			
						
			</div>


 </div>
 <?php } ?>
 



<?php
	$cur_method = $this->router->fetch_method(); 
	$open_mtds = array('create_pwd','create_user_pwd','create_branch_pwd','forgot_password');
?>
<section class="topPanel  <?php if($this->session->userdata('business_id') || in_array($cur_method,$open_mtds)) { echo " top-panel-inner2"; } ?>">
  <div class="container">
    <div class="row">
      <div class="col-sm-2 col-md-2" id="logo"><a href="<?php if($this->session->userdata('business_id')) { echo base_url().'bookmyt/reservation_list';} else 
	  {echo base_url();} ?>"><img src="<?php echo base_url(); ?>theme/images/logo.png" alt="Bookmyt"></a>
	  <a href="https://play.google.com/store/apps/details?id=usa.bookmyt.com.activity&hl=en" class="app-icon hidden-md hidden-sm hidden-lg" target="_blank">
<img src="<?php echo base_url(); ?>theme/images/android-app.png" >
</a>

<a href="https://itunes.apple.com/us/app/bookmyt-us/id1198533522?ls=1&mt=8" target="_blank" class="app-icon hidden-md hidden-sm hidden-lg">
<img src="<?php echo base_url(); ?>theme/images/ios-app.png" >
</a>


 <a href="#" class="btn btn-default pull-right m-nav-control hidden-sm hidden-md hidden-lg" > <i class="fa fa-bars"></i></a></div>
	<?php
	//pr($this->session->all_userdata());
	 //print_r($this->session->userdata)
	  //if($this->session->userdata('business_id') && $this->session->userdata('sup'))
	  if($this->session->userdata('business_id') )
		{
		
			$home_methods = array('create_pwd','Update_business','edit_business','add_customer');
			$floor_methods = array('add_floor','floors','edit_floor','delete_floor');
			$branch_methods = array('add_branch','branches','edit_branch','delete_branch','create_branch_pwd');
			//$table_methods = array('add_table','edit_table','tables','delete_table','book_table','table_confirm');
			$users_methods = array('add_user','users','edit_user','update_user','delete_user','create_user_pwd');
			$reservation_methods = array('add_reservation','buzz_reservation','reservation','edit_reservation','reservation_list','delete_reservation','can_reservation');
			$quick_book = array('quick_book');
			$reports = array('reports');
			$occupancy = array('occupancy');
			$current_method = $this->router->fetch_method();
	?>
	
      <div class="col-sm-10 col-md-10 hidden-xs main-nav main-nav-inner">
        <nav class="pull-left">
		  <ul class="list-unstyled">
		  	<li <?php if(in_array($current_method,$occupancy)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/occupancy"><img src="<?php echo base_url(); ?>theme/images/reservations.png" alt=""> <div class="clearfix"></div>
			  Occupancy</a></li>
		  <?php
		  	//pr($this->session->all_userdata());
			if($this->session->userdata('branch') != 1)
			{
				
				if($this->session->userdata('have_branches') == '0' || $this->session->userdata('have_branches') == '')
				{
				}
				
				else
				{	
					if($this->session->userdata('user_id')!="")
					{
					}
					else if($this->session->userdata('subscription_type')==4 || $this->session->userdata('subscription_type')==5 || $this->session->userdata('subscription_type')==1)
					{ 
			?>
				<li <?php if(in_array($current_method,$branch_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/branches"><img src="<?php echo base_url(); ?>theme/images/branches.png" alt=""><div class="clearfix"></div>Branches </a></li>
			<?php
					}
				}
			}
			?>
			<?php if(empty($this->permissions) || $this->permissions->floor->view == 1){?>
			<li <?php if(in_array($current_method,$floor_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/floors"> <img src="<?php echo base_url(); ?>theme/images/floors.png" alt=""><div class="clearfix"></div>
			  Floors </a></li>
			  <?php } ?>
				<?php
				if(!empty($this->permissions))
				{
				if($this->permissions->users->view == 1)
				{
				?>
				<li <?php if(in_array($current_method,$users_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/users"> <img src="<?php echo base_url(); ?>theme/images/users.png" alt=""><div class="clearfix"></div>
				Users </a></li>
				<?php				
				}
				}else
				{
				?>

				<li <?php if(in_array($current_method,$users_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/users"> <img src="<?php echo base_url(); ?>theme/images/users.png" alt=""><div class="clearfix"></div>
				Users </a></li>
				<?php
				}
				?>
			
			<li <?php if(in_array($current_method,$reservation_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/reservation_list"><img src="<?php echo base_url(); ?>theme/images/reservations.png" alt=""> <div class="clearfix"></div>
			  Reservations</a></li>
			   <li <?php if(in_array($current_method,$quick_book)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/quick_book"><img src="<?php echo base_url(); ?>theme/images/walkin.png" alt=""> <div class="clearfix"></div>
			  Walkin</a></li>
			  <?php
				if(!empty($this->permissions))
				{
				if($this->permissions->dashboard->view == 1)
				{
				?>
			   <li <?php if(in_array($current_method,$reports)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/reports"> <img src="<?php echo base_url(); ?>theme/images/dashbord-icon.png" alt="">
			   <div class="clearfix"></div>
			  Reports</a></li>
			  	<?php				
				}
				}else
				{
				?>
				 <li <?php if(in_array($current_method,$reports)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/reports"> <img src="<?php echo base_url(); ?>theme/images/dashbord-icon.png" alt="">
				   <div class="clearfix"></div>
				  Reports</a></li>
				<?php
				}
				?>
		 
          </ul>		  
        </nav>
		<?php
			}
			else
			{
		?>
			<div class="col-sm-10 col-md-10 hidden-xs main-nav">
			 <nav class="pull-left ">
			  <ul class="list-unstyled ">
				<li ><a href="<?php echo base_url(); ?>">Book My T </a></li>
				<li ><a href="<?php echo base_url('bookmyt/howitworks'); ?>">How it Works</a></li>
				<li ><a href="<?php echo base_url('bookmyt/connectwithus'); ?>">Connect with us</a></li>
				<li ><a href="<?php echo base_url('bookmyt/demo'); ?>">Demo</a></li>
			  </ul>		  
			</nav>
		
		<?php
			}			
				// echo "<pre>";
					// print_r($this->session->userdata());
				// echo "</pre>";
			if($this->session->userdata('business_id'))
			{
			?>
			 <div class="dropdown pull-right"> <a data-target="#" href="page.html" data-toggle="dropdown" class=" btn btn-default btn-block dropdown-toggle pull-right user-control-dd">&nbsp;&nbsp;<!--<img src="<?php //echo base_url(); ?>theme/images/user-pick.png" alt="">--><?php echo $this->session->userdata('business_name');?><i class="fa fa-chevron-circle-down"></i> </a>
			  <ul class="dropdown-menu">
				<?php
					$prf_id = $this->session->userdata('business_id');
					$user_id = $this->session->userdata('user_id');
					
					if(!$this->session->userdata('user_id') && $this->session->userdata('branch') == 0 && $this->session->userdata('subscription_type')!=1)
					{
				?>
					<li><a href="<?php echo base_url()."bookmyt/myBusiness/";?>">My Profile</a></li>	
				<?php	
					}else if(!$this->session->userdata('user_id') && $this->session->userdata('branch') == 0){
				?>
					<li><a href="<?php echo base_url()."bookmyt/my_business/".$prf_id;?>">My Profile</a></li>
				<?php
					}
					else if($this->session->userdata('user_id'))
					{
				?>
					<li><a href="<?php echo base_url()."bookmyt/my_user/".$user_id;?>">My Profile</a></li>
				<?php
					}
					else
					{
				?>
					<li><a href="<?php echo base_url()."bookmyt/my_branch/".$prf_id;?>">My Profile</a></li>
				<?php
					}
					
					if($this->session->userdata('user_id'))
					{
				?>
					<li><a href="<?php echo base_url()."bookmyt/change_user_pd/".$user_id;?>">Change Password</a></li>
				<?php
					}
					else
					{
				?>
				<li><a href="<?php echo base_url()."bookmyt/change_password/".$prf_id;?>">Change Password</a></li>
				<?php
					}
				?>
				<li><a href="<?php echo base_url();?>bookmyt/log_out">Logout</a></li>
			  </ul>
			</div>
			<?php
				}
				else
				{
			?>
             <div class="pull-right text-right btns"> 
			 <a href="https://play.google.com/store/apps/details?id=usa.bookmyt.com.activity&hl=en" class="app-icon" target="_blank">
			<img src="<?php echo base_url(); ?>theme/images/android-app.png" >
			</a>

			<a href="https://itunes.apple.com/us/app/bookmyt-us/id1198533522?ls=1&mt=8" target="_blank" class="app-icon">
			<img src="<?php echo base_url(); ?>theme/images/ios-app.png" >
			</a>

			 <a href="#" class="btn btn-default login_pwd" id="modal-launcher"  data-target="#login-modal" data-toggle="modal">Login</a> <a href="<?php echo base_url('bookmyt/signup'); ?>" class="btn btn-success signup" >Pricing</a> </div>
			
			<?php
				}
			?>
			
			</div>
    </div>
  </div>
  
</section>
<section class="page-container">
		<?php
			if($this->session->flashdata('succ'))
			{
		?>
			<div class="wrap" <?php if(!$this->session->userdata('business_id')) { /*echo "style='margin-top:85px'"; */} else {echo "style='margin-top:0px'"; } ?>>
				<div class="alert alert-success mnone text-center">
				<a class="close" aria-label="close" data-dismiss="alert" href="#"><i class="fa fa-times"></i></a>
				<strong>Success!</strong><?php echo $this->session->flashdata('succ'); ?>	</div>
			</div>
		<?php
			}	
			if($this->session->flashdata('perm'))
			{
		?>
			<div class="wrap" <?php if(!$this->session->userdata('business_id')) { /*cho "style='margin-top:85px'";*/ } else {echo "style='margin-top:0px'"; } ?>>
				<div class="alert alert-danger mnone text-center">
				<a class="close" aria-label="close" data-dismiss="alert" href="#"><i class="fa fa-times"></i></a>
				<strong>Fail!</strong><?php echo $this->session->flashdata('perm'); ?>	</div>
			</div>
		<?php
			}	
	?>
	
	<?php
		//pr($this->session->all_userdata());
		if($this->session->userdata('business_id'))
		{
	?>
		<div class="welcome-panel" >
		<div class="container">
		<div class="row">
		<div class="col-xs-12">
		
		<div class="col-xs-12 col-sm-8   col-md-6   col-md-6 pnone" style="min-width:250px;">
			
			<h4 style="text-transform:none;font-family: 'open_sansregular';" class="">
				Welcome <b><?php  echo (strlen($this->session->userdata('business_name')) > 20) ? substr($this->session->userdata('business_name'), 0, 20).'...' : $this->session->userdata('business_name'); ?> </b>
				<?php  //$CI =& get_instance();
				$last_login = $this->session->userdata('last_login');
				if($last_login != "")  { ?>
						Your last login was <b><?php $date=date_create($this->session->userdata('last_login')); echo date_format($date,"d-M-Y h:i:s A");   ?></b>
				<?php 
				//$session_data = array('last_login' =>"");
				//$CI->session->set_userdata($session_data);
				//$CI->session->unset_userdata('last_login');
				} unset($_SESSION['last_login']);
				?>
			</h4>
		</div>
		<div class="col-xs-12 col-sm-4   col-md-6  pnone">

		<div class="clock"><div id="Date"></div>
		<ul>
		<li id="hours"></li>:

		<li id="min"></li>:

		<li id="sec"></li>
		<li id="secam"></li>
		</ul>




		</div>

		</div>

		</div>
		</div>
		</div>
		</div>	
	<?php
		}
	?>
<?php $login_sup = $this->session->userdata('login_sup');
//pr($this->session->all_userdata());
if($this->session->userdata('business_id')  && $login_sup=='sup') { ?>
	<div class="container">
	<div class="row">
	<div class="pull-right mt10"><a href="<?php echo base_url('bookmyt/superadmin')?>" class="btn btn-success btn-xss">view super admin dashboard</a></div>
	<div class="clearfix"></div>
	</div>
	</div>
	<?php } ?>
<!-- Book My T Header Ends Here -->

<!-- Book My T Content Starts Here -->

	{content}

<!-- Book My T Content Ends Here -->

<!-- Book My T Footer Starts Here -->

<div class="wrap inner-footer">
    <div class="container">
      <div class="row">
        <div class="footer">
        
          <div class="col-sm-6">
          <nav><a href="<?php echo base_url('bookmyt/terms')?>" target="_blank"> Terms & Conditions</a> <a href="<?php echo base_url('bookmyt/privacy')?>" target="_blank">Privacy Policy </a> <a href="<?php echo base_url('bookmyt/connectwithus'); ?>"> Connect Us</a><a href="<?php echo base_url('bookmyt/contact_us'); ?>" target="_blank"> Contact Us</a></nav>
          <p class="small  copyrights">&copy; <?php echo date("Y"); ?> Bookmyt all rights reserved</p>
          </div>
        
        <div class="col-sm-6">
        <div class="social-links pull-right">
        
       <a href="https://www.facebook.com/BookmyT-607569296119448/" target="_blank"> <span class="fa fa-facebook"></span></a>
        
        <a href="https://twitter.com/bookmytapp" target="_blank"> <span class="fa fa-twitter"></span></a>
        
        <a href="https://plus.google.com/u/0/105493531598431973223" target="_blank"> <span class="fa fa-google-plus"></span></a>
        
        <a href="https://www.linkedin.com/company/13336638/admin/updates/" target="_blank"> <span class="fa fa-linkedin"></span></a>
     
        </div>
        </div>
        
      
          
          
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header login_modal_header">
        <button type="button" class="close" id="close-login" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
        <h3 class="modal-title" id="myModalLabel">Login to Your Account</h3>
      </div>
      <div class="modal-body login-modal">
       <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text eve</p> -->
        <br/>
        <div class="clearfix"></div>
        <div id='social-icons-conatainer'>
          <div class='modal-body-left'>
		  <form name="login" method="post" action="">
		  <center><span id="log-err" style="color:red;font-weight:bold"></span></center>
            <div class="form-group">
			<label class="form-lable ">User name<span class="star">*</span></label>
              <input type="text" id="username" name="business_email" placeholder="" value="" class="form-control login-field" >
              <i class="fa fa-user login-field-icon"></i>
			 <span style="color:red" id="un-err"></span>
			  </div>
            <div class="form-group">
			<label class="form-lable ">Password<span class="star">*</span></label>
              <input type="password" name="password" id="login-pass" placeholder="" value="" class="form-control login-field" >
              <i class="fa fa-lock login-field-icon"></i>
			  <span style="color:red" id="pwd-err"></span>
			  </div>
            <button class="btn btn-success modal-login-btn" id="login-bttn" name="login"/>Login</button> <a href="<?php echo base_url().'bookmyt/forgot_password/'; ?>" class="login-link text-center">Lost your password?</a> 
			</form>
			</div>
          <div id='center-line'> OR </div>
          <div class="modal-body-right">
            <a class="btn btn-default close-login-con" href="<?php echo base_url('bookmyt/signup'); ?>"> New User Please Register</a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer login_modal_footer"> </div>
    </div>
  </div>
</div>
<div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header login_modal_header">
        <button type="button" class="close close-login" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
        <h3 class="modal-title" id="myModalLabel"> Signup </h3>
      </div>
      <div class="modal-body login-modal signup-form">
        <div class="modal-body-left">		
		<form name="register" method="post" action="<?php echo base_url().'bookmyt/add_customer/'; ?>">
        <div class="col-sm-6 col-xs-6 hidden-md hidden-lg"><a href="#" class="btn btn-tab activebt" data-sign-tab="small-ent">Small enterprise <br/><small>Start ups</small></a></div>
         <div class="col-sm-6 col-xs-6 hidden-md hidden-lg"><a href="#" class="btn btn-tab " data-sign-tab="large-ent">Large enterprise <br/><small>Established restaurants</small></a></div>
        
          <div class="form-panel ent " id="small-ent">
            <div class="form-panel-header text-center hidden-sm hidden-xs "><strong>Small enterprise</strong><br/>
              <small>Start ups</small></div>
            <div class="form-panel-body">
              <div class="form-group">
                <input  name="business_name" id="s_business_name" maxlength="50" required placeholder="Restaurant Name"  value="" class="form-control login-field"  type="text" > 
              </div>
              <div class="form-group">
                <input name="business_email_phn" id="s_business_email_phn"  maxlength="50" placeholder="Email ID/Phone number" value="" class="form-control login-field" required  type="text" >
              </div>
              <div class="form-group prela">
                <input  name="location" id="s_location" placeholder="Zip Code" value="" class="form-control login-field" type="text">
              
			  </div>
              <div class="form-group">
                <input  name="your_name" id="s_your_name" placeholder="Your Name" value="" class="form-control login-field" type="text">
              </div>
              <div class="form-group">  <div class="checkbox checkbox-success">
                        <input id="s_ru_owner" class="styled" type="checkbox" name="ru_owner">
                        <label for="s_ru_owner">
                            Are you the owner
                        </label>
                    </div>  </div>
              <div class="form-group">
                <input  name="owner_name" id="s_owner_name" placeholder="Owner's Name" value="" class="form-control login-field" type="text">
              </div>			  
              <div class="form-group"> <div class="checkbox checkbox-success">
                        <input name="want_demo" id="s_want_demo" class="styled" type="checkbox" value="1">
                        <label for="s_want_demo">
                            Need a help to set up?
                        </label>
                    </div>   </div>
			<div class="form-group"> <div class="checkbox checkbox-success">
                        <input name="i_agree" id="i_agree" class="styled" type="checkbox" value="1">
                        <label for="i_agree">
                            By Checking this box, I Agree <a href="<?php echo base_url("bookmyt/terms"); ?>" target="_blank">Terms of Use</a> and <a href="<?php echo base_url("bookmyt/privacy"); ?>" target="_blank">Privacy Policy</a>
                        </label>
                    </div>   </div>
                    <div class="form-group">
					<input type="hidden" name="business_type" value="S">             
					<input type="submit" value="Signup" name="sub" id="sbutt" class="btn btn-success modal-login-btn">
					</div> 
                    
            </div>
          </div>
		  </form>
        </div>
        <div class="modal-body-right">
          <div class="form-panel ent " id="large-ent" style="display:none;">
            <div class="form-panel-header text-center hidden-sm hidden-xs"><strong>Large enterprise</strong><br/>
              <small>Established restaurants</small></div>
			  <form name="register" method="post" action="<?php echo base_url().'bookmyt/add_customer/'; ?>">
            <div class="form-panel-body">
              <div class="form-group">
                <input  name="business_name" id="l_business_name" maxlength="50" required  placeholder="Restaurant Name"  value="" class="form-control login-field"  type="text">
              </div>
              <div class="form-group">
                <input  name="business_email_phn" id="l_business_email_phn"  maxlength="50" required  placeholder="Email ID/Phone number" value="" class="form-control login-field"  type="text">
              </div>
              <div class="form-group">
                <input  name="location" id="l_location"  placeholder="Zip code" value="" class="form-control login-field" type="text">
              </div>
              <div class="form-group">
                <input  name="year_establish" id="l_year_establish" placeholder="Year of Establishment" value="" class="form-control login-field" type="text">
              </div>
              <div class="form-group">
                <input  name="your_name" id="l_your_name" placeholder="Your Name" value="" class="form-control login-field" type="text">
              </div>
              <div class="form-group">
                <input  name="no_of_emps" name="l_no_of_emps" placeholder="Number of employees" value="" class="form-control login-field" type="text">
              </div>
			  <div class="form-group"> <div class="checkbox checkbox-success">
                        <input id="l_want_demo" name="want_demo" class="styled" type="checkbox"  value="1">
                        <label for="l_want_demo">
                           Need a help to set up?
                        </label>
                    </div> </div>
                    <div class="form-group"> <div class="checkbox checkbox-success">
                        <input name="i_agree" id="l_i_agree" class="styled" type="checkbox" value="1">
                        <label for="l_i_agree">
                            By Checking this box, I Agree <a href="<?php echo base_url("bookmyt/terms"); ?>" target="_blank">Terms of Use</a> and <a href="<?php echo base_url("bookmyt/privacy"); ?>" target="_blank">Privacy Policy</a>
                        </label>
                    </div>   </div>
                      <div class="form-group"> 
					  <input type="hidden" name="business_type" value="L">
						<input type="submit" value="Signup" name="sub" id="lbutt" class="btn btn-success modal-login-btn" >
					  </div>
            </div>
			</form>
          </div>
        </div>
      </div>
      <div class="modal-footer login_modal_footer"> </div>
    </div>
  </div>

</div>
<div class="modal fade" id="signup-modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header login_modal_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
        <h3 class="modal-title" id="myModalLabel">Signup</h3>
      </div>
      <div class="modal-body login-modal">
        <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text eve</p>-->
        <br/>
        <div class="clearfix"></div>
		
		<form name="register" method="post" action="<?php echo base_url().'bookmyt/add_customer/'; ?>">
        <div class='modal-body-left'>
		<center><span id="errr1" style="color:red;font-weight:bold"></span></center>
          <div class="form-group">
		  <label class="form-lable ">Business Name<span class="star">*</span></label>
            <input type="text" id="business_name" name="business_name" placeholder="" maxlength="25" value="" class="form-control login-field" required>
          </div>
          <div class="form-group">
		  <label class="form-lable ">Select Business Type<span class="star">*</span></label>
			<select   class="selectpicker" required  name="business_types" id="b_tpe">
				<option value="" style="display:none;">Select Business Type</option>
					<?php
					if(isset($business_types) && !empty($business_types))
					{
						foreach($business_types as $type)
						{
					?>
						<option value="<?php echo $type['business_typeid']; ?>"<?php echo set_select('business_types',$type['business_typeid']); ?> ><?php echo $type['business_typename']; ?></option>
					<?php
						}
					}
					?>
			</select>
			<!--<input type="text" id="" placeholder="Restaurant Name" value="" class="form-control login-field" required>-->
          </div>
          <div class="form-group">
			<label class="form-lable ">Email / Phone Number<span class="star">*</span></label>
            <input type="text" name="business_email_phn" id="b_id" maxlength="50" placeholder="" value="" class="form-control login-field" required>
			<span id="em_err" style="color:red"></span>
          </div>
          <div class="form-group">
            <input type="submit" value="Submit" name="sub" id="butt" class="btn btn-success modal-login-btn" onClick="return val_reg()">
          </div>
          <div class='modal-body-left'> </div>
        </div>
		</form>
        <div class='modal-body-right'>
          <h4> Why book my t</h4>
          <ul class="list-unstyled list">
            <li> Peak rush hour timings</li>
            <li>Most frequent order items</li>
            <li>Table occupancy daily/week/monthly</li>
            <li>Repeat customers details </li>
          </ul>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer login_modal_footer"> </div>
    </div>
  </div>
</div>

<div class="modal fade" id="demo-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header login_modal_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
        <h3 class="modal-title" id="myModalLabel">CLICK HERE TO DEMO</h3>
      </div>
      <div class="modal-body login-modal">
        <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text eve</p>-->
        <br/>
        <div class="clearfix"></div>
		<span style="color:green;margin-left:100px;" id="sucess_demo" ></span>
		<form name="register" method="post" >
        <div class='modal-body-left'  style="width:100%; padding:0 40px; border:none">
		<center><span id="errr1" style="color:red;font-weight:bold"></span></center>
		<center><div id="loading" style="display:none;"></div></center>
          <div class="form-group">
		  <label class="form-lable ">Name<span class="star">*</span></label>
            <input type="text" id="demo_name" name="business_name" placeholder="" maxlength="25" value="" class="form-control login-field" required>
          </div>
         <div class="form-group">
		  <label class="form-lable ">Email<span class="star">*</span></label>
            <input type="text" id="demo_email" name="business_name" placeholder="" maxlength="25" value="" class="form-control login-field" required>
          </div>
          <div class="form-group">
			<label class="form-lable ">Phone Number<span class="star">*</span></label>
            <input type="text" name="demo_phone" id="demo_phone"  maxlength="50" placeholder="" value="" class="form-control login-field" required>
			<span id="em_err" style="color:red"></span>
          </div>
          <div class="form-group">
            <input type="button" value="Submit" name="sub" id="butt" class="btn btn-success modal-login-btn" onClick="request_demo()">
          </div>
          
        </div>
		</form>
      
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer login_modal_footer"> </div>

    </div>
  </div>
</div>
<script src="<?php echo base_url();?>theme/js/jquery.scrolltabs.js"></script>
<script src="<?php echo base_url();?>theme/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
function val_reg_new()
	{
		var msg= [];
		var bname = $('#business_name').val();
		var btype = $('#b_tpe').val();
		var bemail = $('#b_id').val();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(bname == "")
		{
			msg.push('e1');
		}
		if(btype == "")
		{
			msg.push('e2');
		}
		if(bemail == "")
		{
			msg.push('e3');
		}
		else
		{
			if (!filter.test(bemail)) 
			{
				msg.push('e3');
			}
			else
			{
				var bem = $('#b_id').val();
				$.post("<?php echo base_url().'bookmyt/b_dup/'; ?>",{'business_email' : bem },function(data)
				{
					if($.trim(data) == '1')
					{
						$("#errr1").html("This email is already registered");
						$("#b_id").addClass('error');
						return false;
					}
					else
					{
						$("#errr1").html("");
						$("#b_id").removeClass('error');
					}
				});
		
			}
		}
		
		
		if(msg.length != 0)
		{
			if($.inArray("e1", msg) !== -1){ $("#business_name").addClass('error'); } else { $("#business_name").removeClass('error'); }
			if($.inArray("e2", msg) !== -1){ $("[data-id='b_tpe']").addClass('error'); } else { $("[data-id='b_tpe']").removeClass('error'); }
			if($.inArray("e3", msg) !== -1){ $("#b_id").addClass('error'); } else { $("#b_id").removeClass('error'); }
			return false;
		}
		else
		{
			$("#business_name").removeClass('error');
			$("[data-id='b_tpe']").removeClass('error');
			$("#b_id").removeClass('error');
			msg = [];
		}
	}
/*function connect_with_us()
{

  var name = $('#connect_name').val();
  var res_name = $('#connect_res_name').val();
   var mobile = $('#connect_mobile').val();
   var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(name=='')
  {
  $("#connect_name").addClass('error');
  return false;
  } 
  else
  { 
  $("#connect_name").removeClass('error');
  }
   if(res_name=='')
  {
  $("#connect_res_name").addClass('error');
  return false;
  } 
  else
  { 
  $("#connect_res_name").removeClass('error');
  }
   if(mobile=='')
  {
  $("#connect_mobile").addClass('error');
  return false;
  } 
  else
  { 
 	 if(isNaN(mobile) && !filter.test(mobile)){
		  $("#connect_mobile").addClass('error');
		  return false;
	 }else if(!isNaN(mobile) && mobile.length!=10){
		$("#connect_mobile").addClass('error');
		return false;
	 }else{
	 	$("#connect_mobile").removeClass('error');
	 }
  }
	$.post("<?php echo base_url().'bookmyt/connect_with_us/'; ?>",{'mobile' : mobile,'name':name,'res_name':res_name },function(data)
	{
	if($.trim(data) == '1')
	{
	alert("Our Representative will contact you soon");
	location.reload();
	$('#connect_name').val('');
	$('#connect_res_name').val('');
	$('#connect_mobile').val('');
	return false;
	}

	});
}	*/
function request_demo()
{
	
  var name = $('#demo_name').val();
  var email = $('#demo_email').val();
   var mobile = $('#demo_phone').val();
   var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(name=='')
  {
  $("#demo_name").addClass('error');
  return false;
  } 
  else
  { 
  $("#demo_name").removeClass('error');
  }
   if(email=='' || !filter.test(email) )
  {
  $("#demo_email").addClass('error');
  return false;
  } 
  else
  { 
  $("#demo_email").removeClass('error');
  }
   if(mobile=='' || isNaN(mobile) || mobile.length!=10)
  {
  $("#demo_phone").addClass('error');
  return false;
  } 
  else
  { 
  $("#demo_phone").removeClass('error');
  }
  	$("#loading").show();
	$("#loading").html("<div class='spinner' style='color:#fff;'><i class='fa fa-spinner fa-spin fa-3x' style='color:#000;'></i><br /> <b>Searching for Lab Locations</b></div>");
	$.post("<?php echo base_url().'bookmyt/request_demo/'; ?>",{'mobile' : mobile,'name':name,'email':email },function(data)
	{
	if($.trim(data) == '1')
	{
	alert("Our Representative will contact you soon");
	location.reload();
	$('#demo_name').val('');
	$('#demo_email').val('');
	$('#demo_phone').val('');
	return false;
	}

	});
}		
function val_reg()
	{
		var msg= [];
		var bname = $('#business_name').val();
		var btype = $('#b_tpe').val();
		var bemail = $('#b_id').val();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(bname == "")
		{
			msg.push('e1');
		}
		if(btype == "")
		{
			msg.push('e2');
		}
		if(bemail == "")
		{
			msg.push('e3');
		}
		else
		{
			if (!filter.test(bemail)) 
			{
				msg.push('e3');
			}
			else
			{
				var bem = $('#b_id').val();
				$.post("<?php echo base_url().'bookmyt/b_dup/'; ?>",{'business_email' : bem },function(data)
				{
					if($.trim(data) == '1')
					{
						$("#errr1").html("This email is already registered");
						$("#b_id").addClass('error');
						return false;
					}
					else
					{
						$("#errr1").html("");
						$("#b_id").removeClass('error');
					}
				});
		
			}
		}
		
		
		if(msg.length != 0)
		{
			if($.inArray("e1", msg) !== -1){ $("#business_name").addClass('error'); } else { $("#business_name").removeClass('error'); }
			if($.inArray("e2", msg) !== -1){ $("[data-id='b_tpe']").addClass('error'); } else { $("[data-id='b_tpe']").removeClass('error'); }
			if($.inArray("e3", msg) !== -1){ $("#b_id").addClass('error'); } else { $("#b_id").removeClass('error'); }
			return false;
		}
		else
		{
			$("#business_name").removeClass('error');
			$("[data-id='b_tpe']").removeClass('error');
			$("#b_id").removeClass('error');
			msg = [];
		}
	}
	
	$('#business_name,#b_tpe,#b_id').change(function()
	{
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if($("#business_name").val() != "")
		{
			$("#business_name").removeClass('error');
		}
		if($('#b_tpe').val() != "")
		{
			$("[data-id='b_tpe']").removeClass('error');
		}
		if($('#b_id').val() != "")
		{
			$("#b_id").removeClass('error');
		}
		
	});
	
	
	$(".close").click(function()
	{
			$("#business_name").removeClass('error');
			$("[data-id='b_tpe']").removeClass('error');
			$("#b_id").removeClass('error');
			$("#username").removeClass('error');
			$("#login-pass").removeClass('error');
			
	});
	
$(document).ready(function(e)
{
	$("#username").focus();
/*$("#sbutt").click(function(){
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if($("#s_business_name").val()==""){
			alert("Please enter Restaurant Name");
			$("#s_business_name").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#s_business_name").attr("style","border:1px solid #ddd !important");
		}
		if($("#s_business_email_phn").val()==""){
			alert("Please enter Email Id/Phone Number");
			$("#s_business_email_phn").attr("style","border:1px solid red !important");
			return false;
		}else if(isNaN($("#s_business_email_phn").val()) && !regex.test($("#s_business_email_phn").val())){
			alert("Please enter valid Email Id");
			$("#s_business_email_phn").attr("style","border:1px solid red !important");
			return false;
		}else if(!isNaN($("#s_business_email_phn").val()) && $("#s_business_email_phn").val().length!=10){
			alert("Please enter valid Phone Number");
			$("#s_business_email_phn").attr("style","border:1px solid red !important");
			return false;				
		}else{			
			$("#s_business_email_phn").attr("style","border:1px solid #56af64 !important");
		}
		if($("#s_location").val()==""){
			alert("Please enter zip code");
			$("#s_location").attr("style","border:1px solid red !important");
			return false;
		}else if(isNaN($("#s_location").val()) || $("#s_location").val().length!=5 ){
			alert("Please enter valid 5 letter zip code");
			$("#s_location").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#s_location").attr("style","border:1px solid #ddd !important");
		}
		if($("#s_your_name").val()==""){
			alert("Please enter your Name");
			$("#s_your_name").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#s_your_name").attr("style","border:1px solid #ddd !important");
		}
		if($("#stime_zone").val()==""){
			alert("Please select your Timezone");
			$("#stime_zone").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#stime_zone").attr("style","border:1px solid #ddd !important");
		}

		if($("#i_agree").prop('checked') == false){
			alert("Please check I-Agree box");
			$("#i_agree").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#i_agree").attr("style","border:1px solid #ddd !important");
		}
	});	*/
	$("#lbutt").click(function(){
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if($("#l_business_name").val()==""){
			alert("Please enter Restaurant Name");
			$("#l_business_name").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#l_business_name").attr("style","border:1px solid #ddd !important");
		}		
		if($("#l_business_email_phn").val()==""){
			alert("Please enter Email id / Phone Number");
			$("#l_business_email_phn").attr("style","border:1px solid red !important");
			return false;
		}else if(isNaN($("#l_business_email_phn").val()) && !regex.test($("#l_business_email_phn").val())){
			alert("Please enter valid Email Id");
			$("#l_business_email_phn").attr("style","border:1px solid red !important");
			return false;
		}else if(!isNaN($("#l_business_email_phn").val()) && $("#l_business_email_phn").val().length!=10){
			alert("Please enter valid Phone Number");
			$("#l_business_email_phn").attr("style","border:1px solid red !important");
			return false;				
		}else{			
			$("#l_business_email_phn").attr("style","border:1px solid #ddd !important");
		}
		if($("#l_location").val()==""){
			alert("Please enter Head office location");
			$("#l_location").attr("style","border:1px solid red !important");
			return false;
		}else if(isNaN($("#l_location").val()) || $("#l_location").val().length!=5 ){
			alert("Please enter valid 5 letter zip code");
			$("#l_location").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#l_location").attr("style","border:1px solid #ddd !important");
		}
		if($("#l_year_establish").val()==""){
			alert("Please enter Year of establishment");
			$("#l_year_establish").attr("style","border:1px solid red !important");
		}else{
			$("#l_year_establish").attr("style","border:1px solid #ddd !important");
		}
		if($("#ltime_zone").val()==""){
			alert("Please select your Timezone");
			$("#ltime_zone").attr("style","border:1px solid red !important");
		}else{
			$("#ltime_zone").attr("style","border:1px solid #ddd !important");
		}
		if($("#l_i_agree").prop('checked') == false){
			alert("Please check I-Agree box");
			$("#l_i_agree").attr("style","border:1px solid red !important");
			return false;
		}else{
			$("#l_i_agree").attr("style","border:1px solid #ddd !important");
		}
	});
	
	//$('.selectpicker').selectpicker();
	
	$('.close-login-con').click(function(){
	
	$("#close-login").click();
	
	})
	

    var navhtml =$('.main-nav').html();
	$('.m-nav-cnt').append(navhtml);
	
	$('.m-nav-control').click(function(){
	 $('.m-nav').addClass('active');
	  $('.menu-nav-bg').show();
	   $('body').addClass('modal-open2');
	 return false;	
	});
	
	$('.m-nav-close').click(function(){
	 $('.m-nav').removeClass('active');
	  $('.menu-nav-bg').hide();
	   $('body').removeClass('modal-open2');
	 return false;	
	});
	
	$('.mnav-close a').click(function(){
	 $('.m-nav').removeClass('active');
	  $('.menu-nav-bg').hide();
	   $('body').removeClass('modal-open2');
	
	});
	
	$('.menu-nav-bg').click(function(){
	
	 $('.m-nav').removeClass('active');
	  $('.menu-nav-bg').hide();
	   $('body').removeClass('modal-open2');
	
	});
	
	
	
	
	
	
	$('.icon-list li a').click(function(){
	 var icontarget = $(this).attr('data-tabe');
	 $(".tab-section").hide(0);
	  $("#" + icontarget ).fadeIn(500);
	   $('.icon-list li a').removeClass('active');
	    $(this).addClass('active');
	   return false;	
	});	
	
	$(".btn-tab").click(function(){
	  	$(".btn-tab").removeClass("activebt");
		$(this).addClass("activebt");
		var attName = $(this).attr("data-sign-tab");
		var attNameid= "#"+attName;
		$(".ent").hide();
		$(attNameid).show();
		
		
		
	})
	
	
	
	
	
	
	
	function validateEmail(email) { 
    var re = '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
    return re.test(email);
}
		$('#login-bttn').on('click',function()
		{
			var error = [];
			var uname = $("#username").val();
			var pwd = $("#login-pass").val();
			
			if(uname == "")
			{
				error.push('e1');
			}

			if(pwd == "")
			{
				error.push('e2');
				
			}
			
			if(error.length != 0)
			{
				if($.inArray("e1", error) !== -1){ $("#username").addClass('error');$("#username").focus(); } else { $("#username").removeClass('error'); }
				if($.inArray("e2", error) !== -1){ $("#login-pass").addClass('error');$("#login-pass").focus(); } else { $("#login-pass").removeClass('error'); }
				return false;
			}
			else
			{
				$("#username").removeClass('error');
				$("#login-pass").removeClass('error');
				error = [];
			}
			
			$.post("<?php echo base_url().'bookmyt/login_action/'; ?>",{business_email : uname , password : pwd },function(data)
			{
				//alert(data);return false;
				if($.trim(data) == 0)
				{
					$("#log-err").html('Invalid Username And Password');
					return false;					
				}
				else if($.trim(data) == 'sup_admin')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/admin_dashboard/";
				}
				else if($.trim(data) == 'user')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/occupancy/";				
				}
				else if($.trim(data) == 'editor')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/occupancy/";				
				}	
				else if($.trim(data) == 'business_first')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/my_business/";	
				}
				else if($.trim(data) == 'business')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/occupancy/";	
				}
				else if($.trim(data) == 'branch')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/occupancy/";				
				}
				else if($.trim(data) == 'admin')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/occupancy/";
				}
				else if(!isNaN($.trim(data)))
				{
					
					window.location.href = "<?php echo base_url('bookmyt/change_password'); ?>/"+$.trim(data);
				}
				else
				{
					window.location.href = "<?php echo base_url(); ?>";	
				}
			});
			return false;
		});
		
		$('#username,#login-pass').change(function()
		{
			
			if($("#username").val() != "")
			{
				$("#username").removeClass('error');
			}
			if($('#login-pass').val() != "")
			{
				$('#login-pass').removeClass('error');
			}
		});
		
		
	
		$("#select_no_of_members").blur(function() 
		{
			$.ajax({
				type :	"POST",
				url	 :	"<?php echo base_url();?>bookmyt/get_tables",
				data :	{'no_of_members' : $("#select_no_of_members").val(),'floor_id':$("#floor").val()},
				success : function(data)
					{
						$('#sub_cat_data').html(data);
					}

				});
			
		});
		 
});

</script> 


<script src="<?php echo base_url(); ?>theme/js/slider.js"></script> 
<script src="<?php echo base_url(); ?>theme/js/slider-fx.js"></script>

<script>
$('#modal-launcher-reg').click(function(){
	$('#login-modal').modal('hide' );
	 $('#signup-modal').modal('show');
	 $('body').addClass('modal-open2');
	 
});
$('.close-login').click(function(){
	 $('body').removeClass('modal-open2');
 
});
$('.login_pwd').click(function(){
	setTimeout(function(){
	  $('#login-modal input#username').focus();
	}, 500);
	
});

</script>


  
	<script type="text/javascript">
$("#s_ru_owner").click(function(){
	var owner=$("#s_your_name").val();
	$("#s_owner_name").val(owner);
})	
	
$(document).ready(function() {
// Create two variable with the names of the months and days in an array
var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ]; 
var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]

// Create a newDate() object
<?php

time_zone_set($this->session->userdata('time_zone'));
$ctime =  Date('m/d/Y H:i');

?>

var newDate = new Date("<?php echo $ctime;?>");

// Extract the current date from Date object
newDate.setDate(newDate.getDate());
// Output the day, date, month and year    
$('#Date').html(dayNames[newDate.getDay()] + " , " + ('0' + newDate.getDate()).slice(-2) + '-' + monthNames[newDate.getMonth()] + '-' + newDate.getFullYear());
$("#hours").text('<?php echo date('H')?>');
var ahour = <?php echo date('H')?>;
$("#min").text('<?php echo date('i')?>')
$("#sec").text('<?php echo date('s')?>')
startCount();

function startCount()
{
	timer = setInterval(count,1000);
}
function count()
{
	//var time_shown = $("#realtime").text();
      //  var time_chunks = time_shown.split(":");
        var hour, mins, secs;
        hour=Number($("#hours").text());
        mins=Number($("#min").text());
        secs=Number($("#sec").text());
		ahour=Number(ahour);
        secs++;
            if (secs==60){
                secs = 0;
                mins=mins + 1;
               } 
              if (mins==60){
                mins=0;
                hour=hour + 1;
				ahour = ahour+1;
              }
              if (hour>=13){
                hour=hour-12;
              }
 
        $("#hours").text(plz(hour));
		$("#min").text(plz(mins) );
		$("#sec").text( plz(secs));
		$("#secam").text( ahour >= 12 ? 'pm' : 'am');
 
}
 
function plz(digit){
 
    var zpad = digit + '';
    if (digit < 10) {
        zpad = "0" + zpad;
    }
    return zpad;
}
/*
setInterval( function() {
	// Create a newDate() object and extract the seconds of the current time on the visitor's
	var seconds = new Date("<?php echo $ctime;?>").getSeconds();
	var hours = new Date("<?php echo $ctime;?>").getHours();
	var ampm = hours >= 12 ? 'pm' : 'am';
	// Add a leading zero to seconds value
	$("#sec").html( " : " +( seconds < 10 ? "0" : "" ) + seconds + " "+ ampm);
	},1);
	
setInterval( function() {
	// Create a newDate() object and extract the minutes of the current time on the visitor's
	var minutes = new Date("<?php echo $ctime;?>").getMinutes();
	// Add a leading zero to the minutes value
	$("#min").html(" : " +( minutes < 10 ? "0" : "" ) + minutes);
    },1);
	
setInterval( function() {
	// Create a newDate() object and extract the hours of the current time on the visitor's
	var hours = new Date("<?php echo $ctime;?>").getHours();
		hours = hours % 12;
		hours = hours ? hours : 12;
	// Add a leading zero to the hours value
	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1);*/
	
}); 

	</script>
</body>
</html>


<!-- Book My T Footer Ends Here -->