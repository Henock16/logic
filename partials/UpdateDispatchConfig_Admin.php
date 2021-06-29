<div class="modal fade" id="modal-UpdDconfig" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:1000px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="UpdDconfig-form" action="#">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="UpdDconfig-title"></h4>
					<input id="update-UpdDconfig" name="update-UpdDconfig" type="hidden" value="0">
					<input id="id-UpdDconfig" name="id-UpdDconfig" type="hidden" value="">
				</div>

				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-12">	

						<div class="form-group">
							<div class="col-xs-4">
								<input type="text" class="form-control pull-right" id="lib_UpdDconfig" name="lib_UpdDconfig" disabled="disabled" />
							</div>
							<div class="col-xs-8">
								<select class="form-control pull-right" id="std_UpdDconfig" name="std_UpdDconfig"oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required >
								<option value="1">Automatique</option>
								<option value="0">Manuel</option>
								</select>
							</div>
						</div>

						
					</div>

				
			</div>
			
				<div class="modal-footer">
					<button type="submit" id="validate-UpdDconfig" style="width: 10%;margin-left: 35%;" class="btn btn-block btn-primary pull-left">Valider</button>
					<button type="button" id="cancel-UpdDconfig" style="width: 10%;margin-right: 35%;margin-top:0px" class="btn btn-block btn-danger pull-right">Annuler</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->