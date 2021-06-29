<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	include_once('../functions/Date_management_function.php');
	
	$i = 1 ;
	$tab[0] = 0 ;
	$typcompte = $_SESSION['TYPE_COMPTE'];
	
	if(!empty($_POST['one'])){
		
		$query9 = $bdd -> prepare("SELECT ID_CERTIF, NUM_CERTIF, NUM_PCKLIST, ID_TYPPROD, DATE_CREATION, STADE, RE_EDIT FROM certificat WHERE ID_USER_PREC=:util AND ID_USER_COUR = 0 AND NB_EDIT >= 1 AND ERREUR = 0 AND BLOCKED = 0 AND STADE >= 3 AND DISABLED = 0 AND A_R IN(0,2) AND NUM_PCKLIST = :numpk");
		$query9 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
		$query9 -> bindParam(':numpk', $_POST['numpk'], PDO::PARAM_STR);
		$query9 -> execute();
		$rows9 = $query9 -> rowCount();
		
		if($rows9 > 0){
			
			while($data9 = $query9 -> fetch()){
				
				$tab[0] += 1;
				
				$tab[$i] = $data9['ID_CERTIF'];
				$i++;
				$tab[$i] = $data9['NUM_CERTIF'] ;
				$i++;
				
				$query13 = $bdd -> query("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =".$data9['ID_TYPPROD']);
				$data13 = $query13 -> fetch();
				
				$tab[$i] = $data13['LIBELLE'] ;
				$i++;
				
				$query13 -> closeCursor();
				
				$query10 = $bdd -> prepare("SELECT SUM(POIDS_NET) as P_N FROM ticket WHERE ID_CERTIF=:certif");
				$query10 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);
				$query10 -> execute();
				$data10 = $query10 -> fetch();
			
				$tab[$i] = $data10['P_N'];
				$i++;				
				
				$query10 -> closeCursor();
				
				$date10 = new DateTime($data9['DATE_CREATION']);				
				$tab[$i] = $date10 -> format('d/m/Y à H : i : s');
				$i++;
				
				$stadedeb = ($data9['STADE'] - 1);
			
				$query11 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 2 AND VAL_PREC =:util AND CIBLE = (SELECT bordereau.ID_BORD as id_bord FROM bordereau,certif_bord WHERE bordereau.ID_BORD = certif_bord.ID_BORD AND STADE=:stadedeb AND ID_CERTIF=:certif ORDER BY bordereau.DATE_CREATION DESC LIMIT 1) ORDER BY DATE_CREATION LIMIT 1");
				$query11 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
				$query11 -> bindParam(':stadedeb', $stadedeb, PDO::PARAM_INT);
				$query11 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);					
				$query11 -> execute();
				$data11 = $query11 -> fetch();
				$datedeb = $data11['DATE_CREATION'];	
				$query11 -> closeCursor();
				
				$query12 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE=:certif AND ACTEUR =:util AND ACTION = 3 ORDER BY DATE_CREATION LIMIT 1");
				$query12 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);
				$query12 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);				
				$query12 -> execute();
				$data12 = $query12 -> fetch();
				$datefin = $data12['DATE_CREATION'];
				$query12 -> closeCursor();
				
				$dateFin = date('Y-m-d', strtotime(date($datefin)));
				$dateDeb = date('Y-m-d', strtotime($datedeb));
				
				$time1 = date('H:i:s', strtotime($datefin));
				$time2 = date('H:i:s', strtotime($datedeb));  

				if($dateDeb == $dateFin){

					if($time1 == $time2){

						$heur = 00;
						$min = 00;
						$sec = 00;
					}
					else{

						$heur = diffHour($datedeb, $datefin)[0];
						$min = diffHour($datedeb, $datefin)[1];
						$sec = diffHour($datedeb, $datefin)[2];
					}
				}
				else{

					$heur = ((diffWorkDay($dateDeb, $dateFin) / 86400)-1)*8;
					$heur += (calHourDep($datedeb)[0]) ;
					$heur += calHourFin($datefin)[0] ;
					$min = calHourDep($datedeb)[1] ;
					$min += calHourFin($datefin)[1] ;
					$sec = calHourDep($datedeb)[2] ;
					$sec += calHourFin($datefin)[2] ;
				}				
				$heur = $heur - 1 ;
				
				$query13 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 7 AND CIBLE=:certif AND VAL_PREC = :util ORDER BY DATE_CREATION");
				$query13 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);
				$query13 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);				
				$query13 -> execute();
				
				$row13 = $query13 -> rowCount();
				
				if($row13 > 0){
					
					while($data13 = $query13 -> fetch()){
						
						$datedeDebut = $data13['DATE_CREATION'];
						
						$query14 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE=:certif AND ACTEUR =:util AND ACTION = 3 AND DATE_CREATION >:dateretro ORDER BY DATE_CREATION LIMIT 1");
						$query14 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);
						$query14 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
						$query14 -> bindParam(':dateretro', $data13['DATE_CREATION'], PDO::PARAM_STR);
						
						$data14 = $query14 -> fetch();
						$datedeFin = $data14['DATE_CREATION'];
						
						$DF = date('Y-m-d', strtotime(date($datedeFin)));
						$DD = date('Y-m-d', strtotime($datedeDebut));
						
						$time3 = date('H:i:s', strtotime($datedeFin));
						$time4 = date('H:i:s', strtotime($datedeDebut));  

						if($DD == $DF){

							if($time3 == $time4){

								$heur1 = 00;
								$min1 = 00;
								$sec1 = 00;
							}
							else{

								$heur1 = diffHour($datedeDebut, $datedeFin)[0];
								$min1 = diffHour($datedeDebut, $datedeFin)[1];
								$sec1 = diffHour($datedeDebut, $datedeFin)[2];
							}
						}
						else{

							$heur1 = ((diffWorkDay($DD, $DF) / 86400)-1)*8;
							$heur1 += (calHourDep($datedeDebut)[0]) ;
							$heur1 += calHourFin($datedeFin)[0] ;
							$min1 = calHourDep($datedeDebut)[1] ;
							$min1 += calHourFin($datedeFin)[1] ;
							$sec1 = calHourDep($datedeDebut)[2] ;
							$sec1 += calHourFin($datedeFin)[2] ;
						}				
						$heur1 = $heur1 - 1 ;
						
						$heur += $heur1;
						$min += $min1;
						$sec += $sec1;
					}
				}				
				$query13 -> closeCursor();
				
				while($sec >= 60){

					$min++;
					$sec -= 60;
				}

				while($min >= 60){

					$heur++;
					$min -= 60;
				}
				
				if($heur <= 9){
					$heur = '0'.$heur ;
				}
				if($min <= 9){
					$min = '0'.$min;
				}
				if($sec <= 9){
					$sec = '0'.$sec;
				}
	
				$tab[$i] = $heur.' : '.$min.' : '.$sec;
				$i++;
				$tab[$i] = $data9['RE_EDIT'];
				$i++;
				$tab[$i] = $data9['NUM_PCKLIST'];
				$i++;
				$tab[$i] = $_SESSION['ID_UTIL'];
				$i++;
			}
			$query9 -> closeCursor();
		}
	}
	else{
	
		$query9 = $bdd -> prepare("SELECT ID_CERTIF, NUM_CERTIF, NUM_PCKLIST, ID_TYPPROD, DATE_CREATION, STADE, RE_EDIT FROM certificat WHERE ID_USER_PREC=:util AND ID_USER_COUR = 0 AND NB_EDIT >= 1 AND ERREUR = 0 AND BLOCKED = 0 AND STADE >= 3 AND DISABLED = 0 AND A_R IN(0,2) ORDER BY DATE_CREATION DESC LIMIT 100");
		$query9 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
		$query9 -> execute();
		$rows9 = $query9 -> rowCount();
		
		if($rows9 >= 1){
			
			while($data9 = $query9 -> fetch()){
				
				$tab[0] += 1;
				
				$tab[$i] = $data9['ID_CERTIF'];
				$i++;
				$tab[$i] = $data9['NUM_CERTIF'] ;
				$i++;
				
				$query13 = $bdd -> query("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =".$data9['ID_TYPPROD']);
				$data13 = $query13 -> fetch();
				
				$tab[$i] = $data13['LIBELLE'] ;
				$i++;
				
				$query13 -> closeCursor();
				
				$query10 = $bdd -> prepare("SELECT SUM(POIDS_NET) as P_N FROM ticket WHERE ID_CERTIF=:certif");
				$query10 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);
				$query10 -> execute();
				$data10 = $query10 -> fetch();
			
				$tab[$i] = $data10['P_N'];
				$i++;				
				
				$query10 -> closeCursor();
				
				$date10 = new DateTime($data9['DATE_CREATION']);				
				$tab[$i] = $date10 -> format('d/m/Y à H : i : s');
				$i++;
				
				$stadedeb = ($data9['STADE'] - 1);
			
				$query11 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 2 AND VAL_PREC =:util AND CIBLE = (SELECT bordereau.ID_BORD as id_bord FROM bordereau,certif_bord WHERE bordereau.ID_BORD = certif_bord.ID_BORD AND STADE=:stadedeb AND ID_CERTIF=:certif ORDER BY bordereau.DATE_CREATION DESC LIMIT 1) ORDER BY DATE_CREATION LIMIT 1");
				$query11 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
				$query11 -> bindParam(':stadedeb', $stadedeb, PDO::PARAM_INT);
				$query11 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);					
				$query11 -> execute();
				$data11 = $query11 -> fetch();
				$datedeb = $data11['DATE_CREATION'];	
				$query11 -> closeCursor();
				
				$query12 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE=:certif AND ACTEUR =:util AND ACTION = 3 ORDER BY DATE_CREATION LIMIT 1");
				$query12 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);
				$query12 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);				
				$query12 -> execute();
				$data12 = $query12 -> fetch();
				$datefin = $data12['DATE_CREATION'];
				$query12 -> closeCursor();
				
				$dateFin = date('Y-m-d', strtotime(date($datefin)));
				$dateDeb = date('Y-m-d', strtotime($datedeb));
				
				$time1 = date('H:i:s', strtotime($datefin));
				$time2 = date('H:i:s', strtotime($datedeb));  

				if($dateDeb == $dateFin){

					if($time1 == $time2){

						$heur = 00;
						$min = 00;
						$sec = 00;
					}
					else{

						$heur = diffHour($datedeb, $datefin)[0];
						$min = diffHour($datedeb, $datefin)[1];
						$sec = diffHour($datedeb, $datefin)[2];
					}
				}
				else{

					$heur = ((diffWorkDay($dateDeb, $dateFin) / 86400)-1)*8;
					$heur += (calHourDep($datedeb)[0]) ;
					$heur += calHourFin($datefin)[0] ;
					$min = calHourDep($datedeb)[1] ;
					$min += calHourFin($datefin)[1] ;
					$sec = calHourDep($datedeb)[2] ;
					$sec += calHourFin($datefin)[2] ;
				}				
				$heur = $heur - 1 ;
				
				$query13 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 7 AND CIBLE=:certif AND VAL_PREC = :util ORDER BY DATE_CREATION");
				$query13 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);
				$query13 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);				
				$query13 -> execute();
				
				$row13 = $query13 -> rowCount();
				
				if($row13 > 0){
					
					while($data13 = $query13 -> fetch()){
						
						$datedeDebut = $data13['DATE_CREATION'];
						
						$query14 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE=:certif AND ACTEUR =:util AND ACTION = 3 AND DATE_CREATION >:dateretro ORDER BY DATE_CREATION LIMIT 1");
						$query14 -> bindParam(':certif', $data9['ID_CERTIF'], PDO::PARAM_INT);
						$query14 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
						$query14 -> bindParam(':dateretro', $data13['DATE_CREATION'], PDO::PARAM_STR);
						
						$data14 = $query14 -> fetch();
						$datedeFin = $data14['DATE_CREATION'];
						
						$DF = date('Y-m-d', strtotime(date($datedeFin)));
						$DD = date('Y-m-d', strtotime($datedeDebut));
						
						$time3 = date('H:i:s', strtotime($datedeFin));
						$time4 = date('H:i:s', strtotime($datedeDebut));  

						if($DD == $DF){

							if($time3 == $time4){

								$heur1 = 00;
								$min1 = 00;
								$sec1 = 00;
							}
							else{

								$heur1 = diffHour($datedeDebut, $datedeFin)[0];
								$min1 = diffHour($datedeDebut, $datedeFin)[1];
								$sec1 = diffHour($datedeDebut, $datedeFin)[2];
							}
						}
						else{

							$heur1 = ((diffWorkDay($DD, $DF) / 86400)-1)*8;
							$heur1 += (calHourDep($datedeDebut)[0]) ;
							$heur1 += calHourFin($datedeFin)[0] ;
							$min1 = calHourDep($datedeDebut)[1] ;
							$min1 += calHourFin($datedeFin)[1] ;
							$sec1 = calHourDep($datedeDebut)[2] ;
							$sec1 += calHourFin($datedeFin)[2] ;
						}				
						$heur1 = $heur1 - 1 ;
						
						$heur += $heur1;
						$min += $min1;
						$sec += $sec1;
					}
				}				
				$query13 -> closeCursor();
				
				while($sec >= 60){

					$min++;
					$sec -= 60;
				}

				while($min >= 60){

					$heur++;
					$min -= 60;
				}
				
				if($heur <= 9){
					$heur = '0'.$heur ;
				}
				if($min <= 9){
					$min = '0'.$min;
				}
				if($sec <= 9){
					$sec = '0'.$sec;
				}
	
				$tab[$i] = $heur.' : '.$min.' : '.$sec;
				$i++;
				$tab[$i] = $data9['RE_EDIT'];
				$i++;
				$tab[$i] = $data9['NUM_PCKLIST'];
				$i++;
				$tab[$i] = $_SESSION['ID_UTIL'];
				$i++;
			}
			$query9 -> closeCursor();
		}
	}
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>