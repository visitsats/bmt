<html>
	<head>
		<title>Table Matrix</title>
		<style type="text/css">
			body
			{
				margin:          0;
				padding:         0;
				background-color: #000;
				font-family:     'lucida grande', arial, tahoma, sans-serif;
			}

			#container
			{
				margin:          0 auto;
				padding-top:20px;
				width:           683px;
				position:        relative;
				background-color : #77B547;
			}
			ul { list-style:none; 
					width:100%;margin: 0;
					padding:         0;
				}
			ul li{
			float : left;
			padding : 8px;
			margin : 5px;
			color:blue;
			font-weight : bold;
			background-color : red ; 
			}
			table 
			{
				padding : 8px;
				margin : 5px;
			}
			
		</style>
	</head>
<body>

<div id="container">
<ul id="tabs">
	<li><a href="#tab1">Business Entity</a></li>
	<li><a href="#tab2">Customer</a></li>
	<li><a href="#tab3">Business Customer</a></li>
	<li><a href="#tab4">User Details</a></li>
</ul>

<br/><br/><br/>
<div id="tab1">
	<h1 style="padding : 8px;margin : 5px;"> Table Matrix Business Entity</h2>
	<form name="" method="post" action="<?php echo base_url()."/bookmyt/add_customer/"; ?>">
	<table cellspacing="5" cellpadding="5px">
		<tr>
			<td><input type="text" name="b_name" placeholder="Choose Your Business Name" size="50"></td>
		</tr>
		<tr>
			<td><input type="text" name="b_email" placeholder="Enter Your Business Email Id" size="50"></td>
		</tr>
		<tr>
			<td>
		
				<select name="time_zone" style="width:325px;height:30px">
					<option value="">Select Your Time Zone</option>
					<?php
					if(isset($time_zone) && !empty($time_zone))
					{
						foreach($time_zone as $zone)
						{
					?>
						<option value="<?php echo $zone['country_code']; ?>"><?php echo $zone['zone_name']; ?></option>
					<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><textarea rows="5" cols="38" name="b_address" Placeholder="Enter Your Address."></textarea></td>
		</tr>
		<tr>
			<td><input type="text" name="b_phone" placeholder="Enter Business Phone Number." size="50"></td>
		</tr>	
		
		<tr>
			<td><input type="text" name="b_state" placeholder="Enter Business State." size="50"></td>
		</tr>
		
		<tr>
			<td>
			<select name="b_country" style="width:325px;height:30px">
			 <option value="">Select Business Country.<option>
				<?php
					if(isset($countries) && !empty($countries))
					{
						foreach($countries as $countries)
						{
				?>
					<option value="<?php echo $countries['country_code']; ?>"><?php echo $countries['country_name']; ?></option>
				<?php
						}
					}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="text" name="b_relation" placeholder="Enter Relationship" size="50" />
			</td>
		</tr>
		<tr>
			<td>
			<select name="b_type" style="width:325px;height:30px">
				<option value="">Select Business Type.<option>
				<?php
					if(isset($business) && !empty($business))
					{
						foreach($business as $business)
						{
				?>
						<option value="<?php echo $business['business_typeid']; ?>"><?php echo $business['business_typename']; ?></option>
				<?php	}
					}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="text" name="b_subcription_type" placeholder="Enter Subscription Type" size="50" />
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" name="sub" value="Next">
			</td>
		</tr>
	</table>
	</form>
</div>
<div id="tab2">
gfdisdgfisd
</div>
<div id="tab3">lds\fdsfs 
</div>
<div id="tab4">sfdssfsfsf
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery-ui.js"></script>
<script>
	$(document).ready(function()
	{
		$("#tabs").tabs();
	});
</script>


</body>
</html>