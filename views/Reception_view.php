		<!-- Home Administration -->
		<?php include_once('./partials/Reception_home.php');?>

		<!-- Main content -->
		<section class="content" style="max-height: 730px; overflow: auto;padding-bottom: 0px;">

			<div class="row" id="RECEPTION" style="display:none">
				<?php include_once('./partials/Reception_reception.php');?>
			</div>

			<div class="row" id="ARCHIVE" style="display:none">
				<?php include_once('./partials/Reception_archive.php');?>
			</div>

			<div class="row" id="PROFIL" style="display:none">
				<?php include_once('./partials/User_profil.php');?>
			</div>

		</section>
		<!-- /.content -->

		</div>
		<!-- /.content-wrapper -->
		<?php include_once('./partials/User_packinglist_info.php');?>
		<?php include_once('./partials/Reception_updatstatut.php');?>
		<?php include_once('./partials/Reception_infoarchive.php');?>