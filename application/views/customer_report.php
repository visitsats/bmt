<style>
.ui-datepicker-year{ display:none !important;}
/* Tooltip container */
.tooltip {
    position: relative;
    display: inline-block;
    /*border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
	opacity:1;
}

/* Tooltip text */
.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
 
    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>
<script type="text/javascript">
$(document).ready( function() {
	$.fn.dataTable.ext.errMode = 'none';
	$('#example').dataTable( {
		"bJQueryUI": true,
		 "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0] }], 
		"sPaginationType": "full_numbers",		
		"aaSorting": [[ 0, 'desc' ]]

	});	
});
</script>
<div class="wrap mnone">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h4><a href="<?php echo base_url();?>bookmyt/reports" class="btn">Back to Reports</a></h4>
				<h4 class="text-center">Promotion Activity</h4>
				<div class="form-group col-sm-12 col-md-12">
					<form name="month" action="" method="post">
						<div class="form-group col-sm-1 col-md-1">
							<label class="form-lable" style="padding-top:7px;">Favourite Day :</label>
						</div>
						<div class="form-group col-sm-2 col-md-2">	
							<input type="text" name="date" id="date" value="<?php if(isset($_POST['date'])) echo $_POST['date']; ?>" class="form-control">
						</div>
						<div class="form-group col-sm-2 col-md-2">
							<label class="form-lable" style="padding-top:7px;">Customer Type :</label>							
						</div>
						<div class="form-group col-sm-3 col-md-3">
							<select name="cust_priority" class="form-control">								
								<option value="">Select Priority</option>
								<option value="is_vip" <?php if(isset($_POST['cust_priority']) && $_POST['cust_priority']=='is_vip') echo 'selected=selected'; ?>>Is VIP</option>
								<option value="is_star" <?php if(isset($_POST['cust_priority']) && $_POST['cust_priority']=='is_star') echo 'selected=selected'; ?>>Is Star Customer</option>
							</select>
						</div>
						<div class="form-group col-sm-2 col-md-2">
							<input type="submit" name="submit" value="Submit" class="btn btn-success btn-xss"/>
						</div>
					</form>
				</div>
				<div class="table-responsive col-sm-12 col-md-12">
				  <table class="table table-style-one table-striped" id="example">
					<thead>
					  <tr>
					  	<th width="7%"><input type="checkbox" name="check" id="check" /></th>
						<th width="16%">Name</th>			
						<th width="15%">Phone</th>
						<th width="15%">Customer Type</th>
						<th width="15%">Favourite Day</th>		
						<th width="8%">Promo Status</th>						
					  </tr>
					</thead>
					<tbody>
						<?php
							if(count($customers) != 0)
							{
								foreach($customers as $customer)
								{
									//$steward=($feeback['steward']!="0")?$feeback['steward']:"";
									$disc_val='';
									if($customer['disc_on_cur_bill']!=""){
										$disc_val=$customer['disc_on_cur_bill'];
									}else if($customer['disc_on_last_bill']!=""){
										$disc_val=$customer['disc_on_last_bill'];
									}else if($customer['disc_on_group']!=""){
										$disc_val=$customer['disc_on_group'];
									}else if($customer['disc_on_freq_cust']!=""){
										$disc_val=$customer['disc_on_freq_cust'];
									}else{
										$disc_val=$customer['disc_percent'];
									}
									if($customer['discount_type']=='percentage'){
										$disc_type="%";
									}else{
										$disc_type="";
									}
						?>
									<tr>
										<td><input type="checkbox" value="<?php echo $customer['customer_id']; ?>" name="customer" class="check_customer" id="check_<?php echo $customer['customer_id']; ?>"  /></td>
										<td><?php echo $customer['name']; ?></td>
										<td><?php echo $customer['phone_no']; ?></td>
										<td><?php echo ($customer['is_vip']==1)?'<img src="'.base_url().'theme/images/vip.png" width="22" style="padding-top:8px;">':"";echo ($customer['is_star_customer']==1)?'<img src="'.base_url().'theme/images/star-d.png" width="22" style="padding-top:8px;">':""; ?></td>
										<td><?php if($customer['date_of_birth']!='0000-00-00' && $customer['date_of_birth']!='0001-11-30'){echo date("d-M",strtotime($customer['date_of_birth']));} ?></td>
										<?php
											if($customer['promotion_id']!=""){
										?>
										<td><a href="#"><img src="<?php echo base_url().'/theme/images/star-active.png'; ?>" width="18" height="20" /></a><a href="javascript:void(0);" data-toggle="modal" data-target="#promoModal_edit_<?php echo $customer['customer_id']; ?>" style="padding-left:5px;"><img src="<?php echo base_url().'/theme/images/edit.png'; ?>" width="18" height="20" /></a><a href="javascript:void(0);" data-toggle="modal" data-target="#promoModal_info_<?php echo $customer['customer_id']; ?>" style="padding-left:5px;"><i class="fa fa-info-circle" aria-hidden="true" style="color:red; font-size:20px;width:18px;height:20px"></i></a></td>
										<?php
											}else{
												echo '<td></td>';
											}
										?>
									</tr>
									<div class="modal fade" id="promoModal_edit_<?php echo $customer['customer_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog " role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
											<h4 class="modal-title" id="myModalLabel">Generate Promocode</h4>
										  </div>
										  <form action="<?php echo base_url('bookmyt/send_promocode_cust'); ?>" method="post">
										<div class="modal-body">	 
											 <div class="form-group col-md-10  col-sm-10 col-md-offset-1">	
												<label class="form-lable "><strong>Message</strong><span class="star">*</span></label>			 
												<input type="text"  name="message" class="form-control" value="<?php echo $customer['description']; ?>" id="message" />      
											 </div>
												<!--<div class="form-group col-md-10 col-md-offset-1">	 
									
												<input type="text" placeholder="Enter No of members" class="form-control"   name="table_for" required id="select_no_of_members" onblur="get_tables()">
												</div>-->
											<div class="form-group col-md-10 col-sm-10 col-md-offset-1">	 
												<label class="form-lable "><strong>Discount On</strong></label>	
												
												<div class="col-sm-6 col-xs-12"><input type="radio" name="discount" value="current" class="form-radio" <?php if($customer['disc_on_cur_bill']!="")echo 'checked=checked'; ?> /> Current Bill<br /></div>
												
												<div class="col-sm-6 col-xs-12"><input type="radio" name="discount" value="last" class="form-radio" <?php if($customer['disc_on_last_bill']!="")echo 'checked=checked'; ?> /> Last Bill<br /></div>
												
												<div class="col-sm-6 col-xs-12"><input type="radio" name="discount" value="group" class="form-radio" <?php if($customer['disc_on_group']!="")echo 'checked=checked'; ?> /> Group Bill<br /></div>
												
												<div class="col-sm-6 col-xs-12"><input type="radio" name="discount" value="freq_cust" class="form-radio" <?php if($customer['disc_on_freq_cust']!="")echo 'checked=checked'; ?>/> Frequent Customer Bill
												</div>	
												
												
												
												
											</div>
											<div class="form-group col-md-10 col-sm-10 col-md-offset-1">
												<label class="form-lable"><strong>Promotion Type</strong><span class="star">*</span></label>
												<div class="col-sm-6 col-xs-12"><input type="radio" name="promotion_type" value="generic" <?php if($customer['promotion_type']==0)echo 'checked=checked'; ?> /> Generic</div>
												<div class="col-sm-6 col-xs-12"><input type="radio" name="promotion_type" value="specific" <?php if($customer['promotion_type']==1)echo 'checked=checked'; ?> /> Specific</div>
												
												
											</div>
											<div class="form-group col-md-10 col-sm-10 col-md-offset-1">												
												<label class="form-lable"><strong>Discount Value (Either Percentage or Value)<div class="tooltip">?<span class="tooltiptext">Discount can be % or fixed value. eg. 20% or 30</span></div></strong><span class="star">*</span></label>
												<input type="text" name="discount_value" value="<?php echo round($disc_val)." ".$disc_type; ?>" id="discount_value" class="form-control" />
											</div>
											<div class="form-group col-md-10 col-sm-10 col-md-offset-1">			
												<div class="row">
													<div class="col-sm-6 col-xs-12"><label class="form-lable "><strong>Your Promo Code</strong></label></div>	 
												<div class="col-sm-6 col-xs-12">
													<?php 
														//$val=rand(11111,99999); 
														echo '<span style="font-weight:600">'.$customer['promocode'].'</span>';
													?>
												</div>
												</div>						
											</div>
											 
											<input type="hidden" name="promocode" value="<?php echo $customer['promocode']; ?>" />
											<input type="hidden" value="<?php echo $customer['customer_id']; ?>" name="customer_id" />
										</div>
										<div class="clearfix"></div>
										  <div class="modal-footer ">
											
											<div class="text-center">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-success" onclick="send_promo()">Send Promocode</button>
										  </div>
										</div>
										</form>
									  </div>
									</div>
									</div>
									
									
									<div class="modal fade" id="promoModal_info_<?php echo $customer['customer_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog " role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close" style="color:#000000;">x</button>
											<h4 class="modal-title" id="myModalLabel">Promocode Information</h4>
										  </div>										 
										<div class="modal-body">	 
											 <div class="form-group col-md-10  col-sm-10 col-md-offset-1">	
											 	<div class="col-sm-6 col-xs-12">
												<label class="form-lable "><strong>Message</strong></label>			 
												</div>
												<div class="col-sm-6 col-xs-12">
												<?php echo $customer['description']; ?>     
												</div>
											 </div>
												<!--<div class="form-group col-md-10 col-md-offset-1">	 
									
												<input type="text" placeholder="Enter No of members" class="form-control"   name="table_for" required id="select_no_of_members" onblur="get_tables()">
												</div>-->
											<div class="form-group col-md-10 col-sm-10 col-md-offset-1">
												<div class="col-sm-6 col-xs-12">	 
												<label class="form-lable "><strong>Discount On</strong></label>	
												</div>
												
												<div class="col-sm-6 col-xs-12"><?php if($customer['disc_on_cur_bill']!="")echo 'Current Bill'; ?></div>
												
												<div class="col-sm-6 col-xs-12"><?php if($customer['disc_on_last_bill']!="")echo 'Last Bill'; ?></div>
												
												<div class="col-sm-6 col-xs-12"><?php if($customer['disc_on_group']!="")echo 'Group Bill'; ?></div>
												
												<div class="col-sm-6 col-xs-12"><?php if($customer['disc_on_freq_cust']!="")echo 'Frequent Customer Bill'; ?></div>	
												
												
												
												
											</div>
											<div class="form-group col-md-10 col-sm-10 col-md-offset-1">
												<div class="col-sm-6 col-xs-12">
												<label class="form-lable"><strong>Promotion Type</strong></label>
												</div>
												<div class="col-sm-6 col-xs-12"><?php if($customer['promotion_type']==0)echo 'Generic'; ?> </div>
												<div class="col-sm-6 col-xs-12"><?php if($customer['promotion_type']==1)echo 'Specific'; ?></div>
												
												
											</div>
											<div class="form-group col-md-10 col-sm-10 col-md-offset-1">
												<div class="col-sm-6 col-xs-12">
												<label class="form-lable"><strong>Discount Value</label>
												</div>
												<div class="col-sm-6 col-xs-12">
												<?php echo round($disc_val)." ".$disc_type; ?>
												</div>
											</div>
											<div class="form-group col-md-10 col-sm-10 col-md-offset-1">			
												<div class="row">
													<div class="col-sm-6 col-xs-12"><label class="form-lable "><strong>Your Promocode</strong></label></div>	 
												<div class="col-sm-6 col-xs-12">
													<?php 
														//$val=rand(11111,99999); 
														echo '<span style="font-weight:600;font-family:arial;">'.$customer['promocode'].'</span>';
													?>
												</div>
												</div>						
											</div>										 
											
										</div>
										<div class="clearfix"></div>
									
									  </div>
									</div>
									</div>
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
				  <button name="promocode" data-toggle="modal" id="generate" data-target="#promoModal" class="btn btn-success btn-xss btn-sm pull-right">Generate Promocode</button>
				 </div>
			  </div>
		</div>
	</div>
</div>
<div class="modal fade" id="promoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        <h4 class="modal-title" id="myModalLabel">Generate Promocode</h4>
      </div>
	  <form action="<?php echo base_url('bookmyt/send_promocode'); ?>" method="post">
	<div class="modal-body">	 
         <div class="form-group col-md-10  col-sm-10 col-md-offset-1">	
			<label class="form-lable "><strong>Message</strong><span class="star">*</span></label>			 
         	<input type="text"  name="message" class="form-control" value="" id="message" />      
         </div>
			<!--<div class="form-group col-md-10 col-md-offset-1">	 

			<input type="text" placeholder="Enter No of members" class="form-control"   name="table_for" required id="select_no_of_members" onblur="get_tables()">
			</div>-->
		<div class="form-group col-md-10 col-sm-10 col-md-offset-1">	 
			<label class="form-lable "><strong>Discount On</strong></label>	
			
			<div class="col-sm-6 col-xs-12"><input type="radio" name="discount" value="current" class="form-radio" /> Current Bill<br /></div>
			
			<div class="col-sm-6 col-xs-12"><input type="radio" name="discount" value="last" class="form-radio"  /> Last Bill<br /></div>
			
			<div class="col-sm-6 col-xs-12"><input type="radio" name="discount" value="group" class="form-radio"  /> Group Bill<br /></div>
			
			<div class="col-sm-6 col-xs-12"><input type="radio" name="discount" value="freq_cust" class="form-radio" /> Frequent Customer Bill
			</div>	
			
			
			
			
		</div>
		<div class="form-group col-md-10 col-sm-10 col-md-offset-1">
			<label class="form-lable"><strong>Promotion Type</strong><span class="star">*</span></label>
			<div class="col-sm-6 col-xs-12"><input type="radio" name="promotion_type" value="generic" /> Generic</div>
			<div class="col-sm-6 col-xs-12"><input type="radio" name="promotion_type" value="specific" /> Specific</div>
			
			
		</div>
		<div class="form-group col-md-10 col-sm-10 col-md-offset-1">
			<label class="form-lable"><strong>Discount Value <div class="tooltip">?<span class="tooltiptext">Discount can be % or fixed value. eg. 20% or 30</span></div>(Either Percentage or Value)</strong><span class="star">*</span></label>
			<input type="text" name="discount_value" value="" id="discount_value" class="form-control" />
		</div>
		<div class="form-group col-md-10 col-sm-10 col-md-offset-1">			
			<div class="row">
				<div class="col-sm-6 col-xs-12"><label class="form-lable "><strong>Your Promo Code</strong></label></div>	 
			<div class="col-sm-6 col-xs-12">
				<?php 
					$val=rand(11111,99999); 
					echo '<span style="font-weight:600">'.$val.'</span>';
				?>
			</div>
			</div>						
		</div>
		 
		<input type="hidden" name="promocode" value="<?php echo $val; ?>" />
		<input type="hidden" id="customer_ids" value="" name="customer_ids" />
	</div>
	<div class="clearfix"></div>
      <div class="modal-footer ">
        
		<div class="text-center">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" onclick="send_promo()">Send Promocode</button>
      </div>
    </div>
	</form>
  </div>
</div>
</div>
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
			  
<script type="text/javascript">
$(document).ready(function(){
	$("#date").datepicker({
		'changeMonth'	: true,
		'changeYear'	: false,
		'dateFormat'	: 'dd-MM',
		'showButtonPanel'	: false,
	});
	$("#generate").click(function(){
		if($(".check_customer:checkbox:checked").length==0){
			alert("Please select atleast one checkbox");
			return false;
		}else{
			var final='';
			//alert($(".check_customer:checkbox:checked").val());
			var i=1;
			$(".check_customer:checkbox:checked").each(function(){ 
				var values=$(this).val();
				if(i==1){
					final+=values;
				}else{
					final+='_'+values;
				}				
				i++;
			});	
			$("#customer_ids").val(final);	
		}
	});
	function send_promo(){
		if($("#message").val()==""){
			alert("Please enter the message");
			return false;
		}
		if($('input[name=discount_type]:checked').length<=0){
			alert("Please select the discount type");
			return false;
		}
		if($("#discount_value").val()==""){
			alert("Please enter the discount value");
			return false;
		}
	}
	$('#check').on('click',function(){
        if(this.checked){
            $('.check_customer').each(function(){
                this.checked = true;
            });
        }else{
             $('.check_customer').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.check_customer').on('click',function(){
        if($('.check_customer:checked').length == $('.check_customer').length){
            $('#check').prop('checked',true);
        }else{
            $('#check').prop('checked',false);
        }
    });
})
</script>