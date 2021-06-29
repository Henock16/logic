<?php
	
	include_once('inc/config_client.php');
	include_once('inc/get_put_file.php');
	include_once('inc/logger_client.php');
	
	function Post($url,array $token,$pass){
		
		$content = array('table' => $token, 'pass' => $pass);
        $requete = array(  'http' =>   array( 'method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded',  'content' => http_build_query($content) ) );
        $context = stream_context_create($requete);
        $content = @file_get_contents($url, false, $context);

        return $content;
    }

	if(!file_exists($cntrl_certif_auth) || !GetFile($cntrl_certif_auth)|| GetFile($cntrl_certif_auth) >=3 ){
		
		PutFile($cntrl_certif_auth,1);
		sleep($delay_send_certif_auth);

		$query = "SELECT ID_CERTIF, ID_EXP, ID_CAMP, ID_REC, NUM_PCKLIST, NUM_CERTIF, ID_USER_PREC,CLIENT,ID_DEST FROM certificat WHERE AUTH_CERTIF = 0 ORDER BY ID_CERTIF LIMIT 1";
		$result = $bdd -> query($query);
		$rows = $result -> rowCount();
		
		if($rows > 0){
			
			while($data = $result -> fetch()){
				
				$idcertif = $data['ID_CERTIF'];
				$pcklist = $data['NUM_PCKLIST'];
				$certif = $data['NUM_CERTIF'];
				
				$query0 = "SELECT LIBELLE FROM exportateur WHERE ID_EXP = ".$data['ID_EXP'];
				$result0 = $bdd -> query($query0);
				$data0 = $result0 -> fetch();
				
				$export = $data0['LIBELLE'];
				$result0 -> closeCursor();
				
				$query1 = "SELECT LIBELLE FROM campagne WHERE ID_CAMP = ".$data['ID_CAMP'];
				$result1 = $bdd -> query($query1);
				$data1 = $result1 -> fetch();
				
				$camp = $data1['LIBELLE'];
				$result1 -> closeCursor();
				
				$query2 = "SELECT LIBELLE FROM recolte WHERE ID_REC = ".$data['ID_REC'];
				$result2 = $bdd -> query($query2);
				$data2 = $result2 -> fetch();
				
				$rec = $data2['LIBELLE'];
				$result2 -> closeCursor();
				
				$query3 = "SELECT COUNT(ID_TICKET) AS NB FROM ticket WHERE ID_CERTIF = ".$data['ID_CERTIF'];
				$result3 = $bdd -> query($query3);
				$data3 = $result3 -> fetch();
				
				$nbrecont = $data3['NB'];
				$result3 -> closeCursor();
				
				$query4 = "SELECT ACTEUR, DATE_CREATION FROM journal WHERE ACTION = 3 AND CIBLE = ".$data['ID_CERTIF'];
				$result4 = $bdd -> query($query4);
				$data4 = $result4 -> fetch();
				$row4 = $result4 -> rowCount();
				
				if($row4 > 0){
					
					$dateedit = date("Y-m-d", strtotime($data4['DATE_CREATION']));
				
					$query5 = "SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL = ".$data4['ACTEUR'];
					$result5 = $bdd -> query($query5);
					$data5 = $result5 -> fetch();
					
					$agentedit = $data5['NOM']." ".$data5['PRENOM'];
					$result5 -> closeCursor();					
				}
				else{
					$dateedit = date("Y-m-d");
					$agentedit = 'ADMIN';
				}
				$result4 -> closeCursor();
				
				
				$query6 = "SELECT MIN(DATE_PESEE) AS DD, MAX(DATE_PESEE) AS DF FROM ticket WHERE ID_CERTIF = ".$data['ID_CERTIF'];
				$result6 = $bdd -> query($query6);
				$data6 = $result6 -> fetch();
				
				$datedeb = $data6['DD'];
				$datefin = $data6['DF'];
				$result6 -> closeCursor();
				
				$query7 = "SELECT SUM(`POIDS_PRE_PESEE`) AS P1, SUM(`POIDS_DEU_PESEE`) AS P2, SUM(`TARE_CONT`) AS TC, SUM(`NB_EMB`) AS NB, SUM(`TARE_EMB`) AS TE, SUM(`TARE_HAB`) AS TH FROM `ticket` WHERE `ID_CERTIF` = ".$data['ID_CERTIF'];
				$result7 = $bdd -> query($query7);
				$data7 = $result7 -> fetch();
				
				$p1 = $data7['P1'];
				$p2 = $data7['P2'];
				$tarecont = $data7['TC'];
				$nbemb = $data7['NB'];
				$taremb = $data7['TE'];
				$tarehab = $data7['TH'];
				$poidsnet = abs(intval($data7['P2']) - intval($data7['P1'])) - (intval($data7['TC']) + intval($data7['TE']) + intval($data7['TH'])) ;
				$result7 -> closeCursor();
				
				$query8 = "SELECT DISTINCT(INSPECTEUR) AS INSP FROM ticket WHERE ID_CERTIF = ".$data['ID_CERTIF'];
				$result8 = $bdd -> query($query8);
				
				$inspecteur = "";
				while($data8 = $result8 -> fetch()){
					
					$query9 = "SELECT NOM, PRENOM FROM inspecteur WHERE ID_INSP = ".$data8['INSP'];
					$result9 = $bdd -> query($query9);
					$data9 = $result9 -> fetch();
					
					$inspecteur .= $data9['NOM']." ".$data9['PRENOM']." ; ";
					$result9 -> closeCursor();
				}
				$result8 -> closeCursor();	
				
				$client= $data['CLIENT'];
				 
				$query10 = $bdd -> prepare("SELECT PORT,PAYS FROM destination WHERE ID_DEST=:dest");
				$query10 -> bindParam(':dest', $data['ID_DEST'], PDO::PARAM_INT);
				$query10 -> execute();
				$data10 = $query10 -> fetch();
				$dest = $data10['PORT']." ".$data10['PAYS'];
				$query10 -> closeCursor();
			}

			$token = array($idcertif,$pcklist,$certif,$export,$camp,$rec,$nbrecont,$dateedit,$agentedit,$datedeb,$datefin,$p1,$p2,$tarecont,$nbemb,$taremb,$tarehab,$poidsnet,$inspecteur,$client,$dest);

			//Récupération du contenu renvoyé par le webservice
			$output = Post($url_send_certif_auth,$token,$pass);

			if(!$output){				
				Loger("send_certif_auth : "."Unable to reach webservice!");
			}
			else{
				
				$resultat = json_decode($output);
				
				if($resultat[0] == 0){
					
					$query10 = $bdd -> prepare("UPDATE certificat SET AUTH_CERTIF = 2 WHERE ID_CERTIF =:idcertif");
					$query10 -> bindParam(':idcertif', $resultat[2], PDO::PARAM_INT);	
					$query10 -> execute();
					$query10 -> closeCursor();
				}
				Loger("send_certif_auth : ".$resultat[0]."==>".$resultat[1]);
				Loger("send_certif_auth : ".$resultat[0]."==>".$resultat[2]);
			}
			$result -> closeCursor();
		}
		else{			
			Loger("send_certif_auth : "."Aucun certificat à authentifier !");
		}
		PutFile($cntrl_certif_auth,0);
	}
	else{		
		PutFile($cntrl_certif_auth,GetFile($cntrl_certif_auth)+1);
	}
?>