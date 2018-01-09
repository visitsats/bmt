<tr>
	<td><?php echo $values['name']; ?></td>
	<td><?php echo $values['phone_no']; ?></td>
	<td><?php echo date("g:i A", strtotime($values['in_time'])); ?></td>

	<td class="text-center"><?php echo $values['no_of_mem']; ?></td>
	<td><?php $date = date_create($values['booked_date']); echo date_format($date,'d-M-Y'); ?></td>

	<td class='text-center' >

	<div class='action three black'>
	<a href='#' class='buzz-sm-icon' onclick="buzz_msg('<?php echo $values['userid'];?>')"  title='Buzz'></a> 
	<span class='divider'></span> 
	<a href='#' class='book-sm-icon' title='Book' data-toggle='modal' data-target='#reservationpop' onclick="buzz_reservation('<?php echo $values['userid']; ?>')">
	</a> <span class='divider'></span> 
	<a href="<?php echo base_url().'bookmyt/can_reservation/'.$values['userid']; ?>" class='cancel-sm-icon' title='Cancel'  onclick = "if(confirm('Are you sure you want to Delete (<?php echo $values['name']; ?>)')) { return true; } else {return false; }"></a>
	</div>
	</td>
</tr>

<script>
$('.selectpicker').selectpicker();
</script>