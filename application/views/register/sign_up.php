<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="<?php echo base_url();?>theme/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>theme/css/stylesheet.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo base_url();?>theme/css/bootstrap.min.css"></script>
<script type="text/javascript" src="<?php echo base_url();?>theme/js/jquery-1.11.3.min.js"></script>
<link href="<?php echo base_url();?>font-awesome-4.3.0/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url();?>font-awesome-4.3.0/fonts/fontawesome-webfont.svg" rel="stylesheet">

</head>
<body>
<div  class="wrap">
  <nav id="top-nav">
    <div class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <a href="<?php echo base_url();?>" class="navbar-brand"><img src="<?php echo base_url();?>images/logo.jpg" width="272" height="45" alt="logo"></a> </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">tour</a></li>
            <li><a href="#">demo</a></li>
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">support<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">About</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">About</a></li>
              </ul>
            </li>
          <?php
			if(!$this->session->userdata('business_id'))
			{
			?>
            <li><a href="<?php echo base_url();?>bookmyt/login">login</a></li>
            <li class="active"><a href="<?php echo base_url();?>bookmyt/sign_up">free signup</a></li>
			<?php
			}else
			{
			?>
			 <li><a href="<?php echo base_url();?>bookmyt/log_out">Log Out</a></li>
           
			
			<?php
			}
			?>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  
 <div class=" banner">
 <img src="<?php echo base_url();?>images/sign-up-banner.jpg" width="100%" height="234" style="margin-top:-20px;"> 
<div class="banner-cnt">
	

<h1 class="text-center bannerh1"><span style="color:#282828;">thank you for choosing</span> table matrix</h1>
<p class="sign">Access table matrix through mobile browsers and native applications with your iPhone,<br> 
iPad, Android, and Windows Phone.</p>

<div class="box-icon2">
    <img  src="<?php echo base_url();?>images/sign-uo-icon..png" ></div>
  </div>
    
     <div class="conttop"> 
    <div class="wrap m-none section-two">
    <div class="container">
   
    	<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 tab">
        
      <?php
	 
		if($this->session->flashdata('success'))
		{
			echo "<span style='color:green'>".$this->session->flashdata('success')."</span>";
		}
		else
		{
			echo "<span style='color:red'>".$this->session->flashdata('fail')."</span>";
		}
	?>
       <form name="" method="post" class="form" action="<?php echo base_url()."bookmyt/add_customer/"; ?>">
	   
	   <div class="form-group">
        <div class="col-sm-12 p-none"><input type="text" placeholder="Choose your business name" class="form-control " value="<?php echo set_value('business_name'); ?>" name="business_name">
		<span style="color:red"><?php echo form_error('business_name'); ?></span>
		</div>
       
        <!-- <p class="col-sm-3">tablematrix.com</p>-->
         </div>
		 <div class="clearfix"></div>
		 
		 <div class="form-group">
		 
                 <select  placeholder="(UTC-05:00) Eastern Time (US & Canada)" class="form-control"  name="business_types">
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
				 <span style="color:red"><?php echo form_error('business_types'); ?></span>
				 </div>
		
		<div class="form-group">				
			 <input type="text" placeholder="Enter your Email Id OR Mobile Number" class="form-control" value="<?php echo set_value('business_email_phn'); ?>"  name="business_email_phn">
			 <span style="color:red"><?php echo form_error('business_email_phn'); ?></span>
		</div>
		
		<!--<div class="form-group">
            <input type="password" placeholder="Enter your password" class="form-control"  value=""  name="password" required>
        </div>-->
		
		 
	
		
		 <div class="form-group">
                <input type="submit" name="sub"  class="btn btn-primary  btn-lg pull-right" value="Sign Up"  >
               <div>
          </form>        
        </div>
       
    </div>
        </div>
        
       </div> 
        
<div class="footer">
	<div class="container">
    	<div class="col-md-2 col-sm-2">
        	 <h3 style="font-family:Bebas; font-size:18px;">COMPANY</h3>
                <p style="font-family:'Myriad Web Pro';  font-weight:800;">About<br />
                Services<br />
                Career<br />
                Blog</p>
        </div>
        <div class="col-md-2 col-sm-2">
        <h3 style="font-family:Bebas; font-size:18px; padding-left:0px;">NAVIGATION</h3>
                <p style="padding-left:0px; font-family:'Myriad Web Pro'">Tour<br />
                Demo<br />
                Support<br />
                Login</p>
        </div>
        <div class="col-md-3 col-sm-3">
        	 <h3 style="font-family:Bebas; font-size:18px; padding-left:0px;">CONTACT US</h3>
                <p style="padding-left:0px; font-family:'Myriad Web Pro'">Knowledge Matrix,Inc<br />
                Lorem ipsum dolor sit amet 542147<br />
                Lorem ipsum dolor  95062<br />
               Phone : 040254601655<br />
               Fax : 040426545665</p>
               
        </div>
        <div class="col-md-5 col-sm-6=5">
        	 <h3 style="font-family:Bebas; font-size:18px; padding-left:0px;">BE SOCIABLE</h3>
                <p style="padding-left:0px; font-family:'Myriad Web Pro'">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean   <br />
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. consectetuer  <br />
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit consectetuer<br />
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean <br />
                Lorem ipsum dolor sit amet</p>
                
 
       </div>
    </div>
</div>

     
  	<div class="footer-bot">
    	<p>Copyright © 2014 tablematrix. All Rights Reserved.<a href="#" style="text-decoration:none; color:#000;"> Terms of Use | Privacy Policy | FAQs | e-Compliance</a></p>
    </div> 

</div>
<script type="text/javascript" src="<?php echo base_url();?>theme/js/bootstrap.min.js"></script>
  		<script type="text/javascript" src="<?php echo base_url();?>engine1/script.js"></script>
</body>
</html>
