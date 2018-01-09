<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Change Password</h4>
		 
          <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div>
		  <div class="clearfix"></div>
			
			<?php			
				if($this->session->flashdata('success'))
				{
			?>			
				<div class='alert alert-success text-center' > <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('success'); ?></strong></div>		
			<?php
				}
				if($this->session->flashdata('fail'))
				{
			?>
				<div class='alert alert-danger text-center'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('fail'); ?></strong> </div>	
			<?php
				}
			?>
		 
        <div class="wrap">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
            <div class="panelone  plr10">
			<form name="" method="post" class="wrap mt15" action="<?php echo base_url()."bookmyt/change_password/".$bid; ?>">
            
				<div class="form-group col-md-4">
				<label class="form-lable ">Old Password<span class="star">*</span></label>
					<input type="password" placeholder=""  maxlength="15" class="form-control " value="<?php echo set_value('old_pwd'); ?>" name="old_pwd" id="old_pwd">
					<span style="color:red"><?php echo form_error('old_pwd'); ?></span>				   
				</div>
					 
				<div class="form-group col-md-4">
				<label class="form-lable ">New Password<span class="star">*</span></label>
					<input type="password" placeholder="" maxlength="15" class="form-control " value="<?php echo set_value('new_pwd'); ?>" name="new_pwd" id="new_pwd">
					<span style="color:red"><?php echo form_error('new_pwd'); ?></span>
				</div>
				   
				<div class="form-group col-md-4">
				<label class="form-lable ">Confirm New Password<span class="star">*</span></label>
					<input type="password" placeholder="" maxlength="15" class="form-control " value="<?php echo set_value('cnf_pwd'); ?>" name="cnf_pwd" id="cnf_pwd">
					<span style="color:red"><?php echo form_error('cnf_pwd'); ?></span>
				</div>
					 
					 <div class="form-group col-md-12">
					 <a href="<?php echo base_url().'bookmyt/reservation_list/'; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a>
				  <button type="submit" name="sub" onclick="return valid()" class="btn btn-success pull-right">Save Password</button> </div>
				  
				</form>
						
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<script>
	function valid()
	{
		var error = [];
		if($("#old_pwd").val() == "")
		{
			error.push('e1');
		}
		if($("#new_pwd").val() == "")
		{
			error.push('e2');
		}
		if($("#cnf_pwd").val() == "")
		{
			error.push('e3');
		}
		
		if(error.length != 0)
		{
			if($.inArray("e1", error) !== -1){ $("#old_pwd").addClass('error'); } else { $("#old_pwd").removeClass('error'); }
			if($.inArray("e2", error) !== -1){ $("#new_pwd").addClass('error'); } else { $("#new_pwd").removeClass('error'); }
			if($.inArray("e3", error) !== -1){ $("#cnf_pwd").addClass('error'); } else { $("#cnf_pwd").removeClass('error'); }
			return false;
		}
		else
		{
			 $("#old_pwd").removeClass('error');
			  $("#new_pwd").removeClass('error');
			   $("#cnf_pwd").removeClass('error');
			   error = [];
		}
		
		
	}
	
	$("#old_pwd,#new_pwd,#cnf_pwd").change(function()
		{
			if($("#old_pwd").val() != "")
			{
				 $("#old_pwd").removeClass('error');
			}
			if($("#new_pwd").val() != "")
			{
				$("#new_pwd").removeClass('error');
			}
			if($("#cnf_pwd").val() != "")
			{
				 $("#cnf_pwd").removeClass('error');
			}
		});
		
</script>