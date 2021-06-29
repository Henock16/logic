<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');

	$i = 0 ;
	if($_SESSION['ROLE'] == 2){
		if($_SESSION['ID_VILLE'] == 1){
			$bke = 3;
		}else{
			$bke = 0;
		}
		$query = $bdd -> query("SELECT ID_UTIL, LOGIN, STAT_COMPTE, NOM, PRENOM, TYPE_COMPTE, MATRICULE, ID_VILLE FROM utilisateur WHERE TYPE_COMPTE <> 0 AND DISABLED = 0 AND ID_VILLE IN(".$_SESSION['ID_VILLE'].",".$bke.")");
		$tab[$i] = $query -> rowCount();
		$i++;		
	}
	elseif($_SESSION['ROLE'] != 2){
		
		$query = $bdd -> query("SELECT ID_UTIL, LOGIN, STAT_COMPTE, NOM, PRENOM, TYPE_COMPTE, MATRICULE, ID_VILLE FROM utilisateur WHERE TYPE_COMPTE <> 0 AND DISABLED = 0");
		$tab[$i] = $query -> rowCount();
		$i++;
	}	

	while($data = $query -> fetch()){

		$tab[$i] = $data['ID_UTIL'];
		$i++;
		$tab[$i] = $data['NOM'];
		$i++;
		$tab[$i] = $data['PRENOM'];
		$i++;
		$tab[$i] = $data['LOGIN'];
		$i++;
		$tab[$i] = $data['MATRICULE'];
		$i++;
		$tab[$i] = $data['TYPE_COMPTE'];
		$i++;

		$query1 = $bdd -> prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
		$query1 -> bindParam(':vil', $data['ID_VILLE'], PDO::PARAM_INT);
		$query1 -> execute();
		$data1 = $query1 -> fetch();
		
		$tab[$i] = $data1['LIBELLE'];
		$i++;
		
		$query1 -> closeCursor();
		
		$tab[$i] = $data['STAT_COMPTE'];
		$i++;
	}
	$query -> closeCursor();

	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
	
?>