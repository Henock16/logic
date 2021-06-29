<?php
	include_once('../config/Connexion.php');

	$i = 1;
	$tab[0] = 0;
	$dat = date('Y-m-d');

	if(!empty($_POST['idcontrol'])){
		
		$tab[0] = 1;
		
		$query = $bdd -> prepare("SELECT ID_VILLE FROM utilisateur WHERE ID_UTIL IN (SELECT ID_USER FROM bordereau WHERE ID_BORD=:bd)");
		$query -> bindParam(':bd', $_POST['idcontrol'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		$ville = $data['ID_VILLE'];
		
		$query -> closeCursor();

		$tab[$i] = $_POST['idcontrol'];
		$i++;
		
		$query1 = $bdd -> prepare("SELECT ID_UTIL, NOM, PRENOM, COMPTE FROM utilisateur WHERE TYPE_COMPTE = 2 AND STAT_COMPTE = 0 AND JOUR=:jou AND PREM_CONNEXION = 1 AND ID_VILLE=:vil ORDER BY COMPTE");
		$query1 -> bindParam(':jou', $dat, PDO::PARAM_STR);
		$query1 -> bindParam(':vil', $ville, PDO::PARAM_INT);
		$query1 -> execute();
		
		$rows1 = $query1 -> rowCount();

		$tab[$i] = $rows1;
		$i++;	
		
		if($rows1 > 0){

			while($data1 = $query1 -> fetch()){
				
				$tab[$i] = $data1['ID_UTIL'];
				$i++;
				$tab[$i] = $data1['NOM'].' '.$data1['PRENOM'];
				$i++;
				$tab[$i] = $data1['COMPTE'];
				$i++;
			}
			$query1 -> closeCursor();
		}
		else{

			$tab[$i] = 0;
			$i++;
		}
	}

	$bdd = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>