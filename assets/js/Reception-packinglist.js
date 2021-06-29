function getPackinglist(){

	//Chargement de la liste des packing-lists
	$.ajax({
		
		url: './models/Reception_reception_getPackinglist.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#pcklist-table').DataTable().clear().draw(false);
			
			var i = 0,
				x = 1,
				heur ='',
				minu ='',
				seco ='',
				line ='',
				classe ='',
				j = data[0] * 10
			;
			while(i < j){

				if(data[i+6] == 0){
					line ='<span style="background-color: #dd4b39; color: white;width: 100%;display: block;">non</span>';
				}
				else if(data[i+6] == 1){
					line ='<span style="background-color: #00a65a; color: white;width: 100%;display: block;">oui</span>'; 
				}

				if(data[i+10] == 2){
					classe ='far fa-paper-plane fa-lg';
				}
				else if(data[i+10] != 2){
					classe ='far fa- fa-lg'; 
				}
				
				if(data[i+7]<10){
					heur ='0'+data[i+7];
				}
				else{
					heur = data[i+7];
				}
				
				if(data[i+8]<10){
					minu ='0'+data[i+8];
				}
				else{
					minu = data[i+8];
				}
				
				if(data[i+9]<10){
					seco ='0'+data[i+9];
				}
				else{
					seco = data[i+9];
				}
				
				$('#pcklist-table').DataTable().row.add([
				
					data[i+2],
					data[i+3],
					new Intl.NumberFormat("fr-FR").format(data[i+4]),
					data[i+5],
					'<span class="label" style="background-color: #7b7b7b;"><label style="color: white;" id="h'+x+'">'+heur+'</label> : <label style="color: white;" id="m'+x+'">'+minu+'</label> : <label style="color: white;" id="s'+x+'">'+seco+'</label></span>',
					line,
					'<a href="#" id="'+data[i+1]+'" class="fa fa-search-plus fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="functions/Print.php?egasilocedetsil='+data[i+1]+'" id="'+data[i+1]+'" target="_blank" class="fa fa-print fa-lg"></a>',
					'<a href="#" id="'+data[i+1]+'" class="'+classe+'"></a>',
				]).columns.adjust().draw(false);
				i += 10;
				x +=1;
			}
		}			
	});
}

//Modifier une ligne après impression du Packing list
$('#pcklist-table').on('click','.fa-print', function(){
	
	var statut = $(this).closest('tr').find('td:nth-child(6)').text();

	if(statut == 'non'){

		$('#pcklist-table').DataTable().row($(this).parents('tr')).remove();

		$.ajax({

			url: './models/Reception_reception_updateBundle.php',
			type: 'POST',
			data:'id='+$(this).attr('id'),
			dataType: 'json',
			success : function(data){
				
				if (data[0] > 0){
					
					var line ='',
						classe =''
					;

					if(data[6] == 0){
						line ='<span style="background-color: #dd4b39; color: white;width: 100%;display: block;">non</span>';
					}
					else if(data[6] == 1){
						line ='<span style="background-color: #00a65a; color: white;width: 100%;display: block;">oui</span>'; 
					}

					if(data[8] == 2){
						classe ='far fa-paper-plane fa-lg';
					}
					else if(data[8] != 2){
						classe ='far fa- fa-lg'; 
					}

					$('#pcklist-table').DataTable().row.add([
					
						data[2],
						data[3],
						new Intl.NumberFormat("fr-FR").format(data[4]),
						data[5],
						data[7],
						line,
						'<a href="#" id="'+data[1]+'" class="fa fa-search-plus fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="functions/Print.php?egasilocedetsil='+data[1]+'" id="'+data[1]+'" target="_blank" class="fa fa-print fa-lg"></a>',
						'<a href="#" id="'+data[1]+'" class="'+classe+'"></a>',
					]).columns.adjust().draw(false);
				}
			}	
		});
	}
});	

//Affichage des informations du Packing list
$('#pcklist-table').on('click','.fa-search-plus', function(){
	
	var num = $(this).closest('tr').find('td:nth-child(1)').text();
	
	//chargement des informations
	$.ajax({
		
		url: './models/User_packinglist_getInfo.php',
		type: 'POST',
		data:'idcert='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				var state = '',
					level = ''
				;
				
				$('#num-pcklist').text(num);
				$('#cli-pcklist').val(data[1]);
				$('#nav-pcklist').val(data[2]);
				
				if(data[3] == 0){
					state = 'En attente';
				}
				else if(data[3] == 1){
					state = 'Traitement en cours';
				}
				else if(data[3] == 2){
					state = 'Traité';
				}
				else if(data[3] == 3){
					state = 'Rejeté';
				}
				else if(data[3] == 4){
					state = 'Transmis au CCA';
				}
				$('#state-pcklist').val(state);
				
				if(data[4] == 0){
					level = 'Administration';
				}
				else if(data[4] == 1){
					level = 'Matching';
				}
				else if(data[4] == 2){
					level = '1er Contrôle';
				}
				else if(data[4] == 3){
					level = '2e Contrôle';
				}
				else if(data[4] == 4){
					level = '3e Contrôle';
				}
				else if(data[4] == 5){
					level = '4e Contrôle';
				}
				else if(data[4] == 6){
					level = '5e Contrôle';
				}
				else if(data[4] == 7){
					level = 'Bordereau utilisateur';
				}				
				$('#stad-pcklist').val(level);
				
				$('#trans-pcklist').val(data[5]);
				$('#dest-pcklist').val(data[6]);
				$('#dem-pcklist').val(data[7]);
				$('#prec-pcklist').val(data[8]);
				$('#dernagent-pcklist').val(data[9]);
				$('#nbtckt-pcklist').val(data[10]);
				
				$('#modal-infoPcklist').modal('show');
			}
		}
	});
});

//Changement du statut du packing list à transmis au CCA
$('#pcklist-table').on('click','.fa-paper-plane', function(){
	
	$('#idpcklist-updatstat').val($(this).attr('id'));
	$('#numline-pcklist').val($(this).closest('tr').index());
	
	$.ajax({
		
		url: './models/Reception_reception_getNumcertif.php',
		type: 'POST',
		data:'idcert='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){

			if(data[0] ==1 ){
				$('#updatestate-pcklist').text(data[1]);
				$('#modal-statpcklistConfirmation').modal('show');
			}
		}		
	});
});
$('#validate-statpcklistConfirmation').on('click', function(){

	$('#modal-statpcklistConfirmation').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Reception_reception_upstateBundle.php',
		type : 'POST',
		data : 'idcert='+$('#idpcklist-updatstat').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = '',
				numline = $("#numline-pcklist").val()
			; 
			if(data[0] == 1){
				msg1 = "Le certificat "+$('#updatestate-pcklist').text()+" a bien été transmis au CCA.";
				type = "alert-success";
			}
			if(data[0] == 2){
				msg1 = "Le certificat "+$('#updatestate-pcklist').text()+" ne peut plus être transmis.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !"
				type = "alert-danger";
			}
			$('#pcklist-table').DataTable().row(':eq('+numline+')').remove().draw(false);
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});