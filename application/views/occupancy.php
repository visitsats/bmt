<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Occupancy</h4>
		 
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
          <div class="col-xs-12 "> 
		   <center><b><span style="color:green" id="sucess"></span></b></center>
           <center><b><span style="color:red" id="error"></span></b></center>
			<form name="guest_add" method="post" id="guest_add" class="wrap mt25" action="">
				<div class="form-group col-md-6 col-md-offset-3" style="display:none;">
					<!--<label class="sr-only" for="name">Select Floor</label>-->
					 <select placeholder="Select Country" class="selectpicker" id="floor" name="floor" required>
						
							<?php
								if(isset($floors_info) && !empty($floors_info))
								{
									foreach($floors_info as $floors1)
									{
										if($floors1['section_id']!=""){
											$section_ids=explode(",",$floors1['section_id']);
											$section_names=explode(",",$floors1['section_name']);
											$sections=array_combine($section_ids,$section_names);
											foreach($sections as $key=>$value){
									
								?>
												<option value="<?php echo $floors1['floor_id'].'_'.$key.'_'.$floors1['business_id']; ?>" ><?php echo $value.' - '.$floors1['floor_no'].' - '.$floors1['business_name']; ?></option>
								<?php
											}
										}
									}
								}
							?>
					 </select>
				</div>	
				</form>
				<div class="wrap " id="table_data">
				
				
		
			  </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  

<script type="text/javascript" src="<?php echo base_url();?>theme/js/daterangepicker.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>theme/js/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/jquery.timepicker.min.css" type="text/css"/>

<script src="<?php echo base_url().'theme/js/jquery-ui.js'; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'theme/css/jquery-ui.css'; ?>" />
<link rel="stylesheet" href="<?php echo base_url().'theme/css/qunit.css'; ?>" type="text/css"/>
 
<script language="javascript">

	$(document).ready(function()
		{
		
		   var floor_id=$("#floor").val();
		   var flr=floor_id.split("_");
		   var flr_id=flr[0];
		   var sec_id=flr[1];
		   var bus_id=flr[2];
			$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/get_occupancy_data",
			data :	{'floor_id':flr_id,'section_id':sec_id,'business_id':bus_id},
			success : function(data){

			$('#table_data').html(data);

			}

			});
         
		 
		    $("#floor").change(function()
			{
				var floor_id = $("#floor").val();
			   var flr=floor_id.split("_");
			   var flr_id=flr[0];
			   var sec_id=flr[1];
			    var bus_id=flr[2];
				var select_no_of_members=$('#select_no_of_members1').val();
				$.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/get_occupancy_data",
			data :	{'floor_id':flr_id,'section_id':sec_id,'business_id':bus_id},
			success : function(data){

			$('#table_data').html(data);

			}

			});
			});
			 
				
			
			/*$("#booked_date").datepicker({
				  dateFormat: "yy-mm-dd",
				  changeMonth: true,
				  changeYear: true 
				});		*/	

			$('#in_time').timepicker();
			
		});

</script>