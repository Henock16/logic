<?php

include_once('inc/config_client.php');

include_once('inc/get_post_url.php');

include_once('inc/get_put_file.php');

include_once('inc/insert_str_int.php');

include_once('inc/logger_client.php');

if(!file_exists($cntrl_get_pcklist_update) || !GetFile($cntrl_get_pcklist_update)|| GetFile($cntrl_get_pcklist_update)>=3)
{
PutFile($cntrl_get_pcklist_update,1);

sleep($delay_get_pcklist_update);

//Chargement des derniers identifiants modifiés
$token=GetFile($last_token_get_pcklist_update);

//Récupération du contenu renvoyé par le webservice
$output=Get($url_get_pcklist_update,$token,$pass);

if(!$output)
	Loger("get_pcklist_update:"."Unable to reach webservice!");
else
	{
		$resultat = json_decode($output);

		$statut= $resultat->{'status'};
		$message= $resultat->{'msg'};

		Loger("get_pcklist_update:".$statut."==>".$message);

		$lastoken="";

		Loger("get_pcklist_update:".($token?"SENT TOKEN =".$token:""));

		//S'il ya de nouvelles modifications de packing_list
		if(!$statut)
			{
				$pcklsts= $resultat->{'pcklsts'};
				
				//Pour chaque packing_list
				for($i=0;$i<count($pcklsts);$i++)
					{
						$packing_list= $pcklsts[$i]->{'packing_list'};

						//Remplir et loguer (afficher) les champs de la packing_list
						$nb_pckl=count($packing_list);
						$pl="PACKINGLIST[".$i."]=";
						for($j=0;$j<$nb_pckl;$j++)
							$pl.=($j?";":"[").$packing_list[$j].(($j==$nb_pckl-1)?"]":"");
						Loger("get_pcklist_update:".$pl);

						//MAJ de la packing_list
						$update="UPDATE certificat SET A_R=".$packing_list[1].", ID_A_R='".insert_int($packing_list[2])."',DISABLED=".$packing_list[3]." WHERE ID_PCKLIST =".$packing_list[0]."";
						$bdd->exec($update);

						//Concatener les id des packing_list
						$lastoken.=($i?",":"").$packing_list[0];

						$demande= $pcklsts[$i]->{'demande'};

						//Remplir et loguer (afficher) les champs de la demande
						$nb_dmd=count($demande);

						if($nb_dmd)
							{
							$dmd="DEMANDE[".$i."]=";
							for($j=0;$j<$nb_dmd;$j++)
								$dmd.=($j?";":"[").$demande[$j].(($j==$nb_dmd-1)?"]":"");
							Loger("get_pcklist_update:".$dmd);

							$insert="INSERT INTO demande_intervention(`TYPE_DEMANDE`, `ID_PKLIST`,`MOTIF`)";
							$insert.=" VALUES('".insert_int($demande[0])."','".$packing_list[0]."','".insert_str($demande[1])."')";
							$bdd->exec($insert);
							}			
					}
				//FIN Pour chaque packing_list

				Loger("get_pcklist_update:".($lastoken?"GOT TOKEN=".$lastoken:""));
			}

		PutFile($last_token_get_pcklist_update,$lastoken);


	}
PutFile($cntrl_get_pcklist_update,0);
}
else	
PutFile($cntrl_get_pcklist_update,GetFile($cntrl_get_pcklist_update)+1);

?>
