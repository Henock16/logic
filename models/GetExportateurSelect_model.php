<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

	$i =0 ;

	$count= $bdd ->query("SELECT COUNT(DISTINCT(ID_EXP)) AS nb_exp FROM exportateur WHERE ID_EXP IN(SELECT ID_EXP FROM agrement)");
	$data_count = $count->fetch();
	$tab[$i]= $data_count['nb_exp'];
	$i++;
	$count -> closeCursor();

	$query = $bdd ->query("SELECT DISTINCT(ID_EXP) AS EXP, LIBELLE FROM exportateur WHERE ID_EXP IN(SELECT ID_EXP FROM agrement)");
	while($data = $query->fetch()){

		$tab[$i]= $data['EXP'];
		$i++;
		$tab[$i]= $data['LIBELLE'];
		$i++;
	}
	$query -> closeCursor();
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
	?>