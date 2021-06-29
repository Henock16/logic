function getArchive(){

	//Chargement de la liste des packing-lists
	$.ajax({
		
		url: './models/Reception_reception_getArchive.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#archive-table').DataTable().clear().draw(false);
			
			var i = 0,
				heur ='',
				minu ='',
				seco ='',
				j = data[1] * 10
			;
			while(i < j){
				if(data[i+9]<10){
					heur ='0'+data[i+9];
				}
				else{
					heur = data[i+9];
				}
				if(data[i+10]<10){
					minu ='0'+data[i+10];
				}
				else{
					minu = data[i+10];
				}
				if(data[i+11]<10){
					seco ='0'+data[i+11];
				}
				else{
					seco = data[i+11];
				}

				$('#archive-table').DataTable().row.add([
				
					data[i+3],
					data[i+4],
					new Intl.NumberFormat("fr-FR").format(data[i+7]),
					data[i+6],
					'<span class="label" style="background-color: #7b7b7b;"><label style="color: white;" id="h">'+heur+'</label> : <label style="color: white;" id="m">'+minu+'</label> : <label style="color: white;" id="s">'+seco+'</label></span>',
					'<a href="#" id="'+data[i+2]+'" class="fa fa-search-plus fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="functions/Print.php?egasilocedetsil='+data[i+2]+'" id="'+data[i+2]+'" target="_blank" class="fa fa-print fa-lg"></a>',
				]).columns.adjust().draw(false);
				i += 10;
			}
		}			
	});
}

//Affichage des informations du Packing list
$('#archive-table').on('click','.fa-search-plus', function(){
	
	var num = $(this).closest('tr').find('td:nth-child(1)').text();
	
	//chargement des informations
	$.ajax({
		
		url: './models/Reception_reception_getArchive.php',
		type: 'POST',
		data:'idcert='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				if(data[4] =="Transmis au CCA"){
					$('#nume-pcklist').text("Certificat "+data[10]);
				}
				else{

					$('#nume-pcklist').text("Packing List "+num);
				}
				
				if(data[3] !=0){
					$('#A_R-pcklist').text("Annulé et remplacé par le Packing List "+data[3]);
				}
				else{
					$('#A_R-pcklist').text("");
				}
				
				$('#clie-pcklist').val(data[1]);
				$('#navi-pcklist').val(data[2]);

				if((data[4] =="Rejeté")||(data[4] =="Transmis au CCA")){

					$('#statu-pcklist').val(data[4]);
				}
				else{

					$('#statu-pcklist').val("Annulé");
				}
				
				
				$('#transi-pcklist').val(data[5]);
				$('#desti-pcklist').val(data[6]);
				$('#dema-pcklist').val(data[7]);
				$('#dernragent-pcklist').val(data[8]);
				$('#nbtckte-pcklist').val(data[9]);
				
				$('#modal-infoArchive').modal('show');
			}
		}
	});
});