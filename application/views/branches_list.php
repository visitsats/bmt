  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Branches Details</h4>
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
				<?php
				// echo "<pre>";
					// print_r($perms);
				  // echo "</pre>"; exit;
				 ?>
        <div class="wrap">
		<?php
			if(isset($perms) && !empty($perms->branch))
			{
				if($perms->branch->add == 0)
				{
				}
				else
				{
		?>
					<div class="col-xs-12 text-right text-center-xs"> <a href="<?php echo base_url()."bookmyt/add_branch/"; ?>" class="btn btn-success icon-btn"> <i class="fa fa-plus-circle"></i> Add New Branch</a></div>
		<?php
					
				}
			}
			else
			{
		?>
          <div class="col-xs-12 text-right text-center-xs"> <a href="<?php echo base_url()."bookmyt/add_branch/"; ?>" class="btn btn-success  icon-btn"> <i class="fa fa-plus-circle"></i> Add New Branch</a></div>
		<?php
			}
		?>
            <div class="wrap mt15">			
			<div class="table-responsive">
              <table class="table table-style-one table-striped" >
                <thead>
                  <tr>
                     <th>Branch Name</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Phone</th>
					<?php
					  if(isset($perms) && !empty($perms->branch))
						{
							if($perms->branch->edit == 0 && $perms->branch->delete == 0)
							{
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
				if(count($branches->braches_list) != '0') 
				{
				  foreach($branches->braches_list as $branch)
				  {				 
				  ?>
                    <tr>
                      <td><?php echo $branch->business_name;?></td>
                      <td><?php echo $branch->business_email;?></td>
                      <td><?php echo $branch->address;?></td>
                      <td><?php echo $branch->phone_no;?></td>
						
					  <td>
					  <div 
						<?php
							if(isset($perms) && !empty($perms->branch))
							{
								if($perms->branch->edit == 0 && $perms->branch->delete == 0)
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
						
							if(isset($perms) && !empty($perms->branch))
							{
								if($perms->branch->edit == 0)
								{
								}
								else
								{
						?>	  
							<a href="<?php echo base_url()."bookmyt/edit_branch/".$branch->business_id; ?>" class="edit-sm-icon" title="Edit"></a>
						<?php
								
								}
							}
							else
							{
						?>
							<a href="<?php echo base_url()."bookmyt/edit_branch/".$branch->business_id; ?>" class="edit-sm-icon" title="Edit"></a>
						<?php
							}
						?>
					  <span class="divider"></span> 
					  <?php
							if(isset($perms) && !empty($perms->branch))
							{
								if($perms->branch->delete == 0)
								{
								}
								else
								{
									if($this->session->userdata('business_id')!=$branch->business_id){
						?>	  
							<a href="<?php echo base_url()."bookmyt/delete_branch/".$branch->business_id;?>" onclick = "if(confirm('Are you sure you want to Delete (<?php echo $branch->business_name ?>)')) { return true; } else {return false; }" class="delete-sm-icon" title="Delete"></a>
					  
						<?php
									}
								
								}
							}
							else
							{
								if($this->session->userdata('business_id')!=$branch->business_id){
						?>					  
						  <a href="<?php echo base_url()."bookmyt/delete_branch/".$branch->business_id;?>" onclick = "if(confirm('Are you sure you want to Delete (<?php echo $branch->business_name ?>)')) { return true; } else {return false; }" class="delete-sm-icon" title="Delete"></a>
						 <?php
						 		}
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
				<tr><td colspan="5" class="text-center"><span style="color:red">No Records Found.</span></td></tr>
				<?php
				}
					?>
				
                </tbody>
              </table>
			</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
	//$("#fo").fadeOut(2000);
</script>

