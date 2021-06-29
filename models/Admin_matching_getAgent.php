<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');

	$i = 0;
	$tab[$i] = 0;
	if($_SESSION['ROLE']==2){
		if($_SESSION['ID_VILLE'] == 1){
			$bke = 3;
		}else{
			$bke = 0;
		}
		$query1 = $bdd -> query("SELECT ID_UTIL, NOM, PRENOM, STAT_COMPTE, ID_VILLE FROM utilisateur WHERE TYPE_COMPTE = 1 AND ID_VILLE IN(".$_SESSION['ID_VILLE'].",".$bke.")");
		$tab[$i] =  $query1 -> rowCount() ;;
		$i++;
		$query1 -> execute();
	}
	elseif($_SESSION['ROLE']!=2){
		$query1 = $bdd -> query("SELECT ID_UTIL, NOM, PRENOM, STAT_COMPTE, ID_VILLE FROM utilisateur WHERE TYPE_COMPTE = 1");
		$tab[$i] =  $query1 -> rowCount() ;;
		$i++;
		$query1 -> execute();
	}
	
	while($data1 = $query1 -> fetch()){
		
		$tab[$i] = $data1['ID_UTIL'];
		$i++;
		$tab[$i] = $data1['NOM'];
		$i++;
		$tab[$i] = $data1['PRENOM'];
		$i++;
		$tab[$i] = $data1['STAT_COMPTE'];
		$i++;
		
		$query2 = $bdd -> prepare("SELECT ID_CERTIF FROM certificat WHERE DISABLED = 0 AND A_R IN(0,2) AND STATUT NOT IN(3,4) AND ID_USER_COUR=:util");
		$query2 -> bindParam(':util',$data1['ID_UTIL'],PDO::PARAM_INT);
		$query2 -> execute();
		
		$tab[$i] = $query2 -> rowCount();
		$i++;
		
		if($tab[$i-1] > 0){
			
			$nb_ticket = 0;
			
			while($data2 = $query2 -> fetch()){
				
				$query3 = $bdd -> prepare("SELECT COUNT(ID_TICKET) AS NB FROM ticket WHERE ID_CERTIF =:certif");
				$query3 -> bindParam(':certif', $data2['ID_CERTIF'],PDO::PARAM_INT);
				$query3 -> execute();
				$data3 = $query3 -> fetch();
				
				$nb_ticket += $data3['NB'];
				
				$query3 -> closeCursor();
			}
			
			$tab[$i] = $nb_ticket;
			$i++;
		}
		else{
			
			$tab[$i] = 0;
			$i++;
		}
		
		$query4 = $bdd -> prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
		$query4 -> bindParam(':vil', $data1['ID_VILLE'], PDO::PARAM_INT);
		$query4 -> execute();
		$data4 = $query4 -> fetch();
		
		$tab[$i] = $data4['LIBELLE'];
		$i++;
		
		$query4 -> closeCursor();
		$query2 -> closeCursor();
	}
	$query1 -> closeCursor();
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>