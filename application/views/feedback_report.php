<div class="wrap mnone">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h4><a href="<?php echo base_url();?>bookmyt/reports">Back to Dashboard</a></h4>
				<h4 class="text-center">Feedback Report</h4>
				<div class="table-responsive">
				  <table class="table table-style-one table-striped" id="example">
					<thead>
					  <tr>
						<th width="16%">Customer Details</th>			
						<th width="15%">Billing Details</th>		
						<th width="8%">Feedback on Food</th>
						<th width="8%">Feedback on Service</th>
						<th width="10%">Special Remarks</th>                   					 
					  </tr>
					</thead>
					<tbody>
						<?php
							if(count($feedback_report) != 0)
							{
								foreach($feedback_report as $feeback)
								{
									$steward=($feeback['steward']!="0")?$feeback['steward']:"";
						?>
						<tr>
							<td><?php echo "Name :".$feeback['name']."</br>Mobile No. :".$feeback['phone_no']."</br>Dining :".$feeback['type_of_dining']; ?></td>             			<td><?php echo "Bill No. :".$feeback['bill_no']."</br>Bill Amount :".$feeback['bill_amount']."</br>Steward :".$steward; ?></td>                 
							<td><?php 
							$feed_on_food=json_decode($feeback['feedback_on_food']);
							//echo $feeback['feedback_on_food'];pr($feed_on_food);
							echo "Quality : ".$feed_on_food->quality."</br>Presentation : ".$feed_on_food->presentation."</br>Taste : ".$feed_on_food->taste;
						   ?></td>
						   <td><?php 
							//echo $feeback['feedback_on_service'];
							$feedback_on_service=json_decode($feeback['feedback_on_service']);
							//pr($feedback_on_service);
						   echo "Promptness : ".$feedback_on_service->promptness."</br>Courtesy : ".$feedback_on_service->courtesy."</br>Competence : ".$feedback_on_service->competence; ?></td>
						 
						  <td><?php echo ($feeback['special_remarks']!="")?$feeback['special_remarks']:''; ?></td>
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
		  