<?php
if(count($business_info) != 0){
?>						
<script type="text/javascript">
			$(document).ready( function() {
				$('#example').dataTable( {
					"bJQueryUI": true,
			         "aoColumnDefs": [{'bSortable': false, 'aTargets': [ 4] }], 
					"sPaginationType": "full_numbers",
					"aaSorting": [[ 0, 'desc' ]]
		 
				} );
			} );
	</script>
<?php } ?>	
  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4><a href="<?php echo base_url();?>bookmyt/admin_dashboard">Dashboard</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo base_url();?>bookmyt/request_demo_list">Request demo List</a></h4>
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
			
        <div class="wrap mnone">
		
		<!-- Add users form starts here -->
          <div class="clearfix"></div>
		<!-- <h4 class="mt15">Business Information</h4> -->
		<!-- Users list starts from here -->
            <div class="wrap mnone">
			<div class="table-responsive">
              <table class="table table-style-one table-striped"  id="example">
                <thead>
                  <tr>
				  	<th width="13%">Request Id</th>
					<th>Name</th>
                    <th>Email</th>
					<th>Phone</th>
                    <th>Request Date</th>
					<th>Contact Type</th>
                    				 
                  </tr>
                </thead>
                <tbody>
					<?php
						if(count($business_info) != 0)
						{
							foreach($business_info as $business)
							{
					?>
                    <tr>
					 <td><?php echo $business['request_id']; ?></td>
                      <td><?php echo $business['name']; ?></td>
					  <td><?php echo $business['email']; ?></td>
					  <td><?php echo $business['mobile']; ?></td>
					    <td><?php $date1=date_create($business['added_date']); echo date_format($date1,"d-M-Y"); ?></td>
					  <td><?php echo $business['contact_type']; ?></td>
                    
				

                    </tr>
						<?php
							}
						}
						else
						{
						?>
							<tr><td colspan="7" class="text-center"><span style="color:red">No Records Found.</span></td></tr>
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
