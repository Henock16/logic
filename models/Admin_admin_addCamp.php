<?php

	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(!empty($_POST['libel'])){
		
		$libel = strtoupper($_POST['libel']);
		
		$query = $bdd -> prepare("SELECT COUNT(ID_CAMP) AS NB FROM campagne WHERE LIBELLE=:libel");
		$query -> bindParam(':libel', $libel, PDO::PARAM_STR);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){			
			$tab[0] = 1;
		}
		else{
			
			$tab[0] = 2;
			
			$query1 = $bdd -> prepare("INSERT INTO campagne (LIBELLE, DEBUT, FIN, PRODUIT, DATE_CREATION) VALUES (:lib, :deb, :fin, :prod, NOW())");
			$query1 -> bindParam(':lib', $_POST['libel'], PDO::PARAM_STR);
			$query1 -> bindParam(':deb', $_POST['debut'], PDO::PARAM_STR);
			$query1 -> bindParam(':fin', $_POST['fin'], PDO::PARAM_STR);
			$query1 -> bindParam(':prod', $_POST['prodt'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
	}	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>