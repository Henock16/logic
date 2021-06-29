<div class="modal fade" id="modal-close-incid" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:1024px">
		<div class="modal-content" style="border-radius: 3px;">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Incident sur la liasse : <span id="close-incid-bundle"></span></h4>
				<input id="close-id-incid" name="close-id-incid" type="hidden" value="">
			</div>
			
			<div class="modal-body" style="max-height: 650px; overflow-y:auto;">
				
				<div class="col-xs-12" id="close-incid-utilplate" style="display: none; border-bottom: 1px solid #d2d6de; margin-bottom: 10px;">
					<div class="form-group">
						<div class="col-xs-10">
							<h4 id="close-incid-type" style="text-align: center; font-weight: bold;"></h4>
						</div>
						<div class="col-xs-2" style="width: 100%;">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-xs-10">
							<h4 id="close-incid-structure" style="text-align: center;"></h4>
						</div>
						<div class="col-xs-2" style="padding-left: 6%;">
							<button type="button" id="button-close-incid-utilplate" class="btn btn-block btn-primary pull-left"><i class="fa fa-thumbs-up fa-lg"></i>&nbsp;&nbsp;Valider</button>
						</div>
					</div>
					
					<div class="col-xs-12" style="height: 10px"></div>
					
					<div class="form-group">
						<div class="col-xs-12" style="margin-bottom: 10px;">
							<textarea id="close-incid-motif" style="resize: none" class="form-control" rows ="5" col="50" style="width:100%;" value="" disabled="disabled"></textarea>
						</div>
					</div>
					
				</div>
				
				<div class="col-xs-12" id="close-incid-interne" style="display: none;">	
					<div class="form-group">
						<div class="col-xs-10">
							<h4 style="text-align: center; font-weight: bold;">Demande d'intervention</h4>
						</div>
						<div class="col-xs-2" style="width: 100%;">
						</div>
					</div>					
					
					<div class="form-group">
						
						<div class="col-xs-10">
							<h4 id="close-incid-user" style="text-align: center;"></h4>
						</div>
						<div class="col-xs-2" style="padding-left: 6%;">
							<button type="button" id="button-close-incid-user-all" class="btn btn-block btn-primary pull-left"><i class="fa fa-unlock-alt fa-lg"></i>&nbsp;&nbsp;Tous</button>
						</div>
					</div>
					
					<div class="col-xs-12" style="height: 10px"></div>
					
					<div class="form-group">
						<div class="col-xs-12">
							<table class="table table-bordered table-hover" style="font-size: 12px">
								<thead>
									<tr>
										<th style="text-align: center; width: 16%;">Code pes&eacute;e</th>
										<th style="text-align: center; width: 14%;">N&deg; conteneur</th>
										<th style="text-align: center; width: 24%;">Pont bascule</th>
										<th style="text-align: center; width: 10%;">Poids net</th>
										<th style="text-align: center; width: 33%;">Anomalie</th>
										<th style="width: 3%;"></th>
									</tr>
								</thead>
								<tbody  id="close-incid-interne-table">
								</tbody>									
							</table>
						</div>
					</div>
				</div>
				
			</div>
		
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" style="width: 15%" class="btn btn-block btn-danger pull-right"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;Fermer</button>
			</div>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->