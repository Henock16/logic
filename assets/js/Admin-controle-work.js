function getContWork(){
	
	//Chargement de la liste des liasses à affecter au matching
	$.ajax({
		
		url: './models/Admin_controle_getAgent.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			if(data[0] > 0){
				
				$('#contro-table').DataTable().clear().draw(false);
				var i = 0,
					j = data[0] * 7,
					stat = ''
				;
				
				while(i < j){
					
					if(data[i+4] > 0){
						stat = 'Inactif';
					}
					else{
						stat = 'Actif';
					}
					
					$('#contro-table').DataTable().row.add([
						data[i+2],
						data[i+3],
						data[i+5],
						data[i+6],
						data[i+7],
						stat,
						'<a href="#" id="'+data[i+1]+'" class="fa fa-search-plus fa-lg"></a>',
					]).columns.adjust().draw(false);
					i += 7;
				}
			}
		}			
	});
}

//Affichage du détail des liasses au niveau d'un agent du matching
$('#contro-table').on('click','.fa-search-plus', function(){
	
	$('#title-ControlInfo').text($(this).closest('tr').find('td:nth-child(1)').text()+' '+$(this).closest('tr').find('td:nth-child(2)').text());
	$('#details-ControlInfo').html('<div class="form-group" style="font-weight: bold"><div class="col-xs-7"><label class="control-label">N&deg; Packing list</label></div><div class="col-xs-2 text-center"><label class="control-label">Tickets</label></div><div class="col-xs-3 text-center"><label class="control-label">Statut</label></div></div><div class="col-xs-12" style="height: 5px"></div>');
	
	showLoader();
	
	$.ajax({
		
		url: './models/Admin_getAgentWork.php',
		type: 'POST',
		data: 'idagent='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			if(data[0] > 0){
				
				var i = 0,
					j = data[0] * 3,
					stat = '',
					color = ''
				;
				
				while(i < j){
					
					if(data[i+3] == 0){
						stat = 'Bac non conforme' ;
						color = '#dd4b39';
					}
					else if(data[i+3] == 1){
						stat = 'Bac du bordereau' ;
						color = '#f39c12';
					}
					else if(data[i+3] == 2){
						stat = 'Bac de traitement' ;
						color = '#00a65a';
					}
				
					$('#details-ControlInfo').append('<div class="form-group"><div class="col-xs-7"><input type="text" class="form-control pull-right" value="'+data[i+1]+'" disabled="disabled"/></div><div class="col-xs-2"><input type="text" class="form-control text-center" value="'+data[i+2]+'" disabled="disabled"/></div><div class="col-xs-3"><input type="text" class="form-control text-center" value="'+stat+'" disabled="disabled" style="background-color: '+color+'; color: white"/></div></div><div class="col-xs-12" style="height: 5px"></div>');
					i += 3;
				}
			}
			
			hideLoader();
			$('#modal-ControlInfo').modal('show');
		}
	});
});