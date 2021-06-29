$(function(){

	$("#pcklist-table").DataTable({

		"autoWidth": false,
		"aoColumnDefs": [
			{ "bSortable": false,"aTargets": [6] },
		],
		"order": [[ 5, "asc" ], [ 0, 'asc' ]],
		"colReorder": true,
		"columns": [
			{ className: "dt-first" },
			{ className: "dt-body" },
			{ className: "dt-body" },
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
	
	$("#archive-table").DataTable({

		"autoWidth": false,
		"aoColumnDefs": [
			{ "bSortable": false,"aTargets": [5] },
		],
		"order": [[ 0, "asc" ]],
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

$(document).ready(function(){

	//Chargement de la liste des packing list
	getPackinglist();
	var getBundle = setInterval(function(){		
		getPackinglist();
	}, 300000);
	
	//Chargement de la liste des archives
	getArchive();
	var getArchiveBundle = setInterval(function(){		
		getArchive();
	}, 600000);
	
	$( document ).ajaxStop(function(){
		$('.loader2').fadeOut(500);
	});
	
    //Fonction de gestion des chronomètres
	var gestChrono = setInterval(function chrono() {

		var oTable = $('#pcklist-table').dataTable();
		var long = oTable.fnGetData().length ;
		//alert(long) ;
		for(i = 1; i <= long; i++){
			
			//alert(statut+i+"i")
			var sec = $('#s'+i).text() ;
			var min = $('#m'+i).text() ;
			var heu = $('#h'+i).text() ;
			//alert(statut+i+" i "+sec)
		
			if(sec == 59){
				
				sec = 0+''+0 ;
				
				if(min < 9){
					
					min++ ;
					min = 0+''+(min) ;
				}
				else{
					
					min++ ;
				}
			}
			else{
				
				if(sec < 9){
					
					sec++ ;
					sec = 0+''+sec ;
				}
				else{
					
					sec++ ;
				}
			}
			
			if(min > 59){
				
				min = 0+''+0 ; 
				
				if(heu < 9){
					
					heu++ ;
					heu = 0+''+(heu) ;
				}
				else{
					
					heu++ ;
				}
			}
					
			$('#s'+i).text(sec) ; 
			$('#m'+i).text(min) ; 
			$('#h'+i).text(heu) ;
				
		}
	},1000);
    		
})

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

$('.modal').on('show.bs.modal,shown.bs.modal', function () {				
	$('#notification').css('display','none')
});