function getDestination(){
	
	//Chargement de la liste des destinations
	$.ajax({
		
		url: './models/Admin_admin_getDest.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#dest-table').DataTable().clear().draw(false);
			
			var i = 0,
				j = data[1] * 5,
				faicon = '',
				role = data[(data.length - 1)],
				option = ''
			;

			while(i < j){
				
				if(data[i+5]==0){
					faicon = 'toggle-on';
				}
				if(data[i+5]==1){
					faicon = 'toggle-off';
				}
				if(role <= 1){
					option = '<a href="#" id="'+data[i+2]+'" class="far fa-edit fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fa fa-'+faicon+' fa-lg toggledest"></a>';
				}
				$('#dest-table').DataTable().row.add([
					data[i+3],
					data[i+4],
					data[i+6],
					option
				]).columns.adjust().draw(false);
				i +=5;
			}
		}			
	});
}

//Création Destination
$('#destAdd').on('click', function(){

	$('#modal-Adddest').modal('show');
});
//Validation de la destination créee
$('#Adddest-form').submit(function(event){

	event.preventDefault();
	var data = 'pays='+$('#input-pays').val()+'&port='+$('#input-port').val();
	
	$('#modal-Adddest').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_addDest.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){

			if(data[0] == 2){
				notification("La destination "+$('#input-pays').val()+" - "+$('#input-port').val()+" a été créee avec succès.","","alert-success");
				//Chargement de la liste des destinations
				getDestination();
			}
			else if(data[0] == 1){
				notification("La destination "+$('#input-pays').val()+" - "+$('#input-port').val()+" existe déjà.","Veuillez la rechercher dans le tableau des destinations !","alert-warning");
			}
			$('#input-pays').val('');
			$('#input-port').val('');
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin création destination

//Modfication destination
$('#dest-table').on('click','.fa-edit', function(){
	
	$('#upiddest').val($(this).attr('id'));
	
	//Chargement de la destination à modifier
	$.ajax({
		
		url: './models/Admin_admin_getDest.php',
		type: 'POST',
		data:'iddest='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				$('#pays_Updpays').val(data[1]);
				$('#port_Updport').val(data[2]);				
				$('#modal-Upddest').modal('show');
			}
		}			
	});
});
//Validation de la destination modifiée
$('#Upddest-form').submit(function(event){

	event.preventDefault();
	var data = 'upiddest='+$('#upiddest').val()+'&pays='+$('#pays_Updpays').val()+'&port='+$('#port_Updport').val();
	
	$('#modal-Upddest').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_updateDest.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){
				notification("La destination "+$('#pays_Updpays').val()+" - "+$('#port_Updport').val()+" a été modifiée avec succès.","","alert-success");
				//Chargement de la liste des destinations
				getDestination();
			}
			else if(data[0] == 0){
				notification("La destination "+$('#pays_Updpays').val()+" - "+$('#port_Updport').val()+" existe déjà.","Veuillez la rechercher dans le tableau des destinations !","alert-warning");
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin modification destination

//Activation et désactivation d'une destination
$('#dest-table').on('click','.toggledest', function(){

	$('#iddest-updatstat').val($(this).attr('id'));
	
	if($(this).hasClass('fa-toggle-on')){
		$('#dest-verb').html('d&eacute;sactiver');
	}
	else{
		$('#dest-verb').html('r&eacute;activer');
	}
	$('#updatestate-destination').text(($(this).closest('tr').find('td:nth-child(1)').text())+" - "+($(this).closest('tr').find('td:nth-child(2)').text()));
	$('#modal-upstatdestConfirmation').modal('show');	
});
$('#validate-upstatdestConfirmation').on('click', function(){
	
	$('#modal-upstatdestConfirmation').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Admin_admin_updateDest.php',
		type : 'POST',
		data : 'iddest='+$('#iddest-updatstat').val(),
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 2){
				notification("La destination "+$('#updatestate-destination').text()+" a été désactivée avec succès.","","alert-success");
			}
			if(data[0] == 3){
				notification("La destination "+$('#updatestate-destination').text()+" a été réactivée avec succès.","","alert-success");
			}
			//Chargement de la liste des destinations
			getDestination();
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin activation et désactivation d'une destination