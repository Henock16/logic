<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if((isset($_POST['idconf'])) && (!empty($_POST['idconf']))){
		
		$tab[0] = 1;
		$query = $bdd -> prepare("UPDATE configuration SET VALEUR=:valeur WHERE ID_CONF =:idconf");
		$query -> bindParam(':valeur', $_POST['valeur'], PDO::PARAM_INT);
		$query -> bindParam(':idconf', $_POST['idconf'], PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>