<div class="col-xs-12">
	<div class="box">

		<div class="box-header">

			<h3 class="box-title">Gestion du Contr&ocirc;le</h3>

		</div>

		<div class="box-body" style="padding-top: 0px">

			<ul class="nav nav-tabs" id="myTab">
				<li class="active">
					<a data-toggle="tab" href="#affec">R&eacute;partition</a>
				</li>

				<li>
					<a data-toggle="tab" href="#list">Suivi</a>
				</li>
				<li>
					<a data-toggle="tab" href="#config">Configuration</a>
				</li>
			</ul>

			<div class="tab-content" style="padding-top: 10px">

				<div id="affec" class="tab-pane in active">

					<table id="controle-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Agent matching</th>
								<th>Certificats</th>
								<th>Tickets</th>
								<th>Poids net (Kg)</th>
								<th>Date cloture</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

				</div>

				<div id="list" class="tab-pane">

					<table id="contro-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Nom</th>
								<th>Pr&eacute;nom</th>
								<th>Liasses</th>
								<th>Tickets</th>
								<th>Ville</th>
								<th>Statut</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				
				<div id="config" class="tab-pane">

					<table id="config-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Param&egrave;tre</th>
								<th>Valeur</th>
								<th>Ville</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				
			</div>

		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</div>
<!-- /.col -->