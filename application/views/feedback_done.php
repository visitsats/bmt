<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Reward Points</h4>
		 
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
				<div class="form-group col-md-12">
				
				<div class="form-group col-md-12">
				<label class="form-lable ">Thank you: We Appreciate your valuable feedback.</label>
				</div>
				<div class="form-group col-md-12">
				<?php
					if($reward_info[0]['rewards']>0){
				?>
				<label class="form-lable ">Congratulations! Your earned rewards points: <?php echo $reward_info[0]['rewards']; ?></label>
				<?php
					}
				?>
				</div>
				 <div class="form-group col-md-12"><a href="<?php echo base_url().'bookmyt/reservation_list/'; ?>" style="margin-left:5px" class="btn btn-success pull-right">Reservation List</a> 
				  </div>				  
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
 <script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function(){ location.href="<?php echo base_url().'bookmyt/reservation_list/'; ?>"; }, 10000);
	});
</script>
