<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(!empty($_POST['idstruct'])){
		
		$query1 = $bdd -> prepare("UPDATE demandeur SET STATUT_COMPTE = :state, CHANG_STAT = 0 WHERE ID_DEMAND = :demand");
		$query1 -> bindParam(':state', $_POST['state'], PDO::PARAM_INT);
		$query1 -> bindParam(':demand', $_POST['idstruct'], PDO::PARAM_INT);
		$query1 -> execute();
		$query1 -> closeCursor();
		$tab[0] = 1;
	}	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>