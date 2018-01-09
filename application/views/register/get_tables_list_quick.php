<label class="form-lable ">Select Table Number<span class="star">*</span></label>	
<select  id="sub_cat_data1<?php echo $no_of_k;?>" multiple="multiple"  placeholder="Select Your Table Number" class="selectpicker"   name="table_id" required>
	<!--<option value="" style="display:none;">Select Your Table Number</option>-->
			
	<?php
	if(!empty($test)){
	foreach($test as $test1)
	{
		if($test1['table_no'] != "" && $test1['available_status']==1)
		{		
	?>
	
	<option value="<?php echo trim($test1['table_id']).'_'.trim($test1['section_id']);?>" <?php echo ($table_id == $test1['table_id']) ? 'selected="selected"': ''?>><?php echo $test1['section_name']; ?> TB - <?php echo trim($test1['table_no']); ?> , Seating Capacity - <?php echo trim($test1['no_of_seats']); ?>, Type - <?php echo ucwords(trim($test1['table_type'])); ?> </option>

	<?php
		}
	}
	}else{
		echo '<option value="">No Tables are available</option>';
	}
	?>	</select>
<script>
$('.selectpicker').selectpicker();
</script>