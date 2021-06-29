<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if( (isset($_POST['egreneur'])) && (!empty($_POST['egreneur'])) ){
		
		$egreneur = strtoupper($_POST['egreneur']);
		
		$query = $bdd -> prepare("SELECT COUNT(ID_EGRE) AS NB FROM egreneur WHERE LIBELLE=:egre");
		$query -> bindParam(':egre', $egreneur, PDO::PARAM_STR);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){
			
			$tab[0] = 1;
		}
		else{
			
			$tab[0] = 2;
			
			$query1 = $bdd -> prepare("INSERT INTO egreneur (LIBELLE) VALUES (:egre)");
			$query1 -> bindParam(':egre', $egreneur, PDO::PARAM_STR);
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