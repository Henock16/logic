<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if( (isset($_POST['expor'])) && (!empty($_POST['expor'])) ){
		
		$expor = strtoupper($_POST['expor']);
		
		$query = $bdd -> prepare("SELECT ID_EXP FROM exportateur WHERE LIBELLE=:expor AND PRODUIT =:prod");
		$query -> bindParam(':expor', $expor, PDO::PARAM_STR);
		$query -> bindParam(':prod', $_POST['prod'], PDO::PARAM_INT);
		$query -> execute();
		$rows = $query -> rowCount();
		
		if($rows == 0){
			
			$tab[0] = 1;
			
			$query1 = $bdd -> prepare("INSERT INTO exportateur (LIBELLE,PRODUIT,DATE_CREATION) VALUES (:libel,:prod,NOW())");
			$query1 -> bindParam(':libel', $expor, PDO::PARAM_STR);
			$query1 -> bindParam(':prod', $_POST['prod'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();

			$query2 = $bdd -> prepare("SELECT ID_EXP FROM exportateur WHERE LIBELLE=:libel AND PRODUIT=:prod");
			$query2 -> bindParam(':libel', $expor, PDO::PARAM_STR);
			$query2 -> bindParam(':prod', $_POST['prod'], PDO::PARAM_INT);
			$query2 -> execute();
			$data2 = $query2 -> fetch();

			$query3 = $bdd -> prepare("INSERT INTO agrement (ID_EXP,ID_CAMP,CODE,DATE_CREATION) VALUES (:exp,:camp,:agre,NOW())");
			$query3 -> bindParam(':exp', $data2['ID_EXP'], PDO::PARAM_INT);
			$query3 -> bindParam(':camp', $_POST['camp'], PDO::PARAM_INT);
			$query3 -> bindParam(':agre', $_POST['agre'], PDO::PARAM_STR);
			$query3 -> execute();
			
			$query2 -> closeCursor();
			$query3 -> closeCursor();
			
			$query4 = $bdd -> prepare("SELECT LIBELLE FROM campagne WHERE ID_CAMP=:camp");
			$query4 -> bindParam(':camp', $_POST['camp'], PDO::PARAM_INT);
			$query4 -> execute();
			$data4 = $query4 -> fetch();

			$tab[1] = $expor;
			$tab[2] = $data4['LIBELLE'];
			$tab[3] = $_POST['agre'];
			
			$query4 -> closeCursor();
		}
		else{
			
			$tab[1] = $expor;
		}
		$query -> closeCursor();
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>