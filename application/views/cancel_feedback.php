<div class="container">
	<div class="col-xs-12">
		<h5 class="text-center mt10">We Thank you for using BOOKMYT services.</h5>
		<div class="col-xs-12 text-center">
			<div class="col-xs-12 text-center" style="color:#FF0000">
				<?php echo validation_errors(); ?>
			</div>
			<form method="post" action="">			
				<div class="table-responsive text-center">
					<table class="" cellspacing="10" width="100%">
						<tr>
							<td>&nbsp;</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td>
						</tr>
						<tr>
							<td><strong>Rate Your Experience*</strong></td><td><input type="radio" name="experience" value="1" /></td>
											<td><input type="radio" name="experience" value="2" /></td>
											<td><input type="radio" name="experience" value="3" /></td>
											<td><input type="radio" name="experience" value="4" /></td>
											<td><input type="radio" name="experience" value="5" /></td>
						</tr>
						<tr>
							<td><strong>Specific Reason for Cancellation*</strong></td>
							<td colspan="5"><textarea name="reason" id="reason" class="form-control" cols="20" rows="5"></textarea></td>
						</tr>				
					</table>
				</div>
				<div class="text-center">
					<input type="submit" name="submit" value="Submit" id="feedback" class="btn btn-orang btn-success"/>
				</div>				 
			</form>
		</div>
	</div>
</div>	
<script type="text/javascript">
$(document).ready(function(){
	$("#feedback").click(function(){
		if (!$('input[name=experience]:checked').val() ) {
			alert("Please rate your experience");
			return false;
		}else{
		
		}
		if($("#reason").val()==""){
			alert("Please enter the reason for cancellation");
			return false;
		}
	});
});
</script>