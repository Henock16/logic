<?php

	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
    session_start();

    include_once('../config/Connexion.php');
	
	if(!empty($_POST['idcert'])){
		
		$i = 1;
		$tab[0] = 1;
		
		$query = $bdd -> prepare("SELECT ID_TRANSIT, CLIENT, ID_DEST, ID_DEMANDEUR, NAVIRE, STATUT, STADE, ID_USER_COUR, ID_USER_PREC FROM certificat WHERE ID_CERTIF = :idcert");
		$query -> bindParam(':idcert', $_POST['idcert'], PDO::PARAM_INT);
		$query -> execute();
		
		while($data = $query -> fetch()){
			
			$tab[$i] = $data['CLIENT'] ;
			$i++;
			$tab[$i] = $data['NAVIRE'] ;
			$i++;
			$tab[$i] = $data['STATUT'] ;
			$i++;
			$tab[$i] = $data['STADE'] ;
			$i++;
			
			$query1 = $bdd -> prepare("SELECT LIBELLE FROM transitaire WHERE ID_TRANSIT = :idtrans");
			$query1 -> bindParam(':idtrans', $data['ID_TRANSIT'], PDO::PARAM_INT);
			$query1 -> execute();
			$data1 = $query1 -> fetch();
			
			$tab[$i] = $data1['LIBELLE'] ;
			$i++;
			
			$query1 -> closeCursor();
			
			$query2 = $bdd -> prepare("SELECT PAYS, PORT FROM destination WHERE ID_DEST = :iddest");
			$query2 -> bindParam(':iddest', $data['ID_DEST'], PDO::PARAM_INT);
			$query2 -> execute();
			$data2 = $query2 -> fetch();
			
			$tab[$i] = $data2['PORT']." / ".$data2['PAYS'] ;
			$i++;
			
			$query2 -> closeCursor();
			
			$query3 = $bdd -> prepare("SELECT STRUCTURE FROM demandeur WHERE ID_DEMAND = :iddem");
			$query3 -> bindParam(':iddem', $data['ID_DEMANDEUR'], PDO::PARAM_INT);
			$query3 -> execute();
			$data3 = $query3 -> fetch();
			
			$tab[$i] = $data3['STRUCTURE'];
			$i++;
			
			$query3 -> closeCursor();
			
			if($data['ID_USER_PREC'] == 0 ){
				
				$tab[$i] = "Administrateur";
				$i++;
			}
			else{
			
				$query6 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL = :idutil");
				$query6 -> bindParam(':idutil', $data['ID_USER_PREC'], PDO::PARAM_INT);
				$query6 -> execute();
				$data6 = $query6 -> fetch();
				
				$tab[$i] = $data6['NOM']." ".$data6['PRENOM'];
				$i++;
				
				$query6 -> closeCursor();
			}
			
			if($data['ID_USER_COUR'] == 0 ){
				
				$tab[$i] = "Administrateur";
				$i++;
			}
			else{
			
				$query4 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL = :idutil");
				$query4 -> bindParam(':idutil', $data['ID_USER_COUR'], PDO::PARAM_INT);
				$query4 -> execute();
				$data4 = $query4 -> fetch();
				
				$tab[$i] = $data4['NOM']." ".$data4['PRENOM'];
				$i++;
				
				$query4 -> closeCursor();
			}
		}
		$query -> closeCursor();
		
		$query5 = $bdd -> prepare("SELECT COUNT(ID_TICKET) AS NB FROM ticket WHERE ID_CERTIF = :idcert");
		$query5 -> bindParam(':idcert', $_POST['idcert'], PDO::PARAM_INT);
		$query5 -> execute();
		$data5 = $query5 -> fetch();
		
		$tab[$i] = $data5['NB'] ;
		$i++;
		
		$query5 -> closeCursor();
	}
	else{
		include_once('../functions/Date_management_function.php');

		$i = 0 ;
		$tab[0] = 0;
		$i++;

		if($_SESSION['ROLE'] == 2){
			
			if($_SESSION['ID_VILLE'] == 1){
                $bke = 3;
            }else{
                $bke = 0;
            }       
			$query1 = $bdd -> prepare("SELECT ID_CERTIF, NUM_PCKLIST, STATUT, ID_VILLE, ID_TYPPROD, DATE_CREATION  FROM certificat WHERE ID_CAMP IN (SELECT ID_CAMP FROM campagne WHERE STATUT = 0) AND STATUT NOT IN(3,4) AND A_R <> 1 AND DISABLED = 0 AND (ID_VILLE = :ville OR ID_VILLE=:ville2) ORDER BY DATE_CREATION DESC");
			$query1 -> bindParam(':ville', $_SESSION['ID_VILLE'], PDO::PARAM_INT);
			$query1 -> bindParam(':ville2', $bke, PDO::PARAM_INT);
			$query1 -> execute();
			$tab[$i] = $query1->rowcount();
			$i++;
		}
		else if($_SESSION['ROLE'] != 2){
			
			$query1 = $bdd -> query("SELECT ID_CERTIF, NUM_PCKLIST, STATUT,ID_VILLE, ID_TYPPROD, DATE_CREATION  FROM certificat WHERE ID_CAMP IN (SELECT ID_CAMP FROM campagne WHERE STATUT = 0) AND STATUT NOT IN(3,4) AND A_R <> 1 AND DISABLED = 0 ORDER BY DATE_CREATION DESC");
			$query1 -> execute();
			$tab[$i] = $query1->rowcount();
			$i++;
		}
		while($data1 = $query1 -> fetch()){

				$tab[$i] = $data1['ID_CERTIF'];
				$i++;
				$tab[$i] = $data1['NUM_PCKLIST'];
				$i++;

				$query2 = $bdd -> prepare("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =:prod");
				$query2 -> bindParam(':prod', $data1['ID_TYPPROD'], PDO::PARAM_INT);
				$query2 -> execute();
				$data2 = $query2->fetch();
				
				$tab[$i] = $data2['LIBELLE'];
				$i++;
				
				$query2 -> closeCursor();
				
				$datedit = new DateTime($data1['DATE_CREATION']);				
				$tab[$i] = $datedit->format('d/m/Y à H : i : s');
				$i++;

				$poids = 0;
				$query4 = $bdd -> prepare("SELECT POIDS_NET FROM ticket WHERE ID_CERTIF =:cert");
				$query4 -> bindParam(':cert', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query4 -> execute();
				
				while($data4 = $query4 -> fetch()){
					$poids += $data4['POIDS_NET'];
				}
				$query4 -> closeCursor();

				$tab[$i] = $poids;
				$i++;                     
				$query5 = $bdd -> prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
				$query5 -> bindParam(':vil', $data1['ID_VILLE'], PDO::PARAM_INT);
				$query5 -> execute();
				$data5 = $query5 -> fetch();
				
				$tab[$i] = $data5['LIBELLE'];
				$i++;
				
				$query5 -> closeCursor();

			if($data1['STATUT'] == 0){

				$heur = "0";
				$min = "0";
				$sec = "0";
			}
			elseif($data1['STATUT'] == 1){

				$query8 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 1 AND CIBLE =:pckl ORDER BY DATE_CREATION DESC LIMIT 1");
				$query8 -> bindParam(':pckl', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query8 -> execute();
				$data8 = $query8 -> fetch();

				$datAction = $data8['DATE_CREATION'];

				$query8 -> closeCursor();

				$dateServeur = date('Y-m-d', strtotime(date('Y-m-d H:i:s')));
				$dateComp = date('Y-m-d', strtotime($datAction));
				$dateServeur1 = date('Y-m-d H:i:s');

				if($dateComp == $dateServeur){
					$heur = diffHour($datAction, $dateServeur1)[0];
					$min = diffHour($datAction, $dateServeur1)[1];
					$sec = diffHour($datAction, $dateServeur1)[2];
				}
				else{
					$heur = ((diffWorkDay($dateComp, $dateServeur) / 86400)-1)*8;
					$heur += (calHourDep($datAction)[0]) ;
					$heur += calHourFin($dateServeur1)[0] ;
					$min = calHourDep($datAction)[1] ;
					$min += calHourFin($dateServeur1)[1] ;
					$sec = calHourDep($datAction)[2] ;
					$sec += calHourFin($dateServeur1)[2] ;
				}
				while($sec >= 60){
					$min++;
					$sec -= 60;
				}
				while($min >= 60){
					$heur++;
					$min -= 60;
				}

			}
			elseif($data1['STATUT'] == 2){

				$query9= $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 3 AND CIBLE =:pckl ORDER BY DATE_CREATION DESC");
				$query9 -> bindParam(':pckl', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query9 -> execute();
				$data9 = $query9 -> fetch();

				$datAction = $data9['DATE_CREATION'];

				$query9 -> closeCursor(); 

				$dateServeur = date('Y-m-d', strtotime(date('Y-m-d H:i:s')));
				$dateComp = date('Y-m-d', strtotime($datAction));
				$dateServeur1 = date('Y-m-d H:i:s');

				if($dateComp == $dateServeur){
					$heur = diffHour($datAction, $dateServeur1)[0];
					$min = diffHour($datAction, $dateServeur1)[1];
					$sec = diffHour($datAction, $dateServeur1)[2];
				}
				else{
					$heur = ((diffWorkDay($dateComp, $dateServeur) / 86400)-1)*8;
					$heur += (calHourDep($datAction)[0]) ;
					$heur += calHourFin($dateServeur1)[0] ;
					$min = calHourDep($datAction)[1] ;
					$min += calHourFin($dateServeur1)[1] ;
					$sec = calHourDep($datAction)[2] ;
					$sec += calHourFin($dateServeur1)[2] ;
				}

				while($sec >= 60){
					$min++;
					$sec -= 60;
				}

				while($min >= 60){
					$heur++;
					$min -= 60;
				}
			}
			$tab[$i] = $heur;
			$i++;
			$tab[$i] = $min;
			$i++;
			$tab[$i] = $sec;
			$i++;
			
		}
		$query1 -> closeCursor();
	}
	
    $bdd = null;
	
    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);
?>