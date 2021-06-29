<div class="row">
	<div class="modal fade" id="modal-statpcklistConfirmation" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" style="width:600px">
			<div class="modal-content" style="border-radius: 3px;">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Transmission du certificat</h4>
					<input type="hidden" id="idpcklist-updatstat" value="" />
					<input type="hidden" id="numline-pcklist" value="" />
				</div>

				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-12 text-center" style="font-size: 18px;">
						<p>Voulez-vous vraiment <b>confirmer la transmission au CCA</b> du certificat ?</p>
						<p id="updatestate-pcklist" style="font-weight: bold;"></p>
					</div>
					
				</div>
			
				<div class="modal-footer">
					<button type="button" id="validate-statpcklistConfirmation" style="width: 15%" class="btn btn-block btn-primary pull-left"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Oui</button>
					<button type="button" data-dismiss="modal" style="width: 15%" class="btn btn-block btn-danger pull-right"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;Non</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>