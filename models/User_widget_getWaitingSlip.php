<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	include('../config/Connexion.php');

	$query = $bdd -> prepare("SELECT ID_BORD FROM bordereau WHERE ID_USER =:util AND STATUT = 0 ORDER BY ID_BORD DESC LIMIT 1");
	$query -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
	$query -> execute();
	$rows = $query -> rowCount();
	
	$i = 0;
	$tab[$i] = $rows ;
	$i++ ;

	if($rows >= 1){

		while($data = $query -> fetch()){

			$tab[$i] = $data['ID_BORD'];
			$i++;

			$query1 = $bdd -> prepare("SELECT ID_CERTIF FROM certif_bord WHERE ID_BORD =:bd");
			$query1 -> bindParam(':bd', $data['ID_BORD'], PDO::PARAM_INT);
			$query1 -> execute();
			
			$rows1 = $query1 -> rowCount();
			$tab[$i] = $rows1 ;
			$i++;

			while($data1 = $query1->fetch()){

				$query2 = $bdd -> prepare("SELECT NUM_PCKLIST FROM certificat WHERE ID_CERTIF=:ct ORDER BY DATE_CREATION");
				$query2 -> bindParam(':ct', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query2 -> execute();

				while ($data2 = $query2->fetch()){

					$tab[$i] = $data2['NUM_PCKLIST'];
					$i++;

					$query3 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK FROM ticket WHERE ID_CERTIF=:certif");
					$query3 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
					$query3 -> execute();	

					while ($data3 = $query3->fetch()){

						$tab[$i] = $data3['NB_TK'];
						$i++;
					}
					$query3 -> closeCursor() ;
				}
				$query2 -> closeCursor() ;
			}
			$query1 -> closeCursor() ;		
		}
	}
	$query -> closeCursor() ;
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>