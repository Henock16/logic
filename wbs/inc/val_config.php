<?php

//Fonction qui ressort la valeur d'un parametre de configuration 
//à partir de son identifiant dans la table config
function val_config($bdd,$param)
	{
	$query="SELECT VALEUR FROM configuration WHERE ID_CONF=".$param."";
	$result=$bdd->query($query);
	$val=0;
	while ($lign = $result->fetch()) 
		$val=$lign['VALEUR'];
	$result->closeCursor();	
	return $val;
	}

function put_config($bdd,$param,$value)
	{
	$query="UPDATE configuration SET VALEUR=".$value." WHERE ID_CONF=".$param;
	$bdd->exec($query);
	}

?>
