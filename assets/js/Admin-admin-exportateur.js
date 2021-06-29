function getExportateur(){
	
	//Chargement de la liste des exportateurs
	$.ajax({
		
		url: './models/Admin_admin_getExpor.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#expor-table').DataTable().clear().draw(false);
			
			var i = 0,
				faicon = '',
				j = data[1] * 7,
				role = data[(data.length - 1)],
				option = ''
			;
			
			while(i < j){
				
				if(data[i+8] == 0){
					faicon = 'toggle-on';
				}
				else if(data[i+8] == 1){
					faicon = 'toggle-off';
				}
				if(role <= 1){
					option = '<a href="#" id="'+data[i+2]+'" class="far fa-edit fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fa fa-'+faicon+' fa-lg toggleexp"></a>';
				}
				$('#expor-table').DataTable().row.add([
					data[i+3],
					data[i+4],
					data[i+5],
					data[i+6],
					data[i+7],
					option
				]).columns.adjust().draw(false);
				i += 7;
			}
		}			
	});
}

//Création exportateur
$('#exporAdd').on('click', function(){
	
	//Chargement de la liste des produits
	$.ajax({
		
		url : './models/Admin_selectProd.php',
		type : 'POST',
		data : '',
		dataType : 'json',
		success : function(data){

			var option = '<option selected disabled>------------ Produit ------------</option>',
				j = 1
			;
			
			for(var i = 0; i < data[0]; i++){
				option +='<option value="'+data[(i+j)]+'">'+data[(i+(j+1))]+'</option>';
				j+=1;
			}
			$('#prod_Addexpor').html(option);
			$('#modal-Addexpor').modal('show');
		}
	});
});
//Validation de l'exportateur crée
$('#Addexpor-form').submit(function(event){

	event.preventDefault();
	var data = 'expor='+$('#expor_Addexpor').val()+'&prod='+$('#prod_Addexpor').val()+'&camp='+$('#camp_Addexpor').val()+'&agre='+$('#agre_Addexpor').val();
	
	$('#modal-Addexpor').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_addExpor.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){

			if(data[0] == 0){
				notification("L'exportateur "+data[1]+" du produit "+$('#prod_Addexpor option:selected').text()+" existe déjà.","Veuillez le rechercher dans le tableau des exportateurs !","alert-warning");
			}
			else{
				notification("L'exportateur "+data[1]+" a été crée pour la campagne "+data[2]+" avec l'agrement "+data[3]+".","","alert-success");
				//Chargement de la liste des campagnes
				getExportateur();
			}
			$('#expor_Addexpor').val('');
			$('#prod_Addexpor').val('');
			$('#camp_Addexpor').val('');
			$('#agre_Addexpor').val('');
			hideLoader();
		}
	});
});
//Fin création exportateur

//Modfication exportateur
$('#expor-table').on('click','.fa-edit', function(){

	$('#id-Updexp').val($(this).attr('id'));
	$('#name-Updexp').val($(this).closest('tr').find('td:nth-child(1)').text());

	$.ajax({

		url : './models/Admin_admin_infoExpor.php',
		type : 'POST',
		data : 'idexpor='+$(this).attr('id'),
		dataType : 'json',
		success : function(data){
			
			$('#expor_Updexpor').val(data[0]);
			$('#prod_Updprod').val(data[1]);
			
			var fin = (data.length - 2)/2,
				j = 0,
				option = '<option selected disabled>--------- Campagne ---------</option>'
			;
			
			for(var i = 0; i < fin; i++){
				option += '<option value="'+data[j+2]+'">'+data[j+3]+'</option>';						
				j += 2;
			}
			$('#camp_Updexpor').html(option);
			$('#modal-Updexpor').modal('show');
		}
	});
});
//Validation de l'exportateur modifié
$('#Updexpor-form').submit(function(event){

	event.preventDefault();
	var data = 'id_expor='+$('#id-Updexp').val()+'&camp='+$('#camp_Updexpor').val()+'&agre='+$('#Agre_Updexpor').val();
	
	$('#modal-Updexpor').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_admin_updateExpor.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 3){
				notification("Les modifications portant sur l'exportateur "+$('#name-Updexp').val()+" ont été effectuées avec succès.","","alert-success");

			}
			else if(data[0] == 4) {
				notification("L'exportateur "+$('#name-Updexp').val()+" a été reassocié à la campagne "+$('#camp_Updexpor option:selected').text()+".","","alert-success");
			}
			$('#Agre_Updexpor').val('');
			//Chargement de la liste des exportateurs
			getExportateur();
			hideLoader();
		}
	});
});
//Fin modification exportateur

//Activation et désactivation d'un exportateur pour une campagne donnée
$('#expor-table').on('click','.toggleexp', function(){
	
	$('#idexp-updatstat').val($(this).attr('id'));
	
	if($(this).hasClass('fa-toggle-on')){
		$('#exp-verb').html('d&eacute;sactiver');
	}
	else{
		$('#exp-verb').html('r&eacute;activer');
	}
	$('#updatestate-exportateur').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#modal-upstatexpConfirmation').modal('show');	
});
$('#validate-upstatexpConfirmation').on('click', function(){
	
	$('#modal-upstatexpConfirmation').modal('hide');
	showLoader();
	
	$.ajax({

		url : './models/Admin_admin_updateExpor.php',
		type : 'POST',
		data : 'idexp='+$('#idexp-updatstat').val(),
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){
				notification("L'exportateur "+$('#updatestate-exportateur').text()+" a été désactivé avec succès.","","alert-success");
			}
			if(data[0] == 2){
				notification("L'exportateur "+$('#updatestate-exportateur').text()+" a été réactivé avec succès.","","alert-success");
			}
			//Chargement de la liste des campagnes
			getExportateur();
			hideLoader();
		}
	});
});
//Fin activation et désactivation d'un exportateur pour une campagne donnée