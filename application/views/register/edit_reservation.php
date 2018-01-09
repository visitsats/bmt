 
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
       <form name="" method="post" class="form" action="<?php echo base_url()."bookmyt/edit_reservation/"; ?>">
	   <input type="hidden" name="reservation_id" value="<?php echo $userdata['reservation_id'];?>" />
	 
		  <div class="form-group">
		 
                <select  placeholder="Select Country" class="form-control" id="floor" name="floor" required>
				 <option value="">Select Floor</option>
					<?php
					if(isset($floors) && !empty($floors))
					{
						foreach($floors->floors_list as $floors1)
						{
						
					?>
						<option value="<?php echo $floors1->floor_id; ?>"  <?php  if($floors1->floor_id==$userdata['floor']) { echo 'selected=selected';} ?>><?php echo $floors1->floor_no; ?></option>
					<?php
						}
					}
					?>
				 </select>
                     </div>
	
				<div class="form-group">	 

				<input type="text" placeholder="Enter No of members" maxlength="3" value="<?php echo $userdata['table_for'];?>" class="form-control"   name="table_for" required id="select_no_of_members">
				</div>
				<div class="form-group">	 
<input type="text" placeholder="" value="<?php echo $userdata['table_id'];?>" class="form-control"   name="table_id" required id="sub_cat_data">
			
				</div>
                  <div class="form-group">	 

				<input type="text" placeholder="Your Name" maxlength="25" value="<?php echo $userdata['name'];?>" class="form-control"   name="name" required >
				</div>
		  <div class="form-group">	 

				<input type="text" placeholder="Your Phone" maxlength="13" class="form-control"   name="phone_no" required value="<?php echo $userdata['phone_no'];?>">
				</div>
				  <div class="form-group">	 

				<input type="text" placeholder="Your In Time" class="form-control"   name="in_time" required value="<?php echo $userdata['in_time'];?>">
				</div>
				  <div class="form-group">	 

				<input type="text" placeholder="Your Out Time" class="form-control"   name="out_time" required value="<?php echo $userdata['out_time'];?>">
				</div>
				
			<div class="form-group">
                <input type="submit" name="sub"   class="btn btn-success pull-right" value="Save"  >
               <div>
          </form>        
        </div>
       
    </div>
        </div>
        
       </div> 
        
