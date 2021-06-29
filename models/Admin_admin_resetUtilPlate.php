<?php
	include_once('../config/Connexion.php');

	$tab[0] = 0;

	if(!empty($_POST['idstruct'])){
		
		$query = $bdd -> prepare("UPDATE demandeur SET FIRST_CONNECTION = 0 , MOT_PASSE = 12345, CHANG_STAT = 0 WHERE ID_DEMAND = :util");
		$query -> bindParam(':util', $_POST['idstruct'], PDO::PARAM_INT);
		$query -> execute();	
		$query -> closeCursor();
		$tab[0] = 1;
	}	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>