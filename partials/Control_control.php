<div class="col-xs-12" id="control" style="display:none;">
	<div class="box box-default box-solid collapsed-box">
		<div class="box-header with-border">
			<h3 class="box-title" id="numpklist" style="font-weight: bold"></h3>&nbsp;
			<span id="numticket" style="font-weight: bold"></span>&nbsp;|
			<h3 class="box-title" id="weight" style="color:#e00000;background-color: white;padding: 2px;border-radius: 2px;"></h3>
			<input type="hidden" id="weight2" value="" />
			<a href="#" target="_blank" style="display:none;margin-right: 30px;" class="pull-right edit-certif"><button type="button" style="width:150px;height: 25px;padding: 1px 5px 5px 5px; color: white" class="btn btn-block btn-success"><i class="fa fa-print"></i>&nbsp;Certificat provisoire</button></a>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
				</button>
			</div>
			<!-- /.box-tools -->
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding" style="display: none;">
			<div id="head-color" class="box box-info" style="font-size: 13px; font-weight: lighter; margin: 0px">
				<!-- form coton start -->
				<form class="form-horizontal control-form" id="control-coton" style="display: none;">
					<div class="box-body" style="max-height: 535px;overflow: auto;font-size: 15px;">
						<div class="col-xs-6">
							<div class="form-group">
								<div class="col-xs-3">
									<label for="recA" class="control-label">R&eacute;colte</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control pull-right" id="recA" name="recA" placeholder="Récolte" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="campA" class="control-label">Campagne</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="campA" name="campA" placeholder="Campagne" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="prodA" class="control-label">Produit</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="prodA" name="prodA" placeholder="Produit" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="rapA" class="control-label">Rapport&nbsp;Emp.</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="rapA" name="rapA" placeholder="Rapport Empotage" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Champ obligatoire')" required /> 
									<input type="hidden" style="width:0;height:0" id="rapA1" name="rapA1" value="" />
								</div>
							</div>							
							<div class="form-group">
								<div class="col-xs-3">
									<label for="typcA" class="control-label">Type&nbsp;TC(s)</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="typcA" name="typcA" placeholder="Type Conteneur" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="transA" class="control-label">Transitaire</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="transA" name="transA" placeholder="Transitaire" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="egrA" class="control-label">Egreneur</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="egrA" name="egrA" placeholder="Egreneur" disabled="disabled" required />
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<div class="col-xs-3">
									<label for="expA" class="control-label">Exportateur</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="expA" name="expA" placeholder="Exportateur" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="instfourA" class="control-label">N&deg;&nbsp;Inst.&nbsp;Four.</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="instfourA" name="instfourA" placeholder="N° Instruction Fournisseur" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="cliA" class="control-label">Client</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="cliA" name="cliA" placeholder="Client" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="instcliA" class="control-label">N&deg;&nbsp;Inst.&nbsp;Client</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="instcliA" name="instcliA" placeholder="N° Instruction Client" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="destA" class="control-label">Destination</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="destA" name="destA" placeholder="Destination" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="navA" class="control-label">Navire</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="navA" name="navA" placeholder="Navire" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="dossA" class="control-label">N&deg;&nbsp;Dossier</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="dossA" name="dossA" placeholder="N° Dossier" disabled="disabled" required />
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="box">
								<!-- /.box-header -->
								<div class="box-body no-padding">
									<table class="table details" id="ticket-coton">
										<tbody>
											<tr>
												<th style="text-align:center">N&deg; Ticket</th>
												<th style="width:15%;text-align:center">Date</th>
												<th style="width:18%;text-align:center">N&deg; Conteneur</th>
												<th style="width:20%;text-align:center">N&deg; Plomb</th>
												<th style="width:15%;text-align:center">Poids net (Kg)</th>
												<th></th>
											</tr>
										</tbody>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<p class="warning-printing" style="color: #dd4b39;font-size: 14px;text-align: center;font-style:italic;font-weight: bold;"></p>
						<button type="submit" id="validate-cot" style="width: 10%;margin-left: 35%;margin-top: 0px;" class="btn btn-block btn-primary pull-left"><i class="far fa-check-circle fa-lg"></i>&nbsp;Valider</button>
						<button type="button" id="cancel-cot" style="width: 10%;margin-right: 35%;margin-top: 0px;" class="btn btn-block btn-danger pull-right cancel-bundle"><i class="far fa-times-circle fa-lg"></i>&nbsp;Annuler</button>
					</div>
					<!-- /.box-footer -->
				</form>
				<!-- form cajou start -->
				<form class="form-horizontal control-form" id="control-cajou" style="display: none;">
					<div class="box-body" style="max-height: 535px;overflow: auto;font-size: 15px;">
						<div class="col-xs-6">
							<div class="form-group">
								<div class="col-xs-3">
									<label for="recB" class="control-label">R&eacute;colte</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control pull-right" id="recB" name="recB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="campB" class="control-label">Campagne</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="campB" name="campB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="prodB" class="control-label">Produit</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="prodB" name="prodB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="dateB" class="control-label">Date</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="dateB" name="dateB" disabled="disabled" required />
								</div>
							</div>							
							<div class="form-group">
								<div class="col-xs-3">
									<label for="typcB" class="control-label">Type&nbsp;TC(s)</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="typcB" name="typcB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="transB" class="control-label">Transitaire</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="transB" name="transB" disabled="disabled" required />
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<div class="col-xs-3">
									<label for="expB" class="control-label">Exportateur</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="expB" name="expB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="cliB" class="control-label">Client</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="cliB" name="cliB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="destB" class="control-label">Destination</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="destB" name="destB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="navB" class="control-label">Navire</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="navB" name="navB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="pklistB" class="control-label">N&deg;&nbsp;Packing&nbsp;List</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="pklistB" name="pklistB" disabled="disabled" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label for="otB" class="control-label">N&deg;&nbsp;OT</label>
								</div>
								<div class="col-xs-9">
									<input type="text" class="form-control" id="otB" name="otB" disabled="disabled" required />
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="box">
								<!-- /.box-header -->
								<div class="box-body no-padding">
									<table class="table details" id="ticket-cajou">
										<tbody>
											<tr>
												<th style="text-align:center">N&deg; Ticket</th>
												<th style="width:15%;text-align:center">Date</th>
												<th style="width:18%;text-align:center">N&deg; Conteneur</th>
												<th style="width:20%;text-align:center">N&deg; Plomb</th>
												<th style="width:15%;text-align:center">Poids net (Kg)</th>
												<th></th>
											</tr>
										</tbody>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<p class="warning-printing" style="color: #dd4b39;font-size: 14px;text-align: center;font-style:italic"></p>
						<button type="submit" id="validate-caj" style="width: 10%;margin-left: 35%;margin-top: 0px;" class="btn btn-block btn-primary pull-left"><i class="far fa-check-circle fa-lg"></i>&nbsp;Valider</button>
						<button type="button" id="cancel-caj" style="width: 10%;margin-right: 35%;margin-top: 0px;" class="btn btn-block btn-danger pull-right cancel-bundle"><i class="far fa-times-circle fa-lg"></i>&nbsp;Annuler</button>
					</div>
					<!-- /.box-footer -->
				</form>
			</div>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</div>
<!-- /.col -->