<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Edit Business</h4>
         <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p> -->
        </div>
			<div class='clearfix'></div>
			<?php			
				if($this->session->flashdata('success'))
				{
			?>			
				<div class='alert alert-success text-center' id='fo'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('success'); ?></strong> </div>		
			<?php
				}
				if($this->session->flashdata('fail'))
				{
			?>
				<div class='alert alert-danger text-center' id='fo'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('fail'); ?></strong> </div>	
			<?php
				}
			?>
        <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
            <div class="panelone  plr10">
			<center><span style="color:red"><?php echo form_error('business_name'); ?><?php echo form_error('business_types'); ?><?php echo form_error('business_email'); ?><?php echo form_error('address'); ?><?php echo form_error('phone_no'); ?><?php echo form_error('state'); ?><?php echo form_error('b_check'); ?></span></center>
            <form name="" method="post" role="form" class="wrap mt25" action="<?php echo base_url()."bookmyt/edit_business/"; ?>"><input type="hidden" name="relationship_id" value="<?php echo $this->session->userdata('business_id');?>" />
			
			<div class="form-group col-md-6">
		 Your Business Name
        <input type="text" placeholder="Choose your business name" class="form-control " maxlength="35"  value="<?php echo $userdata['business_name'];?>" name="business_name" />       
         </div>
		 
		 
		<div class="form-group col-md-6">
		 Select Your Business Type
                 <select  placeholder="(UTC-05:00) Eastern Time (US & Canada)" class="selectpicker"  name="business_types">
				<option value="" style="display:none;">Select Your Business Type</option>
					<?php
					if(isset($business_types) && !empty($business_types))
					{
						foreach($business_types as $type)
						{
					?>
						<option value="<?php echo $type['business_typeid']; ?>" <?php  if($type['business_typeid']==$userdata['business_typeid']) { echo 'selected=selected';} ?>><?php echo $type['business_typename']; ?></option>
					<?php
						}
					}
					?>
				 </select>
		
		</div>
		
		 <div class="form-group col-md-6">
		Business Email Id
				 <input type="email" placeholder="Business Email Id" class="form-control" value="<?php echo $userdata['business_email'];?>"  name="business_email" maxlength="35">
             
		</div>
		<div class="form-group col-md-6">
		 Your Address
                 <input type="text" placeholder="Your address" maxlength="150" class="form-control"  value="<?php echo $userdata['address'];?>"  name="address" >
                  
		</div>
		<div class="form-group col-md-6">
		Your Phone Number
                 <input type="text" placeholder="Your Phone" maxlength="13" class="form-control"  value="<?php echo $userdata['phone_no'];?>"  name="phone_no" id="phone">
                  
		</div>
	
		<div class="form-group col-md-6">
		Your State
				 <input type="text" placeholder="Your State" maxlength="25" class="form-control" value="<?php echo $userdata['state'];?>"  name="state">
                     </div>
		<?php $countries = array('IN'=> 'India','US' => 'United States Of America','CA' => 'Canada'); ?>
	
		<div class="form-group col-md-6">
		Your Country 
			<select  placeholder="(UTC-05:00) Eastern Time (US & Canada)" class="selectpicker"  name="country">
				<option value="" style="display:none;">Select Your Country</option>
					<?php
					if(isset($countries) && !empty($countries))
					{
						foreach($countries as $key => $val)
						{
					?>
						<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php
						}
					}
					?>
			</select>
		
			
        </div>
		<?php $time_zones = array('(UTC+05:30) Asia/Kolkata ','(UTC-11:00) Samoa Time Zone (US)','(UTC-10:00 ) Hawaii-Aleutian Time Zone (US)','	
			(UTC-09:00) Alaska Time Zone (US)','(UTC-08:00 Pacific Time Zone (US & Canada)','(UTC-07:00) Mountain Time Zone (US & Canada)','(UTC-06:00) Central Time Zone (US & Canada)','(UTC-05:00) Eastern Time Zone (US & Canada)','(UTC-04:00) Atlantic Time Zone (US & Canada)','(UTC+10:00) Chamorro Time Zone (US)','(UTC-03:30) Newfoundland Time Zone (Canada)'); ?>
		<div class="form-group col-md-6">
		Your Timezone
				<select  placeholder="(UTC-05:00) Eastern Time (US & Canada)" class="selectpicker"  name="country">
				<option value="" style="display:none;">Select Your Timezone</option>
					<?php
					if(isset($time_zones) && !empty($time_zones))
					{
						foreach($time_zones as $key => $val)
						{
					?>
						<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php
						}
					}
					?>
			</select>
        </div>
		
		<!--<div class="form-group col-md-6">
		Your Country
				 <input type="text" placeholder="Your Country" maxlength="25" class="form-control" value="<?php echo isset($userdata['country'])?$userdata['country']:'';?>"  name="country">
                     </div>
					 
		<div class="form-group col-md-6">-->
		Your Timezone
				 <input type="text" placeholder="Your Timezone" maxlength="35" class="form-control" value="<?php echo isset($userdata['time_zone'])?$userdata['time_zone']:'';?>"  name="time_zone">
                     </div>
	
		  <!--<div class="form-group">
                <select  placeholder="Select Country" class="form-control"  name="country" required>
				 <option value="">Select Country</option>
					<?php
				
					?>
						<option value="<?php //echo $coutries1['country_name']; ?>" <?php  //if($coutries1['country_name']==$userdata['country']) { echo 'selected=selected';} ?>><?php //echo $coutries1['country_name']; ?></option>
					<?php
						//}
					//}
					?>
				 </select>
                     </div>
		<div class="form-group">
                 <select  placeholder="(UTC-05:00) Eastern Time (US & Canada)" class="form-control"   name="time_zone" required>
				 <option value="">Select Your Time Zone</option>
					<?php
					//if(isset($zones) && !empty($zones))
					//{
//foreach($zones as $zone)
						//{
					?>
						<option value="<?php //echo $zone['zone_name']; ?>" <?php  //if($zone['zone_name']==$userdata['time_zone']) { echo 'selected=selected';} ?>><?php// echo $zone['zone_name']; ?></option>
					<?php
						//}
					//}
					?>
				 </select>
                 </div>-->
				 
				 <div class="form-group col-md-6">
			Business Having Branches?	&nbsp;&nbsp;
			<input type="radio" name="b_check" value="1"<?php if($userdata['have_branches'] == '1') { echo "checked='checked'";} else { } ?> id="b_yes" /> Yes
			<input type="radio" name="b_check" value="0"<?php if($userdata['have_branches'] == '0') { echo "checked='checked'";} else { } ?> id="b_no" /> No

		</div>
		 
		 <div class="form-group col-md-12">		
                <input type="submit" name="sub"   class="btn btn-success pull-right" value="Update"  >             
          </div>
		  
</form>
					
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
	
	$(document).ready(function() 
	{
            $('#phone').keydown(function(event) 
			{
               
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
                    || event.keyCode == 27 || event.keyCode == 13 
                    || (event.keyCode == 65 && event.ctrlKey === true) 
                    || (event.keyCode >= 35 && event.keyCode <= 39)){
                        return;
                }else {
                    
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                        event.preventDefault(); 
                    }   
                }
            });
            
        });

  </script>
 