$(function(){ 
		   
/* Single File Upload start*/
	if($('button#fileupload').length){
	   $('button#fileupload,input.file_input').live('click',function(e){
			e.preventDefault();			
			var rel=$(this).data('rel');																	
		  $('#'+rel).click();
		});
		
	  $('input[type="file"]').live('change',function(){
		 var id=$(this).attr('id'); 											 
		$('input#'+id+'_input').val($(this).val());
	   });
	  
	  $('input.file_input').live('change',function(){
		var rel=$(this).data('rel');										   
		$('#'+rel).val($(this).val());
	  });
	 
	 }
	 
	

	

/* Single File Upload end */	 
	 
	 
});