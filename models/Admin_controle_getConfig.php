<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	$i = 1;
	
	if($_SESSION['ROLE'] > 1){
		
		$query = $bdd -> query("SELECT ID_CONF, LIBELLE, VALEUR, VILLE FROM configuration WHERE PORTEE = 2 AND VILLE =".$_SESSION['ID_VILLE']);
	}
	else{
		$query = $bdd -> query("SELECT ID_CONF, LIBELLE, VALEUR, VILLE FROM configuration WHERE PORTEE = 2");
	}
	
	while($data = $query -> fetch()){
		
		$tab[0] += 1;
		
		$tab[$i] = $data['ID_CONF'];
		$i++;
		$tab[$i] = $data['LIBELLE'];
		$i++;
		
		if($data['ID_CONF'] == 1 || $data['ID_CONF'] == 2 ||$data['ID_CONF'] == 10 ||$data['ID_CONF'] == 11){
			
			if($data['VALEUR'] == 0){

				$tab[$i] = 'Manuel';
				$i++;
			}
			elseif($data['VALEUR'] == 1){

				$tab[$i] = 'Automatique';
				$i++;
			}
		}
		else{
			$tab[$i] = $data['VALEUR'];
			$i++;
		}
		
		if($data['VILLE'] == 0){
			$tab[$i] = 'Global';
			$i++;
		}
		else{
			$query1 = $bdd -> query("SELECT LIBELLE FROM ville WHERE ID_VILLE =".$data['VILLE']);
			$data1 = $query1 -> fetch();
			
			$tab[$i] = $data1['LIBELLE'];
			$i++;
			
			$query1 -> closeCursor();
		}
	}
	$query -> closeCursor();

	$bdd = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>