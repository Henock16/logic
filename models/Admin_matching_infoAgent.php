<?php
	include_once('../config/Connexion.php');

	$dat = date('Y-m-d');
	$tab[0] = 0;
	$i = 1;

	if((isset($_POST['idmatch']))&&(!empty($_POST['idmatch']))){

		$tab[0] = 1;
		$query = $bdd -> prepare("SELECT ID_VILLE FROM certificat WHERE ID_CERTIF=:certif");
		$query -> bindParam(':certif', $_POST['idmatch'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		$ville = $data['ID_VILLE'];
		
		$query -> closeCursor();

		$tab[$i] = $_POST['idmatch'];
		$i++;
		
		$query1 = $bdd -> prepare("SELECT ID_UTIL, NOM, PRENOM, COMPTE FROM utilisateur WHERE TYPE_COMPTE = 1 AND STAT_COMPTE = 0 AND JOUR=:jou AND PREM_CONNEXION = 1 AND ID_VILLE = :vil  ORDER BY COMPTE");
		$query1 -> bindParam(':jou', $dat, PDO::PARAM_STR);
		$query1 -> bindParam(':vil', $ville, PDO::PARAM_INT);
		$query1 -> execute();
		$rows1 = $query1 -> rowCount();
		
		if($rows1 >= 1){

			$tab[$i] = $rows1;
			$i++;
			
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