<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	$i=0;
	
	$query = $bdd -> query("SELECT IDENTIFIANT, LIBELLE FROM poste_travail WHERE STATUT =0 ");
	$rows=$query->rowCount();

	$tab[$i] = $rows;
	$i++;

	while($data = $query->fetch()){

		$tab[$i] = $data['IDENTIFIANT'];
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