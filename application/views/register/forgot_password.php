<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Forgot Password</h4>
		 
          <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
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
   <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
            <div class="panelone  plr10">
			<form name="" method="post" class="wrap mt15" action="<?php echo base_url()."bookmyt/forgot_password/"; ?>">
            
				<div class="form-group col-md-8">
					<label class="form-lable ">Your Email Id / Phone Number<span class="star">*</span></label>
					<input type="text" placeholder="" class="form-control " maxlength="40" value="<?php echo set_value('email'); ?>" name="email" id="email">
					<span style="color:red"><?php echo form_error('email'); ?></span>				   
				</div>
				
					 <div class="form-group col-md-3"><a href="<?php echo base_url(); ?>" class="btn btn-success pull-right mt25" style="margin-left:5px">Cancel</a>
				  <button type="submit" name="sub" onclick="return fun()" class="btn btn-success pull-right mt25">Check</button> </div>
				  
			</form>
						
            </div>
          </div>
        </div>
		</div>
    </div>
  </div>
  
<script>
	function fun()
	{
		if($("#email").val() == "")
		{
			$("#email").addClass('error');
			return false;
		}
		else
		{
			$("#email").removeClass('error');
		}
	}
</script>