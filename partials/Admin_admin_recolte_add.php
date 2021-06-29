<div class="row">
	<div class="modal fade" id="modal-add-rec" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" style="width:750px">
			<div class="modal-content" style="border-radius: 3px;">
				<form id="form-add-rec" action="#">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle"></i>&nbsp;Cr&eacute;ation nouvelle r&eacute;colte</h4>
					</div>

					<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

						<div class="col-xs-6">	

							<div class="form-group">
								<div class="col-xs-4">
									<label for="rec-product" class="control-label">Produit</label>
								</div>
								<div class="col-xs-8">
									<select class="form-control pull-right" id="rec-product" name="rec-product" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required >
									</select>
								</div>
							</div>
							
							<div style="height: 30px;"></div>
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="rec-year" class="control-label">Ann&eacute;e</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="rec-year" name="rec-year" required />
								</div>
							</div>

						</div>

						<div class="col-xs-6">
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="rec-dateD" class="control-label">Date D&eacute;but</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control datepicker pull-right" id="rec-dateD" name="rec-dateD" />
								</div>
							</div>
							
							<div style="height: 30px;"></div>
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="rec-dateF" class="control-label">Date Fin</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control datepicker pull-right" id="rec-dateF" name="rec-dateF" />
								</div>
							</div>
							
						</div>
				</div>
				
					<div class="modal-footer">
						<button type="submit" style="width: 15%;" class="btn btn-block btn-primary pull-left"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Cr&eacute;er</button>
						<button type="button" data-dismiss="modal" style="width: 15%" class="btn btn-block btn-danger pull-right"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;Annuler</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>