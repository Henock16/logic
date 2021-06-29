<div class="modal fade" id="modal-incidintern" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" style="width:1000px">
		<div class="modal-content" style="border-radius: 3px;">
			<form id="incidintern-form" action="#">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="match-title"></h4>
					<input id="update-incidintern" name="update-incidintern" type="hidden" value="0">
					<input id="id-incidintern" name="id-incidintern" type="hidden" value="">
				</div>
				<div class="modal-body" style="max-height: 1000px; overflow-y:auto;">

					<div class="col-xs-12">					
						<div class="form-group">
							<div class="col-xs-12">
								<table class="table table-bordered table-hover" id="tab_incidintern" style="margin:auto;width:99%">
									<tbody>
										    
										<tr id="incidA0">
											<td >
												<input name="Num_tckt0" id="Num_tckt0" style="text-align: center;" class="form-control"  disabled="disabled"  required="" type="text" />
											</td>
											<td >
											    <input name="Cont_tckt0" id="Cont_tckt0" style="text-align: center;" class="form-control" disabled="disabled" required="" type="text"/>
											</td>
											<td >
											    <input name="site_tckt0" id="site_tckt0" style="text-align: center;" class="form-control" disabled="disabled"/>
											</td>
											<td >
											    <input name="pb_tckt0" id="pb_tckt0" style="text-align: center;" class="form-control" disabled="disabled"/>
											</td>
											<td >
											    <input name="libel0" id="libel0" style="text-align: center;" class="form-control" disabled="disabled"/>
							  				</td>
											<td >
											    <a href="#" id="id_tckt0" class="fa fa-check-square"></a>
											</td>
											
										</tr>
									   <tr id="incidA1"></tr>
								    </tbody>
													   
								</table>
							</div>
						</div>
						
					</div>
			</div>
			
				<div class="modal-footer">
					<button type="submit" id="validate-Incidintern" style="width: 10%;margin-left: 35%;" class="btn btn-block btn-primary pull-left">Valider</button>
					<button type="button" id="cancel-Incidintern" style="width: 10%;margin-right: 35%;margin-top:0px" class="btn btn-block btn-danger pull-right">Annuler</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->