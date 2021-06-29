<?php
	include_once('../config/Connexion.php');

	$tab[0] = 0;
	$i = 1 ;

	if(!(empty($_POST['typetare']))){

		$query = $bdd -> prepare("SELECT VALEUR FROM config_tare WHERE IDENTIFIANT =:id");
		$query -> bindParam(':id', $_POST['typetare'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if(!is_null($data['VALEUR'])){
			$tab[0] = 1;
			$tab[$i] = $data['VALEUR'];
		}
		$query -> closeCursor();		
	}			
	$bdd = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>