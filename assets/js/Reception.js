//Vérification si nombre est entier
function isInt(n){
   return n % 1 === 0;
}

//Apparition du loader
function showLoader(){
	
	var loadstat = $('.loader').css('display') ;	
	if(loadstat == 'none'){		
		$('.loader').fadeIn(0);
	}
}
//Disparition du loader
function hideLoader(){
	
	var loadstat = $('.loader').css('display') ;	
	if(loadstat == 'block'){		
		$('.loader').fadeOut(500);
	}
}

//notification
function notification(text1,text2,classtoadd){
	
	$('#message1').text(text1);
	$('#message2').text(text2);	
	
	var tab = ['alert-warning','alert-success','alert-danger','alert-info'];	
	for(var i = 0; i < 4; i++){
		
		if(tab[i] == classtoadd){			
			$('#notification').addClass(classtoadd);
		}
		else{			
			$('#notification').removeClass(tab[i]);
		}	
	}
	$('#notification').delay(800).slideDown(300,'linear').delay(3500).slideUp(300,'linear');
}

//Début gestion des onglets
$('#reception-button').click(function(e){

	$('#archive-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').removeClass('active');
	$('#reception-button').parent('li').addClass('active');

	$('#ARCHIVE').fadeOut(0);
	$('#PROFIL').fadeOut(0);
	$('#RECEPTION').fadeIn(400,'swing');
   
});

$('#archive-button').click(function(e){

	$('#reception-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').removeClass('active');
	$('#archive-button').parent('li').addClass('active');

	$('#RECEPTION').fadeOut(0);
	$('#PROFIL').fadeOut(0);
	$('#ARCHIVE').fadeIn(400,'swing');
   
});

$('#profil-button').click(function(e){

	$('#reception-button').parent('li').removeClass('active');
	$('#archive-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').addClass('active');

	$('#RECEPTION').fadeOut(0);
	$('#ARCHIVE').fadeOut(0);
	$('#PROFIL').fadeIn(400,'swing');
 
});

//Verrouillage de l'écran
$('#locked').on('click', function(){	
	$('.lockscreen').slideDown(1000,'swing');
});

//Déverrouillage de l'espace de travail
$('#locked-form').on('submit', function(event){
	
	event.preventDefault();
	var pass = $('input[name=pwdlocked]').val();
	
	$.ajax({
		
		url : './models/User_lockSession.php',
		type : 'POST',
		data : 'pass='+pass,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 0){
				$('input[name=pwdlocked]').css('border', '1px solid red');
			}
			else{
				$('input[name=pwdlocked]').css('border', '0px solid red');
				$('.lockscreen').slideUp(1000,'swing');
			}
			$('#pwdlocked').val('');
		}
	});
});