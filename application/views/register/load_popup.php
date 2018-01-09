<?php

for($i=1;$i<=$no_of_tables;$i++)
{
?>

  <div class="modal fade" id="myModal_<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:300px;">
      <div class="modal-content">
        <div class="modal-body login-modal">
            <button type="button" class="close" id="close-login" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
          <div class="clearfix"></div>
          <h4 class="text-center mt10"> Select Seats</h4>
		  <center><span id="tn<?php echo $i;?>" style="color:red;font-weight:bold"></span></center>
		   <div class="form-group">
		   <label class="form-lable ">Table Number<span class="star">*</span></label>
            <input type="text"  placeholder="" value=""   id="table_no<?php echo $i;?>"   name="table_no"  class="form-control" maxlength="5" onblur="checkDup(<?php echo $i;?>)">		
          </div>
          <div class="form-group">
		  <label class="form-lable ">No of Seats<span class="star">*</span></label>
            <input type="text"  placeholder="" value=""  maxlength="2" id="no_seats_<?php echo $i;?>"   name="tables"  class="form-control ">
          </div>
            <div class="form-group">
			<label class="form-lable ">Table type<span class="star">*</span></label>
			<select class="selectpicker"  id="selectpicker_<?php echo $i;?>">
			<option value="" style="display:none;">Select Table Type</option>
			<option value="rectangle">Rectangle</option>
			<option value="square">Square</option>
			<option value="circle">Circle</option>
			</select>
          </div>

          <div class="form-group">
            <button type="submit" id="submit<?php echo $i;?>" class="btn btn-success modal-login-btn" onclick="save_pop(<?php echo $i;?>)">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
		<input type="text"  name="images" id="save_images_<?php echo $i;?>" value="" style="display:none"/>
<input type="text"  name="table_type" id="table_type_<?php echo $i;?>" value="" style="display:none"/>




<?php
}


?>
<script>
$('.selectpicker').selectpicker();
$( "input[id^='table_no'],input[id^='no_seats_']" ).keydown(function(event) 
			{
               
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
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
            
</script>


