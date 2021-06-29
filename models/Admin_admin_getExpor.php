<?php

	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');

	$tab[0] = 0;
	$tab[1] = 0;
	$i = 2 ;

	$query = $bdd -> query("SELECT ID_EXP, PRODUIT, LIBELLE, STATUT FROM exportateur");
	
	while($data = $query -> fetch()){

		$query1 = $bdd -> prepare("SELECT ID_EXP, CODE, ID_CAMP, DATE_CREATION FROM agrement WHERE ID_EXP=:exp AND STATUT = 0 ORDER BY DATE_CREATION DESC LIMIT 1");
		$query1 -> bindParam(':exp', $data['ID_EXP'], PDO::PARAM_INT);
		$query1 -> execute();
		$tab[1] += $query1 -> rowCount();

		while($data1 = $query1 -> fetch()){

			$tab[$i] = $data1['ID_EXP'];
			$i++;
			$tab[$i] = $data['LIBELLE'];
			$i++;

			$query2 = $bdd -> prepare("SELECT LIBELLE FROM produit WHERE ID_PROD =:prod");
			$query2 -> bindParam(':prod', $data['PRODUIT'], PDO::PARAM_INT);
			$query2 -> execute();
			$data2 = $query2->fetch();
			
			$tab[$i] = $data2['LIBELLE'];
			$i++;
			
			$query2 -> closeCursor();

			$query3= $bdd ->prepare("SELECT LIBELLE FROM campagne WHERE ID_CAMP =:camp");
			$query3 -> bindParam(':camp', $data1['ID_CAMP'], PDO::PARAM_INT);
			$query3 -> execute();
			$data3 = $query3->fetch();
			
			$tab[$i]= $data3['LIBELLE'];
			$i++;
			
			$query3 -> closeCursor();

			$tab[$i]= $data1['CODE'];
			$i++;
			
			$datedit = new DateTime($data1['DATE_CREATION']);				
			$tab[$i] = $datedit->format('d/m/Y à H : i : s');
			$i++;
			
			$tab[$i]= $data['STATUT'];
			$i++;
		}
		$query1 -> closeCursor();
	}
	$query -> closeCursor();
	$tab[$i] = $_SESSION['ROLE'];
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>