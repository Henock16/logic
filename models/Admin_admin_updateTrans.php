<?php
	include_once('../config/Connexion.php');
	
	if( (isset($_POST['upidtrans'])) && (!empty($_POST['upidtrans'])) ){
		
		$libel = strtoupper($_POST['trans']);
		
		$query = $bdd ->prepare("SELECT COUNT(ID_TRANSIT) AS NB FROM transitaire WHERE LIBELLE=:libel");
		$query -> bindParam(':libel', $libel, PDO::PARAM_STR);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){
			
			$tab[0] = 0;
		}
		else{
			
			$tab[0] = 1;
			$query1 = $bdd ->prepare("UPDATE transitaire SET LIBELLE =:lib,CHANG_STAT = 0 WHERE ID_TRANSIT=:idtrans");
			$query1 -> bindParam(':lib', $_POST['trans'], PDO::PARAM_INT);
			$query1 -> bindParam(':idtrans', $_POST['upidtrans'], PDO::PARAM_INT);
			$query1 -> execute();
			$query1 -> closeCursor();			
		}
	}

	if( (isset($_POST['idtrans'])) && (!empty($_POST['idtrans'])) ){

		$query = $bdd ->prepare("SELECT DISABLED FROM transitaire WHERE ID_TRANSIT=:trans");
		$query -> bindParam(':trans', $_POST['idtrans'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['DISABLED'] == 0){
			
			$tab[0] = 2;
			
			$query = $bdd ->prepare(" UPDATE transitaire SET DISABLED = 1,CHANG_STAT=0 WHERE ID_TRANSIT=:trans");
			$query -> bindParam(':trans', $_POST['idtrans'], PDO::PARAM_INT);
			$query -> execute();
		}
		elseif($data['DISABLED'] == 1){
			
			$tab[0] = 3;
			
			$query = $bdd ->prepare(" UPDATE transitaire SET DISABLED = 0,CHANG_STAT=0 WHERE ID_TRANSIT=:trans");
			$query -> bindParam(':trans', $_POST['idtrans'], PDO::PARAM_INT);
			$query -> execute();
		}
	}
	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>