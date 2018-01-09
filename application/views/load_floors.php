    <label class="form-lable ">Select floor<span class="star">*</span></label>	 
	 <?php  echo ' <select  placeholder="Select Floor" class="selectpicker" id="floor" name="floor"  onchange="get_tables()" required>';
			//echo  '<option value="" style="display:none;">Select Floor</option>';
			if(!empty($ex_flr)){
				foreach($ex_flr as $data)
				{
					echo "<option value='".$data['floor_id']."'>".$data['floor_no']." - ".$data['business_name']."</option>";
				}
			}else{
				echo "<option value=''>No Floors are available</option>";
			}	
			echo '</select>';
			
			?>
			<script>
$('.selectpicker').selectpicker();
</script>