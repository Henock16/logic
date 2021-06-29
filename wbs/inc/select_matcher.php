<?php
/*-----------------------------------------------------------------------------------------------*/
/*  Fonction de selection du matcheur ayant le mons de tickets de la journée: */
/*  	- Si auto est on, est effectué systématiquement pour tous les tickets 	  */
/*  	  ou uniquement celui dont l'identifiant est spécifié					  */
/*  	- Si auto est off, est effectué lorsque le delai configuré est dépassé 	  */
/*-----------------------------------------------------------------------------------------------*/

include_once('logger_client.php');

include_once('val_config.php');

include_once('affect_matcher.php');

include_once('redirect_ville.php');

// Selection automatique d'un matcheur et affectation 
function select_matcher($bdd,$id_certif,$ville)
	{
	$dispatch_matching_delay=val_config($bdd,6);

	//Pour chaque ville
	for($v=0;$v<=3;$v++)
		if(!$ville  || $ville==$v)		
			{
			Loger("VILLE=[".(($v==1)?"ABIDJAN":(($v==2)?"SAN PEDRO":(($v==3)?"BOUAKE":"TOUTES")))."]");

			//Type de dispatching en fonction de la ville
			$dispatch_matching_auto=val_config($bdd,(($v==1)?1:(($v==2)?10:1)));

			//Dispatching automatique ou Delai
			$delai=($v?($dispatch_matching_auto?0:$dispatch_matching_delay):$dispatch_matching_delay);

			Loger("DELAI=[".$delai."]");

			//Liste des nouveaux certificats
			$query="SELECT ID_CERTIF, NUM_PCKLIST, ID_VILLE  FROM certificat WHERE STADE=0 AND DISABLED=0 AND STATUT=0 ".($v?"AND ID_VILLE=".$v:"").(($id_certif)?" AND ID_CERTIF =".$id_certif:"")."  AND TIMESTAMPDIFF(SECOND,CAST(DATE_CREATION AS DATETIME), CAST('".date("Y-m-d H:i:s")."' AS DATETIME))>=".$delai." ORDER BY ID_CERTIF ";
			$result=$bdd->query($query);
			$n=0;
//Loger($query);
			while ($lign = $result->fetch()) //pour tous les certificats pas encore affectés
				{
				Loger("select_matcher: "."CERTIFICAT ".$lign['ID_CERTIF']."=[".$lign['NUM_PCKLIST']."]");

				//Pour chaque utilisateur , trouver celui ayant recu le moins de ticket et de certificat pour la journée actuelle
				$iduser=0;
				$nbticket=0;

				$tour=1; //0=Matcheurs déja connectés aujourd'hui   / 1=Matcheurs pas encoreconnectés aujourd'hui
				while ($tour<2 && $iduser==0)  //Pour chaque tour et si le certificat n'a pas encore été affecté à un matcheur
					{
					Loger("select_matcher: "."	Les agents ".($tour?"actifs pas forcement encore connectés de la journée":"déja connectés de la journée")."  ");

					$query="SELECT ID_UTIL, PRENOM, NOM, COMPTE FROM utilisateur WHERE TYPE_COMPTE=1 AND STAT_COMPTE=0 AND DISABLED=0 AND PREM_CONNEXION=1 ".($tour?"":" AND JOUR='".date("Y-m-d")."'")." AND ID_VILLE=".redirect_ville($lign["ID_VILLE"])." ORDER BY ID_UTIL ASC";
					$res=$bdd->query($query);

					while ($donnees = $res->fetch())
						{
						$tickets=$donnees['COMPTE'];
						Loger("select_matcher: "."		AGENT ".$donnees['ID_UTIL']."=[".$donnees['NOM']." ".$donnees['PRENOM']."] NB TICKETS=".$tickets."  ");
					
						//si l'utilisateur à moins de tickets il devient celui à qui on fait l'affectation
						if(!$iduser || ($tickets<$nbticket) )
							{
							$iduser=$donnees['ID_UTIL'];
							$nbticket=$tickets;
							}
						}
					$res->closeCursor();	
					//FIN Pour chaque utilisateur , trouver celui ayant recu le moins de ticket et de certificat pour la journée actuelle
					$tour++;
					}

				//affectation
				if($iduser)
					{
					Loger("select_matcher: "."	AFFECTATION du CERTIFICAT ".$lign['ID_CERTIF']." à L'AGENT ".$iduser);

					affect_matcher($bdd,0,$lign['ID_CERTIF'],$iduser); 
					}
				else
					Loger("select_matcher: "."	PAS D'AFFECTATION du CERTIFICAT ".$lign['ID_CERTIF']." ");

				$n++;
				}
			$result->closeCursor();	
			//Fin pour chaque certificat certificats
			}
		//Fin pour chaque ville

	return 1;
	}

?>
