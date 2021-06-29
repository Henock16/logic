<div class="modal fade" id="modal-delete" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:1000px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="delete-form" action="#">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="delete-title"></h4>
					<input id="id-userdelete" name="id-userdelete" type="hidden" value="">
				</div>
				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-12">	

						<div class="form-group">
							<div class="col-xs-6">
								Voulez-vous vraiment supprimer cet utilisateur ?
							</div>
						</div>
						
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" id="validate-delete" style="width: 10%;margin-left: 35%;" class="btn btn-block btn-primary pull-left">Oui</button>
					<button type="button" id="cancel-delete" style="width: 10%;margin-right: 35%;margin-top:0px" class="btn btn-block btn-danger pull-right">Non</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->