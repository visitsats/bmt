<style>
thead {
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit;
	background-color :burlywood;
	color:#fff;
	font-weight:bold
}
tr td{
	padding:5px !important
}
</style>
 <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4><a href="<?php echo base_url();?>bookmyt/admin_dashboard">Dashboard</a></h4>
        </div>
			<div class='clearfix'></div>
			
        <div class="wrap mnone">
		
		<!-- Add users form starts here -->
          <div class="clearfix"></div>
		<!-- <h4 class="mt15">Business Information</h4> -->
		<!-- Users list starts from here -->
            <div class="wrap mnone">
			<div class="table-responsive">
			<div class="col-md-4">
              <table class="table table-style-one table-striped">
                <tbody>
					<tr>
                      <td>Business name</td>
                      <td><?php echo $business_info[0]['business_name']?></td>
					</tr>
					<tr>
                      <td>No of Floors</td>
                      <td><?php echo count($business_info)?></td>
					</tr>
					<tr>
                      <td>Number of users</td>
                      <td><?php echo count($business_user_info)?></td>
					</tr>
					<tr>
                      <td>Last Login</td>
                      <td><?php echo ($business_info[0]['last_login']!='' && $business_info[0]['last_login']!='0000-00-00 00:00:00') ? date('m/d/Y h:i a',strtotime($business_info[0]['last_login'])) : '';?></td>
					</tr>
				</tbody>
				</table>
				</div>
				<div class="col-md-4">
				<table class="table table-style-one table-striped">
					<thead class="active">
					<tr>
                      <td>Floor Name</td>
                      <td>Tables Count</td>
					</tr>
					</thead>
					<tbody>
					<?php foreach($business_info as $floor){ ?>		
					<tr>
                      <td><?php echo $floor['floor_no']?></td>
                      <td><?php echo $floor['table_count']?></td>
					</tr>					
					<?php } ?>
				</tbody>
				</table>
				</div>
				<div class="col-md-4">
				<table class="table table-style-one table-striped">
				
					<?php if(count($business_user_info)>0){?>
					<thead class="active">
					<tr>
                      <td>User Name</td>
                      <td>Last Name</td>
					</tr>
					</thead>
					<tbody>
					<?php if(is_array($business_user_info) && count($business_user_info)>0){
					foreach($business_user_info as $user){ ?>		
					<tr>
                      <td><?php echo $user['username']?></td>
                      <td><?php echo ($user['last_login']!='' && $user['last_login']!='0000-00-00 00:00:00') ? date('m/d/Y h:i a',strtotime($user['last_login'])) : '';?></td>
					</tr>					
					<?php } } ?>
                </tbody>
				<?php } ?>
              </table>
			  </div>
			  <div class="clearfix"></div>
			  
			  <?php if(is_array($business_bracnch_info_array) && count($business_bracnch_info_array)>0){
			  ?>
			  
			  <?php $i=0;
			  foreach($business_bracnch_info_array as $key => $brach){
			  $i++;
			  ?> 
			  <div class="clearfix"></div>
			  <h6>Brach business <?php echo $i; ?></h6>
			  <div class="clearfix"></div>
			  <div class="col-md-4">
			  
			  <table class="table table-style-one table-striped">
                <tbody>
					<tr>
                      <td>Branch name</td>
                      <td><?php echo $brach[0]['business_name']?></td>
					</tr>
					<tr>
                      <td>No of Floors</td>
                      <td><?php echo (count($brach)==1 && $brach[0]['floor_no']!='' && $brach[0]['table_count']>0) ? count($brach) : 0?></td>
					</tr>
					<tr>
                      <td>Number of users</td>
                      <td><?php echo count($branch_user_info[$key])?></td>
					</tr>
					<tr>
                      <td>Last Login</td>
                      <td><?php echo ($brach[0]['last_login']!='' && $brach[0]['last_login']!='0000-00-00 00:00:00') ? date('m/d/Y h:i a',strtotime($brach[0]['last_login'])) : '';?></td>
					</tr>
				</tbody>
				</table>
				</div>
				<?php if(count($brach)==1 && $brach[0]['floor_no']!='' && $brach[0]['table_count']>0) { ?>
				<div class="col-md-4">
				<table class="table table-style-one table-striped">
					<thead class="active">
					<tr>
                      <td>Floor Name</td>
                      <td>Tables Count</td>
					</tr>
					</thead>
					<tbody>
					<?php if(is_array($brach) && count($brach)>0) { 
					foreach($brach as $floor){
					if($floor['floor_no']!='' && $floor['table_count']>0){
					?>		
					<tr>
                      <td><?php echo $floor['floor_no']?></td>
                      <td><?php echo $floor['table_count']?></td>
					</tr>					
					<?php } } } ?>
				</tbody>
				</table>
				</div>
				<?php } else{ ?>
				<div class="col-md-4">
				<table class="table table-style-one table-striped">
					<thead class="active">
					<tr>
                      <td>Floor Name</td>
                      <td>Tables Count</td>
					</tr>
					</thead>
					<tbody>
					<tr>
                      <td colspan="2">No Floors Added.</td>
                    </tr>					
				</tbody>
				</table>
				</div>
				<?php } ?>
				<div class="col-md-4">
			    <table class="table table-style-one table-striped">
					<?php if(count($branch_user_info[$key])>0){?>
					<thead>
					<tr>
                      <td>User Name</td>
                      <td>Last Name</td>
					</tr>
					</thead>
					<tbody>
					<?php if(is_array($branch_user_info[$key]) && count($branch_user_info[$key])>0){
					foreach($branch_user_info[$key] as $user){ ?>		
					<tr>
                      <td><?php echo $user['username']?></td>
                      <td><?php echo ($user['last_login']!='' && $user['last_login']!='0000-00-00 00:00:00') ? date('m/d/Y H:i',strtotime($user['last_login'])) : '';?></td>
					</tr>					
					<?php } } ?>
                </tbody>
				<?php }else{ ?>
				<thead>
					<tr>
                      <td>User Name</td>
                      <td>Last Name</td>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td colspan="2">No Users.</td>
					</tr>
					</tbody>
				<?php } ?>
              </table>
			  </div>
			  <?php } ?>
			  <div class="clearfix"></div>
			  <?php } ?>
			  <div class="clearfix"></div>
			 </div>
			 
            </div>
			
		<!-- Users list ends here -->
          </div>
        </div>
      </div>
    </div>
  </div>
