<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(!empty($_POST['libel'])){
		
		$libel = strtoupper($_POST['libel']);
		
		$query = $bdd ->prepare("SELECT COUNT(ID_REC) AS NB FROM recolte WHERE LIBELLE=:libel");
		$query -> bindParam(':libel', $libel, PDO::PARAM_STR);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){			
			$tab[0] = 1;
		}
		else{
			
			$query = $bdd ->prepare("INSERT INTO recolte (LIBELLE, DEBUT, FIN, PRODUIT, DATE_CREATION) VALUES (:lib, :deb, :fin, :prod, NOW())");
			$query -> bindParam(':lib', $_POST['libel'], PDO::PARAM_STR);
			$query -> bindParam(':deb', $_POST['debut'], PDO::PARAM_STR);
			$query -> bindParam(':fin', $_POST['fin'], PDO::PARAM_STR);
			$query -> bindParam(':prod', $_POST['prodt'], PDO::PARAM_INT);
			$query -> execute();
			$query -> closeCursor();
			$tab[0] = 2;
		}
	}
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>