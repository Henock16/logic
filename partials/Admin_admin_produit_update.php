<div class="modal fade" id="modal-Updprod" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:750px">
		<div class="modal-content" style="border-radius: 3px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Modification du produit</h4>
				<input id="upidprod" type="hidden" value="">
			</div>

			<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

				<div class="col-xs-12" style="padding-right: 0px">

					<div class="form-group">
						<div class="col-xs-4">
							<label for="produit_Updprod" class="control-label">Produit</label>
						</div>
						<div class="col-xs-6">
							<input type="text" class="form-control pull-right" id="produit_Updprod" name="produit_Updprod" required />
						</div>
						<div class="col-xs-2" style="padding-right: 0px">
							<button type="button" id="button-updateprod" style="width: 100%;text-align: left;" class="btn btn-block btn-warning pull-left"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Modifier</button>
						</div>
					</div>

				</div>

				<div class="col-xs-12" style="height: 30px"></div>

				<div class="col-xs-12" style="padding-right: 0px">

					<div class="form-group">
						<div class="col-xs-4">
							<label for="sousproduit_addprod" class="control-label">Sous-produit</label>
						</div>
						<div class="col-xs-6">
							<input type="text" class="form-control pull-right" id="sousproduit_addprod" name="sousproduit_addprod" />
						</div>
						<div class="col-xs-2" style="padding-right: 0px">
							<button type="button" id="button-addsousprod" style="width: 100%;text-align: left;" class="btn btn-block btn-primary pull-left"><i class="fa fa-plus-circle fa-lg"></i>&nbsp;Ajouter</button>
						</div>
					</div>

				</div>

				<div class="col-xs-12" style="height: 30px"></div>

				<div class="col-xs-12" style="padding-right: 0px">
					<div class="form-group">
						<div class="col-xs-4">
							<label for="sousproduit_delprod" class="control-label">Sous-produit</label>
						</div>
						<div class="col-xs-6">
							<select class="form-control pull-right" id="sousproduit_delprod" name="sousproduit_delprod">
							</select>
						</div>
						<div class="col-xs-2" style="padding-right: 0px">
							<button type="button" id="button-delsousprod" style="width: 100%;text-align: left;" class="btn btn-block btn-danger pull-left"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;D&eacute;sactiver</button>
						</div>
					</div>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" data-dismiss="modal" style="width: 15%" class="btn btn-block btn-danger pull-left"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;Fermer</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
