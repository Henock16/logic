<?php

function Loger($texte)
	{

	global $log;

	if($texte!=="")
		{
		$datelog=date('d/m/Y H:i:s');

		if (file_exists($log))
			{
			$format="Ym";

			$instfich=filemtime($log);
			$datefich=date ($format, $instfich);

			if($datefich<date ($format))
				rename($log,$log.".".date ($format, $instfich));
			}

		if (!$handle = fopen($log, 'a')) 
			exit;
		
		if (fwrite($handle, "[".$datelog."]".$texte."\r\n") === FALSE) 
			exit;
			
		fclose($handle);			
		}
	}

?>
