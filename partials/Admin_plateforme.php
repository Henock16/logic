<div class="col-xs-12">

	<div class="box">

		<div class="box-header">
			<h3 class="box-title">Administration de la plateforme en ligne</h3>
		</div>

		<div class="box-body" style="padding-top: 0px">

			<ul class="nav nav-tabs" id="myTab">
				<li class="active">
					<a data-toggle="tab" href="#utilplate">Compte utilisateur</a>
				</li>

				<li >
					<a data-toggle="tab" href="#camp">Campagne</a>
				</li>

				<li>
					<a data-toggle="tab" href="#rec">R&eacute;colte</a>
				</li>

				<li>
					<a data-toggle="tab" href="#expor">Exportateur</a>
				</li>

				<li>
					<a data-toggle="tab" href="#transit">Transitaire</a>
				</li>

				<li>
					<a data-toggle="tab" href="#dest">Destination</a>
				</li>

				<li>
					<a data-toggle="tab" href="#egren">Egreneur</a>
				</li>

				<li>
					<a data-toggle="tab" href="#prod">Produit</a>
				</li>

				<li>
					<a data-toggle="tab" href="#pcklist">Packing List</a>
				</li>

			</ul>

			<div class="tab-content" style="padding-top: 10px">

				<div id="utilplate" class="tab-pane in active">

					<table id="utilplate-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Utilisateur</th>
								<th>Structure</th>
								<th>Responsable</th>
								<th>Fonction</th>
								<th>Ville</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php 
						if($_SESSION['ROLE'] == 0){
							echo '<a href="#" id="add-utilplate" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er utilisateur en ligne</a>';
						}
					?>
				</div>

				<div id="camp" class="tab-pane">

					<table id="camp-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Ann&eacute;e</th>
								<th>D&eacute;but</th>
								<th>Fin</th>
								<th>Produit</th>
								<th>Date de cr&eacute;ation</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php 
						if($_SESSION['ROLE'] <= 1){
							echo '<a href="#" id="add-camp" class="btn btn-primary button-admin"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er campagne</a>';
						}
					?>					
				</div>

				<div id="rec" class="tab-pane">

					<table id="rec-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Ann&eacute;e</th>
								<th>D&eacute;but</th>
								<th>Fin</th>
								<th>Produit</th>
								<th>Date de cr&eacute;ation</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php 
						if($_SESSION['ROLE'] <= 1){
							echo '<a href="#" id="add-rec" class="btn btn-primary button-admin"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er r&eacute;colte</a>';
						}
					?>					
				</div>

				<div id="expor" class="tab-pane">

					<table id="expor-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Exportateur</th>
								<th>Produit</th>
								<th>Campagne active</th>
								<th>Agr&eacute;ment</th>
								<th>Date de cr&eacute;ation</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php 
						if($_SESSION['ROLE'] <= 1){
							echo '<a href="#" id="exporAdd" class="btn btn-primary button-admin"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er exportateur</a>';
						}
					?>					
				</div>

				<div id="transit" class="tab-pane">
					<table id="transit-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Transitaire</th>
								<th>Date de cr&eacute;ation</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php 
						if($_SESSION['ROLE'] <= 1){
							echo '<a href="#" id="transAdd" class="btn btn-primary button-admin"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er transitaire</a>';
						}
					?>					
				</div>

				<div id="dest" class="tab-pane">
					<table id="dest-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Pays</th>
								<th>Port</th>
								<th>Date de cr&eacute;ation</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php 
						if($_SESSION['ROLE'] <= 1){
							echo '<a href="#" id="destAdd" class="btn btn-primary button-admin"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er destination</a>';
						}
					?>					
				</div>

				<div id="egren" class="tab-pane">
					<table id="egren-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>&Eacute;greneur</th>
								<th>Date de cr&eacute;ation</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php 
						if($_SESSION['ROLE'] <= 1){
							echo '<a href="#" id="egreAdd" class="btn btn-primary button-admin"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er &eacute;greneur</a>';
						}
					?>					
				</div>

				<div id="prod" class="tab-pane">
					<table id="prod-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Produit</th>
								<th>Date de cr&eacute;ation</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php 
						if($_SESSION['ROLE'] <= 1){
							echo '<a href="#" id="prodAdd" class="btn btn-primary button-admin"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er produit</a>';
						}
					?>					
				</div>

				<div id="pcklist" class="tab-pane">
					<table id="pcklist-table" class="table table-bordered">
						<thead>
							<tr>
								<th>N&deg; Packing list</th>
								<th>Produit</th>
								<th>Poids net (Kg)</th>
								<th>Ville</th>
								<th>Date cr&eacute;ation</th>
								<th>D&eacute;lai</th>
								<th style="width: 11%;"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>