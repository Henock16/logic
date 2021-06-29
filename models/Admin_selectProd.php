<?php
	include_once('../config/Connexion.php');
	
	$i = 0;
	
	$query = $bdd -> query("SELECT ID_PROD, LIBELLE FROM produit WHERE DISABLED = 0");
	$tab[$i] = $query -> rowCount();
	$i++;

	while($data = $query->fetch()){

		$tab[$i] = $data['ID_PROD'];
		$i++;
		$tab[$i] = $data['LIBELLE'];
		$i++;
	}
	$query->closeCursor();	

	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>