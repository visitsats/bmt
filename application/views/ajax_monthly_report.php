<div id="chart_div">
</div>
		       <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Some raw data (not necessarily accurate)       
	    var data = google.visualization.arrayToDataTable([
          ['Month', '<?php echo $monthly_report[0]['day_name'];?>', 
		  			'<?php echo $monthly_report[1]['day_name'];?>', 
					'<?php echo $monthly_report[2]['day_name'];?>',
					'<?php echo $monthly_report[3]['day_name'];?>',
					'<?php echo $monthly_report[4]['day_name'];?>',
					'<?php echo $monthly_report[5]['day_name'];?>', 
					'<?php echo $monthly_report[6]['day_name'];?>',],				
					
          ['<?php echo "Week 1";?>',  <?php echo $monthly_report[0]['no_of_visits'];?>,
		  		    <?php echo $monthly_report[1]['no_of_visits'];?>,         
					<?php echo $monthly_report[2]['no_of_visits'];?>,
					<?php echo $monthly_report[3]['no_of_visits'];?>,
					<?php echo $monthly_report[4]['no_of_visits'];?>,
					<?php echo $monthly_report[5]['no_of_visits'];?>,
					<?php echo $monthly_report[6]['no_of_visits'];?> ],
					
          ['<?php echo "Week 2";?>',   <?php echo $monthly_report[7]['no_of_visits'];?>,
		  		    <?php echo $monthly_report[8]['no_of_visits'];?>,         
					<?php echo $monthly_report[9]['no_of_visits'];?>,
					<?php echo $monthly_report[10]['no_of_visits'];?>,
					<?php echo $monthly_report[11]['no_of_visits'];?>,
					<?php echo $monthly_report[12]['no_of_visits'];?>,
					<?php echo $monthly_report[13]['no_of_visits'];?>],
					
          ['<?php echo "Week 3";?>',  <?php echo $monthly_report[14]['no_of_visits'];?>,
		  		    <?php echo $monthly_report[15]['no_of_visits'];?>,         
					<?php echo $monthly_report[16]['no_of_visits'];?>,
					<?php echo $monthly_report[17]['no_of_visits'];?>,
					<?php echo $monthly_report[18]['no_of_visits'];?>,
					<?php echo $monthly_report[19]['no_of_visits'];?>,
					<?php echo $monthly_report[20]['no_of_visits'];?>],
		 ['<?php echo "Week 4";?>',  <?php echo $monthly_report[21]['no_of_visits'];?>,
		  		    <?php echo $monthly_report[22]['no_of_visits'];?>,         
					<?php echo $monthly_report[23]['no_of_visits'];?>,
					<?php echo $monthly_report[24]['no_of_visits'];?>,
					<?php echo $monthly_report[25]['no_of_visits'];?>,
					<?php echo $monthly_report[26]['no_of_visits'];?>,
					<?php echo $monthly_report[27]['no_of_visits'];?>],	
		['<?php echo "Week 5";?>',  <?php echo $monthly_report[28]['no_of_visits'];?>,
		  		    <?php echo $monthly_report[29]['no_of_visits'];?>,         
					<?php echo isset($monthly_report[30]['no_of_visits'])?$monthly_report[30]['no_of_visits']:"";?>,
					<?php echo isset($monthly_report[31]['no_of_visits'])?$monthly_report[31]['no_of_visits']:"";?>,
					<?php echo "0";?>,
					<?php echo "0";?>,
					<?php echo "0";?>]				
        ]);

        var options = {
          
          //vAxis: {title: "Registrants"},
          //hAxis: {title: "Year"},
				
          seriesType: "bars",
		  colors: ['#f18de7', '#67e8fe', '#f8d56d', '#f8976d', '#94f86d', '#6daef8', '#f86d7a'],
		  'width':450,
			'height':270,
		  bar:{groupWidth:'90%'}
          //'height':250
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      google.setOnLoadCallback(drawVisualization);
</script>