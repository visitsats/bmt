<!-- Book My T Header Starts Here -->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Bookmyt</title>

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

<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/bootstrap-select.css">
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

 
</head>

<body>

<div class="m-nav hidden-sm hidden-md hidden-lg"> <a href="#" class="m-nav-close btn btn-default pull-right "> <i class="fa fa-chevron-right"></i> </a> </div>
<section class="topPanel top-panel-inner">
  <div class="container">
    <div class="row">
      <div class="col-sm-2 col-md-2" id="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>theme/images/logo.png" alt="Bookmyt"></a> <a href="#" class="btn btn-default pull-right m-nav-control hidden-sm hidden-md hidden-lg" > <i class="fa fa-bars"></i></a></div>
      <div class="col-sm-10 col-md-10 hidden-xs main-nav">
        <nav class="pull-left">
		  <ul class="list-unstyled">
			<li><a href="#">Book My T </a></li>
            <li><a href="#">How it Works</a></li>
            <li><a href="#">Tour</a></li>
            <li><a href="#">Support</a></li>
          </ul>		  
        </nav>
		  	
            <?php 
				// echo "<pre>";
					// print_r($this->session->userdata());
				// echo "</pre>";
				if($this->session->userdata('business_id'))
				{
			?>
			 <div class="dropdown pull-right"> <a data-target="#" href="page.html" data-toggle="dropdown" class=" btn btn-default  dropdown-toggle pull-right">&nbsp;&nbsp;<!--<img src="<?php //echo base_url(); ?>theme/images/user-pick.png" alt="">--><?php echo $this->session->userdata('business_name'); ?><i class="fa fa-chevron-circle-down"></i> </a>
			  <ul class="dropdown-menu">
				<?php
					$prf_id = $this->session->userdata('business_id');
					$user_id = $this->session->userdata('user_id');
					
					if(!$this->session->userdata('user_id') && $this->session->userdata('branch') == 0)
					{
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
             <div class="pull-right text-right btns"> <a href="#" class="btn btn-default" id="modal-launcher"  data-target="#login-modal" data-toggle="modal">Login</a> <a href="#" class="btn btn-success signup" id="modal-launcher"  data-target="#signup-modal" data-toggle="modal" >Free Signup</a> </div>
			
			<?php
				}
			?></div>
    </div>
  </div>
</section>
<section class="page-container">
<?php
	if($this->session->flashdata('succ'))
	{
?>
	<div class="wrap inner-page-cnt" style="margin-top:0px">
		<div class="alert alert-success mnone text-center">
		<a class="close" aria-label="close" data-dismiss="alert" href="#"><i class="fa fa-times"></i></a>
		<strong>Success!</strong><?php echo $this->session->flashdata('succ'); ?>	</div>
	</div>
<?php
	}	
	if($this->session->flashdata('perm'))
	{
?>
	<div class="wrap inner-page-cnt" style="margin-top:0px">
		<div class="alert alert-danger mnone text-center">
		<a class="close" aria-label="close" data-dismiss="alert" href="#"><i class="fa fa-times"></i></a>
		<strong>Fail!</strong><?php echo $this->session->flashdata('perm'); ?>	</div>
	</div>
<?php
	}	
		if($this->session->userdata('business_id'))
		{
			$home_methods = array('create_pwd','Update_business','edit_business','add_customer');
			$floor_methods = array('add_floor','floors','edit_floor','delete_floor');
			$branch_methods = array('add_branch','branches','edit_branch','delete_branch','create_branch_pwd');
			//$table_methods = array('add_table','edit_table','tables','delete_table','book_table','table_confirm');
			$users_methods = array('add_user','users','edit_user','update_user','delete_user','create_user_pwd');
			$reservation_methods = array('add_reservation','buzz_reservation','reservation','edit_reservation','reservation_list','delete_reservation','can_reservation');
			$quick_book = array('quick_book');
			$reports = array('reports');
			$current_method = $this->router->fetch_method();
	?>
			<div class="inner-nav" <?php if($this->session->flashdata('perm')) { echo "style='margin-top:0px !important'"; } ?>>
				<div class="container">
				  <div class="row">
					<div class="col-xs-12">
					  <ul class="list-unstyled">
					 
					<?php
					if($this->session->userdata('branch') != 1)
					{
						
						if($this->session->userdata('have_branches') == '0' || $this->session->userdata('have_branches') == '')
						{
						}
						
						else
						{
							if($this->session->userdata('user_id'))
							{
							}
							else
							{
					?>
						<li <?php if(in_array($current_method,$branch_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/branches"><img src="<?php echo base_url(); ?>theme/images/branches.png" alt=""><br/>Branches </a></li>
					<?php
							}
						}
					}
					?>
						<li <?php if(in_array($current_method,$floor_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/floors"> <img src="<?php echo base_url(); ?>theme/images/floors.png" alt=""> <br/>
						  Floors </a></li>
						<!--<li <?php //if(in_array($current_method,$table_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php //echo base_url();?>bookmyt/tables"> <img src="<?php //echo base_url(); ?>theme/images/tables.png" alt=""> <br/>
						  Tables </a></li>-->
						<li <?php if(in_array($current_method,$users_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/users"> <img src="<?php echo base_url(); ?>theme/images/users.png" alt=""> <br/>
						  Users </a></li>
						<li <?php if(in_array($current_method,$reservation_methods)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/reservation_list"><img src="<?php echo base_url(); ?>theme/images/reservations.png" alt=""> <br/>
						  Reservations</a></li>
						   <li <?php if(in_array($current_method,$quick_book)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/quick_book"><img src="<?php echo base_url(); ?>theme/images/reservations.png" alt=""> <br/>
						  Walkin</a></li>
						   <li <?php if(in_array($current_method,$reports)) { echo "class='active'"; } else {} ?> ><a href="<?php echo base_url();?>bookmyt/reports"> <img src="<?php echo base_url(); ?>theme/images/reports.png" alt=""><br/>
						  Dashboard</a></li>
						  <li class="pull-right">
						  
						   <div class="clock"><div id="Date"></div>
						   <ul>
								<li id="hours">00</li>
								<li id="point">:</li>
								<li id="min">00</li>
								<li id="point">:</li>
								<li id="sec">00</li>
							</ul>




</div>
						  
						  </li>
						  
					  </ul>
					  
					  
					 
					  
					</div>
				  </div>
				</div>
			  </div>
	<?php
		}
	?>

<!-- Book My T Header Ends Here -->

<!-- Book My T Content Starts Here -->

	{content}

<!-- Book My T Content Ends Here -->

<!-- Book My T Footer Starts Here -->

<div class="wrap inner-footer">
    <div class="container">
      <div class="row">
        <div class="footer">
          <div class="social-media text-center"> <a href="#" class="fb"></a> <a href="#" class="twitter"></a> <a href="#" class="pinterest"></a> <a href="#" class="linkedin"></a> </div>
          <nav><a href="#"> Terms & Conditions</a> <a href="#">Privacy Policy </a> <a href="#"> connect us</a></nav>
          <p class="small text-center copyrights">&copy; 2015 Bookmyt all rights reserved</p>
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
              <input type="text" id="username" name="business_email" placeholder="Enter User name" value="" class="form-control login-field" >
              <i class="fa fa-user login-field-icon"></i>
			 <span style="color:red" id="un-err"></span>
			  </div>
            <div class="form-group">
              <input type="password" name="password" id="login-pass" placeholder="Password" value="" class="form-control login-field" >
              <i class="fa fa-lock login-field-icon"></i>
			  <span style="color:red" id="pwd-err"></span>
			  </div>
            <button class="btn btn-success modal-login-btn" id="login-bttn" name="login"/>Login</button> <a href="<?php echo base_url().'bookmyt/forgot_password/'; ?>" class="login-link text-center">Lost your password?</a> 
			</form>
			</div>
          <div id='center-line'> OR </div>
          <div class="modal-body-right">
            <button class="btn btn-default close-login-con" id="modal-launcher"  data-target="#signup-modal" data-toggle="modal"> New User Please Register</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
        <h3 class="modal-title" id="myModalLabel">Free Signup</h3>
      </div>
      <div class="modal-body login-modal">
        <!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text eve</p>-->
        <br/>
        <div class="clearfix"></div>
		<form name="register" method="post" action="<?php echo base_url().'bookmyt/add_customer/'; ?>">
        <div class='modal-body-left'>
          <div class="form-group">
            <input type="text" id="business_name" name="business_name" placeholder="Business Name" maxlength="25" value="" class="form-control login-field" required>
          </div>
          <div class="form-group">
			<select   class="selectpicker" required  name="business_types" id="b_tpe">
				<option value="">Select Your Business Type</option>
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
            <input type="text" name="business_email_phn" id="b_id" maxlength="50" placeholder="Email or Phone Number" value="" class="form-control login-field" required>
			<span id="em_err" style="color:red"></span>
          </div>
          <div class="form-group">
            <input type="submit" value="Submit" name="sub" id="butt" class="btn btn-success modal-login-btn" onclick="return val_reg()">
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


<script type="text/javascript">
function val_reg()
	{
		var msg="";
		var bname = $('#business_name').val();
		var btype = $('#b_tpe').val();
		var bemail = $('#b_id').val();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(bname == "")
		{
			msg = "Please enter business name\n";
		}
		if(btype == "")
		{
			msg += "Please select business type\n";
		}
		if(bemail == "")
		{
			msg += "Please enter business emailid\n";
		}
		else
		{
			if (!filter.test(bemail)) 
			{
				msg += "Please enter valid emailid\n";
			}
		}
		
		if(msg != "")
		{
			alert(msg);
			return false;
		}
		else
		{
			return true;
		}
	}
	
$(document).ready(function(e)
{	
	$('.selectpicker').selectpicker();
	
	$('.close-login-con').click(function(){
	
	$("#close-login").click();
	
	})
	

    var navhtml =$('.main-nav').html();
	$('.m-nav').append(navhtml);
	
	$('.m-nav-control').click(function(){
	 $('.m-nav').addClass('active');
	 return false;	
	});
	
	$('.m-nav-close').click(function(){
	 $('.m-nav').removeClass('active');
	 return false;	
	});
	
	$('.icon-list li a').click(function(){
	 var icontarget = $(this).attr('data-tabe');
	 $(".tab-section").hide(0);
	  $("#" + icontarget ).fadeIn(500);
	   $('.icon-list li a').removeClass('active');
	    $(this).addClass('active');
	   return false;	
	});	
	
		$('#login-bttn').on('click',function()
		{

			var uname = $("#username").val();
			var pwd = $("#login-pass").val();
			
			if(uname == "")
			{
				$("#un-err").html("Please Enter Username");
				return false;
			}
			else
			{
				$("#un-err").html("");
			}
			
			if(pwd == "")
			{
				$("#pwd-err").html("Please Enter Password");
				return false;
			}
			else
			{
				$("#pwd-err").html("");
			}
			
			$.post("<?php echo base_url().'bookmyt/login_action/'; ?>",{business_email : uname , password : pwd },function(data)
			{
				if($.trim(data) == 0)
				{
					$("#log-err").html('Invalid Username And Password');
					return false;					
				}
				else if($.trim(data) == 'user')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/reservation_list/";				
				}
				else if($.trim(data) == 'editor')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/floors/";				
				}	
				else if($.trim(data) == 'business_first')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/my_business/";	
				}
				else if($.trim(data) == 'business')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/branches/";	
				}
				else if($.trim(data) == 'branch')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/floors/";				
				}
				else if($.trim(data) == 'admin')
				{
					window.location.href = "<?php echo base_url(); ?>bookmyt/floors/";
				}
				else
				{
					window.location.href = "<?php echo base_url(); ?>";	
				}
			});
			return false;
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

 
  
	<script type="text/javascript">
	
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
	
	var stickyOffset = $('.inner-nav').offset().top;


$(function() {

	// grab the initial top offset of the navigation 
	var sticky_navigation_offset_top = $('.inner-nav').offset().top;
	
	// our function that decides weather the navigation bar should have "fixed" css position or not.
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop(); // our current vertical position from the top
		
		// if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
		if (scroll_top > sticky_navigation_offset_top) { 
			$('.inner-nav').css({ 'position': 'fixed', 'top':0, 'left':0 });
		} else {
			$('.inner-nav').css({ 'position': 'relative' }); 
		}   
	};
	
	// run our function on load
	sticky_navigation();
	
	// and run it again every time you scroll
	$(window).scroll(function() {
		 sticky_navigation();
	});
	
	
	
});

$(document).ready(function() {
// Create two variable with the names of the months and days in an array
var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ]; 
var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]

// Create a newDate() object
var newDate = new Date();
// Extract the current date from Date object
newDate.setDate(newDate.getDate());
// Output the day, date, month and year    
$('#Date').html(dayNames[newDate.getDay()] + " , " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

var hours = new Date().getHours();
var ampm = hours >= 12 ? 'pm' : 'am';
hours = hours % 12;
hours = hours ? hours : 12;
setInterval( function() {
	// Create a newDate() object and extract the seconds of the current time on the visitor's
	var seconds = new Date().getSeconds();
	// Add a leading zero to seconds value
	$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds + " "+ ampm);
	},1000);
	
setInterval( function() {
	// Create a newDate() object and extract the minutes of the current time on the visitor's
	var minutes = new Date().getMinutes();
	// Add a leading zero to the minutes value
	$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    },1000);
	
setInterval( function() {
	// Create a newDate() object and extract the hours of the current time on the visitor's
	//var hours = new Date().getHours();
	// Add a leading zero to the hours value
	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);
	
}); 

	</script>
</body>
</html>


<!-- Book My T Footer Ends Here -->