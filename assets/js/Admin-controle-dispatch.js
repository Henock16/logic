function getSlipContDispatch(){
	
	//Chargement de la liste des borderaux à affecter au contrôle
	$.ajax({
		
		url: './models/Admin_controle_getSlip.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			if(data[0] > 0){
				
				$('#controle-table').DataTable().clear().draw(false);
			
				var i = 0,
					j = data[0] * 6
				;
				
				while(i < j){
				
					$('#controle-table').DataTable().row.add([
						data[i+5],
						data[i+2],
						data[i+3],
						new Intl.NumberFormat("fr-FR").format(data[i+4]),
						data[i+6],
						'<a href="#" id="'+data[i+1]+'" class="far fa-share-square fa-lg"></a>'
					]).columns.adjust().draw(false);
					i += 6 ;
				}
			}s
		}			
	});
}

//affectation d'un bordereau au controle
$('#controle-table').on('click','.fa-share-square', function(){
	
	$('#controle-title').text($(this).attr('id'));
	showLoader();

	$.ajax({
		url : './models/Admin_controle_infoAgent.php',
		type : 'POST',
		data : 'idcontrol='+$(this).attr('id'),
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				$('#id-cont').val(data[1]);

				var j = 0;
				
				if (data[2] > 0){	

					var option = '<option selected disabled>-------------------------- Agent disponible --------------------------</option>';

					for(var i = 0; i < data[2]; i++){

						option += '<option value="'+data[(3+j)]+'">'+data[(3+(j+1))]+' ('+data[(3+(j+2))]+' tickets)</option>';
						j += 3;
					}
				}
				else{

					var option = '<option selected disabled>----------------------- Aucun agent disponible -----------------------</option>';
				}
				$('#user_cont').html(option);
				$('#modal-cont').modal('show');
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});

$('#cont-form').submit(function(event){

	event.preventDefault();
	var data = 'idcont='+$('#id-cont').val()+'&usercont='+$('#user_cont').val();
	
	$('#modal-cont').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_controle_dispatchSlip.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){

				notification("Le bordereau "+$('#controle-title').text()+" a été transmis à "+data[1]+" avec succès.","","alert-success");
				//Chargement de la liste des liasses à affecter au matching
				getSlipContDispatch();
			}
			
			$( document ).ajaxStop(function(){
				hideLoader();
			});
		}
	});
});
//Fin affectation d'un bordereau au controle