<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	include_once('../functions/Dispatching_function.php');
	
	$queryrejet = $bdd -> prepare("SELECT ID_CERTIF FROM certificat WHERE STATUT = 3 AND NUM_PCKLIST = :numpk AND BLOCKED = 0 AND DISABLED = 0 AND A_R IN(0,2)");
	$queryrejet -> bindParam(':numpk', $_POST['NUMPKLIST'], PDO::PARAM_STR);
	$queryrejet -> execute();
	$row = $queryrejet -> rowCount();
	
	if($row > 0){
		
		$tab[0] = 'rejet';
	}
	else{
		
		$nbtk = $_POST['NUMTICKET'];
		$i = 0;
		$cle = true;

		while ($i < $nbtk){

			$T0[$i] = "T".$i;
			$numtk[$i] = $_POST[''.$T0[$i].''];
			$T1[$i] = "ST".$i;
			$statk[$i] = $_POST[''.$T1[$i].''];
			$T2[$i] = "ERR".$i;
			$selectk[$i] = $_POST[''.$T2[$i].''];
			$i++;
		}

		$query = $bdd -> prepare("SELECT ID_CERTIF FROM certificat WHERE NUM_PCKLIST=:numpklist AND BLOCKED = 0 AND DISABLED = 0 AND A_R IN(0,2)");
		$query -> bindParam(':numpklist', $_POST['NUMPKLIST'], PDO::PARAM_STR);
		$query -> execute();
		$data = $query->fetch();
		
		$query1 = $bdd -> prepare("SELECT ID_CB FROM certif_bord WHERE ID_CERTIF=:certif");
		$query1 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
		$query1 -> execute();
		$rows1 = $query1 -> rowCount();
		
		if($rows1 >= 1){		
			$tab[0] = 2;
		}	
		else{		
			
			for($k = 0; $k < $nbtk; $k++){

				if($statk[$k] == 1){

					$query2 = $bdd -> prepare("UPDATE ticket SET MATCHED=1 WHERE ID_TICKET=:tk");
					$query2 -> bindParam(':tk', $numtk[$k], PDO::PARAM_INT);
					$query2 -> execute();				
					$query2 -> closeCursor();
				}

				if($statk[$k] == 0){

					$query3 = $bdd -> prepare("INSERT INTO erreur(ID_TICKET,ID_TYP_ERR,RESOLVED,ID_CERTIF)VALUES(:num,:err,1,:certif)");
					$query3 -> bindParam(':num', $numtk[$k], PDO::PARAM_INT);
					$query3 -> bindParam(':err', $selectk[$k], PDO::PARAM_INT);
					$query3 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
					$query3 -> execute();
					$query3 -> closeCursor();
					
					$cle = false;
				}
			}

			if($cle == true){
				
				$tab[0] = 0 ;
				
				$query4 = $bdd -> prepare("SELECT ID_BORD FROM bordereau WHERE ID_USER =:util AND STATUT = 0 ORDER BY ID_BORD DESC LIMIT 1");
				$query4 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
				$query4 -> execute();
				$rows4 = $query4 -> rowCount();
				$data4 = $query4 -> fetch();

				if($rows4 == 1){
					
					$tab[1] = 0 ;
					
					$query5 = $bdd -> prepare("INSERT INTO certif_bord(ID_BORD,ID_CERTIF)VALUES(:bd,:ct)");
					$query5 -> bindParam(':bd', $data4['ID_BORD'], PDO::PARAM_INT);
					$query5 -> bindParam(':ct', $data['ID_CERTIF'], PDO::PARAM_INT);
					$query5 -> execute();
					$query5 -> closeCursor();
					
					$query6 = $bdd -> prepare("UPDATE certificat SET STADE = 7 WHERE ID_CERTIF=:idcertif");
					$query6 -> bindParam(':idcertif', $data['ID_CERTIF'], PDO::PARAM_INT);
					$query6 -> execute();
					$query6 -> closeCursor();
					
					$query7 = $bdd -> prepare("SELECT COUNT(ID_CB) as NB_LIASSE FROM certif_bord WHERE ID_BORD =:bd");
					$query7 -> bindParam(':bd', $data4['ID_BORD'], PDO::PARAM_INT);
					$query7 -> execute();
					$data7 = $query7 -> fetch();

					$query8 = $bdd -> query("SELECT VALEUR FROM configuration WHERE ID_CONF = 3");
					$data8 = $query8 -> fetch();
					$query8 -> closeCursor();

					if($data7['NB_LIASSE'] >= $data8['VALEUR']){
						
						$tab[2] = 0 ;
						
						$result = Dispatching($data4['ID_BORD'],2,$_SESSION['ID_UTIL'],$_SESSION['ID_VILLE'],$bdd);
						
						if($result[0] == 0){
							
							$tab[3] = 0 ;
							$tab[4] = $result[1] ;
						}
						elseif($result[0] == 1){
							
							$tab[3] = 1 ;
						}
					}
					else{
						
						$tab[2] = 1 ;
					}
					$query7 -> closeCursor();		    
				}
				else{
					
					$tab[1] = 1 ;
					
					$query9 = $bdd -> prepare("INSERT INTO bordereau(ID_USER,STADE)VALUES(:util,1)");
					$query9 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
					$query9 -> execute();
					$query9 -> closeCursor();

					$query10 = $bdd -> prepare("SELECT ID_BORD FROM bordereau WHERE ID_USER =:util AND STATUT = 0 ORDER BY ID_BORD DESC LIMIT 1");
					$query10 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
					$query10 -> execute();
					$data10 = $query10 -> fetch();

					$query11 = $bdd -> prepare("INSERT INTO certif_bord(ID_BORD,ID_CERTIF)VALUES(:bd,:ct)");
					$query11 -> bindParam(':bd', $data10['ID_BORD'], PDO::PARAM_INT);
					$query11 -> bindParam(':ct', $data['ID_CERTIF'], PDO::PARAM_INT);
					$query11 -> execute();
					
					$tab[2] = $data10['ID_BORD'] ;
					
					$query10->closeCursor();
					$query11->closeCursor();
					
					$query12 = $bdd -> prepare("UPDATE certificat SET STADE = 7 WHERE ID_CERTIF=:idcertif");
					$query12 -> bindParam(':idcertif', $data['ID_CERTIF'], PDO::PARAM_INT);
					$query12 -> execute();
					$query12 -> closeCursor();
				}
				$query4 -> closeCursor();
			}
			else{
				
				$tab[0] = 1 ;
				
				$query13 = $bdd -> prepare("UPDATE certificat SET ERREUR = 1 WHERE ID_CERTIF=:ct");
				$query13 -> bindParam(':ct', $data['ID_CERTIF'], PDO::PARAM_INT);
				$query13 -> execute();
				$query13 -> closeCursor();	
			}
		}
		$query1 -> closeCursor();
		$query -> closeCursor();
	}
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>