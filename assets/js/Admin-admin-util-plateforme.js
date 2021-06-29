function getUtilPlateforme(){

	//Chargement de la liste des utilisateurs (plateforme en ligne)
	$.ajax({

		url: './models/Admin_admin_getUtilPlate.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){

			$('#utilplate-table').DataTable().clear().draw(false);
			
			var i = 0,
				faicon = '',
				j = data[1]*7
			;
			while(i < j){

				if(data[i+8] == 0){
					faicon = 'toggle-on';
				}
				else if(data[i+8] == 1){
					faicon = 'toggle-off';
				}

				$('#utilplate-table').DataTable().row.add([
					data[i+3],
					data[i+4],
					data[i+5],
					data[i+6],
					data[i+7],
					'<a href="#" id="'+data[i+2]+'" class="fa fa-search-plus fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fas fa-sync-alt fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fa fa-'+faicon+' fa-lg toggleutilplate"></a>',
				]).columns.adjust().draw(false);
				i += 7;
			}
		}
	});
}

//Création d'un utilisateur de la plateforme en ligne
$('#add-utilplate').on('click', function(){
	$('#modal-add-utilplate').modal('show');
});
$('#form-add-utilplate').submit(function(e){
	
	e.preventDefault();
	var data = 'structure='+$('#utilplate-structure').val()+'&typop='+$('#utilplate-typop').val()+'&town='+$('#utilplate-town').val()+'&logo='+$('#utilplate-logo').val() ;
	
	$('#modal-add-utilplate').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Admin_admin_addUtilPlate.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			;
			if(data[0] == 2){
				msg1 = "Le compte utilisateur de la structure "+$('#utilplate-structure').val()+" a été crée avec succès." ;
				type = "alert-success";
				//chargement de la liste des utilisateurs en ligne
				getUtilPlateforme()
			}
			else if(data[0] == 1){
				msg1 = "La structure "+$('#utilplate-structure').val()+" possède déjà d'un compte en ligne." ;
				msg2 = "Veuillez le rechercher dans le tableau des comptes utilisateurs !" ;
				type = "alert-warning";
			}
			else if(data[0] == 0){
				msg1 = "La structure "+$('#utilplate-structure').val()+" n'a pas été créée." ;
				msg2 = "Veuillez contacter immédiatement l'administrateur !" ;
				type = "alert-danger";
			}
			
			$('#utilplate-structure').val('');
			$('#utilplate-typop').val($('#utilplate-typop option:first').val());
			$('#utilplate-town').val($('#utilplate-town option:first').val());
			$('#utilplate-logo').val('');
			
			$.when($(document).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});

//Affichage des informations de la structure (Plateforme en ligne)
$('#utilplate-table').on('click','.fa-search-plus', function(){

	showLoader();

	$.ajax({

		url : './models/Admin_admin_getUtilPlateInfo.php',
		type : 'POST',
		data : 'idstruct='+$(this).attr('id'),
		dataType : 'json',
		success : function(data){

			if(data[0] == 1){
				$('#contact-utilplate-structure').text(data[1]);
				$('#contact-utilplate-tel').val(data[2]);
				$('#contact-utilplate-cc').val(data[3]);
				$('#contact-utilplate-adrgeo').val(data[4]);
				$('#modal-show-utilplate').modal('show');
			}
			$(document).ajaxStop(function(){hideLoader()});
		}
	});
});

//Réinitialisation du compte utilisateur (Plateforme en ligne)
$('#utilplate-table').on('click','.fa-sync-alt', function(){

	$('#reinit-id-utilplate').val($(this).attr('id'));
	$('#reinit-structure-utilplate').text($(this).closest('tr').find('td:nth-child(2)').text());
	$('#modal-reinit-utilplate').modal('show');
});
$('#button-confirm-reinit-utilplate').on('click', function(){

	$('#modal-reinit-utilplate').modal('hide');
	showLoader();

	$.ajax({

		url : './models/Admin_admin_resetUtilPlate.php',
		type : 'POST',
		data : 'idstruct='+$('#reinit-id-utilplate').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 1){
				msg1 = "Le compte utilisateur de la structure "+$('#reinit-structure-utilplate').text()+" a été réinitialisé avec succès." ;
				type = "alert-success";
				
			}
			else if(data[0] == 0){
				msg1 = "Le compte utilisateur de la structure "+$('#reinit-structure-utilplate').text()+" n'a pas été réinitialisé.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !"
				type = "alert-danger";
			}
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});

//Changement du statut du compte utilisateur (plateforme en ligne)
$('#utilplate-table').on('click','.toggleutilplate', function(){

	$('#status-id-utilplate').val(idstruct = $(this).attr('id'));

	if($(this).hasClass('fa-toggle-on')){
		$('#status-verb-utilplate').html('d&eacute;sactiver');
		$('#status-utilplate-state').val(1);
	}
	else{
		$('#status-verb-utilplate').html('r&eacute;activer');
		$('#status-utilplate-state').val(0);
	}
	$('#status-structure-utilplate').text($(this).closest('tr').find('td:nth-child(2)').text());
	$('#modal-status-utilplate').modal('show');
});
$('#button-status-utilplate').on('click', function(){
	
	$('#modal-status-utilplate').modal('hide');
	showLoader();

	$.ajax({

		url : './models/Admin_admin_statusUtilPlate.php',
		type : 'POST',
		data : 'idstruct='+$('#status-id-utilplate').val()+'&state='+$('#status-utilplate-state').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 1){				
				if($('#status-utilplate-state').val() == 1){
					msg1 = "Le compte utilisateur de la structure "+$('#status-structure-utilplate').text()+" a été désactivé avec succès." ;
					type = "alert-success";
				}
				else if($('#status-utilplate-state').val() == 0){
					msg1 = "Le compte utilisateur "+$('#status-structure-utilplate').text()+" a été réactivé avec succès." ;
					type = "alert-success";
				}
				//chargement de la liste des utilisateurs en ligne
				getUtilPlateforme();				
			}
			else if(data[0] == 0){
				msg1 = "Le compte utilisateur de la structure "+$('#reinit-structure-utilplate').text()+" n'a pas été modifié.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !"
				type = "alert-danger";
			}
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});