<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');

	$tab[0]=0;

 if( (isset($_POST['update'])) && (!empty($_POST['update'])) && ($_POST['update']==1) ){
	 if($_POST['post']==1)
	 {
		 $fonc="AGENT MATCHING";
	 }
	 if($_POST['post']==2)
	 {
		 $fonc="AGENT CONTROLE";
	 }

    $query = $bdd ->prepare(" UPDATE utilisateur SET STAT_COMPTE=:stat,PREM_CONNEXION=:prem,ID_VILLE=:vil,TYPE_COMPTE=:typ,FONCTION=:fonc WHERE ID_UTIL=:util");
	$query -> bindParam(':stat', $_POST['statu'], PDO::PARAM_INT);
	$query -> bindParam(':prem', $_POST['conne'], PDO::PARAM_INT);
	$query -> bindParam(':vil', $_POST['ville'], PDO::PARAM_INT);
	$query -> bindParam(':typ', $_POST['post'], PDO::PARAM_INT);
	$query -> bindParam(':fonc', $fonc, PDO::PARAM_INT);
	$query -> bindParam(':util', $_POST['idtutil'], PDO::PARAM_INT);
	$query -> execute();	

	$tab[0]=1;
}
	
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>