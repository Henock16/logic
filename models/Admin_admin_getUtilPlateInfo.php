<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');

	$tab[0] = 0;
	$i = 1;
	
	if(!empty($_POST['idstruct'])){
		
		$query = $bdd -> prepare("SELECT STRUCTURE, CONTACT_RESPO, NUM_CC, ADRESSE_GEO FROM demandeur WHERE ID_DEMAND = :util");
		$query -> bindParam(':util', $_POST['idstruct'], PDO::PARAM_INT);
		$query -> execute();
		
		While($data = $query -> fetch()){
			
			$tab[$i] = $data['STRUCTURE'];
			$i++;
			$tab[$i] = $data['CONTACT_RESPO'];
			$i++;
			$tab[$i] = $data['NUM_CC'];
			$i++;
			$tab[$i] = $data['ADRESSE_GEO'];
			$i++;
		}
		$query -> closeCursor();
		
		$tab[0] = 1;
	}
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>