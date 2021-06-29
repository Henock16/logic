//Apparition du loader
function showLoader(){
	
	var loadstat = $('.loader').css('display') ;
	
	if(loadstat == 'none'){
		
		$('.loader').fadeIn(500);
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
	var tab = ['alert-warning','alert-success','alert-danger'];
	
	for(var i = 0; i < 3; i++){
		
		if(tab[i] == classtoadd){
			
			$('#notification').addClass(classtoadd);
		}
		else{
			
			$('#notification').removeClass(tab[i]);
		}	
	}
	
	$('#notification').slideDown(600,'linear').delay(8000).slideUp(800,'linear');
}

//Poster les informations de connexion
$("#login-form").submit(function(event){
	
	event.preventDefault();
	var data = $(this).serialize();
	document.getElementById('login-form').reset();
	showLoader();
	
	$.ajax({
		
		url : './models/Authentication_model.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			hideLoader();
			
			if(data[0] == 0){
				
				notification("Le nom d'utilisateur et/ou le mot de passe est érroné !","","alert-danger");		
			}
			else if(data[0] == 1){

				notification("Votre compte utilisateur est désactivé !","Contacter l'administrateur s'il vous plaît.","alert-warning");
			}
			else if(data[0] == 2){
				
				notification("Votre compte est en cours d'utilisation !","Veuillez patienter 05 minutes puis réessayer.","alert-warning");
			}
			else if(data[0] == 3){
				
				$('#user-fullname').text(data[1]);
				$('#modal-FirstConnection').modal('show');
			}
			
			else if(data[0] == 4){
				
				window.location.replace('index.php');
			}
		}
	});
});

//Poster les informations de première connexion
$("#firstconnection-form").submit(function(event){
	
	event.preventDefault();
	
	if(document.getElementById('new-password2').value != document.getElementById('new-password3').value){
		
		$('#modal-FirstConnection').modal('hide');
		notification("Les mots de passe saisis ne sont pas identiques !","Veuillez réessayer s'il vous plaît.","alert-warning");
	}
	else{
		
		var data = $(this).serialize() ;
		showLoader();
		
		$.ajax({
			
			url : './models/FirstConnection_model.php',
			type : 'POST',
			data : data,
			dataType : 'json',
			success : function(data){
				
				$('#modal-FirstConnection').modal('hide');
				document.getElementById('firstconnection-form').reset();
				notification("Vos informations ont été mises à jour avec succès !","Connectez-vous avec votre nouveau mot de passe.","alert-success");
				hideLoader();
			}
		});
	}
});