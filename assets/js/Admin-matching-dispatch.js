function getBundleMatchDispatch(){
	
	//Chargement de la liste des liasses à affecter au matching
	$.ajax({
		
		url: './models/Admin_matching_getBundle.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			$('#matching-table').DataTable().clear().draw(false);
			
			var i = 0,
				j = data[1] * 7
			;
			
			while(i < j){
				
				$('#matching-table').DataTable().row.add([
					data[i+3],
					data[i+4],
					data[i+5],
					new Intl.NumberFormat("fr-FR").format(data[i+6]),
					data[i+7],
					data[i+8],
					'<a href="#" id="'+data[i+2]+'" class="far fa-share-square fa-lg"></a>',
				]).columns.adjust().draw(false);
				i += 7 ;
			}
		}			
	});
}

//affectation d'une liasse au matching
$('#matching-table').on('click','.fa-share-square', function(){
	
	$('#match-title').text($(this).closest('tr').find('td:nth-child(1)').text());
	showLoader();

	$.ajax({

		url : './models/Admin_matching_infoAgent.php',
		type : 'POST',
		data : 'idmatch='+$(this).attr('id'),
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				$('#id-match').val(data[1]);

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
				$('#user_match').html(option);
				$('#modal-match').modal('show');
			}
			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});
});

$('#match-form').submit(function(event){

	event.preventDefault();
	var data = 'idmatch='+$('#id-match').val()+'&usermatch='+$('#user_match').val();
	
	$('#modal-match').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Admin_matching_dispatchBundle.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 1){

				notification("Le Packing list "+$('#match-title').text()+" a été transmis à "+data[1]+" avec succès.","","alert-success");
				//Chargement de la liste des liasses à affecter au matching
				getBundleMatchDispatch();
			}
			
			$( document ).ajaxStop(function(){
				hideLoader();
			});
		}
	});
});
//Fin affectation Liasse au Matching