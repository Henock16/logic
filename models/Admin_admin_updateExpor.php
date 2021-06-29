<?php
	include_once('../config/Connexion.php');
	
	$i = 0;
	$tab[0] = 0;
	$i++;
	
	if((isset($_POST['idexp'])) && (!empty($_POST['idexp']))){
		
		$query = $bdd -> prepare("SELECT STATUT FROM exportateur WHERE ID_EXP=:idexp");
		$query -> bindParam(':idexp', $_POST['idexp'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['STATUT'] == 0 ){
			
			$tab[0] = 1;
			
			$query1 = $bdd -> prepare("UPDATE exportateur SET STATUT = 1, CHANG_STAT = 0 WHERE ID_EXP=:exp");
			$query1 -> bindParam(':exp', $_POST['idexp'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
		if($data['STATUT'] == 1 ){
			
			$tab[0] = 2;
			
			$query1 = $bdd -> prepare("UPDATE exportateur SET STATUT = 0, CHANG_STAT = 0 WHERE ID_EXP=:exp");
			$query1 -> bindParam(':exp', $_POST['idexp'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
	}
	elseif((isset($_POST['id_expor'])) && (!empty($_POST['id_expor']))){	
		
		$query = $bdd -> prepare("SELECT ID_AGRE FROM agrement WHERE ID_EXP=:expor AND ID_CAMP=:camp");
		$query -> bindParam(':expor', $_POST['id_expor'], PDO::PARAM_INT);
		$query -> bindParam(':camp', $_POST['camp'], PDO::PARAM_INT);
		$query -> execute();
		$row = $query -> rowCount();
		
		if($row == 0){
			
			$tab[0] = 3;
			$query1 = $bdd -> prepare("INSERT INTO agrement (CODE,ID_EXP,ID_CAMP,DATE_CREATION) VALUES(:agre,:exp,:camp,NOW())");
			$query1 -> bindParam(':agre', $_POST['agre'], PDO::PARAM_STR);
			$query1 -> bindParam(':exp', $_POST['id_expor'], PDO::PARAM_INT);
			$query1 -> bindParam(':camp', $_POST['camp'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
		else{
			
			$tab[0] = 4;
			
			$data = $query -> fetch();
			$query2 = $bdd -> prepare("UPDATE agrement SET CODE =:agre, STATUT = 0, CHANG_STAT = 0 WHERE ID_AGRE =:idagre");
			$query2 -> bindParam(':agre', $_POST['agre'], PDO::PARAM_INT);
			$query2 -> bindParam(':idagre', $data['ID_AGRE'], PDO::PARAM_INT);
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