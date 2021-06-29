function getProduit(){

	//Chargement de la liste des produits
	$.ajax({

		url: './models/Admin_admin_getProd.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){

			$('#prod-table').DataTable().clear().draw(false);

			var i = 0,
				j = data[1] * 4,
				faicon = '',
				role = data[(data.length - 1)],
				option = ''
			;

			while(i < j){

				if(data[i+4] == 0){
					faicon ='toggle-on';
				}
				if(data[i+4] == 1){
					faicon ='toggle-off';
				}
				if(role <= 1){
					option = '<a href="#" id="'+data[i+2]+'" class="far fa-edit fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+2]+'" class="fa fa-'+faicon+' fa-lg toggleprod"></a>';
				}
				$('#prod-table').DataTable().row.add([
					data[i+3],
					data[i+5],
					option
				]).columns.adjust().draw(false);
				i +=4;
			}
		}
	});
}

//Création produit
$('#prodAdd').on('click', function(){

	$('#modal-Addprod').modal('show');
});
//Validation du produit crée
$('#Addprod-form').submit(function(event){

	event.preventDefault();
	var data = 'produit='+$('#input-prod').val();

	$('#modal-Addprod').modal('hide');
	showLoader();

	$.ajax({

		url : './models/Admin_admin_addProd.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){

			if(data[0] == 2){
				notification("Le produit "+$('#input-prod').val()+" a été crée avec succès.","","alert-success");
				//Chargement de la liste des produits
				getProduit();
			}
			else if(data[0] == 1){
				notification("Le produit "+$('#input-prod').val()+" existe déjà.","Veuillez le rechercher dans le tableau des produits !","alert-warning");
			}
			$('#input-prod').val('');

			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin création produit

//Modfication produit
$('#prod-table').on('click','.fa-edit', function(){

	$('#upidprod').val($(this).attr('id'));

	//Chargement du produit à modifier
	$.ajax({

		url: './models/Admin_admin_getProd.php',
		type: 'POST',
		data:'idprod='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){

			if(data[0] == 1){
				$('#produit_Updprod').val(data[1]);

				$.ajax({

					url: './models/GetTypeProduit_model.php',
					type: 'POST',
					data:'idprod='+$('#upidprod').val(),
					dataType: 'json',
					success : function(data){

						if(data[0] == 1){
							var option = '<option selected disabled>---------------------- Sous-produit ----------------------</option>',
								j = 1,
								fin = (data.length - 1)/2;
							;

							for(var i = 0; i < fin; i++){
								option +='<option value="'+data[(i+j)]+'">'+data[(i+(j+1))]+'</option>';
								j += 1;
							}
							$('#sousproduit_delprod').html(option);
							$('#modal-Updprod').modal('show');
						}
					}
				});
			}
		}
	});
});
//Validation du produit modifié
$('#modal-Updprod').on('click','#button-updateprod', function(){

	var data = 'upidprod='+$('#upidprod').val()+'&prod='+$('#produit_Updprod').val();

	$('#modal-Updprod').modal('hide');
	showLoader();

	$.ajax({

		url : './models/Admin_admin_updateProd.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){

			if(data[0] == 1){
				notification("Le produit "+$('#produit_Updprod').val()+" a été modifié avec succès.","","alert-success");
				//Chargement de la liste des produits
				getProduit();
			}
			else if(data[0] == 0){
				notification("Le produit "+$('#produit_Updprod').val()+" existe déjà.","Veuillez le rechercher dans le tableau des produits !","alert-warning");
			}

			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Ajout d'un sous produit
$('#modal-Updprod').on('click','#button-addsousprod', function(){

	if(($('#sousproduit_addprod').val() != "") && ($('#sousproduit_addprod').val() !== null) ){

		var data = 'upidprod='+$('#upidprod').val()+'&sousprod='+$('#sousproduit_addprod').val();

		$('#modal-Updprod').modal('hide');
		showLoader();

		$.ajax({

			url : './models/Admin_admin_updateProd.php',
			type : 'POST',
			data : data,
			dataType : 'json',
			success : function(data){

				if(data[0] == 1){
					notification("Le sous-produit "+$('#sousproduit_addprod').val()+" a été ajouté avec succès.","","alert-success");
					//Chargement de la liste des produits
					getProduit();
				}
				else if(data[0] == 0){
					notification("Le sous-produit "+$('#sousproduit_addprod').val()+" existe déjà.","Veuillez le rechercher dans le tableau des produits !","alert-warning");
				}
				$('#sousproduit_addprod').val('');
				$( document ).ajaxStop(function(){
					hideLoader()
				});
			}
		});
	}
});
//Retrait d'un sous produit
$('#modal-Updprod').on('click','#button-delsousprod', function(){

	if(($('#sousproduit_delprod option:selected').val() != "") && ($('#sousproduit_delprod option:selected').val() !== null) ){

		var data = 'upidprod='+$('#upidprod').val()+'&delsousprod='+$('#sousproduit_delprod option:selected').val();

		$('#modal-Updprod').modal('hide');
		showLoader();

		$.ajax({

			url : './models/Admin_admin_updateProd.php',
			type : 'POST',
			data : data,
			dataType : 'json',
			success : function(data){

				if(data[0] == 1){
					notification("Le sous-produit "+$('#sousproduit_addprod').val()+" a été désactivé avec succès.","","alert-success");
				}
				$('#sousproduit_delprod').val('');
			}
		});
	}
});
//Fin modification produit

//Activation et désactivation d'un produit
$('#prod-table').on('click','.toggleprod', function(){

	$('#idprod-updatstat').val($(this).attr('id'));

	if($(this).hasClass('fa-toggle-on')){
		$('#prod-verb').html('d&eacute;sactiver');
	}
	else{
		$('#prod-verb').html('r&eacute;activer');
	}
	$('#updatestate-produit').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#modal-upstatprodConfirmation').modal('show');
});
$('#validate-upstatprodConfirmation').on('click', function(){

	$('#modal-upstatprodConfirmation').modal('hide');
	showLoader();

	$.ajax({

		url : './models/Admin_admin_updateProd.php',
		type : 'POST',
		data : 'idprod='+$('#idprod-updatstat').val(),
		dataType : 'json',
		success : function(data){

			if(data[0] == 2){
				notification("Le produit "+$('#updatestate-produit').text()+" a été désactivé avec succès.","","alert-success");
			}
			if(data[0] == 3){
				notification("Le produit "+$('#updatestate-produit').text()+" a été réactivé avec succès.","","alert-success");
			}
			//Chargement de la liste des produits
			getProduit();

			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin activation et désactivation d'un produit
