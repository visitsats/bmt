<?php
if(count($results) != 0)
{
?>							
<script type="text/javascript">
$(document).ready( function() {
	$('#example').dataTable( {
		"bJQueryUI": true,
		 "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 5] }], 
		"sPaginationType": "full_numbers",
		"aaSorting": [[ 0, 'desc' ]]

	} );
});
</script>
<?php
	}
?>
<div class="wrap mnone">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h4><a href="<?php echo base_url();?>bookmyt/reports">Back to Reports</a></h4>
				<h4 class="text-center">Detailed Report</h4>
				<div style="margin:20px;">
					<form name="date" method="post" action="<?php echo base_url('bookmyt/detailed_report'); ?>">
						<label>From Date : </label>
						<input type="text" name="from_date" id="from_date" value="<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];} ?>">
						<label>To Date : </label>
						<input type="text" name="to_date" id="to_date" value="<?php if(isset($_POST['to_date'])){echo $_POST['to_date'];} ?>">
						<input type="submit" name="submit" value="Submit" class="btn btn-success btn-xss" />
					</form>
				</div>
				<div class="table-responsive">
				  <table class="table table-style-one table-striped" id="example">
					<thead>
					  <tr>
						<th width="16%">Name</th>			
						<th width="15%">Phone</th>		
						<th width="8%">Favourite Day</th>
						<th width="14%">Customer Type</th>						
						<th width="10%">Visit Count</th>                   					 
					  </tr>
					</thead>
					<tbody>
						<?php
							if(count($results) != 0)
							{
								foreach($results as $result)
								{
									//$steward=($feeback['steward']!="0")?$feeback['steward']:"";
						?>
						<tr>
							<td><?php echo $result['customer_name']; ?></td>
							<td><?php echo $result['phone_no']; ?></td>                 
							<td><?php echo ($result['dob']!="")?date('d-M',strtotime($result['dob'])):''; ?></td>
							<td><?php echo ($result['is_vip']==1)?'<img src="'.base_url().'theme/images/vip.png" width="22" style="padding-top:8px;">':"";echo ($result['is_star_customer']==1)?'<img src="'.base_url().'theme/images/star-d.png" width="22" style="padding-top:8px;">':""; ?></td>							
							<td><?php echo $result['visit_count']; ?></td>
						</tr>
							<?php
								}
							}
							else
							{
							?>
								<tr><td colspan="9" class="text-center"><span style="color:red">No Records Found.</span></td></tr>
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
<script type="text/javascript">
$(document).ready(function(){
	$('#from_date').datetimepicker({
				timepicker:false,
				format:'d-M-Y',
				formatDate:'d-m-Y'
			});
	$('#to_date').datetimepicker({
				timepicker:false,
				format:'d-M-Y',
				formatDate:'d-m-Y'
			});
		
});
</script>