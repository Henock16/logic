<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

	$tab[0] = 0;
	$i = 1 ;

	if($_SESSION['ROLE'] == 2){

		if($_SESSION['ID_VILLE'] == 1){
			$bke = 3;
		}else{
			$bke = 0;
		}

		$query = $bdd -> query("SELECT COUNT(ID_CERTIF) AS nb_certif FROM certificat WHERE STADE = 0 AND STATUT = 0 AND BLOCKED = 0 AND ERREUR = 0 AND A_R <> 1 AND DISABLED = 0 AND ID_VILLE IN(".$_SESSION['ID_VILLE'].",".$bke.")");
		$data = $query -> fetch();
		
		$tab[$i] = $data['nb_certif'];
		$i++;
		
		$query -> closeCursor();

		$query1 = $bdd -> query("SELECT ID_CERTIF, NUM_PCKLIST, ID_TYPPROD, ID_VILLE, DATE_CREATION FROM certificat WHERE STADE = 0 AND STATUT = 0 AND BLOCKED = 0 AND ERREUR = 0 AND A_R <> 1 AND DISABLED = 0 AND ID_VILLE IN(".$_SESSION['ID_VILLE'].",".$bke.")");
	}
	elseif($_SESSION['ROLE'] != 2){
		
		$query = $bdd -> query("SELECT COUNT(ID_CERTIF) AS nb_certif FROM certificat WHERE STADE = 0 AND STATUT =0 AND BLOCKED = 0 AND ERREUR = 0 AND A_R <> 1 AND DISABLED = 0");
		$data = $query -> fetch();
		
		$tab[$i] = $data['nb_certif'];
		$i++;
		
		$query -> closeCursor();

		$query1 = $bdd ->query("SELECT ID_CERTIF, NUM_PCKLIST, ID_TYPPROD, ID_VILLE, DATE_CREATION FROM certificat WHERE STADE = 0 AND STATUT =0 AND BLOCKED = 0 AND ERREUR = 0 AND A_R <> 1 AND DISABLED = 0");
	}
	
	while($data1 = $query1 -> fetch()){

		$tab[$i] = $data1['ID_CERTIF'];
		$i++;
		$tab[$i] = $data1['NUM_PCKLIST'];
		$i++;
		
		$query9 = $bdd -> prepare("SELECT COUNT(ID_TICKET) AS NB FROM ticket WHERE ID_CERTIF =:certif");
		$query9 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
		$query9 -> execute();
		$data9 = $query9 -> fetch();
		$tab[$i] = $data9['NB'];
		$i++;
		
		$query9 -> closeCursor();
		
		$query5 = $bdd -> prepare("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =:prod");
		$query5 -> bindParam(':prod', $data1['ID_TYPPROD'], PDO::PARAM_INT);
		$query5 -> execute();
		$data5 = $query5 -> fetch();
		
		$tab[$i] = $data5['LIBELLE'];
		$i++;
		
		$query5 -> closeCursor();
		
		$poids = 0;
		$query8 = $bdd -> prepare("SELECT POIDS_NET FROM ticket WHERE ID_CERTIF =:certif");
		$query8 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
		$query8 -> execute();
		while($data8 = $query8 -> fetch()){

			$poids += $data8['POIDS_NET'];
		}
		$tab[$i] = $poids;
		$i++;
		$query8 -> closeCursor();
		
		$query2 = $bdd -> prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
		$query2 -> bindParam(':vil', $data1['ID_VILLE'], PDO::PARAM_INT);
		$query2 -> execute();
		$data2 = $query2 -> fetch();
		
		$tab[$i] = $data2['LIBELLE'];
		$i++;
		
		$query2 -> closeCursor();		
		
		$datedit = new DateTime($data1['DATE_CREATION']);				
		$tab[$i] = $datedit->format('d/m/Y à H : i : s');
		$i++;
	}
	$query1 -> closeCursor();

	$bdd = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>