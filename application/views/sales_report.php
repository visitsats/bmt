<div class="wrap mnone">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
			<h4><a href="<?php echo base_url();?>bookmyt/reports" class="btn">Back to Reports</a></h4>
				<h3 class="text-center">Sales Report</h3>
				<div class="col-xs-12 col-md-12 col-sm-12">	
					<h3>Revenue for Past 6 days</h3>					
					<form name="weekly" action="" method="post">
						<div class="form-group col-sm-2 col-md-2">
							<label class="form-lable" style="padding-top:7px;">Select Week : </label>
						</div>
						<div class="form-group col-sm-6 col-md-6">
							<?php
								$sunday = date( 'd-m-Y', strtotime( 'sunday previous week' ) );
								$saturday = date( 'd-m-Y', strtotime( 'saturday this week' ) );
							?>
							<input type="text" name="weekrange" id="weekpicker" value="<?php echo isset($_POST['weekrange'])?$_POST['weekrange']:$sunday." to ".$saturday; ?>" class="form-control"/>
						</div>	
						<div class="form-group col-sm-4 col-md-4">
							<input type="submit" name="submit" value="Submit" class="btn btn-success btn-xss" />
						</div>
					</form>
					<div class="col-md-9 col-sm-9">
						<div id="chart_div" class="chart"></div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3 hidden-xs" style="background-color:#ffffff;height:270px;">
						<table border="1" width="100%" style="margin-top:15px;">
							<tr>
								<th style="text-align:center">Day</th>
								<th style="text-align:center">Revenue</th>
							</tr>
						<?php
							$ttl=0;
							foreach($weekreport as $week){
								$ttl+=$week['bill_amount'];
						?>		
								<tr>
									<td><?php echo $week['day_name']; ?></td>
									<td align="center"><?php echo $week['bill_amount']; ?></td>
								</tr>
						<?php		
							}
						?>
							<tr>
								<th style="text-align:right">Total Revenue</th>
								<th style="text-align:center"><?php echo $ttl; ?></th>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-xs-12 col-md-12 col-sm-12">
					<?php //pr($this->session->all_userdata()); ?>
					<h3>Revenue per Year</h3>
					<form name="year" method="post" action="">
						<div class="form-group col-sm-2 col-md-2">
							<label class="form-lable" style="padding-top:7px;">Select Year : </label>
						</div>
						<div class="form-group col-sm-6 col-md-6">						
							<select name="year" id="year" class="form-control">								
								<?php 
									$i=0;
									for($i=0;$i<=10;$i++){
										$es_year=date('Y',strtotime($established_year[0]['created_ts']));
										
								?>
										<option value="<?php echo $i+$es_year; ?>" <?php if((isset($_POST['year']) && $_POST['year']==($i+$es_year)) || (!isset($_POST['year']) && date("Y")==($i+$es_year))){echo "selected=selected";}?>><?php echo $i+$es_year; ?></option>
								<?php
										
									}
								?>
							</select>
							</div>
						<div class="form-group col-sm-4 col-md-4">
							<input type="submit" name="submit" value="Submit" class="btn btn-success btn-xss"/>
						</div>
					</form>
					<div class="col-md-9 col-sm-9">
						<div id="chart_div1" class="chart"></div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3 hidden-xs" style="background-color:#ffffff;height:300px;border-left:1px solid #999999;">
						<table border="1" width="100%">
							<tr>
								<th style="text-align:center;">Month</th>
								<th style="text-align:center;">Revenue</th>
							</tr>
						<?php
							$total=0;
							foreach($yearlyreport as $year){
								$total+=$year['bill_amount'];
						?>	
								
									<tr>
										<td><?php echo substr($year['Period'],0,-4)."-".substr($year['Period'],-4); ?></td>
										<td align="center"><?php echo $year['bill_amount']; ?></td>
									</tr>								
						<?php		
							}
						?>
							<tr>
								<th style="text-align:right;">Total Revenue</th>
								<th style="text-align:center;"><?php echo $total; ?></th>
							</tr>
						</table>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>	
		</div>
	</div>
</div>
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />

<script type="text/javascript" src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
	google.load('visualization', '1', {packages: ['corechart'],annotationsWidth: 15});
</script>
<script type="text/javascript">
	  function drawVisualization1() {
        // Some raw data (not necessarily accurate)       
	    var data = google.visualization.arrayToDataTable([
          ['Week', 'Daily'],				
					
          ['<?php echo $weekreport[0]['day_name'];?>',  <?php echo $weekreport[0]['bill_amount'];?>],
		  ['<?php echo $weekreport[1]['day_name'];?>', <?php echo $weekreport[1]['bill_amount'];?>],		
          ['<?php echo $weekreport[2]['day_name'];?>', <?php echo $weekreport[2]['bill_amount'];?>],
					
          ['<?php echo $weekreport[3]['day_name'];?>', <?php echo $weekreport[3]['bill_amount'];?>],
		 ['<?php echo $weekreport[4]['day_name'];?>', <?php echo $weekreport[4]['bill_amount'];?>],	
		['<?php echo $weekreport[5]['day_name'];?>', <?php echo $weekreport[5]['bill_amount'];?>],
		['<?php echo $weekreport[6]['day_name'];?>',  <?php echo $weekreport[6]['bill_amount'];?>]							
        ]);

        var options = {
          
          vAxis: {title: "Revenue"},
          hAxis: {title: "",slantedText:true,},
				
          seriesType: "bars",
		  colors: [ '#F15A2A', '#D4A129'],
		  'width':'100%',
			'height':'100%',
		  bar: {groupWidth: '50%'},	
		  legend: "bottom"
          //'height':250
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization1);
	  function drawVisualization() {
        // Some raw data (not necessarily accurate)       
	    var data = google.visualization.arrayToDataTable([
          ['Week', 'Monthly'],				
					
          ['<?php echo $yearlyreport[0]['Period'];?>',  <?php echo $yearlyreport[0]['bill_amount'];?>],
		  ['<?php echo $yearlyreport[1]['Period'];?>', <?php echo $yearlyreport[1]['bill_amount'];?>],		
          ['<?php echo $yearlyreport[2]['Period'];?>', <?php echo $yearlyreport[2]['bill_amount'];?>],
					
          ['<?php echo $yearlyreport[3]['Period'];?>', <?php echo $yearlyreport[3]['bill_amount'];?>],
		 ['<?php echo $yearlyreport[4]['Period'];?>', <?php echo $yearlyreport[4]['bill_amount'];?>],	
		['<?php echo $yearlyreport[5]['Period'];?>', <?php echo $yearlyreport[5]['bill_amount'];?>],
		['<?php echo $yearlyreport[6]['Period'];?>',  <?php echo $yearlyreport[6]['bill_amount'];?>],
		['<?php echo $yearlyreport[7]['Period'];?>',  <?php echo $yearlyreport[7]['bill_amount'];?>],
		['<?php echo $yearlyreport[8]['Period'];?>',  <?php echo $yearlyreport[8]['bill_amount'];?>],
		['<?php echo $yearlyreport[9]['Period'];?>',  <?php echo $yearlyreport[9]['bill_amount'];?>],
		['<?php echo $yearlyreport[10]['Period'];?>',  <?php echo $yearlyreport[10]['bill_amount'];?>],
		['<?php echo $yearlyreport[11]['Period'];?>',  <?php echo $yearlyreport[11]['bill_amount'];?>]									
        ]);
        var options = {
          
          vAxis: {title: "Revenue"},
          hAxis: {title: "",slantedText:true,},
				
          seriesType: "bars",
		  colors: [ '#F15A2A', '#D4A129'],
		  'width':'100%',
			'height':'100%',
		  bar: {groupWidth: '50%'},	
		  legend: "bottom"
          //'height':250
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div1'));
        chart.draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization);
	  	  var startDate,
        endDate,
        selectCurrentWeek = function () {
            window.setTimeout(function () {
                $('#weekpicker').datepicker('widget').find('.ui-datepicker-current-day a').addClass('ui-state-active')
            }, 1);
        };
		var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	   $('#weekpicker').datepicker({
		"changeMonth": true,
        "changeYear": true,   
		dateFormat: 'dd-M-yy',
		format		: 'd-M-Y',
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
	  

</script>