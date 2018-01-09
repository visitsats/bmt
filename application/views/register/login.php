
    <div class="wrap m-none section-two">
    <div class="container">
   
    	<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 tab">
        
     <?php
		if($this->session->flashdata('msg') && $this->session->flashdata('msg') != '')
		{
			echo "<span style='color:red'>".$this->session->flashdata('msg')."</span>";
		}
		
	?>
       <form name="" method="post" class="form" action="<?php echo base_url()."bookmyt/login_action/"; ?>">
		 <div class="form-group">	 
				
				 <input type="email" placeholder="Your Email Id" class="form-control"   name="business_email" required>
                   </div>
		 <div class="form-group">
                 <input type="password" placeholder="Your password" class="form-control"   name="password" required>
                   </div>
		
		 <div class="form-group">
                <input type="submit" name="submit"  class="btn btn-primary  btn-lg pull-right" value="Login"  >
               <div>
          </form>        
        </div>
       
    </div>
        </div>
        
       </div> 
        
