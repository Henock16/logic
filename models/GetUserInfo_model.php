<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

	$i = 0;

	$tab[0]=0;

 if((isset($_POST['idutil']))&&(!empty($_POST['idutil']))){

 	$tab[0]=1;
 	$i++;

	$query = $bdd ->prepare("SELECT ID_UTIL, LOGIN, STAT_COMPTE, PREM_CONNEXION, NOM, PRENOM, TYPE_COMPTE, MATRICULE, ID_VILLE, CONTACT, DATE_NAISSANCE, EMAIL, AVATAR FROM utilisateur WHERE ID_UTIL=:util");
	$query -> bindParam(':util', $_POST['idutil'], PDO::PARAM_INT);
	$query -> execute();
    	
	
	While($data = $query -> fetch()){
		
		$tab[$i] = $data['ID_UTIL'];
		$i++;
		$tab[$i] = $data['LOGIN'];
		$i++;
		$tab[$i] = $data['STAT_COMPTE'];
		$i++;
		$tab[$i] = $data['PREM_CONNEXION'];
		$i++;
		$tab[$i] = $data['NOM'];
		$i++;
		$tab[$i] = $data['PRENOM'];
		$i++;
		$tab[$i] = $data['TYPE_COMPTE'];
		$i++;
		$tab[$i] = $data['MATRICULE'];
		$i++;
		$tab[$i] = $data['ID_VILLE'];
		$i++;
		$tab[$i] = $data['CONTACT'];
		$i++;
		$tab[$i] = $data['DATE_NAISSANCE'];
		$i++;
		$tab[$i] = $data['EMAIL'];
		$i++;
		$tab[$i] = $data['AVATAR'];
		$i++;

	}
	$query -> closeCursor();

	$query1 = $bdd -> prepare("SELECT ID_VILLE, LIBELLE FROM ville");
	$query1 -> execute();
	$rows = $query1 -> rowCount();

	$tab[$i] = $rows;
	$i++;
	
	while($data1 = $query1->fetch()){

		$tab[$i] = $data1['ID_VILLE'];
		$i++;
		$tab[$i] = $data1['LIBELLE'];
		$i++;
	}
    $query1->closeCursor();

    $query2 = $bdd -> prepare("SELECT IDENTIFIANT ,LIBELLE FROM poste_travail");
	$query2 -> execute();
	$rows1 = $query2 -> rowCount();

	$tab[$i] = $rows1;
	$i++;
	
	while($data2 = $query2->fetch()){

		$tab[$i] = $data2['IDENTIFIANT'];
		$i++;
		$tab[$i] = $data2['LIBELLE'];
		$i++;
	}
    $query2->closeCursor();

    //Liste des differents statut du compte

    $tab[$i] = 2;
	$i++;

	$tab[$i] = 0;
	$i++;
	$tab[$i] = "Actif";
	$i++;
	$tab[$i] = 1;
	$i++;
	$tab[$i] = "Inactif";
	$i++;

	//Liste des états de connexion du compte

    $tab[$i] = 3;
	$i++;

	$tab[$i] = 0;
	$i++;
	$tab[$i] = "Jamais Connecté";
	$i++;
	$tab[$i] = 1;
	$i++;
	$tab[$i] = "Déjà Connecté";
	$i++;
	$tab[$i] = 2;
	$i++;
	$tab[$i] = "A Réinitialisé";
	$i++;
	
}
	
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>