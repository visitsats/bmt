<?php
	if(isset($t_zones) && !empty($t_zones))
	{
		foreach($t_zones as $zone)
		{
	?>
		<option value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['zone_name']; ?></option>
	<?php
		}
	}
?>
<script>
$('.selectpicker').selectpicker();
</script>