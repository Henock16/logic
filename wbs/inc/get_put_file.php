<?php

function GetFile($fich)
	{
	$token=0;
        if (($handle = @ fopen($fich, "r"))!==false)
	        while ((($donnees = fgets($handle, 4096)) !== false))
			$token=str_replace("\n","",$donnees);
        return $token;
	}

function PutFile($fichier,$token)
	{
	$cree=false;

	if(file_exists($fichier))
		if(!unlink($fichier))
			$cree=false;

	if ($handle = fopen($fichier, 'w')) 
		{
		if (fwrite($handle, $token) === FALSE) 
			exit;
		fclose($handle);
		$cree=true;	
		}

	return $cree;
	}




?>
