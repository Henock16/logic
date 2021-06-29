<div class="modal fade" id="modal-cont" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:750px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="cont-form" action="#">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" style="font-weight: bold"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Affectation du bordereau <span id="controle-title"></span> au contr&ocirc;le</h4>
					<input id="id-cont" name="id-cont" type="hidden" value="">
				</div>
				
				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-12">					
						<div class="form-group">
							<div class="col-xs-4">
								<label for="user_cont" class="control-label">Selectionner un agent</label>
							</div>
							<div class="col-xs-8">
								<select class="form-control pull-center" style="font-size: 16px;" id="user_cont" name="user_cont" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</select>
							</div>
						</div>
						
					</div>
				</div>
			
				<div class="modal-footer">
					<button type="submit" style="width: 15%" class="btn btn-block btn-primary pull-left"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Affecter</button>
					<button type="button" data-dismiss="modal" style="width: 15%" class="btn btn-block btn-danger pull-right"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;Annuler</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->