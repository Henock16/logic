<div class="modal fade" id="modal-Addexpor" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:750px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="Addexpor-form" action="#">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle"></i>&nbsp;Cr&eacute;ation nouvel exportateur</h4>
				</div>

				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-6">	
						
						<div class="form-group">
							<div class="col-xs-4">
								<label for="expor_Addexpor" class="control-label">Exportateur</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="expor_Addexpor" name="expor_Addexpor" required />
							</div>
						</div>
						
						<div style="height: 30px;"></div>
						
						<div class="form-group">
							<div class="col-xs-4">
								<label for="prod_Addexpor" class="control-label">Produit</label>
							</div>
							<div class="col-xs-8">
								<select class="form-control pull-right" id="prod_Addexpor" name="prod_Addexpor" onchange="updateCamp()" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required >
								</select>
							</div>
						</div>						

					</div>

					<div class="col-xs-6">
						
						<div class="form-group">
							<div class="col-xs-4">
								<label for="camp_Addexpor" class="control-label">Campagne</label>
							</div>
							<div class="col-xs-8">
							<select class="form-control pull-right" id="camp_Addexpor" name="camp_Addexpor"  oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required >
							</select>
							</div>
						</div>
						
						<div style="height: 30px;"></div>
						
						<div class="form-group">
							<div class="col-xs-4">
								<label for="agre_Addexpor" class="control-label">N&deg;&nbsp;Agr&eacute;ment</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="agre_Addexpor" name="agre_Addexpor" required />
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