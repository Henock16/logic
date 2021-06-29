function getPackingList(){

	//Chargement de la liste des packing-lists
	$.ajax({
		
		url: './models/Admin_admin_getPack.php',
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
				j = data[1] * 9
			;
			while(i < j){
				
				if(data[i+8]<10){
					heur = '0'+data[i+8];
				}
				else{
					heur = data[i+8];
				}
				
				if(data[i+9]<10){
					minu = '0'+data[i+9];
				}
				else{
					minu = data[i+9];
				}
				
				if(data[i+10]<10){
					seco = '0'+data[i+10];
				}
				else{
					seco = data[i+10];
				}

				$('#pcklist-table').DataTable().row.add([
				
					data[i+3],
					data[i+4],
					new Intl.NumberFormat("fr-FR").format(data[i+6]),
					data[i+7],
					data[i+5],
					'<span class="label" style="background-color: #7b7b7b;"><label style="color: white;" id="h'+x+'">'+heur+'</label> : <label style="color: white;" id="m'+x+'">'+minu+'</label> : <label style="color: white;" id="s'+x+'">'+seco+'</label></span>',
					'<a href="#" id="'+data[i+2]+'" class="fa fa-search-plus fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="functions/Print.php?egasilocedetsil='+data[i+2]+'" target="_blank" class="fa fa-print fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="far fa-trash-alt fa-lg"></a>',
				]).columns.adjust().draw(false);
				i += 9;
				x += 1;
			}
		}			
	});
}

//Affichage des informations du Packing list
$('#pcklist-table').on('click','.fa-search-plus', function(){
	
	var num = $(this).closest('tr').find('td:nth-child(1)').text();
	
	//chargement des informations
	$.ajax({
		
		url: './models/Admin_admin_getPack.php',
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
				$('#stad-pcklist').val(state);
				
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
				$('#state-pcklist').val(level);
				
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

//Rejet d'un packing list par l'administrateur
$('#pcklist-table').on('click','.fa-trash-alt', function(){
	
	$('#idpcklist-updatstat').val($(this).attr('id'));
	$('#updatestate-pcklist').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#modal-rejectpcklistConfirmation').modal('show');
});
$('#validate-rejectpcklistConfirmation').on('click', function(){
	
	$('#modal-rejectpcklistConfirmation').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Admin_admin_rejectPack.php',
		type : 'POST',
		data : 'idcert='+$('#idpcklist-updatstat').val(),
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){
				notification("Le packing list "+$('#updatestate-pcklist').text()+" a été rejeté avec succès.","","alert-success");
				
				//Chargement des packing list
				getPackingList();
			}
			if(data[0] == 2){
				notification("Le packing list "+$('#updatestate-pcklist').text()+" n'a pas été rejeté.","Veuillez contacter immédiatement l'administrateur !","alert-success");
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin rejet d'un packing list