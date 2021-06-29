<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

 if( (isset($_POST['idrec'])) && (!empty($_POST['idrec'])) ){

 	$query = $bdd ->prepare("SELECT STATUT FROM recolte WHERE ID_REC=:rec");
	$query -> bindParam(':rec', $_POST['idrec'], PDO::PARAM_INT);
	$query -> execute();
	$data = $query -> fetch();
	
	$tab[0]=$_POST['idrec'];	
	$tab[1]=$data['STATUT'];
	
}
	
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>