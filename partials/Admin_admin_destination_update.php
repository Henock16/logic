<div class="modal fade" id="modal-Upddest" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:750px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="Upddest-form" action="#">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Modification destination</h4>
					<input id="upiddest" type="hidden" value="">
				</div>

				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-6">	

						<div class="form-group">
							<div class="col-xs-4">
								<label for="pays_Updpays" class="control-label">Pays</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="pays_Updpays" name="pays_Updpays" required />
							</div>
						</div>

					</div>

					<div class="col-xs-6">
						
						<div class="form-group">
							<div class="col-xs-4">
								<label for="port_Updport" class="control-label">Port</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="port_Updport" name="port_Updport" required />
							</div>
						</div>
						
					</div>
			</div>
			
				<div class="modal-footer">
					<button type="submit" style="width: 15%;" class="btn btn-block btn-primary pull-left"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Modifier</button>
					<button type="button" data-dismiss="modal" style="width: 15%;" class="btn btn-block btn-danger pull-right"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;Annuler</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->