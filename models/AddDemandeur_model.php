<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	
	$string=$_POST['struct'];
	$int_struct=strlen($string);
	if($int_struct<=9)
	{
		$struct=strtolower($string);
	}
	else if($int_struct>9){

		$int=($int_struct-9)*-1;
		if($int==0)
		{
			$struct=strtolower($string);
		}
		else{
		$struct=strtolower(substr($string, 0, $int));
		}
	}
	$bool=true;
	$i=-1;
	$nb=0;
	$query = $bdd ->query("SELECT LOGIN FROM demandeur ORDER BY DATE_CREATION DESC LIMIT 1");
	$data = $query -> fetch();
	$string2=$data['LOGIN'];

	while($bool==true){
		$rest=substr($string2,$i);
		if(is_numeric($rest))
		{
			$i-=1;
		}
		else{
			$rest=substr($string2,$i+1);
			$bool=false;

		}

	}

	$num=($rest+1);
	$nb_int=strlen($num);
	if($nb_int==1){
		$login=$struct.'ex00'.$num;
	}
	if($nb_int==2){
		$login=$struct.'ex0'.$num;
	}
	if($nb_int>=3){
		$login=$struct.'ex'.$num;
	}
	$structure=strtoupper($_POST['struct']);
 	$query1 = $bdd ->prepare("INSERT INTO demandeur (LOGIN,STRUCTURE,DATE_CREATION) VALUES (:log,:str,NOW())");
	$query1 -> bindParam(':log',$login, PDO::PARAM_INT);
	$query1 -> bindParam(':str',$structure, PDO::PARAM_INT);
	$query1 -> execute();
	$query1 -> closeCursor();
	$tab[0]=$login;
	$tab[1]=$structure;


	if( (isset($_POST['idexp'])) && (!empty($_POST['idexp']))){

	$query2 = $bdd ->prepare("SELECT ID_DEMAND FROM demandeur WHERE LOGIN=:log ");
	$query2-> bindParam(':log',$login, PDO::PARAM_INT);
	$query2 -> execute();
	$data2 = $query2 -> fetch();


	$query3 = $bdd -> prepare("UPDATE exportateur SET ID_USER=:iduser WHERE ID_EXP=:id");
	$query3-> bindParam(':iduser', $data2['ID_DEMAND'], PDO::PARAM_INT);
	$query3-> bindParam(':id', $_POST['idexp'], PDO::PARAM_INT);
	$query3 -> execute();
	$query3 -> closeCursor();

	$query2 -> closeCursor();

	}
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);

?>