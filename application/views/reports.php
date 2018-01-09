<div class="wrap mnone">
	<div class="container">
		<div class="row">
			<div class="chart-bgcol">
				<div class="container">
					<h4><a href="<?php echo base_url();?>bookmyt/reports" class="btn">Back to Reports</a></h4>
					<h2 class="text-center" style="margin-bottom:20px;">Customer Report</h2>
					<div class="text-right" style="margin-right:10px;padding:5px;"><a href="<?php echo base_url('bookmyt/detailed_report'); ?>" class="btn btn-success btn-xss">Detailed Report</a></div>
					<div class="row">
						<div class="col-md-6">
							<div class="box box-success">
								<div class="box-header with-border">
									<h3 class="box-title">Daily</h3>
								</div>
								<div class="box-body">
									<div class=" ">
										<canvas id="chart-area" style="height: 240px; width: 582px;" height="290" width="582"></canvas>
									</div>
								</div>            
							</div>
						</div> <!-- /.box-body -->
						<div class="col-md-6">             
							<div class="box box-danger">
								<div class="box-header with-border">
									<h3 class="box-title">Weekly</h3>
								</div>
								<div class="box-body">
									<div class=" ">
										<canvas id="myBarChart" style="height: 240px; width: 582px;" height="290" width="582"></canvas>
									</div>
								</div>            
							</div>
						</div> <!-- /.box-body -->
					</div>
				</div>
				<hr>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title col-xs-12">Monthly</h3>
									<?php
										for ($i = 0; $i <= 11; $i++){
											$months= date("M-Y", strtotime( date( 'Y-m-01' )." -$i months"));
									?>		
											<p id="randomizeData_<?php echo $i; ?>" class=" pull-right m10" ><a href="<?php echo base_url('bookmyt/getDashboard').'/'.$months; ?>" <?php if($this->uri->segment(3)==$months || ($this->uri->segment(3)=='' && $this->uri->segment(3)==$i)) {?>style="background-color:#d23d0e;"<?php } ?>><?php echo $months; ?></a></p>
									<?php
										}
									?>		
								</div>
								<div class="box-body">
									<div class=" ">
										<canvas id="myBarChartCombo" style="height: 290px; width: 582px;" height="290" width="582"></canvas>
									</div>
								</div>            
							</div>            
						</div>
					</div>
				</div>
			</div>
			<div class='clearfix'></div>
			<div class="clearfix"></div>
			<h3><a href="<?php echo base_url('bookmyt/feedback_report'); ?>">Click Here</a> to view the Feedback report</h3>	
		</div>
	</div>
</div>

<script type="text/javascript">
    /*var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };*/

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                   data: [<?php echo (!empty($daily_report))?$daily_report[0]['old_visits']:''; ?>, <?php echo (!empty($daily_report))?$daily_report[0]['new_visits']:''; ?>],
                      backgroundColor: [
                          "#36A2EB",
						  "#FF6384"                          
                ],

                backgroundColor: [
                    window.chartColors.orange,
					window.chartColors.red                                        
                ],

                label: 'Dataset 1'
            }],

           labels: [
                "Old Visits", "New Visits" ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Daily Report'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };
</script>
<script type="text/javascript">
    
	/*var old_visits1=[
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][0]['old_visits']))?$monthly_report[0][0]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][1]['old_visits']))?$monthly_report[0][1]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][2]['old_visits']))?$monthly_report[0][2]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][3]['old_visits']))?$monthly_report[0][3]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][4]['old_visits']))?$monthly_report[0][4]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][5]['old_visits']))?$monthly_report[0][5]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][6]['old_visits']))?$monthly_report[0][6]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][7]['old_visits']))?$monthly_report[0][7]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][8]['old_visits']))?$monthly_report[0][8]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][9]['old_visits']))?$monthly_report[0][9]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][10]['old_visits']))?$monthly_report[0][10]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][11]['old_visits']))?$monthly_report[0][11]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][12]['old_visits']))?$monthly_report[0][12]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][13]['old_visits']))?$monthly_report[0][13]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][14]['old_visits']))?$monthly_report[0][14]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][15]['old_visits']))?$monthly_report[0][15]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][16]['old_visits']))?$monthly_report[0][16]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][17]['old_visits']))?$monthly_report[0][17]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][18]['old_visits']))?$monthly_report[0][18]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][19]['old_visits']))?$monthly_report[0][19]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][20]['old_visits']))?$monthly_report[0][20]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][21]['old_visits']))?$monthly_report[0][21]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][22]['old_visits']))?$monthly_report[0][22]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][23]['old_visits']))?$monthly_report[0][23]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][24]['old_visits']))?$monthly_report[0][24]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][25]['old_visits']))?$monthly_report[0][25]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][26]['old_visits']))?$monthly_report[0][26]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][27]['old_visits']))?$monthly_report[0][27]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][28]['old_visits']))?$monthly_report[0][28]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][29]['old_visits']))?$monthly_report[0][29]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[0][30]['old_visits']))?$monthly_report[0][30]['old_visits']:0; ?> ];
		var old_visits2=[
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][0]['old_visits']))?$monthly_report[1][0]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][1]['old_visits']))?$monthly_report[1][1]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][2]['old_visits']))?$monthly_report[1][2]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][3]['old_visits']))?$monthly_report[1][3]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][4]['old_visits']))?$monthly_report[1][4]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][5]['old_visits']))?$monthly_report[1][5]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][6]['old_visits']))?$monthly_report[1][6]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][7]['old_visits']))?$monthly_report[1][7]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][8]['old_visits']))?$monthly_report[1][8]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][9]['old_visits']))?$monthly_report[1][9]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][10]['old_visits']))?$monthly_report[1][10]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][11]['old_visits']))?$monthly_report[1][11]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][12]['old_visits']))?$monthly_report[1][12]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][13]['old_visits']))?$monthly_report[1][13]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][14]['old_visits']))?$monthly_report[1][14]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][15]['old_visits']))?$monthly_report[1][15]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][16]['old_visits']))?$monthly_report[1][16]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][17]['old_visits']))?$monthly_report[1][17]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][18]['old_visits']))?$monthly_report[1][18]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][19]['old_visits']))?$monthly_report[1][19]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][20]['old_visits']))?$monthly_report[1][20]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][21]['old_visits']))?$monthly_report[1][21]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][22]['old_visits']))?$monthly_report[1][22]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][23]['old_visits']))?$monthly_report[1][23]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][24]['old_visits']))?$monthly_report[1][24]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][25]['old_visits']))?$monthly_report[1][25]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][26]['old_visits']))?$monthly_report[1][26]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][27]['old_visits']))?$monthly_report[1][27]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][28]['old_visits']))?$monthly_report[1][28]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][29]['old_visits']))?$monthly_report[1][29]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1][30]['old_visits']))?$monthly_report[1][30]['old_visits']:0; ?> ];
	var old_visits3=[
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][0]['old_visits']))?$monthly_report[2][0]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][1]['old_visits']))?$monthly_report[2][1]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][2]['old_visits']))?$monthly_report[2][2]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][3]['old_visits']))?$monthly_report[2][3]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][4]['old_visits']))?$monthly_report[2][4]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][5]['old_visits']))?$monthly_report[2][5]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][6]['old_visits']))?$monthly_report[2][6]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][7]['old_visits']))?$monthly_report[2][7]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][8]['old_visits']))?$monthly_report[2][8]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][9]['old_visits']))?$monthly_report[2][9]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][10]['old_visits']))?$monthly_report[2][10]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][11]['old_visits']))?$monthly_report[2][11]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][12]['old_visits']))?$monthly_report[2][12]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][13]['old_visits']))?$monthly_report[2][13]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][14]['old_visits']))?$monthly_report[2][14]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][15]['old_visits']))?$monthly_report[2][15]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][16]['old_visits']))?$monthly_report[2][16]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][17]['old_visits']))?$monthly_report[2][17]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][18]['old_visits']))?$monthly_report[2][18]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][19]['old_visits']))?$monthly_report[2][19]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][20]['old_visits']))?$monthly_report[2][20]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][21]['old_visits']))?$monthly_report[2][21]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][22]['old_visits']))?$monthly_report[2][22]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][23]['old_visits']))?$monthly_report[2][23]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][24]['old_visits']))?$monthly_report[2][24]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][25]['old_visits']))?$monthly_report[2][25]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][26]['old_visits']))?$monthly_report[2][26]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][27]['old_visits']))?$monthly_report[2][27]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][28]['old_visits']))?$monthly_report[2][28]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][29]['old_visits']))?$monthly_report[2][29]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2][30]['old_visits']))?$monthly_report[2][30]['old_visits']:0; ?> ];*//*				
for (var i = 0; i <= 11; i++) {				
var chartData = {
            labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7","Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13", "Day 14", "Day 15", "Day 16", "Day 17", "Day 18", "Day 19", "Day 20", "Day 21", "Day 22", "Day 23", "Day 24", "Day 25", "Day 26", "Day 27", "Day 28", "Day 29", "Day 30", "Day 31" ],

            datasets: [{
                type: 'bar',
                label: 'Old Visits',
                borderWidth: 1,                
                data: old_visits3,
                
                backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(129, 165, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(129, 165, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(129, 165, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(129, 165, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(129, 165, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                borderColor: [
                        'rgba(255, 99, 132, 2)',
                        'rgba(54, 162, 235, 9)',
                        'rgba(255, 206, 86, 8)',
                        'rgba(75, 192, 192, 5)',
                        'rgba(153, 102, 255, 2)',
                        'rgba(129, 165, 255, 7)',
                        'rgba(255, 99, 132, 10)',
                        'rgba(54, 162, 235, 54)',
                        'rgba(255, 206, 86, 42)',
                        'rgba(75, 192, 192, 64)',
                        'rgba(153, 102, 255, 74)',
                        'rgba(129, 165, 255, 52)',
                        'rgba(255, 99, 132, 032)',
                        'rgba(54, 162, 235, 92)',
                        'rgba(255, 206, 86, 32)',
                        'rgba(75, 192, 192, 22)',
                        'rgba(153, 102, 255, 82)',
                        'rgba(129, 165, 255, 52)',
                        'rgba(255, 99, 132, 59)',
                        'rgba(54, 162, 235, 72)',
                        'rgba(255, 206, 86, 42)',
                        'rgba(75, 192, 192, 92)',
                        'rgba(153, 102, 255, 32)',
                        'rgba(129, 165, 255, 62)',
                        'rgba(255, 99, 132, 53)',
                        'rgba(54, 162, 235, 48)',
                        'rgba(255, 206, 86, 56)',
                        'rgba(75, 192, 192, 76)',
                        'rgba(153, 102, 255, 35)',
                        'rgba(129, 165, 255, 95)',
                        'rgba(255, 159, 64, 65)'
                    ],
            },
                       
            {
                type: 'line',
                label: 'New Visits',
                backgroundColor: window.chartColors.blue,
                borderWidth: 2,
                fill: false,
                data: [16, 19, 3, 5, 2, 3, 6, 14, 9, 2, 8, 4, 7, 2, 1, 12, 18, 14, 16, 13, 17, 3, 6, 14, 9, 2, 8, 4, 5, 2, 3 ],
                
               }]

        };
}       
            var ctx = document.getElementById("myBarChartCombo").getContext("2d");
            window.myMixedChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
					 scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						},
                    title: {
                        display: true,
//                        text: 'Chart.js Combo Bar Line Chart'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    }
                }
            });
        
		/*for (var i = 0; i <= 11; i++) {
			 document.getElementById('randomizeData_'+i).addEventListener('click', function() {
			 
									chartData.datasets.forEach(function(dataset) {
										if(dataset.type=="bar"){
											dataset.data = dataset.data.map(function() {
												return randomScalingFactor(i);
											});
										}else if(dataset.type=="line"){
											dataset.data = dataset.data.map(function() {
												return randomScalingFactor1(i);
											});
										}
									});
									window.myMixedChart.update();
								
				
			});
		}*/
		/*window.randomScalingFactor = function(mon) {			
			var month=parseInt(mon)+1;
			//alert('old_visits'+month);
			return '<?php echo (!empty($monthly_report) && isset($monthly_report[3][20]['old_visits']))?$monthly_report[3][20]['old_visits']:0; ?>';
			//return '[16, 19, 3, 5, 2, 3, 6, 14, 9, 2, 8, 4, 7, 2, 1, 12, 18, 14, 16, 13, 17, 3, 6, 14, 9, 2, 8, 4, 5, 2, 3 ]';
			//return (Math.random() > 0.5 ? 1.0 : 2.0) * Math.round(Math.random() * 100);
		}
		window.randomScalingFactor1 = function(mon) {			
			var month=parseInt(mon)+1;
			//alert('old_visits'+month);
			return '<?php echo (!empty($monthly_report) && isset($monthly_report[3][20]['new_visits']))?$monthly_report[3][20]['new_visits']:0; ?>';
			//return '[16, 19, 3, 5, 2, 3, 6, 14, 9, 2, 8, 4, 7, 2, 1, 12, 18, 14, 16, 13, 17, 3, 6, 14, 9, 2, 8, 4, 5, 2, 3 ]';
			//return (Math.random() > 0.5 ? 1.0 : 2.0) * Math.round(Math.random() * 100);
		}/*/
	var ctx = document.getElementById("myBarChartCombo");	
	var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7","Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13", "Day 14", "Day 15", "Day 16", "Day 17", "Day 18", "Day 19", "Day 20", "Day 21", "Day 22", "Day 23", "Day 24", "Day 25", "Day 26", "Day 27", "Day 28", "Day 29", "Day 30", "Day 31" ],
            datasets: [{
                label: 'Old Visits',
                data: [
				<?php echo (!empty($monthly_report) && isset($monthly_report[0]['old_visits']))?$monthly_report[0]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1]['old_visits']))?$monthly_report[1]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2]['old_visits']))?$monthly_report[2]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[3]['old_visits']))?$monthly_report[3]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[4]['old_visits']))?$monthly_report[4]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[5]['old_visits']))?$monthly_report[5]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[6]['old_visits']))?$monthly_report[6]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[7]['old_visits']))?$monthly_report[7]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[8]['old_visits']))?$monthly_report[8]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[9]['old_visits']))?$monthly_report[9]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[10]['old_visits']))?$monthly_report[10]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[11]['old_visits']))?$monthly_report[11]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[12]['old_visits']))?$monthly_report[12]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[13]['old_visits']))?$monthly_report[13]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[14]['old_visits']))?$monthly_report[14]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[15]['old_visits']))?$monthly_report[15]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[16]['old_visits']))?$monthly_report[16]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[17]['old_visits']))?$monthly_report[17]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[18]['old_visits']))?$monthly_report[18]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[19]['old_visits']))?$monthly_report[19]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[20]['old_visits']))?$monthly_report[20]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[21]['old_visits']))?$monthly_report[21]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[22]['old_visits']))?$monthly_report[22]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[23]['old_visits']))?$monthly_report[23]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[24]['old_visits']))?$monthly_report[24]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[25]['old_visits']))?$monthly_report[25]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[26]['old_visits']))?$monthly_report[26]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[27]['old_visits']))?$monthly_report[27]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[28]['old_visits']))?$monthly_report[28]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[29]['old_visits']))?$monthly_report[29]['old_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[30]['old_visits']))?$monthly_report[30]['old_visits']:0; ?> ] ,
               	backgroundColor: window.chartColors.orange,
                borderColor: window.chartColors.red,
                borderWidth: 1
            },{
                    type: 'line',
                    label: 'New Visits',
                    borderColor: window.chartColors.red,
                    borderWidth: 1,
                    fill: false ,
                    data: [
				<?php echo (!empty($monthly_report) && isset($monthly_report[0]['new_visits']))?$monthly_report[0]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[1]['new_visits']))?$monthly_report[1]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[2]['new_visits']))?$monthly_report[2]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[3]['new_visits']))?$monthly_report[3]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[4]['new_visits']))?$monthly_report[4]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[5]['new_visits']))?$monthly_report[5]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[6]['new_visits']))?$monthly_report[6]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[7]['new_visits']))?$monthly_report[7]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[8]['new_visits']))?$monthly_report[8]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[9]['new_visits']))?$monthly_report[9]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[10]['new_visits']))?$monthly_report[10]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[11]['new_visits']))?$monthly_report[11]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[12]['new_visits']))?$monthly_report[12]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[13]['new_visits']))?$monthly_report[13]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[14]['new_visits']))?$monthly_report[14]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[15]['new_visits']))?$monthly_report[15]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[16]['new_visits']))?$monthly_report[16]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[17]['new_visits']))?$monthly_report[17]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[18]['new_visits']))?$monthly_report[18]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[19]['new_visits']))?$monthly_report[19]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[20]['new_visits']))?$monthly_report[20]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[21]['new_visits']))?$monthly_report[21]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[22]['new_visits']))?$monthly_report[22]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[23]['new_visits']))?$monthly_report[23]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[24]['new_visits']))?$monthly_report[24]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[25]['new_visits']))?$monthly_report[25]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[26]['new_visits']))?$monthly_report[26]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[27]['new_visits']))?$monthly_report[27]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[28]['new_visits']))?$monthly_report[28]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[29]['new_visits']))?$monthly_report[29]['new_visits']:0; ?>,
				<?php echo (!empty($monthly_report) && isset($monthly_report[30]['new_visits']))?$monthly_report[30]['new_visits']:0; ?>]
                }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }  
      });
	/*$("[id^=randomizeData]").on('click', function() {
		var random_val=this.id;
		var month=random_val.split("_");
		
            myChart.datasets.forEach(function(dataset) {
                dataset.data = dataset.data.map(function() {
                    return randomScalingFactor(month[1]);
                });
            });
            window.myChart.update();
        });*/

</script> 
<script>
        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var color = Chart.helpers.color;
        var barChartData = {
            labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            datasets: [{
                label: 'Old Visits',
                backgroundColor: window.chartColors.orange,
                borderColor: window.chartColors.orange,
                borderWidth: 1,
                data: [
                    <?php echo (!empty($weekly_report))?$weekly_report[0]['old_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[1]['old_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[2]['old_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[3]['old_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[4]['old_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[5]['old_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[6]['old_visits']:0; ?>
                ]
            }, {
                label: 'New Visits',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: [
                    <?php echo (!empty($weekly_report))?$weekly_report[0]['new_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[1]['new_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[2]['new_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[3]['new_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[4]['new_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[5]['new_visits']:0; ?>, 
                    <?php echo (!empty($weekly_report))?$weekly_report[6]['new_visits']:0; ?>
                ]
            }]

        };

        window.onload = function() {
		window.myDoughnut = new Chart(document.getElementById("chart-area").getContext("2d"), config);
		responsive: true
		
            var ctx = document.getElementById("myBarChart").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Weekly Report'
                    }
                }
            });

        };

    </script>
	