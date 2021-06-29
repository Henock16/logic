<?php
ini_set('session.gc_maxlifetime','28800');
//ini_set('session.save_path','c:/wamp/sessions');
session_start();

include_once('../config/Connexion.php');
include_once('../functions/Date_management_function.php');

$i =0 ;

$tab[0]=0;
$i++;

	$query6 = $bdd ->query("SELECT COUNT(ID_CERTIF) AS nb_certif FROM certificat WHERE STADE IN(2,3,4,5,6) AND  BLOCKED = 0 AND ERREUR = 0 AND A_R = 0 AND DISABLED = 0");
	$data6 = $query6->fetch();
	$tab[$i]=$data6['nb_certif'];
	$i++;
	$query6 -> closeCursor();

	$query7 = $bdd ->query("SELECT ID_CERTIF, ID_TRANSIT, NUM_PCKLIST, ID_EXP, ID_TYPPROD, ID_VILLE, NUM_OT, ID_USER_COUR, STADE, DATE_CREATION FROM certificat WHERE STADE IN(2,3,4,5,6) AND  BLOCKED = 0 AND ERREUR = 0 AND A_R = 0 AND DISABLED = 0");

	while($data7 = $query7->fetch()){

		$tab[$i]= $data7['ID_CERTIF'];
		$i++;
		$tab[$i]= $data7['NUM_PCKLIST'];
		$i++;
		$tab[$i]= $data7['NUM_OT'];
		$i++;

		$query8= $bdd ->prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
		$query8 -> bindParam(':vil', $data7['ID_VILLE'], PDO::PARAM_INT);
		$query8 -> execute();
		$data8 = $query8->fetch();
		$tab[$i]= $data8['LIBELLE'];
		$i++;
		$query8 -> closeCursor();

		$query9= $bdd ->prepare("SELECT LIBELLE FROM transitaire WHERE ID_TRANSIT =:trans");
		$query9 -> bindParam(':trans', $data7['ID_TRANSIT'], PDO::PARAM_INT);
		$query9 -> execute();
		$data9 = $query9->fetch();
		$tab[$i]= $data9['LIBELLE'];
		$i++;
		$query9 -> closeCursor();

		$query10= $bdd ->prepare("SELECT LIBELLE FROM exportateur WHERE ID_EXP =:exp");
		$query10 -> bindParam(':exp', $data7['ID_EXP'], PDO::PARAM_INT);
		$query10 -> execute();
		$data10 = $query10->fetch();
		$tab[$i]= $data10['LIBELLE'];
		$i++;
		$query10 -> closeCursor();
		
		$query11= $bdd ->prepare("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =:prod");
		$query11 -> bindParam(':prod', $data7['ID_TYPPROD'], PDO::PARAM_INT);
		$query11 -> execute();
		$data11= $query11->fetch();
		$tab[$i]= $data11['LIBELLE'];
		$i++;
		$query11 -> closeCursor();

		$tab[$i]= $data7['DATE_CREATION'];
		$i++;

		$poid=0;
		$query12= $bdd ->prepare("SELECT POIDS_NET FROM ticket WHERE ID_CERTIF =:certif");
		$query12 -> bindParam(':certif', $data7['ID_CERTIF'], PDO::PARAM_INT);
		$query12 -> execute();
		while($data12= $query12->fetch()){

			$poid+= $data12['POIDS_NET'];
		}

		$tab[$i]=$poid;
		$i++;
		$query12 -> closeCursor();

		$query14= $bdd ->prepare("SELECT NOM,PRENOM FROM utilisateur WHERE ID_UTIL =:util");
		$query14 -> bindParam(':util', $data7['ID_USER_COUR'], PDO::PARAM_INT);
		$query14 -> execute();
		$data14= $query14->fetch();
		$tab[$i]= $data14['NOM'].' '.$data14['PRENOM'];
		$i++;
		$query14 -> closeCursor();
		
		$query13= $bdd ->prepare("SELECT DATE_CREATION FROM journal WHERE CIBLE =:certif AND ACTION = 2 ORDER BY DATE_CREATION DESC");
		$query13 -> bindParam(':certif', $data7['ID_CERTIF'], PDO::PARAM_INT);
		$query13 -> execute();
		$data13= $query13->fetch();

		$datedeb = $data13['DATE_CREATION'];
		$datefin = date('Y-m-d');

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
		
		$query13 -> closeCursor();

		$tck=0;
		$query3= $bdd ->prepare("SELECT COUNT(ID_TICKET) AS nb_tck FROM ticket WHERE ID_CERTIF =:certif");
		$query3 -> bindParam(':certif', $data7['ID_CERTIF'], PDO::PARAM_INT);
		$query3 -> execute();
		$data3 = $query3->fetch();

		$tck+= $data3['nb_tck'];
		
		$query3 -> closeCursor();

		$tab[$i] =$tck;
		$i++;

		$tab[$i] =$data7['STADE'];
		$i++;

	}

	$query7 -> closeCursor();

$bdd = null;
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>