<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	include_once('../config/Connexion.php');
	include_once('../functions/Date_management_function.php');

	$i = 0 ;
	$tab[0] = 0;

	if(!(empty($_POST['id']))){

		$tab[0] = 1;
		$i++;

		$query = $bdd -> prepare("SELECT IMPRIM_RECEPT FROM certificat WHERE ID_CERTIF =:id");
		$query -> bindParam(':id', $_POST['id'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();

		if($data['IMPRIM_RECEPT'] == 0){
			
			$query10 = $bdd -> prepare("UPDATE certificat SET IMPRIM_RECEPT = 1 WHERE ID_CERTIF =:id");
			$query10 -> bindParam(':id', $_POST['id'], PDO::PARAM_INT);
			$query10 -> execute();
			$query10 -> closeCursor();
		}

		$query2 = $bdd -> prepare("SELECT ID_CERTIF, NUM_PCKLIST, STATUT, ID_TYPPROD, IMPRIM_RECEPT, DATE_CREATION  FROM certificat WHERE ID_CERTIF =:id");
		$query2 -> bindParam(':id', $_POST['id'], PDO::PARAM_INT);
		$query2 -> execute();

		while($data1 = $query2 -> fetch()){

	        if($data1['STATUT'] == 4) {

	            $query6 = $bdd -> prepare("SELECT DATE_CREATION FROM journal WHERE ACTION = 5 AND CIBLE =:pckl ORDER BY DATE_CREATION DESC");
	            $query6 -> bindParam(':pckl', $data1['ID_CERTIF'], PDO::PARAM_INT);
	            $query6 -> execute();

	            while($data6 = $query6 -> fetch()){

	                $dAction = $data6['DATE_CREATION'];
	                $dServeur = date_create(date('Y-m-d H:i:s')); 
	                $dComp = date_create($dAction);
	                $nw = $dServeur -> format('U');
	                $dt = $dComp -> format('U');
	                $psed = ($nw - $dt);

	                if($psed < 86400){
	                    $bool = true;
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

	            $query2 = $bdd ->prepare("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =:prod");
	            $query2 -> bindParam(':prod', $data1['ID_TYPPROD'], PDO::PARAM_INT);
	            $query2 -> execute();
	            $data2 = $query2 -> fetch();

	            $tab[$i] = $data2['LIBELLE'];
	            $i++;

	            $query2 -> closeCursor();

	            $poids = 0;
	            $query4 = $bdd -> prepare("SELECT POIDS_NET FROM ticket WHERE ID_TICKET =:tck");
	            $query4 -> bindParam(':tck', $data1['ID_CERTIF'], PDO::PARAM_INT);
	            $query4 -> execute();

	            while($data4 = $query4 -> fetch()){
	                $poids += $data4['POIDS_NET'];
	            }
	            $query4 -> closeCursor();

	            $tab[$i]= $poids;
	            $i++;
	            $datedit = new DateTime($data1['DATE_CREATION']);               
	            $tab[$i] = $datedit->format('d/m/Y à H : i : s');
	            $i++;           
	            $tab[$i]= $data1['IMPRIM_RECEPT'];
	            $i++;

	            if($data1['STATUT'] == 0){

	                $heur = "00";
	                $min = "00";
	                $sec = "00";
	            }
	            elseif($data1['STATUT'] == 4){

	                $heur = "00";
	                $min = "00";
	                $sec = "00";
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
	            $tab[$i] = $heur.":".$min.":".$sec;
	            $i++;
	            $tab[$i] = $data1['STATUT'];
	            $i++;
	        }
	    }		
		$query2 -> closeCursor();
		$query -> closeCursor();
	}
	$bdd = null;

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>