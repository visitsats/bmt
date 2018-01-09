<style type="text/css">
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
          <h4 class="text-center">Sections</h4>
          <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div> <div class='clearfix'></div>
		<center><span style="font-weight:bold;color:red;padding:10px !important;" id="error_sucess"></span></center>
        <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
		 
            <div class="panelone  plr10">
			</center>
              <form role="form" class="wrap mt10" method="post">
			   <input type="hidden" name="relationship_id" value="<?php if($this->session->userdata('relationship_id') == '') { echo '';} else {echo $this->session->userdata('relationship_id'); }?>" />
			   <?php
					
						if($this->session->userdata('branch') == 0)
						{
							if($this->session->userdata('have_branches') == '0')
							{
						?>
								<input type="hidden" placeholder="Branch Name" class="form-control" value="<?php echo $this->session->userdata('business_id');?>" name="branch" id="business_id">
			
						<?php
							}
							else
							{
							
						?>
						  <div class="form-group col-md-12">
						  <label class="form-lable ">Select Branches<span class="star">*</span></label>	
							  <select class="selectpicker"  name="branch" id="business_id">
									<option value="" style="display:none;">Select  Branch</option>
									<?php
									if(isset($branches) && !empty($branches))
									{
										foreach($branches as $branch)
										{
									?>
										<option value="<?php echo $branch['business_id']; ?>" <?php if($branch['business_id'] == $this->session->userdata('business_id')) { echo "selected='selected'";} ?> <?php echo set_select('branch', $branch['business_id']); ?>><?php echo $branch['business_name']; ?></option>
									<?php
										}
									}
									?>
							 </select>
								<span style="color:red"><?php echo form_error('branch'); ?></span>
						  </div>
					<?php
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
				 <input type="text" placeholder="" class="form-control" id="floor_no"  name="floor_no" maxlength="2" required>
                </div>
                <div class="form-group col-md-6">
				<label class="form-lable ">No. of Sections<span class="star">*</span></label>
				 <input type="text" placeholder="" maxlength="3" class="form-control"   name="no_of_sections" required id="sections">
                </div>
				<div class="form-group  col-md-12">
					<a href="<?php echo base_url().'bookmyt/floors/'; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a>
					<input type="submit" name="submit" class="btn btn-success pull-right" value="Submit" />					
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
	$("#floor_no").focus();
});
</script>  