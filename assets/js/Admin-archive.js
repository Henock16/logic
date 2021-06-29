function getPackingArchive(){

	//Chargement de la liste des packing-lists rejeté ou annulé
	$.ajax({
		
		url: './models/Admin_archive_getPackinglist.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#archpack-table').DataTable().clear().draw(false);
			
			var i = 0,
				heur = '',
				minu = '',
				seco = '',
				classe = '',
				j = data[1] * 9
			;
			while(i < j){
				
				if(data[i+8]<10){
					heur = '0'+data[i+8];
				}
				else{
					heur = data[i+8];
				}
				
				if(data[i+9]<10){
					minu = '0'+data[i+9];
				}
				else{
					minu = data[i+9];
				}
				
				if(data[i+10]<10){
					seco = '0'+data[i+10];
				}
				else{
					seco = data[i+10];
				}
				
				$('#archpack-table').DataTable().row.add([
					data[i+3],
					data[i+4],
					new Intl.NumberFormat("fr-FR").format(data[i+6]),
					data[i+7],
					data[i+5],
					'<span class="label" style="background-color: #7b7b7b;"><label style="color: white;" id="h">'+heur+'</label> : <label style="color: white;" id="m">'+minu+'</label> : <label style="color: white;" id="s">'+seco+'</label></span>',
					'<a href="#" id="'+data[i+2]+'" class="fa fa-search-plus fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="functions/Print.php?egasilocedetsil='+data[i+2]+'" id="'+data[i+2]+'" target="_blank" class="fa fa-print fa-lg"></a>',
				]).columns.adjust().draw(false);
				i += 9;
			}
		}			
	});
}

//Affichage des informations du Packing list
$('#archpack-table').on('click','.fa-search-plus', function(){
	
	var num = $(this).closest('tr').find('td:nth-child(1)').text();
	
	//chargement des informations
	$.ajax({
		
		url: './models/Admin_archive_getPackinglist.php',
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
				
				if(data[3] != 0){
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

function getCertificatArchive(){

	//Chargement de la liste des certificats
	$.ajax({
		
		url: './models/Admin_archive_getCertificat.php',
		type: 'POST',
		data:'',
		dataType: 'json',
		success : function(data){
			
			$('#archcertif-table').DataTable().clear().draw(false);
			
			var i = 0,
				heur = '',
				minu = '',
				seco = '',
				numpk = '',
				classe = '',
				j = data[1] * 11,
				option = '',
				role = data[(data.length - 1)]
			;
			while(i < j){
				
				if(data[i+8]<10){
					heur = '0'+data[i+8];
				}
				else{
					heur = data[i+8];
				}
				
				if(data[i+9]<10){
					minu = '0'+data[i+9];
				}
				else{
					minu = data[i+9];
				}
				
				if(data[i+10]<10){
					seco = '0'+data[i+10];
				}
				else{
					seco = data[i+10];
				}
				
				if(role <= 1){
					numpk = encodeURIComponent(data[i+11]);
					option = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="models/GenerateCertif_model.php?numpk='+numpk+'&cont='+data[i+12]+'" target="_blank" class="fa fa-print fa-lg"></a>';
				}
				
				$('#archcertif-table').DataTable().row.add([
					data[i+3],
					data[i+4],
					new Intl.NumberFormat("fr-FR").format(data[i+6]),
					data[i+7],
					data[i+5],
					'<span class="label" style="background-color: #7b7b7b;"><label style="color: white;" id="h">'+heur+'</label> : <label style="color: white;" id="m">'+minu+'</label> : <label style="color: white;" id="s">'+seco+'</label></span>',
					'<a href="#" id="'+data[i+2]+'" class="fa fa-search-plus fa-lg"></a>'+option,
				]).columns.adjust().draw(false);
				i += 11;
			}
		}			
	});
}

//Affichage des informations du Certificat
$('#archcertif-table').on('click','.fa-search-plus', function(){
	
	var num = $(this).closest('tr').find('td:nth-child(1)').text();
	
	//chargement des informations
	$.ajax({
		
		url: './models/Admin_archive_getCertificat.php',
		type: 'POST',
		data:'idcert='+$(this).attr('id'),
		dataType: 'json',
		success : function(data){
			
			if(data[0] == 1){
				
				if(data[4] =="Transmis au CCA") {
					$('#nume-pcklist').text("Certificat "+data[10]);
				}
				else{

					$('#nume-pcklist').text("Packing List "+num);
				}
				if(data[3] !=0){
					$('#A_R-pcklist').text("Annulé et remplacé par le Packing List "+data[3]);
				}
				
				$('#clie-pcklist').val(data[1]);
				$('#navi-pcklist').val(data[2]);

				if((data[4] =="Rejeté")||(data[4] =="Transmis au CCA")||(data[4] =="Traité")){

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