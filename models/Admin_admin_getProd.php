<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');

	$i = 0 ;
	$tab[0] = 0;
	$i++;
	
	if(!empty($_POST['idprod'])){
		
		$tab[0] = 1;
		
		$query6 = $bdd ->prepare("SELECT LIBELLE FROM produit WHERE ID_PROD =:idprod");
		$query6 -> bindParam(':idprod', $_POST['idprod'], PDO::PARAM_INT);
		$query6 -> execute();
		
		while($data6 = $query6->fetch()){
		
			$tab[$i]= $data6['LIBELLE'];
			$i++;
		}
		$query6 -> closeCursor();
	}
	else{
		
		$query = $bdd -> query("SELECT COUNT(ID_PROD) AS NB FROM produit");
		$data = $query -> fetch();
		
		$tab[$i] = $data['NB'];
		$i++;
		
		$query -> closeCursor();

		$query1 = $bdd -> query("SELECT ID_PROD, LIBELLE, DISABLED, DATE_CREATION FROM produit");

		while($data1 = $query1 -> fetch()){

			$tab[$i] = $data1['ID_PROD'];
			$i++;
			$tab[$i] = $data1['LIBELLE'];
			$i++;
			$tab[$i] = $data1['DISABLED'];
			$i++;
			$datedit = new DateTime($data1['DATE_CREATION']);				
			$tab[$i] = $datedit->format('d/m/Y à H : i : s');
			$i++;
		}

		$query1 -> closeCursor();
		$tab[$i] = $_SESSION['ROLE'];
	}
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>