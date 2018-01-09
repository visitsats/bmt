  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 <?php if(isset($perms) && !empty($perms->users)) { if($perms->users->add == 0) { echo "style='display:none'"; } }
			?>>Users</h4>
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
			<center><span style="color:red;font-weight:bold"><?php echo form_error('email_phn'); ?></span></center>
        <div class="wrap mnone">
		
		<!-- Add users form starts here -->
          <div class="col-xs-12"> 
           <!--  <div class="panelone  plr10"> -->
			<center><span style="color:red;font-weight:bold" id="email_err"></span></center>
			<div <?php if(isset($perms) && !empty($perms->users)) { if($perms->users->add == 0) { echo "style='display:none'"; } }
			?> >
            <form name="" method="post" role="form" class="wrap mnone" action="">
			
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
						  <div class="form-group col-sm-4 col-md-3">
						  <label class="form-lable ">Select  Branch<span class="star">*</span></label>
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
					
							if(count($branches)>=1){
								$branch=$branches[0]['business_id'];
							}else{
								$branch=$branches[0]['relationship_id'];
							}

					?>	
					<input type="hidden" class="form-control" value="<?php echo $branch;?>" name="business_admin" id="business_id">	   
				   <div class="form-group col-xs-12 <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-3"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-3"; } else { echo "col-sm-4"; } } ?> <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-md-4"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-md-3"; } else {echo "col-md-3"; } } ?>"> 
				    <label class="form-lable ">Name<span class="star">*</span></label>
						<input type="text" placeholder="" class="form-control" value="<?php echo set_value('username'); ?>" name="username" id="username" maxlength="25" >
						<span style="color:red"></span>
				   </div>
				  
				  <div class="form-group col-xs-12 <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-3"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-3"; } else { echo "col-sm-4"; } } ?> <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-md-3"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-md-3"; }else { echo "col-md-2"; }  } ?>"> 
				   <label class="form-lable ">Email/Phone number<span class="star">*</span></label>
					 <input type="text" placeholder="" class="form-control"  value="<?php echo set_value('email_phn'); ?>"  name="email_phn" id="email_chk" maxlength="50">
					 <span style="color:red"></span>
				  </div>
				 
				 <div class="form-group col-xs-12 <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-3"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-3"; } else { echo "col-sm-4"; } } ?> <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-md-3"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-md-3"; }else { echo "col-md-2"; }  } ?>">
					<label class="form-lable ">User type<span class="star">*</span></label>
					<select class="selectpicker"  name="user_type" id="user_type">
					<option value="" style="display:none;">Select  User Type</option>
					<?php
					if($this->session->userdata('user_type_id'))
					{
						$gt = $this->session->userdata('user_type_id');
						if($gt == '2')
						{
					?>
						<option value="3" <?php echo set_select('user_type',3); ?>>Conserver/Manager</option>
						<option value="4" <?php echo set_select('user_type',4); ?>>Waiter/Server</option>
					<?php
						}
						else if($gt == '3')
						{
					?>
						<option value="4" <?php echo set_select('user_type',4); ?>>Waiter/Server</option>
					<?php
						}
					}
					else
					{
						foreach($roles as $users)
						{
					?>
						<option value="<?php echo $users['role_id']; ?>" <?php echo set_select('user_type', $users['role_id']); ?>><?php echo $users['role_name']; ?></option>
					<?php
						}
					}
					
				
					?>
					</select>
				
					<span style="color:red;margin-top:10px !important;" ></span>
				 </div>
					
				<?php
					if(isset($perms) && !empty($perms->users))
					{
						if($perms->users->add == 0)
						{
						}
						else
						{
				?>
							<div class="form-group col-xs-12 <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-3"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-3"; } else { echo "col-sm-4"; } } ?> <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-md-2"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-md-2"; }else { echo "col-md-2"; }  } ?> mt30 text-right-xs">
							
						  <button type="submit" id="submit" name="sub" onclick="return validate()" class="btn btn-success btn-xss" style="margin-left:6px" >Add User</button> <a href="" class="btn btn-success btn-xss" style="margin-left:6px">Clear</a> 
						  
						  </div>
				<?php
							
						}
					}
					else
					{
				?>
				  <div class="form-group <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-sm-3"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-sm-3"; } else { echo "col-sm-4"; } } ?> col-xs-12 <?php if($this->session->userdata('branch') == "1" || $this->session->userdata('user_id') != '') { echo "col-md-2"; } else { if($this->session->userdata('have_branches') == '0') { echo "col-md-2"; }else { echo "col-md-2"; }  } ?> mt30 text-right-xs"><button type="submit" id="submit" name="sub" onclick="return validate()" class="btn btn-success btn-xss " style="margin-left:6px" >Add User</button><a href="" style="margin-left:6px" class="btn btn-success btn-xss">Clear</a> 
				  
				  
				  </div>
				<?php
					}
				?> 
				  
				  
				  
				</form>
				</div>
							
              
           <!-- </div> -->
          </div>
        </div>
		<!-- Add users form ends here --><div class="clearfix"></div>
		<h4 class="mt15">Users Information</h4>
		<!-- Users list starts from here -->
            <div class="wrap mnone">
			<div class="table-responsive">
              <table class="table table-style-one table-striped" >
                <thead>
                  <tr>
                    <th>Branch Name</th>
					<th>User Name</th>
                    <th>Email / Phone Number</th>
					 <th>User Type</th>
                    <?php
					  if(isset($perms) && !empty($perms->users))
						{
							if($perms->users->edit == 0 && $perms->users->delete == 0)
							{
					?>
						<th class="pull-right">&nbsp;</th>
					<?php
							}
							else
							{
					?>
						 <th class="pull-right">Actions</th>
					<?php
							}
						}
						else
						{
					?>
                      <th class="pull-right">Actions</th>
					 <?php
						}
					?>
                  </tr>
                </thead>
                <tbody>
				<?php
				
				if(is_array($vusers->users_list) && !empty($vusers->users_list))
				{
					foreach($vusers->users_list as $user)
					{		
						if($user->user_id == $this->session->userdata('user_id'))
						{
						}
						else
						{
				  ?>
                    <tr>
                      <td>
					  <?php
						foreach($branch_name as $bname)
						{
							if($user->business_id == $bname['business_id'])
							{
								echo $bname['business_name'];
							}
						}
					?></td>
                      <td><?php echo $user->username; ?></td>
                      <td><?php echo (isset($user->email) && $user->email!="")?$user->email:$user->phone_no; ?></td>
					   <td><?php echo $user->role_name; ?></td>
					  <td>
						<div 
						<?php
							if(isset($perms) && !empty($perms->users))
							{
								if($perms->users->edit == 0 && $perms->users->delete == 0)
								{
								}
								else
								{
									echo "class='action black'>";
								}
							}
							else
							{
								echo "class='action black'>";
							}
					
						
							if(isset($perms) && !empty($perms->users))
							{
								if($perms->users->edit == 0)
								{
								}
								else
								{
						?>	  
							<a href="<?php echo base_url()."bookmyt/edit_user/".$user->user_id; ?>" class="edit-sm-icon" title="Edit"></a>
						<?php
								
								}
							}
							else
							{
						?>
							<a href="<?php echo base_url()."bookmyt/edit_user/".$user->user_id; ?>" class="edit-sm-icon" title="Edit"></a>
						<?php
							}
						?>
					  
					  <?php
							if(isset($perms) && !empty($perms->users))
							{
								if($perms->users->delete == 0)
								{
								}
								else
								{
						?>	  <span class="divider"></span> 
							<a href="<?php echo base_url()."bookmyt/delete_user/".$user->user_id;?>" onclick = "if(confirm('Are you sure to delete (<?php echo $user->username; ?>)')) { return true; } else {return false; }" class="delete-sm-icon" title="Delete"></a>
					  
						<?php
								
								}
							}
							else
							{
						?>	<span class="divider"></span> 				  
						  <a href="<?php echo base_url()."bookmyt/delete_user/".$user->user_id;?>" onclick = "if(confirm('Are you sure to delete (<?php echo $user->username; ?>)')) { return true; } else {return false; }" class="delete-sm-icon" title="Delete"></a>
						 <?php
							}
						?>
						</div>					  
					  
					  </td>

                    </tr>
					<?php
						}
					}
				}
				else
				{
				?>
					<tr><td colspan="4" class="text-center"><span style="color:red">No Records Found.</span></td></tr>
				<?php
				}
				?>
            
                </tbody>
              </table>
			 </div>
            </div>
			
		<!-- Users list ends here -->
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
		else if(isNaN(email))
		{
			if(!filter.test(email))
			{
				error.push('e3');
			}
		}else if(!isNaN(email) && email.length!=10){
			error.push('e3');
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
			$('[data-id=user_type]').removeClass('error');
			error = [];
		}
		
	}
	
		
	
	$("#business_id,#username,#email_chk,#user_type").change(function()
	{
		if($("#business_id").val() != '')
		{
			$("#business_id").removeClass('error'); 
		}
		if($("#username").val() != '')
		{
			$("#username").removeClass('error');
		}
		
		if($("#email_chk").val() != "")
		{
			$("#email_chk").removeClass('error');
		}
		if($("#user_type").val() != "")
		{
			$('[data-id=user_type]').removeClass('error');
		}
	});
	
	

	//$("#fo").fadeOut(2000);
	$(document).ready(function()
	{
		$("#username").change(function()
		{
			if($.isNumeric($("#username").val()))
			{
					$('#email_err').html("Username sholud not be numbers.");
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
					$('#email_err').html("Email or Phone Number already registered for business try another.");
					$("#submit").attr("disabled","disabled");
					return false;
				}
				else
				{
					$('#email_err').html("");
					$("#submit").removeAttr("disabled");
				}
			});
		});
	});
  </script>
 

