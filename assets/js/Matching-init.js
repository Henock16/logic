$(function(){
	
	$("#archive-table").DataTable({
		
		"autoWidth": false,
		"aoColumnDefs": [
			{ "bSortable": false,"aTargets": [5] },
		],
		"columns": [
			{ className: "dt-first" },
			{ className: "dt-body" },
			{ className: "dt-body" },
			{ className: "dt-body" },
			{ className: "dt-body" },
			{ className: "dt-body" }
		],
		"dom": "<'row'<'col-xs-4'l><'col-xs-4 text-center'B><'col-xs-4'f>>"+"<'row'<'col-xs-12'rt>>"+"<'row'<'col-xs-5'i><'col-xs-7'p>>",
		"buttons": [
			{ extend: 'copy', className: 'btn btn-default far fa-copy', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Copier</span>" },
			{ extend: 'excel', className: 'btn btn-default far fa-file-excel', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Exporter</span>" },
			{ extend: 'print', className: 'btn btn-default fa fa-print', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Imprimer</span>" },
		],
		"retrieve": true
	});
});

$(document).ready(setInterval(function(){
	//Chargement des liasses à traiter
	$.ajax({
		
		url: './models/User_widget_getWaitingBundle.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			var total = 0,
				rows = $('#wbundle tr').length
			;			
			if(rows => 1){
			
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
	//Chargement du bordereau ouvert/fermé
	$.ajax({
		
		url: './models/User_widget_getWaitingSlip.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			var total = 0,
				rows = $('#wslip tr').length
			;			
			if(rows => 1){				
				$('#wslip tr').remove();				
			}
			
			if(data[0] > 0){
				
				$('.send-slip').css('display', 'block');
				$("#numbord").html('');
				$("#numbord").html('<i class="far fa-folder-open" ></i>&nbsp;&nbsp;BORDEREAU OUVERT N° '+data[1]) ;
				
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
				$('#wslip > tbody:last').append('<tr><td><button class="btn btn-block btn-default" style="text-align:left;width:360px;font-size: 12px;">Aucune liasse disponible</button></td></tr>');
			}
			$("#numws").text(total) ;
		}
	});
	//Chargement des liasses non conformes
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
			$("#numbb").text(total) ;
		}
	});
}, 120000));

//Chargement des liasses à traiter
	$.ajax({
		
		url: './models/User_widget_getWaitingBundle.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			var total = 0,
				rows = $('#wbundle tr').length
			;			
			if(rows => 1){
			
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
	//Chargement du bordereau ouvert/fermé
	$.ajax({
		
		url: './models/User_widget_getWaitingSlip.php',
		type: 'POST',
		data: '',
		dataType: 'json',
		success : function(data){
			
			var total = 0,
				rows = $('#wslip tr').length
			;			
			if(rows => 1){				
				$('#wslip tr').remove();				
			}
			
			if(data[0] > 0){
				
				$('.send-slip').css('display', 'block');
				$("#numbord").html('');
				$("#numbord").html('<i class="far fa-folder-open" ></i>&nbsp;&nbsp;BORDEREAU OUVERT N° '+data[1]) ;
				
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
				$('#wslip > tbody:last').append('<tr><td><button class="btn btn-block btn-default" style="text-align:left;width:360px;font-size: 12px;">Aucune liasse disponible</button></td></tr>');
			}
			$("#numws").text(total) ;
		}
	});
	//Chargement des liasses non conformes
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
			$("#numbb").text(total) ;
		}
	});
	
//Chargement des archives
$.ajax({

	url: './models/User_archive_getBundle.php',
	type: 'POST',
	data: '',
	dataType: 'json',
	success : function(data){
		
		$('#archive-table').DataTable().clear().draw(false);
		
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

$( document ).ajaxStop(function(){
	$('.loader2').fadeOut(500);
});

$('.modal').on('show.bs.modal,shown.bs.modal', function () {				
	$('#notification').css('display','none')
});

//Gestion de l'affichage des listes de selection des non conformités
var SelectShow = setInterval(function(){
	
	var disp = $('#matching').css('display');
	
	if(disp == 'block'){
		
		var numrow = $('#bundle tr').length - 1;
		
		for(var i = 0; i < numrow; i++){			
			var check = $('input[name=ST'+i+']:checked').val();			
			if(check == 0){				
				$('#select'+i).fadeIn(400,'swing');
				$('#ligne'+i).css('backgroundColor', '#f55c49');
				$('#ligne'+i).css('color', '#ffffff');
			}
			else if(check == 1){				
				$('#select'+i).fadeOut(0);
				$('#ligne'+i).css('backgroundColor', '#00d573');
				$('#ligne'+i).css('color', '#ffffff');
			}			
		}
	}
}, 500);

//Rotation du logo
var AnimatedLogo = setInterval(function(){
	
	var elem = $(".cube");
    $({deg: 0}).animate({deg: 1800}, {
		
        duration: 2000,
        step: function(now){			
            elem.css({				
                transform: "rotate(" + now + "deg)"
            });
        }
    });
}, 10000);