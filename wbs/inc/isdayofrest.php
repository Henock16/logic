<?php

function isdayofrest($bdd,$date)
	{
	$year = substr($date,0,4);
	    
	$easterDate = easter_date($year);
	$easterDay = date('j', $easterDate);
	$easterMonth = date('n', $easterDate);
	$easterYear = date('Y', $easterDate);
	    
	$holidays = array(
	mktime(0, 0, 0, 1, 1, $year),// 1er janvier
	mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear),// Lundi de paques
	mktime(0, 0, 0, 5, 1, $year),// Fete du travail
	//mktime(0, 0, 0, 11, 11, $year),// Nuit de l'ascencion
	mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),// Ascension
	mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), // Pentecote
	//mktime(0, 0, 0, 11, 11, $year),// Nuit du destin
	//mktime(0, 0, 0, 5, 8, $year),// Ramadan
	mktime(0, 0, 0, 8, 7, $year),// Fete nationale
	mktime(0, 0, 0, 8, 15, $year),// Assomption
	//mktime(0, 0, 0, 11, 11, $year),// Tabaski
	mktime(0, 0, 0, 11, 1, $year),// Toussaint
	//mktime(0, 0, 0, 11, 15, $year),// Journée de la paix
	//mktime(0, 0, 0, 11, 11, $year),// Mahouloud
	mktime(0, 0, 0, 12, 25, $year),// Noel
	);
	    
	sort($holidays);
	    
	$ferie=0;
	$i=0;
	while (!$ferie && $i<count($holidays))
		{
		$jour=$holidays[$i];
		if(date('Y', $jour)."-".date('m', $jour)."-".date('d', $jour)==$date)
			$ferie=1;
		$i++;
		}

	if(!$ferie)
		{
		$query="SELECT IDENTIFIANT FROM joursferies WHERE DATE='".$date."'";
		$res=$bdd->query($query);
		while ($lign = $res->fetch())
			$ferie=$lign['IDENTIFIANT'];
		$res->closeCursor();	
		}

	return $ferie;			
	}

?>
