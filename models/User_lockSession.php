<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	include('../config/Connexion.php');
 
	$query = $bdd -> prepare("SELECT ID_UTIL FROM utilisateur WHERE PASS=:mp AND ID_UTIL=:util");
	$query -> bindParam(':mp', $_POST['pass'], PDO::PARAM_STR);
	$query -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
	$query -> execute();
	$rows = $query -> rowCount();
	$query->closeCursor();
	
	if($rows > 0){

		$result['0'] = 1 ;		
	}	
	else{

		$result['0'] = 0 ;
	}
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($result) ;
?>