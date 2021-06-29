<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	include('../config/Connexion.php');

	$query = $bdd -> prepare("SELECT ID_CERTIF, NUM_PCKLIST FROM certificat WHERE A_R IN(0,2) AND STATUT <> 3 AND DISABLED = 0 AND BLOCKED = 0 AND ERREUR = 0 AND STADE<>7 AND ID_USER_COUR=:util ORDER BY DATE_CREATION ");
	$query -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
	$query -> execute();
	$rows = $query -> rowCount();
	
	$i = 0;
	$tab[$i] = $rows ;
	$i++ ;
	
	if($rows >= 1){
		
		while ($data = $query -> fetch()){
			
			$tab[$i] = $data['NUM_PCKLIST'];
			$i++;
			
			$query1 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK FROM ticket WHERE ID_CERTIF=:certif");
			$query1 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
			$query1 -> execute();	
			
			while ($data1 = $query1->fetch()){
				
				$tab[$i] = $data1['NB_TK'];
				$i++;
			}
			$query1->closeCursor();
		}
	}
	$query->closeCursor();
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>