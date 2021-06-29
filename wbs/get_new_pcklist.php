<?php

include_once('inc/config_client.php');

include_once('inc/get_post_url.php');

include_once('inc/get_put_file.php');

include_once('inc/insert_str_int.php');

include_once('inc/select_matcher.php');

include_once('inc/isdayofrest.php');

//RECHErche de l'existance de la provenance dans ex2c( site_provenance puis corr_site_provenance)
//si pas dans les deux, insertion dans corr_site_provenance sinon recuperer id du site_provenance
function get_id($bdd,$chp_idtcorresp,$id_ticket,$val,$chpid,$chpval,$tparam,$tcorresp)
	{
	$idtparam=0;
	$idtcorresp=0;

	if(trim($val)!='')
		{
		$query="SELECT * FROM ".$tparam." WHERE ".(($chpval=='NOM')?"CONCAT(NOM,' ',PRENOM)":$chpval)."='".$val."'";
		$res=$bdd->query($query);
		while ($data = $res->fetch()) 
			$idtparam=$data[$chpid];
		$res->closeCursor();	

		if(!$idtparam)  //si le site_provenance n'existe pas on check ausssi dans corr_site_provenance
			{
			$query="SELECT * FROM ".$tcorresp." WHERE DERIVE='".$val."'";
			$res=$bdd->query($query);
			while ($data = $res->fetch())
				{
				$idtparam=$data['ORIGINAL'];
				$idtcorresp=$data[$chp_idtcorresp];
				}
			$res->closeCursor();	

			if(!$idtcorresp)
				{
				$bdd->exec("INSERT INTO ".$tcorresp."(DERIVE,ORIGINAL,ID_TICKET,DATE_CREATION) VALUES('".insert_str($val)."',0,".$id_ticket.",'".date("Y-m-d H:i:s")."')");
				$idtcorresp=$bdd->lastInsertId();
				}
			}
		}

	return array($idtparam,$idtcorresp);
	}


if((!isdayofrest($bdd,date('Y-m-d')) && date('w')!=6 && date('w')!=0  && date("H:i:s") >="08:30:00" && date("H:i:s") <="16:00:00"))
	{

	if(!file_exists($cntrl_get_new_pcklist) || !GetFile($cntrl_get_new_pcklist)|| GetFile($cntrl_get_new_pcklist)>=3)
		{

		PutFile($cntrl_get_new_pcklist,1);

		sleep($delay_get_new_pcklist);

		//Chargement du dernier identifiant téléchargé
		$token=GetFile($last_token_get_new_pcklist);			     

		$again=val_config($bdd,15);

		//Récupération du contenu renvoyé par le webservice
		$output=Get($url_get_new_pcklist,$again.":".$token,$pass);

		if(!$output)
			{
			Loger("get_new_pcklist:"."Unable to reach webservice!");
			}
		else
			{
				if($again)
					put_config($bdd,15,0);

				$resultat = json_decode($output);

				//var_dump($resultat);

				$statut= $resultat->{'status'};
				$message= $resultat->{'msg'};

				Loger("get_new_pcklist:".$statut."==>".$message);

				$token=explode(":",$token);
				
				$lastid=$token[0];
				$badids=(isset($token[1])?$token[1]:"");

				//S'il ya de nouvelles packing_list
				if(!$statut)
					{
						//Connexion à la BD SOLAS
						$dblink= new PDO('mysql:host=localhost;dbname=solas;charset=utf8', "root", $pswd,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

						$pcklsts= $resultat->{'pcklsts'};
				
						$badids="";

						//Pour chaque packing_list
						for($i=0;$i<count($pcklsts);$i++)
							{
								$packing_list= $pcklsts[$i]->{'packing_list'};

								$lastid=$packing_list[0];

								//Remplir et loguer (afficher) les champs de la packing_list
								$nb_pckl=count($packing_list);
								$pl="PACKINGLIST[".$i."]=";
								for($j=0;$j<$nb_pckl;$j++)
									$pl.=($j?";":"[").$packing_list[$j].(($j==$nb_pckl-1)?"]":"");
								Loger("get_new_pcklist:".$pl);

		//  ID_EXP /  ID_EGRE / ID_TYPPROD / ID_CAMP / ID_REC / ID_PROD  / ID_DEST /  ID DEMANDEUR /ID_TRANSIT
		
								$id_certif=0;
								$certif=0;
								//On verifie l'existence du ticket avant insertion
								$res = $bdd -> query("SELECT ID_CERTIF FROM certificat WHERE ID_PCKLIST='".$packing_list[0]."' AND DISABLED =0 AND A_R =0");
								while ($rows = $res->fetch()) 
									{
									$id_certif=$rows['ID_CERTIF'];
									$certif=$id_certif;
									Loger("get_new_pcklist:"." Le packing List ".$packing_list[0]." a dejà été inséré");
									}
								$res -> closeCursor();
								
								if($id_certif == 0)
									{
									//Insertion de la packing_list
									$insert="INSERT INTO certificat(`ID_PCKLIST`, `NUM_PCKLIST`, `ID_EXP`, `ID_EGRE`, `ID_TYPPROD`, `ID_CAMP`, `ID_REC`, `ID_PROD`, `ID_VILLE`, `ID_TRANSIT`, `NUM_OT`, `NUM_DOSS`, `NUM_INST_CLI`, `NUM_INST_FOUR`, `CLIENT`, `ID_DEST`, `ID_DEMANDEUR`, `NAVIRE`, `STATUT`,  `NUM_CERTIF`, `A_R`, `ID_A_R`, `DISABLED`, `ID_USER_PREC`, `ID_USER_COUR`, `STADE`, `NB_EDIT`, `BLOCKED`, `ERREUR`, `CHANG_STAT`, `DATE_CREATION`,`DATE_PACKLIST`,DEB_EMP,FIN_EMP,NOM_SOUM,PREN_SOUM,FONCT_SOUM,TEL_SOUM)";

									$insert.=" VALUES(".$packing_list[0].",'".insert_str($packing_list[1])."',".$packing_list[2].",".insert_int($packing_list[3]).",".insert_int($packing_list[4]).",".insert_int($packing_list[5]).",".insert_int($packing_list[6]).",".$packing_list[7].",".$packing_list[8].",".insert_int($packing_list[9]).",'".insert_str($packing_list[10])."','".insert_str($packing_list[11])."','".insert_str($packing_list[12])."','".insert_str($packing_list[13])."','".insert_str($packing_list[14])."',".$packing_list[15].",".$packing_list[16].",'".insert_str($packing_list[17])."',0,'',".$packing_list[18].",".insert_int($packing_list[19]).",0,0,0,0,0,0,0,1,'".date("Y-m-d H:i:s")."','".$packing_list[20]."','".insert_str($packing_list[21])."','".insert_str($packing_list[22])."','".insert_str($packing_list[23])."','".insert_str($packing_list[24])."','".insert_str($packing_list[25])."','".insert_str($packing_list[26])."')";

									$bdd->exec($insert);

									//Récuperation de ID_CERTIF pour la MAJ dans les tickets
									$id_certif=$bdd->lastInsertId();
									}
																										
									$conteneurs=$pcklsts[$i]->{'conteneurs'};
									$nb_tcs=count($conteneurs);
									$nb_tck=0;

									//Pour chaque conteneur de la packing_list en cours
									for($j=0;$j<$nb_tcs;$j++)
										{
										$tcs="CONTENEUR[".$j."]=";

										//Remplir et loguer (afficher) les champs du conteneur
										for($k=0;$k<count($conteneurs[$j]);$k++)
											$tcs.=($k?";":"[").$conteneurs[$j][$k].(($k==count($conteneurs[$j])-1)?"]":"");
										Loger("get_new_pcklist:".$tcs);

										//Si l'identifiant du ticket existe
										if($conteneurs[$j][0])
											{
											$query="SELECT * FROM TICKET WHERE IDENTIFIANT='".$conteneurs[$j][0]."'";
											$result=$dblink->query($query);
											while ($donnees = $result->fetch()) //insertion du ticket et eventuellement du SITe / PROvenance /  Marque  / Inspecteur /
											//if($donnees['TYP_RECEPT']==1) //si le ticket est venu par web 
												{	
												
											$id_ticket=0;
											if($certif>0)
												{
												//On verifie l'existence du ticket avant insertion
												$res = $bdd -> query("SELECT ID_TICKET FROM ticket WHERE NUM_TICKET='".insert_str((str_replace(" ","",$donnees['CODE_PESEE_N_2'])?$donnees['CODE_PESEE_N_2']:$donnees['CODE_PESEE_N_1']))."' AND ID_CERTIF=".$id_certif." ");
												while ($rows = $res->fetch()) 
													{
													$id_ticket=$rows['ID_TICKET'];
													Loger("get_new_pcklist:"." Le icket ".$id_ticket." a dejà été inséré");
													}
												$res -> closeCursor();
												}

											if($id_ticket==0)
												{	
												//insertion proprement dite du ticket
												$insert="INSERT INTO ticket(`NUM_TICKET`,`EXPORTATEUR`, `NUM_CAMION`, `DATE_EDITION`, `SITE`, `PROVENANCE`, `NUM_CONTENEUR`, `NUM_PLOMB`, `MARQUE`, `NB_EMB`,`TYPE_EMB`, `POIDS_PRE_PESEE`, `POIDS_DEU_PESEE`, `TARE_HAB`, `TARE_CONT`, `TARE_EMB`, `POIDS_NET`, `INSPECTEUR`, `ID_CERTIF`, `MATCHED`,CONTROLLED, `DATE_CREATION`,DATE_PESEE)";
												$insert.=" VALUES('".insert_str((str_replace(" ","",$donnees['CODE_PESEE_N_2'])?$donnees['CODE_PESEE_N_2']:$donnees['CODE_PESEE_N_1']))."','".insert_str($donnees['CHARGEUR'])."','".str_replace(" ","",insert_str($donnees['N_VEHICULE_TRACTEUR']))."','".$donnees['DATE_HEURE_EDITION']."',".$donnees['PONT'].",'0','".insert_str($donnees['N_CONTENEUR_1'])."','".insert_str($donnees['N_PLOMB_1'])."','0',".insert_int($conteneurs[$j][5]).",".insert_int($conteneurs[$j][7]).",".insert_int($donnees['POIDS_1ERE_PESEE']).",".insert_int($donnees['POIDS_2EME_PESEE']).",".insert_int($conteneurs[$j][3]).",".insert_int($conteneurs[$j][2]).",".insert_int($conteneurs[$j][4]).",".insert_int($conteneurs[$j][1]).",'0',".$id_certif.",0,0,'".date("Y-m-d H:i:s")."','".insert_str($conteneurs[$j][6])."')";
												$bdd->exec($insert);

												//Récuperation de ID_TICKET pour la MAJ de PROvenance /  Marque  / Inspecteur
												$id_ticket=$bdd->lastInsertId();
												}
				
												//RECHErche de l'existance de la provenance dans ex2c( site_provenance puis corr_site_provenance)
												//si pas dans les deux, insertion dans corr_site_provenance sinon recuperer id du site_provenance

												list ($provenance,$corresp_prov)=get_id($bdd,'ID_CORP',$id_ticket,$donnees['PROVENANCE'],'ID_PROV','LIBELLE','site_provenance','corr_site_provenance');
		
												list ($marque,$corresp_marq)=get_id($bdd,'ID_CORM',$id_ticket,$donnees['MARQUE'],'ID_MARQ','LIBELLE','marque','corr_marque');
		
												list ($inspecteur,$corresp_insp)=get_id($bdd,'ID_CORI',$id_ticket,$donnees['AGENT_CCI'],'ID_INSP','NOM','inspecteur','corr_inspecteur');

												//MAJ de PROvenance /  Marque  / Inspecteur  dans le ticket
												if($provenance || $marque || $inspecteur || $corresp_prov || $corresp_marq || $corresp_insp)
													$bdd->exec("UPDATE ticket SET PROVENANCE='".$provenance."',MARQUE='".$marque."',INSPECTEUR='".$inspecteur."',ID_CORP='".$corresp_prov."',ID_CORM='".$corresp_marq."',ID_CORI='".$corresp_insp."' WHERE ID_TICKET=".$id_ticket."");
										

												//RECHErche de l'existance du pont dans ex2c.site sinon insertion 
												$query="SELECT * FROM site WHERE ID_SITE='".$donnees['PONT']."'";
												$res=$bdd->query($query);
												$exist=0;
												while ($data = $res->fetch()) 
													$exist++;
												$res->closeCursor();	

												$query="SELECT * FROM PONT WHERE ID_PONT='".$donnees['PONT']."'";
												$res=$dblink->query($query);
												while ($data = $res->fetch())
													if($exist) //si le ex2c.site existe on le modifie Ã  partir de solas.pont
														$bdd->exec("UPDATE  site SET CODE='".insert_str($data['CODE'])."',LIBELLE='".insert_str($data['NOM'])."',STRUCTURE='".insert_str($data['STRUCTURE'])."',TYPE=".$data['TYPE']." WHERE ID_SITE=".$data['ID_PONT']);
													else //si le ex2c.site n'existe pas on l'insere Ã  partir de solas.pont
														$bdd->exec("INSERT INTO site (ID_SITE,CODE,LIBELLE,STRUCTURE,TYPE,DATE_CREATION) VALUES(".$data['ID_PONT'].",'".insert_str($data['CODE'])."','".insert_str($data['NOM'])."','".insert_str($data['STRUCTURE'])."',".$data['TYPE'].",'".date("Y-m-d H:i:s")."')");
												$res->closeCursor();		
												
												//compteur des tickets effectivement insérés
												$nb_tck++;

												}
											$result->closeCursor();	
											//FIN insertion du ticket
											}
										//S'il n'y a pas d'identifiant ticket 
										else
											{												
											$insert="INSERT INTO ticket(`NUM_TICKET`,`EXPORTATEUR`, `NUM_CAMION`, `DATE_EDITION`, `SITE`, `PROVENANCE`, `NUM_CONTENEUR`, `NUM_PLOMB`, `MARQUE`, `NB_EMB`,`TYPE_EMB`, `POIDS_PRE_PESEE`, `POIDS_DEU_PESEE`, `TARE_HAB`, `TARE_CONT`, `TARE_EMB`, `POIDS_NET`, `INSPECTEUR`, `ID_CERTIF`, `MATCHED`,CONTROLLED, `DATE_CREATION`,DATE_PESEE)";
											$insert.=" VALUES('','','','0000-00-00 00-00-00',0,0,'','','0',0,0,0,0,0,0,0,0,0,".$id_certif.",0,0,'".date("Y-m-d H:i:s")."','0000-00-00')";
											$bdd->exec($insert);
											$nb_tck++;
											}
										}
									//FIN Pour chaque conteneur de la packing_list en cours

									//Si le nombre de tickets inséré est différent du nombre de tickets venu de ipage on supprime les tickets et la packing_list
									if($nb_tck==$nb_tcs)
										select_matcher($bdd,$id_certif,$packing_list[8]);	
									else			
										{
										//Concatener les id des packing_list
										$badids.=($badids?",":"").$packing_list[0];

										$delete="DELETE FROM ticket WHERE ID_CERTIF='".$id_certif."'";
										$bdd->exec($delete);

										$delete="DELETE FROM certificat WHERE ID_CERTIF='".$id_certif."'";
										$bdd->exec($delete);

										Loger("get_new_pcklist:"."Impossible de retrouver tous les TCs de la packinglist N°".$packing_list[0]);
										}
									
							}
						//FIN Pour chaque packing_list

						$rcvdid= $resultat->{'token'};
						Loger("get_new_pcklist:".($rcvdid?"ID RECU=".$rcvdid:""));
						Loger("get_new_pcklist:".($lastid?"LAST ID=".$lastid:""));

						PutFile($last_token_get_new_pcklist,$lastid.($badids?":".$badids:""));
					}
				//FIN Si de nouvelles packing_list
				elseif($badids)
					PutFile($last_token_get_new_pcklist,$lastid);
			}
		//FIN Si webservice atteint 

		PutFile($cntrl_get_new_pcklist,0);
		}
	else	
		PutFile($cntrl_get_new_pcklist,GetFile($cntrl_get_new_pcklist)+1);
	}

?>
