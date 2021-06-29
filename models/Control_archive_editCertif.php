<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	$tab[0] = 0;
	
	if(!empty($_POST['idcertif'])){
	
		include_once('../config/Connexion.php');
		include_once('../functions/Journalisation_function.php');
		
		$query = $bdd -> prepare("UPDATE certificat SET ERREUR = 1 WHERE ID_CERTIF = :certif");
		$query -> bindParam(':certif', $_POST['idcertif'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();
		
		Journalisation($_SESSION['ID_UTIL'],8,$_POST['idcertif'],0,$bdd);
		
		$tab[0] = 1;
		
		$bdd = null;
	
		/* Output header */
		header('Content-type: application/json');
		echo json_encode($tab);
	}	

?>