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
  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Floors</h4>
          <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div><div class='clearfix'></div>
		<center>
			<!--<span style="font-weight:bold;color:red;padding:10px !important;" id="error_sucess"></span>
			<span style="font-weight:bold;color:green;padding:10px !important;" id="error_save"></span>-->
			<center><span style="font-weight:bold;color:red;padding:10px !important;" id="error_sucess"></center>
			</center>
        <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
		  	<div style="color:#FF0000">
				<?php
					if($this->session->flashdata('fail')){
						echo $this->session->flashdata('fail');
					}
					echo validation_errors();
				?>
			</div>
            <div class="panelone  plr10">             
			 <form role="form" class="wrap mt10" method="post" action="">
			   <input type="text" style="display:none" placeholder="Enter your Floor Name" class="form-control" id="floor_id"  name="floor_id" value="<?php echo $floor_id;?>">
			   <input type="hidden" name="relationship_id" value="<?php echo $this->session->userdata('business_id');?>" />
			   <?php
				
				if($this->session->userdata('branch') == '0')
				{
					if($this->session->userdata('have_branches') == '0')
					{
				?>
						<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
			
				<?php
					}
					else
					{
						if($floor_info[0]['business_id'] == $this->session->userdata('business_id'))
						{
				?>
							<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
				<?php
						}
						else
						{
				?>
							<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $floor_info[0]['business_id'];?>" name="branch" id="business_id">	
							
				<?php
						}
					}
				}
				else
				{
				?> 
					<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
				
				<?php
				}
				?>			   
			   
                <div class="form-group col-md-6">
				<label class="form-lable "> Floor <div class="tooltip">?<span class="tooltiptext">Enter floor number. eg:1,2,3,A,B etc.,</span></div><span class="star">*</span></label>	
				 <input type="text" placeholder="" class="form-control" id="floor_no" maxlength="2" name="floor_no" required value="<?php echo $floor_info[0]['floor_no'];?>">
                </div>
                <div class="form-group col-md-6">
				<label class="form-lable ">No of Sections<span class="star">*</span></label>
				 <input type="text" placeholder="" class="form-control no_of_columns"  maxlength="3"  name="no_of_sections" required id="no_of_sections" value="<?php echo $floor_info[0]['no_of_sections'];?>" >
                </div>
                <div class="form-group">
					<a href="<?php echo base_url().'bookmyt/floors/'; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a> <input type="submit" name="submit" value="Update Floor"  class="btn btn-success pull-right" id="update" />
				</div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
$(document).ready(function(){
	$("#update").on('click',function(){
		if($("#floor_no").val().length>2){
			alert("Floor field can not exceed 2 characters in length.");
			return false;
		}
	});
});
</script>  