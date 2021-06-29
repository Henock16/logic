<?php

	include_once('../config/Connexion.php');

	$tab[0] = 0;

	if((isset($_POST['iduser']))&&(!empty($_POST['iduser']))){
		
		$query = $bdd -> prepare("UPDATE utilisateur SET PREM_CONNEXION = 0, PASS = 12345 WHERE ID_UTIL=:util");
		$query -> bindParam(':util', $_POST['iduser'], PDO::PARAM_INT);
		$query -> execute();	
		$query -> closeCursor();
		
		$tab[0] = 1;
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>