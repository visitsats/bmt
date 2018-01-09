
  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Floors</h4>
          <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div>
		<div class='clearfix'></div>
			<?php			
				if($this->session->flashdata('success'))
				{
			?>			
				<div class='alert alert-success text-center' id='ss_fo'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> 
				<strong><?php echo $this->session->flashdata('success'); ?></strong> </div>		
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
        <div class="wrap mnone">
          <div class="col-md-8 col-md-offset-2"> 
		   <?php
			if(isset($perms) && !empty($perms->floor))
			{
				if($perms->floor->add == 0)
				{
				}
				else
				{
		?>
					 <div class="wrap mnone text-right text-center-xs">
              <a href="<?php echo base_url()."bookmyt/add_floor/"; ?>" class="btn btn-success icon-btn"> <i class="fa fa-plus-circle"></i> Add Floor</a>
              </div>
		<?php
					
				}
			}
			else
			{
		?>
          <div class="wrap mnone text-right text-center-xs">
              <a href="<?php echo base_url()."bookmyt/add_floor/"; ?>" class="btn btn-success icon-btn"> <i class="fa fa-plus-circle"></i> Add Floor</a>
              </div>
		<?php
			}
		?>
              
          <div class="mt10"></div>
		  
            <div class="wrap table-responsive">
              <table class="table table-style-two " >
			  <thead>
			   <tr>
					<th  >Floor Name</th>
					<th>No Of Sections</th>
					<th ><?php if($this->session->userdata('have_branches') == 'No') { echo 'Business'; } else { echo "Branch Name"; } ?></th>
					<?php
					  if(isset($perms) && !empty($perms->floor))
						{
							if($perms->floor->edit == 0 && $perms->floor->delete == 0)
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
				  //pr($floors);
				  if(count($floors) != '0')
				  {
				  foreach($floors as $branch)
				  {
				 
				  ?>
                  <tr>
                    <td class="floor"><a href="<?php echo base_url('bookmyt/section_list').'/'.$branch['floor_id']; ?>"><?php echo $branch['floor_no'];?></a></td>
                    <td class="section"><?php echo $branch['no_of_sections'];?> Sections</td>
					<td class="branch"><?php echo $branch['branch'];?></td>
                    <td>
					
					<div 
						<?php
							if(isset($perms) && !empty($perms->floor))
							{
								if($perms->floor->edit == 0 && $perms->floor->delete == 0)
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
						
							if(isset($perms) && !empty($perms->floor))
							{
								if($perms->floor->edit == 0)
								{
								}
								else
								{
						?>
							<a href="<?php echo base_url()."bookmyt/section_list/".$branch['floor_id']; ?>" title="Sections"><img src="<?php echo base_url(); ?>images/sections_icon.png" /></a>
							<span class="divider"></span> 	  
							<a href="<?php echo base_url()."bookmyt/edit_floor/".$branch['floor_id']; ?>" class="edit-sm-icon" title="Edit"></a> 
						<?php
								
								}
							}
							else
							{
						?>
							<a href="<?php echo base_url()."bookmyt/section_list/".$branch['floor_id']; ?>" class="edit-section-icon" title="Sections"></a>
							<span class="divider"></span> 
							<a href="<?php echo base_url()."bookmyt/edit_floor/".$branch['floor_id']; ?>" class="edit-sm-icon" title="Edit"></a> 
						<?php
							}
						
							if(isset($perms) && !empty($perms->floor))
							{
								if($perms->floor->delete == 0)
								{
								}
								else
								{
						?>	  
							<span class="divider"></span> 
							<a onclick = "if(confirm('Are you sure you want to Delete (<?php echo $branch['floor_no']; ?>)')) { return true; } else {return false; }" href="<?php echo base_url()."bookmyt/delete_floor/".$branch['floor_id'];?>" class="delete-sm-icon" title="Delete"></a>
					  
						<?php
								
								}
							}
							else
							{
						?>	
							<span class="divider"></span> 
						  <a onclick = "if(confirm('Are you sure you want to Delete (<?php echo $branch['floor_no']; ?>)')) { return true; } else {return false; }" href="<?php echo base_url()."bookmyt/delete_floor/".$branch['floor_id'];?>" class="delete-sm-icon" title="Delete"></a>
						 <?php
							}
						?>
						</div>					  
					  
					  </td>
                  </tr>
                  <?php
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
			  <p style="color:#FF0000;">Note : Please click on Floor name for manage sections.</p>
			 
			  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
	//$("#ss_fo").fadeOut(2000)
  </script>
   