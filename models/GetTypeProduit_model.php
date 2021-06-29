<?php
	include_once('../config/Connexion.php');

	$i = 0 ;
	$tab[0] = 0;
	$i++;

	if( (isset($_POST['idprod'])) && (!empty($_POST['idprod'])) ){

		$tab[0] = 1;

		$query1 = $bdd ->prepare("SELECT ID_TYPPROD, LIBELLE FROM type_produit WHERE PRODUIT =:idprod AND STATUT = 0");
		$query1 -> bindParam(':idprod', $_POST['idprod'], PDO::PARAM_INT);
		$query1 -> execute();

		while($data1 = $query1->fetch()){

			$tab[$i]= $data1['ID_TYPPROD'];
			$i++;
			$tab[$i]= $data1['LIBELLE'];
			$i++;
		}
		$query1 -> closeCursor();
	}

	$bdd = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>
