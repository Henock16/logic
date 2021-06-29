<?php

include_once('inc/config_client.php');

include_once('inc/get_put_file.php');

include_once('inc/logger_client.php');

function recoiftp($secured,$ftp_server,$ftp_port,$ftp_user,$ftp_pass,$ftp_rep,$fichier,$local_rep,$filename)
	{
	$erreur=array("","");
	$depotftp=false;

	@ $conn_id=(($secured)?ftp_ssl_connect($ftp_server):ftp_connect($ftp_server,$ftp_port));

	if($conn_id)
		{
		if(ftp_login($conn_id,$ftp_user,$ftp_pass))
			{
			ftp_pasv($conn_id, true);

			if(@ftp_get($conn_id,$local_rep."OK",$ftp_rep."LOGIC",FTP_BINARY))
				{
				Loger("resynchro: "."Le fichier '"."LOGIC"."' a été téléchargé ".(($ftp_rep=='.')?"":"depuis ".$ftp_rep." ")."par FTP sur ".$ftp_user."@".$ftp_server." ");
				
				if(@ftp_get($conn_id,$local_rep.$filename,$ftp_rep.$fichier,FTP_BINARY))
					{
					Loger("resynchro: "."Le fichier '".$fichier."' a été téléchargé ".(($ftp_rep=='.')?"":"depuis ".$ftp_rep." ")."par FTP sur ".$ftp_user."@".$ftp_server." ");
					
					if(@!ftp_delete($conn_id,$ftp_rep."LOGIC"))
						$erreur=array("ECHEC de suppression du fichier '"."LOGIC"."' par FTP sur le serveur ".$ftp_server."","FAILURE to delete '"."LOGIC"."' file on FTP server ".$ftp_server." ");

					$depotftp=true;
					}
				else
					$erreur=array("ECHEC de téléchargement du fichier '".$fichier."' par FTP sur le serveur ".$ftp_server."","FAILURE to download '".$fichier."' file on FTP server ".$ftp_server." ");					
				}

			}
		else
			$erreur=array("ECHEC d'authentification FTP sur le serveur ".$ftp_server."","FTP authenticating to server ".$ftp_server." Failure");

		ftp_close($conn_id);
		}
	else
		$erreur=array("ECHEC de connexion FTP au serveur ".$ftp_server."","Failure connecting to FTP server ".$ftp_server."");

	if(!$depotftp && $erreur[0])
		Loger("resynchro: ".$erreur[0]);

	return $depotftp;
	}

if(!file_exists($cntrl_resynchro ) || !GetFile($cntrl_resynchro)|| GetFile($cntrl_resynchro)>=3)
	{
	PutFile($cntrl_resynchro,1);

	sleep($delay_resynchro);

	
	
	
	if(file_exists($path."resynchro.zip"))
		if(!unlink($path."resynchro.zip"))
			Loger("resynchro: "."Impossible de supprimer le fichier resynchro.zip");

	if(file_exists($path."OK"))
		if(!unlink($path."OK"))
			Loger("resynchro: "."Impossible de supprimer le fichier OK");

		
	if(recoiftp(0,$ip_resynchro,"21",$user_resynchro,$pass_resynchro,$rep_resynchro,"resynchro.zip",$path,"resynchro.zip"))
	{
		
		shell_exec('C:\"Program Files"\WinRAR\WinRar x -ibck '.$path."resynchro.zip resynchro.sql ".$path." ");

		if(file_exists($path."resynchro.zip"))
			if(!unlink($path."resynchro.zip"))
				Loger("resynchro: "."Impossible de supprimer le fichier resynchro.zip");


		shell_exec("C:\wamp\bin\mysql\mysql5.6.17\bin\mysql -h ".$serv." -u ".$user." ".($pswd?"-p".$pswd:"")." -e \"stop slave;\"" );
		
		shell_exec("C:\wamp\bin\mysql\mysql5.6.17\bin\mysql -h ".$serv." -u ".$user." ".($pswd?"-p".$pswd:"")." <".$path."resynchro.sql");

		if(file_exists($path."resynchro.sql"))
			if(!unlink($path."resynchro.sql"))
				Loger("resynchro: "."Impossible de supprimer le fichier resynchro.sql");
		
		shell_exec("C:\wamp\bin\mysql\mysql5.6.17\bin\mysql -h ".$serv." -u ".$user." ".($pswd?"-p".$pswd:"")." -e \"start slave;\"" );

		if(file_exists($path."OK"))
			if(!unlink($path."OK"))
				Loger("resynchro: "."Impossible de supprimer le fichier OK");
		
	}
								
	PutFile($cntrl_resynchro,0);
	}
else	
	PutFile($cntrl_resynchro,GetFile($cntrl_resynchro)+1);

?>
