<?php
	include_once('../config/Connexion.php');

	$i = 0;
	
	$query = $bdd -> prepare("SELECT NUM_TICKET, EXPORTATEUR, DATE_EDITION, NUM_CONTENEUR, POIDS_NET, NUM_PLOMB, NB_EMB FROM ticket WHERE ID_CERTIF = :certif");
	$query -> bindParam(':certif', $_POST['idcertif'], PDO::PARAM_INT);
	$query -> execute();

	$tab[$i] = $query -> rowCount();
	$i++;
	
	While($data = $query -> fetch()){
		
		if($data['NUM_TICKET'] === null || $data['NUM_TICKET'] == ''){			
			$data['NUM_TICKET'] = 'N/D' ;
		}
		$tab[$i] = $data['NUM_TICKET'];
		$i++;
		
		if($data['EXPORTATEUR'] === null || $data['EXPORTATEUR'] == ''){			
			$data['EXPORTATEUR'] = 'N/D' ;
		}
		$tab[$i] = $data['EXPORTATEUR'];
		$i++;

		$date = new DateTime($data['DATE_EDITION']);
		$tab[$i] = $date -> format('d/m/Y à H : i : s');
		$i++;
		$tab[$i] = $data['NUM_CONTENEUR'];
		$i++;
		$tab[$i] = $data['NUM_PLOMB'];					
		$i++;
		$tab[$i] = $data['NB_EMB'];					
		$i++;
		$tab[$i] = $data['POIDS_NET'];					
		$i++;			
	}
	$query -> closeCursor();	
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>