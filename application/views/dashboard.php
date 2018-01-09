<script type="text/javascript">
			$(document).ready( function() {
				$('#example').dataTable( {
					"bJQueryUI": true,
			         "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 7] }], 
					"sPaginationType": "full_numbers",
					"aaSorting": [[ 0, 'desc' ]]
		 
				} );
			} );
	</script>
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
              <table class="table table-style-one table-striped" id="example">
                <thead>
                  <tr>
					<th width="5%">ID</th>
                    <th width="8%">Reg date</th>
					<th width="10%">Reg time</th>
                    <th width="14%">Business name</th>
					<th width="23%">Business email/Phone Number</th>
                    <th width="10%">Sub Type</th>
					<th width="10%">Sub Start</th>
					<th width="8%">Sub End</th>
					<th width="12%">Actions</th>					 
                  </tr>
                </thead>
                <tbody>
					<?php
						if(count($business_info) != 0)
						{
							foreach($business_info as $business)
							{
								$sub_type="--";
								if($business['subscription_type']==1){
									$sub_type="Free";
								}else if($business['subscription_type']==2){
									$sub_type="Individual Monthly";
								}else if($business['subscription_type']==3){
									$sub_type="Individual Annual";
								}else if($business['subscription_type']==4){
									$sub_type="Multiple Monthly";
								}else if($business['subscription_type']==5){
									$sub_type="Multiple Annual";
								}
					?>
                    <tr>
                      <td><?php echo $business['business_id']; ?></td>
                      <td><?php $date1=date_create($business['created_ts']); echo date_format($date1,"d-M-Y"); ?></td>
					   <td><?php $date2=date_create($business['created_ts']); echo date_format($date2,"h:i A"); ?></td>
					  <td><?php echo $business['business_name']; ?></td>
                      <td><?php echo ($business['business_email']!="")?$business['business_email']:$business['phone_no']; ?></td>
                      <td><?php echo $sub_type; ?></td>
					  <td><?php echo (isset($business['substart']) && $business['substart']!="")?date('d-M-Y',strtotime($business['substart'])):date('d-M-Y',strtotime($business['created_ts'])); ?> </td>
					  <td><?php /*if($business['is_active'] == 1) {  $effectiveDate = date("Y-m-d");$sub_date=(isset($business['subscription_type']) && $business['subscription_type']!="0")?$business['subscription_type']:"3"; $effectiveDate = strtotime("+".$sub_date." months", strtotime($business['substart'])); echo (isset($business['substart']) && $business['substart']!="")?date('d-M-Y',$effectiveDate):""; }*/ echo date("d-M-Y",strtotime($business['subscription_end_dt'])); ?></td>
					  <td align="center">
					    <div class="done" style="text-align:center;">
						<?php
							if($business['is_active'] == 0)
							{
						?>
							<a href="#" id="my-modal_<?php echo $business['business_id']; ?>" class="" data-toggle="modal" data-target="#deactivate-modal_<?php echo $business['business_id']; ?>" data-id="<?php echo $business['business_id']; ?>" data-name="<?php echo $business['business_name']; ?>"><img src="<?php echo base_url().'/theme/images/star-deactive.png'; ?>" width="18" height="20" /></a>
						<?php
							}
							else if($business['is_active'] == 1)
							{
						?>
							
							<a href="#" class="" data-toggle="modal" data-target="#loginsuperadmin-modal_<?php echo $business['business_id']; ?>" data-id="<?php echo $business['business_id']; ?>"><i class="fa fa-eye" aria-hidden="true" style="color:red; font-size:20px;"></i></a>
							<a href="<?php echo base_url()."bookmyt/validate_business/".$business['business_id']; ?>" class=""  onclick = "if(confirm('Are you sure you want to in-active (<?php echo $business['business_name']; ?>)')) { return true; } else {return false; }" ><img src="<?php echo base_url().'/theme/images/star-active.png'; ?>" width="18" height="20" /></a>
						<?php
							}
							else
							{
							}
						?>
						<a href="<?php echo base_url('bookmyt/business_report/').'/'.$business['business_id']; ?>" class="" ><i class="fa fa-info-circle" aria-hidden="true" style="color:red; font-size:20px;"></i></a>
						<a href="<?php echo base_url('bookmyt/editBusinessEntity').'/'.$business['business_id']; ?>" style="padding-left:5px;"><img src="<?php echo base_url().'/theme/images/edit.png'; ?>" width="18" height="20" /></a>
						</div>	
											
					  </td>
					  
					  <div class="modal fade" id="loginsuperadmin-modal_<?php echo $business['business_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header login_modal_header">
							<button type="button" class="close" id="close-login" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h3 class="modal-title" id="myModalLabel">Activation of Business</h3>
						  </div>
						  <div class="modal-body login-modal">
							<p>Verification Code</p>
							<form name="" action="<?php echo base_url()."bookmyt/validate_verification/".$business['business_id']; ?>" method="post">
								<input type="text" class="form-control" name="verification_code">
								</br>
								<input type="submit" name="submit" value="Submit" class="btn" style="float:right" />
							</form>
							<div class="clearfix"></div>
						  </div>
						  <div class="clearfix"></div>
						  <div class="modal-footer login_modal_footer"> </div>
						</div>
					  </div>
					</div>
					  <div class="modal fade" id="deactivate-modal_<?php echo $business['business_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header login_modal_header">
								<button type="button" class="close" id="close-login" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h3 class="modal-title" id="myModalLabel">Activation of Business</h3>
							  </div>
							  <div class="modal-body login-modal">
							   <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text eve</p> -->
								<p>Are you sure you want to activate <strong><?php echo $business['business_name']; ?></strong> for</p>
								<form name="" action="<?php echo base_url()."bookmyt/validate_business/".$business['business_id']; ?>" method="post">
									<select class="form-control" name="subscription">
										<option value="3">3 Months</option>
										<option value="6">6 Months</option>
										<option value="12">12 Months</option>
									</select></br>
									<input type="submit" name="submit" value="Submit" class="btn" style="float:right" />
								</form>
								<div class="clearfix"></div>
								
								<div class="clearfix"></div>
							  </div>
							  <div class="clearfix"></div>
							  <div class="modal-footer login_modal_footer"> </div>
							</div>
						  </div>
						</div>
						
						
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
			  <a type="submit" name="sub" href="<?php echo base_url().'bookmyt/export/'; ?>" class="btn btn-success btn-xss" style="margin-left:6px" >Export</a> 
            </div>
			
		<!-- Users list ends here -->
          </div>
        </div>
      </div>
    </div>
  </div>
