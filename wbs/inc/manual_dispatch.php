<?php
include_once('inc/config_client.php');

$config=array(,,,);

for($k=0;$k<count($config);$k++)
	$bdd->exec("UPDATE configuration SET VALEUR='' WHERE ID_CONF=".$config[$k]."");

?>
