function Time(){
	
	var sec = $('#s').text() ;
	var min = $('#m').text() ;
	var hour = $('#h').text() ;
	
	if(sec == 59){
		
		sec = 0+''+0 ;
		
		if(min < 9){
			
			min++ ;
			min = 0+''+(min) ;
		}
		else{
			
			min++ ;
		}
	}
	else{
		
		if(sec < 9){
			
			sec++ ;
			sec = 0+''+sec ;
		}
		else{
			
			sec++ ;
		}
	}
	
	if(min > 59){
		
		min = 0+''+0 ; 
		
		if(hour < 9){
			
			hour++ ;
			hour = 0+''+(hour) ;
		}
		else if(hour == 23){
			
			hour = 0+''+0 ;
		} 
		else{
			
			hour++ ;
		}
	}

	$('#s').text(sec) ; 
	$('#m').text(min) ; 
	$('#h').text(hour) ;
}
var compte = setInterval(Time, 1000);