<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
    session_start();
    
    include_once('../config/Connexion.php');

    if(!empty($_POST['idcert'])){
        
        $i = 1;
        $tab[0] = 1;
        $query = $bdd -> prepare("SELECT ID_TRANSIT, ID_CERTIF, NUM_CERTIF, CLIENT, ID_DEST, ID_DEMANDEUR, NAVIRE, A_R, STATUT, ID_USER_COUR, ID_USER_PREC FROM certificat WHERE ID_CERTIF = :idcert");
        $query -> bindParam(':idcert', $_POST['idcert'], PDO::PARAM_INT);
        $query -> execute();
        
        while($data = $query -> fetch()){
            
            $tab[$i] = $data['CLIENT'] ;
            $i++;
            $tab[$i] = $data['NAVIRE'] ;
            $i++;
            if($data['A_R']==1){

                $query7 = $bdd->prepare("SELECT ID_A_R FROM certificat WHERE ID_CERTIF =:pkl ");
                $query7 -> bindParam(':pkl', $data['ID_CERTIF'], PDO::PARAM_INT);
                $query7 -> execute();
                $data7 = $query7->fetch();

                $query8 = $bdd->prepare("SELECT NUM_PCKLIST FROM certificat WHERE ID_PCKLIST =:pkl ");
                $query8 -> bindParam(':pkl', $data7['ID_A_R'], PDO::PARAM_INT);
                $query8 -> execute();
                $data8 = $query8->fetch();
                $tab[$i]= $data8['NUM_PCKLIST'];
                $i++;
                $query8 -> closeCursor();
                $query7 -> closeCursor();

            }
            else{

                $tab[$i] = 0;
                $i++;

            }

            if($data['STATUT']==3){

                $tab[$i]="Rejeté";
                $i++;
            }
            elseif($data['STATUT']==4){

                $tab[$i]="Transmis au CCA";
                $i++;
            }
			elseif($data['STATUT']==2){

                $tab[$i]="Traité";
                $i++;
            }
            else{

                $tab[$i] = 0;
                $i++;
            }
        
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

			if($data['STATUT'] == 4 || $data['STATUT'] == 2 ){
				
				if($data['ID_USER_COUR'] == 0 ){
					
					$query4 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL = :idutil");
					$query4 -> bindParam(':idutil', $data['ID_USER_PREC'], PDO::PARAM_INT);
					$query4 -> execute();
					$data4 = $query4 -> fetch();
					
					$tab[$i] = $data4['NOM']." ".$data4['PRENOM'];
					$i++;
					
					$query4 -> closeCursor();
				}
			}
            
			$query5 = $bdd -> prepare("SELECT COUNT(ID_TICKET) AS NB FROM ticket WHERE ID_CERTIF = :idcert");
			$query5 -> bindParam(':idcert', $_POST['idcert'], PDO::PARAM_INT);
			$query5 -> execute();
			$data5 = $query5 -> fetch();
			
			$tab[$i] = $data5['NB'] ;
			$i++;
			
			$query5 -> closeCursor();

			$tab[$i] = $data['NUM_CERTIF'] ;
			$i++;
		}
		$query -> closeCursor();
    }
    else{
        
        include_once('../functions/Date_management_function.php');

        $tab[0] = 0;
        $i = 1 ;  
		if($_SESSION['ROLE'] == 2){
			
			if($_SESSION['ID_VILLE'] == 1){
                $bke = 3;
            }else{
                $bke = 0;
            }   
			
			$query1 = $bdd -> prepare("SELECT DISTINCT(ID_CERTIF), NUM_PCKLIST,NUM_CERTIF, STATUT, ID_VILLE, certificat.DATE_CREATION AS DATE_CREATION, ID_USER_PREC,journal.DATE_CREATION FROM certificat,journal WHERE ID_CERTIF=CIBLE AND ACTION= 3 AND STATUT IN(4) AND A_R IN(0,2) AND ID_CAMP IN (SELECT ID_CAMP FROM campagne WHERE STATUT = 0)AND (ID_VILLE = :ville OR ID_VILLE=:ville2) ORDER BY journal.DATE_CREATION DESC LIMIT 150 ");
			$query1 -> bindParam(':ville', $_SESSION['ID_VILLE'], PDO::PARAM_INT);
			$query1 -> bindParam(':ville2', $bke, PDO::PARAM_INT);
			$query1 -> execute();
			$tab[$i] = $query1->rowcount();
			$i++;
		}
		else if($_SESSION['ROLE'] != 2){
			
			$query1 = $bdd -> query("SELECT DISTINCT(ID_CERTIF), NUM_PCKLIST,NUM_CERTIF, STATUT, ID_VILLE, certificat.DATE_CREATION AS DATE_CREATION, ID_USER_PREC,journal.DATE_CREATION FROM certificat,journal WHERE ID_CERTIF=CIBLE AND ACTION= 3 AND STATUT IN(2,4) AND A_R IN(0,2) AND ID_CAMP IN (SELECT ID_CAMP FROM campagne WHERE STATUT = 0) ORDER BY journal.DATE_CREATION DESC LIMIT 500");
			$query1 -> execute();
			$tab[$i] = $query1->rowcount();
			$i++;
		}
		
        while($data1 = $query1 -> fetch()){
			
            $tab[$i] = $data1['ID_CERTIF'];
            $i++;			
			$tab[$i] = $data1['NUM_CERTIF'];
			$i++;			
            $tab[$i] = $data1['NUM_PCKLIST'];
            $i++;
            $datedit = new DateTime($data1['DATE_CREATION']);               
            $tab[$i] = $datedit->format('d/m/Y à H : i : s');
            $i++;
            
            $query4= $bdd ->prepare("SELECT POIDS_NET FROM ticket WHERE ID_CERTIF =:certif");
            $query4 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
            $query4 -> execute();
			
			$poids = 0;
            while($data4 = $query4->fetch()){

                $poids = $poids + $data4['POIDS_NET'];
            }
            $query4 -> closeCursor();

            $tab[$i]= $poids;
            $i++;

            $query5= $bdd ->prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
            $query5 -> bindParam(':vil', $data1['ID_VILLE'], PDO::PARAM_INT);
            $query5 -> execute();
            $data5 = $query5->fetch();
            $tab[$i]= $data5['LIBELLE'];
            $i++;
            $query5 -> closeCursor();
			
			if($data1['STATUT'] == 2){
				
				$tab[$i]= "0";
				$i++;
				$tab[$i]= "0";
				$i++;
				$tab[$i]= "0";
				$i++;
				$tab[$i]= $data1['NUM_PCKLIST'];
				$i++;
				$tab[$i]= $data1['ID_USER_PREC'];
				$i++;
            }
          
			if($data1['STATUT'] == 4){
				
				
				$query8= $bdd ->prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 1 AND CIBLE =:pckl ORDER BY DATE_CREATION DESC LIMIT 1");
				$query8 -> bindParam(':pckl', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query8 -> execute();
				$data8 = $query8->fetch();
				$datAction = $data8['DATE_CREATION'];
				$query8 -> closeCursor();

				$query6= $bdd ->prepare("SELECT DATE_CREATION FROM journal WHERE ACTION IN(5) AND CIBLE =:pckl ORDER BY DATE_CREATION DESC");
				$query6 -> bindParam(':pckl', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query6 -> execute();
				$data6 = $query6->fetch();
				$dAction = $data6['DATE_CREATION'];
				$query6 -> closeCursor();
				$dateServeur = date('Y-m-d', strtotime($dAction));
				$dateComp = date('Y-m-d', strtotime($datAction));

				$dateServeur1 = $dAction;

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
			
				$tab[$i]= $heur;
				$i++;
				$tab[$i]= $min;
				$i++;
				$tab[$i]= $sec;
				$i++;
				$tab[$i]= $data1['NUM_PCKLIST'];
				$i++;
				$tab[$i]= $data1['ID_USER_PREC'];
				$i++;
            }
        }
        $query1 -> closeCursor();
		
		$tab[$i]= $_SESSION['ROLE'];
    }
    $bdd = null;

    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);
?>