//Vérification si nombre est entier
function isInt(n){	
   return n % 1 === 0;
}

//Mise à jour du poids net au changement des tares
function CalculPnet(form){
	
	var tcont = document.getElementById('tcont').value ;	
	if(tcont == ''){
		tcont = 0 ;
	}

	var pnet = (Math.abs(document.getElementById('pes1').value - document.getElementById('pes2').value)) - tcont - document.getElementById('temb').value;
	if(form == 'control-cajou'){		
		pnet -= document.getElementById('thab').value;
	}	
	return pnet;
}

//Mise à jour des tares
function MajPnet(){
	
	var nbemb = document.getElementById('nbemb').value;
	var tcont = document.getElementById('tcont').value;
	var form = $('form:visible').attr('id');
	
	if(!(isInt(tcont))){		
		document.getElementById('tcont').value = 0;
	}
	if(isInt(nbemb)){	
		if(form == "control-cajou"){	
			var typetare = document.getElementById('marql').value;
			
			if(tcont >= 3000){				
				document.getElementById('thab').value = 120;
			}
			else{				
				document.getElementById('thab').value = 60;
			}
		}
		else{
			var typetare = document.getElementById('typtare').value;
		}

		$.ajax({
		
		url : './models/Control_control_getTypetareValue.php',
		type : 'POST',
		data : 'typetare='+typetare,
		dataType : 'json',
		success : function(data){
			
			if(data[0]==1)
			{
				document.getElementById('temb').value = (nbemb*data[1]);
				document.getElementById('pnet').value = CalculPnet(form);
			}
			else{

				document.getElementById('temb').value = 0;
				document.getElementById('pnet').value = CalculPnet(form);
			}
		}
		});

	}
	else if(!(isInt(nbemb)) || nbemb==""){		
		document.getElementById('nbemb').value = "";
		document.getElementById('temb').value = 0;
		document.getElementById('pnet').value = CalculPnet(form);		
	}	
	document.getElementById('pnet').value = CalculPnet(form);
}

//Changement d'état lors de la modification d'un ticket
function updateTicket(){	
	if(document.getElementById('update-ticket').value == 0){		
		document.getElementById('update-ticket').value = 1;
	}
}

//Apparition du loader
function showLoader(){
	
	var loadstat = $('.loader').css('display') ;	
	if(loadstat == 'none'){		
		$('.loader').fadeIn(0);
	}
}
//Disparition du loader
function hideLoader(){
	
	var loadstat = $('.loader').css('display') ;	
	if(loadstat == 'block'){		
		$('.loader').fadeOut(500);
	}
}

function hideWidget(){
	
	var hideWB = setTimeout(function(){
		document.getElementById("waitingBundle").style.width = "0px";
	}, 50);
	var hideWS = setTimeout(function(){
		document.getElementById("waitingSlip").style.width = "0px";
	}, 200);
	var hideBB = setTimeout(function(){
		document.getElementById("blockedBundle").style.width = "0px";
	}, 350);
}

//notification
function notification(text1,text2,classtoadd){
	
	$('#message1').text(text1);
	$('#message2').text(text2);	
	
	var tab = ['alert-warning','alert-success','alert-danger','alert-info'];	
	for(var i = 0; i < 4; i++){
		
		if(tab[i] == classtoadd){			
			$('#notification').addClass(classtoadd);
		}
		else{			
			$('#notification').removeClass(tab[i]);
		}	
	}
	$('#notification').delay(800).slideDown(300,'linear').delay(3500).slideUp(300,'linear');
}

//Début gestion des onglets
$('#control-button').click(function(){
	
	$('#control').fadeOut(0) ;
	document.getElementById("waitingBundle").style.width = "400px";
	
	$('#archive-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').removeClass('active');
	$('#control-button').parent('li').addClass('active');
	
	$('#ARCHIVE').fadeOut(0);
	$('#PROFIL').fadeOut(0);
	$('#CONTROL').fadeIn(400,'swing');
});

$('#archive-button').click(function(){
	
	hideWidget();
	
	$('#control-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').removeClass('active');
	$('#archive-button').parent('li').addClass('active');
	
	$('#CONTROL').fadeOut(0);
	$('#PROFIL').fadeOut(0);
	$('#ARCHIVE').fadeIn(400,'swing');
});

$('#profil-button').click(function(){
	
	hideWidget();
	
	$('#control-button').parent('li').removeClass('active');
	$('#archive-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').addClass('active');
	
	$('#CONTROL').fadeOut(0);
	$('#ARCHIVE').fadeOut(0);
	$('#PROFIL').fadeIn(400,'swing');
});
//Fin gestion des onglets


//Récupération des données d'une liasse pour traitement au contrôle
$('#wbundle').on('click','.line', function(){
	
	var numpk = encodeURIComponent($(this).attr('id'));
	showLoader();
	
	$.ajax({
		
		url : './models/Control_control_getBundle.php',
		type : 'POST',
		data : 'numpk='+numpk,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 0){
				hideLoader();			
				notification("La liasse "+numpk+" n'est plus disponible.","","alert-danger");
			}
			else if(data[0] == 1){
				
				var stade = data[(data.length - 4 )],
					contr = data[(data.length - 3 )],
					gap = data[(data.length - 2 )],
					weight = data[(data.length - 1 )]
				;				
				$('#weight').text('Poids net : '+new Intl.NumberFormat("fr-FR").format(weight)+' Kg');
				$('#weight2').val(weight);
				
				if(stade > 2){					
					$('.edit-certif').attr('href', 'models/GenerateCertif_model.php?numpk='+numpk+'&cont='+contr);
					$('.edit-certif').css('display', 'block');
				}
				else{					
					$('.edit-certif').attr('href',"#");
					$('.edit-certif').css('display', 'none');
				}
				
				if(stade == 3){					
					$('.warning-printing').text('* Attention vous êtes priés de bien vouloir imprimer le certificat provisoire à joindre à la liasse physique avant de valider !');
				}
				else if(gap == 1){
					$('.warning-printing').text('* Attention vous êtes au dernier niveau de contrôle, le certificat définitif doit être imprimer après validation !');
				}
				else{
					$('.warning-printing').text('');
				}
				
				if(data[1] == 1){
					
					$('#control').css('display','none') ;
					$('#control-coton').css('display', 'none') ;
					$('#control-cajou').css('display','block') ;
					
					$('#numpklist').text(data[12]) ;
					$('#numticket').text('['+data[15]+' ticket(s)]') ;
					$('#recB').attr('value', data[3]) ;
					$('#campB').attr('value', data[4]) ;
					$('#prodB').attr('value', data[5]) ;
					$('#dateB').attr('value', data[6]) ;
					
					var postc20 = (data[15] * 7) + 16,
						postc40 = postc20 + 1,
						sep = ''
					;					
					if(data[postc20] == 0){						
						var nbtc20 = '' ;						
					}
					else{						
						var nbtc20 = data[postc20]+'x20' ;						
					}
					
					if(data[postc40] == 0){						
						var nbtc40 = '' ;
					}
					else{						
						var nbtc40 = data[postc40]+'x40' ;
					}
					
					if(data[postc20] != 0 && data[postc40] != 0){						
						sep = ' ; ';
					}
					
					$('#typcB').attr('value', nbtc20+sep+nbtc40) ;
					$('#transB').attr('value', data[7]) ;
					$('#expB').attr('value', data[8]) ;
					$('#cliB').attr('value', data[9]) ;
					$('#pklistB').attr('value', data[12]) ;
					$('#destB').attr('value', data[10]) ;
					$('#navB').attr('value', data[11]) ;
					$('#otB').attr('value', data[14]) ;
					
					$('#ticket-cajou tr:gt(0)').remove();
					
					var j = 0,
						trbgcol = "",
						tcheck = 0
					;					
					for(var i = 0; i < data[15]; i++){
						
						if(data[j+21] > 0){
							trbgcol = '#00d573';
							tcheck = 1;
						}
						else{
							trbgcol = '#ffffff';
							tcheck = 0;
						}
						
						$('#ticket-cajou > tbody:last').append('<tr class="ligne'+i+'" style="background-color:'+trbgcol+'"><td><input type="hidden" style="width:0px" id="check-tckt-caj'+i+'" value="'+tcheck+'" /><input style="text-align:center" type="text" class="form-control" placeholder="N° Ticket" value="'+data[j+16]+'" disabled="disabled"></td><td><input type="text" style="text-align:center" class="form-control" placeholder="Date" value="'+data[j+18]+'" disabled="disabled"></td><td><input type="text" style="text-align:center" class="form-control" placeholder="N° Conteneur" value="'+data[j+17]+'" disabled="disabled"></td><td><input type="text" style="text-align:center" class="form-control"  placeholder="N° Plomb" value="'+data[j+19]+'" disabled="disabled"></td><td><input type="text" style="text-align:center" class="form-control"  placeholder="Poids net" value="'+new Intl.NumberFormat("fr-FR").format(data[j+20])+'" disabled="disabled"></td><td style="font-size:16px;vertical-align: middle"><button id="'+data[j+22]+'" name="'+i+'" type="button" style="width:100%" class="btn btn-block btn-default pull-left tckt-control"><i class="far fa-eye"></i>&nbsp;&nbsp;contr&ocirc;ler</button></td></tr>');
						j += 7 ;
					}					
					$('#head-color').removeClass('box-info').addClass('box-danger') ;				
					$('#control-cajou').css('display','block') ;
				}
				else if(data[1] == 2){
					
					$('#control').css('display','none') ;
					$('#control-cajou').css('display','none') ;
					$('#control-coton').css('display','block') ;
					
					$('#numpklist').text(data[16]) ;
					$('#numticket').text('['+data[18]+' ticket(s)]') ;					
					$('#recA').attr('value', data[3]) ;
					$('#campA').attr('value', data[4]) ;
					$('#prodA').attr('value', data[5]) ;
					$('#rapA').attr('value', data[17]) ;
					$('#rapA1').attr('value', data[17]) ;
					
					var postc20 = (data[18] * 7) + 19,
						postc40 = postc20 + 1,
						sep = ''
					;					
					if(data[postc20] == 0){						
						var nbtc20 = '' ;						
					}
					else{
						var nbtc20 = data[postc20]+'x20' ;						
					}
					
					if(data[postc40] == 0){
						var nbtc40 = '' ;						
					}
					else{						
						var nbtc40 = data[postc40]+'x40' ;
					}
					
					if(data[postc20] != 0 && data[postc40] != 0){						
						sep = ' ; ';
					}
					
					$('#typcA').attr('value', nbtc20+sep+nbtc40) ;
					$('#transA').attr('value', data[7]) ;
					$('#egrA').attr('value', data[8]) ;
					$('#expA').attr('value', data[12]) ;
					$('#instfourA').attr('value', data[10]) ;
					$('#cliA').attr('value', data[13]) ;
					$('#instcliA').attr('value', data[9]) ;
					$('#destA').attr('value', data[14]) ;
					$('#navA').attr('value', data[15]) ;
					$('#dossA').attr('value', data[11]) ;
					
					$('#ticket-coton tr:gt(0)').remove();
					
					var j = 0,
						trbgcol = "",
						tcheck = 0
					;					
					for(var i = 0; i < data[18]; i++){
						
						if(data[j+24] > 0){
							trbgcol = '#00d573';
							tcheck = 1;
						}
						else{
							trbgcol = '#ffffff';
							tcheck = 0;
						}
						
						$('#ticket-coton > tbody:last').append('<tr class="ligne'+i+'" style="background-color:'+trbgcol+'"><td><input type="hidden" style="width:0px" id="check-tckt-cot'+i+'" value="'+tcheck+'" /><input style="text-align:center" type="text" class="form-control" placeholder="N° Ticket" value="'+data[j+19]+'" disabled="disabled"></td><td><input type="text" style="text-align:center" class="form-control" placeholder="Date" value="'+data[j+21]+'" disabled="disabled" required></td><td><input type="text" style="text-align:center" class="form-control" placeholder="N° Conteneur" value="'+data[j+20]+'" disabled="disabled"></td><td><input type="text" style="text-align:center" class="form-control" placeholder="N° Plomb" value="'+data[j+22]+'" disabled="disabled"></td><td><input type="text" style="text-align:center" class="form-control"  placeholder="Poids net" value="'+new Intl.NumberFormat("fr-FR").format(data[j+23])+'" disabled="disabled"></td><td style="font-size:16px;vertical-align: middle"><button id="'+data[j+25]+'" name="'+i+'" type="button" style="width:width:100%" class="btn btn-block btn-default pull-left tckt-control"><i class="far fa-eye"></i>&nbsp;&nbsp;contr&ocirc;ler</button></td></tr>');
						j += 7 ;
						
						$('#head-color').removeClass('box-danger').addClass('box-info') ;
						$('#control-coton').css('display','block') ;
					}
				}
			}
			
			$('#archive-button').parent('li').removeClass('active');
			$('#profil-button').parent('li').removeClass('active');
			$('#control-button').parent('li').addClass('active');
			
			$('#ARCHIVE').fadeOut(0);
			$('#PROFIL').fadeOut(0);
			$('#CONTROL').fadeIn(400,'swing');

			hideWidget();
			$('#control').fadeIn(400,'swing');			
			hideLoader();
		}
	});
});

//Affichage du détail des tickets de la liasse pour contrôle
$(".details").on('click','.tckt-control', function(){
	
	var form = $('form:visible').attr('id');
	
	if(form == 'control-cajou'){
		var num = 'check-tckt-caj'+$(this).attr('name') ;
	}
	else{
		var num = 'check-tckt-cot'+$(this).attr('name') ;
	}
	document.getElementById(num).value = 1 ;	
	var numtckt = $(this).attr('id') ;	
	showLoader();
	
	$.ajax({
		
		url : './models/Control_control_getTicket.php',
		type : 'POST',
		data : 'numtckt='+numtckt,
		dataType : 'json',
		success : function(data){
			
			$('#ticket-title').text(data[0]);
			
			if(form == 'control-cajou'){
				
				$('#marq').attr('disabled', true);
				$('#marque-coton label').text('Type Tare'); 
				$('#hab-cajou').css('display','block');
				$('#hab-cajou label').text('Tare habillage');
				$('#typtare').css('display','none');
				$('#marq').css('display','none');
				$('#marql').css('display','block');
				$('#thab').css('display','block');
				
				if(data[9] < 3000){					
					$('#thab').val(60);
				}
				else{					
					$('#thab').val(120);
				}				
				$('#temb').val(data[10]);
			}
			else{
				$('#marque-coton label').text('Marque'); 
				$('#marque-coton').css('display','block');
				$('#marq').attr('disabled', false);
				$('#thab').css('display','none');
				$('#hab-cajou label').text('Type Tare');
				$('#marq').css('display','block');
				$('#marql').css('display','none');
				$('#typtare').css('display','block');

				$('#temb').val(data[10]);
				
				if(data[4] == 0){
				
					var j = 1,
						fin = (data[13] * 2) + 14,
						option = '<option selected disabled>------------ Marque ------------</option>'
					;					
					for(var i = 0; i < data[fin]; i++){						
						option += '<option value="'+data[(fin+j)]+'">'+data[(fin+(j+1))]+'</option>';
						j += 2;
					}					
					$('#marq').html(option);
				}
				else{
					
					var j = 1,
						fin = (data[13] * 2) + 14,
						option = '<option selected disabled>------------ Marque ------------</option>'
					;					
					for(var i = 0; i < data[fin]; i++){
						
						if(data[4] == data[(fin+j)]){							
							option += '<option selected value="'+data[(fin+j)]+'">'+data[(fin+(j+1))]+'</option>';
						}
						else{							
							option += '<option value="'+data[(fin+j)]+'">'+data[(fin+(j+1))]+'</option>';
						}						
						j += 2;
					}	
					$('#marq').html(option);
				}
			}			
			$('#site').val(data[2]);
			$('#cam').val(data[1]);
			$('#nbemb').val(data[5]);
			$('#pes1').val(data[6]);
			$('#pes2').val(data[7]);
			$('#tcont').val(data[9]);
			$('#pnet').val(data[11]);
			
			if(data[3] == 0){
				
				var j = 1,
					option = '<option selected disabled>----------- Provenance -----------</option>'
				;				
				for(var i = 0; i < data[13]; i++){					
					option += '<option value="'+data[13+j]+'">'+data[13+(j+1)]+'</option>';
					j += 2;
				}	
				$('#prov').html(option);
			}
			else{
				
				var j = 1,
					option = '<option selected disabled>----------- Provenance -----------</option>'
				;				
				for(var i = 0; i < data[13]; i++){
					
					if(data[3] == data[13+j]){						
						option += '<option selected value="'+data[13+j]+'">'+data[13+(j+1)]+'</option>';
					}
					else{						
						option += '<option value="'+data[13+j]+'">'+data[13+(j+1)]+'</option>';
					}
					j += 2;
				}	
				$('#prov').html(option);
			}
			
			if(data[12] == 0){
				
				var j = 1,
					option = '<option selected disabled>------------ Inspecteur ------------</option>',
					fin_marq = (data[13] * 2) + 14,
					fin_insp = (data[fin_marq] * 2) + (fin_marq + 1)
				;				
				for(var i = 0; i < data[fin_insp]; i++){					
					option += '<option value="'+data[fin_insp+j]+'">'+data[fin_insp+(j+1)]+'</option>';
					j += 2;
				}	
				$('#insp').html(option);
			}
			else{
				
				var j = 1,
					option = '<option selected disabled>------------ Inspecteur ------------</option>',
					fin_marq = (data[13] * 2) + 14,
					fin_insp = (data[fin_marq] * 2) + (fin_marq + 1)
				;				
				for(var i = 0; i < data[fin_insp]; i++){
					
					if(data[12] == data[fin_insp+j]){						
						option += '<option selected value="'+data[fin_insp+j]+'">'+data[fin_insp+(j+1)]+'</option>';
					}
					else{						
						option += '<option value="'+data[fin_insp+j]+'">'+data[fin_insp+(j+1)]+'</option>';
					}					
					j += 2;
				}	
				$('#insp').html(option);
			}

			var emb = (data[fin_insp]*2)+(fin_insp + 1);
			

				var j = 1,
					option = '<option selected disabled>------------ Type tare ------------</option>',

					fin_tare = emb+1;	

				for(var i = 0; i < data[fin_tare]; i++){
					
					if(data[emb] == data[fin_tare+j]){						
						option += '<option selected value="'+data[fin_tare+j]+'">'+data[fin_tare+(j+1)]+' Kg</option>';
					}
					else{						
						option += '<option value="'+data[fin_tare+j]+'">'+data[fin_tare+(j+1)]+' Kg</option>';
					}					
					j += 2;
				}
				if(form == 'control-cajou'){
					$('#marql').html(option);
				}
				else{
					$('#typtare').html(option);
				}

			$('#id-ticket').attr('value',numtckt) ;
			$('#update-ticket').attr('value',0) ;
			$('input[name=rad][value=0]').prop( "checked", true );
			$('#text-area').val('');
			$('#text-area').slideUp(100,'linear');
			$('#text-area').prop('disabled', true);
			
			hideLoader();
			$('#modal-check-ticket').modal('show');			
		}
	});
});

//Validation d'un ticket au controle
$("#form-check-ticket").submit(function(event){
	
	event.preventDefault();
	var updateticket = $('#update-ticket').val(),
		data = 'idticket='+$('#id-ticket').val()+'&updatetckt='+updateticket
	;	
	if(updateticket == 1){
		
		var form = $('form:visible').attr('id');
		document.getElementById('temb').disabled = false;
		document.getElementById('pnet').disabled = false;
		
		if(form == 'control-cajou'){			
			document.getElementById('thab').disabled = false;
			data += '&prod=1&thab='+document.getElementById('thab').value+'&typtare='+document.getElementById('marql').value;
			document.getElementById('thab').disabled = true;
		}
		else{			
			data += '&prod=2&marq='+document.getElementById('marq').value+'&typtare='+document.getElementById('typtare').value;
		}
		data += '&cam='+document.getElementById('cam').value+'&insp='+document.getElementById('insp').value+'&nbemb='+document.getElementById('nbemb').value+'&temb='+document.getElementById('temb').value+'&tcont='+document.getElementById('tcont').value+'&pnet='+document.getElementById('pnet').value+'&prov='+document.getElementById('prov').value ;
		
		document.getElementById('temb').disabled = true;
		document.getElementById('pnet').disabled = true;
	}
	
	var error = $('input[name=rad]:checked').val();
	data += '&error='+error ;	
	if(error == 1){		
		data += '&text='+document.getElementById('text-area').value;
	}

	showLoader();
	
	$.ajax({
		url : './models/Control_control_updateTicket.php',
		type : 'POST',
		data : data,
		dataType : 'json',
		success : function(data){
			
			var sep = '';
			
			if(data[0] == 0){				
				var nbtc20 = '' ;						
			}
			else{				
				var nbtc20 = data[0]+'x20' ;						
			}
			
			if(data[1] == 0){				
				var nbtc40 = '' ;
			}
			else{				
				var nbtc40 = data[1]+'x40' ;
			}
			
			if(data[0] != 0 && data[1] != 0){				
				sep = ' ; ';
			}
			
			if((form == 'control-cajou') && (data[0] != 0 || data[1] != 0) ){				
				document.getElementById('typcB').value = nbtc20+sep+nbtc40 ;
			}
			else if((form != 'control-cajou') && (data[0] != 0 || data[1] != 0) ){				
				document.getElementById('typcA').value = nbtc20+sep+nbtc40 ;
			}
			
			if((data[2] != $('#weight2').val()) && (data[2] != 0) ){				
				$('#weight').text('Poids Net : '+new Intl.NumberFormat("fr-FR").format(data[2])+' Kg');
				$('#weight2').val(data[2]);
				$('.warning-printing').text('* Attention le poids net total a été modifié, nous vous prions de bien vouloir vérifier les modifications apportées !');
			}
			
			if(data[3] == 1){
				$('#'+(document.getElementById('id-ticket').value)).closest("tr").css("background-color","#f55c49");
			}
			else if(data[3] == 0){
				$('#'+(document.getElementById('id-ticket').value)).closest("tr").css("background-color","#00d573");
			}			
			hideLoader();
		}			
	});
	$('#modal-check-ticket').modal('hide');
});

//Validation d'une liasse traitée au controle
$(".control-form").submit(function(event){
	
	event.preventDefault();
	var formid = $(this).attr('id'),
		table = "",
		data = 'numpklist='+encodeURIComponent($('#numpklist').text())
	;	
	if(formid == 'control-coton'){		
		if(document.getElementById('rapA').value != document.getElementById('rapA1').value){		
			data += '&rapemp='+document.getElementById('rapA').value ;
		}
		var numticket = $('#ticket-coton tr').length - 1,
			tableau = '#ticket-coton',
			prod = 'cot';
	}
	else{		
		var numticket = $('#ticket-cajou tr').length - 1 ,
			tableau = '#ticket-cajou',
			prod = 'caj';
	}
	
	for(var i = 0 ; i < numticket ; i++){		
		var statut = $(tableau+' input[id=check-tckt-'+prod+i+']').val() ;		
		if((typeof statut == 'undefined') || (statut == 0)){			
			table += (i+1)+" | " ;
		}
	}
	
	if(table !== ""){		
		notification("Les tickets suivants n'ont pas été traités : "+table,"","alert-warning");
	}
	else{
		
		showLoader();
		$('#rapA').attr('value', '') ;
		$('#rapA1').attr('value', '') ;
		
		$.ajax({
			url : './models/Control_control_updateBundle.php',
			type : 'POST',
			data : data,
			dataType : 'json',
			success : function(data){
				
				$('#control').slideUp(1200);
				
				if(data[0] == 'rejet'){
					notification("Le packing list "+$('#numpklist').text()+" a été rejeté par l'administrateur.","La liasse a été archivée avec succès.","alert-danger");
				}
				else{
					
					if(data[0] == 0){					
						if(data[1] == 0){						
							if(data[2] == 0){							
								if(data[3] == 0){								
									notification("La liasse traitée a été validée avec succès.","Le bordereau a été transmis à : "+data[4],"alert-success");
									
									var onlyone = 1;
									//chargement des archives
									$.ajax({
							
										url: './models/User_archive_getBundle.php',
										type: 'POST',
										data: 'Onlyone='+onlyone,
										dataType: 'json',
										success : function(data){
											
											var i = 0,
												j = data[0] * 8
											;
											
											while(i < j){
												
												if(data[i+8] == 1){
													sup = '<sup>er</sup>';
												}
												else{
													sup = '<sup>e</sup>';
												}
												
												$('#archive-table').DataTable().row.add([
													data[i+2],
													data[i+3],
													new Intl.NumberFormat("fr-FR").format(data[i+4]),
													data[i+8]+sup+' Contrôle',
													data[i+5],
													data[i+7],
													'<a href="#" id="'+data[i+1]+'" name="'+data[i+2]+'" class="fa fa-search-plus fa-lg"></a>',
												]).columns.adjust().draw(false);
												i += 8 ;
											}
										}			
									});
								}
								else if(data[3] == 1){								
									notification("La liasse traitée a été validée avec succès.","Le bordereau n'a pas pu être transmis.","alert-warning");
								}
							}
							else if(data[2] == 1){							
								notification("La liasse traitée a été validée avec succès.","Elle a été intégrée au bordereau en cours.","alert-success");
							}
						}
						else if(data[1] == 1){						
							notification("La liasse traitée a été validée avec succès.","Le bordereau N° "+data[2]+" a été créée.","alert-success");
						}					
					}
					else if(data[0] == 1){					
						notification("La liasse non conforme a été transmise à l'administrateur.","La gestion de(s) non conformité(s) est en cours...","alert-danger");
					}
					else if(data[0] == 2){					
						notification("La liasse a été déjà traitée au Contrôle.","","alert-warning");
					}				
					
					$.ajax({
						
						url: './models/User_widget_getWaitingBundle.php',
						type: 'POST',
						data: '',
						dataType: 'json',
						success : function(data){
							
							var total = 0,
								rows = $('#wbundle tr').length
							;						
							if(rows >= 1){
							
								$('#wbundle tr').remove();
								
								if(rows < data[0]){
									
									var pluriel = "";
									if(data[0] > 1){
										pluriel = "s";
									}								
									notification("Vous avez reçu "+data[0]+" nouvelle"+pluriel+" liasse"+pluriel+" à traiter.","","alert-info");
								}
							}
					
							if(data[0] > 0){
								
								var line = 0,
									i = 0
								;							
								while(line < data[0]){
									
									$('#wbundle > tbody:last').append('<tr><td><button class="btn btn-block btn-default line" style="text-align:left;width:360px;font-size: 12px;" id="'+data[(i+1)]+'">'+data[(i+1)]+'&nbsp;['+data[i+2]+' ticket(s)]</button></td></tr>');
									total += 1 ;					
									i += 2 ;
									
									line = $('#wbundle tr').length ;
								}
							}
							else{							
								$('#wbundle > tbody:last').append('<tr><td><button class="btn btn-block btn-default" style="text-align:left;width:360px;font-size: 12px;" >Aucune liasse disponible</button></td></tr>');
							}
							$("#numwb").text(total) ;
						}
					});
					
					$.ajax({
						
						url: './models/User_widget_getWaitingSlip.php',
						type: 'POST',
						data: '',
						dataType: 'json',
						success : function(data){
							
							var total = 0,
								rows = $('#wslip tr').length
							;
							
							if(rows >= 1){							
								$('#wslip tr').remove();
							}
							
							if(data[0] > 0){
								
								$('.send-slip').css('display', 'block');
								$("#numbord").text('');
								$("#numbord").html('<i class="far fa-folder-open" ></i>&nbsp;&nbsp;BORDEREAU OUVERT N° '+data[1]) ;;
								
								var line = 0,
									i = 0
								;							
								while(line < data[2]){
									
									$('#wslip > tbody:last').append('<tr><td><button class="btn btn-block btn-default" style="text-align:left;width:360px;font-size: 12px;">'+data[(i+3)]+'&nbsp;['+data[i+4]+' ticket(s)]</button></td></tr>');
									total += 1 ;					
									i += 2 ;								
									line = $('#wslip tr').length ;
								}
							}
							else{
								
								$('.send-slip').css('display', 'none');
								$("#numbord").text('');
								$("#numbord").html('<i class="far fa-folder" ></i>&nbsp;&nbsp;BORDEREAU FERME') ;
								$('#wslip > tbody:last').html('<tr><td><button class="btn btn-block btn-default" style="text-align:left;width:360px;font-size: 12px;">Aucune liasse disponible</button></td></tr>');
							}
							$("#numws").text(total) ;
						}
					});
					
					$.ajax({
						
						url: './models/User_widget_getBlockedBundle.php',
						type: 'POST',
						data: '',
						dataType: 'json',
						success : function(data){
							
							var total = 0,
								rows = $('#bbundle tr').length
							;						
							if(rows => 1){						
								$('#bbundle tr').remove();				
							}
					
							if(data[0] > 0){
								
								var line = 0,
									i = 0
								;							
								while(line < data[0]){
									
									$('#bbundle > tbody:last').append('<tr><td><button class="btn btn-block btn-default disabled" style="text-align:left;width:360px;font-size: 12px;" id="'+data[(i+1)]+'">'+data[(i+1)]+'&nbsp;['+data[i+2]+' NC]</button></td></tr>');
									total += 1 ;					
									i += 2 ;								
									line = $('#bbundle tr').length ;
								}
							}
							else{							
								$('#bbundle > tbody:last').append('<tr><td><button class="btn btn-block btn-default disabled" style="text-align:left;width:360px;font-size: 12px;" >Aucune liasse bloquée</button></td></tr>');
							}
							$("#numbb").text(total);
						}
					});

					if(data[0] == 3){
						var numpk = encodeURIComponent(data[1]);
						$('#title-editcertif').text(data[3]);
						$('#lien-editcertif').attr('href', 'models/GenerateCertif_model.php?numpk='+numpk+'&cont='+data[2]);
						$('#modal-edit-certif').modal('show');
						
						var onlyone = 1;
						//chargement des archives
						$.ajax({
				
							url: './models/Control_archive_getCertificat.php',
							type: 'POST',
							data: 'one='+onlyone+'&numpk='+data[1],
							dataType: 'json',
							success : function(data){
								
								var i = 0,
									classe = '',
									numpk = encodeURIComponent(data[i+8]),
									j = data[0] * 9
								;		
								while(i < j){
									
									if(data[i+7] == 0){
										classe ='<a href="#" id="'+data[i+1]+'" name="'+data[i+2]+'" class="far fa-clone fa-lg"></a>';
									}
									if(data[i+7] == 2){
										classe = '<a href="models/GenerateCertif_model.php?numpk='+numpk+'&cont='+data[i+9]+'" id="'+data[i+1]+'" target="_blank" class="fa fa-print fa-lg"></a>';
									}
									
									$('#archcertif-table').DataTable().row.add([
										data[i+2],
										data[i+3],
										new Intl.NumberFormat("fr-FR").format(data[i+4]),
										data[i+5],
										data[i+6],
										'<a href="#" id="'+data[i+1]+'" name="'+data[i+2]+'" class="fa fa-search-plus fa-lg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="'+data[i+1]+'" name="'+data[i+2]+'" class="far fa-edit fa-lg"></a>',
										classe
									]).columns.adjust().draw(false);
									i += 9;
								}
							}			
						});						
					}
				}

				$( document ).ajaxStop(function(){
					hideLoader()
				});
			}		
		});
	}
});

//Imprimer le certificat définitif
$('#lien-editcertif').click(function(){	
	$('#modal-edit-certif').modal('hide');
});

//Annuler le traitement d'une liasse
$('.cancel-bundle').click(function(){	
	$('#control').slideUp(800, 'swing');
});

//Transmission manuelle du bordereau par l'agent du Control
$('#waitingSlip').on('click','.send-slip', function(){
	
	hideWidget();
	showLoader();
	
	$.ajax({
		url : './models/User_manual_dispatchBord.php',
		type : 'POST',
		data : '',
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 0){
				
				$('#wslip tr').remove();			
				$('.send-slip').css('display','none');			
			
				$("#numbord").text('');
				$("#numbord").html('<i class="far fa-folder" ></i>&nbsp;&nbsp;BORDEREAU FERME') ;
				$('#wslip > tbody:last').append('<tr><td><button class="btn btn-block btn-default" style="text-align:left;width:360px;font-size: 12px;">Aucune liasse disponible</button></td></tr>');
				
				$("#numws").text(0) ;
				
				notification("Le bordereau en cours a été transmis à : "+data[1],"","alert-success");
				
				var onlyone = 1
				//chargement des archives
				$.ajax({
		
					url: './models/User_archive_getBundle.php',
					type: 'POST',
					data: 'Onlyone='+onlyone,
					dataType: 'json',
					success : function(data){
						
						var i = 0,
							j = data[0] * 8
						;					
						while(i < j){
							
							if(data[i+8] == 1){
								sup = '<sup>er</sup>';
							}
							else{
								sup = '<sup>e</sup>';
							}
							
							$('#archive-table').DataTable().row.add([
								data[i+2],
								data[i+3],
								new Intl.NumberFormat("fr-FR").format(data[i+4]),
								data[i+8]+sup+' Contrôle',
								data[i+5],
								data[i+7],
								'<a href="#" id="'+data[i+1]+'" name="'+data[i+2]+'" class="fa fa-search-plus fa-lg"></a>',
							]).columns.adjust().draw(false);
							i += 8 ;
						}
					}			
				});
			}			
			$( document ).ajaxStop(function(){
				hideLoader()
			});
		}
	});	
}); 

//Affichage des informations de la liasse dans les archives
$('#ARCHIVE').on('click','.fa-search-plus', function(){
	
	var idcertif = $(this).attr('id'),
		title = $(this).attr('name')
	;	
	$.ajax({
		
		url : './models/User_archive_getInfo.php',
		type : 'POST',
		data : 'idcertif='+idcertif,
		dataType : 'json',
		success : function(data){
			
			$('#info-title').text("");
			$('#info-title').text(title);			
			$('#information tr:gt(0)').remove();
			
			var j = (data[0] - 1) * 7,
				i = 0
			;			
			while(i <= j){				
				$('#information > tbody:last').append('<tr><td>'+data[i+1]+'</td><td>'+data[i+2]+'</td><td style="text-align: center;">'+data[i+3]+'</td><td style="text-align: center;">'+data[i+4]+'</td><td style="text-align: center;">'+data[i+5]+'</td><td style="text-align: center;">'+data[i+6]+'</td><td style="text-align: center;">'+new Intl.NumberFormat("fr-FR").format(data[i+7])+'</td></tr>');
				i += 7 ;
			}
			$('#modal-show-archive').modal('show');
		}
	});
});

//Demande de modification d'un certificat déjà édité
$('#archcertif-table').on('click','.fa-edit', function(){
	
	$('#redit-idcertif').val($(this).attr('id'));
	$('#redit-numcertif').text($(this).attr('name'));
	$('#numline-reditcertif').val($(this).closest('tr').index());
	
	$('#modal-editCertifConfirmation').modal('show');	
});
$('#validate-editCertifConfirmation').on('click', function(){
	
	$('#modal-editCertifConfirmation').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Control_archive_editCertif.php',
		type : 'POST',
		data : 'idcertif='+$('#redit-idcertif').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = '',
				numline = $('#numline-reditcertif').val()
			;
			if(data[0] == 1){				
				
				msg1 = "La demande de modification du certificat "+$('#redit-numcertif').val()+" a été transmise à l'administrateur avec succès.";
				type = "alert-success";			
			}
			else{
				
				msg1 = "La demande de modification du certificat "+$('#redit-numcertif').val()+" est déjà en cours de traitement par l'administrateur.";
				type = "alert-success";
			}
			$('#archcertif-table').DataTable().row(':eq('+numline+')').remove().draw(false);
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});

/*
//Demande de réedition d'un certificat déjà édité
$('#archcertif-table').on('click','.fa-clone', function(){
	
	$('#reedit-idcertif').val($(this).attr('id'));
	$('#reedit-numcertif').text($(this).attr('name'));
	$('#numline-reeditcertif').val($(this).closest('tr').index());
	
	$('#modal-reeditCertifConfirmation').modal('show');	
});
$('#validate-reeditCertifConfirmation').on('click', function(){
	
	$('#modal-reeditCertifConfirmation').modal('hide');
	showLoader();
	
	$.ajax({
		
		url : './models/Control_archive_reeditCertif.php',
		type : 'POST',
		data : 'idcertif='+$('#reedit-idcertif').val(),
		dataType : 'json',
		success : function(data){
			
			var msg1 = '',
				msg2 = '',
				type = '',
				numline = $('#numline-reeditcertif').val()
			;
			if(data[0] == 1){				
				
				msg1 = "La demande de réedition du certificat "+$('#reedit-numcertif').val()+" a été transmise à l'administrateur avec succès.";
				type = "alert-success";			
			}
			else{
				
				msg1 = "La demande de réedition du certificat "+$('#reedit-numcertif').val()+" est déjà en cours de traitement par l'administrateur.";
				type = "alert-success";
			}
			$('#archcertif-table > tbody').find('tr:nth-child('+numline+') > td:nth-child(7)').text('');
			$.when($( document ).ajaxStop(function(){hideLoader()})).done(notification(msg1,msg2,type));
		}
	});
});
*/

//Verrouillage de l'écran
$('#locked').on('click', function(){	
	$('.lockscreen').slideDown(1000,'swing');
});

//Déverrouillage de l'espace de travail
$('#locked-form').on('submit', function(event){
	
	event.preventDefault();
	var pass = $('input[name=pwdlocked]').val();
	
	$.ajax({
		
		url : './models/User_lockSession.php',
		type : 'POST',
		data : 'pass='+pass,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 0){
				$('input[name=pwdlocked]').css('border', '1px solid red');
			}
			else{
				$('input[name=pwdlocked]').css('border', '0px solid red');
				$('.lockscreen').slideUp(1000,'swing');
			}
			$('#pwdlocked').val('');
		}
	});
});