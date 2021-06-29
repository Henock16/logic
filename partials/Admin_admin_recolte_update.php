<div class="row">
	<div class="modal fade" id="modal-update-rec" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" style="width:750px">
			<div class="modal-content" style="border-radius: 3px;">
				<form id="form-update-rec" action="#">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Modification r&eacute;colte</h4>
						<input id="update-id-rec" type="hidden" value="">
						<input id="update-lib-camp" type="hidden" value="" />
					</div>
					<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

						<div class="col-xs-6">	
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="rec-update-dateD" class="control-label">D&eacute;but de R&eacute;colte</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control datepicker pull-right" id="rec-update-dateD" name="rec-update-dateD" style="border-radius: 0px;" />
								</div>
							</div>

						</div>

						<div class="col-xs-6">
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="rec-update-dateF" class="control-label">Fin de R&eacute;colte</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control datepicker pull-right" id="rec-update-dateF" name="rec-update-dateF" style="border-radius: 0px;" />
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
</div>