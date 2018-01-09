<style>
.ui-datepicker-year{ display:none !important;}

input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
</style>
<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Feedback</h4>
		 
         <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p> -->
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
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
            <div class="panelone  plr10">
				<center><span style="color:red;font-weight:bold" id="err_msg"></span></center>
				<form name="" method="post" class="wrap mt15" action="<?php echo base_url()."bookmyt/feedback/".$rid; ?>">
            <input type="hidden" name="bill_id" id="bill_id" value="<?php echo $rid; ?>" />
				<div class="col-xs-12 col-md-12">
					<div class="form-group col-md-3">
						Date :-  <b style="font-family:Arial, Helvetica, sans-serif"><?php echo date('d-M-y'); ?></b>
					</div>
					<div class="form-group col-md-6 pull-right">
						<?php
							if(!empty($promocode)){
								foreach($promocode as $promo){
									if($promo['disc_on_cur_bill']!=""){
										$promo_type="is valid on current bill";	
										$val=$promo['disc_on_cur_bill'];								
									}else if($promo['disc_on_last_bill']!=""){
										$promo_type="is valid on last bill";
										$val=$promo['disc_on_last_bill'];
									}else if($promo['disc_on_group']!=""){
										$promo_type="is valid on group bill";
										$val=$promo['disc_on_group'];
									}else if($promo['disc_on_freq_cust']!=""){
										$promo_type="";
										$val=$promo['disc_on_freq_cust'];
									}else if($promo['disc_percent']!=""){
										$promo_type="";
										$val=$promo['disc_percent'];
									}
									if($promo['discount_type']=='percentage'){
										$type=number_format($val)."%";
									}else if($promo['discount_type']=='value'){
										$type=number_format($val) ."Flat";
									}
						?>
								<p style="font-family:Arial, Helvetica, sans-serif;">Promo Code: <?php echo $promo['promocode']." Discount: ".$type." ".$promo_type; ?></p>
						<?php
								}
							}
						?>						
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="form-group col-md-12">

				<input id="radio-1" class="radio-custom" name="dining_type" type="radio" value="lunch" checked>
					<label for="radio-1" class="radio-custom-label">Lunch</label>
				<input id="radio-2" class="radio-custom" name="dining_type" type="radio" value="dinner" >
					<label for="radio-2" class="radio-custom-label">Dinner</label>
				</div>
					<div class="clearfix"></div>
				<div class="form-group col-md-6">
				<label class="form-lable ">Bill Number  <span class="star">*</span></label>
				
					<input type="text" name="bill_no" value="" id="bill_no" class="form-control" />
				</div>
				<div class="form-group col-md-6">
				<?php
					$ip_address = $_SERVER['REMOTE_ADDR'];
					//$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip_address));
					// echo "<pre>";
						// print_r($query);
					// echo "</pre>";
				?>
				<label class="form-lable ">Bill Amount <span class="star">*</span></label>
				
					<input type="text" name="bill_amt" value="" placeholder="Bill Amount In USD" id="bill_amt" class="form-control" maxlength="6"/>
				</div>
				<div class="form-group col-md-6">
				<label class="form-lable ">Table Number <span class="star">*</span></label>
				
					<input type="text" name="tab_no" readonly="" value="<?php if(isset($bill_info[0]) && $bill_info[0]['table_no'] != '') {echo $bill_info[0]['table_no'];} else { echo ""; } ?>" id="tab_no" class="form-control" maxlength="3" />
				</div>
				<div class="form-group col-md-6">
				<label class="form-lable ">Steward <span class="star">*</span></label>
				
					<input type="text" name="stew" value="<?php if(isset($steward[0]) && $steward[0]['steward'] != '') {echo $steward[0]['steward'];} else { echo ""; } ?>" id="stew" class="form-control" maxlength="25"/>
				</div>				
				<div class="form-group col-md-6">
				<label class="form-lable ">Guest Name <span class="star">*</span></label>
				
					<input type="text" name="c_name" value="<?php if(isset($bill_info[0]) && $bill_info[0]['name'] != '') {echo $bill_info[0]['name'];} else { echo ""; } ?>" id="c_name" class="form-control" maxlength="25" />
				</div>
				<div class="form-group col-md-6">
				<label class="form-lable ">Guest Phone <span class="star">*</span></label>
				
					<input type="text" name="c_phn" value="<?php if(isset($bill_info[0]) && $bill_info[0]['phone_no'] != '') {echo $bill_info[0]['phone_no'];} else { echo ""; } ?>" id="c_phn" class="form-control" maxlength="12"/>
				</div>
				<div class="form-group col-md-6">
				<label class="form-lable ">Guest Fav. Day </label>
				
					<input type="text" name="date_of_birth" value="<?php if(isset($bill_info[0]) && $bill_info[0]['date_of_birth'] != '') {echo date('d-M',strtotime($bill_info[0]['date_of_birth']));} else { echo ""; } ?>" id="date_of_birth" class="form-control"/>
				</div>
				<div class="form-group col-md-6">
				<label class="form-lable ">Available Reward Points</label>
				<span style="margin-left:16px; font-weight:bold"><?php echo (empty( $reward_info[0]['rewards'])) ? 0: $reward_info[0]['rewards'];?></span>
				</div>
				<div class="clearfix"></div>
				<b><i><u style="font-size:15px">Feedback</u></i></b>
				<div class="clearfix"></div>
				<div class="form-group col-sm-6 col-md-6">
				<br/>
				<u><b>Food </b></u>
				<br/>
				<div class="table-responsive">
				<table class="feed_back" cellspacing="10">
					<tr>
						<td>&nbsp;</td><td>5</td><td>4</td><td>3</td><td>2</td><td>1</td>
					</tr>
					<tr>
						<td>Quality</td><td><input type="radio" name="quality" value="5" /></td>
										<td><input type="radio" name="quality" value="4" /></td>
										<td><input type="radio" name="quality" value="3" /></td>
										<td><input type="radio" name="quality" value="2" /></td>
										<td><input type="radio" name="quality" value="1" /></td>
					</tr>
					<tr>
						<td>Presentation</td><td><input type="radio" name="presentation" value="5" /></td>
										<td><input type="radio" name="presentation" value="4" /></td>
										<td><input type="radio" name="presentation" value="3" /></td>
										<td><input type="radio" name="presentation" value="2" /></td>
										<td><input type="radio" name="presentation" value="1" /></td>
					</tr>
					<tr>
						<td>Taste</td><td><input type="radio" name="taste" value="5" /></td>
										<td><input type="radio" name="taste" value="4" /></td>
										<td><input type="radio" name="taste" value="3" /></td>
										<td><input type="radio" name="taste" value="2" /></td>
										<td><input type="radio" name="taste" value="1" /></td>
					</tr>
				</table>
				</div>
				</div>
				<div class="form-group col-sm-6 col-md-6"><br/>
				<u><b>Service</b></u>
				<br/>
				<div class="table-responsive">
				<table class="feed_back" cellspacing="5">
					<tr>
						<td>&nbsp;</td><td>5</td><td>4</td><td>3</td><td>2</td><td>1</td>
					</tr>
					<tr>
						<td>Promptness</td><td><input type="radio" name="promptness" value="5" /></td>
										<td><input type="radio" name="promptness" value="4" /></td>
										<td><input type="radio" name="promptness" value="3" /></td>
										<td><input type="radio" name="promptness" value="2" /></td>
										<td><input type="radio" name="promptness" value="1" /></td>
					</tr>
					<tr>
						<td>Courtesy</td><td><input type="radio" name="courtesy" value="5" /></td>
										<td><input type="radio" name="courtesy" value="4" /></td>
										<td><input type="radio" name="courtesy" value="3" /></td>
										<td><input type="radio" name="courtesy" value="2" /></td>
										<td><input type="radio" name="courtesy" value="1" /></td>
					</tr>
					<tr>
						<td>Competence</td><td><input type="radio" name="competence" value="5" /></td>
										<td><input type="radio" name="competence" value="4" /></td>
										<td><input type="radio" name="competence" value="3" /></td>
										<td><input type="radio" name="competence" value="2" /></td>
										<td><input type="radio" name="competence" value="1" /></td>
					</tr>
				</table>	
				</div>
				</div>
				<div class="form-group col-md-12">
				Special Remarks
					<textarea name="spl_rem" class="form-control" id="spl_rem"></textarea>
				</div>				 
					 <div class="form-group col-md-12"><a href="<?php echo base_url().'bookmyt/reservation_list/'; ?>" style="margin-left:5px" class="btn btn-success pull-right">Cancel</a> 
				  <button type="submit" name="sub"  id="sub" class="btn btn-success pull-right" onclick="return valid();">Done</button>
				  </div>				  
				</form>
						
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="verifypromoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog sm" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
			<h4 class="modal-title" id="myModalLabel">Verify Promocode</h4>
		  </div>
		  <form action="<?php echo base_url('bookmyt/verify_promocode'); ?>" method="post">
		<div class="modal-body">	 
			 <div class="form-group col-md-10  col-sm-10 col-md-offset-1">	
				<label class="form-lable ">Enter Promocode<span class="star">*</span></label>			 
				<input type="text"  name="promocode" class="form-control" value="" id="promocode" />      
			 </div>
		</div>
		<div class="clearfix"></div>
		  <div class="modal-footer ">
			
			<div class="text-center">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-success" onclick="return verify_promo()">Verify Promocode</button>
		  </div>
		</div>
		</form>
	  </div>
	</div>
</div>
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />

<script type="text/javascript" src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>

	 $('#c_phn,#bill_no').keydown(function(event) 
	{
	   
		if (event.keyCode == 46 || event.keyCode == 188 || event.keyCode == 8 || event.keyCode == 9 
			|| event.keyCode == 27 || event.keyCode == 13 
			|| (event.keyCode == 65 && event.ctrlKey === true) 
			|| (event.keyCode >= 35 && event.keyCode <= 39)){
				return;
		}else {
			
			if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				event.preventDefault(); 
			}   
		}
	});
	
	$("#bill_no").blur(function()
	{
		var bill_no = $("#bill_no").val();
		$.post("<?php echo base_url().'bookmyt/bill_no_unique/'; ?>",{ bill_num : bill_no} ,function(data)
		{
			if($.trim(data) != 0)
			{
				$("#bill_no").addClass('error');
				return false;
			}
			else
			{
				$("#bill_no").removeClass('error');
			}
		});
	});
            
	function valid()
	{
		// if($('input[name=dining_type]:checked').length <= 0)
		// {
			// $("#err_msg").show();
			// $("#err_msg").html("Please check dining type.");
			// $("#err_msg").fadeOut(2000);
			// return false;
		// }
		// else
		// {
			// $("#err_msg").html('');
		// }
		//alert($("#bill_no").val());
		var error = [];
		if($("#bill_no").val() == "")
		{
			error.push('e1');
		}
		if($("#bill_amt").val() == "")
		{
			error.push('e2');
		}
		if($("#tab_no").val() == "")
		{
			error.push('e3');
		}
		if($("#stew").val() == "")
		{
			error.push('e4');
		}
		if($("#c_name").val() == "" && $("#c_phn").val() == "")
		{
			error.push('e5');
		}
		
		/*if($("#c_phn").val().length <10)
		{
			error.push('e6');
		}*/
		
		if(error.length != 0)
		{
			if($.inArray("e1", error) !== -1){$("#bill_no").addClass('error'); } else { $("#bill_no").removeClass('error'); }
			if($.inArray("e2", error) !== -1){ $("#bill_amt").addClass('error'); } else { $("#bill_amt").removeClass('error'); }
			if($.inArray("e3", error) !== -1){ $("#tab_no").addClass('error'); } else { $("#tab_no").removeClass('error'); }
			if($.inArray("e4", error) !== -1){ $("#stew").addClass('error'); } else { $("#stew").removeClass('error'); }
			if($.inArray("e5", error) !== -1){ $("#c_name").addClass('error');$("#c_phn").addClass('error'); } else { $("#c_name").removeClass('error'); $("#c_phn").removeClass('error');}
			//if($.inArray("e6", error) !== -1){ $("#c_phn").addClass('error'); } else { $("#c_phn").removeClass('error'); }
			return false;
		}
		else
		{
			if(confirm("Are you sure about billing details?"))
			{
				$("#bill_no").removeClass('error');
				$("#bill_amt").removeClass('error');
				$("#tab_no").removeClass('error');
				$("#stew").removeClass('error');
				$("#c_name").removeClass('error');
				$("#c_phn").removeClass('error');
				error = [];
			}
			else
			{
				return false;
			}
		}
	
		/*
		if($('input[name=quality]:checked').length<=0)
		{
			$("#err_msg").html("Please give feedback about quality.");
			return false;
		}
		else
		{
			$("#err_msg").html("");
		}
		if($('input[name=presentation]:checked').length<=0)
		{
			$("#err_msg").html("Please give feedback about presentation.");
			return false;
		}
		else
		{
			$("#err_msg").html("");
		}
		if($('input[name=taste]:checked').length<=0)
		{
			$("#err_msg").html("Please give feedback about taste.");
			return false;
		}
		else
		{
			$("#err_msg").html("");
		}
		if($('input[name=promptness]:checked').length<=0)
		{
			$("#err_msg").html("Please give feedback about promptness.");
			return false;
		}
		else
		{
			$("#err_msg").html("");
		}
		if($('input[name=courtesy]:checked').length<=0)
		{
			$("#err_msg").html("Please give feedback about courtesy.");
			return false;
		}
		else
		{
			$("#err_msg").html("");
		}
		if($('input[name=competence]:checked').length<=0)
		{
			$("#err_msg").html("Please give feedback about competence.");
			return false;
		}
		else
		{
			$("#err_msg").html("");
		}
		
		if($("#spl_rem").val() == "")
		{
			$("#err_msg").html("Please enter special remarks.");
			return false;
		}
		else
		{
			$("#err_msg").html("");
		}	*/	
				
    }
	function verify_promo(){
		if($("#promocode").val()==""){
			alert("Please enter Promocode");
			return false;
		}
	}
	$("#bill_no,#bill_amt,#tab_no,#stew,#c_name,#c_phn").change(function()
	{
		if($("#bill_no").val() != "")
		{
			$("#bill_no").removeClass('error');
			
		}
		if($("#bill_amt").val() != "")
		{
			$("#bill_amt").removeClass('error');
			
		}
		if($("#tab_no").val() != "")
		{
			$("#tab_no").removeClass('error');
			
		}
		if($("#stew").val() != "")
		{
			$("#stew").removeClass('error');
			
		}
		if($("#c_name").val() != "" && $("#c_phn").val() != "")
		{
			$("#c_name").removeClass('error');
			$("#c_phn").removeClass('error');
		}
		 
		
	});
	$('#date_of_birth').datepicker({
		'changeMonth'	: true,
		'changeYear'	: false,
		'dateFormat'	: 'dd-MM',
		'showButtonPanel'	: false,
	});	
</script>
