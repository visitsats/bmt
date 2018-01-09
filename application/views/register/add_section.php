  <div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-center">Add Section</h4>
          <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>-->
        </div> <div class='clearfix'></div>
		<center><span style="font-weight:bold;color:red;padding:10px !important;" id="error_sucess"></span></center>
        <div class="wrap mnone">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2"> 
		 	<div style="color:#FF0000">
			<?php
				echo validation_errors();
			?>
			</div>
            <div class="panelone  plr10">
			</center>
              <form role="form" class="wrap mt10">
			   <input type="hidden" name="relationship_id" value="<?php if($this->session->userdata('relationship_id') == '') { echo '';} else {echo $this->session->userdata('relationship_id'); }?>" />
			 	   
                <div class="form-group col-md-6">
				<label class="form-lable "> Section Name<span class="star">*</span></label>	
				 <input type="text" placeholder="" class="form-control" id="section_name"  name="section_name" maxlength="25" required>
                </div>
                <div class="form-group col-md-6">
				<label class="form-lable ">No of Tables<span class="star">*</span></label>
				 <input type="text" placeholder="" maxlength="3" class="form-control no_of_columns"   name="no_of_tables" required id="no_of_tables">
                </div>
                <div class="form-group col-md-6">
				<label class="form-lable ">No of rows</label>
				 <input type="text" placeholder="" maxlength="3" class="form-control"   name="no_of_rows" required id="no_of_rows"> 
                </div>
                <div class="form-group col-md-6">
				<label class="form-lable "> No of Columns</label>
				 <input type="text" placeholder="" maxlength="3" class="form-control no_of_columns"   name="no_of_columns" required id="no_of_columns">
				 <input type="hidden" name="floor_id" id="floor_id" value="<?php echo $floor_id; ?>" />
				 <input type="hidden" name="bus_id" id="bus_id" value="<?php echo $bus_id; ?>" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="floor-layout" style="text-align:center">
    <div class="table-responsive" id="sub_cat_data">
    
  </div>
  </div>
  <div class="form-group col-md-9">
  <a href="<?php echo base_url().'bookmyt/floors/'; ?>" class="btn btn-success pull-right" style="margin-left:5px">Cancel</a><button  class="btn btn-success pull-right icon-btn" type="button" onclick="save_tables()"> <i class="fa fa-plus-circle"></i> Save</button> </div>
    <div id="load_popup_data"></div>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#section_name").focus();
		});
		$('#no_of_tables,#no_of_rows,#no_of_columns').keydown(function(event) 
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
			$(".no_of_columns,#no_of_rows").keyup(function() 
			{
				var no_of_tables=$("#no_of_tables").val();
				var no_of_rows=$("#no_of_rows").val();
				var no_of_columns=$("#no_of_columns").val();
				
				
				if(parseInt(no_of_rows)>10)
				{
					$('#error_sucess').html("Please enter no of rows less than or equal to 10.");
					return false;
				}
				if(parseInt(no_of_columns)>10)
				{
					$('#error_sucess').html("Please enter no of columns less than or equal to 10.");
					return false;
				}
				if(parseInt(no_of_tables) > (parseInt(no_of_columns))*(parseInt(no_of_rows)))
				{
					//$('#error_sucess').show();
					$('#error_sucess').html("Multiplication of columns and rows should be grater than no of tables.");
					//$('#error_sucess').fadeOut(2000);
					return false;
				}
				else
				{
					$('#error_sucess').html("");
				}
			
					
						$.ajax({
						type :	"POST",
						url	 :	"<?php echo base_url();?>bookmyt/tables_arrange",
						data :	{'no_of_tables' : $("#no_of_tables").val(),'no_of_rows' : $("#no_of_rows").val(),'no_of_columns' : $("#no_of_columns").val()},
						success : function(data)
						{
							$('#sub_cat_data').html(data);
						
							$.ajax({
								type :	"POST",
								url	 :	"<?php echo base_url();?>bookmyt/getpopup",
								data :	{'no_of_tables' : $("#no_of_tables").val(),'no_of_rows' : $("#no_of_rows").val(),'no_of_columns' : $("#no_of_columns").val(),'floor_id':$("#floor_id").val()},
								success : function(data1){

								$('#load_popup_data').html(data1);

							}

							});	
						 
					 
					 

						}

				});
				
			
			});
			
			
			function click_model(id)
			{
			  $('#click_input_'+id).val(id)

			}
			function saveimg(imagename,id)
			{

			$("#save_images_"+id).val(imagename)

			}
            function checkDup(id){
				var t_nos=$("#table_no"+id).val();
				$.ajax({
						url		: '<?php echo base_url('bookmyt/table_unique');?>',
						type	: 'POST',
						data	: {floor_id:$("#floor_id").val(),t_no:t_nos},
						success	: function(data){										
										if($.trim(data)=="failure"){
											$("#tn"+id).html("Table number should be unique!");
											$("#submit"+id).attr("disabled",true);
											return false;											
										}else{
											$("#tn"+id).html("");
											$("#submit"+id).attr("disabled",false);
										}
									}
						
				});
			}
			var table_no = [];
			function save_pop(id)
			{	
				
				table_no = [];
				t_nos = $('#table_no'+id).val();	
				
				var shape=$('#selectpicker_'+id).val();	
				var seats=$('#no_seats_'+id).val();
				
				$('#table_no'+id).change(function()
				{
					if($('#table_no'+id).val() != "")
					{
						$('#table_no'+id).removeClass('error');
					}
				});
				
				$('#no_seats_'+id).change(function()
				{
					if($('#no_seats_'+id).val() != "")
					{
						$('#no_seats_'+id).removeClass('error');
					}
				});
				
				$('#selectpicker_'+id).change(function()
				{
					if($('#selectpicker_'+id).val() != "")
					{
						$("[data-id=selectpicker_"+id+"]").removeClass('error');
					}
				});
				
				
				var bad = [];
				if(t_nos == "")
				{
					bad.push('e1');
				}
				if(seats == "" || seats == '0')
				{
					bad.push('e2');
				}
				if(shape == "")
				{
					bad.push('e3');
				}
				
				if(bad.length != 0)
				{
					if($.inArray("e1", bad) !== -1){ $('#table_no'+id).addClass('error'); } else { $('#table_no'+id).removeClass('error'); }
					if($.inArray("e2", bad) !== -1){ $('#no_seats_'+id).addClass('error'); } else { $('#no_seats_'+id).removeClass('error'); }
					if($.inArray("e3", bad) !== -1){ $("[data-id=selectpicker_"+id+"]").addClass('error');	 } else { $("[data-id=selectpicker_"+id+"]").removeClass('error'); }					
					return false;
				}
				else
				{
					$('#table_no'+id).removeClass('error');
					$('#no_seats_'+id).removeClass('error');
					$("[data-id=selectpicker_"+id+"]").removeClass('error');
					bad = [];
				}
				
				$("input:text[name=table_no]").each(function()
				{
					if($(this).val()!='' && $(this).attr('id')!='table_no'+id)
					{
						table_no.push($(this).val());
					}
				});
				
				var found = $.inArray(t_nos, table_no);
				
				if (found != -1) 
				{
					$("#tn"+id).html("Table number should be unique!");
					$('#table_no'+id).addClass('error');
					return false;
				}
				else
				{
					$("#tn"+id).html("");
					$('#table_no'+id).removeClass('error');
					table_no.push(t_nos);
				}
				var no_of_tables=parseInt($('#no_of_tables').val());
				
			   if(table_no.length > no_of_tables )
				{
					//$(".close").click();
					//$("#error_sucess").show();
					$("#tn"+id).html("You can't add the table more than No of tables!");
					//$("#error_sucess").fadeOut(2000);
					$('#no_seats_'+id).val('');  
					$('#table_no'+id).val(''); 			
					return false;
				}
				else
				{
					$("#tn"+id).html("");
				}
							
				
				$('#table_no'+id).val(t_nos);
				$('#del_'+id).show();
				var text = $('#click_model_'+id).text();
				if($('#del_'+id).show())
				{
					$('#click_model_'+id).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
				}
				else
				{
					$('#click_model_'+id).html('<i class="fa fa-plus" aria-hidden="true"></i>');
				}
				//var shape=$('#selectpicker_'+id).val();
				
				$('#save_images_'+id).val(seats+''+shape+'.jpg');
				$('#table_type_'+id).val(shape);
				if(seats > 8)
				{
					$('#change_capacity_'+id).html(seats);
				}
				else
				{
					$('#change_capacity_'+id).html(seats);
				}
				$("#change_table_"+id).html("Table "+t_nos);
				$('#change_color_'+id).removeClass($('#change_color_'+id).attr('class'));
			
				
				if($('#no_seats_'+id).val()>8)
				{
					$('#change_color_'+id).addClass('tb '+shape+' t8 green')
				}
				else
				{
				
					if(seats%2==0)
					{
						$('#change_color_'+id).addClass('tb '+shape+' t'+seats+' green')
					}
					else
					{
						var seats1=Number(seats)+Number(1);
						$('#change_color_'+id).addClass('tb '+shape+' t'+seats1+' green')
					
					}

				}
				$("#error_sucess").html("");
				$('.close').trigger('click');
				$(".hover").hide();
			}
			
			
			function save_tables()
			{
				var error = [];
				var no_of_tables=$("#no_of_tables").val();
				var no_of_rows=parseInt($("#no_of_rows").val());
				var no_of_columns=parseInt($("#no_of_columns").val());
				
				if(no_of_rows>10)
				{
					$('#error_sucess').html("Please enter no of rows less than or equal to 10.");
					return false;
				}
				if(no_of_columns>10)
				{
					$('#error_sucess').html("Please enter no of columns less than or equal to 10.");
					return false;
				}
				if(parseInt(no_of_tables) > (parseInt(no_of_columns))*(parseInt(no_of_rows)))
				{
					$('#error_sucess').html("Multiplication of columns and rows should be greater than no of tables.");
					return false;
				}
				else
				{
					$('#error_sucess').html("");
				}
				
				/*if($.trim($("#business_id").val()) =='')
				{
					error.push('e1');
				}*/
				if($.trim($("#section_name").val()) =='')
				{
					error.push('e2');
				}
				if($.trim($("#no_of_tables").val()) =='' || $.trim($("#no_of_tables").val()) == 0)
				{
					error.push('e3');
				}
				if($.trim($("#no_of_rows").val()) =='0')
				{
					error.push('e4');
				}
				if($.trim($("#no_of_columns").val()) =='0')
				{
					error.push('e5');
				}
				
				if(error.length != 0)
				{
					/*if($.inArray("e1", error) !== -1){ $("#business_id").addClass('error'); } else { $("#business_id").removeClass('error'); }*/
					if($.inArray("e2", error) !== -1){ $("#section_name").addClass('error');$("#section_name").focus(); } else { $("#section_name").removeClass('error'); }
					if($.inArray("e3", error) !== -1){ $("#no_of_tables").addClass('error');$("#no_of_tables").focus(); } else { $("#no_of_tables").removeClass('error'); }
					if($.inArray("e4", error) !== -1){ $("#no_of_rows").addClass('error');$("#no_of_rows").focus(); } else { $("#no_of_rows").removeClass('error'); }
					if($.inArray("e5", error) !== -1){ $("#no_of_columns").addClass('error');$("#no_of_columns").focus(); } else { $("#no_of_columns").removeClass('error'); }
					return false;
				}
				else
				{
					//$("#business_id").removeClass('error');
					$("#section_name").removeClass('error');
					$("#no_of_tables").removeClass('error');
					$("#no_of_rows").removeClass('error');
					$("#no_of_columns").removeClass('error');error = [];
				}
		
				
			var tables = new Array();
			$("input:text[name=tables]").each(function(){
			tables.push($(this).val());
			});
			
			var images = new Array();
			$("input:text[name=images]").each(function(){
			images.push($(this).val());
			});
			
			var table_no = new Array();
			$("input:text[name=table_no]").each(function(){
			table_no.push($(this).val());
			});
			
			var serialno = new Array();
			$("input:text[name=serialno]").each(function(){
			serialno.push($(this).val());
			});
			
			var table_type = new Array();
			$("input:text[name=table_type]").each(function(){
			table_type.push($(this).val());
			});
			
			var business_id=$('#bus_id').val();
		   
		   $.ajax({
			type :	"POST",
			url	 :	"<?php echo base_url();?>bookmyt/addsection",
			data :	{'no_of_floors':$("#no_of_floors").val(),'section_name' : $("#section_name").val(),'tables':tables,'serialno':serialno,'table_no':table_no,'no_of_tables':$("#no_of_tables").val(),'images':images,
			'no_of_rows':$("#no_of_rows").val(),'no_of_columns':$("#no_of_columns").val(),'table_type':table_type,'business_id':business_id,'floor_id':$("#floor_id").val()},
			success : function(data)
			{
				if($.trim(data)==1)
				{
					while(tab_nos.length > 0) 
					{
						tab_nos.pop();
					}
				}
				alert(data);
				window.location='<?php echo base_url();?>bookmyt/section_list/'+$("#floor_id").val();

			}

			});   
			
			}			
				
			$("#section_name,#no_of_tables,#no_of_rows,#no_of_columns").change(function()
			{
				if($.trim($("#section_name").val()) !='')
				{
					$("#section_name").removeClass('error');
					
				}
				if($.trim($("#no_of_tables").val()) !='')
				{
					$("#no_of_tables").removeClass('error');
					
				}
				if($.trim($("#no_of_rows").val()) !='0')
				{
					$("#no_of_rows").removeClass('error');
					
				}
				if($.trim($("#no_of_columns").val()) !='0')
				{
					$("#no_of_columns").removeClass('error');
				}
				
			});
			
			
			function delete_table(id)
			{
			
				if(confirm("Are you sure you want to delete the table")){
					$('#save_images_'+id).val('');
					$('#table_type_'+id).val('');
					$('#change_capacity_'+id).html('');
					$('#no_seats_'+id).val('');	
					$('#table_no'+id).val('');
					$("#selectpicker_"+id+" option[value='']").attr("selected","selected"); 
					$('#change_color_'+id).removeClass($('#change_color_'+id).attr('class'));
					$('#change_color_'+id).addClass('tb rectangle six green');
					$('#del_'+id).hide();
					var text = $('#click_model_'+id).text();
					if($.trim(text) == 'add')
					{
						$('#click_model_'+id).html('<i class="fa fa-pencil" aria-hidden="true">');
					}
					else
					{
						$('#click_model_'+id).html('<i class="fa fa-plus" aria-hidden="true">');
					}
				}
			}
		$("body").delegate(".tb",'click',function(){			
			$(".hover").hide();
			$(".hover",this).show();
		});
		
	  </script>