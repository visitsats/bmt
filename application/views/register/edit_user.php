  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Edit User</h4>
         <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
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
			<center><span style="color:red;font-weight:bold" id="email_err"><?php echo form_error('email_phn'); ?></span></center>
        <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
            <div class="panelone  plr10">
			
			<?php
				foreach($user_info->get_user as $user_data)
				{
			?>
            <form name="" method="post" role="form" class="wrap mt15" action="<?php echo base_url()."bookmyt/update_user/".$user_data->user_id; ?>">
			<input type="hidden" name="relationship_id" value="<?php if($this->session->userdata('relationship_id') == '') { echo ''; } else { echo $this->session->userdata('relationship_id'); } ?>" /> <input type="hidden" name="pwd_id" value="<?php echo $user_data->password;?>" />

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
					if($user_data->relationship_id == '0')
					{
			?>
			
						<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
			<?php
					}
					else
					{
			?>
				<div class="form-group col-xs-12 col-md-6 col-sm-6"> 
					<label class="form-lable ">Select  Branch<span class="star">*</span></label>
					<select class="selectpicker"  name="branch">
					<option value="" style="display:none;">Select User Branch</option>
					<?php
						if(isset($branches) && !empty($branches))
						{
							foreach($branches as $branch)
							{
							?>
							<option value="<?php echo $branch['business_id']; ?>" <?php if($user_data->business_id == $branch['business_id']) { echo "selected='selected'"; }  ?>><?php echo $branch['business_name']; ?></option>
							<?php
							}
						}
					?>
					</select>
				</div>
			<?php	
					}
				}
			}
			else
			{
			?>
			
			<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch">
			<?php
			}
			?>
					
				   <div class="form-group col-xs-12 col-sm-6 col-md-6"> 
				  <label class="form-lable ">Username<span class="star">*</span></label>
						<input type="text" placeholder="" id="username" maxlength="25" class="form-control" value="<?php echo $user_data->username; ?>" name="username" >
					
				   </div>
				  
				  <div class="form-group  col-xs-12 col-md-6 col-sm-6"> 
				   <label class="form-lable ">User Email Id OR Phone Number<span class="star">*</span></label>
					 <input type="text" placeholder="" maxlength="25" class="form-control" value="<?php echo (isset($user_data->email) && $user_data->email!="")?$user_data->email:$user_data->phone_no; ?>"   name="email_phn" id="email_chk">
					
				  </div>
				  
				   <div class="form-group col-xs-12 col-sm-6 col-md-6">
					<label class="form-lable ">User type<span class="star">*</span></label>
					<select class="selectpicker"  name="user_type" id="user_type">
					<option value="" style="display:none;">Select  User Type</option>
					<?php
					if($this->session->userdata('user_type_id'))
					{	
						$r_data = $user_data->user_type_id;
						$gt = $this->session->userdata('user_type_id');
						if($gt == '2')
						{
					?>
						<option value="3" <?php if($r_data == '3') {echo "selected='selected'"; }  ?>>Conserver/Manager</option>
						<option value="4" <?php if($r_data == '4') {echo "selected='selected'"; }  ?>>Waiter/Server</option>
					<?php
						}
						else if($gt == '3')
						{
					?>
						<option value="4" <?php if($r_data == '4') {echo "selected='selected'"; }  ?>>Waiter/Server</option>
					<?php
						}
					}
						else
						{
							$r_data = $user_data->user_type_id;
							foreach($roles as $users)
							{
						?>
							<option value="<?php echo $users['role_id']; ?>" <?php echo set_select('user_type', $users['role_id']); ?> <?php if($users['role_id']==$r_data) {echo "selected='selected'"; }  ?>><?php echo $users['role_name']; ?></option>
						<?php
							}
						}
					
					?>
					</select>
				
					<span style="color:red;margin-top:10px !important;" ><?php echo form_error('user_type'); ?></span>
				 </div>
				  
				
				
				  <div class="form-group col-xs-12 col-sm-6 col-md-6 pull-right mt25"><a href="<?php echo base_url().'bookmyt/users/'; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a>
				  <input name="sub" type="submit" onclick="return validate()" class="btn btn-success pull-right" value="Update"></div>				  
				  
				</form>
			<?php
				}
			?>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
<script type="text/javascript">
	 
	function validate()
	{
		var business = $("#business_id").val();
		var uname = $("#username").val();
		var email = $("#email_chk").val();	
		var user_type = $("#user_type").val();	
		var error = [];
		if(business == '')
		{
			error.push('e1');
		}
		if(uname == '')
		{
			error.push('e2');
		}
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(email == "")
		{
			error.push('e3');
		}
		else
		{
			if(isNaN(email)){
				if(!filter.test(email))
				{
					error.push('e3');
				}
			}
		}
		if(user_type == "")
		{
			error.push('e4');
		}
		
		if(error.length != 0)
		{
			if($.inArray("e1", error) !== -1){ $("[data-id='business_id']").addClass('error'); } else { $("[data-id='business_id']").removeClass('error'); }
			if($.inArray("e2", error) !== -1){ $("#username").addClass('error');} else {$("#username").removeClass('error'); }
			if($.inArray("e3", error) !== -1){ $("#email_chk").addClass('error');} else { $("#email_chk").removeClass('error'); }
			if($.inArray("e4", error) !== -1){ $("[data-id='user_type']").addClass('error'); } else { $("[data-id='user_type']").removeClass('error'); }
			return false;
		}
		else
		{
			$("[data-id='business_id']").removeClass('error'); 
			$("#username").removeClass('error');
			$("#email_chk").removeClass('error');
			$('input[data-id=user_type]').removeClass('error');
		}
		
	}
		
	$("#business_id,#username,#email_chk,#user_type").change(function()
	{
		if($("#business_id").val() != "")
		{
			$("[data-id='business_id']").removeClass('error');
		}
		if($("#username").val() != "")
		{
			$("#username").removeClass('error'); 
		}
		if($("#email_chk").val() != "")
		{
			$("#email_chk").removeClass('error'); 
		}
		if($("#user_type").val() != "")
		{
			$('input[data-id=user_type]').removeClass('error');
		}
	});
	



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
         
