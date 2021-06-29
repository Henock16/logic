<?php

include_once('inc/config_client.php');

include_once('inc/get_put_file.php');

include_once('inc/logger_client.php');

function Post($url,$table,$passwd)
        {
	$content = array('table' => $table, 'passwd' => $passwd);
        $requete = array(  'http' =>   array( 'method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded',  'content' => http_build_query($content) ) );
        $context = stream_context_create($requete);
        $content = @file_get_contents($url, false, $context);

        return $content;
        }

if(!file_exists($cntrl_send_param_table) || !GetFile($cntrl_send_param_table)|| GetFile($cntrl_send_param_table)>=3)
{
PutFile($cntrl_send_param_table,1);

sleep($delay_send_param_table);

$tbl=array('campagne','recolte','destination','demandeur','egreneur','exportateur','produit','type_produit','transitaire','agrement','config_tare');
$chp=array(array('ID_CAMP','LIBELLE','DEBUT','FIN','PRODUIT','STATUT'),
		   array('ID_REC','LIBELLE','DEBUT','FIN','PRODUIT','STATUT'),
		   array('ID_DEST','STATUT','PORT','PAYS'),
		   array('ID_DEMAND','DERNIERE_ACTION','LOGIN','MOT_PASSE','STATUT_COMPTE','FIRST_CONNECTION','STRUCTURE','SIGLE','NOM_RESPO','FONCTION_RESPO','CONTACT_RESPO','NUM_CC','ADRESSE_GEO','TYPE_OPERATEUR','VILLE','LOGO'),
		   array('ID_EGRE','STATUT','LIBELLE'),
		   array('ID_EXP','LIBELLE','PRODUIT','STATUT','ID_USER'),
		   array('ID_PROD','LIBELLE','DISABLED'),
		   array('ID_TYPPROD','LIBELLE','PRODUIT','STATUT'),
		   array('ID_TRANSIT','DISABLED','LIBELLE'),
		   array('ID_AGRE','CODE','ID_EXP','ID_CAMP','STATUT'),
		   array('IDENTIFIANT','VALEUR','PRODUIT','STATUT','DATE_CREATION'));

$nbr=0;
$table=array();

for($j=0;$j<count($tbl);$j++) // pour chaque table parametre
	{
	$ligne=array();
	$query="SELECT * FROM ".$tbl[$j]." WHERE CHANG_STAT=0 OR SENT=0 ORDER BY ".$chp[$j][0]." ";
	$result=$bdd->query($query);
	$i=0;

//	echo $tbl[$j]."\r\n";

	while ($lign = $result->fetch()) //pour toutes les lignes modifiées
		if($i<$max_lign_send_param_table)
			{
				$champ=array();
				$champ[]=(($lign["SENT"]==0)?1:(($lign["CHANG_STAT"]==0)?2:0));
				
//				echo (($lign["SENT"]==0)?"INSERTION=":(($lign["CHANG_STAT"]==0)?"MODIFICATION=":0));
				
				for($k=0;$k<count($chp[$j]);$k++)
				{
					$champ[]=(($lign[$chp[$j][$k]]==null)?"":$lign[$chp[$j][$k]]);
//					echo $lign[$chp[$j][$k]].(($k==count($chp[$j])-1)?"\r\n":";");
				}
				$ligne[]=$champ;	
				$i++;
			}
	$result->closeCursor();	
	
//	echo"\r\n";


	$table[]=($i?$ligne:0);
	$nbr+=$i;
	}	     

//Récupération du contenu renvoyé par le webservice
$output=Post($url_send_param_table,($nbr?$table:"0"),$pass);

if(!$output)
	{
	Loger("send_param_table:"."Unable to reach webservice!");
	}
else
	{

		//var_dump($output);

		$resultat = json_decode($output);

		$statut= $resultat->{'status'};
		$message= $resultat->{'msg'};

		Loger("send_param_table:".$statut."==>".$message);

		//S'il ya de nouvelles mises a jour
		if($statut===0)
			{
				$id= $resultat->{'ids'};

				for($j=0;$j<count($id);$j++) // pour chaque table parametre
				if($id[$j]) // si la liste des id retournés n'est pas vide
					{
					$query="UPDATE ".$tbl[$j]." SET CHANG_STAT=1,SENT=1 WHERE ".$chp[$j][0]." IN(".$id[$j].")";
					$bdd->exec($query);

					Loger("send_param_table:"."	".$tbl[$j]."=".$id[$j]);

					for($i=0;$i<count($table[$j]);$i++) // pour chaque ligne
						{
						$ln=(($table[$j][$i][0]==1)?"INSERTION":(($table[$j][$i][0]==2)?"MODIFICATION":""))." ".$tbl[$j]."[".$i."]=";
						for($k=1;$k<count($table[$j][$i]);$k++)							
							$ln.=(($k>1)?";":"[").$table[$j][$i][$k].(($k==count($table[$j][$i])-1)?"]":"");
						Loger("send_param_table:"."		".$ln);
						}

					}

			}


	}
PutFile($cntrl_send_param_table,0);
}
else	
PutFile($cntrl_send_param_table,GetFile($cntrl_send_param_table)+1);

?>
