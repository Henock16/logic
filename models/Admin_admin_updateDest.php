<?php
	include_once('../config/Connexion.php');
	
	if( (isset($_POST['upiddest'])) && (!empty($_POST['upiddest'])) ){
		
		$pays = strtoupper($_POST['pays']);
		$port = strtoupper($_POST['port']);
		
		$query = $bdd ->prepare("SELECT COUNT(ID_DEST) AS NB FROM destination WHERE PORT=:port AND PAYS=:pays AND ID_DEST <>:iddest");
		$query -> bindParam(':port', $port, PDO::PARAM_STR);
		$query -> bindParam(':pays', $pays, PDO::PARAM_STR);
		$query -> bindParam(':iddest', $_POST['upiddest'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){
			
			$tab[0] = 0;
		}
		else{
			
			$tab[0] = 1;
			$query1 = $bdd ->prepare("UPDATE destination SET PAYS =:pays,PORT =:port, CHANG_STAT=0 WHERE ID_DEST=:iddest");
			$query1 -> bindParam(':pays', $pays, PDO::PARAM_STR);
			$query1 -> bindParam(':port', $port, PDO::PARAM_STR);
			$query1 -> bindParam(':iddest', $_POST['upiddest'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();			
		}
	}
	
	if( (isset($_POST['iddest'])) && (!empty($_POST['iddest'])) ){

		$query = $bdd ->prepare("SELECT STATUT FROM destination WHERE ID_DEST=:dest");
		$query -> bindParam(':dest', $_POST['iddest'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['STATUT'] == 0){
			
			$tab[0] = 2;
			$query1 = $bdd ->prepare("UPDATE destination SET STATUT = 1,CHANG_STAT=0 WHERE ID_DEST=:dest");
			$query1 -> bindParam(':dest', $_POST['iddest'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
		elseif($data['STATUT'] == 1){
			
			$tab[0] = 3;
			$query2 = $bdd ->prepare("UPDATE destination SET STATUT =0,CHANG_STAT=0 WHERE ID_DEST=:dest");
			$query2 -> bindParam(':dest', $_POST['iddest'], PDO::PARAM_INT);
			$query2 -> execute();
			$query2 -> closeCursor();
		}
		$query -> closeCursor();
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>