<?php
/*-----------------------------------------------------------------------------------------------*/
/*  	  Initialisation des conteurs de tickets de matcheurs et controleurs		  */
/*-----------------------------------------------------------------------------------------------*/


include_once('inc/config_client.php');

include_once('inc/logger_client.php');


Loger("init_count: INITIALISATION DES COMPTEURS DE TICKETS");

$query="UPDATE utilisateur SET COMPTE=0 WHERE TYPE_COMPTE IN(1,2)";
$bdd->exec($query);


?>
