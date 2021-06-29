$('.logout').on('click', function(event){
	
	event.preventDefault();
	showLoader();
	
	$.ajax({
		
		url : './models/Deconnection_model.php',
		type : 'POST',
		data : 'deco=0',
		dataType : 'json',
		success : function(data){
			
			if(data == 1){
				
				$("body").fadeOut(1500);
				
				setTimeout( function(){
					
					window.location.replace('index.php');
				}, 1500);
			}
		}
	});
});