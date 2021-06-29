function getCampagne(){
	
	//Chargement de la liste des campagnes
	$.ajax({
		
		url: './models/Admin_admin_getCamp.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#camp-table').DataTable().clear().draw(false);
			
			var i = 0 ,
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
					option = '<a href="#" id="'+data[i+2]+'" class="far fa-edit fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fa fa-'+faicon+' fa-lg togglecamp"></a>';
				}
				
				$('#camp-table').DataTable().row.add([
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

//Création Campagne
$('#add-camp').on('click', function(){
	getSelectProduit('#camp-product');
	$('#modal-add-camp').modal('show');
});
$('#form-add-camp').submit(function(e){

	e.preventDefault();
	var data = 'prodt='+$('#camp-product').val()+'&debut='+$('#camp-dateD').val()+'&libel='+$('#camp-year').val()+'&fin='+$('#camp-dateF').val();
	
	$('#modal-add-camp').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_addCamp.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 2){
				msg1 = "La campagne "+$('#camp-year').val()+" du "+$('#camp-product option:selected').text()+" a été créee avec succès.";
				type = "alert-success";
				//Chargement de la liste des campagnes
				getCampagne();
			}
			else if(data[0] == 1){
				msg1 = "La campagne "+$('#camp-year').val()+" du "+$('#camp-product option:selected').text()+" existe déjà.";
				msg2 = "Veuillez la rechercher dans le tableau des campagnes !";
				type = "alert-warning";
			}
			else if(data[0] == 0){
				msg1 = "La campagne "+$('#camp-year').val()+" du "+$('#camp-product option:selected').text()+" n'a pas été créee.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !";
				type = "alert-danger";
			}
			$('#camp-product').val($('#camp-product option:first').val());
			$('#camp-dateD').val('');
			$('#camp-year').val('');
			$('#camp-dateF').val('');
			
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});

//Modfication campagne
$('#camp-table').on('click','.fa-edit', function(){
	
	$('#update-id-camp').val($(this).attr('id'));
	$('#update-lib-camp').text($(this).closest('tr').find('td:nth-child(1)').text());
	
	//Chargement de la campagne à modifier
	$.ajax({
		
		url: './models/Admin_admin_getCamp.php',
		type: 'POST',
		data:'idcamp='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 1){
				$('#camp-update-dateD').val(data[1]);
				$('#camp-update-dateF').val(data[2]);
				$('#modal-update-camp').modal('show');
			}
			else if(data[0] == 0){
				msg1 = "La campagne "+$('#update-lib-camp').val()+" n'a pu être récupérée.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !";
				type = "alert-danger";
				$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
			}
		}			
	});
});
$('#form-update-camp').submit(function(e){

	e.preventDefault();
	var data = 'upidcamp='+$('#update-id-camp').val()+'&debut='+$('#camp-update-dateD').val()+'&fin='+$('#camp-update-dateF').val();
	
	$('#modal-update-camp').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_updateCamp.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 1){
				msg1 = "La campagne "+$('#update-lib-camp').text()+" a été modifiée avec succès.";
				type = "alert-success";
				//Chargement de la liste des campagnes
				getCampagne();
			}
			else if(data[0] == 0){
				msg1 = "La campagne "+$('#update-lib-camp').text()+" n'a pas été modifiée.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !";
				type = "alert-danger";
			}
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});

//Activation et désactivation d'une campagne
$('#camp-table').on('click','.togglecamp', function(){

	$('#status-id-camp').val($(this).attr('id'));
	
	if($(this).hasClass('fa-toggle-on')){
		$('#status-verb-camp').html('cl&ocirc;turer');
		$('#status-camp-state').val(1);
	}
	else{
		$('#status-verb-camp').html('rouvrir');
		$('#status-camp-state').val(0);
	}
	$('#status-lib-camp').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#modal-status-camp').modal('show');
});
$('#button-status-camp').on('click', function(){
	
	$('#modal-status-camp').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Admin_admin_updateCamp.php',
		type : 'POST',
		data : 'idcamp='+$('#status-id-camp').val()+'&state='+$('#status-camp-state').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = ''
			; 
			if(data[0] == 2){				
				if($('#status-camp-state').val() == 1){
					msg1 = "La campagne "+$('#status-lib-camp').text()+" a été clôturée avec succès.";
					type = "alert-success";
				}
				else if($('#status-camp-state').val() == 0){
					msg1 = "La campagne "+$('#status-lib-camp').text()+" a été rouverte avec succès.";
					type = "alert-success";
				}
				//chargement de la liste des utilisateurs en ligne
				getCampagne();				
			}
			else if(data[0] == 0){
				msg1 = "La campagne "+$('#status-lib-camp').text()+" n'a pas été modifié.";
				msg2 = "Veuillez contacter immédiatement l'administrateur !"
				type = "alert-danger";
			}
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});