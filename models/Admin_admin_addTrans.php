<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if( (isset($_POST['trans'])) && (!empty($_POST['trans'])) ){
		
		$libel = strtoupper($_POST['trans']);
		
		$query = $bdd ->prepare("SELECT COUNT(ID_TRANSIT) AS NB FROM transitaire WHERE LIBELLE=:libel");
		$query -> bindParam(':libel', $libel, PDO::PARAM_STR);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){
			
			$tab[0] = 1;
		}
		else{
			
			$tab[0] = 2;
			
			$query1 = $bdd ->prepare("INSERT INTO transitaire (LIBELLE) VALUE (:lib)");
			$query1 -> bindParam(':lib', $libel, PDO::PARAM_INT);
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