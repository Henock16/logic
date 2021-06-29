<div class="modal fade" id="modal-user" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:1000px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="user-form" action="#">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="user-title"></h4>
					<input id="update-user" name="update-ticket" type="hidden" value="0">
					<input id="id-user" name="id-user" type="hidden" value="">
				</div>
				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-6">					
						<div class="form-group">
						<div class="col-xs-4">
								<label for="avatar" class="control-label">Avatar</label>
							</div>
							<div class="col-xs-8">
								<input type="image" class="form-control pull-right" id="img" name="img" alt="Avatar" style="height:100px;margin-bottom:10px;" />
							</div>
							
						</div>
						<div class="form-group">
							<div class="col-xs-4">
								<label for="site" class="control-label">Matricule</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="matr" name="matr" disabled="disabled" required />
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-4">
								<label for="site" class="control-label">Login</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="log" name="log" disabled="disabled" required />
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-4">
								<label for="nbemb" class="control-label">Nom</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="nom" name="nom" disabled="disabled"  required />
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-4">
								<label for="temb" class="control-label">Pr&eacute;nom</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="pren" name="pren" disabled="disabled" required />
							</div>
						</div>
						<div class="form-group" id="hab-cajou">
							<div class="col-xs-4" >
								<label for="thab" class="control-label">Date Naissance</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="naiss" name="naiss" disabled="disabled" required />
							</div>
						</div>
					</div>

					<div class="col-xs-6">
						<div class="form-group">
							<div class="col-xs-4">
								<label for="prov" class="control-label">Ville</label>
							</div>
							<div class="col-xs-8">
								<select class="form-control pull-right" id="vil" name="vil" onchange="updateUser()" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-4">
								<label for="pes2" class="control-label">Contact</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="cont" name="cont" disabled="disabled" required />
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-4">
								<label for="tcont" class="control-label">Email</label>
							</div>
							<div class="col-xs-8">
								<input type="text" class="form-control pull-right" id="mail" name="mail" disabled="disabled" required />
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-4">
								<label for="prov" class="control-label">Poste de travail</label>
							</div>
							<div class="col-xs-8">
								<select class="form-control pull-right" id="trav" name="trav" onchange="updateUser()" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-4">
								<label for="prov" class="control-label">Statut</label>
							</div>
							<div class="col-xs-8">
								<select class="form-control pull-right" id="stat" name="stat" onchange="updateUser()" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</select>
							</div>
						</div>
						<div class="form-group" id="marque-coton">
							<div class="col-xs-4" >
								<label for="marq" class="control-label">Connexion</label>
							</div>
							<div class="col-xs-8">
								<select class="form-control pull-right" id="conex" name="conex" onchange="updateUser()" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</select>
							</div>
						</div>
					</div>
			</div>
			
				<div class="modal-footer">
					<button type="submit" id="validate-user" style="width: 10%;margin-left: 35%;" class="btn btn-block btn-primary pull-left">Valider</button>
					<button type="button" id="cancel-user" style="width: 10%;margin-right: 35%;margin-top:0px" class="btn btn-block btn-danger pull-right">Annuler</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->