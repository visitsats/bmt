
    <div style="margin-top:100px"></div>
    <div class="container">
   	<div class="col-sm-2 col-md-12  tab">
	
	 <center>
      <?php
	 
		if($this->session->flashdata('success'))
		{
			echo "<span style='color:green'><b>".$this->session->flashdata('success')."</b></span>";
		}
		else
		{
			echo "<span style='color:red'><b>".$this->session->flashdata('fail')."</b></span>";
		}
	?>
	</center>
	<center><h4>Table Details</h4>
		<hr/>
		</center>
		<div style="margin-top:15px"></div>
       <div class="wrap m-none" style="margin-top:15px !important">
        <div class="col-sm-12">
          <div class="panel-one">
            <div class="panel-one-heading   ">
              <div class="container-fluid">
                <div class="row">
                  <div class="pull-right">
                     
                    <a href="<?php echo base_url()."bookmyt/add_table/"; ?>" class="btn btn-warning table-row-add"><i class="fa fa-plus"></i>Add Table</a> <br/><br/></div>
					<div class="clearfix"></div>
                </div>
              </div>
            </div>
            <div class="panel-one-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped m-none">
                  <thead>
                    <tr>
					 <th>Floor</th>
                      <th>Table No</th>
                      <th>No of seats</th>
                       <th class="text-center">Actions</th>
                    
                    </tr>
                  </thead>
                  <tbody>
				  <?php
				  foreach($tables->tables_list as $branch)
				  {
				 
				  ?>
                    <tr>
					<td><?php echo $branch->floor_no;?></td>
                      <td><?php echo $branch->table_no;?></td>
                      <td><?php echo $branch->no_of_seats;?></td>
                      
                      <td class="text-center"><a href="<?php echo base_url()."bookmyt/edit_table/".$branch->table_id; ?>" class=""><span class="label label-warning"><i class="fa fa-file-text-o"></i></span></a> <a onclick = "if(confirm('Are you sure you want to Delete (<?php echo $branch->table_no; ?>)')) { return true; } else {return false; }" href="<?php echo base_url()."bookmyt/delete_table/".$branch->table_id;?>" class=""><span class="label label-danger"><i class="fa fa-trash-o"></i></span></a></td>
                    </tr>
					<?php
					}
					?>
             
          
                  </tbody>
                </table>
              </div>
            </div>
           
          </div>
        </div>
      </div>
        </div>
       </div> 
