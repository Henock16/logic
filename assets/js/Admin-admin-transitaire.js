function getTransitaire(){
	
	//Chargement de la liste des transitaires
	$.ajax({
		
		url: './models/Admin_admin_getTrans.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#transit-table').DataTable().clear().draw(false);
			
			var i = 0,
				j = (data[1] * 4),
				faicon = '',
				role = data[(data.length - 1)],
				option = ''
			;

			while(i < j){
				
				if(data[i+4]==0){
					faicon = 'toggle-on';
				}
				if(data[i+4]==1){
					faicon = 'toggle-off';
				}
				if(role <= 1){
					option = '<a href="#" id="'+data[i+2]+'" class="far fa-edit fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fa fa-'+faicon+' fa-lg toggletrans"></a>';
				}
				$('#transit-table').DataTable().row.add([
					data[i+3],
					data[i+5],
					option
				]).columns.adjust().draw(false);
				i +=4;
			}
		}			
	});
}

//Création Transitaire
$('#transAdd').on('click', function(){

	$('#modal-Addtrans').modal('show');
});
//Validation du transitaire crée
$('#Addtrans-form').submit(function(event){

	event.preventDefault();
	var data = 'trans='+$('#input-trans').val();
	
	$('#modal-Addtrans').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_addTrans.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){

			if(data[0] == 2){
				notification("Le transitaire "+$('#input-trans').val()+" a été crée avec succès.","","alert-success");
				//Chargement de la liste des transitaires
				getTransitaire();
			}
			else if(data[0] == 1){
				notification("Le transitaire "+$('#input-trans').val()+" existe déjà.","Veuillez le rechercher dans le tableau des transitaires !","alert-warning");
			}
			else{
				notification("Le transitaire "+$('#input-trans').val()+" n'a pas été crée.","Veuillez contacter immédiatement l'administrateur !","alert-danger");
			}
			$('#input-trans').val('');
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin création transitaire

//Modfication transitaire
$('#transit-table').on('click','.fa-edit', function(){
	
	$('#upidtrans').val($(this).attr('id'));
	
	//Chargement du transitaire à modifier
	$.ajax({
		
		url: './models/Admin_admin_getTrans.php',
		type: 'POST',
		data:'idtrans='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				$('#trans_Updtrans').val(data[1]);				
				$('#modal-Updtrans').modal('show');
			}
		}			
	});
});
//Validation du transitaire modifié
$('#Updtrans-form').submit(function(event){

	event.preventDefault();
	var data = 'upidtrans='+$('#upidtrans').val()+'&trans='+$('#trans_Updtrans').val();
	
	$('#modal-Updtrans').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_updateTrans.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){
				notification("Le transitaire "+$('#trans_Updtrans').val()+" a été modifié avec succès.","","alert-success");
				//Chargement de la liste des transitaires
				getTransitaire();
			}
			else if(data[0] == 0){
				notification("Le transitaire "+$('#trans_Updtrans').val()+" existe déjà.","Veuillez le rechercher dans le tableau des transitaires !","alert-warning");
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin modification transitaire

//Activation et désactivation d'un transitaire
$('#transit-table').on('click','.toggletrans', function(){

	$('#idtrans-updatstat').val($(this).attr('id'));
	
	if($(this).hasClass('fa-toggle-on')){
		$('#trans-verb').html('d&eacute;sactiver');
	}
	else{
		$('#trans-verb').html('r&eacute;activer');
	}
	$('#updatestate-transitaire').text($(this).closest('tr').find('td:nth-child(1)').text())
	$('#modal-upstattransConfirmation').modal('show');	
});
$('#validate-upstattransConfirmation').on('click', function(){
	
	$('#modal-upstattransConfirmation').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Admin_admin_updateTrans.php',
		type : 'POST',
		data : 'idtrans='+$('#idtrans-updatstat').val(),
		dataType : 'json',
		success : function(data){			
			
			if(data[0] == 2){
				notification("Le transitaire "+$('#updatestate-transitaire').text()+" a été désactivé avec succès.","","alert-success");
			}
			if(data[0] == 3){
				notification("Le transitaire "+$('#updatestate-transitaire').text()+" a été réactivé avec succès.","","alert-success");
			}
			//Chargement de la liste des transitaires
			getTransitaire();
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin activation et désactivation d'un transitaire