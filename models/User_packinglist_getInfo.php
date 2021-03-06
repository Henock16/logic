<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
    session_start();

    include_once('../config/Connexion.php');
	
	if( (isset($_POST['idcert'])) && (!empty($_POST['idcert'])) ){
		
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

		global $bool;
		$bool = false;
		$i = 0 ;
		$tab[0] = 0;
		$i++;

		if($_SESSION['ROLE'] == 2){
			
			$query = $bdd -> query("SELECT COUNT(ID_CERTIF) AS nb_cert FROM certificat WHERE ID_VILLE = ".$_SESSION['ID_VILLE']." AND ID_CAMP IN (SELECT ID_CAMP FROM campagne WHERE STATUT = 0)");
			$data = $query -> fetch();
			
			$tab[$i] = $data['nb_cert'];
			$i++;
			
			$query -> closeCursor();

			$query1 = $bdd -> query("SELECT ID_CERTIF, NUM_PCKLIST, STADE, STATUT, ID_VILLE, A_R, DISABLED, ID_EXP, ID_TYPPROD, DATE_CREATION FROM certificat WHERE ID_VILLE = ".$_SESSION['ID_VILLE']." AND ID_CAMP IN (SELECT ID_CAMP FROM campagne WHERE STATUT = 0)ORDER BY DATE_CREATION DESC");
		}
		else if($_SESSION['ROLE'] != 2){
			
			$query = $bdd -> query("SELECT COUNT(ID_CERTIF) AS nb_cert FROM certificat WHERE ID_CAMP IN (SELECT ID_CAMP FROM campagne WHERE STATUT = 0) ");
			$data = $query -> fetch();
			
			$tab[$i] = $data['nb_cert'];
			$i++;
			
			$query -> closeCursor();

			$query1 = $bdd -> query("SELECT ID_CERTIF, NUM_PCKLIST, STADE, STATUT, ID_VILLE, A_R, DISABLED, ID_EXP, ID_TYPPROD, DATE_CREATION FROM certificat WHERE ID_CAMP IN (SELECT ID_CAMP FROM campagne WHERE STATUT = 0) ORDER BY DATE_CREATION DESC");
		}

		while($data1 = $query1 -> fetch()){

			if (($data1['STATUT'] == 3)||($data1['STATUT'] == 4)) {

				$query6 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION IN(4,5) AND CIBLE =:pckl ORDER BY DATE_CREATION DESC");
				$query6 -> bindParam(':pckl', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query6 -> execute();

				while($data6 = $query6 -> fetch()){

					$dAction = $data6['DATE_CREATION'];
					$dServeur = date_create(date('Y-m-d H:i:s')); 
					$dComp = date_create($dAction);

					$nw = $dServeur -> format('U');
					$dt = $dComp -> format('U');

					$psed =($nw - $dt);

					if($psed<86400){
						$bool=true;
					}
				}
				$query6 -> closeCursor();
			}
			else{
				$bool = true;
			}
			
			if($bool == true ){

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

				$query3 = $bdd -> prepare("SELECT LIBELLE FROM exportateur WHERE ID_EXP =:exp");
				$query3 -> bindParam(':exp', $data1['ID_EXP'], PDO::PARAM_INT);
				$query3 -> execute();
				$data3 = $query3 -> fetch();
				
				$tab[$i] = $data3['LIBELLE'];
				$i++;
				
				$query3 -> closeCursor();
				
				$datedit = new DateTime($data1['DATE_CREATION']);				
				$tab[$i] = $datedit->format('d/m/Y ?? H : i : s');
				$i++;

				$poids = 0;
				$query4 = $bdd -> prepare("SELECT POIDS_NET FROM ticket WHERE ID_TICKET =:tck");
				$query4 -> bindParam(':tck', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query4 -> execute();
				
				while($data4 = $query4 -> fetch()){
					$poids += $data4['POIDS_NET'];
				}
				$query4 -> closeCursor();

				$tab[$i] = $poids;
				$i++;
				$tab[$i] = $data1['STADE'];
				$i++;
				$tab[$i] = $data1['STATUT'];
				$i++;
				$tab[$i] = $data1['DISABLED'];
				$i++;

				$query5 = $bdd -> prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
				$query5 -> bindParam(':vil', $data1['ID_VILLE'], PDO::PARAM_INT);
				$query5 -> execute();
				$data5 = $query5 -> fetch();
				
				$tab[$i] = $data5['LIBELLE'];
				$i++;
				
				$query5 -> closeCursor();

				if($data1['DISABLED'] == 1){

					$heur = "00";
					$min = "00";
					$sec = "00";

					if($data1['A_R'] == 1){

						$query7 = $bdd -> prepare("SELECT NUM_PCKLIST FROM certificat WHERE ID_CERTIF =:pkl");
						$query7 -> bindParam(':pkl', $data1['ID_CERTIF'], PDO::PARAM_INT);
						$query7 -> execute();
						$data7 = $query7 -> fetch();
						
						$tab[$i] = "Remplac?? par ".$data1['NUM_PCKLIST'];
						$i++;
						
						$query7 -> closeCursor();
					}

					$tab[$i]=$heur." : ".$min." : ".$sec;
					$i++;
				}
				else{

					if($data1['STATUT'] == 0){

						$tab[$i] = "En attente";
						$i++;

						$heur = "00";
						$min = "00";
						$sec = "00";
					}
					elseif($data1['STATUT'] == 3){
						
						$tab[$i] = "Rejet??";
						$i++;

						$heur = "00";
						$min = "00";
						$sec = "00";

					}
					elseif($data1['STATUT'] == 4){

						$tab[$i] = "Transmis";
						$i++;

						$heur = "00";
						$min = "00";
						$sec = "00";
					}
					elseif($data1['STATUT'] == 1){

						$tab[$i] = "Traitement en cours";
						$i++;

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

					if($data1['STATUT'] == 2){
						
						$tab[$i] = "Trait??";
						$i++;
						
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
					$tab[$i]=$heur." : ".$min." : ".$sec;
					$i++;
				}
			}
		}
		$query1 -> closeCursor();
	}
	
    $bdd = null;
	
    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);
?>