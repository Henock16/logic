<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if( (isset($_POST['produit'])) && (!empty($_POST['produit'])) ){
		
		$produit = strtoupper($_POST['produit']);
		
		$query = $bdd -> prepare("SELECT COUNT(ID_PROD) AS NB FROM produit WHERE LIBELLE=:prod");
		$query -> bindParam(':prod', $produit, PDO::PARAM_STR);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){
			
			$tab[0] = 1;
		}
		else{
			
			$tab[0] = 2;
			
			$query1 = $bdd -> prepare("INSERT INTO produit (LIBELLE) VALUES (:prod)");
			$query1 -> bindParam(':prod', $produit, PDO::PARAM_STR);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
		$query -> closeCursor();
	}
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>