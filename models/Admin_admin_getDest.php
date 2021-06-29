<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');

	$i = 0 ;
	$tab[0] = 0;
	$i++;
	
	if(!empty($_POST['iddest'])){
		
		$tab[0] = 1;
		
		$query6 = $bdd -> prepare("SELECT PAYS, PORT FROM destination WHERE ID_DEST =:iddest");
		$query6 -> bindParam(':iddest', $_POST['iddest'], PDO::PARAM_INT);
		$query6 -> execute();
		
		while($data6 = $query6 -> fetch()){
		
			$tab[$i]= $data6['PAYS'];
			$i++;
			$tab[$i]= $data6['PORT'];
			$i++;
		}
		$query6 -> closeCursor();
	}
	else{

		$query = $bdd -> query("SELECT COUNT(ID_DEST) AS nb_dest FROM destination");
		$data = $query -> fetch();
		
		$tab[$i] = $data['nb_dest'];
		$i++;
		
		$query -> closeCursor();

		$query1 = $bdd -> query("SELECT ID_DEST, PORT, PAYS, STATUT, DATE_CREATION FROM destination");

		while($data1 = $query1 -> fetch()){

			$tab[$i] = $data1['ID_DEST'];
			$i++;
			$tab[$i] = $data1['PAYS'];
			$i++;
			$tab[$i] = $data1['PORT'];
			$i++;
			$tab[$i] = $data1['STATUT'];
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