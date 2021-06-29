function getIncident(){

	//Chargement des liasses en attente d'intervention
	$.ajax({
		
		url: './models/Admin_incident_getIncident.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			$('#incident-table').DataTable().clear().draw(false);
			
			var i = 0,
				j = data[0] * 7,
				stad = ''
			;
			
			while(i < j){
				
				if(data[i+7] == 0){
					stad ='Administration';
				}
				else if(data[i+7] == 1){
					stad ='Matching';
				}
				else if(data[i+7] ==2){
					stad ='1er contrôle';
				}
				else if(data[i+7] ==3){
					stad ='2e contrôle';
				}
				else if(data[i+7] == 4){
					stad ='3e contrôle';
				}
				else if(data[i+7] == 5){
					stad ='4e contrôle';
				}
				else if(data[i+7] == 6){
					stad ='5e contrôle';
				}

				$('#incident-table').DataTable().row.add([
					data[i+2],
					data[i+3],
					data[i+4],
					new Intl.NumberFormat("fr-FR").format(data[i+5]),
					data[i+6],
					stad,
					'<a href="#" id="'+data[i+1]+'" class="fa fa-search-plus fa-lg"></a>',
				]).columns.adjust().draw(false);
				i += 7 ;
			}
		}			
	});
}

//Affichage des demandes d'intervention sur une liasse
$('#incident-table').on('click','.fa-search-plus', function(){
	
	$('#close-incid-bundle').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#redit-numcertif').text($(this).closest('tr').find('td:nth-child(1)').text());
	
	$('#numline-reditcertif').val($(this).closest('tr').index());
	
	$('#close-id-incid').val($(this).attr('id'));
	$('#interv-idcertif').val($(this).attr('id'));
	
	$('#close-incid-utilplate').css('display','none');
	$('#close-incid-interne').css('display','none');
	
	showLoader();
	
	$.ajax({

		url : './models/Admin_incident_getIncidentDetails.php',
		type : 'POST',
		data : 'idincid='+$(this).attr('id'),
		dataType : 'json',
		success : function(data){
			
			var fin = 0,
				j = 0,
				bool = false
			;			
			if(data[0] == 0){
				
				if(data[1] > 0){
					
					$('#close-incid-interne').css('display','block');
					$('#close-incid-interne-table').html('');
					$('#close-incid-user').text(data[2]);
					
					for(var i = 0; i < data[1]; i++){

						$('#close-incid-interne-table').append("<tr id='incidintern"+data[j+3]+"'><td ><input value='"+data[j+4]+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/></td><td ><input value='"+data[j+5]+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/></td><td ><input value='"+data[j+6]+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/></td><td ><input value='"+new Intl.NumberFormat("fr-FR").format(data[j+7])+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/</td><td ><input value='"+data[j+8]+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/</td><td><a href='#' id='"+data[j+3]+"' class='fa fa-unlock-alt fa-lg'></a></td></tr>");
						j += 6;
					}					
					hideLoader();
					$('#modal-close-incid').modal('show');
				}
				else if(data[1] == 0){
					
					var action = '',
						actiontitle = ''
					;					
					if(data[2] == 8){
						action = 'modifier';
						actiontitle = 'Modification';
					}
					else if(data[2] == 9){
						action = 'r&eacute;&eacute;diter';
						actiontitle = 'R&eacute;&eacute;dition';
					}
					$('#edit-action-title').text(actiontitle);
					$('#edit-action').text(action);					
					$('#edit-controleur').text(data[3]);
					
					hideLoader();
					$('#modal-editCertifConfirmation').modal('show');					
				}
			}
			else if(data[0] > 0){
				
				$('#close-incid-utilplate').css('display','block');
				$('#close-incid-structure').text(data[1]);
				$('#close-incid-motif').val(data[2]);
				
				if(data[0] == 1){
					$('#close-incid-type').text('Demande d\'annulation');
				}
				else if(data[0] == 2){
					$('#close-incid-type').text('Demande d\'annule et remplace');
				}
				
				if(data[4] > 0){
					
					$('#close-incid-interne').css('display','block');
					$('#close-incid-interne-table').html('');
					$('#close-incid-user').text(data[5]);
					
					for(var i = 0; i < data[4]; i++){

						$('#close-incid-interne-table').append("<tr id='incidintern"+data[j+6]+"'><td ><input value='"+data[j+7]+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/></td><td ><input value='"+data[j+8]+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/></td><td ><input value='"+data[j+9]+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/></td><td ><input value='"+new Intl.NumberFormat("fr-FR").format(data[j+10])+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/</td><td ><input value='"+data[j+11]+"' style='text-align: center; font-size: 12px' class='form-control' disabled='disabled'/</td><td><a href='#' id='"+data[j+6]+"' class='fa fa-unlock-alt fa-lg'></a></td></tr>");
						j += 6;
					}
				}				
				hideLoader();
				$('#modal-close-incid').modal('show');
			}
		}
	});	
});

//Cloturer une demande d'annulation et/ou une demande d'annule et remplace
$('#close-incid-utilplate').on('click','#button-close-incid-utilplate', function(){
	
	$('#modal-close-incid').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_incident_resolveIncident.php',
		type : 'POST',
		data : 'idincid='+$('#close-id-incid').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = "",
				msg2 = "",
				type = ""
			;			
			if(data[0] > 0){
				
				if(data[0] == 1){
					msg1 = "La demande d'annulation de la liasse "+$('#close-incid-bundle').text()+" a été validée avec succès." ;
					type = "alert-success";
				}
				else if(data[0] == 2){
					msg1 = "La demande d'annule et remplace de la liasse "+$('#close-incid-bundle').text()+" a été validée avec succès." ;
					type = "alert-success";
				}				
				//Chargement des liasses en attente d'intervention
				getIncident();
				
				$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
			}
		}
	});
});

//Cloturer toutes les demandes d'intervention portant sur une liasse
$('#close-incid-interne').on('click','#button-close-incid-user-all', function(){
	
	$('#modal-close-incid').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_incident_resolveInternalIncident.php',
		type : 'POST',
		data : 'idincidinternall='+$('#close-id-incid').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = "",
				msg2 = "",
				type = ""
			;			
			if(data[0] == 1){
				
				msg1 = "La demande d'intervention sur la liasse "+$('#close-incid-bundle').text()+" a été traitée avec succès." ;
				type = "alert-success";	
				//Chargement des liasses en attente d'intervention
				getIncident();
				
				$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
			}
		}
	});
});

//Cloturer une demande d'intervention portant sur un ticket
$('#close-incid-interne-table').on('click','.fa-unlock-alt', function(){
	
	var idtckt = $(this).attr('id');	
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_incident_resolveInternalIncident.php',
		type : 'POST',
		data : 'idticket='+idtckt+'&idincid='+$('#close-id-incid').val(),
		dataType : 'json',
		success : function(data){
			
			if(data[0] > 0){
				
				var msg1 = "",
					msg2 = "",
					type = ""
				;			
				if(data[0] == 2){
					$('#close-incid-interne-table').find('tr[id=incidintern'+idtckt+']').remove();
					hideLoader();
				}
				else if(data[0] == 3){					
					$('#modal-close-incid').modal('hide');
					
					msg1 = "La demande d'intervention sur la liasse "+$('#close-incid-bundle').text()+" a été traitée avec succès." ;
					type = "alert-success";	
					//Chargement des liasses en attente d'intervention
					getIncident();
					
					$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
				}
			}
		}
	});
});

//Cloturer une demande d'édition ou de modification d'un certificat
$('#validate-editCertifConfirmation').on('click', function(){
	$('#modal-editCertifConfirmation').modal('hide');	
	showLoader();
	
	var action = 0;
	if($('#edit-action').text() == 'modifier'){
		action = 1;
	}
	
	$.ajax({
		
		url : './models/Admin_incident_resolveIntervention.php',
		type : 'POST',
		data : 'idcertif='+$('#interv-idcertif').val()+'&action='+action,
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = '',
				numline = $('#numline-reditcertif').val()
			;
			
			if(data[0] == 1){
				
				msg1 = "Le certificat "+$('#redit-numcertif').text()+" a été rétrogradé au niveau de l'utilisateur "+$('#edit-controleur').text()+" pour modification.";
				type = "alert-success";
				
				$('#incident-table').DataTable().row(':eq('+numline+')').remove().draw(false);
				$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
			}
		}
	});
});		