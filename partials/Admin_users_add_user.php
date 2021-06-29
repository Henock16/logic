<div class="row">
	<div class="modal fade" id="modal-add-user" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" style="width:900px">
			<div class="modal-content" style="border-radius: 3px;">
			
				<form id="form-add-user" action="#">
				
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle"></i>&nbsp;Cr&eacute;ation nouvel utilisateur</h4>
					</div>
					
					<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

						<div class="col-xs-6">					
							<div class="form-group">
								<div class="col-xs-4">
									<label for="user-matr" class="control-label">Matricule</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="user-matr" name="user-matr" required />
								</div>
							</div>
							
							<div class="col-xs-12" style="height: 10px"></div>
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="user-name" class="control-label">Nom</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="user-name" name="user-name" onkeydown="if(event.keyCode==32) return false;" required />
								</div>
							</div>
							
							<div class="col-xs-12" style="height: 10px"></div>
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="user-firstname" class="control-label">Pr&eacute;nom</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="user-firstname" name="user-firstname" onkeydown="if(event.keyCode==32) return false;" required />
								</div>
							</div>
							
							<div class="col-xs-12" style="height: 10px"></div>
							
							<div class="form-group">
								<div class="col-xs-4" >
									<label for="user-birth" class="control-label">Date de naissance</label>
								</div>
								<div class="col-xs-8">
									<input type="text" style="border-radius: 0px" class="form-control datepicker pull-right" id="user-birth" name="user-birth" required />
								</div>
							</div>
						</div>
						
						<div class="col-xs-6">
						
							<div class="form-group">
								<div class="col-xs-4">
									<label for="user-town" class="control-label">Ville</label>
								</div>
								<div class="col-xs-8">
									<select class="form-control pull-right" id="user-town" name="user-town"  oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required >
									</select>
								</div>
							</div>
							
							<div class="col-xs-12" style="height: 10px"></div>
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="user-phone" class="control-label">Contact</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right phone" id="user-phone" name="user-phone" required />
								</div>
							</div>
							
							<div class="col-xs-12" style="height: 10px"></div>
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="user-mail" class="control-label">Email</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="user-mail" name="user-mail" required />
								</div>
							</div>
							
							<div class="col-xs-12" style="height: 10px"></div>
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="user-cel" class="control-label">Cellule</label>
								</div>
								<div class="col-xs-8">
									<select class="form-control pull-right" id="user-cel" name="user-cel" onchange="" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required >
									</select>
								</div>
							</div>						
						</div>
					
						<!--
						<div class="col-xs-12">
							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="avatar" class="control-label">Avatar</label>
								</div>
								<div class="col-xs-8">
									<input type="image" class="form-control pull-right" id="img-Adduser" name="img-Adduser" alt="Avatar" style="height:100px;margin-bottom:10px;" />
								</div>								
							</div>							
						</div>-->
						
						<div class="col-xs-12" style="height: 10px"></div>
						<div class="col-xs-12">
							<p id="form-add-user-error" class="text-center" style="color: red"></p>
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