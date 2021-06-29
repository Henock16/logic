<div class="row">
	<div class="modal fade" id="modal-check-ticket" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" style="width:800px">
			<div class="modal-content" style="border-radius: 3px;">
				<form id="form-check-ticket" action="#">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
						<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle"></i>&nbsp;N&deg; Conteneur : <span id="ticket-title"></span></h4>
						<input id="update-ticket" name="update-ticket" type="hidden" value="0">
						<input id="id-ticket" name="id-ticket" type="hidden" value="">
					</div>
					<div class="modal-body" style="max-height: 650px; overflow-y:auto;">
						<div class="col-xs-6">							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="site" class="control-label">Site</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="site" name="site" disabled="disabled" required />
								</div>
							</div>
							<div style="height: 30px;"></div>
							<div class="form-group">
								<div class="col-xs-4">
									<label for="pes1" class="control-label">Pes&eacute;e&nbsp;1</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="pes1" name="pes1" disabled="disabled" required />
								</div>
							</div>
							<div style="height: 30px;"></div>
							<div class="form-group">
								<div class="col-xs-4">
									<label for="pes2" class="control-label">Pes&eacute;e&nbsp;2</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="pes2" name="pes2" disabled="disabled" required />
								</div>
							</div>
							<div style="height: 30px;"></div>
							<div class="form-group">
								<div class="col-xs-4">
									<label for="pnet" class="control-label">Poids&nbsp;Net</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="pnet" name="pnet" disabled="disabled" required />
								</div>
							</div>
							<div style="height: 30px;"></div>
							<div class="form-group">
								<div class="col-xs-4">
									<label for="temb" class="control-label">Tare&nbsp;Emballage</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="temb" name="temb" disabled="disabled" required />
								</div>
							</div>
							<div style="height: 30px;"></div>
							<div class="form-group" id="hab-cajou">
								<div class="col-xs-4" >
									<label for="thab" class="control-label">Tare&nbsp;Habillage</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" id="thab" name="thab" disabled="disabled" required />
									<select class="form-control pull-right" onchange="MajPnet();updateTicket()" id="typtare" name="typtare" />
									</select>
								</div>
							</div>							
							<div style="height: 30px;"></div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<div class="col-xs-4">
									<label for="cam" class="control-label">N&deg;Camion</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" onkeyup="updateTicket()" id="cam" name="cam" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</div>
							</div>
							<div style="height: 30px;"></div>
							<div class="form-group">
								<div class="col-xs-4">
									<label for="prov" class="control-label">Provenance</label>
								</div>
								<div class="col-xs-8">
									<select class="form-control pull-right" onchange="updateTicket()" id="prov" name="prov" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
									</select>
								</div>
							</div>
							<div style="height: 30px;"></div>							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="insp" class="control-label">Inspecteur</label>
								</div>
								<div class="col-xs-8">
									<select class="form-control pull-right" onchange="updateTicket()" id="insp" name="insp" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
									</select>
								</div>
							</div>
							<div style="height: 30px;"></div>
							<div class="form-group">
								<div class="col-xs-4">
									<label for="tcont" class="control-label">Tare&nbsp;Conteneur</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" onkeyup="updateTicket();MajPnet()" id="tcont" name="tcont" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</div>
							</div>
							<div style="height: 30px;"></div>							
							<div class="form-group">
								<div class="col-xs-4">
									<label for="nbemb" class="control-label">NB&nbsp;Emballage</label>
								</div>
								<div class="col-xs-8">
									<input type="text" class="form-control pull-right" onkeyup="MajPnet();updateTicket()" id="nbemb" name="nbemb" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
								</div>
							</div>
							<div style="height: 30px;"></div>
														
							<div class="form-group" id="marque-coton">
								<div class="col-xs-4" >
									<label for="marq" class="control-label">Marque</label>
								</div>
								<div class="col-xs-8">
									<select class="form-control pull-right" onchange="updateTicket()" id="marq" name="marq" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required />
									</select>
									<select class="form-control pull-right" onchange="MajPnet();updateTicket()" id="marql" name="marql" />
									</select>
								</div>
							</div>
							<div style="height: 30px;"></div>
						</div>
						<div class="col-xs-12">
							<i style="color:#DD4B39">Avez-vous d&eacute;tecter une non conformit&eacute; particuli&egrave;re ?</i></br>
							<label style="color: #00A65A; font-weight:400"><input name="rad" value="1" type="radio">&nbsp;&nbsp;Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="color: #DD4B39;font-weight:400"><input name="rad" value="0" type="radio" checked="checked">&nbsp;&nbsp;Non</label></br>
							<textarea id="text-area" name="text-area" class="form-control" rows ="5" col="50" style="width:100%; display:none" placeholder="Veuillez saisir explicitement la non conformité détectée" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')"  disabled="true" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" id="validate-ticket" style="width: 12%;margin-left: 35%;" class="btn btn-block btn-primary pull-left"><i class="far fa-check-circle fa-lg"></i>&nbsp;Valider</button>
						<button type="button" data-dismiss="modal" style="width: 12%;margin-right: 35%;margin-top:0px" class="btn btn-block btn-danger pull-right"><i class="far fa-times-circle fa-lg"></i>&nbsp;Annuler</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>