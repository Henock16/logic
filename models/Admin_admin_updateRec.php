<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(!empty($_POST['upidrec'])){
		
		$query = $bdd -> prepare("UPDATE recolte SET DEBUT =:deb, FIN =:fin, CHANG_STAT = 0 WHERE ID_REC=:idrec");
		$query -> bindParam(':deb', $_POST['debut'], PDO::PARAM_STR);
		$query -> bindParam(':fin', $_POST['fin'], PDO::PARAM_STR);
		$query -> bindParam(':idrec', $_POST['upidrec'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();
		$tab[0] = 1;
	}	
	elseif(!empty($_POST['idrec'])){

		$query = $bdd ->prepare("UPDATE recolte SET STATUT = :state, CHANG_STAT = 0 WHERE ID_REC =:rec");
		$query -> bindParam(':state', $_POST['state'], PDO::PARAM_INT);
		$query -> bindParam(':rec', $_POST['idrec'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();		
		$tab[0] = 2;
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>