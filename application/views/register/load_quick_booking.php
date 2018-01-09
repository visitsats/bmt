<?php
				
  foreach($res_list->res_list as $branches)
  {
 
  ?>
		<tr id="remove_div_<?php echo $branches->reservation_id;?>">
	  <td id="name:<?php echo $branches->reservation_id;?>" contenteditable="true"><?php echo $branches->name;?></td>
	  <td id="phone_no:<?php echo $branches->reservation_id;?>" contenteditable="true"><?php echo $branches->phone_no;?></td>
	  <td id="in_time:<?php echo $branches->reservation_id;?>" contenteditable="true"><?php echo date("g:i A", strtotime($branches->in_time));?></td>
   
	 <td class="text-center" id="table_for:<?php echo $branches->reservation_id;?>" contenteditable="false"><?php echo $branches->table_for;?></td>
	 <td id="floor_no:<?php echo $branches->reservation_id;?>" contenteditable="false"><?php echo $branches->floor_no;?></td>
	 <td id="table_n:<?php echo $branches->reservation_id;?>" contenteditable="false">Table Number - <?php echo $branches->table_no;?></td>
	  <td id="booked_date:<?php echo $branches->reservation_id;?>" contenteditable="true"><?php $date = date_create($branches->booked_date); echo date_format($date,'d-M-Y');?></td>
   
	  <td class="text-center">
	  <?php 
		
		
		if($branches->visits>=3)
		{
			echo '<img src="'.base_url().'theme/images/star.png" width="22" style="padding-top:8px;">&nbsp;';
		}else{
			echo '<img src="'.base_url().'theme/images/star-d.png" width="22" style="padding-top:8px;">&nbsp;';
		}
		if(date('Y-').date('m-d',strtotime($branches->date_of_birth)) == date('Y-m-d'))
		{
			echo '<img src="'.base_url().'theme/images/birthday.png" width="22" style="padding-top:8px;">&nbsp;';
		}else{
			echo '<img src="'.base_url().'theme/images/birthday-d.png" width="22" style="padding-top:8px;">&nbsp;';
		}
		if($branches->is_vip ==1)
		{
			echo '<img src="'.base_url().'theme/images/vip.png" width="22" style="padding-top:8px;">&nbsp;';
		}else{
			echo '<img src="'.base_url().'theme/images/vip-d.png" width="22" style="padding-top:8px;">&nbsp;';
		}
		?>
	  <div class="action three black">
	  <?php 
	 if($branches->confirmed==1)
	 {
	 ?>
	<a href="<?php echo base_url()."bookmyt/feedback/".$branches->reservation_id; ?>" class="btn btn-success btn-xss pull-left"> Done </a><span class="divider"></span>
	 <?php
	 }
	 else
	 {
	 ?>
	 <a href="#" class="book-sm-icon" title="Book" data-toggle="modal" data-target="#reservationpop" onclick="buzz_reservation('<?php echo $branches->reservation_id;?>')">
	  </a> 
	 
	
	 <?php
	 }
	 ?>
	  <?php 
	 if($branches->confirmed==1)
	 {
	 ?>
	 <?php
		if($this->session->userdata('user_id') && $this->session->userdata('user_type_id') == '4') 
		{
			echo "";
		} 
		else
		{							
	?>
	<span class="divider"></span>
	 <a href="<?php echo base_url()."/bookmyt/delete_reservation1/".$branches->reservation_id;?>" class="cancel-sm-icon" title="Cancel"  onclick = "if(confirm('Are you sure you want to cancel reservation')) { return true; } else {return false; }"></a>
	
	 <?php
		}
	 }
	 ?>
	  </td>
	</tr>
	<?php
	}
	?>