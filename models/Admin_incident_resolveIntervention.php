<?php

	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(!(empty($_POST['idcertif']))){
		
		if($_POST['action'] == 1){
			
			$query = $bdd -> prepare("SELECT ID_USER_PREC FROM certificat WHERE ID_CERTIF = :certif");
			$query -> bindParam(':certif', $_POST['idcertif'], PDO::PARAM_INT);
			$query -> execute();
			$data = $query -> fetch();
			
			$query1 = $bdd -> prepare("UPDATE certificat SET ERREUR = 0, STATUT = 1, ID_USER_COUR = :util WHERE ID_CERTIF=:certif");
			$query1 -> bindParam(':util',$data['ID_USER_PREC'], PDO::PARAM_INT);
			$query1 -> bindParam(':certif',$_POST['idcertif'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
			
			$query -> closeCursor();
			$tab[0] = 1;
		}
	}
	$bdd = null ;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
	
?>