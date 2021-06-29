function getUser(){
	
	//Chargement de la liste des utilisateurs
	$.ajax({

		url: './models/Admin_users_getUser.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			$('#user-table').DataTable().clear().draw(false);
			
			var i = 0,
				j = data[0] * 8,
				cel = '',
				faicon = ''
			;			
			while(i < j){
				
				if(data[i+6] == 1){
					cel = 'Matching';
				}
				else if(data[i+6] == 2){
					cel = 'Controle';
				}
				else if(data[i+6] == 3){
					cel = 'Reception';
				}
				//ajouter le 29/06/2021 extraire
				else if(data[i+6] == 4){
					cel = 'Extraire';
				}
				
				if(data[i+8] == 0){
					faicon = 'toggle-on';
				}
				else if(data[i+8] == 1){
					faicon = 'toggle-off';
				}
				
				$('#user-table').DataTable().row.add([
					data[i+2],
					data[i+3],
					data[i+4],
					data[i+5],
					cel,
					data[i+7],
					'<a href="#" id="'+data[i+1]+'" class="fa fa-sync-alt fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+1]+'" class="far fa-edit fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+1]+'" class="fa fa-'+faicon+' fa-lg toggleuserlogic"></a>'
				]).columns.adjust().draw();
				i += 8 ;
			}
		}			
	});
}

//Création d'un utilisateur logic
$('#add-user').on('click', function(){
	
	showLoader();	
	//Chargement de la liste des villes
	getTown();
	//Chargement de la liste des postes de travail
	getWorkplace();	
	
	hideLoader();
	$('#modal-add-user').modal('show');	
});
$('#form-add-user').submit(function(e){
	
	e.preventDefault();
	
	if(!isInt($('#user-matr').val())){
		$('#form-add-user-error').text('Matricule incorrect !');
	}
	else if(!isValidEmailAddress($('#user-mail').val())){
		$('#form-add-user-error').text('Adresse email incorrecte !');
	}
	else{
		
		var data = 'matr='+$('#user-matr').val()+'&name='+$('#user-name').val()+'&firstname='+$('#user-firstname').val()+'&birth='+$('#user-birth').val()+'&town='+$('#user-town').val()+'&phone='+$('#user-phone').val()+'&mail='+$('#user-mail').val()+'&cel='+$('#user-cel').val();
		
		$('#modal-add-user').modal('hide');	
		showLoader();
		
		$.ajax({

			url : './models/Admin_users_addUser.php',
			type : 'POST',
			data : data,
			dataType : 'json',
			success : function(data){
				
				var msg1 = '',
					msg2 = '',
					type = ''
				;					
				if(data[0] == 1){
					
					msg1 = "L'utilisateur "+$('#user-name').val()+" "+$('#user-firstname').val()+" au matricule "+$('#user-matr').val()+" existe déjà.";
					msg2 = "Veuillez le rechercher dans le tableau pour des modifications !";
					type = 'alert-warning';
				}
				else if(data[0] == 2){
					
					msg1 = "L'utilisateur "+$('#user-name').val()+" "+$('#user-firstname').val()+" a été crée avec succès.";
					type = 'alert-success';
					//Chargement de la liste des utilisateurs logic
					getUser();
				}
				else if(data[0] == 3){
					
					msg1 = "L'utilisateur "+$('#user-name').val()+" "+$('#user-firstname').val()+" n'a pas pu être crée.";
					msg2 = "Veuillez contacter immédiatement l'administrateur !";
					type = 'alert-danger';
				}
				//ajouter le 29/06/2021 extrait
				// else if(data[0] == 4){
					
				// 	msg1 = "L'utilisateur "+$('#user-name').val()+" "+$('#user-firstname').val()+" n'a pas pu être crée.";
				// 	msg2 = "Veuillez contacter immédiatement l'administrateur !";
				// 	type = 'alert-danger';
				// }
				$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));	
				
				$('#user-matr').val('');
				$('#user-name').val('');
				$('#user-firstname').val('');
				$('#user-birth').val('');
				$('#user-town').val($("#user-town").val());
				$('#user-phone').val('');
				$('#user-mail').val('');
				$('#user-cel').val($("#user-cel").val());
				$('#form-add-user-error').text('');
			}
		});
	}
});

//Réinitialisation du compte utilisateur logic
$('#user-table').on('click','.fa-sync-alt', function(){

	$('#reinit-id-user').val($(this).attr('id'));
	$('#reinit-fullname-user').text($(this).closest('tr').find('td:nth-child(1)').text()+' '+$(this).closest('tr').find('td:nth-child(2)').text());
	$('#modal-reinit-user').modal('show');
});
$('#button-confirm-reinit-user').on('click', function(){

	$('#modal-reinit-user').modal('hide');
	showLoader();

	$.ajax({

		url : './models/Admin_users_resetUser.php',
		type : 'POST',
		data : 'iduser='+$('#reinit-id-user').val(),
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				var msg1 = '',
					msg2 = '',
					type = ''
				; 
				msg1 = "Le compte utilisateur de "+$('#reinit-fullname-user').text()+" a été réinitialisé avec succès." ;
				type = "alert-success";
				$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
			}			
		}
	});
});

//Changement du statut du compte utilisateur logic
$('#user-table').on('click','.toggleuserlogic', function(){

	$('#status-id-user').val(idstruct = $(this).attr('id'));

	if($(this).hasClass('fa-toggle-on')){
		$('#status-verb-user').html('d&eacute;sactiver');
	}
	else{
		$('#status-verb-user').html('r&eacute;activer');
	}
	$('#status-fullname-user').text($(this).closest('tr').find('td:nth-child(1)').text()+' '+$(this).closest('tr').find('td:nth-child(2)').text());
	$('#modal-status-user').modal('show');
});
$('#button-status-user').on('click', function(){

	$('#modal-status-user').modal('hide');
	showLoader();

	$.ajax({

		url : './models/Admin_users_statusUser.php',
		type : 'POST',
		data : 'iduser='+$('#status-id-user').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 0){
				msg1 = "Le compte utilisateur de la structure "+$('#status-fullname-user').text()+" a été désactivé avec succès." ;
				type = "alert-success";
				
			}
			else if(data[0] == 1){
				msg1 = "Le compte utilisateur "+$('#status-fullname-user').text()+" a été réactivé avec succès." ;
				type = "alert-success";
			}			
			//chargement de la liste des utilisateurs en ligne
			getUser();
			
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});