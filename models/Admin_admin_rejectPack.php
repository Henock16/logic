<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	include_once('../functions/Journalisation_function.php');
	
	$tab[0] = 0;
	
	if( (isset($_POST['idcert'])) && (!empty($_POST['idcert'])) ){
		
		$tab[0] = 1;
		
		$query1 = $bdd -> prepare("SELECT STATUT FROM certificat WHERE ID_CERTIF=:certif");
		$query1 -> bindParam(':certif', $_POST['idcert'], PDO::PARAM_INT);
		$query1 -> execute();	
		$data1 = $query1 -> fetch();

		$val_prec = $data1['STATUT'];
		$query1 -> closeCursor();

		$query = $bdd -> prepare("UPDATE certificat SET STATUT = 3, CHANG_STAT = 0 WHERE ID_CERTIF=:certif");
		$query -> bindParam(':certif', $_POST['idcert'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();

		Journalisation($_SESSION['ID_UTIL'],4,$_POST['idcert'],$val_prec,$bdd);
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>