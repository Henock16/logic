<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if( (isset($_POST['port'])) && (!empty($_POST['port'])) ){
		
		$port = strtoupper($_POST['port']);
		$pays = strtoupper($_POST['pays']);
		
		$query = $bdd ->prepare("SELECT COUNT(ID_DEST) AS NB FROM destination WHERE PAYS=:pays AND PORT=:port");
		$query -> bindParam(':pays', $pays, PDO::PARAM_STR);
		$query -> bindParam(':port', $port, PDO::PARAM_STR);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){
			
			$tab[0] = 1;
		}
		else{
			
			$tab[0] = 2;
			
			$query1 = $bdd ->prepare("INSERT INTO destination (PAYS,PORT,DATE_CREATION) VALUES (:pays,:port,NOW())");
			$query1 -> bindParam(':pays', $pays, PDO::PARAM_STR);
			$query1 -> bindParam(':port', $port, PDO::PARAM_STR);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
	}
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>