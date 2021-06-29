<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');
	
	function dateFr($date){
    	return strftime('%d/%m/%Y',strtotime($date));
    }
	
	$tab[0] = 0;
	$i = 1;

	if(!empty($_POST['idrec'])){
		
		$tab[0] = 1;
		
		$query = $bdd -> prepare("SELECT DEBUT, FIN FROM recolte WHERE ID_REC =:idrec");
		$query -> bindParam(':idrec', $_POST['idrec'], PDO::PARAM_INT);
		$query -> execute();
		
		while($data = $query -> fetch()){
		
			$tab[$i] = $data['DEBUT'];
			$i++;
			$tab[$i] = $data['FIN'];
		}
		$query -> closeCursor();
	}
	else{

		$query = $bdd -> query("SELECT ID_REC, LIBELLE, DEBUT, FIN, PRODUIT, STATUT, DATE_CREATION FROM recolte");
		$tab[$i] = $query -> rowCount() ;
		$i++;

		while($data = $query -> fetch()){

			$tab[$i] = $data['ID_REC'];
			$i++;
			$tab[$i] = $data['LIBELLE'];
			$i++;
			
			if($data['DEBUT'] === null || $data['DEBUT'] ==''){
				$tab[$i] = '';
			}
			else{
				$tab[$i] = dateFr($data['DEBUT']);
			}
			$i++;
			
			if($data['FIN'] === null || $data['FIN'] ==''){
				$tab[$i] = '';
			}
			else{
				$tab[$i] = dateFr($data['FIN']);
			}
			$i++;
			
			$query1 = $bdd -> prepare("SELECT LIBELLE FROM produit WHERE ID_PROD = :prod");
			$query1 -> bindParam(':prod', $data['PRODUIT'], PDO::PARAM_INT);
			$query1 -> execute();			
			$data1 = $query1 -> fetch();
			
			$tab[$i] = $data1['LIBELLE'];
			$i++;
			
			$query1 -> closeCursor();

			$tab[$i] = $data['STATUT'];
			$i++;
			
			$datedit = new DateTime($data['DATE_CREATION']);				
			$tab[$i] = $datedit->format('d/m/Y à H : i : s');
			$i++;
		}
		$query -> closeCursor();
		$tab[$i] = $_SESSION['ROLE'];
	}
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>