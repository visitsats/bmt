<link rel="stylesheet"  href="<?php echo base_url(); ?>theme/css/build.css" />
<!-- Container -->
<section class="page-container">
  <div class="banner-inner" id="bookmyt">
    <div class="banner-cnt">
      
    </div>
  </div>
  
  <div  class="inner-cnt">
  <section id="howitworks">
    <div class="container">
      <div class="panelone">
	  
         
		 
		 <div class="wrap" id="demo">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h3 class="text-center mt10">Demo</h3>
          <!--p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p-->
        </div>
      </div>
    </div>
    <div class="tab-list col-sm-12 ">
      <div class="container">
        <div class="row">
          <ul class="list-unstyled icon-list mt25">
            <li ><a href="#" data-tabe="login" class="active" title="Login"><img src="<?php echo base_url(); ?>theme/images/1.png" alt=""> <br/>
              <span>Register </span></a></li>
            <li><a href="#" data-tabe="select-restaurant" title="Select Restaurant"> <img src="<?php echo base_url(); ?>theme/images/7.png" alt=""> <br/>
              <span>Set up</span> </a></li>
            <li><a href="#" data-tabe="table-management" title="Table Management"><img src="<?php echo base_url(); ?>theme/images/2.png" alt=""> <br/>
              <span>Table Management </span></a></li>
            <li><a href="#" data-tabe="view-reports" title="View Reports"><img src="<?php echo base_url(); ?>theme/images/3.png" alt=""> <br/>
              <span>View Reports</span></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="tab-cnt tab-cnt-2 col-sm-12 col-xs-12">
      <div class="tab-section" id="login" style="display:block">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-6 m-pull-left s-pull-left">
              <h3 class="mtnone">Register</h3>
             <!-- <p>Go through our quick set up process and register yourself today. It’s absolutely free for 1st 90 days..!! No credit card info required. You can also get is touch with our consultant, and they will help set up you restaurant in no time.</p>-->
			 <p>Go through our quick set up process and register yourself today. It's absolutely free for 1st 90 days..!! No credit card info required. You can also get in touch with our consultant (call <span style="font-family:Arial, Helvetica, sans-serif;font-size:14px;">+91 7731825006 / +91 9000550399</span>), and they will help you to set up you restaurant in no time.</p>
              
              <a href="#" class="btn btn-success" data-toggle="modal" data-target="#signup-modal">Register </a> </div>
               <div class="col-xs-12 col-sm-6 m-pull-right s-pull-left"> <img src="<?php echo base_url(); ?>theme/images/register.png" class="img-responsive img-style"> </div>
           
          </div>
        </div>
      </div>
      <div class="tab-section" id="select-restaurant">
        <div class="container">
          <div class="row">
            
            <div class="col-xs-12 col-sm-6 m-pull-right s-pull-left">
              <h3 class="mtnone">Set up</h3>
       
              <ul class="list-unstyled list circle">
                <li> You can set up your very own floor plan, we got all the tools</li>
<li>	If you have multiple branches, we have you covered</li>
<li>If you have multiple floors, we have you covered</li>
<li>Just follow the process, and you will be able to set up your restaurant in next couple of minutes</li>

              </ul>
              </div>
              
              <div class="col-xs-12 col-sm-6  m-pull-left s-pull-left "> <img src="<?php echo base_url(); ?>theme/images/set_up.png" class="img-responsive img-style"> </div>
          </div>
        </div>
      </div>
      <div class="tab-section" id="table-management">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-6 m-pull-left s-pull-left">
              <h3 class="mtnone">Table management</h3>
             
              <ul class="list-unstyled list circle">
               <li>	Now that you have set up your restaurant, you can start managing your table</li>
<li>	You can send SMS to your customer to alert them, once their table is ready or their booking is confirmed</li>
<li>	You can also use our Android app to start reserving tables</li>
<li>	We help you capture all your customer details, and manage your table booking</li>

              </ul>
               </div>
            <div class="col-xs-12 col-sm-6 m-pull-right s-pull-left"> <img src="<?php echo base_url(); ?>theme/images/table--management.png" class="img-responsive img-style"> </div>
          </div>
        </div>
      </div>
      <div class="tab-section" id="view-reports">
        <div class="container">
          <div class="row">
           
            <div class="col-xs-12 col-sm-6 m-pull-right s-pull-left">
              <h3 class="mtnone">View Reports</h3>
              
              <ul class="list-unstyled list circle">
                 <li>Use our advanced business analytics to make better decisions </li>
 <li>We provide you with real time dashboard for data occupancy</li>
 <li>	Reward your best staff</li>
 <li>	Know what your customers like</li>

              </ul>
              </div>
              
               <div class="col-xs-12 col-sm-6  m-pull-left s-pull-left"> <img src="<?php echo base_url(); ?>theme/images/view-report-demo.png" class="img-responsive img-style"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    </div>
  </section>
  </div>

  <!--<div class="wrap apps">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 text-left responsive">
			<img src="<?php echo base_url(); ?>theme/images/responsive.png" class="img-responsive"> 
		</div>
		<div class="col-xs-6 text-right ">
        <div class="app-btn">
        <h6>Coming soon</h6>
			<a href="#."><img src="<?php echo base_url(); ?>theme/images/android.png" class=""></a> 
			<a href="#."><img src="<?php echo base_url(); ?>theme/images/ios.png" class=""></a>
		</div>
        </div>

        </div>
      </div>
    </div>-->
  </div>
<?php if ($this->uri->segment(3) !== FALSE){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".login_pwd").trigger('click');
			});
		</script>
<?php  } ?>
   <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
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
  