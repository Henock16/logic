<div class="col-xs-12">
	<div class="box">

		<div class="box-header">

			<h3 class="box-title">Gestion du Matching</h3>

		</div>

		<div class="box-body" style="padding-top: 0px">

			<ul class="nav nav-tabs" id="myTab">
				<li class="active">
				<a data-toggle="tab" href="#affecM">R&eacute;partition</a>
				</li>

				<li>
				<a data-toggle="tab" href="#listM">Suivi</a>
				</li>
				<li>
				<a data-toggle="tab" href="#configM">Configuration</a>
				</li>
			</ul>

			<div class="tab-content" style="padding-top: 10px">

				<div id="affecM" class="tab-pane in active">

					<table id="matching-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>N&deg; Packing list</th>
								<th>Tickets</th>
								<th>Produit</th>
								<th>Poids net (Kg)</th>
								<th>Ville</th>
								<th>Date cr&eacute;ation</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

				</div>

				<div id="listM" class="tab-pane">

					<table id="match-table" class="table table-bordered table-hover">
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

				<div id="configM" class="tab-pane">

					<table id="configM-table" class="table table-bordered table-hover">
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
