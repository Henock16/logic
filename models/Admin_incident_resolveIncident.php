<?php

	include_once('../config/Connexion.php');

	$tab[0] = 0;
	
	if(isset($_POST['idincid']) && !(empty($_POST['idincid']))){
		
		$query = $bdd -> prepare("SELECT A_R FROM certificat WHERE ID_CERTIF=:certif");
		$query -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();

		if($data['A_R'] == 3){

			$query1 = $bdd -> prepare("UPDATE certificat SET A_R = 1, DISABLED = 1, CHANG_STAT = 0 WHERE ID_CERTIF=:certif");
			$query1 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
			$tab[0] = 1;
		}
		elseif($data['A_R'] == 4){

			$query1 = $bdd -> prepare("UPDATE certificat SET A_R = 5, CHANG_STAT = 0 WHERE ID_CERTIF=:certif");
			$query1 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
			$tab[0] = 2;
		}
		$query -> closeCursor();
	}
	
	$bdd = null ;
	
	/* Output header */

	header('Content-type: application/json');
	echo json_encode($tab);
?>