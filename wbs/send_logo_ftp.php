<?php

include_once('inc/config_client.php');

include_once('inc/get_put_file.php');

include_once('inc/logger_client.php');

function envoiftp($secured,$ftp_server,$ftp_port,$ftp_user,$ftp_pass,$ftp_rep,$fichier,$filename)
	{
	$erreur=array("","");
	$depotftp=false;

	if($fichier)
		{
		if (file_exists($filename)) 
			{
			if (filesize($filename)) 
				{
				@ $conn_id=(($secured)?ftp_ssl_connect($ftp_server):ftp_connect($ftp_server,$ftp_port));

				if($conn_id)
					{
					if(ftp_login($conn_id,$ftp_user,$ftp_pass))
						{
						ftp_pasv($conn_id, true);

						if(ftp_size($conn_id,$fichier)>-1)
							ftp_delete($conn_id,$fichier);						
						$i=1;
						while ($i<=3 && !$depotftp)
							if(!ftp_put($conn_id,$fichier,$filename,FTP_BINARY))
								$i++;
							else
								if(!ftp_rename($conn_id,$fichier,$ftp_rep."/".$fichier))
									$i++;
								else
									{
									Loger("send_logo_ftp: "."Le fichier '".$fichier."' a été déposé ".(($ftp_rep=='.')?"":"dans ".$ftp_rep." ")."par FTP sur ".$ftp_user."@".$ftp_server." en ".$i." tentative".(($i==1)?"":"s").".");
									$depotftp=true;
									}

						if(!$depotftp)
							$erreur=array("ECHEC de depot du fichier '".$fichier."' par FTP sur ".$ftp_user."@".$ftp_server."","Failure putting file '".$fichier."' by FTP on ".$ftp_user."@".$ftp_server."");
						}
					else
						$erreur=array("ECHEC d'authentification FTP sur le serveur ".$ftp_server."","FTP authenticating to server ".$ftp_server." Failure");

					ftp_close($conn_id);
					}
				else
					$erreur=array("ECHEC de connexion FTP au serveur ".$ftp_server."","Failure connecting to FTP server ".$ftp_server."");
				}
			else
				$erreur=array("Le fichier ".$fichier." est VIDE","The file ".$fichier." is EMPTY");
			}
		else
			$erreur=array("Le fichier ".$filename." n'existe pas","The file ".$filename." does not exist");
		}
	else
		$erreur=array("Le fichier à envoyer par FTP ne porte pas de nom","The file to send by FTP does not have any name");

	if(!$depotftp)
		Loger("send_logo_ftp: ".$erreur[0]);

	return $depotftp;
	}

if(!file_exists($cntrl_send_logo ) || !GetFile($cntrl_send_logo)|| GetFile($cntrl_send_logo)>=3)
	{
	PutFile($cntrl_send_logo,1);

	sleep($delay_send_logo_ftp);

	if($dh = opendir($rep_logo))
		{
		while ((false !== ($filename = readdir($dh))))
			{
			if ($filename != "." && $filename != ".." && substr($filename,-4) == ".png" )
				if(file_exists($rep_logo.$filename))
					if(envoiftp(0,$ip_send_send_logo_ftp,"21",$user_send_send_logo_ftp,$pass_send_send_logo_ftp,$rep_send_logo_ftp,$filename,$rep_logo.$filename))
						if(!unlink($rep_logo.$filename))
							Loger("send_logo_ftp: "."Impossible de supprimer le fichier ".$rep_logo.$filename."");
			}
		closedir($dh);	
		}
		else
			Loger("send_logo_ftp: "."Impossible d'ouvrir le repertoire ".$rep_logo."");

	PutFile($cntrl_send_logo,0);
	}
else	
	PutFile($cntrl_send_logo,GetFile($cntrl_send_logo)+1);

?>
