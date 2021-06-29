<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

	$update = $_POST['updatetckt'];
	$error = $_POST['error'];
	$idtckt = $_POST['idticket'];
	$tab[0] = 0;
	$tab[1] = 0;
	$tab[2] = 0;
	$tab[3] = 0;
	
	$query10 = $bdd -> prepare("UPDATE ticket SET CONTROLLED = 1 WHERE ID_TICKET =:idtckt");
	$query10 -> bindParam(':idtckt', $idtckt, PDO::PARAM_INT);
	$query10 -> execute();
	$query10 -> closeCursor();
	
	if($update == '1'){
		
		$prov = $_POST['prov'];
		$nb_emb = $_POST['nbemb'];
		$temb = $_POST['temb'];
		$tcont = $_POST['tcont'];
		$pnet = $_POST['pnet'];		
		$insp = $_POST['insp'];
		$prod = $_POST['prod'];
		$cam = $_POST['cam'];
		$typetare = $_POST['typtare'];
		$thab = 0;
		$marq = 0;
		$weight = 0;
		
		if($prod == '2'){
			$marq = $_POST['marq'];
		}
		else{			
			$thab = $_POST['thab'];
		}
		
		$query = $bdd -> prepare("SELECT ID_CERTIF, ID_CORI, ID_CORM, ID_CORP FROM ticket WHERE ID_TICKET =:tk");
		$query -> bindParam(':tk', $idtckt, PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();

		if($data['ID_CORI'] != 0){

			$query1 = $bdd -> prepare("UPDATE corr_inspecteur SET ORIGINAL =:insp WHERE ID_CORI =:cori");
			$query1 -> bindParam(':insp', $insp, PDO::PARAM_INT);
			$query1 -> bindParam(':cori', $data['ID_CORI'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();
		}
		if($data['ID_CORM'] != 0){

			$query2 = $bdd -> prepare("UPDATE corr_marque SET ORIGINAL =:marq WHERE ID_CORM =:corm");
			$query2 -> bindParam(':marq', $marq, PDO::PARAM_INT);
			$query2 -> bindParam(':corm', $data['ID_CORM'], PDO::PARAM_INT);
			$query2 -> execute();
			$query2 -> closeCursor();
		}
		if($data['ID_CORP'] !=0 ){

			$query3 = $bdd -> prepare("UPDATE corr_site_provenance SET ORIGINAL =:prov WHERE ID_CORP =:corp");
			$query3 -> bindParam(':prov', $prov, PDO::PARAM_INT);
			$query3 -> bindParam(':corp', $data['ID_CORP'], PDO::PARAM_INT);
			$query3 -> execute();
			$query3 -> closeCursor();
		}
		
		$query4 = $bdd -> prepare("UPDATE ticket SET PROVENANCE=:prov, MARQUE=:marq, NB_EMB=:emb, TARE_HAB=:thab, TARE_CONT=:tcont, TARE_EMB=:temb, POIDS_NET=:pnet, INSPECTEUR=:insp, NUM_CAMION=:cam,TYPE_EMB=:typetare WHERE ID_TICKET=:tk");
		$query4 -> bindParam(':prov', $prov, PDO::PARAM_INT);
		$query4 -> bindParam(':marq', $marq, PDO::PARAM_INT);
		$query4 -> bindParam(':emb', $nb_emb, PDO::PARAM_INT);
		$query4 -> bindParam(':thab', $thab, PDO::PARAM_INT);
		$query4 -> bindParam(':tcont', $tcont, PDO::PARAM_INT);
		$query4 -> bindParam(':temb', $temb, PDO::PARAM_INT);
		$query4 -> bindParam(':pnet', $pnet, PDO::PARAM_INT);
		$query4 -> bindParam(':insp', $insp, PDO::PARAM_INT);
		$query4 -> bindParam(':tk', $idtckt, PDO::PARAM_INT);
		$query4 -> bindParam(':cam', $cam, PDO::PARAM_STR);
		$query4 -> bindParam(':typetare', $typetare, PDO::PARAM_INT);
		$query4 -> execute();
		$query4 -> closeCursor();
		
		$query5 = $bdd -> prepare("SELECT TARE_CONT FROM ticket WHERE ID_CERTIF =:certif");
		$query5 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
		$query5 -> execute();
		
		while($data5 = $query5 -> fetch()){
			
			if($data5['TARE_CONT'] < 3000){				
				$tab[0] += 1;
			}
			else{				
				$tab[1] += 1;
			}
		}		
		$query5 -> closeCursor();
		
		$query6 = $bdd -> prepare("UPDATE certificat SET ID_MODIFICATEUR=:util, DATE_MODIFICATION = now() WHERE ID_CERTIF =:certif");
		$query6 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
		$query6 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
		$query6 -> execute();
		$query6 -> closeCursor();
		
		$query7 = $bdd -> prepare("SELECT POIDS_NET FROM ticket WHERE ID_CERTIF =:certif");
		$query7 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
		$query7 -> execute();
		
		while($data7 = $query7 -> fetch()){			
			$weight += $data7['POIDS_NET'];
		}		
		$query7 -> closeCursor();
		
		$tab[2] = $weight;
		
		$query->closeCursor();
	}

	if($error == '1'){
		
		$tab[3] = 1;
		
		$text = $_POST['text'];

		$query8 = $bdd -> prepare("SELECT ID_CERTIF FROM ticket WHERE ID_TICKET =:tk");
		$query8 -> bindParam(':tk', $idtckt, PDO::PARAM_INT);
		$query8 -> execute();
		$data8 = $query8->fetch();
		
		$query9 = $bdd -> prepare("INSERT INTO erreur(ID_TICKET,LIBELLE,ID_TYP_ERR,ID_CERTIF)VALUES(:num,:text,0,:certif)");
		$query9 -> bindParam(':num', $idtckt, PDO::PARAM_INT);
		$query9 -> bindParam(':text', $text, PDO::PARAM_INT);
		$query9 -> bindParam(':certif', $data8['ID_CERTIF'], PDO::PARAM_INT);
		$query9 -> execute();
		$query9 -> closeCursor();
		
		$query11 = $bdd -> prepare("UPDATE ticket SET CONTROLLED = 0 WHERE ID_TICKET =:idtckt");
		$query11 -> bindParam(':idtckt', $idtckt, PDO::PARAM_INT);
		$query11 -> execute();
		$query11 -> closeCursor();
		
		$query12 = $bdd->prepare("UPDATE certificat SET ERREUR = 1 WHERE ID_CERTIF=:ct");
		$query12 -> bindParam(':ct', $data8['ID_CERTIF'], PDO::PARAM_INT);
		$query12 -> execute();
		$query12 -> closeCursor();
		
		$query8 -> closeCursor();
	}	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>