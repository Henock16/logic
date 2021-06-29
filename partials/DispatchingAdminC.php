<div class="modal fade" id="modal-control" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:1000px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="control-form" action="#">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="control-title"></h4>
					<input id="update-control" name="update-control" type="hidden" value="0">
					<input id="id-control" name="id-control" type="hidden" value="">
				</div>
				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-12">					
						<div class="form-group">
							<div class="col-xs-8">
								<select class="form-control pull-center" id="user_control" name="user_control" onchange="updateControl()" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</select>
							</div>
						</div>
						
					</div>
				</div>
			
				<div class="modal-footer">
					<button type="submit" id="validate-Control" style="width: 10%;margin-left: 35%;" class="btn btn-block btn-primary pull-left">Affecter</button>
					<button type="button" id="cancel-Control" style="width: 10%;margin-right: 35%;margin-top:0px" class="btn btn-block btn-danger pull-right">Annuler</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->