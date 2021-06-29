<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	include('../config/Connexion.php');

	if(!empty($_POST['numpk'])){

		$num_pk = $_POST['numpk'];
		$i = 0;
		$an = date('Y');
		$y = 0;
		$j = 0;
		$ta20 = 0;
		$ta40 = 0;
		$weight = 0;
		
		$query = $bdd -> prepare("SELECT *, DATE_FORMAT( DATE( DATE_PACKLIST ) , '%d/%m/%Y' ) as DATEPK FROM certificat WHERE NUM_PCKLIST=:numpck AND BLOCKED = 0 AND DISABLED = 0 AND A_R IN(0,2) AND ID_USER_COUR=:util ORDER BY DATE_CREATION");
		$query -> bindParam(':numpck', $num_pk, PDO::PARAM_STR);
		$query -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
		$query -> execute();
		$rows = $query -> rowCount();
		$data = $query -> fetch();

		if($rows > 0){

			$query1 = $bdd -> prepare("SELECT LIBELLE FROM recolte WHERE ID_REC=:reco");
			$query1 -> bindParam(':reco', $data['ID_REC'], PDO::PARAM_INT);
			$query1 -> execute();
			$data1 = $query1 -> fetch();
			$reco = $data1['LIBELLE'];
			$query1 -> closeCursor();

			$query2 = $bdd -> prepare("SELECT LIBELLE FROM campagne WHERE ID_CAMP=:camp");
			$query2 -> bindParam(':camp', $data['ID_CAMP'], PDO::PARAM_INT);
			$query2 -> execute();
			$data2 = $query2 -> fetch();
			$camp = $data2['LIBELLE'];
			$query2 -> closeCursor();

			$query3 = $bdd -> prepare("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD=:prod");
			$query3 -> bindParam(':prod', $data['ID_TYPPROD'], PDO::PARAM_INT);
			$query3 -> execute();
			$data3 = $query3 -> fetch();
			$prod = $data3['LIBELLE'];
			$query3 -> closeCursor();

			$query4 = $bdd -> prepare("SELECT LIBELLE FROM exportateur WHERE ID_EXP=:expor");
			$query4 -> bindParam(':expor', $data['ID_EXP'], PDO::PARAM_INT);
			$query4 -> execute();
			$data4 = $query4 -> fetch();
			$exp = $data4['LIBELLE'];
			$query4 -> closeCursor();

			$query5 = $bdd -> prepare("SELECT LIBELLE FROM transitaire WHERE ID_TRANSIT=:trans");
			$query5 -> bindParam(':trans', $data['ID_TRANSIT'], PDO::PARAM_INT);
			$query5 -> execute();
			$data5 = $query5 -> fetch();
			$trans = $data5['LIBELLE'];
			$query5 -> closeCursor();

			$query6 = $bdd -> prepare("SELECT PAYS,PORT FROM destination WHERE ID_DEST=:dest");
			$query6 -> bindParam(':dest', $data['ID_DEST'], PDO::PARAM_INT);
			$query6 -> execute();
			$data6 = $query6 -> fetch();
			$pay = $data6['PORT'].'-'.$data6['PAYS'];
			$query6 -> closeCursor();

			$query7 = $bdd -> prepare("SELECT LIBELLE FROM egreneur WHERE ID_EGRE=:egre");
			$query7 -> bindParam(':egre', $data['ID_EGRE'], PDO::PARAM_INT);
			$query7 -> execute();
			$data7 = $query7 -> fetch();
			$egre = $data7['LIBELLE'];
			$query7 -> closeCursor();

			$query8 = $bdd -> prepare("SELECT NUM_CERTIF FROM certificat WHERE ID_CERTIF=:certi");
			$query8 -> bindParam(':certi', $data['ID_CERTIF'], PDO::PARAM_INT);
			$query8 -> execute();
			$data8 = $query8 -> fetch();
			$numcertif = $data8['NUM_CERTIF'];
			$query8 -> closeCursor();
			
			$tab[$i] = 1;
			$i++;
			$tab[$i] = $data['ID_PROD'];
			$i++;
			$tab[$i] = $numcertif;
			$i++;
			$tab[$i] = $reco;
			$i++;
			$tab[$i] = $camp;
			$i++;
			$tab[$i] = $prod;
			$i++;
			$tab[$i] = $data['DATEPK'];
			$i++;
			$tab[$i] = $trans;
			$i++;

			if($data['ID_PROD']=='2'){

				$tab[$i] = $egre;
				$i++;
				$tab[$i] = $data['NUM_INST_CLI'];
				$i++;
				$tab[$i] = $data['NUM_INST_FOUR'];
				$i++;
				$tab[$i] = $data['NUM_DOSS'];
				$i++;
			}

			$tab[$i] = $exp;
			$i++;
			$tab[$i] = $data['CLIENT'];
			$i++;
			$tab[$i] = $pay;
			$i++;
			$tab[$i] = $data['NAVIRE'];
			$i++;
			$tab[$i] = $data['NUM_PCKLIST'];
			$i++;
			$tab[$i] = $data['NUM_RAP_EMP'];
			$i++;

			if($data['ID_PROD']=='1'){
				$tab[$i] = $data['NUM_OT'];
				$i++;
			}

			$query9 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK FROM ticket WHERE ID_CERTIF=:certif");
			$query9 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
			$query9 -> execute();	

			while ($data9 = $query9 -> fetch()){

				$tab[$i] = $data9['NB_TK'];
				$i++;
			}
			$query9 -> closeCursor();

			$query10 = $bdd -> prepare("SELECT NUM_TICKET, NUM_CONTENEUR, DATE_PESEE, NUM_PLOMB, ID_TICKET, TARE_CONT, POIDS_NET, CONTROLLED FROM ticket WHERE ID_CERTIF=:certif");
			$query10 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
			$query10 -> execute();

			while($data10 = $query10 -> fetch()){

				$tab[$i] = $data10['NUM_TICKET'];
				$i++;
				$tab[$i] = $data10['NUM_CONTENEUR'];
				$i++;
				$date = new DateTime($data10['DATE_PESEE']);
				$tab[$i] = $date->format('d/m/Y');
				$i++;
				$tab[$i] = $data10['NUM_PLOMB'];
				$i++;
				$tab[$i] = $data10['POIDS_NET'];
				$i++;
				$tab[$i] = $data10['CONTROLLED'];
				$i++;
				$tab[$i] = $data10['ID_TICKET'];
				$i++;
				
				if($data10['TARE_CONT']<3000){
					$ta20++;
				}

				if($data10['TARE_CONT']>=3000){
					$ta40++;
				}				
				$weight += $data10['POIDS_NET'];
			}
			$query10 -> closeCursor();

			$tab[$i] = $ta20;
			$i++;
			$tab[$i] = $ta40;
			$i++;
			$tab[$i] = $data['STADE'];
			$i++;
			$tab[$i] = $_SESSION['ID_UTIL'];
			$i++;
			
			$query11 = $bdd -> query("SELECT VALEUR FROM configuration WHERE ID_CONF = 5");
			$data11 = $query11 -> fetch();
			
			$gap = $data['STADE'] - $data11['VALEUR'] ;
			
			if($gap > 0){				
				$tab[$i] = 1;
			}
			else{				
				$tab[$i] = 0;
			}
			$i++;
			
			$tab[$i] = $weight;
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