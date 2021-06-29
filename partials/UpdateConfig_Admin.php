<div class="modal fade" id="modal-Updconfig" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:1000px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="Updconfig-form" action="#">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="Updconfig-title"></h4>
					<input id="update-Updconfig" name="update-Updconfig" type="hidden" value="0">
					<input id="id-Updconfig" name="id-Updconfig" type="hidden" value="">
				</div>

				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-12">	

						<div class="form-group">
							<div class="col-xs-4">
								<input type="text" class="form-control pull-right" id="lib_Updconfig" name="lib_Updconfig" disabled="disabled" />
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="nb_Updconfig" name="nb_Updconfig" required="required" />
								</select>
							</div>
						</div>

						
					</div>

				
			</div>
			
				<div class="modal-footer">
					<button type="submit" id="validate-Updconfig" style="width: 10%;margin-left: 35%;" class="btn btn-block btn-primary pull-left">Valider</button>
					<button type="button" id="cancel-Updconfig" style="width: 10%;margin-right: 35%;margin-top:0px" class="btn btn-block btn-danger pull-right">Annuler</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->