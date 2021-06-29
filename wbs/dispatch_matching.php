<?php
/*-----------------------------------------------------------------------------------------------*/
/*  Fonction de dispatching au niveau du matching : 					  */
/*  	- Dispatching des certificats expirés à l'administration vers le matching  */
/*  	- Dispatching des bordereaux dont un certificat a expiré au matching	  */
/*  	  vers l''administration										  */
/*  	- Dispatching des bordereaux expirés à l'administration vers le controle */
/*  	- Dispatching des bordereaux dont un certificat a expiré au controle	n*/
/*  	  vers le controle n+1										  */
/*-----------------------------------------------------------------------------------------------*/


include_once('inc/config_client.php');

include_once('inc/get_put_file.php');

include_once('inc/select_matcher.php');

include_once('inc/isdayofrest.php');

//include_once('/var/www/html/certificat/logicsite/functions/Dispatching_function.php');
include_once('C:/wamp/www/logic/functions/Dispatching_function.php');

if((!isdayofrest($bdd,date('Y-m-d')) && date('w')!=6 && date('w')!=0  && date("H:i:s") >="08:30:00" && date("H:i:s") <="16:00:00"))
	{

	if(!file_exists($cntrl_dispatch_matching) || !GetFile($cntrl_dispatch_matching)|| GetFile($cntrl_dispatch_matching)>=3)
		{

		PutFile($cntrl_dispatch_matching,1);

		sleep($delay_dispatch_matching);

		/*  	- Dispatching des certificats expirés à l'administration pour le matching  */

		select_matcher($bdd,0,0);


		/*  	- Dispatching des bordereaux dont un certificat a expiré au matching	  */
		/*  	  vers l''administration										  */
		/*  	- Dispatching des bordereaux expirés à l'administration vers le controle */
		/*  	- Dispatching des bordereaux dont un certificat a expiré au controle n    */
		/*  	  vers le controle n+1										  */



		//Pour chaque bordereaux créé et pas encore transmis OU à l'administration pour le controle
		$query="SELECT STADE, STATUT, ID_BORD, ID_USER FROM bordereau WHERE STATUT=0 OR (STATUT=1 AND STADE=1)  ORDER BY STADE";
		$result=$bdd->query($query);
		while ($lign = $result->fetch()) //pour tous les bordereaux aux certificats pas encore transferés
			{
			$nb=0;
			$ville=0;
			// 7=delai certificats matché au matching
			// 8=delai bordereaux a l'administration
			// 9=delai certificats controlé au controle
			$delai=val_config($bdd,(($lign['STADE']==1)?(($lign['STATUT']==0)?7:8):9));

//			Loger("dispatch_matching: "."BORDEREAU [ID=".$lign['ID_BORD']." STADE=".$lign['STADE']." STATUT=".$lign['STATUT']."]");

			 //pour chaque certificats du bordereaux 
			$query="SELECT ID_CERTIF, ID_BORD  FROM certif_bord WHERE ID_BORD=".$lign['ID_BORD'];
			$res=$bdd->query($query);
			while ($data = $res->fetch())
				{
				if($lign['STADE']==1)  //si bordereaux au matching ou à l'administration pour le controle
					{
					if($lign['STATUT']==0) //pour chaque certificat matché dont la durée  a depassé le delai, Delai depuis l'envoi du certificat au matching jusqua maintenant dépassé
						$query="SELECT * FROM journal WHERE CIBLE=".$data['ID_CERTIF']." AND ACTION=1 AND TIMESTAMPDIFF(SECOND,CAST(DATE_CREATION AS DATETIME), CAST('".date("Y-m-d H:i:s")."' AS DATETIME))>".$delai."";
					else //Delai depuis l'envoi du borderau à l'administration jusqua maintenant dépassé
						$query="SELECT * FROM journal WHERE CIBLE=".$data['ID_BORD']." AND ACTION=6 AND TIMESTAMPDIFF(SECOND,CAST(DATE_CREATION AS DATETIME), CAST('".date("Y-m-d H:i:s")."' AS DATETIME))>".$delai."";
					}
				else //si bordereaux au controle, Pour chaque borderau précedant de chaque certificat dont la date et l'heure d'affectation a depassé le delai		
					$query="SELECT * FROM bordereau B ,certif_bord CB ,journal J WHERE CB.ID_CERTIF=".$data['ID_CERTIF']." AND CB.ID_BORD=B.ID_BORD AND B.STADE=".($lign['STADE']-1)." AND CB.ID_BORD=J.CIBLE AND J.ACTION=2 AND TIMESTAMPDIFF(SECOND,CAST(J.DATE_CREATION AS DATETIME), CAST('".date("Y-m-d H:i:s")."' AS DATETIME))>".$delai."";

				$rslt=$bdd->query($query);
				while ($donnees = $rslt->fetch())
					$nb++;
				$rslt->closeCursor();

				if($nb==1)
					{
					//Retrouver la ville d'un des certificats du bordereau pour l'attribuer à un controleur de la ville
					$query="SELECT ID_VILLE FROM certificat WHERE ID_CERTIF=".$data['ID_CERTIF'];
					$rslt=$bdd->query($query);
					while ($donnees = $rslt->fetch())
						$ville=$donnees['ID_VILLE'];
					$rslt->closeCursor();
					}
				}
			$res->closeCursor();	

			if($nb)
				Loger("dispatch_matching: "."	TRANSMISSION DU BORDEREAU [ID=".$lign['ID_BORD']." STADE=".$lign['STADE']." STATUT=".$lign['STATUT']." UTILISATEUR=".$lign['ID_USER']."]  à un ".(($lign['STADE']==1)?(($lign['STATUT']==0)?"CONTROLEUR 1 ou à ADMINISTRATEUR 2":"CONTROLEUR 1"):"CONTROLEUR ".$lign['STADE']));

			if($nb)
				Dispatching($lign['ID_BORD'] ,$lign['STADE']+(($lign['STADE']==1)?(($lign['STATUT']==0)?1:0):1),$lign['ID_USER'],redirect_ville($ville),$bdd);
			}
		$result->closeCursor();	
		//FIN Pour chaque bordereaux aux certificats pas encore transferés

		PutFile($cntrl_dispatch_matching,0);
		}
	else	
		PutFile($cntrl_dispatch_matching,GetFile($cntrl_dispatch_matching)+1);

	}

?>
