<?php
	include_once('../config/Connexion.php');

	$tab[0] = 0;
	$i = 1 ;

	if(!(empty($_POST['idcert']))){

		$query = $bdd -> prepare("SELECT NUM_CERTIF FROM certificat WHERE ID_CERTIF =:id");
		$query -> bindParam(':id', $_POST['idcert'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();

		$tab[$i] = $data['NUM_CERTIF'];

		$query -> closeCursor();
		
		$tab[0] = 1;
	}			
	$bdd = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>