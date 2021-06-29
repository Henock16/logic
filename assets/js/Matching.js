//Vérification si nombre est entier
function isInt(n){
   return n % 1 === 0;
}

//Détermination du type de produit
function checkProd(numpklist){
	
	var bool = true;
    var i = "";
	var j = 0;
    var pos = numpklist.length - 1;
    
    while(bool){
        
        i = numpklist.charAt(pos).concat(i) ;
        
        if(isInt(i)){
			
            pos = pos - 1 ;
        }
        else{
			
            j = numpklist.charAt(pos);
            bool = false ;
        }
    }
	return j ;
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

//Fermeture du widget
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
$('#matching-button').click(function(){
	
	$('#matching').fadeOut(0) ;
	document.getElementById("waitingBundle").style.width = "400px";
	
	$('#archive-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').removeClass('active');
	$('#matching-button').parent('li').addClass('active');
	
	$('#ARCHIVE').fadeOut(0);
	$('#PROFIL').fadeOut(0);
	$('#MATCHING').fadeIn(400,'swing');
});

$('#archive-button').click(function(){
	
	hideWidget();	
	
	$('#matching').fadeIn(400,'swing') ;
	
	$('#matching-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').removeClass('active');
	$('#archive-button').parent('li').addClass('active');
	
	$('#MATCHING').fadeOut(0);
	$('#PROFIL').fadeOut(0);
	$('#ARCHIVE').fadeIn(400,'swing');
});

$('#profil-button').click(function(){
	
	hideWidget();
	
	$('#matching-button').parent('li').removeClass('active');
	$('#archive-button').parent('li').removeClass('active');
	$('#profil-button').parent('li').addClass('active');
	
	$('#MATCHING').fadeOut(0);
	$('#ARCHIVE').fadeOut(0);
	$('#PROFIL').fadeIn(400,'swing');
});
//Fin gestion des onglets

//Récupération des données d'une liasse pour traitement
$('#wbundle').on('click','.line', function(){
	
	var numpk = encodeURIComponent($(this).attr('id')) ;
	//var numpk = encodeURIComponent(numpk1);
	showLoader();
	
	$.ajax({
		
		url : './models/Matching_match_getBundle.php',
		type : 'POST',
		data : 'numpk='+numpk,
		dataType : 'json',
		success : function(data){
			
			if(data[0] == 0){				
				notification("La liasse "+numpk+" n'est plus disponible !","Veuillez contactez immédiatement l'administrateur","alert-warning");
			}
			else{
				
				$('#matching').attr('display','none') ;
				$('#bundle tr:gt(0)').remove();
				
				if(checkProd(data[0]) == 'J'){					
					$('#head-color').removeClass('box-info').addClass('box-danger') ;
				}
				else if(checkProd(data[0]) == 'T'){					
					$('#head-color').removeClass('box-danger').addClass('box-info') ;
				}
				
				$('#numpklist').text(data[0]) ;
				$('#numticket').text('['+data[1]+' ticket(s)]') ;				
				
				var pos_numerr = (data[1] * 9) + 2,
					numerr = data[pos_numerr],
					option = '<option selected disabled>-------- Anomalie --------</option>',
					p = 0
				;				
				for(var k = 0; k < numerr ; k++){
					option += '<option value="'+data[(pos_numerr + (p+1))]+'">'+data[(pos_numerr + (p+2))]+'</option>' ;
					p += 2;
				}				
				
				var j = 0 ;
				for(var i = 0; i < data[1] ; i++ ){
					$('#bundle > tbody:last').append('<tr id="ligne'+i+'" ><td>'+data[2+j]+'</td><td>'+data[2+(j+1)]+'</td><td style="text-align: center;">'+data[2+(j+2)]+'</td><td style="text-align: center;">'+data[2+(j+3)]+'</td><td style="text-align: center;">'+data[2+(j+7)]+'</td><td style="text-align: center;">'+data[2+(j+8)]+'</td><td style="text-align: center;">'+new Intl.NumberFormat("fr-FR").format(data[2+(j+4)])+'</td></tr>');
					
					if((data[2+(j+5)]) == 0){						
						var check = '' ;
					}
					else if((data[2+(j+5)]) == 1){						
						var check = 'checked="checked"' ;
					}
					
					$('#bundle > tbody:last > tr:last').append('<td><div class="radio" style="margin:0px"><label><input name="T'+i+'" id="T'+i+'" value="'+data[2+(j+6)]+'" type="text" style="display:none;width:0px;"></label><label style="color: #00A65A;"><input name="ST'+i+'" value="1" type="radio" '+check+' >M</label>&nbsp;&nbsp;<label style="color: #DD4B39;"><input name="ST'+i+'" value="0" type="radio">NC</label><label  style="padding: 0px 0px 0px 5px;display:none;" id="select'+i+'"><select class="form-control" name="select'+i+'" style="padding: 0px 0px 0px 0px;width: 145px;font-size: 11px">'+option+'</select></label></div></td>') ;
					j += 9 ;
				}
				
				$('#archive-button').parent('li').removeClass('active');
				$('#profil-button').parent('li').removeClass('active');
				$('#matching-button').parent('li').addClass('active');
				
				$('#ARCHIVE').fadeOut(0);
				$('#PROFIL').fadeOut(0);
				$('#MATCHING').fadeIn(400,'swing');
				
				hideWidget();
				
				$('#matching').fadeIn(400,'swing') ;
			}
			hideLoader();
		}
	});	
});

//Validation d'une liasse traitée au matching
$("#validate").on('click',function(){
	
	var numticket = document.getElementById("bundle").getElementsByTagName('tr').length - 1,
		table = "",
		data = ""
	;	
	for(var i = 0 ; i < numticket ; i++){
		
		var statut = $('input[name=ST'+i+']:checked').val() ;
		
		if((typeof statut == 'undefined') || (statut == 0)){
			
			var erreur = $('select[name=select'+i+']').val() ;			
			if((erreur === null) || (erreur ==="")){				
				table += (i+1)+" | " ;
			} 
		}
	}
	
	if(table !== ""){		
		notification("Les tickets suivants n'ont pas été traités : "+table,"","alert-warning");
	}
	else{
		
		showLoader();
		
		var data = 'NUMPKLIST='+encodeURIComponent($('#numpklist').text())+'&NUMTICKET='+numticket ;
		
		for(var i = 0 ; i < numticket ; i++){
			
			var stat = $('input[name=ST'+i+']:checked').val() ;
			data += '&T'+i+'='+$('#T'+i).val() ;
			data += '&ST'+i+'='+stat ;
			
			if(stat == 0){				
				var error = $('select[name=select'+i+']').val() ;
				data += '&ERR'+i+'='+error ;
			}
			else{				
				var notdefine = ''
				data += '&ERR'+i+'='+notdefine ;
			}
		}
		
		$.ajax({
			
			url : './models/Matching_match_updateBundle.php',
			type : 'POST',
			data : data,
			dataType : 'json',
			success : function(data){
				
				$('#matching').slideUp(1200);				
				
				if(data[0] == 'rejet'){
					notification("Le packing list "+$('#numpklist').text()+" a été rejeté par l'administrateur.","La liasse a été archivée avec succès.","alert-danger");
				}
				else{
					if(data[0] == 0){
						
						if(data[1] == 0){
							
							if(data[2] == 0){
								
								if(data[3] == 0){						
									notification("La liasse "+$('#numpklist').text()+" a été validée avec succès.","Le bordereau en cours a été transmis à : "+data[4],"alert-success");
									
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
												
												$('#archive-table').DataTable().row.add([
													data[i+2],
													data[i+3],
													new Intl.NumberFormat("fr-FR").format(data[i+4]),
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
									notification("La liasse "+$('#numpklist').text()+" a été validée avec succès.","Le bordereau n'a pas pu être transmis.","alert-warning");
								}
							}
							else if(data[2] == 1){							
								notification("La liasse "+$('#numpklist').text()+" a été validée avec succès.","Elle a été intégrée au bordereau en cours.","alert-success");
							}
						}
						else if(data[1] == 1){						
							notification("La liasse "+$('#numpklist').text()+" a été validée avec succès.","Le bordereau N° "+data[2]+" a été crée.","alert-success");
						}					
					}
					else if(data[0] == 1){					
						notification("La liasse "+$('#numpklist').text()+" non conforme a été transmise à l'administrateur.","La gestion des non conformités est en cours...","alert-danger");
					}
					else if(data[0] == 2){					
						notification("La liasse "+$('#numpklist').text()+" a été déjà traitée au Matching.","","alert-warning");
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
				}
				$( document ).ajaxStop(function(){
					hideLoader()
				});
			}
		});		
	}
});

//Annuler le traitement d'une liasse
$('#cancel').click(function(){
	$('#matching').slideUp(800, 'swing');
});

//Transmission manuelle du bordereau par l'agent du Matching
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
							
							$('#archive-table').DataTable().row.add([
								data[i+2],
								data[i+3],
								new Intl.NumberFormat("fr-FR").format(data[i+4]),
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

//Affichage des informations de la liasse dans le tableau d'archive
$('#archive-table').on('click','.fa-search-plus', function(){
	
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