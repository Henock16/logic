function getEgreneur(){
	
	//Chargement de la liste des egreneurs
	$.ajax({
		
		url: './models/Admin_admin_getEgre.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#egren-table').DataTable().clear().draw(false);
			
			var i = 0,
				j = data[1] * 4,
				faicon = '',
				role = data[(data.length - 1)],
				option = ''
			;

			while(i < j){
				
				if(data[i+4] == 0){
					faicon = 'toggle-on';
				}
				if(data[i+4] == 1){
					faicon = 'toggle-off';
				}
				if(role <= 1){
					option = '<a href="#" id="'+data[i+2]+'" class="far fa-edit fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fa fa-'+faicon+' fa-lg toggleegre"></a>';
				}
				$('#egren-table').DataTable().row.add([
					data[i+3],
					data[i+5],
					option
				]).columns.adjust().draw(false);
				i +=4;
			}
		}			
	});
}

//Création Egreneur
$('#egreAdd').on('click', function(){

	$('#modal-Addegre').modal('show');
});
//Validation de l'égreneur crée
$('#Addegre-form').submit(function(event){

	event.preventDefault();
	var data = 'egreneur='+$('#input-egre').val();
	
	$('#modal-Addegre').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_addEgre.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){

			if(data[0] == 2){
				notification("L'égreneur "+$('#input-egre').val()+" a été crée avec succès.","","alert-success");
				//Chargement de la liste des égreneurs
				getEgreneur();
			}
			else if(data[0] == 1){
				notification("L'égreneur "+$('#input-egre').val()+" existe déjà.","Veuillez le rechercher dans le tableau des égreneurs !","alert-warning");
			}
			$('#input-egre').val('');
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin création egreneur

//Modfication égreneur
$('#egren-table').on('click','.fa-edit', function(){
	
	$('#upidegre').val($(this).attr('id'));
	
	//Chargement de l'égreneur à modifier
	$.ajax({
		
		url: './models/Admin_admin_getEgre.php',
		type: 'POST',
		data:'idegre='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				$('#egre_Updegre').val(data[1]);				
				$('#modal-Updegre').modal('show');
			}
		}			
	});
});
//Validation de l'égreneur modifié
$('#Updegre-form').submit(function(event){

	event.preventDefault();
	var data = 'upidegre='+$('#upidegre').val()+'&egre='+$('#egre_Updegre').val();
	
	$('#modal-Updegre').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_updateEgre.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){
				notification("L'égreneur "+$('#egre_Updegre').val()+" a été modifié avec succès.","","alert-success");
				//Chargement de la liste des égreneurs
				getEgreneur();
			}
			else if(data[0] == 0){
				notification("L'égreneur "+$('#egre_Updegre').val()+" existe déjà.","Veuillez le rechercher dans le tableau des égreneurs !","alert-warning");
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin modification egreneur

//Activation et désactivation d'un égreneur
$('#egren-table').on('click','.toggleegre', function(){

	$('#idegre-updatstat').val($(this).attr('id'));
	
	if($(this).hasClass('fa-toggle-on')){
		$('#egre-verb').html('d&eacute;sactiver');
	}
	else{
		$('#egre-verb').html('r&eacute;activer');
	}
	$('#updatestate-egreneur').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#modal-upstategreConfirmation').modal('show');	
});
$('#validate-upstategreConfirmation').on('click', function(){
	
	$('#modal-upstategreConfirmation').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Admin_admin_updateEgre.php',
		type : 'POST',
		data : 'idegre='+$('#idegre-updatstat').val(),
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 2){
				notification("L'égreneur "+$('#updatestate-egreneur').text()+" a été désactivé avec succès.","","alert-success");
			}
			if(data[0] == 3){
				notification("L'égreneur "+$('#updatestate-egreneur').text()+" a été réactivé avec succès.","","alert-success");
			}
			//Chargement de la liste des egreneurs
			getEgreneur();
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin activation et désactivation d'un égreneur