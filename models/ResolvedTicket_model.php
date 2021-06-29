<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	
	$i=0;
	$tab[$i]=0;
	$i++;

	$query1 = $bdd -> prepare("UPDATE erreur SET RESOLVED=2 WHERE ID_TICKET=:tckt AND RESOLVED=1");
	$query1 -> bindParam(':tckt',$_POST['val'], PDO::PARAM_INT);
	$query1 -> execute();

	$query2 = $bdd -> prepare("SELECT ID_CERTIF FROM erreur WHERE ID_TICKET=:tckt");
	$query2 -> bindParam(':tckt',$_POST['val'], PDO::PARAM_INT);
	$query2 -> execute();
	$data2 = $query2 -> fetch();

	$tab[$i] = $data2['ID_CERTIF'];
	$i++;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>