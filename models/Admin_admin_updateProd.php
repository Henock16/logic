<?php
	include_once('../config/Connexion.php');

	if( (isset($_POST['upidprod'])) && (!empty($_POST['upidprod'])) ){

		if( (isset($_POST['prod'])) && (!empty($_POST['prod'])) ){

			$prod = strtoupper($_POST['prod']);

			$query = $bdd -> prepare("SELECT COUNT(ID_PROD) AS NB FROM produit WHERE LIBELLE = :prod AND ID_PROD <> :idprod");
			$query -> bindParam(':prod', $prod, PDO::PARAM_STR);
			$query -> bindParam(':idprod', $_POST['upidprod'], PDO::PARAM_INT);
			$query -> execute();
			$data = $query -> fetch();

			if($data['NB'] > 0){

				$tab[0] = 0;
			}
			else{

				$tab[0] = 1;
				$query1 = $bdd -> prepare("UPDATE produit SET LIBELLE = :prod, CHANG_STAT = 0 WHERE ID_PROD = :idprod");
				$query1 -> bindParam(':prod', $prod, PDO::PARAM_STR);
				$query1 -> bindParam(':idprod', $_POST['upidprod'], PDO::PARAM_INT);
				$query1 -> execute();
				$query1 -> closeCursor();
			}
			$query -> closeCursor();
		}
		elseif( (isset($_POST['sousprod'])) && (!empty($_POST['sousprod'])) ){

			$sousprod = strtoupper($_POST['sousprod']);

			$query = $bdd -> prepare("SELECT COUNT(ID_TYPPROD) AS NB FROM type_produit WHERE LIBELLE=:sousprod AND PRODUIT=:idprod");
			$query -> bindParam(':sousprod', $sousprod, PDO::PARAM_STR);
			$query -> bindParam(':idprod', $_POST['upidprod'], PDO::PARAM_INT);
			$query -> execute();
			$data = $query -> fetch();

			if($data['NB'] > 0){

				$tab[0] = 0;
			}
			else{

				$tab[0] = 1;
				$query1 = $bdd -> prepare("INSERT INTO type_produit (LIBELLE,PRODUIT) VALUES(:sousprod,:idprod)");
				$query1 -> bindParam(':sousprod', $sousprod, PDO::PARAM_STR);
				$query1 -> bindParam(':idprod', $_POST['upidprod'], PDO::PARAM_INT);
				$query1 -> execute();
				$query1 -> closeCursor();
			}
			$query -> closeCursor();
		}
		elseif( (isset($_POST['delsousprod'])) && (!empty($_POST['delsousprod'])) ){

				$tab[0] = 1;
				$query = $bdd -> prepare("UPDATE type_produit SET STATUT = 1, CHANG_STAT = 0 WHERE PRODUIT = :idprod AND ID_TYPPROD = :idtypprod");
				$query -> bindParam(':idtypprod', $_POST['delsousprod'], PDO::PARAM_INT);
				$query -> bindParam(':idprod', $_POST['upidprod'], PDO::PARAM_INT);
				$query -> execute();
				$query -> closeCursor();
			}
			$query -> closeCursor();
	}

	if( (isset($_POST['idprod'])) && (!empty($_POST['idprod'])) ){

		$query = $bdd -> prepare("SELECT DISABLED FROM produit WHERE ID_PROD = :prod");
		$query -> bindParam(':prod', $_POST['idprod'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();

		if($data['DISABLED'] == 0){

			$tab[0] = 2;
			$query1 = $bdd -> prepare(" UPDATE produit SET DISABLED = 1, CHANG_STAT = 0 WHERE ID_PROD = :prod");
			$query1 -> bindParam(':prod', $_POST['idprod'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
		if($data['DISABLED'] == 1){

			$tab[0] = 3;
			$query2 = $bdd -> prepare("  UPDATE produit SET DISABLED = 0, CHANG_STAT = 0 WHERE ID_PROD = :prod");
			$query2 -> bindParam(':prod', $_POST['idprod'], PDO::PARAM_INT);
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
