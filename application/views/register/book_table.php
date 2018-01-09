
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
       <form name="" method="post" class="form" action="<?php echo base_url()."bookmyt/reservation/"; ?>">
	   <input type="hidden" name="relationship_id" value="<?php echo $this->session->userdata('business_id');?>" />
	 
		  <div class="form-group">
		 
                <select  placeholder="Select Country" class="form-control" id="floor" name="floor" required>
				 <option value="">Select Floor</option>
					<?php
					if(isset($floors) && !empty($floors))
					{
						foreach($floors->floors_list as $floors1)
						{
						
					?>
						<option value="<?php echo $floors1->floor_id; ?>" ><?php echo $floors1->floor_no; ?></option>
					<?php
						}
					}
					?>
				 </select>
                     </div>
	
				<div class="form-group">	 

				<input type="text" placeholder="No of members" class="form-control"   name="table_for" required id="select_no_of_members">
				</div>
				<div class="form-group">	 

				<select  id="sub_cat_data"  placeholder="Select Your Table Number" class="form-control"   name="table_id" required>
				<option value="">Select Your Table Number</option>
				</select>
				</div>
                  <div class="form-group">	 

				<input type="text" placeholder="Your Name" class="form-control"   name="name" required >
				</div>
		  <div class="form-group">	 

				<input type="text" placeholder="Your Phone" class="form-control"   name="phone_no" required >
				</div>
				  <div class="form-group">	 

				<input type="text" placeholder="Your In Time" class="form-control"   name="in_time" required >
				</div>
				  <div class="form-group">	 

				<input type="text" placeholder="Your Out Time" class="form-control"   name="out_time" required >
				</div>
				
		 <div class="form-group">
                <input type="submit" name="sub"  class="btn btn-primary  btn-lg pull-right" value="Save"  >
               <div>
          </form>        
        </div>
       
    </div>
        </div>
        
       </div> 

