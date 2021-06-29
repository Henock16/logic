<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');

	$tab[0] = 0;
	$i = 1;

	if($_SESSION['ROLE'] == 2){
		if($_SESSION['ID_VILLE'] == 1){
			$bke = 3;
		}else{
			$bke = 0;
		}

		$query = $bdd -> query("SELECT ID_DEMAND, LOGIN, STRUCTURE, NOM_RESPO, FONCTION_RESPO, VILLE, STATUT_COMPTE FROM demandeur WHERE VILLE IN(".$_SESSION['ID_VILLE'].",".$bke.")");
		$tab[$i] = $query -> rowCount();
		$i++;
	}
	elseif($_SESSION['ROLE'] != 2){

		$query = $bdd -> query("SELECT ID_DEMAND, LOGIN, STRUCTURE, NOM_RESPO, FONCTION_RESPO, VILLE, STATUT_COMPTE FROM demandeur");
		$tab[$i] = $query -> rowCount();
		$i++;
	}

	while($data = $query -> fetch()){

		$tab[$i] = $data['ID_DEMAND'];
		$i++;
		$tab[$i] = $data['LOGIN'];
		$i++;
		$tab[$i] = $data['STRUCTURE'];
		$i++;
		$tab[$i] = $data['NOM_RESPO'];
		$i++;
		$tab[$i] = $data['FONCTION_RESPO'];
		$i++;

		$query1 = $bdd -> prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE = :vil");
		$query1 -> bindParam(':vil', $data['VILLE'], PDO::PARAM_INT);
		$query1 -> execute();
		$data2 = $query1 -> fetch();
		
		$tab[$i] = $data2['LIBELLE'];
		$i++;
		$tab[$i]= $data['STATUT_COMPTE'];
		$i++;
		
		$query1 -> closeCursor();
	}
	$query -> closeCursor();
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>