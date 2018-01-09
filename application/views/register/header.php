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
			<?php 
				if($this->session->userdata('bnch') == 'No')
				{
				}
				else
				{
			?>
			<li id="brnch"><a href="<?php echo base_url();?>bookmyt/branches">Branches</a></li>
			<?php
				}
			?>
				<li><a href="<?php echo base_url();?>bookmyt/floors">Floors</a></li>
				<li><a href="<?php echo base_url();?>bookmyt/tables">Tables</a></li>
				<li><a href="<?php echo base_url();?>bookmyt/users">Users</a></li>
				<li><a href="<?php echo base_url();?>bookmyt/reservation_list">Reservations</a></li>
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