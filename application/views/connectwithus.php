<script src='https://www.google.com/recaptcha/api.js'></script>
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
	  
         <div class="col-xs-12 col-sm-12 pull-left">
          <h3 class="text-center" >Why book my t</h3>
          <p  class="text-center lead hiwcnt">We have developed a cost effective yet highly efficient solution for restaurant owners. It's for every restaurant big or small, boutique or chain, who wants to stay always ahead of the competition.  With no over head expense and an easy set up process which can be done in minutes, we want you to start managing your business efficiently from today. Build a long lasting relationship with your customer. </p>
         <!-- <a href="#" class="btn btn-default2">More</a>--> </div>
		 
		 <div class="wrap">
		 
		 
        <div class="col-xs-12 col-sm-12 ">
            <h4 class="text-center" >Connect with us</h4>
		  <span id="sucess_connect" style="color:red;"></span>
          <form role="form" class="" >
		  <div class="row">
		  <div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <input type="text"  placeholder="Name" class="form-control" id="connect_name">
            </div>
			</div>
			<div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <input type="text" placeholder="Restaurant Name"class="form-control" id="connect_res_name">
            </div>
			</div>
			<div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <input type="text" placeholder="Email or Phone Number" class="form-control" id="connect_mobile">
            </div>
			</div>
			</div>
			<div class="g-recaptcha" data-sitekey="6LcBTScUAAAAAN9BXLcLIFlcgfpgp_oKgxgl5LcZ"></div>			
            <button type="button" onclick="connect_with_us()" class="btn btn-success pull-right">Submit</button>
          </form>
        </div>
		</h3>
		
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
$(document).ready(function(){
	$("#connect_name").focus();
});			
function connect_with_us()
{

  var name = $('#connect_name').val();
  var res_name = $('#connect_res_name').val();
   var mobile = $('#connect_mobile').val();
   var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(name=='')
  {  	
  	$("#connect_name").addClass('error');
  	$("#connect_name").focus();
 	return false;
  } 
  else
  { 
  $("#connect_name").removeClass('error');
  }
   if(res_name=='')
  {
  $("#connect_res_name").addClass('error');
  $("#connect_res_name").focus();
  return false;
  } 
  else
  { 
  $("#connect_res_name").removeClass('error');
  }
   if(mobile=='')
  {
  $("#connect_mobile").addClass('error');
  $("#connect_mobile").focus();
  return false;
  } 
  else
  { 
 	 if(isNaN(mobile) && !filter.test(mobile)){
		  $("#connect_mobile").addClass('error');
		  $("#connect_mobile").focus();
		  return false;
	 }else if(!isNaN(mobile) && mobile.length!=10){
		$("#connect_mobile").addClass('error');
		$("#connect_mobile").focus();
		return false;
	 }else{
	 	$("#connect_mobile").removeClass('error');
	 }
  }
  var captcha_response = grecaptcha.getResponse();
  if(captcha_response.length == 0)
	{
		alert("Please click on captcha");
		// Captcha is not Passed
		return false;
	}
	
	$.post("<?php echo base_url().'bookmyt/connect_with_us/'; ?>",{'mobile' : mobile,'name':name,'res_name':res_name },function(data)
	{
	if($.trim(data) == '1')
	{
	alert("Thanks for your time. We have received your request and our representative will contact you");
	location.reload();
	$('#connect_name').val('');
	$('#connect_res_name').val('');
	$('#connect_mobile').val('');
	return false;
	}

	});
}	

        </script>
  