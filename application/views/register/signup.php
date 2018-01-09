<center>
	<h1> Table Matrix sign up </h2>
	<?php
		if($this->session->flashdata('success'))
		{
			echo "<span style='color:green'><b>".$this->session->flashdata('success')."</b></span>";
		}
		else
		{
			echo "<span style='color:red'><b>".$this->session->flashdata('fail')."</b></span>";
		}
	?>
	<form name="" method="post" action="<?php echo base_url()."table_matrix/add_customer/"; ?>">
	<table cellpadding="4px">
		<tr>
			<td><input type="text" name="business_name" placeholder="Choose Your Business Name" size="50"> &nbsp; @tablematrix.com</td>
			
		</tr>
		<tr>
			<td>
				<select name="business_types" style="width:325px;height:25px">
				<option value="" style="display:none;">Select Your Business Type</option>
					<?php
					if(isset($time_zone) && !empty($time_zone))
					{
						foreach($time_zone->business_types as $type)
						{
					?>
						<option value="<?php echo $type->business_typeid; ?>"><?php echo $type->business_typename; ?></option>
					<?php
						}
					}
					?>
				</select>
			
			</td>
		</tr>
		<tr>
			<td><input type="text" name="business_email" placeholder="Enter Your Email Id" size="50"></td>
			
		</tr>
		<tr>
			<td><input type="text" name="uname" placeholder="Username" size="50"></td>
			
		</tr>
		<tr>
			<td><input type="password" name="passwd" placeholder="Password" size="50"></td>
		</tr>	
		<tr>
			<td>
				
				<select name="time_zone" style="width:325px;height:25px">
					<option value="">Select Your Time Zone</option>
					<?php
					if(isset($time_zone) && !empty($time_zone))
					{
						foreach($time_zone->zones as $zone)
						{
					?>
						<option value="<?php echo $zone->country_code; ?>"><?php echo $zone->zone_name; ?></option>
					<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" name="confirm"> I agree to the terms of conditions and privacy policy.
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="sub" value="Create My Free Account">
			</td>
		</tr>
	</table>
	</form>
</center>