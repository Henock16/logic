<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(!empty($_POST['upidcamp'])){
		
		$query = $bdd ->prepare("UPDATE campagne SET DEBUT =:deb, FIN =:fin, CHANG_STAT=0 WHERE ID_CAMP = :camp");
		$query -> bindParam(':deb', $_POST['debut'], PDO::PARAM_STR);
		$query -> bindParam(':fin', $_POST['fin'], PDO::PARAM_STR);
		$query -> bindParam(':camp', $_POST['upidcamp'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();		
		$tab[0] = 1;
	}
	elseif(!empty($_POST['idcamp'])){

		$query = $bdd -> prepare("UPDATE campagne SET STATUT = :state, CHANG_STAT = 0 WHERE ID_CAMP = :camp");
		$query -> bindParam(':state', $_POST['state'], PDO::PARAM_INT);
		$query -> bindParam(':camp', $_POST['idcamp'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();
		$tab[0] = 2;
	}
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>