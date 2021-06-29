<?php

	include_once('../config/Connexion.php');

	if( (isset($_POST['iduser'])) && (!empty($_POST['iduser'])) ){

		$query = $bdd ->prepare("SELECT STAT_COMPTE FROM utilisateur WHERE ID_UTIL=:util");
		$query -> bindParam(':util', $_POST['iduser'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['STAT_COMPTE'] == 0){
			
			$query1 = $bdd ->prepare(" UPDATE utilisateur SET STAT_COMPTE = 1 WHERE ID_UTIL=:util");
			$query1 -> bindParam(':util', $_POST['iduser'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
			
			$tab[0] = 0;
		}
		elseif($data['STAT_COMPTE'] == 1){
			
			$query1 = $bdd ->prepare(" UPDATE utilisateur SET STAT_COMPTE = 0 WHERE ID_UTIL=:util");
			$query1 -> bindParam(':util', $_POST['iduser'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
			
			$tab[0] = 1;	
		}
		$query -> closeCursor();
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>