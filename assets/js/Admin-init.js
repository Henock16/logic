$('.modal').on('show.bs.modal,shown.bs.modal', function(){				
	$('#notification').css('display','none')
});

$('.datepicker').datepicker({
	showAnim: 'slideDown',
	showWeek: true,
	firstDay: 1,
	autoclose: true,
	changeMonth: true,
	changeYear: true,
	dateFormat: 'dd/mm/yy',
	startDate: '-3d'
});

$(document).ready(function(){
	
	$(".phone").mask("99 99 99 99",{placeholder:" "});
	
	$(function(){
		
		$("#utilplate-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [5] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body-left" },
				{ className: "dt-body-left" },
				{ className: "dt-body-left" },
				{ className: "dt-body-left" },
				{ className: "dt-body" },
			],
			"dom": "<'row'<'col-xs-4'l><'col-xs-4 text-center'B><'col-xs-4'f>>"+"<'row'<'col-xs-12'rt>>"+"<'row'<'col-xs-5'i><'col-xs-7'p>>",
			"buttons": [
				{ extend: 'copy', className: 'btn btn-default far fa-copy', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Copier</span>" },
				{ extend: 'excel', className: 'btn btn-default far fa-file-excel', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Exporter</span>" },
				{ extend: 'print', className: 'btn btn-default fa fa-print', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Imprimer</span>" },
			],
			"retrieve": true
		});
		
		$("#camp-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [5] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body-left" },
				{ className: "dt-body-left" },
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
		
		$("#rec-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [5] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body-left" },
				{ className: "dt-body-left" },
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
		
		$("#expor-table").DataTable({
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
		
		$("#transit-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [2] },
			],
			"columns": [
				{ className: "dt-first" },
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
		
		$("#dest-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [3] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body-left" },
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
		
		$("#egren-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [2] },
			],
			"columns": [
				{ className: "dt-first" },
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
		
		$("#prod-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [2] },
			],
			"columns": [
				{ className: "dt-first" },
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
		
		$("#pcklist-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [5,6] },
			],
			"columns": [
				{ className: "dt-first" },
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
		
		$("#matching-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [6] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body" },
				{ className: "dt-body" },
				{ className: "dt-body" },
				{ className: "dt-body" },
				{ className: "dt-body" },
				{ className: "dt-body" },
			],
			"dom": "<'row'<'col-xs-4'l><'col-xs-4 text-center'B><'col-xs-4'f>>"+"<'row'<'col-xs-12'rt>>"+"<'row'<'col-xs-5'i><'col-xs-7'p>>",
			"buttons": [
				{ extend: 'copy', className: 'btn btn-default far fa-copy', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Copier</span>" },
				{ extend: 'excel', className: 'btn btn-default far fa-file-excel', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Exporter</span>" },
				{ extend: 'print', className: 'btn btn-default fa fa-print', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;'>Imprimer</span>" },
			],
			"retrieve": true
		});
		
		$("#match-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [6] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body-left" },
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
		
		$("#configM-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [3] },
			],
			"order": [[ 2, "asc" ]],
			"columns": [
				{ className: "dt-first" },
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
		
		$("#controle-table").DataTable({
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
				{ extend: 'excel', className: 'btn btn-default far fa-file-excel', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;font-size: 16px;'>Exporter</span>" },
				{ extend: 'print', className: 'btn btn-default fa fa-print', text: "&nbsp;&nbsp;<span style='font-family: Source Sans Pro;font-weight: normal;font-size: 16px;font-size: 16px;'>Imprimer</span>" },
			],
			"retrieve": true
		});
		
		$("#contro-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [6] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body-left" },
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
		
		$("#config-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [3] },
			],
			"order": [[ 2, "asc" ]],
			"columns": [
				{ className: "dt-first" },
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
		
		$("#incident-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [6] },
			],
			"columns": [
				{ className: "dt-first" },
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
		
		$("#user-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [6] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body-left" },
				{ className: "dt-body-left" },
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
		
		$("#archpack-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [6] },
			],
			"columns": [
				{ className: "dt-first" },
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
		$("#archcertif-table").DataTable({
			"autoWidth": false,
			"aoColumnDefs": [
				{ "bSortable": false,"aTargets": [6] },
			],
			"columns": [
				{ className: "dt-first" },
				{ className: "dt-body-left" },
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
	
	//Chargement de la liste des utilisateurs (plateforme en ligne)
	getUtilPlateforme();

	//Chargement de la liste des campagnes
	getCampagne();

	//Chargement de la liste des récoltes
	getRecolte();

	//Chargement de la liste des exportateurs
	getExportateur();

	//Chargement de la liste des transitaires
	getTransitaire();

	//Chargement de la liste des destinations
	getDestination();

	//Chargement de la liste des egreneurs
	getEgreneur();

	//Chargement de la liste des produits
	getProduit();

	//Chargement de la liste des packing list
	getPackingList();
	//Récupération des packing list toutes les 05 minutes
	var PackingListTimer = setInterval(function(){
		getPackingList();
	} , 300000);
	
	//Chargement des liasses à affecter au Matching
	getBundleMatchDispatch();
	//Récupération des liasses toutes les 05 minutes
	var BundleMatchTimer = setInterval(function(){
		getBundleMatchDispatch();
	} , 300000);

	//Chargement du suivi du matching
	getMatchWork();
	//Récupération du suivi du matching toutes les 05 minutes
	var WorkMatchTimer = setInterval(function(){
		getMatchWork();
	} , 300000);

	//Chargement de la configuration du matching
	getMatchConfig();

	//Chargement des bordereaux à affecter au controle
	getSlipContDispatch();
	//Récupération des bordereaux toutes les 05 minutes
	var SlipContTimer = setInterval(function(){
		getSlipContDispatch();
	} , 300000);

	//Chargement du suivi du contrôle
	getContWork();
	//Récupération du suivi du contrôle toutes les 05 minutes
	var WorkContTimer = setInterval(function(){
		getContWork();
	} , 300000);

	//Chargement de la configuration du controle
	getContConfig();

	//Chargement des incidents
	getIncident();
	//Récupération des incidents toutes les 05 minutes
	var incidentTimer = setInterval(function(){
		getIncident();
	} , 300000);

	//Chargement de la liste des utilisateurs
	getUser();
	
	//Chargement des packing List de l'archive	
	getPackingArchive();
	//Récupération des packing List toutes les 05 minutes
	var packingTimer = setInterval(function(){
		getPackingArchive();
	} , 300000);
	
	//Chargement des certificats de l'archive
	getCertificatArchive();
	//Récupération des certificats toutes les 05 minutes
	var certifTimer = setInterval(function(){
		getCertificatArchive();
	} , 300000);
	
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
});