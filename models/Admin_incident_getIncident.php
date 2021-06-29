<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');

	$tab[0] = 0;
	$i = 0;

	if($_SESSION['ROLE'] == 2){
		if($_SESSION['ID_VILLE'] == 1){
			$bke = 3;
		}else{
			$bke = 0;
		}

		$query = $bdd -> query("SELECT ID_CERTIF, NUM_PCKLIST, STADE, NUM_CERTIF, STATUT, A_R, ERREUR, ID_USER_COUR, ID_DEMANDEUR, ID_TYPPROD, ID_VILLE FROM certificat WHERE (A_R IN (3,4) OR ERREUR = 1) AND BLOCKED = 0 AND DISABLED = 0 AND ID_VILLE IN(".$_SESSION['ID_VILLE'].",".$bke.") ORDER BY DATE_CREATION DESC");
		
		$tab[$i] = $query -> rowCount();
		$i++;		
	}
	else if($_SESSION['ROLE'] != 2){
		
		$query = $bdd -> query("SELECT ID_CERTIF, NUM_PCKLIST, STADE, NUM_CERTIF, STATUT, ID_TYPPROD, ID_VILLE FROM certificat WHERE (A_R IN (3,4) OR ERREUR = 1) AND BLOCKED = 0 AND DISABLED = 0 ORDER BY DATE_CREATION DESC");
		
		$tab[$i] = $query -> rowCount();
		$i++;
	}	

	while($data = $query -> fetch()){

		$tab[$i]= $data['ID_CERTIF'];
		$i++;
		
		if($data['STATUT'] == 2 || $data['STATUT'] == 4 ){			
			$tab[$i] = $data['NUM_CERTIF'];
		}
		else{
			$tab[$i] = $data['NUM_PCKLIST'];
		}		
		$i++;
		
		$query1 = $bdd -> prepare("SELECT COUNT(ID_TICKET) AS NB FROM ticket WHERE ID_CERTIF =:certif");
		$query1 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
		$query1 -> execute();
		$data1 = $query1 -> fetch();
		
		$tab[$i] = $data1['NB'];
		$i++;
		
		$query1 -> closeCursor();
		
		$query2 = $bdd -> prepare("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =:typprod");
		$query2 -> bindParam(':typprod', $data['ID_TYPPROD'], PDO::PARAM_INT);
		$query2 -> execute();
		$data2 = $query2 -> fetch();
		
		$tab[$i] = $data2['LIBELLE'];
		$i++;
		
		$query2 -> closeCursor();
		
		$pn = 0;
		$query3 = $bdd -> prepare("SELECT POIDS_NET FROM ticket WHERE ID_CERTIF =:certif");
		$query3 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
		$query3 -> execute();
		
		while($data3 = $query3 -> fetch()){
			
			$pn += $data3['POIDS_NET'];
		}
		$query3 -> closeCursor();
		
		$tab[$i] = $pn;
		$i++;
		
		$query4 = $bdd -> prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
		$query4 -> bindParam(':vil', $data['ID_VILLE'], PDO::PARAM_INT);
		$query4 -> execute();
		$data4 = $query4 -> fetch();
		
		$tab[$i]= $data4['LIBELLE'];
		$i++;
		
		$query4 -> closeCursor();
		
		$tab[$i] = $data['STADE'];
		$i++;
	}
	$query -> closeCursor();

	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>