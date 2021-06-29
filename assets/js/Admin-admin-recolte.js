function getRecolte(){
	
	//Chargement de la liste des recoltes
	$.ajax({
		
		url: './models/Admin_admin_getRec.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#rec-table').DataTable().clear().draw(false);
			
			var i = 0,
				faicon = '',
				j = data[1] * 7,
				role = data[(data.length - 1)],
				option = ''
			;			
			while(i < j){
				
				if(data[i+7] == 0){
					faicon = 'toggle-on';
				}
				else if(data[i+7] == 1){
					faicon = 'toggle-off';
				}
				if(role <= 1){
					option = '<a href="#" id="'+data[i+2]+'" class="far fa-edit fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fa fa-'+faicon+' fa-lg togglerec"></a>';
				}
				$('#rec-table').DataTable().row.add([
					data[i+3],
					data[i+4],
					data[i+5],
					data[i+6],
					data[i+8],
					option
				]).columns.adjust().draw(false);
				i += 7 ;
			}
		}			
	});
}

//Création Recolte
$('#add-rec').on('click', function(){	
	getSelectProduit('#rec-product');
	$('#modal-add-rec').modal('show');
});
$('#form-add-rec').submit(function(e){

	e.preventDefault();
	var data = 'prodt='+$('#rec-product').val()+'&debut='+$('#rec-dateD').val()+'&libel='+$('#rec-year').val()+'&fin='+$('#rec-dateF').val();
	
	$('#modal-add-rec').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_addRec.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 2){
				msg1 = "La récolte "+$('#rec-year').val()+" du "+$('#rec-product option:selected').text()+" a été créee avec succès.";
				type = "alert-success";
				//Chargement de la liste des campagnes
				getRecolte();
			}
			else if(data[0] == 1){
				msg1 = "La récolte "+$('#rec-year').val()+" du "+$('#rec-product option:selected').text()+" existe déjà.";
				msg2 = "Veuillez la rechercher dans le tableau des récoltes !";
				type = "alert-warning";
			}
			else if(data[0] == 0){
				msg1 = "La récolte "+$('#rec-year').val()+" du "+$('#rec-product option:selected').text()+" n'a pas été créee.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !";
				type = "alert-danger";
			}
			$('#rec-product').val($('#rec-product option:first').val());
			$('#rec-dateD').val('');
			$('#rec-year').val('');
			$('#rec-dateF').val('');
			
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});

//Modfication récolte
$('#rec-table').on('click','.fa-edit', function(){
	
	$('#update-id-rec').val($(this).attr('id'));
	$('#update-lib-rec').text($(this).closest('tr').find('td:nth-child(1)').text())
	
	//Chargement de la récolte à modifier
	$.ajax({
		
		url: './models/Admin_admin_getRec.php',
		type: 'POST',
		data:'idrec='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 1){
				$('#rec-update-dateD').val(data[1]);
				$('#rec-update-dateF').val(data[2]);
				$('#modal-update-rec').modal('show');
			}
			else if(data[0] == 0){
				msg1 = "La récolte "+$('#update-lib-rec').val()+" n'a pu être récupérée.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !";
				type = "alert-danger";
				$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
			}
		}			
	});
});
$('#form-update-rec').submit(function(e){

	e.preventDefault();
	var data = 'upidrec='+$('#update-id-rec').val()+'&debut='+$('#rec-update-dateD').val()+'&fin='+$('#rec-update-dateF').val();
	
	$('#modal-update-rec').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_updateRec.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 1){
				msg1 = "La récolte "+$('#update-lib-rec').text()+" a été modifiée avec succès.";
				type = "alert-success";
				//Chargement de la liste des campagnes
				getRecolte();
			}
			else if(data[0] == 0){
				msg1 = "La récolte "+$('#update-lib-rec').text()+" n'a pas été modifiée.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !";
				type = "alert-danger";
			}
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});

//Activation et désactivation d'une récolte
$('#rec-table').on('click','.togglerec', function(){

	$('#status-id-rec').val($(this).attr('id'));
	
	if($(this).hasClass('fa-toggle-on')){
		$('#status-verb-rec').html('cl&ocirc;turer');
		$('#status-rec-state').val(1);
	}
	else{
		$('#status-verb-rec').html('rouvrir');
		$('#status-rec-state').val(0);
	}
	$('#status-lib-rec').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#modal-status-rec').modal('show');	
});
$('#button-status-rec').on('click', function(){
	
	$('#modal-status-rec').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Admin_admin_updateRec.php',
		type : 'POST',
		data : 'idrec='+$('#status-id-rec').val()+'&state='+$('#status-rec-state').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 2){				
				if($('#status-rec-state').val() == 1){
					msg1 = "La récolte "+$('#status-lib-rec').text()+" a été clôturée avec succès.";
					type = "alert-success";
				}
				else if($('#status-rec-state').val() == 0){
					msg1 = "La récolte "+$('#status-lib-rec').text()+" a été rouverte avec succès.";
					type = "alert-success";
				}
				//chargement de la liste des utilisateurs en ligne
				getRecolte();				
			}
			else if(data[0] == 0){
				msg1 = "La récolte "+$('#status-lib-rec').text()+" n'a pas été modifié.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !"
				type = "alert-danger";
			}
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});