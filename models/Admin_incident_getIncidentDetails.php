<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');
	
	$i = 0;
	$tab[0] = 0;
	
	if( (isset($_POST['idincid'])) && (!empty($_POST['idincid'])) ){
		
		$query = $bdd -> prepare("SELECT A_R, ID_PCKLIST, STATUT, ERREUR FROM certificat WHERE ID_CERTIF=:certif");
		$query -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
		$query -> execute();
		
		while($data = $query -> fetch()){

			if($data['A_R'] == 3){
				
				$tab[0] = 1;
				$i++;
				
				$query0 = $bdd -> prepare("SELECT STRUCTURE FROM demandeur WHERE ID_DEMAND IN(SELECT ID_DEMANDEUR FROM certificat WHERE ID_CERTIF=:certif)");
				$query0 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
				$query0 -> execute();
				$data0 = $query0 -> fetch();
				
				$tab[$i] = $data0['STRUCTURE'];
				$i++;
				
				$query0 -> closeCursor();
				
				$query1 = $bdd -> prepare("SELECT MOTIF FROM demande_intervention WHERE ID_PKLIST=:pkl AND TYPE_DEMANDE = 0");
				$query1 -> bindParam(':pkl',$data['ID_PCKLIST'], PDO::PARAM_INT);
				$query1 -> execute();
				$data1 = $query1 -> fetch();
				
				$tab[$i] = $data1['MOTIF'];
				$i++;
				
				$query1 -> closeCursor();
			}
			elseif($data['A_R'] == 4){
				
				$tab[0] = 2;
				$i++;
				
				$query0 = $bdd -> prepare("SELECT STRUCTURE FROM demandeur WHERE ID_DEMAND IN(SELECT ID_DEMANDEUR FROM certificat WHERE ID_CERTIF=:certif)");
				$query0 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
				$query0 -> execute();
				$data0 = $query0 -> fetch();
				
				$tab[$i] = $data0['STRUCTURE'];
				$i++;
				
				$query0 -> closeCursor();
				
				$query1 = $bdd -> prepare("SELECT MOTIF FROM demande_intervention WHERE ID_PKLIST=:pkl AND TYPE_DEMANDE = 1");
				$query1 -> bindParam(':pkl',$data['ID_PCKLIST'], PDO::PARAM_INT);
				$query1 -> execute();
				$data1 = $query1 -> fetch();
				
				$tab[$i] = $data1['MOTIF'];
				$i++;
				
				$query1 -> closeCursor();
			}
			
			$i++;
			$tab[$i] = 0;
			
			if($data['ERREUR'] == 1){
				
				if(($data['STATUT'] == 2 || $data['STATUT'] == 4) && ($data['A_R'] == 0 || $data['A_R'] == 2)){
					
					$query1 = $bdd -> prepare("SELECT ACTEUR, ACTION FROM journal WHERE CIBLE = :certif AND ACTION IN(8,9) ORDER BY DATE_CREATION DESC LIMIT 1");
					$query1 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
					$query1 -> execute();
					$rows = $query1 -> rowCount();
					
					if($rows > 0){
						
						$data1 = $query1 -> fetch();
						
						$i++;
						$tab[$i] = $data1['ACTION'];
						$i++;
						
						$query2 = $bdd -> query("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL=".$data1['ACTEUR']);
						$data2 = $query2 -> fetch();
						
						$tab[$i] = $data2['NOM'].' '.$data2['PRENOM'];
					}
					$query1 -> closeCursor();
				}
				else{
					
					$query1 = $bdd -> prepare("SELECT ID_TICKET, LIBELLE, ID_TYP_ERR FROM erreur WHERE ID_CERTIF =:certif AND RESOLVED = 1 ");
					$query1 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
					$query1 -> execute();
					$rows = $query1 -> rowCount();
					
					if($rows > 0){
						
						$tab[$i] = $rows;
						$i++;
						
						$query0 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL IN(SELECT ID_USER_COUR FROM certificat WHERE ID_CERTIF=:certif)");
						$query0 -> bindParam(':certif',$_POST['idincid'], PDO::PARAM_INT);
						$query0 -> execute();
						$data0 = $query0 -> fetch();
						
						$tab[$i] = $data0['NOM'].' '.$data0['PRENOM'];
						$i++;
						
						$query0 -> closeCursor();
					
						while($data1 = $query1 -> fetch()){

							$tab[$i] = $data1['ID_TICKET'];
							$i++;
							
							$query2 = $bdd -> prepare("SELECT NUM_TICKET, NUM_CONTENEUR, SITE, POIDS_NET FROM ticket WHERE ID_TICKET =:tckt ");
							$query2 -> bindParam(':tckt',$data1['ID_TICKET'], PDO::PARAM_INT);
							$query2 -> execute();
							$data2 = $query2 -> fetch();
							
							$tab[$i] = $data2['NUM_TICKET'];
							$i++;
							$tab[$i] = $data2['NUM_CONTENEUR'];
							$i++;
							
							$query4 = $bdd -> prepare("SELECT LIBELLE FROM site WHERE ID_SITE=:site ");
							$query4 -> bindParam(':site',$data2['SITE'], PDO::PARAM_INT);
							$query4 -> execute();
							$data4 = $query4 -> fetch();
							
							$tab[$i] = $data4['LIBELLE'];
							$i++;
							
							$query4 -> closeCursor();
							
							$tab[$i] = $data2['POIDS_NET'];
							$i++;

							if($data1['ID_TYP_ERR'] == 0){
								
								$tab[$i] = $data1['LIBELLE'];
								$i++;
							}
							else{

								$query3 = $bdd -> prepare("SELECT LIBELLE FROM type_erreur WHERE ID_ERR =:err ");
								$query3 -> bindParam(':err',$data1['ID_TYP_ERR'], PDO::PARAM_INT);
								$query3 -> execute();
								$data3 = $query3 -> fetch();
								
								$tab[$i] = $data3['LIBELLE'];
								$i++;
								
								$query3 -> closeCursor();
							}
							$query2 -> closeCursor();
						}					
					}
					$query1 -> closeCursor();
				}
			}
		}
		$query -> closeCursor();
	}
	
	$bdd = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>