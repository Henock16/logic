<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');
	include_once('../functions/Journalisation_function.php');

	$i = 0 ;
	$tab[0] = 0;

	if(!(empty($_POST['idcert']))){

		$query = $bdd -> prepare("SELECT STATUT FROM certificat WHERE ID_CERTIF =:id");
		$query -> bindParam(':id', $_POST['idcert'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();

		if($data['STATUT'] == 2){

			$tab[0] = 1;
			$i++;

			$query1 = $bdd -> prepare("UPDATE certificat SET STATUT = 4, AUTH_CERTIF = 0 WHERE ID_CERTIF =:id");
			$query1 -> bindParam(':id', $_POST['idcert'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
			Journalisation($_SESSION['ID_UTIL'],5,$_POST['idcert'],0,$bdd);
		}
		elseif($data['STATUT'] != 2){
			$tab[0] = 2;
			$i++;
		}
		$query -> closeCursor();
	}
			
	$bdd = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>