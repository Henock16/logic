<?php
	function Journalisation($acteur,$action,$cible,$valprec,$bdd){	

		$query = $bdd -> prepare("INSERT INTO journal(ACTEUR,ACTION,CIBLE,VAL_PREC)VALUES(:act,:acti,:cible,:val)");
		$query -> bindParam(':act',$acteur, PDO::PARAM_INT);
		$query -> bindParam(':acti',$action, PDO::PARAM_INT);
		$query -> bindParam(':cible',$cible, PDO::PARAM_INT);
		$query -> bindParam(':val',$valprec, PDO::PARAM_INT);
		$query -> execute();
		$query -> closeCursor();

		return 1;
	}
?>