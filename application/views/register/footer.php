<div class="footer">
	<div class="container">
    	<div class="col-md-2 col-sm-2">
        	 <h3 style="font-family:Bebas; font-size:18px;">COMPANY</h3>
                <p style="font-family:'Myriad Web Pro';  font-weight:800;">About<br />
                Services<br />
                Career<br />
                Blog</p>
        </div>
        <div class="col-md-2 col-sm-2">
        <h3 style="font-family:Bebas; font-size:18px; padding-left:0px;">NAVIGATION</h3>
                <p style="padding-left:0px; font-family:'Myriad Web Pro'">Tour<br />
                Demo<br />
                Support<br />
                Login</p>
        </div>
        <div class="col-md-3 col-sm-3">
        	 <h3 style="font-family:Bebas; font-size:18px; padding-left:0px;">CONTACT US</h3>
                <p style="padding-left:0px; font-family:'Myriad Web Pro'">Knowledge Matrix,Inc<br />
                Lorem ipsum dolor sit amet 542147<br />
                Lorem ipsum dolor  95062<br />
               Phone : 040254601655<br />
               Fax : 040426545665</p>
               
        </div>
        <div class="col-md-5 col-sm-6=5">
        	 <h3 style="font-family:Bebas; font-size:18px; padding-left:0px;">BE SOCIABLE</h3>
                <p style="padding-left:0px; font-family:'Myriad Web Pro'">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean   <br />
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. consectetuer  <br />
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit consectetuer<br />
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean <br />
                Lorem ipsum dolor sit amet</p>
                
 
       </div>
    </div>
</div>

     
  	<div class="footer-bot">
    	<p>Copyright © 2014 tablematrix. All Rights Reserved.<a href="#" style="text-decoration:none; color:#000;"> Terms of Use | Privacy Policy | FAQs | e-Compliance</a></p>
    </div> 

</div>
		<script type="text/javascript" src="<?php echo base_url();?>theme/js/bootstrap.min.js"></script>
  		<script type="text/javascript" src="<?php echo base_url();?>engine1/script.js"></script>
		<script src="<?php echo base_url().'/theme/js/jquery-2.1.1.min.js'; ?>"></script>
		<script>
			$(document).ready(function()
			{
			
				// $("#select_no_of_members").blur(function() 
				// {
				// $.ajax({
				// type :	"POST",
				// url	 :	"<?php echo base_url();?>bookmyt/get_tables",
				// data :	{'no_of_members' : $("#select_no_of_members").val(),'floor_id':$("#floor").val()},
				// success : function(data){

				// $('#sub_cat_data').html(data);


				// }

				// });
				// });
				
				$("#select_no_of_members").blur(function() {
				$.ajax({
				type :	"POST",
				url	 :	"<?php echo base_url();?>bookmyt/get_tables",
				data :	{'no_of_members' : $("#select_no_of_members").val(),'floor_id':$("#floor").val()},
				success : function(data){

				$('#sub_cat_data').html(data);


				}

				});
				});
			
				// if($("#b_no").val() == 'No')
				// {
					// if($("#b_no").val() == 'No')
					// {
						// $("#brnch").hide();
					// }
				// }
				// $("#b_yes").click(function()
				// {
					// if($("#b_yes").val() == 'Yes')
					// {
						// $("#brnch").show();
					// }
				// });
				
				// $("#b_no").click(function()
				// {
					// if($("#b_no").val() == 'No')
					// {
						// $("#brnch").hide();
					// }
				// });
			});
		
		</script>
		
</body>
</html>
