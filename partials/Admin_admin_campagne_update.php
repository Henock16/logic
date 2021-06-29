<div class="row">
	<div class="modal fade" id="modal-update-camp" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" style="width:750px">
			<div class="modal-content" style="border-radius: 3px;">
				<form id="form-update-camp" action="#">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Modification campagne</h4>
						<input type="hidden" id="update-id-camp" value="" />
						<input type="hidden" id="update-lib-camp" value="" />
					</div>

					<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

						<div class="col-xs-6">	
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="camp-update-dateD" class="control-label">D&eacute;but de Campagne</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control datepicker pull-right" id="camp-update-dateD" name="camp-update-dateD" style="border-radius: 0px;" />
								</div>
							</div>

						</div>

						<div class="col-xs-6">
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="camp-update-dateF" class="control-label">Fin de Campagne</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control datepicker pull-right" id="camp-update-dateF" name="camp-update-dateF" style="border-radius: 0px;" />
								</div>
							</div>
							
						</div>
					</div>
				
					<div class="modal-footer">
						<button type="submit" style="width: 15%;" class="btn btn-block btn-primary pull-left"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Modifier</button>
						<button type="button" style="width: 15%" class="btn btn-block btn-danger pull-right" data-dismiss="modal"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;Annuler</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>