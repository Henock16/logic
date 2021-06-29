function getMatchConfig(){
	
	//Chargement de la liste des config du Matching
	$.ajax({
		
		url: './models/Admin_matching_getConfig.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#configM-table').DataTable().clear().draw(false);
			
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
						button = '<a href="#" id="'+data[i+1]+'" class="fa fa-toggle-on fa-lg togglemconf"></a>';
					}
					else{
						button = '<a href="#" id="'+data[i+1]+'" class="fa fa-toggle-off fa-lg togglemconf"></a>';
					}
				}
				
				$('#configM-table').DataTable().row.add([
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

//Passage entre les modes auto et manuel pour la configuration du Matching
$('#configM-table').on('click','.togglemconf', function(){
	
	$('#idconf-updatstat').text($(this).attr('id'));
	
	$('#updatestate-conf').text($(this).closest('tr').find('td:nth-child(1)').text()+' à '+$(this).closest('tr').find('td:nth-child(3)').text());
	
	if($(this).hasClass('fa-toggle-on')){
		$('#conf-mode').text('manuel');
	}
	else{
		$('#conf-mode').text('automatique');
	}
	
	$('#modal-upstatconfConfirmation').modal('show');
});
$('#validate-upstatconfConfirmation').on('click', function(){
	
	var data = 0;
	
	if($('#conf-mode').text() == 'automatique'){
		data = 1;
	}
	
	$('#modal-upstatconfConfirmation').modal('hide');
	showLoader();
	
	$.ajax({
		
		url: './models/Admin_matching_updateConfig.php',
		type: 'POST',
		data: 'idconf='+$('#idconf-updatstat').text()+'&valeur='+data,
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				notification("La modification a bien été effectuée avec succès.","","alert-success");
				//Chargement de la configuration au Matching
				getMatchConfig();
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});
//Fin passage entre les modes auto et manuel pour la configuration du Matching

//Modification d'une configuration à valeur numérique
$('#configM-table').on('click','.fa-edit', function(){
	
	$('#Upconftext').text($(this).closest('tr').find('td:nth-child(1)').text());
	$('#upidconf').text($(this).attr('id'));
	$('#modal-Upconfnum').modal('show');
});
$('#Upconfnum-form').submit(function(e){
	
	e.preventDefault();
	
	$('#modal-Upconfnum').modal('hide');
	showLoader();
	
	$.ajax({
		
		url: './models/Admin_matching_updateConfig.php',
		type: 'POST',
		data: 'idconf='+$('#upidconf').text()+'&valeur='+$('#numberforconf').val(),
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				notification("La modification a bien été effectuée avec succès.","","alert-success");
				//Chargement de la configuration au Matching
				getMatchConfig();
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
			
			$("#numberforconf").val($("#numberforconf option:first").val());
		}
	});
});












