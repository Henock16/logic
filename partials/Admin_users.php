<div class="col-xs-12">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Gestion des utilisateurs</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<table id="user-table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Pr&eacute;nom</th>
						<th>Utilisateur</th>
						<th>Matricule</th>
						<th>Cellule</th>
						<th>Ville</th>
						<th style="width: 11%"></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<?php 
				if($_SESSION['ROLE'] <= 1){
					echo '<a href="#" id="add-user" class="btn btn-primary button-admin"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Cr&eacute;er utilisateur</a>';
				}
			?>			
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</div>
<!-- /.col -->