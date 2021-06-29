<?php
	include_once('../config/Connexion.php');
	
	if(!empty($_POST['numpk'])){
		
		$i = 0;
		
		$query = $bdd -> prepare("SELECT ID_CERTIF,  NUM_PCKLIST FROM certificat WHERE NUM_PCKLIST =:certif AND BLOCKED = 0 AND DISABLED = 0 AND A_R IN(0,2) ORDER BY DATE_CREATION DESC LIMIT 1");
		$query -> bindParam(':certif', $_POST['numpk'], PDO::PARAM_STR);
		$query -> execute();
		$rows = $query -> rowCount();
	
		if($rows > 0){
			
			while($data = $query -> fetch()){
				
				$tab[$i] = $data['NUM_PCKLIST'];
				$i++;
				
				$query1 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK FROM ticket WHERE ID_CERTIF = :certif");
				$query1 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
				$query1 -> execute();	
				
				While($data1 = $query1 -> fetch()){
					
					$tab[$i] = $data1['NB_TK'];
					$i++;
				}
				$query1->closeCursor();
				
				$query2 = $bdd -> prepare("SELECT ID_TICKET, NUM_TICKET, EXPORTATEUR, DATE_PESEE, NUM_CONTENEUR, POIDS_NET, MATCHED, NUM_PLOMB, NB_EMB FROM ticket WHERE ID_CERTIF =:certif");
				$query2 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
				$query2 -> execute();
				
				While($data2 = $query2 -> fetch()){
					
					if($data2['NUM_TICKET'] === null || $data2['NUM_TICKET'] == ''){			
						$data2['NUM_TICKET'] = 'N/D' ;
					}
					$tab[$i] = $data2['NUM_TICKET'];
					$i++;
					
					if($data2['EXPORTATEUR'] === null || $data2['EXPORTATEUR'] == ''){			
						$data2['EXPORTATEUR'] = 'N/D' ;
					}
					$tab[$i] = $data2['EXPORTATEUR'];
					$i++;
					$date = new DateTime($data2['DATE_PESEE']);
					$tab[$i] = $date -> format('d/m/Y à H:i:s');
					$i++;
					$tab[$i] = $data2['NUM_CONTENEUR'];
					$i++;
					$tab[$i] = $data2['POIDS_NET'];			
					$i++;
					$tab[$i] = $data2['MATCHED'];
					$i++;
					$tab[$i] = $data2['ID_TICKET'];
					$i++;
					$tab[$i] = $data2['NUM_PLOMB'];
					$i++;
					$tab[$i] = $data2['NB_EMB'];
					$i++;
				}
				$query2 -> closeCursor();
				
				$query3 = $bdd -> prepare("SELECT COUNT(ID_ERR) AS NUM_ERR FROM type_erreur");
				$query3 -> execute();	
				
				While($data3 = $query3 -> fetch()){					
					$tab[$i] = $data3['NUM_ERR'];
					$i++;
				}
				$query3 -> closeCursor();
				
				$query4 = $bdd -> prepare("SELECT ID_ERR, LIBELLE FROM type_erreur");
				$query4 -> execute();	
				
				While($data4 = $query4 -> fetch()){
					
					$tab[$i] = $data4['ID_ERR'];
					$i++;
					$tab[$i] = $data4['LIBELLE'];
					$i++;
				}
				$query4 -> closeCursor();
			}
			
		}
		else{			
			$tab[$i]= 0;
		}
		$query -> closeCursor();
	}	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>