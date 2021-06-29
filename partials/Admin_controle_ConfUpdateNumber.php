<div class="modal fade" id="modal-Upconfcnum" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:750px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="Upconfcnum-form" action="#">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Modification du param&egrave;tre</h4>
					<input id="upidconfc" type="hidden" value="">
				</div>
				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">
					
					<p id="Upconfctext" style="font-weight: bold; font-size: 18px; text-align: center"></p>
					<div class="col-xs-12" style="font-size: 18px">	
						
						<div class="form-group">
							<div class="col-xs-4"></div>
							<div class="col-xs-4">
								<select class="form-control pull-right" id="numberforconfc" name="numberforconfc">
									<option selected disabled>------------ Valeur ------------</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</div>
							<div class="col-xs-4"></div>
						</div>

					</div>					
				</div>

				<div class="modal-footer">
					<button type="submit" style="width: 15%;" class="btn btn-block btn-primary pull-left"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Modifier</button>
					<button type="button" data-dismiss="modal" style="width: 15%;" class="btn btn-block btn-danger pull-right"><i class="fa fa-times-circle-o fa-lg"></i>&nbsp;Annuler</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->