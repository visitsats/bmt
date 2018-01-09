<!-- Book My T Header Starts Here -->

<!DOCTYPE HTML>

<html>

<head>

<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">



<meta name="author" content="">
<title>Free Table Management Software, Dining Reservation Software, Restaurant Management Software</title>

<meta name="description" content="BookmyT  is a next generation table management software for restaurants to manage their business efficiently and smoothly. Signup FREE now and download restaurant management software for free. We have solved the problem of restaurant industry by developing dining reservation software which helps in managing the dining operations."/>

<meta name="keywords" content="Table management software, Restaurant table management software, restaurant management software, Dining software, Free table management software." />



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
<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/demo_table_jui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/jquery-ui.css">

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

<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery-ui.min.js"></script>

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

<div class="m-nav hidden-sm hidden-md hidden-lg"> <a href="#" class="m-nav-close btn btn-default pull-right "> <i class="fa fa-chevron-right"></i> </a> </div>

<section class="topPanel" style="background:#fff  !important;height:80px !important;">

  <div class="container">

    <div class="row">

      <div class="col-sm-2 col-md-2" id="logo"><a href="<?php echo base_url(); ?>bookmyt/admin_dashboard"><img src="<?php echo base_url(); ?>theme/images/logo.png" alt="Bookmyt" class="img-responsive"></a> <a href="#" class="btn btn-default pull-right m-nav-control hidden-sm hidden-md hidden-lg" > <i class="fa fa-bars"></i></a></div>

      <div class="col-sm-10 col-md-10 hidden-xs main-nav">

       <!-- <nav class="pull-left">

          <ul class="list-unstyled">

            <li><a href="#">Book My T </a></li>

            <li><a href="#">How it Works</a></li>

            <li><a href="#">Tour</a></li>

            <li><a href="#">Support</a></li>

          </ul>

        </nav> -->

        <?php

			if($this->session->userdata('business_id'))

			{

			?>

			 <div class="dropdown pull-right"> <a data-target="#" href="page.html" data-toggle="dropdown" class=" btn btn-default btn-block dropdown-toggle pull-right user-control-dd">&nbsp;&nbsp;<!--<img src="<?php //echo base_url(); ?>theme/images/user-pick.png" alt="">--><?php echo $this->session->userdata('business_name');?><i class="fa fa-chevron-circle-down"></i> </a>

			  <ul class="dropdown-menu">

				<?php

					$prf_id = $this->session->userdata('business_id');

					

					if(isset($prf_id) && $prf_id != "")

					{

				?>
					<li><a href="<?php echo base_url()."bookmyt/my_branch/".$prf_id;?>">My Profile</a></li>
					<li><a href="<?php echo base_url()."bookmyt/change_password/".$prf_id;?>">Change Password</a></li>

				<?php

					}

				?>

				<li><a href="<?php echo base_url();?>bookmyt/log_out">Logout</a></li>

			  </ul>

			</div>

		<?php

			}

		?>		

      </div>

    </div>

  </div>

</section>

<!--

<div class="m-nav <?php //if($this->session->userdata('business_id')) { echo "m-nav-inner"; } ?> hidden-sm hidden-md hidden-lg"> <a href="#" class="m-nav-close btn btn-default pull-right "> <i class="fa fa-chevron-right"></i> </a> </div>



<section class="topPanel <?php //if($this->session->userdata('business_id')) { echo " top-panel-inner2"; } ?>">

  <div class="container">

    <div class="row">

      <div class="col-sm-2 col-md-2" id="logo"><a href="<?php //echo base_url().'bookmyt/home'; ?>"><img src="<?php //echo base_url(); ?>theme/images/logo.png" alt="Bookmyt"></a> <a href="#" class="btn btn-default pull-right m-nav-control hidden-sm hidden-md hidden-lg" > <i class="fa fa-bars"></i></a></div>

	

      <div class="col-sm-10 col-md-10 hidden-xs main-nav main-nav-inner">

        <nav class="pull-left">

		  <ul class="list-unstyled">

		  

			<div class="col-sm-10 col-md-10 hidden-xs main-nav">

			 <nav class="pull-left">

			  <ul class="list-unstyled">

				<li><a href="#">Book My T </a></li>

				<li><a href="#">How it Works</a></li>

				<li><a href="#">Tour</a></li>

				<li><a href="#">Support</a></li>

			  </ul>		  

			</nav>	 

			

             <div class="pull-right text-right btns"> <a href="#" class="btn btn-default" id="modal-launcher"  data-target="#login-modal" data-toggle="modal">Login</a> <a href="#" class="btn btn-success signup" id="modal-launcher"  data-target="#signup-modal" data-toggle="modal" >Free Signup</a> </div>

			

			

			

			</div>

    </div>

  </div>

</section>

-->

<section class="page-container" style="margin-top:80px">

		<?php

			if($this->session->flashdata('succ'))

			{

		?>

			<div class="wrap" <?php if(!$this->session->userdata('business_id')) { echo "style='margin-top:85px'"; } else {echo "style='margin-top:0px'"; } ?>>

				<div class="alert alert-success mnone text-center">

				<a class="close" aria-label="close" data-dismiss="alert" href="#"><i class="fa fa-times"></i></a>

				<strong>Success!</strong><?php echo $this->session->flashdata('succ'); ?>	</div>

			</div>

		<?php

			}	

			if($this->session->flashdata('perm'))

			{

		?>

			<div class="wrap" <?php if(!$this->session->userdata('business_id')) { echo "style='margin-top:85px'"; } else {echo "style='margin-top:0px'"; } ?>>

				<div class="alert alert-danger mnone text-center">

				<a class="close" aria-label="close" data-dismiss="alert" href="#"><i class="fa fa-times"></i></a>

				<strong>Fail!</strong><?php echo $this->session->flashdata('perm'); ?>	</div>

			</div>

		<?php

			}	

	?>

		<div class="welcome-panel" >

		<div class="container">

		<div class="row">

		<div class="col-xs-12">



		<div class="col-xs-12 col-sm-8   col-md-6   col-md-6 pnone"><h4 style="text-transform:none;font-family: 'open_sansregular';" class="">Welcome <b><?php if($this->session->userdata('business_id')) { echo (strlen($this->session->userdata('business_name')) > 20) ? substr($this->session->userdata('business_name'), 0, 20).'...' : $this->session->userdata('business_name'); }  ?> </b>Your last login was <b><?php $date=date_create($this->session->userdata('last_login')); echo date_format($date,"d-M-Y h:i:s A"); ?></b></h4></div>

		<div class="col-xs-12 col-sm-4   col-md-6  pnone">



		<div class="clock"><div id="Date"></div>

		<ul>

		<li id="hours"></li>



		<li id="min"></li>



		<li id="sec"></li>

		</ul>









		</div>



		</div>



		</div>

		</div>

		</div>

		</div>	

	



<!-- Book My T Header Ends Here -->



<!-- Book My T Content Starts Here -->



	{content}



<!-- Book My T Content Ends Here -->



<!-- Book My T Footer Starts Here -->



<div class="wrap inner-footer">

    <div class="container">

      <div class="row">

        <div class="footer">

          <div class="social-media text-center"> <a href="https://www.facebook.com/BookmyT-607569296119448/" target="_blank" class="fb"></a> <a href="https://twitter.com/bookmytapp" target="_blank" class="twitter"></a> <a href="#" class="pinterest"></a> <a href="#" class="linkedin"></a> </div>

          <nav><a href="<?php echo base_url('bookmyt/admin_terms')?>" target="_blank"> Terms & Conditions</a> <a href="<?php echo base_url('bookmyt/admin_privacy')?>" target="_blank">Privacy Policy </a> <a href="<?php echo base_url('bookmyt/admin_contact_us'); ?>" target="_blank"> Contact Us</a></nav>

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

			<label class="form-lable ">Enter User name<span class="star">*</span></label>

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





<script type="text/javascript">



	// window.onbeforeunload = function() 

	// {

		// $.post("<?php echo base_url().'bookmyt/sess_des/'; ?>",function(data){

		// });  

	// }

	

	



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

				if($.inArray("e1", error) !== -1){ $("#username").addClass('error'); } else { $("#username").removeClass('error'); }

				if($.inArray("e2", error) !== -1){ $("#login-pass").addClass('error'); } else { $("#login-pass").removeClass('error'); }

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

					$("#log-err").html('');

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



 

  

	<script type="text/javascript">

	

	

$(document).ready(function() {

// Create two variable with the names of the months and days in an array

var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ]; 

var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]



// Create a newDate() object

var newDate = new Date();

// Extract the current date from Date object

newDate.setDate(newDate.getDate());

// Output the day, date, month and year    

$('#Date').html(dayNames[newDate.getDay()] + " , " + newDate.getDate() + '-' + monthNames[newDate.getMonth()] + '-' + newDate.getFullYear());





setInterval( function() {

	// Create a newDate() object and extract the seconds of the current time on the visitor's

	var seconds = new Date().getSeconds();

	var hours = new Date().getHours();

	var ampm = hours >= 12 ? 'pm' : 'am';

	// Add a leading zero to seconds value

	$("#sec").html( " : " +( seconds < 10 ? "0" : "" ) + seconds + " "+ ampm);

	},1);

	

setInterval( function() {

	// Create a newDate() object and extract the minutes of the current time on the visitor's

	var minutes = new Date().getMinutes();

	// Add a leading zero to the minutes value

	$("#min").html(" : " +( minutes < 10 ? "0" : "" ) + minutes);

    },1);

	

setInterval( function() {

	// Create a newDate() object and extract the hours of the current time on the visitor's

	var hours = new Date().getHours();

		hours = hours % 12;

		hours = hours ? hours : 12;

	// Add a leading zero to the hours value

	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);

    }, 1);

	

}); 



	</script>

</body>

</html>





<!-- Book My T Footer Ends Here -->