<?php
$result=array();
$tn1='';

if( $no_of_tables > count($floor_info)){
	$cint = count($floor_info);
	for( $i = $cint; $i < $no_of_tables; $i++ ) {
		$floor_info[$i] = array();
	}
}
$i=1;

$floor_new_array = array();
foreach($floor_info as $floor_info1)
{
	$floor_new_array['ser'.@$floor_info1['serial_no']] = $floor_info1;
}
if(isset($no_of_rows) && $no_of_rows != '' && isset($no_of_columns) && $no_of_columns != '')
{
for($j=1;$j<=$no_of_rows;$j++)
{
	for($k=1;$k<=$no_of_columns;$k++)
{
	

//foreach($floor_info as $floor_info1)
{


if(isset($floor_new_array['ser'.$j.''.$k]))
{

?>
  <div class="modal fade " id="myModal_<?php echo $j.''.$k;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:300px;">
      <div class="modal-content">
        <div class="modal-body " >
            <button type="button" class="close" id="close-login" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
          <div class="clearfix"></div>
          <h4 class="text-center mt10"> Select Seats</h4>
		   <center><span id="tn<?php  echo $j.''.$k;?>" style="color:red;font-weight:bold"></span></center>
		   <div class="form-group">
		   <?php
		   if($floor_new_array[$j.''.$k]['Booked_Status']==0)
		   {
		   ?>
            <input type="text"  placeholder="Table Number" value="<?php echo $floor_new_array['ser'.$j.''.$k]['table_no'];?>"   id="table_no<?php echo $j.''.$k;?>"   name="table_no" maxlength="5" class="form-control">
		   <?php
		   }else
		   {
		   ?>
		   <input type="text"  placeholder="Table Number" value=""   id="table_no<?php echo $j.''.$k;?>"   name="table_no" maxlength="3" class="form-control">
		   <?php
		   }
		   ?>
		   
          </div>
          <div class="form-group">
            <input type="text"  placeholder="Seats" value="<?php if($floor_new_array['ser'.$j.''.$k]['no_of_seats'] != 0) { echo $floor_new_array['ser'.$j.''.$k]['no_of_seats']; } else {} ?>"  maxlength="2" id="no_seats_<?php echo $j.''.$k;?>"   name="tables"  class="form-control">
          </div>
            <div class="form-group">
			<select class="selectpicker" id="selectpicker_<?php echo $j.''.$k;?>">
			<option value="" style="display:none;">Table Type</option>
			<option value="rectangle" <?php if($floor_new_array['ser'.$j.''.$k]['table_type'] == "rectangle") { echo "selected='selected'"; }  ?>>Rectangle</option>
			<option value="square" <?php if($floor_new_array['ser'.$j.''.$k]['table_type'] == "square") { echo "selected='selected'"; }  ?>>Square</option>
			<option value="circle" <?php if($floor_new_array['ser'.$j.''.$k]['table_type'] == "circle") { echo "selected='selected'"; }  ?>>Circle</option>
			</select>
          </div>
          
          <div class="form-group">
            <button type="submit" class="btn btn-success modal-login-btn" onclick="save_pop(<?php echo $j.''.$k;?>)">Submit</button>
          </div>
       
		</div>
      </div>
    </div>
  </div>
<input type="text"  name="images" id="save_images_<?php echo $floor_new_array['ser'.$j.''.$k]['table_no'];?>" value="<?php echo $floor_new_array['ser'.$j.''.$k]['image'];?>" style="display:none" />
<input type="text"  name="table_type" id="table_type_<?php echo $j.''.$k;?>" value="<?php echo $floor_new_array['ser'.$j.''.$k]['table_type'];?>" style="display:none"/>
<?php
}
else
{
?>
  <div class="modal fade" id="myModal_<?php echo $j.''.$k;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:300px;">
      <div class="modal-content">
        <div class="modal-body login-modal">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <div class="clearfix"></div>
          <h4 class="text-center mt10"> Select Seats</h4>
		  <center><span id="tn<?php  echo $j.''.$k;?>" style="color:red;font-weight:bold"></span></center>
		   <div class="form-group">
		    <label class="form-lable ">Table Number<span class="star">*</span></label>
            <input type="text"  placeholder="" value=""   id="table_no<?php echo $j.''.$k;?>"   name="table_no"  class="form-control login-field" maxlength="3">
          </div>
          <div class="form-group">
		   <label class="form-lable ">No of Seats<span class="star">*</span></label>
            <input type="text"  placeholder="" value=""  maxlength="2" id="no_seats_<?php echo $j.''.$k;?>"   name="tables"  class="form-control login-field">
          </div>
            <div class="form-group">
			<label class="form-lable ">Table type<span class="star">*</span></label>
			<select class="selectpicker"  id="selectpicker_<?php echo $j.''.$k;?>">
			<option value="" style="display:none;">Select Table Type</option>
			<option value="rectangle">Rectangle</option>
			<option value="square">Square</option>
			<option value="circle">Circle</option>
			</select>
          </div>
          
          <div class="form-group">
            <button type="submit" class="btn btn-success modal-login-btn" onclick="save_pop(<?php echo $j.''.$k;?>)">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
		<input type="text"  name="images" id="save_images_<?php echo $j.''.$k;?>" value="" style="display:none"/>
<input type="text"  name="table_type" id="table_type_<?php echo $j.''.$k;?>" value="" style="display:none"/>
<?php
$i++;
}
?>
<?php


}
}
}
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