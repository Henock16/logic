	<!-- Home Administration -->
	<?php include_once('./partials/Admin_home.php');?>

	<!-- Main content -->
	<section class="content" style="max-height: 730px; overflow: auto;padding-bottom: 0px;">

		<div class="row nav-menu" id="INTERFACE" style="display:none">
			<?php include_once('./partials/Admin_plateforme.php');?>
		</div>

		<div  class="row nav-menu" id="MATCHING" style="display:none">
			<?php include_once('./partials/Admin_matching.php');?>
		</div>

		<div  class="row nav-menu" id="CONTROLE" style="display:none">
			<?php include_once('./partials/Admin_control.php');?>
		</div>

		<div  class="row nav-menu" id="INCIDENT" style="display:none">
			<?php include_once('./partials/Admin_incident.php');?>
		</div>

		<div class="row nav-menu" id="USER" style="display:none">
			<?php include_once('./partials/Admin_users.php');?>
		</div>
		
		<div class="row nav-menu" id="ARCHIVE" style="display:none">
			<?php include_once('./partials/Admin_archive.php');?>
		</div>

		<div  class="row nav-menu" id="PROFIL" style="display:none">
			<?php include_once('./partials/User_profil.php');?>
		</div>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Début Modal Compte utilisateur en ligne -->
	<!-- Modal création d'un compte utilisateur en ligne -->
	<?php include_once('./partials/Admin_admin_utilplate_add.php');?>

	<!-- Modal affichage des informations du propriétaire du compte utilisateur en ligne -->
	<?php include_once('./partials/Admin_admin_utilplate_get.php');?>

	<!-- Modal confirmation réinitialisation du compte utilisateur en ligne -->
	<?php include_once('./partials/Admin_admin_utilplate_reinit.php');?>

	<!-- Modal confirmation activation/désactivation compte utilisateur -->
	<?php include_once('./partials/Admin_admin_utilplate_status.php');?>
<!-- Fin Modal Compte utilisateur en ligne -->

<!-- Début Modal Campagne -->
	<!-- Modal création campagne -->
	<?php include_once('./partials/Admin_admin_campagne_add.php');?>
	
	<!-- Modal modification campagne -->
	<?php include_once('./partials/Admin_admin_campagne_update.php');?>
	
	<!-- Modal Confirmation activation/désactivation campagne -->
	<?php include_once('./partials/Admin_admin_campagne_upstate.php');?>	
<!-- Fin Modal Campagne -->

<!-- Début Modal Récolte -->
	<!-- Modal création récolte -->
	<?php include_once('./partials/Admin_admin_recolte_add.php');?>
	
	<!-- Modal modification récolte -->
	<?php include_once('./partials/Admin_admin_recolte_update.php');?>
	
	<!-- Modal Confirmation activation/désactivation récolte -->
	<?php include_once('./partials/Admin_admin_recolte_upstate.php');?>	
<!-- Fin Modal Récolte -->

<!-- Début Modal Exportateur -->
	<!-- Modal création exportateur -->
	<?php include_once('./partials/Admin_admin_exportateur_add.php');?>

	<!-- Modal modification exportateur -->
	<?php include_once('./partials/Admin_admin_exportateur_update.php');?>

	<!-- Modal Confirmation activation/désactivation exportateur -->
	<?php include_once('./partials/Admin_admin_exportateur_upstate.php');?>
<!-- Fin Modal Exportateur -->

<!-- Début Modal transitaire -->
	<!-- Modal création transitaire -->
	<?php include_once('./partials/Admin_admin_transitaire_add.php');?>

	<!-- Modal modification transitaire -->
	<?php include_once('./partials/Admin_admin_transitaire_update.php');?>

	<!-- Modal Confirmation activation/désactivation transitaire -->
	<?php include_once('./partials/Admin_admin_transitaire_upstate.php');?>
<!-- Fin Modal transitaire -->

<!-- Début Modal destination -->
	<!-- Modal création destination -->
	<?php include_once('./partials/Admin_admin_destination_add.php');?>

	<!-- Modal modification destination -->
	<?php include_once('./partials/Admin_admin_destination_update.php');?>

	<!-- Modal Confirmation activation/désactivation destination -->
	<?php include_once('./partials/Admin_admin_destination_upstate.php');?>
<!-- Fin Modal destination -->

<!-- Début Modal egreneur -->
	<!-- Modal création egreneur -->
	<?php include_once('./partials/Admin_admin_egreneur_add.php');?>

	<!-- Modal modification egreneur -->
	<?php include_once('./partials/Admin_admin_egreneur_update.php');?>

	<!-- Modal Confirmation activation/désactivation egreneur -->
	<?php include_once('./partials/Admin_admin_egreneur_upstate.php');?>
<!-- Fin Modal egreneur -->

<!-- Début Modal produit -->
	<!-- Modal création produit -->
	<?php include_once('./partials/Admin_admin_produit_add.php');?>

	<!-- Modal modification produit -->
	<?php include_once('./partials/Admin_admin_produit_update.php');?>

	<!-- Modal Confirmation activation/désactivation produit -->
	<?php include_once('./partials/Admin_admin_produit_upstate.php');?>
<!-- Fin Modal produit -->

<!-- Début Modal produit -->
	<!-- Modal création produit -->
	<?php include_once('./partials/User_packinglist_info.php');?>

	<!-- Modal Confirmation activation/désactivation produit -->
	<?php include_once('./partials/Admin_admin_packinglist_rejet.php');?>
<!-- Fin Modal produit -->

<!-- Début Modal gestion matching -->
	<!-- Modal affectation de liasse -->
	<?php include_once('./partials/Admin_matching_bundle_dispach.php');?>
	
	<!-- Modal détails de l'agent du matching -->
	<?php include_once('./partials/Admin_matching_agent_info.php');?>
	
	<!-- Modal désactivation/activation d'un paramètre -->
	<?php include_once('./partials/Admin_matching_ConfUpdateMode.php');?>
	
	<!-- Modal modification d'un paramètre numérique -->
	<?php include_once('./partials/Admin_matching_ConfUpdateNumber.php');?>
<!-- /.Fin Modal gestion matching -->

<!-- Début Modal gestion controle -->
	<!-- Modal affectation de liasse -->
	<?php include_once('./partials/Admin_controle_Slip_dispach.php');?>
	
	<!-- Modal détails de l'agent du controle -->
	<?php include_once('./partials/Admin_Controle_agent_info.php');?>
	
	<!-- Modal désactivation/activation d'un paramètre -->
	<?php include_once('./partials/Admin_controle_ConfUpdateMode.php');?>
	
	<!-- Modal modification d'un paramètre numérique -->
	<?php include_once('./partials/Admin_controle_ConfUpdateNumber.php');?>
<!-- /.Fin Modal gestion controle -->

<!-- Début Modal gestion incident -->
	<!-- Modal résolution des incidents -->
	<?php include_once('./partials/Admin_incident_close_incident.php');?>
	
	<!-- Modal résolution des interventions -->
	<?php include_once('./partials/Admin_incident_close_intervention.php');?>
<!-- /.Fin Modal gestion incident -->

<!-- Début Modal Compte utilisateur logic -->
	<!-- Modal création utilisateur logic -->
	<?php include_once('./partials/Admin_users_add_user.php');?>

	<!-- Modal Confirmation réinitialisation du compte utilisateur -->
	<?php include_once('./partials/Admin_users_reinit_user.php');?>

	<!-- Modal Confirmation activation/désactivation compte utilisateur -->
	<?php include_once('./partials/Admin_users_status_user.php');?>
<!-- Fin Modal Compte utilisateur logic -->

<!-- Début Modal archive logic -->
<?php include_once('./partials/Reception_infoarchive.php');?>
<!-- Fin Modal archive logic -->