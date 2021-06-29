<?php

include_once('inc/config_client.php');

include_once('inc/get_put_file.php');

include_once('inc/logger_client.php');

function Get($url,$token,$pass)
        {
	$content="";
	for($i=0;$i<count($token);$i++)
		$content.="token".($i+1)."=".$token[$i]."&";

//$content="token4"."=".$token[3]."&";

	$link=$url."?".$content."pass=".$pass;

       @ $content = file_get_contents($link);

        return $content;
        }

function GetMFile($nb_tbl,$fich)
	{
	$token=array();
  	$i=0;	
	$handle = @ fopen($fich, "r");
        while ((($donnees = @fgets($handle, 4096)) !== false) || $i<$nb_tbl)
		{
		$token[]=str_replace("\n","",$donnees);
		$i++;
		}

        return $token;
	}

function PutMFile($fichier,$token)
	{
	$cree=false;

	if(file_exists($fichier))
		if(!unlink($fichier))
			$cree=false;

	if ($handle = fopen($fichier, 'w')) 
		{
		$content="";
		for($i=0;$i<count($token);$i++)
			$content.=$token[$i].(($i==count($token)-1)?"":"\n");

		if (fwrite($handle, $content) === FALSE) 
			exit;
		fclose($handle);
		$cree=true;	
		}

	return $cree;
	}

if(!file_exists($cntrl_get_param_table) || !GetFile($cntrl_get_param_table)|| GetFile($cntrl_get_param_table)>=3)
{
PutFile($cntrl_get_param_table,1);

sleep($delay_get_param_table);

$tbl=array('demandeur');
$chp=array(array('ID_DEMAND','DERNIERE_ACTION','LOGIN','MOT_PASSE','STATUT_COMPTE','FIRST_CONNECTION','STRUCTURE','SIGLE','NOM_RESPO','FONCTION_RESPO','CONTACT_RESPO','NUM_CC','ADRESSE_GEO','TYPE_OPERATEUR','VILLE','LOGO'));

/* TABles a ramener depuis ipage
$tbl=array('campagne','recolte','destination','demandeur','egreneur','exportateur','produit','type_produit','transitaire','agrement');
$chp=array(array('ID_CAMP','LIBELLE','DEBUT','FIN','PRODUIT','STATUT'),
		   array('ID_REC','LIBELLE','DEBUT','FIN','PRODUIT','STATUT'),
		   array('ID_DEST','STATUT','PORT','PAYS'), array('ID_DEMAND','DERNIERE_ACTION','LOGIN','MOT_PASSE','STATUT_COMPTE','FIRST_CONNECTION','STRUCTURE','SIGLE','NOM_RESPO','FONCTION_RESPO','CONTACT_RESPO','NUM_CC','ADRESSE_GEO','TYPE_OPERATEUR','VILLE','LOGO'),
		   array('ID_EGRE','STATUT','LIBELLE'),
		   array('ID_EXP','LIBELLE','PRODUIT','STATUT','ID_USER'),
		   array('ID_PROD','LIBELLE','DISABLED'),
		   array('ID_TYPPROD','LIBELLE','PRODUIT'),
		   array('ID_TRANSIT','DISABLED','LIBELLE'),
		   array('ID_AGRE','CODE','ID_EXP','ID_CAMP'));
*/

//Chargement des derniers identifiants téléchargés ou modifiés
$token=GetMFile(count($tbl),$last_token_get_param_table);						     

//Récupération du contenu renvoyé par le webservice
$output=Get($url_get_param_table,$token,$pass);

if(!$output)
	Loger("get_param_tables:"."Unable to reach webservice!");
else
	{
	$resultat = json_decode($output);

	$statut= $resultat->{'status'};
	$message= $resultat->{'msg'};

	Loger("get_param_tables:".$statut."==>".$message);

	if($statut<2)
		{
		$table= $resultat->{'tables'};

		$new=0; //compteur de nouvelle entree ou modification
		
		for($j=0;$j<count($table);$j++) //FIN pour chaque table
			{
			$status= $table[$j]->{'status'};
			$message= $table[$j]->{'msg'};

			if($status!=1)
				Loger("get_param_tables:"."	".$tbl[$j]."=".$status."==>".$message);

			if($status)
				{
				if($status==1)
					$token[$j]="";
				}
			else
				{
				$new++;

				$lines= $table[$j]->{'lines'};
				
				$lastoken="";

				for($i=0;$i<count($lines);$i++)  //Pour  chaque ligne
					{
					$nb_chmp=count($lines[$i])-1;

					$ln=(($lines[$i][0]==1)?"INSERTION":(($lines[$i][0]==2)?"MODIFICATION":""))." ".$tbl[$j]."[".$i."]=";
					for($k=1;$k<=$nb_chmp;$k++)							
						$ln.=(($k>1)?";":"[").$lines[$i][$k].(($k==$nb_chmp)?"]":"");
					Loger("get_param_tables:"."	".$ln);

					$req="";

 				    $ex=0;
					//tester l'existence
			    	$query="SELECT * FROM ".$tbl[$j]." WHERE ".$chp[$j][0]."=".$lines[$i][1];
			    	$result=$bdd->query($query);
			    	while ($lign = $result->fetch()) //pour toutes les lignes modifiées
					    $ex++;								
			    	$result->closeCursor();	

					if($lines[$i][0]==1 && !$ex)//INSERTION de la ligne de la table parametre
						{
						for($k=0;$k<$nb_chmp;$k++)							
							$req.=(($k)?",":"INSERT INTO ".$tbl[$j]."(SENT,CHANG_STAT,").$chp[$j][$k];
						for($k=1;$k<=$nb_chmp;$k++)							
							$req.=(($k>1)?",":") VALUES(1,1,")."'".str_replace("'","''",$lines[$i][$k])."'".(($k==$nb_chmp)?")":"");
						}
					if($lines[$i][0]==2 && $ex)//MAJ de la ligne de la table parametre
						{
						for($k=1;$k<$nb_chmp;$k++)					
							$req.=(($k>1)?",":"UPDATE ".$tbl[$j]." SET ").$chp[$j][$k]."='".str_replace("'","''",$lines[$i][$k+1])."'";
						$req.=" WHERE ".$chp[$j][0]." =".$lines[$i][1]." ";
						}

					if($req)	
						$bdd->exec($req);

					$lastoken.=($i?",":"").$lines[$i][1];				
					}
				//FIN Pour  chaque ligne

				Loger("get_param_tables:"."	"."	".($lastoken?"IDS TRAITES=".$lastoken:""));
				$token[$j]=$lastoken;
				}
				//FIN si nouvelle entree
			}
			//FIN pour chaque table

		//S'il y a une nouvelle entree ou modif
		//if($new)
			PutMFile($last_token_get_param_table,$token);
		}
	}
PutFile($cntrl_get_param_table,0);
}
else	
PutFile($cntrl_get_param_table,GetFile($cntrl_get_param_table)+1);

?>
