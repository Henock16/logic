<?php
	
	include('../config/Connexion.php');
	
	if((isset($_POST['idagent'])) && (!empty($_POST['idagent']))){
		
		$query = $bdd -> prepare("SELECT ID_CERTIF, NUM_PCKLIST, ERREUR, STADE FROM certificat WHERE DISABLED = 0 AND A_R IN(0,2) AND STATUT NOT IN(3,4) AND ID_USER_COUR=:util ORDER BY ID_CERTIF");
		$query -> bindParam(':util', $_POST['idagent'], PDO::PARAM_INT);
		$query -> execute();
		$rows = $query -> rowCount();
		
		$i = 0;
		$tab[$i] = $rows ;
		$i++ ;
		
		if($rows >= 1){
			
			while ($data = $query -> fetch()){
				
				$tab[$i] = $data['NUM_PCKLIST'];
				$i++;
				
				$query1 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK FROM ticket WHERE ID_CERTIF=:certif");
				$query1 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
				$query1 -> execute();	
				
				while ($data1 = $query1->fetch()){
					
					$tab[$i] = $data1['NB_TK'];
					$i++;
				}
				$query1->closeCursor();
				
				if($data['ERREUR'] > 0){
					$tab[$i] = 0;
				}
				elseif($data['STADE'] == 7){
					$tab[$i] = 1;
				}
				else{
					$tab[$i] = 2;
				}
				$i++;
			}
		}
		$query -> closeCursor();
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>