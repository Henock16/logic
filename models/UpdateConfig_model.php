<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

    $query = $bdd ->prepare(" UPDATE configuration SET VALEUR=:val WHERE ID_CONF=:conf");
	$query -> bindParam(':val', $_POST['valeur'], PDO::PARAM_INT);
	$query -> bindParam(':conf', $_POST['id_conf'], PDO::PARAM_INT);
	$query -> execute();
	$tab[0]=0;	
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>