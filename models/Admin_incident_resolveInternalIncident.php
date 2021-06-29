<?php

	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(isset($_POST['idincidinternall']) && !(empty($_POST['idincidinternall']))){
		
		$tab[0] = 1;
		$query = $bdd -> prepare("UPDATE erreur SET RESOLVED = 2 WHERE ID_CERTIF=:certif");
		$query -> bindParam(':certif', $_POST['idincidinternall'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();
		
		$query1 = $bdd -> prepare("UPDATE certificat SET ERREUR = 0, CHANG_STAT = 0 WHERE ID_CERTIF=:certif");
		$query1 -> bindParam(':certif',$_POST['idincidinternall'], PDO::PARAM_INT);
		$query1 -> execute();
		$query1 -> closeCursor();
	}
	elseif(isset($_POST['idticket']) && !(empty($_POST['idticket']))){
		
		$tab[0] = 2;
		$query = $bdd -> prepare("UPDATE erreur SET RESOLVED = 2 WHERE ID_TICKET =:idticket");
		$query -> bindParam(':idticket', $_POST['idticket'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();
		
		$query1 = $bdd -> prepare("SELECT COUNT(ID_ERR) AS NB FROM erreur WHERE ID_CERTIF=:certif AND RESOLVED = 1");
		$query1 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
		$query1 -> execute();
		
		$data1 = $query1 -> fetch();
		
		if($data1['NB'] == 0){
			
			$tab[0] = 3;
			$query2 = $bdd -> prepare("UPDATE certificat SET ERREUR = 0, CHANG_STAT = 0 WHERE ID_CERTIF=:certif");
			$query2 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
			$query2 -> execute();
			$query2 -> closeCursor();
		}	
		$query1 -> closeCursor();
	}
	
	$bdd = null ;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
	
?>