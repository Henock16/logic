<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	$i=0;
	if ($_SESSION['ROLE']==2){
		if($_SESSION['ID_VILLE'] == 1){
			$bke = 3;
		}else{
			$bke = 0;
		}
		$query = $bdd -> query("SELECT ID_VILLE, LIBELLE FROM ville WHERE ID_VILLE IN(".$_SESSION['ID_VILLE'].",".$bke.")");
	}
	elseif($_SESSION['ROLE']!=2){
		$query = $bdd -> query("SELECT ID_VILLE, LIBELLE FROM ville");
	}
	$rows=$query->rowCount();

	$tab[$i] = $rows;
	$i++;

	while($data = $query->fetch()){

		$tab[$i] = $data['ID_VILLE'];
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