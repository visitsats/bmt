
 <div style="margin-top:100px"></div>
    <div class="container">
   
    	<div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 tab">
        
      <center>
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
	</center>
       <form name="" method="post" class="form" action="<?php echo base_url()."bookmyt/edit_table/"; ?>">
	   <input type="hidden" name="table_id" value="<?php echo $this->session->userdata('business_id');?>" />
	   
		 <div class="clearfix"></div>
		 	 <div class="form-group">
		 
                 <select  placeholder="Select Your Floor" class="form-control"  name="floor_id" required>
				<option value="">Select Your Floor</option>
					<?php
					if(isset($floors) && !empty($floors))
					{
						foreach($floors as $type)
						{
					?>
						<option value="<?php echo $type['floor_id']; ?>" <?php  if($type['floor_id']==$userdata['floor_id']) { echo 'selected=selected';} ?> ><?php echo $type['floor_no']; ?></option>
					<?php
						}
					}
					?>
				 </select>
				 </div>
		 <div class="form-group">
		  <input type="text" name="table_no" maxlength="4" value="<?php echo $userdata['table_no'];?>" placeholder="Your table" class="form-control"/>
              
				 </div>
		
		
			<div class="form-group">	 
				
				 <input type="text" placeholder="No of Seats" maxlength="2" value="<?php echo $userdata['no_of_seats'];?>" class="form-control"   name="no_of_seats" required>
                   </div>
		 
		 <div class="form-group">
                <input type="submit" name="sub"  class="btn btn-primary  btn-lg pull-right" value="Save"  >
               <div>
          </form>        
        </div>
       
    </div>
        </div>
        
       </div> 
