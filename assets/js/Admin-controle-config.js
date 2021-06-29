function getContConfig(){
	
	//Chargement de la liste des config du Controle
	$.ajax({
		
		url: './models/Admin_controle_getConfig.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#config-table').DataTable().clear().draw(false);
			
			var i = 0,
				j = data[0] * 4,
				button = ''
			;

			while(i < j){
				
				if(data[i+3] > 0){
					button = '<a href="#" id="'+data[i+1]+'" class="far fa-edit fa-lg"></a>';
				}
				else{
					
					if(data[i+3] == 'Automatique'){
						button = '<a href="#" id="'+data[i+1]+'" class="fa fa-toggle-on fa-lg togglecconf"></a>';
					}
					else{
						button = '<a href="#" id="'+data[i+1]+'" class="fa fa-toggle-off fa-lg togglecconf"></a>';
					}
				}
				
				$('#config-table').DataTable().row.add([
					data[i+2],
					data[i+3],
					data[i+4],
					'',
				]).columns.adjust().draw(false);
				i +=4 ;
			}	
		}
	});
}

//Passage entre les modes auto et manuel pour la configuration du Controle
$('#config-table').on('click','.togglecconf', function(){
	
	$('#idconfc-updatstat').text($(this).attr('id'));
	
	$('#updatestate-confc').text($(this).closest('tr').find('td:nth-child(1)').text()+' à '+$(this).closest('tr').find('td:nth-child(3)').text());
	
	if($(this).hasClass('fa-toggle-on')){
		$('#confc-mode').text('manuel');
	}
	else{
		$('#confc-mode').text('automatique');
	}
	
	$('#modal-upstatconfcConfirmation').modal('show');
});
$('#validate-upstatconfcConfirmation').on('click', function(){
	
	var data = 0;
	
	if($('#confc-mode').text() == 'automatique'){
		data = 1;
	}
	
	$('#modal-upstatconfcConfirmation').modal('hide');
	showLoader();
	
	$.ajax({
		
		url: './models/Admin_controle_updateConfig.php',
		type: 'POST',
		data: 'idconf='+$('#idconfc-updatstat').text()+'&valeur='+data,
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				notification("La modification a bien été effectuée avec succès.","","alert-success");
				//Chargement de la configuration du Controle
				getContConfig();
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin passage entre les modes auto et manuel pour la configuration du Controle

//Modification d'une configuration à valeur numérique
$('#config-table').on('click','.fa-edit', function(){
	
	$('#Upconfctext').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#upidconfc').text($(this).attr('id'));
	$('#modal-Upconfcnum').modal('show');
});
$('#Upconfcnum-form').submit(function(e){
	
	e.preventDefault();
	
	$('#modal-Upconfcnum').modal('hide');
	showLoader();
	
	$.ajax({
		
		url: './models/Admin_controle_updateConfig.php',
		type: 'POST',
		data: 'idconf='+$('#upidconfc').text()+'&valeur='+$('#numberforconfc').val(),
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				notification("La modification a bien été effectuée avec succès.","","alert-success");
				//Chargement de la configuration du Controle
				getContConfig();
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
			
			$("#numberforconfc").val($("#numberforconfc option:first").val());
		}
	});
});