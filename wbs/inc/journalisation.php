<?php

///journalisation
function journal($bdd,$acteur,$action,$cible,$val_prec)
	{
		//Journalisation de l'affectation 
		$query="INSERT INTO journal (ACTEUR,ACTION,CIBLE,VAL_PREC) VALUES(".$acteur.",".$action.",".$cible.",'".$val_prec."')";
		$bdd->exec($query);

		return 1;
	}


?>
