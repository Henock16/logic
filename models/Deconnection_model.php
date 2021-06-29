<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include('../config/Connexion.php');
	
	$query = $bdd -> prepare("UPDATE utilisateur SET DERN_ACTION = 0 WHERE ID_UTIL=:id");
	$query -> bindParam(':id', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
	$query -> execute();
	$query -> closeCursor();
	
	$resultat = 1 ;
	
	$_SESSION = array();
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($resultat);
?>