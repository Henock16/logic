<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	include('../config/Connexion.php');
	
	$query = $bdd -> prepare("UPDATE utilisateur SET CONTACT =:cont, EMAIL =:mail, DATE_NAISSANCE =:dat, PREM_CONNEXION = 1, PASS=:pass WHERE ID_UTIL =:id");
	$query -> bindParam(':cont', $_POST['contact'], PDO::PARAM_STR);
	$query -> bindParam(':mail', $_POST['email'], PDO::PARAM_STR);
	$query -> bindParam(':dat', $_POST['birth'], PDO::PARAM_STR);
	$query -> bindParam(':pass', $_POST['new-password2'], PDO::PARAM_STR);
	$query -> bindParam(':id', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
	$query -> execute();
	$query->closeCursor();
	
	$bdd = null ;
	
	$result['0'] = 1 ;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($result) ;
?>