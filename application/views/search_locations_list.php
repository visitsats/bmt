<ul class="list-unstyled">
    <?php
	if(is_array($locations) && !empty($locations))
	{
	foreach($locations as $locations1)
	{
	?>
	<li onclick="fillme('<?php echo $locations1['city'];?>')"><?php echo $locations1['city'];?></li>
    <?php
	}
	}else
	{
	?>
	<li>No data Found</li>
	<?php
	}
	?>
	</ul>