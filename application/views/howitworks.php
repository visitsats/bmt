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
        <div class="howitworks">
          <div class="row">
            <div class="col-xs-12">
              <h3 class="text-center">How it works</h3>
              <p class="text-center lead hiwcnt">Book My T offers a cost affective yet highly efficient solution for restaurants to help manage their bookings and other day to day activities.  The set up process is extremely user friendly and can be set up in a matter of minutes. The solution is designed to avoid hefty up front investments and at the same time improve efficiency</p>
              <div class="col-sm-3">
                <div class="how-it-work-section">
                  <div class="how-it-work-icon">
                    <div class="ch-item">
                      <div class="ch-info">
                        <div class="ch-info-front ch-img-1"></div>
                        <div class="ch-info-back ch-img-1-ov"> </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <h5 class="text-center text-transform-none text-weight">Login</h5>
                  <p class="text-center">Give your email or phone and start reaping the benefits of Book My T </p>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="how-it-work-section">
                  <div class="how-it-work-icon">
                    <div class="ch-item">
                      <div class="ch-info">
                        <div class="ch-info-front ch-img-2"></div>
                        <div class="ch-info-back ch-img-2-ov"> </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <h5 class="text-center text-transform-none text-weight">Set your restaurant</h5>
                  <p class="text-center ">Set your restaurant with different Branches, Floors, create users and a floor structure (near look alike from 
                    real life) </p>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="how-it-work-section">
                  <div class="how-it-work-icon">
                    <div class="ch-item">
                      <div class="ch-info">
                        <div class="ch-info-front ch-img-3"></div>
                        <div class="ch-info-back ch-img-3-ov"> </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <h5 class="text-center text-transform-none text-weight">Start Booking </h5>
                  <p class="text-center">Start taking orders and manage your walk-ins with interactive floor plan Allocate tables and capture all relevant customer details</p>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="how-it-work-section">
                  <div class="how-it-work-icon">
                    <div class="ch-item">
                      <div class="ch-info">
                        <div class="ch-info-front ch-img-4"></div>
                        <div class="ch-info-back ch-img-4-ov"> </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <h5 class="text-center text-transform-none text-weight">Know your customer</h5>
                  <p class="text-center">Check out what works and what needs to be improved with our advanced analytics tailor made for you </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  </div>

  <?php /*?><div class="wrap apps">
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
    </div><?php */?>
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
  