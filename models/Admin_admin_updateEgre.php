<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

	if( (isset($_POST['upidegre'])) && (!empty($_POST['upidegre'])) ){
		
		$egre = strtoupper($_POST['egre']);
		
		$query = $bdd ->prepare("SELECT COUNT(ID_EGRE) AS NB FROM egreneur WHERE LIBELLE=:egre AND ID_EGRE <>:idegre");
		$query -> bindParam(':egre', $egre, PDO::PARAM_STR);
		$query -> bindParam(':idegre', $_POST['upidegre'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){
			
			$tab[0] = 0;
		}
		else{
			
			$tab[0] = 1;
			$query1 = $bdd ->prepare("UPDATE egreneur SET LIBELLE = :egre, CHANG_STAT = 0 WHERE ID_EGRE = :idegre");
			$query1 -> bindParam(':egre', $egre, PDO::PARAM_STR);
			$query1 -> bindParam(':idegre', $_POST['upidegre'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();			
		}
	}

	if( (isset($_POST['idegre'])) && (!empty($_POST['idegre'])) ){

		$query = $bdd ->prepare("SELECT STATUT FROM egreneur WHERE ID_EGRE=:egr");
		$query -> bindParam(':egr', $_POST['idegre'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['STATUT'] == 0){
			
			$tab[0] = 2;
			$query1 = $bdd ->prepare("UPDATE egreneur SET STATUT = 1,CHANG_STAT = 0 WHERE ID_EGRE=:egr");
			$query1 -> bindParam(':egr', $_POST['idegre'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
		elseif($data['STATUT'] == 1){
			
			$tab[0] = 3;
			$query1 = $bdd ->prepare("UPDATE egreneur SET STATUT = 0, CHANG_STAT = 0 WHERE ID_EGRE=:egr");
			$query1 -> bindParam(':egr', $_POST['idegre'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
		$query -> closeCursor();			
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>