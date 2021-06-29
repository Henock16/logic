<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	include_once('../functions/Date_management_function.php');
	
	$i = 1 ;
	$tab[0] = 0 ;
	$typcompte = $_SESSION['TYPE_COMPTE'];
	
	if(!empty($_POST['Onlyone'])){
		
		if($typcompte == '1'){

			$query = $bdd -> prepare("SELECT ID_BORD, STADE FROM bordereau WHERE ID_USER=:util AND STADE = 1 AND STATUT = 1 ORDER BY ID_BORD DESC LIMIT 1");
			$query -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
			$query -> execute();
		}	
		elseif($typcompte == '2'){

			$query = $bdd -> prepare("SELECT ID_BORD, STADE FROM bordereau WHERE ID_USER=:util AND STADE IN (2,3,4,5) AND STATUT = 1 ORDER BY ID_BORD DESC LIMIT 1");
			$query -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
			$query -> execute();
		}
		
		while($data = $query->fetch()){
			
			$temp[0] = 0;
			$p = 0;
		
			$query1 = $bdd -> prepare("SELECT ID_CERTIF FROM certif_bord WHERE ID_BORD=:bd ORDER BY ID_CERTIF");
			$query1 -> bindParam(':bd', $data['ID_BORD'], PDO::PARAM_INT);
			$query1 -> execute();
			
			while($data1 = $query1->fetch()){
				
				$q = 0;
				$num = 0;
				
				while($q < ($p+1)){
					
					if($temp[$q] == $data1['ID_CERTIF']){
						$num++;
					}
					$q++;
				}
				$temp[$p+1] = $data1['ID_CERTIF'];
				$p++;
				
				$query2 = $bdd -> prepare("SELECT NUM_PCKLIST FROM certificat WHERE ID_CERTIF=:certi");
				$query2 -> bindParam(':certi', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query2 -> execute();
				
				while($data2 = $query2 -> fetch()){
					
					$tab[0] += 1 ; 

					if($typcompte == '1'){
						
						$tab[$i] = $data1['ID_CERTIF'];
						$i++;
						$tab[$i] = $data2['NUM_PCKLIST'];
						$i++;
						
						$query3 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE =:certif AND ACTION = 1");
						$query3 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
						$query3 -> execute();
						$data3 = $query3 -> fetch();
						$datedeb = $data3['DATE_CREATION'];
						$query3 -> closeCursor();
					}
					elseif($typcompte == '2'){
						
						$tab[$i] = $data1['ID_CERTIF'];
						$i++;
						$tab[$i] = $data2['NUM_PCKLIST'];
						$i++;
						$stadedeb = ($data['STADE'] - 1);
						
						if($num == 0){
							
							$query4 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 2 AND VAL_PREC =:util AND CIBLE = (SELECT bordereau.ID_BORD as id_bord FROM bordereau,certif_bord WHERE bordereau.ID_BORD = certif_bord.ID_BORD AND STADE=:stadedeb AND ID_CERTIF=:certif ORDER BY bordereau.DATE_CREATION DESC LIMIT 1) ORDER BY DATE_CREATION LIMIT 1");
							$query4 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
							$query4 -> bindParam(':stadedeb', $stadedeb, PDO::PARAM_INT);
							$query4 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);					
							$query4 -> execute();
							$data4 = $query4 -> fetch();
							$datedeb = $data4['DATE_CREATION'];							
						}
						else{
							
							$query4 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 2 AND VAL_PREC =:util AND CIBLE = (SELECT bordereau.ID_BORD as id_bord FROM bordereau,certif_bord WHERE bordereau.ID_BORD = certif_bord.ID_BORD AND STADE=:stadedeb AND ID_CERTIF=:certif ORDER BY bordereau.DATE_CREATION DESC LIMIT 1) ORDER BY DATE_CREATION");
							$query4 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
							$query4 -> bindParam(':stadedeb', $stadedeb, PDO::PARAM_INT);
							$query4 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);					
							$query4 -> execute();
							
							$stop = 0;
							while($data4 = $query4 -> fetch()){								
								
								$datedeb = $data4['DATE_CREATION'];
								
								if($stop == $num){
									break;
								}
								$stop++;
							}
						}
						$query4 -> closeCursor();						
					}
					
					$query5 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK, SUM(POIDS_NET) as P_N FROM ticket WHERE ID_CERTIF=:certif");
					$query5 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
					$query5 -> execute();
					$data5 = $query5 -> fetch();
					
					$tab[$i] = $data5['NB_TK'];
					$i++;
					$tab[$i] = $data5['P_N'];
					$i++;
					
					$query5 -> closeCursor();
					
					$query6 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE=:bord AND ACTION = 2 ORDER BY DATE_CREATION LIMIT 1");
					$query6 -> bindParam(':bord', $data['ID_BORD'], PDO::PARAM_INT);				
					$query6 -> execute();
					$data6 = $query6->fetch();
					$datefin = $data6['DATE_CREATION'];
					$query6 -> closeCursor();				

					$dateFin = date('Y-m-d', strtotime(date($datefin)));
					$dateDeb = date('Y-m-d', strtotime($datedeb));
					
					$time1 = date('H:i:s', strtotime($datefin));
					$time2 = date('H:i:s', strtotime($datedeb));  

					if($dateDeb == $dateFin){

						if($time1 == $time2){

							$heur = '00';
							$min = '00';
							$sec = '00';
						}
						else{

							$heur = diffHour($datedeb, $datefin)[0];
							$min = diffHour($datedeb, $datefin)[1];
							$sec = diffHour($datedeb, $datefin)[2];
						}
					}
					else{

						$heur = (((diffWorkDay($dateDeb, $dateFin)/86400)-1)*8);
						$heur += (calHourDep($datedeb)[0]) ;
						$heur += calHourFin($datefin)[0] ;
						$min = calHourDep($datedeb)[1] ;
						$min += calHourFin($datefin)[1] ;
						$sec = calHourDep($datedeb)[2] ;
						$sec += calHourFin($datefin)[2] ;
					}
					
					$heur = $heur - 1 ;
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

					$query7 = $bdd -> prepare("SELECT VAL_PREC, DATE_CREATION FROM journal WHERE CIBLE=:bord AND ACTION = 2 ORDER BY `DATE_CREATION` DESC");
					$query7 -> bindParam(':bord', $data['ID_BORD'], PDO::PARAM_INT);
					$query7 -> execute();
					$rows7 = $query7 -> rowCount();
					$data7 = $query7 -> fetch();
					
					if($rows7 >= 1){					
						
						$date7 = new DateTime($data7['DATE_CREATION']);				
						$tab[$i] = $date7 -> format('d/m/Y à H : i : s');
					}
					else{						
						$tab[$i] = $data7['DATE_CREATION'];
					}
					$i++;
					
					$query8 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL=:util");
					$query8 -> bindParam(':util', $data7['VAL_PREC'], PDO::PARAM_INT);
					$query8 -> execute();
					$data8 = $query8 -> fetch();
					
					$tab[$i] = $data8['NOM'].' '.$data8['PRENOM'];
					$i++;					
					$tab[$i] = ($data['STADE'] - 1);
					$i++;
					
					$query7 -> closeCursor();
					$query8 -> closeCursor();
				}
				$query2 -> closeCursor();			
			}
			$query1 -> closeCursor();		
		}
		$query -> closeCursor();		
	}
	else{
	
		if($typcompte == '1'){

			$query = $bdd -> prepare("SELECT ID_BORD, STADE FROM bordereau WHERE ID_USER=:util AND STADE = 1 AND STATUT = 1 ORDER BY DATE_CREATION DESC LIMIT 30");
			$query -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
			$query -> execute();
		}	
		elseif($typcompte == '2'){

			$query = $bdd -> prepare("SELECT ID_BORD, STADE FROM bordereau WHERE ID_USER=:util AND STADE IN (2,3,4,5) AND STATUT = 1 ORDER BY ID_BORD DESC LIMIT 30");
			$query -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
			$query -> execute();
		}
		
		while($data = $query->fetch()){
			
			$temp[0] = 0;
			$p = 0;
		
			$query1 = $bdd -> prepare("SELECT ID_CERTIF FROM certif_bord WHERE ID_BORD=:bd ORDER BY ID_CERTIF");
			$query1 -> bindParam(':bd', $data['ID_BORD'], PDO::PARAM_INT);
			$query1 -> execute();
			
			while($data1 = $query1->fetch()){
				
				$q = 0;
				$num = 0;
				
				while($q < ($p+1)){
					
					if($temp[$q] == $data1['ID_CERTIF']){
						$num++;
					}
					$q++;
				}
				$temp[$p+1] = $data1['ID_CERTIF'];
				$p++;
				
				$query2 = $bdd -> prepare("SELECT NUM_PCKLIST FROM certificat WHERE ID_CERTIF=:certi");
				$query2 -> bindParam(':certi', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query2 -> execute();
				
				while($data2 = $query2 -> fetch()){
					
					$tab[0] += 1 ; 

					if($typcompte == '1'){
						
						$tab[$i] = $data1['ID_CERTIF'];
						$i++;
						$tab[$i] = $data2['NUM_PCKLIST'];
						$i++;
						
						$query3 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE =:certif AND ACTION = 1");
						$query3 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
						$query3 -> execute();
						$data3 = $query3 -> fetch();
						$datedeb = $data3['DATE_CREATION'];
						$query3 -> closeCursor();
					}
					elseif($typcompte == '2'){
						
						$tab[$i] = $data1['ID_CERTIF'];
						$i++;
						$tab[$i] = $data2['NUM_PCKLIST'];
						$i++;
						$stadedeb = ($data['STADE'] - 1);
						
						if($num == 0){
							
							$query4 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 2 AND VAL_PREC =:util AND CIBLE = (SELECT bordereau.ID_BORD as id_bord FROM bordereau,certif_bord WHERE bordereau.ID_BORD = certif_bord.ID_BORD AND STADE=:stadedeb AND ID_CERTIF=:certif ORDER BY bordereau.DATE_CREATION DESC LIMIT 1) ORDER BY DATE_CREATION LIMIT 1");
							$query4 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
							$query4 -> bindParam(':stadedeb', $stadedeb, PDO::PARAM_INT);
							$query4 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);					
							$query4 -> execute();
							$data4 = $query4 -> fetch();
							$datedeb = $data4['DATE_CREATION'];							
						}
						else{
							
							$query4 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 2 AND VAL_PREC =:util AND CIBLE = (SELECT bordereau.ID_BORD as id_bord FROM bordereau,certif_bord WHERE bordereau.ID_BORD = certif_bord.ID_BORD AND STADE=:stadedeb AND ID_CERTIF=:certif ORDER BY bordereau.DATE_CREATION DESC LIMIT 1) ORDER BY DATE_CREATION");
							$query4 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
							$query4 -> bindParam(':stadedeb', $stadedeb, PDO::PARAM_INT);
							$query4 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);					
							$query4 -> execute();
							
							$stop = 0;
							while($data4 = $query4 -> fetch()){								
								
								$datedeb = $data4['DATE_CREATION'];
								
								if($stop == $num){
									break;
								}
								$stop++;
							}
						}
						$query4 -> closeCursor();						
					}
					
					$query5 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK, SUM(POIDS_NET) as P_N FROM ticket WHERE ID_CERTIF=:certif");
					$query5 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
					$query5 -> execute();
					$data5 = $query5 -> fetch();
					
					$tab[$i] = $data5['NB_TK'];
					$i++;
					$tab[$i] = $data5['P_N'];
					$i++;
					
					$query5 -> closeCursor();
					
					$query6 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE=:bord AND ACTION = 2 ORDER BY DATE_CREATION LIMIT 1");
					$query6 -> bindParam(':bord', $data['ID_BORD'], PDO::PARAM_INT);				
					$query6 -> execute();
					$data6 = $query6->fetch();
					$datefin = $data6['DATE_CREATION'];
					$query6 -> closeCursor();				

					$dateFin = date('Y-m-d', strtotime(date($datefin)));
					$dateDeb = date('Y-m-d', strtotime($datedeb));
					
					$time1 = date('H:i:s', strtotime($datefin));
					$time2 = date('H:i:s', strtotime($datedeb));  

					if($dateDeb == $dateFin){

						if($time1 == $time2){

							$heur = '00';
							$min = '00';
							$sec = '00';
						}
						else{

							$heur = diffHour($datedeb, $datefin)[0];
							$min = diffHour($datedeb, $datefin)[1];
							$sec = diffHour($datedeb, $datefin)[2];
						}
					}
					else{

						$heur = (((diffWorkDay($dateDeb, $dateFin)/86400)-1)*8);
						$heur += (calHourDep($datedeb)[0]) ;
						$heur += calHourFin($datefin)[0] ;
						$min = calHourDep($datedeb)[1] ;
						$min += calHourFin($datefin)[1] ;
						$sec = calHourDep($datedeb)[2] ;
						$sec += calHourFin($datefin)[2] ;
					}
					
					$heur = $heur - 1 ;
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

					$query7 = $bdd -> prepare("SELECT VAL_PREC,DATE_CREATION FROM journal WHERE CIBLE=:bord AND ACTION = 2 ORDER BY `DATE_CREATION` DESC");
					$query7 -> bindParam(':bord', $data['ID_BORD'], PDO::PARAM_INT);
					$query7 -> execute();
					$rows7 = $query7 -> rowCount();
					$data7 = $query7 -> fetch();
					
					if($rows7 >= 1){					
						
						$date7 = new DateTime($data7['DATE_CREATION']);				
						$tab[$i] = $date7 -> format('d/m/Y à H : i : s');
					}
					else{
						
						$tab[$i] = $data7['DATE_CREATION'];
					}
					$i++;
					
					$query8 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL=:util");
					$query8 -> bindParam(':util', $data7['VAL_PREC'], PDO::PARAM_INT);
					$query8 -> execute();
					$data8 = $query8 -> fetch();
					
					$tab[$i] = $data8['NOM'].' '.$data8['PRENOM'];
					$i++;					
					$tab[$i] = ($data['STADE'] - 1);
					$i++;
					
					$query7 -> closeCursor();
					$query8 -> closeCursor();
				}
				$query2 -> closeCursor();			
			}
			$query1 -> closeCursor();		
		}
		$query -> closeCursor(); 
	}
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>