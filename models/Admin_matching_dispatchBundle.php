<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	include_once('../config/Connexion.php');
	include_once('../functions/Journalisation_function.php');
	
	$tab[0] = 0;

	if((isset($_POST['idmatch']))&&(!empty($_POST['idmatch']))){

		$tab[0] = 1;

		$query = $bdd -> prepare("UPDATE certificat SET STADE = 1 ,STATUT = 1 ,ID_USER_COUR=:user ,CHANG_STAT = 0 WHERE ID_CERTIF =:certif");
		$query -> bindParam(':user',$_POST['usermatch'], PDO::PARAM_INT);
		$query -> bindParam(':certif',$_POST['idmatch'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();
		
		$query1 = $bdd -> prepare("SELECT NOM, PRENOM, COMPTE FROM utilisateur WHERE ID_UTIL = :user");
		$query1 -> bindParam(':user',$_POST['usermatch'], PDO::PARAM_INT);
		$query1 -> execute();
		$data1 = $query1 -> fetch();
		
		$compte = $data1['COMPTE'];
		
		$query2 = $bdd -> prepare("SELECT COUNT(ID_TICKET) AS nb_tck FROM ticket WHERE ID_CERTIF=:certif");
		$query2 -> bindParam(':certif',$_POST['idmatch'], PDO::PARAM_INT);
		$query2 -> execute();
		$data2 = $query2 -> fetch();

		$compte += $data2['nb_tck'];
		
		$query2 -> closeCursor();
		
		$query3 = $bdd -> prepare("UPDATE utilisateur SET COMPTE =:ct WHERE ID_UTIL=:user");
		$query3 -> bindParam(':ct',$compte, PDO::PARAM_INT);
		$query3 -> bindParam(':user',$_POST['usermatch'], PDO::PARAM_INT);
		$query3 -> execute();
		$query3 -> closeCursor();
		
		Journalisation($_SESSION['ID_UTIL'],1,$_POST['idmatch'],$_POST['usermatch'],$bdd);

		$tab[1] = $data1['NOM'].' '.$data1['PRENOM'];
		
		$query1 -> closeCursor();
	}

	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>