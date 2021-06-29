<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	$i=0;
	
	$query = $bdd -> prepare("SELECT ID_CONF, LIBELLE, VALEUR FROM configuration WHERE ID_CONF=:conf");
	$query -> bindParam(':conf', $_POST['id_conf'], PDO::PARAM_INT);
	$query -> execute();
	$data = $query->fetch();
	if($data['ID_CONF']==1||$data['ID_CONF']==2){
		$tab[$i]=0;
		$i++;
	}
	else{
		$tab[$i]=1;
		$i++;
	}
	$tab[$i] = $data['ID_CONF'];
	$i++;
	$tab[$i] = $data['LIBELLE'];
	$i++;
	$tab[$i] = $data['VALEUR'];
	$i++;
	$query->closeCursor();	

	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>