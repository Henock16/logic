<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	
	$i = 0;
	
	$query = $bdd -> prepare("SELECT ID_CAMP, LIBELLE FROM campagne WHERE STATUT = 0 AND PRODUIT=:prod");
	$query -> bindParam(':prod', $_POST['idprod'], PDO::PARAM_INT);
	$query -> execute();
	$rows=$query->rowCount();

	$tab[$i] = $rows;
	$i++;

	while($data = $query->fetch()){

		$tab[$i] = $data['ID_CAMP'];
		$i++;
		$tab[$i] = $data['LIBELLE'];
		$i++;
	}
	$query->closeCursor();


	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>