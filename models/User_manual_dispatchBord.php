<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	include_once('../config/Connexion.php');
	include_once('../functions/Dispatching_function.php');
	
	$query = $bdd -> prepare("SELECT ID_BORD, STADE FROM bordereau WHERE STATUT = 0 AND ID_USER =:user");
	$query -> bindParam(':user', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
	$query -> execute();
	$data = $query -> fetch();
	
	$result = Dispatching($data['ID_BORD'],($data['STADE'] + 1),$_SESSION['ID_UTIL'],$_SESSION['ID_VILLE'],$bdd);
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($result);
?>