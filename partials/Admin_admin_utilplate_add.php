<div class="row">
	<div class="modal fade" id="modal-add-utilplate" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" style="width:750px">
			<div class="modal-content" style="border-radius: 3px;">
				<form id="form-add-utilplate" action="#">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle"></i>&nbsp;Cr&eacute;ation nouvel utilisateur en ligne</h4>
					</div>

					<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

						<div class="col-xs-6">

							<div class="form-group">
								<div class="col-xs-4">
									<label for="utilplate-structure" class="control-label">Structure</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="utilplate-structure" name="utilplate-structure" required />
								</div>
							</div>

							<div style="height: 30px;"></div>

							<div class="form-group">
								<div class="col-xs-4">
									<label for="utilplate-typop" class="control-label">Type Op&eacute;rateur</label>
								</div>
								<div class="col-xs-8">
									<select class="form-control pull-right" id="utilplate-typop" name="utilplate-typop" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required >
										<option selected disabled >------ Type Opérateur ------</option>
										<option value="1">Exportateur</option>
										<option value="2">Transitaire</option>
									</select>
								</div>
							</div>

						</div>

						<div class="col-xs-6">
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="utilplate-logo" class="control-label">Logo</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="utilplate-logo" name="utilplate-logo" required />
								</div>
							</div>
							
							<div style="height: 30px;"></div>
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="utilplate-town" class="control-label">Ville</label>
								</div>
								<div class="col-xs-8">
								<select class="form-control pull-right" id="utilplate-town" name="utilplate-town"  oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required >
									<option selected disabled >------------ Ville ------------</option>
									<option value="1">Abidjan</option>
									<option value="2">San Pedro</option>
									<option value="3">Bouak&eacute;</option>
								</select>
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
