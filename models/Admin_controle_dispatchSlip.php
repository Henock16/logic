<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	include_once('../functions/Journalisation_function.php');
	
	$tab[0] = 0;

	if((isset($_POST['idcont']))&&(!empty($_POST['idcont']))){

		$tab[0] = 1;
		$compte = 0;

		$query = $bdd -> prepare("SELECT ID_CERTIF FROM certif_bord WHERE ID_BORD=:bd");
		$query -> bindParam(':bd',$_POST['idcont'], PDO::PARAM_INT);
		$query -> execute();
		
		while($data = $query -> fetch()){

			$query1 = $bdd -> prepare("SELECT ID_USER_COUR FROM certificat WHERE ID_CERTIF =:certif");
			$query1 -> bindParam(':certif',$data['ID_CERTIF'], PDO::PARAM_INT);
			$query1 -> execute();
			$data1 = $query1 -> fetch();

			$query2 = $bdd -> prepare("UPDATE certificat SET STADE = 2 ,ID_USER_PREC =:userp , ID_USER_COUR=:user , CHANG_STAT = 0 WHERE ID_CERTIF =:certif");
			$query2 -> bindParam(':userp',$data1['ID_USER_COUR'], PDO::PARAM_INT);
			$query2 -> bindParam(':user',$_POST['usercont'], PDO::PARAM_INT);
			$query2 -> bindParam(':certif',$data['ID_CERTIF'], PDO::PARAM_INT);
			$query2 -> execute();

			$query3 = $bdd -> prepare("SELECT COUNT(ID_TICKET) AS NB FROM ticket WHERE ID_CERTIF =:certif");
			$query3 -> bindParam(':certif',$data['ID_CERTIF'], PDO::PARAM_INT);
			$query3 -> execute();
			$data3 = $query3 -> fetch();
			
			$compte += $data3['NB'];
		}
		
		$query4 = $bdd -> prepare("SELECT NOM, PRENOM, COMPTE FROM utilisateur WHERE ID_UTIL =:user");
		$query4 -> bindParam(':user',$_POST['usercont'], PDO::PARAM_INT);
		$query4 -> execute();
		$data4 = $query4 -> fetch();
		
		$compte += $data4['COMPTE'];

		$query5 = $bdd -> prepare("UPDATE utilisateur SET COMPTE =:ct WHERE ID_UTIL =:user");
		$query5 -> bindParam(':ct', $compte, PDO::PARAM_INT);
		$query5 -> bindParam(':user', $_POST['usercont'], PDO::PARAM_INT);
		$query5 -> execute();

		Journalisation($_SESSION['ID_UTIL'],2,$_POST['idcont'],$_POST['usercont'],$bdd);

		$tab[1] = $data4['NOM'].' '.$data4['PRENOM'];
	}

	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>