<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

	$tab[0]=0;

 if( (isset($_POST['idutil'])) && (!empty($_POST['idutil'])) ){

    $query = $bdd ->prepare(" UPDATE utilisateur SET DISABLED=1 WHERE ID_UTIL=:util");
	$query -> bindParam(':util', $_POST['idutil'], PDO::PARAM_INT);
	$query -> execute();	

	$tab[0]=1;
}
	
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>