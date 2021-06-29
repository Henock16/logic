<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	include_once('../functions/Date_management_function.php');

	$i = 0 ;
	$tab[0] = 0;
	$i++;

	if(!empty($_POST['idtrans'])){
		
		$tab[0] = 1;
		
		$query6 = $bdd ->prepare("SELECT LIBELLE FROM transitaire WHERE ID_TRANSIT =:idtrans");
		$query6 -> bindParam(':idtrans', $_POST['idtrans'], PDO::PARAM_INT);
		$query6 -> execute();
		
		while($data6 = $query6->fetch()){
		
			$tab[$i]= $data6['LIBELLE'];
			$i++;
			
			$query6 -> closeCursor();
		}
	}
	else{
		
		$query = $bdd ->query("SELECT COUNT(ID_TRANSIT) AS nb_trans FROM transitaire ");
		$data = $query->fetch();
		
		$tab[$i] = $data['nb_trans'];
		$i++;
		
		$query -> closeCursor();

		$query1 = $bdd ->query("SELECT ID_TRANSIT, LIBELLE, DISABLED, DATE_CREATION FROM transitaire");

		while($data1 = $query1->fetch()){

			$tab[$i]= $data1['ID_TRANSIT'];
			$i++;
			$tab[$i]= $data1['LIBELLE'];
			$i++;
			$tab[$i]= $data1['DISABLED'];
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