  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Add New User</h4>
          <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>
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
			<center><span style="color:red" id="email_err"><?php echo form_error('branch'); ?><?php echo form_error('username'); ?><?php echo form_error('email_phn'); ?><?php echo form_error('user_type[]'); ?></span></center>
            <form name="" method="post" role="form" class="wrap mt15" action="<?php echo base_url()."bookmyt/add_user/"; ?>">
			
			<input type="hidden" name="relationship_id" value="<?php if($this->session->userdata('relationship_id') == '') { echo ''; } else { echo $this->session->userdata('relationship_id'); } ?>" />
					
					<?php
						if($this->session->userdata('branch') == '0')
						{
							if($this->session->userdata('have_branches') == '0')
							{
						?>
								<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
			
						<?php
							}
							else
							{
							
						?>
						  <div class="form-group col-md-6">
							  <select class="selectpicker"  name="branch" id="business_id">
									<option value="" style="display:none;">Select  Branch</option>
									<?php
									if(isset($branches) && !empty($branches))
									{
										foreach($branches as $branch)
										{
									?>
										<option value="<?php echo $branch['business_id']; ?>" <?php if($branch['business_id'] == $this->session->userdata('business_id')) { echo "selected='selected'";} ?> <?php echo set_select('branch', $branch['business_id']); ?>><?php echo $branch['business_name']; ?></option>
									<?php
										}
									}
									?>
							 </select>
								<span style="color:red"><?php echo form_error('branch'); ?></span>
						  </div>
					<?php
							}
						}
						else
						{
					?>
											 
						<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
				   <?php
						}
					?>		   
				   <div class="form-group col-md-6"> 
						<input type="text" placeholder="User Name" class="form-control" value="<?php echo set_value('username'); ?>" name="username" id="username" maxlength="25" >
				   </div>
				  
				  <div class="form-group col-md-6"> 
					 <input type="text" placeholder="User Email Id OR Phone Number" class="form-control"  value="<?php echo set_value('email_phn'); ?>"  name="email_phn" id="email_chk" maxlength="50">
				  </div>
				 
				 <div class="form-group col-md-6">
			 
					<?php 
						foreach($roles as $users)
						{
					?>
					&nbsp;&nbsp;&nbsp;<input type="radio" name="user_type" value="<?php echo $users['role_id']; ?>"<?php echo set_checkbox('user_type', $users['role_id']); ?> />&nbsp;<?php echo $users['role_name']; ?>
					<?php
						}
					?>
				 </div>
					 
				  <div class="form-group col-md-12">
				  <button type="submit" name="sub"  class="btn btn-success pull-right icon-btn"><i class="fa fa-plus-circle"></i> Add User</button> </div>
				  
				  
				</form>
							
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">
  
  
  
	$(document).ready(function()
	{
		$("#username").change(function()
		{
			if($.isNumeric($("#username").val()))
			{
				alert("Username sholud not be numbers.");
				return false;
			}
			
		});
		$("#email_chk").change(function()
		{
			var email_check = $("#email_chk").val();
			$.post("<?php echo base_url().'bookmyt/email_duplicate/'; ?>",{ email : email_check} ,function(data)
			{
				
				if(data == 1)
				{
					$('#email_err').html("Email already rgistered for business try another.");
					return false;
				}
				else
				{
					$('#email_err').html("");
				}
			});
		});
	});
  </script>
 