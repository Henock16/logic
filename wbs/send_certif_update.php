<?php

include_once('inc/config_client.php');

include_once('inc/get_put_file.php');

include_once('inc/logger_client.php');

function Get($url,$token,$pass)
        {
	$link=$url."?nbr=".$token[0]."&idcertif=".$token[1]."&ar=".$token[2]."&disabled=".$token[3]."&statut=".$token[4]."&poids_net=".$token[5]."&nbre_sac_def=".$token[6]."&pass=".$pass;

        $content = @file_get_contents($link);

        return $content;
        }
		
if(!file_exists($cntrl_certif_update) || !GetFile($cntrl_certif_update)|| GetFile($cntrl_certif_update)>=3)
{
PutFile($cntrl_certif_update,1);

sleep($delay_send_certif_update);

$idcertif="";
$a_r="";
$disabled="";
$statut="";
$poids_net="";
$nbre_sac_def="";

$query="SELECT ID_PCKLIST, A_R, DISABLED, STATUT, ID_CERTIF  FROM certificat WHERE CHANG_STAT=0 ORDER BY ID_PCKLIST ";
$result=$bdd->query($query);
$i=0;
while ($lign = $result->fetch()) //pour tous les certificats modifiées
	if($i<$max_lign_send_certif_update)
	{
	$idcertif.=($i?";":"").$lign['ID_PCKLIST'];
	$a_r.=($i?";":"").$lign['A_R'];
	$disabled.=($i?";":"").$lign['DISABLED'];
	$statut.=($i?";":"").$lign['STATUT'];

	$poids="";
	$sacs="";
	if(($lign['STATUT']== 2) || ($lign['STATUT']== 4))
		{
		$query="SELECT SUM(POIDS_NET) AS POIDS,SUM(NB_EMB) AS SACS FROM  ticket WHERE ID_CERTIF=".$lign['ID_CERTIF'];
		$res=$bdd->query($query);
		while ($row = $res->fetch())
		{
			$poids=$row['POIDS'];
			$sacs=$row['SACS'];
		}
		$res->closeCursor();	

		}
	$poids_net.=($i?";":"").$poids;
	$nbre_sac_def.=($i?";":"").$sacs;
		
	$i++;
	}
$result->closeCursor();	

$token=array($i,$idcertif,$a_r,$disabled,$statut,$poids_net,$nbre_sac_def);

//Récupération du contenu renvoyé par le webservice
$output=Get($url_send_certif_update,$token,$pass);

if(!$output)
	{
	Loger("send_certif_update:"."Unable to reach webservice!");
	}
else
	{
		$resultat = json_decode($output);

		$statut= $resultat->{'status'};
		$message= $resultat->{'msg'};

		Loger("send_certif_update:".$statut."==>".$message);

		//S'il ya de nouvelles mises a jour
		if(!$statut)
			{
				$certif= $resultat->{'certif'};
				
				$cert="CERTIFICATS=";
				$token="";

				//Pour chaque packing_list
				for($i=0;$i<count($certif);$i++)
					{
						$cert.=($i?";":"").$certif[$i];
						$token.=($i?",":"").$certif[$i];
					}

				Loger("send_certif_update:".$cert);

				$query="UPDATE certificat SET CHANG_STAT=1 WHERE ID_PCKLIST IN(".$token.")";
				$bdd->exec($query);
			}
	}

PutFile($cntrl_certif_update,0);
}
else	
PutFile($cntrl_certif_update,GetFile($cntrl_certif_update)+1);

?>
