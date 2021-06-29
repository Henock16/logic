<?php
	include_once('../config/Connexion.php');
	
	if((isset($_POST['idexpor'])) && (!empty($_POST['idexpor']))){
		
		$i = 0;
		
		$query1 = $bdd -> prepare("SELECT LIBELLE, PRODUIT FROM exportateur WHERE ID_EXP=:idexp");
		$query1 -> bindParam(':idexp', $_POST['idexpor'], PDO::PARAM_INT);
		$query1 -> execute();
		$data1 = $query1 -> fetch();
		
		$tab[$i] = $data1['LIBELLE'];
		$i++;
		
		$query3 = $bdd -> prepare("SELECT LIBELLE FROM produit WHERE ID_PROD=:prod");
		$query3 -> bindParam(':prod', $data1['PRODUIT'], PDO::PARAM_INT);
		$query3 -> execute();
		$data3 = $query3 -> fetch();
		
		$tab[$i] = $data3['LIBELLE'];
		$i++;
	
		$query2 = $bdd -> prepare("SELECT ID_CAMP, LIBELLE FROM campagne WHERE PRODUIT=:prod AND STATUT = 0");
		$query2 -> bindParam(':prod', $data1['PRODUIT'], PDO::PARAM_INT);
		$query2 -> execute();
	
		while($data2 = $query2 -> fetch()){

			$tab[$i] = $data2['ID_CAMP'];
			$i++;
			$tab[$i] = $data2['LIBELLE'];
			$i++;
		}
		
		$query1 -> closeCursor();
		$query3 -> closeCursor();
		$query2 -> closeCursor();
	}
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>