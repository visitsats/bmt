<?php /*?><script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
			$(document).ready( function() {
				$('#example').dataTable( {
					"bJQueryUI": true,
			         "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 5] }], 
					"sPaginationType": "full_numbers",
					"aaSorting": [[ 0, 'desc' ]]
		 
				} );
			} );
	</script><?php */?>
<div class="wrap mnone">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
        
		
		
		

   <h3 class="text-center">Dashbord</h3>
          
       

<div class="wrap mytabs-one ">
<ul  class="nav nav-pills ">
<li class="active"><a href="#3a" data-toggle="tab">Daily Report</a></li>
<li><a href="#2a" data-toggle="tab">Weekly Report</a>
			</li>
			<li >
        <a  href="#1a" data-toggle="tab">Monthly Report </a>
			</li>
			
			
			
  		
		</ul>


<div class="panelone ">
			<div class="tab-content clearfix">
			       <div class="tab-pane active" id="3a">
         
		<div class="clearfix"></div>
				<div id="chart_div2">
				</div>
		 
				</div>
			  <div class="tab-pane " id="1a">
         
		 <div class="form-group col-sm-12 col-md-12">
					<form name="month" action="" method="post">
						<div class="form-group col-sm-2 col-md-2">
							<label class="form-lable" style="padding-top:7px;">Select Month :</label>
						</div>
						<div class="form-group col-sm-3 col-md-3">	
							<select name="month" id="month" class="form-control">								
								<option value="01" <?php if((isset($_POST['month']) && $_POST['month']=="01") || (!isset($_POST['month']) && date("m")=="01"))echo "selected=selected"; ?>>January</option>
								<option value="02" <?php if((isset($_POST['month']) && $_POST['month']=="02") || (!isset($_POST['month']) && date("m")=="02"))echo "selected=selected"; ?>>February</option>
								<option value="03" <?php if((isset($_POST['month']) && $_POST['month']=="03") || (!isset($_POST['month']) && date("m")=="03"))echo "selected=selected"; ?>>March</option>
								<option value="04" <?php if((isset($_POST['month']) && $_POST['month']=="04") || (!isset($_POST['month']) && date("m")=="04"))echo "selected=selected"; ?>>April</option>
								<option value="05" <?php if((isset($_POST['month']) && $_POST['month']=="05") || (!isset($_POST['month']) && date("m")=="05"))echo "selected=selected"; ?>>May</option>
								<option value="06" <?php if((isset($_POST['month']) && $_POST['month']=="06") || (!isset($_POST['month']) && date("m")=="06"))echo "selected=selected"; ?>>June</option>
								<option value="07" <?php if((isset($_POST['month']) && $_POST['month']=="07") || (!isset($_POST['month']) && date("m")=="07"))echo "selected=selected"; ?>>July</option>
								<option value="08" <?php if((isset($_POST['month']) && $_POST['month']=="08") || (!isset($_POST['month']) && date("m")=="08"))echo "selected=selected"; ?>>August</option>
								<option value="09" <?php if((isset($_POST['month']) && $_POST['month']=="09") || (!isset($_POST['month']) && date("m")=="09"))echo "selected=selected"; ?>>September</option>
								<option value="10" <?php if((isset($_POST['month']) && $_POST['month']=="10") || (!isset($_POST['month']) && date("m")=="10"))echo "selected=selected"; ?>>October</option>
								<option value="11" <?php if((isset($_POST['month']) && $_POST['month']=="11") || (!isset($_POST['month']) && date("m")=="11"))echo "selected=selected"; ?>>November</option>
								<option value="12" <?php if((isset($_POST['month']) && $_POST['month']=="12") || (!isset($_POST['month']) && date("m")=="12"))echo "selected=selected"; ?>>December</option>
							</select>
						</div>
						<div class="form-group col-sm-3 col-md-3">	
							<select name="year" id="year" class="form-control">								
								<?php 
									$i=0;
									for($i=0;$i<=10;$i++){
										
								?>
										<option value="<?php echo $i+2016; ?>" <?php if((isset($_POST['year']) && $_POST['year']==($i+2016)) || (!isset($_POST['year']) && date("Y")==($i+2016))){echo "selected=selected";}?>><?php echo $i+2016; ?></option>
								<?php
										
									}
								?>
							</select>
						</div>
						<div class="form-group col-sm-4 col-md-4">
							<input type="submit" name="submit" value="Submit" class="btn btn-success btn-xss"/>
						</div>
					</form>
				</div>
				<div class="clearfix"></div>
				<div  id="chart_div">
				</div>	
		 
		 
				</div>
				<div class="tab-pane" id="2a">
          
		  	<div class="form-group col-xs-12 col-md-12">
					<form name="weekly" action="" method="post">
						<div class="form-group col-sm-2 col-md-2">
							<label class="form-lable" style="padding-top:7px;">Select Week : </label>
						</div>
						<div class="form-group col-sm-6 col-md-6">
							<?php
								$sunday = date( 'Y-m-d', strtotime( 'sunday previous week' ) );
								$saturday = date( 'Y-m-d', strtotime( 'saturday this week' ) );
							?>
							<input type="text" name="weekrange" id="weekpicker" value="<?php echo isset($_POST['weekrange'])?$_POST['weekrange']:$sunday." to ".$saturday; ?>" class="form-control"/>
						</div>	
						<div class="form-group col-sm-4 col-md-4">
							<input type="submit" name="submit" value="Submit" class="btn btn-success btn-xss" />
						</div>
					</form>
				</div>
				<div class="clearfix"></div>
				<div id="chart_div1">
				</div>
		  
		  
				</div>
 
          
			</div>
</div>
</div>
		
		
		
		
		 
         <!-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br/>
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p> -->
        </div>
		<div class='clearfix'></div>
			
        
		  <div class="clearfix"></div>
		  <h3><a href="<?php echo base_url('bookmyt/feedback_report'); ?>">Click Here</a> to view the Feedback report</h3>
		  
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		       <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      
	  
	  function drawVisualization() {
	 
		 var oldData = google.visualization.arrayToDataTable([
          ['Week', 'New Customers','Old Customers'],				
					
          ['<?php echo $monthly_report[0]['day_name'];?>',  <?php echo $monthly_report[0]['new_visits'];?>,<?php echo $monthly_report[0]['old_visits'];?>],
		  ['<?php echo $monthly_report[1]['day_name'];?>', <?php echo $monthly_report[1]['new_visits'];?>,<?php echo $monthly_report[1]['old_visits'];?>],		
          ['<?php echo $monthly_report[2]['day_name'];?>', <?php echo $monthly_report[2]['new_visits'];?>,<?php echo $monthly_report[2]['old_visits'];?>],
					
          ['<?php echo $monthly_report[3]['day_name'];?>', <?php echo $monthly_report[3]['new_visits'];?>,<?php echo $monthly_report[3]['old_visits'];?>],
		 ['<?php echo $monthly_report[4]['day_name'];?>', <?php echo $monthly_report[4]['new_visits'];?>,<?php echo $monthly_report[4]['old_visits'];?>],	
		['<?php echo $monthly_report[5]['day_name'];?>', <?php echo $monthly_report[5]['new_visits'];?>,<?php echo $monthly_report[5]['old_visits'];?>],
		['<?php echo $monthly_report[6]['day_name'];?>',  <?php echo $monthly_report[6]['new_visits'];?>,<?php echo $monthly_report[6]['old_visits'];?>],
		
		 ['<?php echo $monthly_report[7]['day_name'];?>',  <?php echo $monthly_report[7]['new_visits'];?>,<?php echo $monthly_report[7]['old_visits'];?>],
		  ['<?php echo $monthly_report[8]['day_name'];?>', <?php echo $monthly_report[8]['new_visits'];?>,<?php echo $monthly_report[8]['old_visits'];?>],		
          ['<?php echo $monthly_report[9]['day_name'];?>', <?php echo $monthly_report[9]['new_visits'];?>,<?php echo $monthly_report[9]['old_visits'];?>],
					
          ['<?php echo $monthly_report[10]['day_name'];?>', <?php echo $monthly_report[10]['new_visits'];?>,<?php echo $monthly_report[10]['old_visits'];?>],
		 ['<?php echo $monthly_report[11]['day_name'];?>', <?php echo $monthly_report[11]['new_visits'];?>,<?php echo $monthly_report[11]['old_visits'];?>],	
		['<?php echo $monthly_report[12]['day_name'];?>', <?php echo $monthly_report[12]['new_visits'];?>,<?php echo $monthly_report[12]['old_visits'];?>],
		['<?php echo $monthly_report[13]['day_name'];?>',  <?php echo $monthly_report[13]['new_visits'];?>,<?php echo $monthly_report[13]['old_visits'];?>]	,
		 ['<?php echo $monthly_report[14]['day_name'];?>',  <?php echo $monthly_report[14]['new_visits'];?>,<?php echo $monthly_report[14]['old_visits'];?>],
		  ['<?php echo $monthly_report[15]['day_name'];?>', <?php echo $monthly_report[15]['new_visits'];?>,<?php echo $monthly_report[15]['old_visits'];?>],		
          ['<?php echo $monthly_report[16]['day_name'];?>', <?php echo $monthly_report[16]['new_visits'];?>,<?php echo $monthly_report[16]['old_visits'];?>],
					
          ['<?php echo $monthly_report[17]['day_name'];?>', <?php echo $monthly_report[17]['new_visits'];?>,<?php echo $monthly_report[17]['old_visits'];?>],
		 ['<?php echo $monthly_report[18]['day_name'];?>', <?php echo $monthly_report[18]['new_visits'];?>,<?php echo $monthly_report[18]['old_visits'];?>],	
		['<?php echo $monthly_report[19]['day_name'];?>', <?php echo $monthly_report[19]['new_visits'];?>,<?php echo $monthly_report[19]['old_visits'];?>],
		['<?php echo $monthly_report[20]['day_name'];?>',  <?php echo $monthly_report[20]['new_visits'];?>,<?php echo $monthly_report[20]['old_visits'];?>],
		 ['<?php echo $monthly_report[21]['day_name'];?>',  <?php echo $monthly_report[21]['new_visits'];?>,<?php echo $monthly_report[21]['old_visits'];?>],
		  ['<?php echo $monthly_report[22]['day_name'];?>', <?php echo $monthly_report[22]['new_visits'];?>,<?php echo $monthly_report[22]['old_visits'];?>],		
          ['<?php echo $monthly_report[23]['day_name'];?>', <?php echo $monthly_report[23]['new_visits'];?>,<?php echo $monthly_report[23]['old_visits'];?>],
					
          ['<?php echo $monthly_report[24]['day_name'];?>', <?php echo $monthly_report[24]['new_visits'];?>,<?php echo $monthly_report[24]['old_visits'];?>],
		 ['<?php echo $monthly_report[25]['day_name'];?>', <?php echo $monthly_report[25]['new_visits'];?>,<?php echo $monthly_report[25]['old_visits'];?>],	
		['<?php echo $monthly_report[26]['day_name'];?>', <?php echo $monthly_report[26]['new_visits'];?>,<?php echo $monthly_report[26]['old_visits'];?>],
		['<?php echo $monthly_report[27]['day_name'];?>',  <?php echo $monthly_report[27]['new_visits'];?>,<?php echo $monthly_report[27]['old_visits'];?>],
		 ['<?php echo $monthly_report[28]['day_name'];?>',  <?php echo $monthly_report[28]['new_visits'];?>,<?php echo $monthly_report[28]['old_visits'];?>],
		  ['<?php echo $monthly_report[29]['day_name'];?>', <?php echo $monthly_report[29]['new_visits'];?>,<?php echo $monthly_report[29]['old_visits'];?>],		
          ['<?php echo $monthly_report[30]['day_name'];?>', <?php echo $monthly_report[30]['new_visits'];?>,<?php echo $monthly_report[30]['old_visits'];?>]
							
        ]);
		
		
		
	 

var options = {
          
          vAxis: {title: "Visits"},
         
				
          seriesType: 'bars',
      series: {1: {type: 'line'}},
		  colors: [ '#F15A2A', '#D4A129'],
		  'width':900,
			'height':270,
		  bar: {groupWidth: '95%'},
		  hAxis: {showTextEvery: 0},
hAxis: {slantedText:'true'},
hAxis: {slantedTextAngle: '45'},
          //'height':250
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(oldData, options);
		}
      google.setOnLoadCallback(drawVisualization);
	  
	  /*$("#month").on('change',function(){
	  	var month=$(this).val();
		$.ajax({
				'url'		: '<?php echo base_url("bookmyt/getPieChart"); ?>',
				'type'		: 'POST',
				'data'		: {month:month},
				'success'	: function(data){
									alert(data);
								}
		})
	  });*/
	  
	  function drawVisualization1() {
        // Some raw data (not necessarily accurate)       
	    var data = google.visualization.arrayToDataTable([
          ['Week', 'New Customers','Old Customers'],				
					
          ['<?php echo $weekly_report[0]['day_name'];?>',  <?php echo $weekly_report[0]['new_visits'];?>,<?php echo $weekly_report[0]['old_visits'];?>],
		  ['<?php echo $weekly_report[1]['day_name'];?>', <?php echo $weekly_report[1]['new_visits'];?>,<?php echo $weekly_report[1]['old_visits'];?>],		
          ['<?php echo $weekly_report[2]['day_name'];?>', <?php echo $weekly_report[2]['new_visits'];?>,<?php echo $weekly_report[2]['old_visits'];?>],
					
          ['<?php echo $weekly_report[3]['day_name'];?>', <?php echo $weekly_report[3]['new_visits'];?>,<?php echo $weekly_report[3]['old_visits'];?>],
		 ['<?php echo $weekly_report[4]['day_name'];?>', <?php echo $weekly_report[4]['new_visits'];?>,<?php echo $weekly_report[4]['old_visits'];?>],	
		['<?php echo $weekly_report[5]['day_name'];?>', <?php echo $weekly_report[5]['new_visits'];?>,<?php echo $weekly_report[5]['old_visits'];?>],
		['<?php echo $weekly_report[6]['day_name'];?>',  <?php echo $weekly_report[6]['new_visits'];?>,<?php echo $weekly_report[6]['old_visits'];?>]							
        ]);

        var options = {
          
          vAxis: {title: "Visits"},
          hAxis: {title: ""},
				
          seriesType: "bars",
		  colors: [ '#F15A2A', '#D4A129'],
		  'width':900,
			'height':270,
		  bar: {groupWidth: '50%'},	
		  legend: "bottom"
          //'height':250
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div1'));
        chart.draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization1);
	  
	  var startDate,
        endDate,
        selectCurrentWeek = function () {
            window.setTimeout(function () {
                $('#weekpicker').datepicker('widget').find('.ui-datepicker-current-day a').addClass('ui-state-active')
            }, 1);
        };
	   $('#weekpicker').datepicker({
		"changeMonth": true,
        "changeYear": true,   
		dateFormat: 'dd-mm-yy',
        "showOtherMonths": false,
        "selectOtherMonths": false,
        "onSelect": function (dateText, inst) {
            var date = $(this).datepicker('getDate'),
            dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
            $('#weekpicker').val($.datepicker.formatDate(dateFormat, startDate, inst.settings) + ' to ' + $.datepicker.formatDate(dateFormat, endDate, inst.settings));
            selectCurrentWeek();
			var datesaved='';
		},
        "beforeShow": function () {
            selectCurrentWeek();
        },
        "beforeShowDay": function (date) {
            var cssClass = '';
            if (date >= startDate && date <= endDate) {
                cssClass = 'ui-datepicker-current-day';
            }
            return [true, cssClass];
        },
        "onChangeMonthYear": function (year, month, inst) {
            selectCurrentWeek();
        }
    })
	  
	  function drawVisualization2() {

        var data = google.visualization.arrayToDataTable([
          ['Day', '<?php echo date("D");?>'],
          ['New Customers',     <?php echo isset($daily_report[0]['new_visits'])?$daily_report[0]['new_visits']:"0";?>],
          ['Old Customers',      <?php echo isset($daily_report[0]['old_visits'])?$daily_report[0]['old_visits']:"0";?>]
        ]);

        var options = {
          title: 'Daily Report',
		  colors: [ '#F15A2A', '#D4A129']
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));

        chart.draw(data, options);
      }
	  
	
      google.setOnLoadCallback(drawVisualization2); 
	  
    </script>