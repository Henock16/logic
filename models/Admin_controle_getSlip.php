<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

	$i = 0 ;
	$tab[0] = 0;

	if($_SESSION['ROLE'] == 2){

		if($_SESSION['ID_VILLE'] == 1){
			$bke = 3;
		}else{
			$bke = 0;
		}

		$query = $bdd -> prepare("SELECT ID_BORD, ID_USER FROM bordereau,utilisateur WHERE ID_USER = ID_UTIL AND (ID_VILLE = :ville OR ID_VILLE=:ville2) AND STATUT = 1 AND STADE = 1 AND ID_BORD NOT IN (SELECT CIBLE FROM journal WHERE ACTION = 2)");
		$query -> bindParam(':ville', $_SESSION['ID_VILLE'], PDO::PARAM_INT);
    	$query -> bindParam(':ville2', $bke, PDO::PARAM_INT);
    	$query -> execute();
		$tab[$i] = $query -> rowCount();
		$i++;
	}
	else{
		
		$query = $bdd -> query("SELECT ID_BORD, ID_USER FROM bordereau WHERE STATUT = 1 AND STADE = 1 AND ID_BORD NOT IN (SELECT CIBLE FROM journal WHERE ACTION = 2)");
		
		$tab[$i] = $query -> rowCount();
		$i++;
	}

	while($data = $query -> fetch()){
		
		$ct = 0;
		$tck = 0;
		$pn = 0;
		
		$tab[$i] = $data['ID_BORD'];
		$i++;
		
		$query1 = $bdd -> prepare("SELECT ID_CERTIF FROM certif_bord WHERE ID_BORD =:bd");
		$query1 -> bindParam(':bd', $data['ID_BORD'], PDO::PARAM_INT);
		$query1 -> execute();

		while($data1 = $query1 -> fetch()){
			
			$ct += 1;
			
			$query2 = $bdd -> prepare("SELECT POIDS_NET FROM ticket WHERE ID_CERTIF =:certif");
			$query2 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
			$query2 -> execute();
			
			$tck += $query2 -> rowCount();
			
			while($data2 = $query2 -> fetch()){
				
				$pn += $data2['POIDS_NET'];
			}			
			$query2 -> closeCursor();
		}
		$query1 -> closeCursor();
		
		$tab[$i] = $ct;
		$i++;
		$tab[$i] = $tck;
		$i++;
		$tab[$i] = $pn;
		$i++;
		
		$query3 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL =:util");
		$query3 -> bindParam(':util', $data['ID_USER'], PDO::PARAM_INT);
		$query3 -> execute();
		$data3 = $query3 -> fetch();
		
		$tab[$i] = $data3['NOM'].' '.$data3['PRENOM'];
		$i++;
		
		$query3 -> closeCursor();
		
		$query4 = $bdd -> prepare("SELECT DATE_CREATION FROM certif_bord WHERE ID_BORD =:bd ORDER BY DATE_CREATION DESC LIMIT 1");
		$query4 -> bindParam(':bd', $data['ID_BORD'], PDO::PARAM_INT);
		$query4 -> execute();
		$data4 = $query4 -> fetch();
		
		$datedit = new DateTime($data4['DATE_CREATION']);				
		$tab[$i] = $datedit -> format('d/m/Y à H : i : s');
		$i++;
		
		$query4 -> closeCursor();
	}
	$query -> closeCursor();

	$bdd = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>