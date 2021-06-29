<?php
/*-----------------------------------------------------------------------------------------------*/
/*  Fonction d'affectation du certificat au matcheur: 					  */
/*  	- Changement de statut du certificat						 	  */
/*  	- Journalisation de l'affectation								  */
/*-----------------------------------------------------------------------------------------------*/

include_once('journalisation.php');

//Fonction qui affecte un certificat à un agent du matching et journalise cette affectation
function affect_matcher($bdd,$acteur,$id_certif,$id_user)
	{
	//MAJ du stade et du statut du certificat et active la retransmission vers ipage
	$query="UPDATE certificat SET CHANG_STAT=0,STATUT=1,STADE=1,ID_USER_COUR=".$id_user." WHERE ID_CERTIF =".$id_certif."";
	$bdd->exec($query);

	//Nombre de tickets
	$query="SELECT ID_TICKET FROM ticket WHERE ID_CERTIF=".$id_certif." ";
	$res=$bdd->query($query);
	$ticket=0;
	while ($data = $res->fetch()) 
		$ticket++;
	$res->closeCursor();	

	//MAJ du nombre de tickets affectés au matcheur pour la journée
	$query="UPDATE utilisateur SET COMPTE=COMPTE+".$ticket." WHERE ID_UTIL =".$id_user."";
	$bdd->exec($query);


	//Journalisation de l'affectation 
	journal($bdd,$acteur,1,$id_certif,$id_user);

	return 1;
	}

?>
